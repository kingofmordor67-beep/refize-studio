import React, { useState, useEffect, useRef } from "react";
import axios from "axios";
import Swal from "sweetalert2";
import { AuthProvider, useAuth } from "./context/AuthContext";
import {
  CustomCursor,
  useEyeTracking,
  useTilt3D,
  FadeInSection,
} from "./components/Effects";
import "./index.css";

// --- HEADER ---

const Header = ({ onAuthClick }) => {
  const { user } = useAuth();
  const [scrolled, setScrolled] = useState(false);
  const [menuActive, setMenuActive] = useState(false);

  useEffect(() => {
    const handleScroll = () => setScrolled(window.scrollY > 50);
    window.addEventListener("scroll", handleScroll);
    return () => window.removeEventListener("scroll", handleScroll);
  }, []);

  const scrollToSection = (id) => {
    setMenuActive(false);
    const element = document.getElementById(id);
    if (element) {
      element.scrollIntoView({ behavior: "smooth", block: "start" });
    }
  };

  return (
    <header id="navbar" className={scrolled ? "scrolled" : ""}>
      <div className="logo" onClick={() => scrollToSection("home")}>
        <h2 style={{ color: "var(--primary)", fontWeight: 900 }}>MA</h2>
      </div>

      <div
        className={`hamburger ${menuActive ? "active" : ""}`}
        onClick={() => setMenuActive(!menuActive)}
      >
        <span></span>
        <span></span>
        <span></span>
      </div>

      <nav className={menuActive ? "nav-active" : ""}>
        <ul>
          <li>
            <button
              className="nav-btn-link"
              onClick={() => scrollToSection("home")}
            >
              Home
            </button>
          </li>
          <li>
            <button
              className="nav-btn-link"
              onClick={() => scrollToSection("story")}
            >
              Story
            </button>
          </li>
          <li>
            <button
              className="nav-btn-link"
              onClick={() => scrollToSection("news")}
            >
              News
            </button>
          </li>
          <li>
            <button className="btn-auth" onClick={onAuthClick}>
              {user ? "Log Out" : "Log In"}
            </button>
          </li>
        </ul>
      </nav>
    </header>
  );
};

// --- HERO SECTION ---

const Hero = () => {
  const svgRef = useRef(null);
  useEyeTracking(svgRef);

  const scrollToStory = () => {
    document.getElementById("story").scrollIntoView({ behavior: "smooth" });
  };

  return (
    <section className="hero" id="home">
      <div className="hero-content">
        <span className="badge">V 2.0 Released</span>
        <h1>
          Choose Your
          <br />
          <span>Adventure</span>
        </h1>
        <p>
          From egg to elder, your choices shape the world. Experience a
          dynamically evolving story.
        </p>
        <button className="cta-btn" onClick={scrollToStory}>
          Start Journey
        </button>
      </div>
      <div className="hero-img" ref={svgRef}>
        <svg width="400" height="400" viewBox="0 0 400 400">
          <defs>
            <filter id="glow" x="-20%" y="-20%" width="140%" height="140%">
              <feGaussianBlur stdDeviation="15" result="blur" />
              <feComposite in="SourceGraphic" in2="blur" operator="over" />
            </filter>
          </defs>
          <path
            d="M100,350 Q50,350 50,250 Q50,100 200,100 Q350,100 350,250 Q350,350 300,350 Z"
            fill="#00d2a4"
          />
          <path d="M120,350 Q120,180 200,180 Q280,180 280,350" fill="#55efc4" />
          <g className="eyes">
            <circle cx="160" cy="200" r="25" fill="white" />
            <circle cx="160" cy="200" r="8" fill="#2d3436" />
            <circle cx="240" cy="200" r="25" fill="white" />
            <circle cx="240" cy="200" r="8" fill="#2d3436" />
          </g>
          <path
            d="M180,260 Q200,280 220,260"
            fill="none"
            stroke="#2d3436"
            strokeWidth="5"
            strokeLinecap="round"
          />
          <path d="M120,130 L100,80 L140,110" fill="#ffeaa7" />
          <path d="M280,130 L300,80 L260,110" fill="#ffeaa7" />
        </svg>
      </div>
    </section>
  );
};

