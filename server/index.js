require("dotenv").config();
const express = require("express");
const mongoose = require("mongoose");
const cors = require("cors");
const cookieParser = require("cookie-parser");
const jwt = require("jsonwebtoken");
const bcrypt = require("bcryptjs");
const nodemailer = require("nodemailer");

// Import Models
const User = require("./models/User");
const News = require("./models/News");

const app = express();
const PORT = process.env.PORT || 5000;
const SECRET_KEY = process.env.JWT_SECRET || "monster_adventure_secret_key";

// --- 1. CONFIGURATION ---

// Middleware
app.use(express.json());
app.use(cookieParser());
app.use(
  cors({
    origin: ["http://localhost:5173", "http://127.0.0.1:5173", "http://192.168.18.21:5173"], // Allow Frontend
    credentials: true, // Allow cookies
  })
);

// Database Connection
mongoose
  .connect(
    process.env.MONGO_URI || "mongodb://127.0.0.1:27017/Refize-LandingPage"
  )
  .then(() => console.log("✅ MongoDB Connected to Refize-LandingPage"))
  .catch((err) => console.error("❌ MongoDB Error:", err));

// Email Transporter (Nodemailer)
const transporter = nodemailer.createTransport({
  service: "gmail",
  auth: {
    // 👇 CHANGE THESE TWO LINES 👇
    user: "predator7193@gmail.com",
    pass: "wgoq ehkn lwfc bagm", // Get this from Google Account -> Security -> App Passwords
  },
});

// --- 2. AUTHENTICATION ROUTES ---

// REGISTER
app.post("/api/auth/register", async (req, res) => {
  try {
    const { username, email, password } = req.body;

    // Check if user exists
    const existingUser = await User.findOne({ email });
    if (existingUser)
      return res.status(400).json({ message: "Email already exists" });

    // Hash Password
    const salt = await bcrypt.genSalt(10);
    const hashedPassword = await bcrypt.hash(password, salt);

    // Create User
    const newUser = await User.create({
      username,
      email,
      password: hashedPassword,
      role: "user", // Default role
    });

    // SEND WELCOME EMAIL
    try {
      await transporter.sendMail({
        from: '"Monster Adventure" <no-reply@game.com>',
        to: email,
        subject: "Welcome, Hero!",
        html: `
          <div style="font-family: Arial; color: #333; padding: 20px;">
            <h1 style="color: #00d2a4;">Welcome to the World, ${username}!</h1>
            <p>Your journey from Egg to Elder has begun.</p>
            <p>We are thrilled to have you join our beta test.</p>
            <br/>
            <a href="http://localhost:5173" style="background: #00d2a4; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Start Playing</a>
          </div>
        `,
      });
      console.log(`📧 Email sent to ${email}`);
    } catch (emailErr) {
      console.error("⚠️ Email failed to send:", emailErr.message);
    }

    res.status(201).json({ message: "User created successfully" });
  } catch (err) {
    res.status(500).json({ message: "Server Error", error: err.message });
  }
});

// LOGIN
app.post("/api/auth/login", async (req, res) => {
  try {
    const { email, password } = req.body;

    // Check User
    const user = await User.findOne({ email });
    if (!user) return res.status(400).json({ message: "User not found" });

    // Check Password
    const isMatch = await bcrypt.compare(password, user.password);
    if (!isMatch)
      return res.status(400).json({ message: "Invalid credentials" });

    // Generate Token
    const token = jwt.sign({ id: user._id, role: user.role }, SECRET_KEY, {
      expiresIn: "7d",
    });

    // Send Cookie
    res
      .cookie("token", token, {
        httpOnly: true,
        secure: false, // Set to true if using https
        maxAge: 7 * 24 * 60 * 60 * 1000, // 7 days
      })
      .json({
        user: {
          id: user._id,
          username: user.username,
          email: user.email,
          role: user.role,
        },
      });
  } catch (err) {
    res.status(500).json({ message: "Server Error" });
  }
});

// LOGOUT
app.post("/api/auth/logout", (req, res) => {
  res.clearCookie("token").json({ message: "Logged out" });
});

// GET CURRENT USER (ME)
app.get("/api/auth/me", async (req, res) => {
  try {
    const token = req.cookies.token;
    if (!token) return res.status(401).json({ message: "Not authenticated" });

    const decoded = jwt.verify(token, SECRET_KEY);
    const user = await User.findById(decoded.id).select("-password");

    if (!user) return res.status(404).json({ message: "User not found" });

    res.json(user);
  } catch (err) {
    res.status(401).json({ message: "Invalid token" });
  }
});

// FORGOT PASSWORD (Simulated)
app.post("/api/auth/forgot-password", async (req, res) => {
  try {
    const { email } = req.body;
    const user = await User.findOne({ email });

    if (!user) return res.status(404).json({ message: "Email not found" });

    // SEND RESET EMAIL
    try {
      await transporter.sendMail({
        from: '"Monster Adventure" <support@game.com>',
        to: email,
        subject: "Reset Your Password",
        html: `
          <h3>Reset Password Request</h3>
          <p>Hello ${user.username}, someone requested a password reset for your account.</p>
          <p>Click the link below to reset it (Link is simulated for now):</p>
          <a href="#">Reset Password</a>
        `,
      });
      console.log(`📧 Reset email sent to ${email}`);
    } catch (emailErr) {
      console.error("Email failed");
    }

    res.json({ message: "Reset link sent" });
  } catch (err) {
    res.status(500).json({ message: "Server Error" });
  }
});

// --- 3. NEWS ROUTES (For the Game Log) ---

// Get All News
app.get("/api/news", async (req, res) => {
  try {
    const news = await News.find().sort({ createdAt: -1 }); // Sorted by newest
    res.json(news);
  } catch (err) {
    res.status(500).json({ message: "Error fetching news" });
  }
});
// Add News (Connected to DB)
app.post("/api/news", async (req, res) => {
  try {
    // We add the current date if not provided
    const newsData = {
      ...req.body,
      date: req.body.date || new Date().toISOString().split("T")[0],
    };
    const newPost = await News.create(newsData);
    res.status(201).json(newPost);
  } catch (err) {
    res
      .status(500)
      .json({ message: "Error creating news", error: err.message });
  }
});

// Update News (NEW ROUTE)
app.put("/api/news/:id", async (req, res) => {
  try {
    const updatedPost = await News.findByIdAndUpdate(req.params.id, req.body, {
      new: true,
    });
    res.json(updatedPost);
  } catch (err) {
    res.status(500).json({ message: "Error updating news" });
  }
});

// Delete News
app.delete("/api/news/:id", async (req, res) => {
  try {
    await News.findByIdAndDelete(req.params.id);
    res.json({ message: "Deleted from Database" });
  } catch (err) {
    res.status(500).json({ message: "Error deleting" });
  }
});

// --- START SERVER ---
app.listen(PORT, () => {
  console.log(`🚀 Server running on http://localhost:${PORT}`);
});
