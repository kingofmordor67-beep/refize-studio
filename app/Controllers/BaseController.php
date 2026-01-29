<?php
/**
 * Base Controller
 * All controllers extend this class
 */

namespace App\Controllers;

use App\Config\App;

abstract class BaseController
{
    protected array $data = [];
    
    /**
     * Load a view file
     */
    protected function view(string $view, array $data = []): void
    {
        $this->data = array_merge($this->data, $data);
        $this->data['baseURL'] = App::baseURL();
        $this->data['user'] = $this->currentUser();
        
        // Extract data to variables
        extract($this->data);
        
        $viewPath = APPPATH . 'Views/' . str_replace('.', '/', $view) . '.php';
        
        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            echo "View not found: {$view}";
        }
    }
    
    /**
     * Return JSON response
     */
    protected function json(mixed $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    /**
     * Get current logged in user
     */
    protected function currentUser(): ?array
    {
        return $_SESSION['user'] ?? null;
    }
    
    /**
     * Check if user is admin
     */
    protected function isAdmin(): bool
    {
        $user = $this->currentUser();
        return $user && $user['role'] === 'admin';
    }
    
    /**
     * Require authentication
     */
    protected function requireAuth(): void
    {
        if (!$this->currentUser()) {
            $this->json(['error' => 'Not authenticated'], 401);
        }
    }
    
    /**
     * Require admin role
     */
    protected function requireAdmin(): void
    {
        $this->requireAuth();
        if (!$this->isAdmin()) {
            $this->json(['error' => 'Admin access required'], 403);
        }
    }
    
    /**
     * Get POST JSON data
     */
    protected function getJsonInput(): array
    {
        $input = file_get_contents('php://input');
        return json_decode($input, true) ?? [];
    }
    
    /**
     * Redirect to URL
     */
    protected function redirect(string $url): void
    {
        header("Location: " . App::baseURL() . ltrim($url, '/'));
        exit;
    }
}