// --- CHARACTERS SECTION (Fixed) ---

const CharactersSection = () => {
  const [currentIndex, setCurrentIndex] = useState(0);

  // Character Data
  const characters = [
    {
      id: "zippo",
      name: "Zippo",
      desc: "Energetic and curious. Gains bonus XP from exploration.",
      className: "c-zippo",
      svg: (
        <svg width="100" height="120" viewBox="0 0 100 120">
          <path
            d="M20,100 Q10,60 50,50 Q90,60 80,100 Q50,110 20,100"
            fill="#0984e3"
          />
          <circle cx="40" cy="80" r="8" fill="white" />
          <circle cx="40" cy="80" r="3" fill="black" />
          <circle cx="65" cy="80" r="8" fill="white" />
          <circle cx="65" cy="80" r="3" fill="black" />
          <path
            d="M48 95 Q52 100 56 95"
            fill="none"
            stroke="black"
            strokeWidth="2"
            strokeLinecap="round"
          />
        </svg>
      ),
    },
    {
      id: "tokko",
      name: "Tokko",
      desc: "Brave and stubborn. Features high defense.",
      className: "c-tokko",
      svg: (
        <svg width="100" height="120" viewBox="0 0 100 120">
          <path d="M20,100 L30,40 L50,20 L70,40 L80,100 Z" fill="#ff7675" />
          <rect x="20" y="40" width="60" height="60" rx="15" fill="#ff7675" />
          <path d="M30,40 L20,20 L40,35" fill="#d63031" />
          <path d="M70,40 L80,20 L60,35" fill="#d63031" />
          <path d="M35 55 L45 60 L35 65" fill="white" />
          <path d="M65 55 L55 60 L65 65" fill="white" />
          <rect x="40" y="80" width="20" height="5" fill="#2d3436" rx="2" />
        </svg>
      ),
    },
    {
      id: "ellize",
      name: "Ellize",
      desc: "Mystical and calm. Specialized in magic and puzzles.",
      className: "c-ellize",
      svg: (
        <svg width="100" height="120" viewBox="0 0 100 120">
          <rect x="30" y="30" width="40" height="70" rx="20" fill="#00b894" />
          <circle cx="50" cy="50" r="15" fill="#55efc4" />
          <circle cx="50" cy="50" r="5" fill="#2d3436" />
          <circle cx="20" cy="40" r="5" fill="#55efc4" opacity="0.6" />
          <circle cx="80" cy="80" r="8" fill="#55efc4" opacity="0.6" />
        </svg>
      ),
    },
    {
      id: "glacius",
      name: "Glacius",
      desc: "Cold and calculating. Freezes enemies in their tracks.",
      className: "c-glacius",
      svg: (
        <svg width="100" height="120" viewBox="0 0 100 120">
          <path d="M20,20 L80,20 L70,100 L30,100 Z" fill="#74b9ff" />
          <path d="M20,20 L50,5 L80,20" fill="#0984e3" />
          <rect x="35" y="40" width="10" height="30" fill="white" />
          <rect x="55" y="40" width="10" height="30" fill="white" />
        </svg>
      ),
    },
  ];

  const nextSlide = () => {
    setCurrentIndex((prev) => (prev + 1) % characters.length);
  };

  const prevSlide = () => {
    setCurrentIndex(
      (prev) => (prev - 1 + characters.length) % characters.length
    );
  };

  const getCardStyle = (index) => {
    const total = characters.length;

    // Calculate indices for Previous, Current, and Next
    const prevIndex = (currentIndex - 1 + total) % total;
    const nextIndex = (currentIndex + 1) % total;

    // --- DESKTOP LOGIC (3 Cards Visible: Left, Center, Right) ---
    let order = 99; // Default hidden order
    let isVisibleDesktop = false;

    if (index === prevIndex) {
      order = 1;
      isVisibleDesktop = true;
    } else if (index === currentIndex) {
      order = 2;
      isVisibleDesktop = true;
    } else if (index === nextIndex) {
      order = 3;
      isVisibleDesktop = true;
    }

    // --- MOBILE LOGIC (Poker Stack) ---
    let mobileClass = "m-hidden";
    if (index === currentIndex) mobileClass = "m-active";
    else if (index === nextIndex) mobileClass = "m-next";
    else if (index === prevIndex) mobileClass = "m-prev";

    return {
      // We pass the order variable to CSS to rearrange them visually
      style: { "--order": order },
      className: `${
        isVisibleDesktop ? "d-visible" : "d-hidden"
      } ${mobileClass}`,
    };
  };

  return (
    <section className="section-padding" id="story">
      <FadeInSection>
        <div className="section-header">
          <h2>Companions</h2>
          <p>Select your starting lineage</p>
        </div>

        <div className="carousel-wrapper">
          <button className="carousel-btn prev-btn" onClick={prevSlide}>
            &#10094;
          </button>

          <div className="deck-container">
            {characters.map((char, index) => {
              const { style, className } = getCardStyle(index);
              return (
                <div
                  key={char.id}
                  style={style}
                  className={`char-card tilt-card carousel-card ${className} ${char.className}`}
                  onClick={() => {
                    // Clicking a side card selects it
                    if (index !== currentIndex) setCurrentIndex(index);
                  }}
                >
                  <div className="char-img">{char.svg}</div>
                  <h3>{char.name}</h3>
                  <p>{char.desc}</p>
                  <a
                    href="#"
                    className="card-link"
                    onClick={(e) => e.preventDefault()}
                  >
                    Select {char.name} &rarr;
                  </a>
                </div>
              );
            })}
          </div>

          <button className="carousel-btn next-btn" onClick={nextSlide}>
            &#10095;
          </button>
        </div>

        <div className="carousel-dots">
          {characters.map((_, idx) => (
            <span
              key={idx}
              className={`dot ${idx === currentIndex ? "active" : ""}`}
              onClick={() => setCurrentIndex(idx)}
            ></span>
          ))}
        </div>
      </FadeInSection>
    </section>
  );
};

