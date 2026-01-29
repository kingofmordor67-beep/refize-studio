<?php
/**
 * CMS Controller
 * Handles CMS admin operations with key-based authentication
 */

namespace App\Controllers;

use App\Models\SanityNewsModel;

class CMS extends BaseController
{
    private SanityNewsModel $newsModel;
    
    public function __construct()
    {
        $this->newsModel = new SanityNewsModel();
    }
    
    /**
     * Verify admin key from request
     */
    private function requireCMSAdmin(): bool
    {
        $input = $this->getJsonInput();
        $key = $input['adminKey'] ?? $_SERVER['HTTP_X_ADMIN_KEY'] ?? '';
        
        if (!$this->newsModel->verifyAdminKey($key)) {
            $this->json(['error' => 'Invalid admin key'], 401);
            return false;
        }
        
        return true;
    }
    
    /**
     * Verify admin key - POST /cms/verify
     */
    public function verify(): void
    {
        $input = $this->getJsonInput();
        $key = $input['adminKey'] ?? '';
        
        if ($this->newsModel->verifyAdminKey($key)) {
            $this->json(['success' => true, 'message' => 'Admin key verified']);
        } else {
            $this->json(['success' => false, 'error' => 'Invalid admin key'], 401);
        }
    }
    
    /**
     * Get all news - GET /cms/news
     */
    public function index(): void
    {
        $news = $this->newsModel->getLatest();
        $this->json($news);
    }
    
    /**
     * Get CMS status - GET /cms/status
     */
    public function status(): void
    {
        $this->json([
            'configured' => $this->newsModel->isConfigured(),
            'message' => $this->newsModel->isConfigured() 
                ? 'Sanity CMS is configured and ready' 
                : 'Sanity CMS is not configured - using fallback data'
        ]);
    }
    
    /**
     * Create news - POST /cms/news/create
     */
    public function create(): void
    {
        if (!$this->requireCMSAdmin()) return;
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['error' => 'Method not allowed'], 405);
            return;
        }
        
        $input = $this->getJsonInput();
        
        // Validation
        if (empty($input['title']) || empty($input['version'])) {
            $this->json(['error' => 'Title and version are required'], 400);
            return;
        }
        
        try {
            $data = [
                'title' => $input['title'],
                'version' => $input['version'],
                'date' => $input['date'] ?? date('Y-m-d'),
                'body' => $input['body'] ?? '',
                'thumb' => $input['thumb'] ?? '',
            ];
            
            $id = $this->newsModel->insert($data);
            
            if (!$id) {
                $this->json(['error' => 'Failed to create news'], 500);
                return;
            }
            
            $this->json(['success' => true, 'id' => $id], 201);
        } catch (\Exception $e) {
            $this->json(['error' => $e->getMessage()], 500);
        }
    }
    
    /**
     * Update news - PUT /cms/news/update/{id}
     */
    public function update(string $id): void
    {
        if (!$this->requireCMSAdmin()) return;
        
        if ($_SERVER['REQUEST_METHOD'] !== 'PUT' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['error' => 'Method not allowed'], 405);
            return;
        }
        
        $input = $this->getJsonInput();
        
        try {
            $data = [];
            if (isset($input['title'])) $data['title'] = $input['title'];
            if (isset($input['version'])) $data['version'] = $input['version'];
            if (isset($input['date'])) $data['date'] = $input['date'];
            if (isset($input['body'])) $data['body'] = $input['body'];
            if (isset($input['thumb'])) $data['thumb'] = $input['thumb'];
            
            $success = $this->newsModel->update($id, $data);
            
            if (!$success) {
                $this->json(['error' => 'Failed to update news'], 500);
                return;
            }
            
            $this->json(['success' => true]);
        } catch (\Exception $e) {
            $this->json(['error' => $e->getMessage()], 500);
        }
    }
    
    /**
     * Delete news - DELETE /cms/news/delete/{id}
     */
    public function delete(string $id): void
    {
        if (!$this->requireCMSAdmin()) return;
        
        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['error' => 'Method not allowed'], 405);
            return;
        }
        
        try {
            $success = $this->newsModel->delete($id);
            
            if (!$success) {
                $this->json(['error' => 'Failed to delete news'], 500);
                return;
            }
            
            $this->json(['success' => true, 'message' => 'News deleted successfully']);
        } catch (\Exception $e) {
            $this->json(['error' => $e->getMessage()], 500);
        }
    }
}
