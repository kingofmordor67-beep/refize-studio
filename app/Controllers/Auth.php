<?php
/**
 * Auth Controller
 * Handles authentication (login, register, logout)
 */

namespace App\Controllers;

use App\Models\UserModel;
use App\Config\App;

class Auth extends BaseController
{
    private UserModel $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    
    /**
     * Login - POST /auth/login
     */
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['error' => 'Method not allowed'], 405);
            return;
        }
        
        $input = $this->getJsonInput();
        $email = $input['email'] ?? '';
        $password = $input['password'] ?? '';
        
        if (empty($email) || empty($password)) {
            $this->json(['error' => 'Email and password required'], 400);
            return;
        }
        
        $user = $this->userModel->findByEmail($email);
        
        if (!$user || !$this->userModel->verifyPassword($user, $password)) {
            $this->json(['error' => 'Invalid credentials'], 401);
            return;
        }
        
        // Store user in session (excluding password)
        unset($user['password'], $user['reset_token'], $user['reset_expires']);
        $_SESSION['user'] = $user;
        
        $this->json([
            'message' => 'Login successful',
            'user' => $user
        ]);
    }
    
    /**
     * Register - POST /auth/register
     */
    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['error' => 'Method not allowed'], 405);
            return;
        }
        
        $input = $this->getJsonInput();
        $username = trim($input['username'] ?? '');
        $email = trim($input['email'] ?? '');
        $password = $input['password'] ?? '';
        
        // Validation
        if (empty($username) || empty($email) || empty($password)) {
            $this->json(['error' => 'All fields are required'], 400);
            return;
        }
        
        if (strlen($password) < 6) {
            $this->json(['error' => 'Password must be at least 6 characters'], 400);
            return;
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->json(['error' => 'Invalid email format'], 400);
            return;
        }
        
        // Check if email exists
        if ($this->userModel->findByEmail($email)) {
            $this->json(['error' => 'Email already registered'], 400);
            return;
        }
        
        // Create user
        $userId = $this->userModel->createUser($username, $email, $password);
        
        if (!$userId) {
            $this->json(['error' => 'Registration failed'], 500);
            return;
        }
        
        // Send welcome email (simplified - would use PHPMailer in production)
        $this->sendWelcomeEmail($email, $username);
        
        $this->json([
            'message' => 'Registration successful',
            'userId' => $userId
        ], 201);
    }
    
    /**
     * Logout - POST /auth/logout
     */
    public function logout(): void
    {
        unset($_SESSION['user']);
        session_destroy();
        
        $this->json(['message' => 'Logged out successfully']);
    }
    
    /**
     * Get current user - GET /auth/me
     */
    public function me(): void
    {
        $user = $this->currentUser();
        
        if (!$user) {
            $this->json(['error' => 'Not authenticated'], 401);
            return;
        }
        
        $this->json($user);
    }
    
    /**
     * Forgot password - POST /auth/forgot
     */
    public function forgot(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['error' => 'Method not allowed'], 405);
            return;
        }
        
        $input = $this->getJsonInput();
        $email = trim($input['email'] ?? '');
        
        if (empty($email)) {
            $this->json(['error' => 'Email required'], 400);
            return;
        }
        
        $user = $this->userModel->findByEmail($email);
        
        // Always return success to prevent email enumeration
        if ($user) {
            $token = $this->userModel->generateResetToken($user['id']);
            $this->sendResetEmail($email, $user['username'], $token);
        }
        
        $this->json(['message' => 'If the email exists, a reset link has been sent']);
    }
    
    /**
     * Send welcome email
     */
    private function sendWelcomeEmail(string $email, string $username): void
    {
        $config = App::$email;
        $subject = "Welcome to Monster Adventure, {$username}!";
        $body = "
            <div style='font-family: Arial; color: #333; padding: 20px;'>
                <h1 style='color: #00d2a4;'>Welcome, {$username}!</h1>
                <p>Your journey from Egg to Elder has begun.</p>
                <p>We are thrilled to have you join our adventure.</p>
                <br/>
                <a href='" . App::baseURL() . "' style='background: #00d2a4; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Start Playing</a>
            </div>
        ";
        
        // Use PHP mail() or PHPMailer in production
        @mail($email, $subject, $body, "Content-Type: text/html; charset=UTF-8\r\nFrom: Monster Adventure <noreply@refize.com>");
    }
    
    /**
     * Send password reset email
     */
    private function sendResetEmail(string $email, string $username, string $token): void
    {
        $resetUrl = App::baseURL() . "auth/reset?token={$token}";
        $subject = "Reset Your Password - Monster Adventure";
        $body = "
            <div style='font-family: Arial; color: #333; padding: 20px;'>
                <h2>Password Reset Request</h2>
                <p>Hello {$username},</p>
                <p>Click the link below to reset your password:</p>
                <a href='{$resetUrl}' style='background: #00d2a4; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Reset Password</a>
                <p style='margin-top: 20px; color: #666;'>This link expires in 1 hour.</p>
            </div>
        ";
        
        @mail($email, $subject, $body, "Content-Type: text/html; charset=UTF-8\r\nFrom: Monster Adventure <noreply@refize.com>");
    }
}