// --- NEWS SECTION ---

const NewsSection = ({ news, onDelete, onEdit, onReadMore }) => {
  const { user } = useAuth();
  return (
    <section className="section-padding" id="news">
      <FadeInSection>
        <div className="section-header">
          <h2>Game Log</h2>
          <p>Track the evolution of the world</p>
        </div>
        <div className="container">
          <div className="dev-layout">
            <div className="timeline-nav">
              <div className="timeline-line"></div>
              {news.map((item, i) => (
                <div
                  key={i}
                  className="timeline-dot nav-btn-link"
                  onClick={() =>
                    document
                      .getElementById(`post-${i}`)
                      .scrollIntoView({ behavior: "smooth", block: "center" })
                  }
                >
                  {item.version}
                </div>
              ))}
            </div>
            <div className="cards-grid dev-grid-wrapper">
              {news.map((post, i) => (
                <div
                  key={post._id || i}
                  id={`post-${i}`}
                  className="char-card dev-card tilt-card"
                >
                  {user?.role === "admin" && (
                    <div className="admin-actions">
                      <button
                        className="btn-admin-small edit"
                        onClick={() => onEdit(post)}
                      >
                        <i className="fas fa-edit"></i>
                      </button>
                      <button
                        className="btn-admin-small delete"
                        onClick={() => onDelete(post._id)}
                      >
                        <i className="fas fa-trash"></i>
                      </button>
                    </div>
                  )}
                  <div className="dev-content-upper">
                    <div className="dev-badge">{post.version}</div>
                    <h3>{post.title}</h3>
                    <p
                      style={{
                        fontSize: "0.9rem",
                        color: "#636e72",
                        marginBottom: "10px",
                      }}
                    >
                      {post.date}
                    </p>
                    <div
                      style={{
                        height: "120px",
                        overflow: "hidden",
                        borderRadius: "10px",
                        marginBottom: "15px",
                      }}
                    >
                      <img
                        src={post.thumb || "https://via.placeholder.com/400"}
                        style={{
                          width: "100%",
                          height: "100%",
                          objectFit: "cover",
                        }}
                        alt={post.title}
                      />
                    </div>
                    <p>{post.body?.substring(0, 80)}...</p>
                  </div>
                  <button
                    className="card-link"
                    style={{
                      background: "none",
                      border: "none",
                      cursor: "pointer",
                    }}
                    onClick={() => onReadMore(post)}
                  >
                    Read Changelog &rarr;
                  </button>
                </div>
              ))}
            </div>
          </div>
        </div>
      </FadeInSection>
    </section>
  );
};

const NewsletterSection = () => {
  return (
    <FadeInSection>
      <section className="newsletter tilt-card">
        <div className="circle-decor cd-1"></div>
        <div className="circle-decor cd-2"></div>
        <h2>Join the Beta</h2>
        <div className="input-wrapper">
          <input type="email" placeholder="Enter your email address..." />
          <button
            onClick={() =>
              Swal.fire("Awesome!", "You're on the list.", "success")
            }
          >
            Join
          </button>
        </div>
      </section>
    </FadeInSection>
  );
};

// --- MAIN PAGE LAYOUT ---

const Main = () => {
  const { user, login, register, logout, API_URL } = useAuth();
  const [news, setNews] = useState([]);
  const [modalMode, setModalMode] = useState(null);
  const [selectedNews, setSelectedNews] = useState(null);

  // News Form State
  const [newsForm, setNewsForm] = useState({
    title: "",
    version: "",
    body: "",
    thumb: "",
    date: "",
  });
  const [isEditing, setIsEditing] = useState(null); // Stores ID of post being edited

  // Auth State (Keep existing)
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [username, setUsername] = useState("");
  const [confirmPass, setConfirmPass] = useState("");
  const [errorMsg, setErrorMsg] = useState("");

  useTilt3D();

  // Reset errors and forms
  useEffect(() => {
    setErrorMsg("");
    if (!modalMode) {
      setNewsForm({ title: "", version: "", body: "", thumb: "", date: "" });
      setIsEditing(null);
    }
  }, [modalMode]);

  const fetchNews = async () => {
    try {
      const { data } = await axios.get(`${API_URL}/news`);
      setNews(data); // If the DB is empty, this will just be an empty array []
    } catch (e) {
      console.error("Could not fetch news from server");
      setNews([]);
    }
  };

  useEffect(() => {
    fetchNews();
  }, []);

  // --- ADMIN NEWS HANDLERS ---
  const handleOpenAdminModal = () => {
    setNewsForm({
      title: "",
      version: "",
      body: "",
      thumb: "",
      date: new Date().toISOString().split("T")[0],
    });
    setIsEditing(null);
    setModalMode("admin-news");
  };

  const handleEditClick = (post) => {
    setNewsForm({ ...post });
    setIsEditing(post._id);
    setModalMode("admin-news");
  };

  const handleNewsSubmit = async (e) => {
    e.preventDefault();
    try {
      if (isEditing) {
        // REAL UPDATE CALL
        const { data } = await axios.put(
          `${API_URL}/news/${isEditing}`,
          newsForm,
          { withCredentials: true }
        );
        setNews(news.map((n) => (n._id === isEditing ? data : n)));
        Swal.fire("Updated!", "Database entry has been modified.", "success");
      } else {
        // REAL CREATE CALL
        const { data } = await axios.post(`${API_URL}/news`, newsForm, {
          withCredentials: true,
        });
        setNews([data, ...news]);
        Swal.fire(
          "Published!",
          "News has been saved to the database.",
          "success"
        );
      }
      setModalMode(null);
    } catch (err) {
      Swal.fire(
        "Error",
        "Could not save to database. Check server connection.",
        "error"
      );
    }
  };

  const handleDeleteNews = async (id) => {
    const result = await Swal.fire({
      title: "Delete permanently?",
      text: "This will remove the data from MongoDB.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#ff7675",
    });

    if (result.isConfirmed) {
      try {
        await axios.delete(`${API_URL}/news/${id}`, { withCredentials: true });
        setNews(news.filter((n) => n._id !== id));
        Swal.fire("Deleted", "Entry removed from Database", "success");
      } catch (err) {
        Swal.fire("Error", "Failed to delete from server.", "error");
      }
    }
  };

  // Auth Handlers
  const handleAuthClick = () => {
    if (user) {
      Swal.fire({
        title: "Log out?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#ff7675",
      }).then((r) => {
        if (r.isConfirmed) logout();
      });
    } else {
      setModalMode("login");
    }
  };

  const handleLoginSubmit = async (e) => {
    e.preventDefault();
    setErrorMsg("");
    if (!email || !password) {
      setErrorMsg("Harap isi semua kolom.");
      return;
    }
    try {
      await login(email, password);
      setModalMode(null);
      Swal.fire({ icon: "success", title: "Welcome Back!" });
    } catch (err) {
      setErrorMsg("Username atau Password salah");
      const form = document.querySelector(".auth-form");
      if (form) {
        form.style.animation = "shake 0.3s";
        setTimeout(() => (form.style.animation = ""), 300);
      }
    }
  };

  const handleRegisterSubmit = async (e) => {
    e.preventDefault();
    setErrorMsg("");
    if (password !== confirmPass) {
      setErrorMsg("Password tidak cocok.");
      return;
    }
    if (password.length < 6) {
      setErrorMsg("Password minimal 6 karakter.");
      return;
    }
    try {
      await register(username, email, password);
      setModalMode(null);
      Swal.fire({
        icon: "info",
        title: "Verifikasi Email",
        text: `Link verifikasi telah dikirim ke ${email}. Silakan cek Inbox anda.`,
        confirmButtonText: "Buka Gmail",
        showCancelButton: true,
        cancelButtonText: "Nanti",
      }).then((result) => {
        if (result.isConfirmed)
          window.open("https://mail.google.com", "_blank");
      });
    } catch (err) {
      setErrorMsg("Gagal mendaftar. Email mungkin sudah digunakan.");
    }
  };

  const handleForgotSubmit = (e) => {
    e.preventDefault();
    if (!email) {
      setErrorMsg("Masukkan email anda.");
      return;
    }
    setModalMode(null);
    Swal.fire(
      "Link Terkirim",
      "Cek email anda untuk mereset password.",
      "success"
    );
  };

  return (
    <>
      <CustomCursor />
      <div className="bg-shapes">
        <div className="shape shape-1"></div>
        <div className="shape shape-2"></div>
        <div className="shape shape-3"></div>
      </div>

      <Header onAuthClick={handleAuthClick} />

      <div className="container">
        <FadeInSection>
          <Hero />
        </FadeInSection>
        <CharactersSection />
        <NewsSection
          news={news}
          onDelete={handleDeleteNews}
          onEdit={handleEditClick}
          onReadMore={(p) => {
            setSelectedNews(p);
            setModalMode("news");
          }}
        />
        <NewsletterSection />
        <footer
          style={{
            marginTop: "50px",
            textAlign: "center",
            color: "var(--text-light)",
            paddingBottom: "30px",
          }}
        >
          <p>&copy; 2024 Monster Adventure Inc.</p>
        </footer>
      </div>

      {user?.role === "admin" && (
        <button
          className="admin-fab"
          style={{ display: "flex" }}
          onClick={handleOpenAdminModal}
        >
          <i className="fas fa-plus"></i>
        </button>
      )}

      {/* --- ADMIN ADD/EDIT MODAL --- */}
      <div
        className={`modal-overlay ${
          modalMode === "admin-news" ? "active" : ""
        }`}
      >
        <div className="modal-content admin-modal">
          <button className="modal-close" onClick={() => setModalMode(null)}>
            &times;
          </button>
          <h2>{isEditing ? "Edit Update" : "New Changelog"}</h2>
          <form className="auth-form" onSubmit={handleNewsSubmit}>
            <div className="admin-form-row">
              <input
                placeholder="Title (e.g. New Horizons)"
                required
                value={newsForm.title}
                onChange={(e) =>
                  setNewsForm({ ...newsForm, title: e.target.value })
                }
              />
              <input
                placeholder="Version (e.g. v2.1)"
                required
                value={newsForm.version}
                onChange={(e) =>
                  setNewsForm({ ...newsForm, version: e.target.value })
                }
              />
            </div>
            <input
              placeholder="Thumbnail Image URL"
              value={newsForm.thumb}
              onChange={(e) =>
                setNewsForm({ ...newsForm, thumb: e.target.value })
              }
            />
            <textarea
              placeholder="What's new in this update?"
              required
              rows="5"
              value={newsForm.body}
              onChange={(e) =>
                setNewsForm({ ...newsForm, body: e.target.value })
              }
            />
            <button
              type="submit"
              className="cta-btn"
              style={{ width: "100%", marginTop: "10px" }}
            >
              {isEditing ? "Save Changes" : "Post Update"}
            </button>
          </form>
        </div>
      </div>

      {/* --- LOGIN MODAL --- */}
      <div className={`modal-overlay ${modalMode === "login" ? "active" : ""}`}>
        <div className="modal-content">
          <button className="modal-close" onClick={() => setModalMode(null)}>
            &times;
          </button>
          <h2>Welcome Back</h2>
          {errorMsg && <div className="error-banner">{errorMsg}</div>}
          <form className="auth-form" onSubmit={handleLoginSubmit}>
            <div className="input-group" style={{ marginBottom: 20 }}>
              <input
                type="email"
                placeholder="Email Address"
                required
                style={{
                  width: "100%",
                  padding: 15,
                  borderRadius: 10,
                  border: "1px solid #ddd",
                }}
                value={email}
                onChange={(e) => setEmail(e.target.value)}
              />
            </div>
            <div className="input-group" style={{ marginBottom: 10 }}>
              <input
                type="password"
                placeholder="Password"
                required
                style={{
                  width: "100%",
                  padding: 15,
                  borderRadius: 10,
                  border: "1px solid #ddd",
                }}
                value={password}
                onChange={(e) => setPassword(e.target.value)}
              />
            </div>
            <div style={{ textAlign: "right", marginBottom: 15 }}>
              <span
                style={{
                  fontSize: "0.85rem",
                  color: "#636e72",
                  cursor: "pointer",
                }}
                onClick={() => setModalMode("forgot")}
              >
                Lupa Password?
              </span>
            </div>
            <button
              type="submit"
              className="cta-btn"
              style={{ width: "100%", marginTop: "10px" }}
            >
              Sign In
            </button>
          </form>
          <p style={{ textAlign: "center", marginTop: "20px" }}>
            Belum punya akun?{" "}
            <span
              className="switch-modal"
              style={{
                color: "var(--primary)",
                fontWeight: "bold",
                cursor: "pointer",
              }}
              onClick={() => setModalMode("register")}
            >
              Register
            </span>
          </p>
        </div>
      </div>

      <div
        className={`modal-overlay ${modalMode === "register" ? "active" : ""}`}
      >
        <div className="modal-content">
          <button className="modal-close" onClick={() => setModalMode(null)}>
            &times;
          </button>
          <h2>New Hero?</h2>
          {errorMsg && <div className="error-banner">{errorMsg}</div>}
          <form className="auth-form" onSubmit={handleRegisterSubmit}>
            <div className="input-group" style={{ marginBottom: 20 }}>
              <input
                placeholder="Username"
                required
                style={{
                  width: "100%",
                  padding: 15,
                  borderRadius: 10,
                  border: "1px solid #ddd",
                }}
                value={username}
                onChange={(e) => setUsername(e.target.value)}
              />
            </div>
            <div className="input-group" style={{ marginBottom: 20 }}>
              <input
                type="email"
                placeholder="Email Address"
                required
                style={{
                  width: "100%",
                  padding: 15,
                  borderRadius: 10,
                  border: "1px solid #ddd",
                }}
                value={email}
                onChange={(e) => setEmail(e.target.value)}
              />
            </div>
            <div className="input-group" style={{ marginBottom: 20 }}>
              <input
                type="password"
                placeholder="Password"
                required
                style={{
                  width: "100%",
                  padding: 15,
                  borderRadius: 10,
                  border: "1px solid #ddd",
                }}
                value={password}
                onChange={(e) => setPassword(e.target.value)}
              />
            </div>
            <div className="input-group" style={{ marginBottom: 20 }}>
              <input
                type="password"
                placeholder="Confirm Password"
                required
                style={{
                  width: "100%",
                  padding: 15,
                  borderRadius: 10,
                  border: "1px solid #ddd",
                }}
                value={confirmPass}
                onChange={(e) => setConfirmPass(e.target.value)}
              />
            </div>
            <button
              type="submit"
              className="cta-btn"
              style={{ width: "100%", marginTop: "10px" }}
            >
              Register
            </button>
          </form>
          <p style={{ textAlign: "center", marginTop: "20px" }}>
            Sudah punya akun?{" "}
            <span
              className="switch-modal"
              style={{
                color: "var(--primary)",
                fontWeight: "bold",
                cursor: "pointer",
              }}
              onClick={() => setModalMode("login")}
            >
              Login
            </span>
          </p>
        </div>
      </div>

      <div
        className={`modal-overlay ${modalMode === "forgot" ? "active" : ""}`}
      >
        <div className="modal-content">
          <button className="modal-close" onClick={() => setModalMode(null)}>
            &times;
          </button>
          <h2>Reset Password</h2>
          <p style={{ marginBottom: 20, color: "#636e72" }}>
            Masukkan email yang terdaftar. Kami akan mengirimkan link reset.
          </p>
          {errorMsg && <div className="error-banner">{errorMsg}</div>}
          <form className="auth-form" onSubmit={handleForgotSubmit}>
            <div className="input-group" style={{ marginBottom: 20 }}>
              <input
                type="email"
                placeholder="Email Address"
                required
                style={{
                  width: "100%",
                  padding: 15,
                  borderRadius: 10,
                  border: "1px solid #ddd",
                }}
                value={email}
                onChange={(e) => setEmail(e.target.value)}
              />
            </div>
            <button
              type="submit"
              className="cta-btn"
              style={{ width: "100%", marginTop: "10px" }}
            >
              Kirim Link Reset
            </button>
          </form>
          <p style={{ textAlign: "center", marginTop: "20px" }}>
            <span
              className="switch-modal"
              style={{
                color: "var(--primary)",
                fontWeight: "bold",
                cursor: "pointer",
              }}
              onClick={() => setModalMode("login")}
            >
              &larr; Kembali ke Login
            </span>
          </p>
        </div>
      </div>

      <div className={`modal-overlay ${modalMode === "news" ? "active" : ""}`}>
        {selectedNews && (
          <div className="modal-content mega-modal-content">
            <button
              className="modal-close"
              style={{
                position: "absolute",
                right: 20,
                top: 20,
                border: "none",
                background: "none",
                fontSize: "1.5rem",
                cursor: "pointer",
                zIndex: 100,
                color: "white",
              }}
              onClick={() => setModalMode(null)}
            >
              &times;
            </button>
            <div
              className="mm-hero"
              style={{ height: 300, background: "black" }}
            >
              <img
                src={selectedNews.thumb}
                style={{
                  width: "100%",
                  height: "100%",
                  objectFit: "cover",
                  opacity: 0.8,
                }}
                alt="Cover"
                onError={(e) => {
                  e.target.onerror = null;
                  e.target.src =
                    "https://via.placeholder.com/800x400?text=No+Image+Available";
                }}
              />
            </div>
            <div className="mm-body" style={{ padding: 30 }}>
              <span className="badge">{selectedNews.version}</span>
              <h2>{selectedNews.title}</h2>
              <p>{selectedNews.body}</p>
            </div>
          </div>
        )}
      </div>
    </>
  );
};

export default function App() {
  return (
    <AuthProvider>
      <Main />
    </AuthProvider>
  );
}
