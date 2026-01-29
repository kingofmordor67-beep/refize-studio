<?php
/**
 * News Controller
 * Handles news/changelog CRUD operations (API)
 */

namespace App\Controllers;

use App\Models\NewsModel;

class News extends BaseController
{
    private NewsModel $newsModel;
    
    public function __construct()
    {
        $this->newsModel = new NewsModel();
    }
    
    /**
     * Get all news - GET /news
     */
    public function index(): void
    {
        $news = $this->newsModel->getLatest();
        $this->json($news);
    }
    
    /**
     * Get single news - GET /news/show/{id}
     */
    public function show(int $id): void
    {
        $news = $this->newsModel->find($id);
        
        if (!$news) {
            $this->json(['error' => 'News not found'], 404);
            return;
        }
        
        $this->json($news);
    }
    
    /**
     * Create news - POST /news/create
     */
    public function create(): void
    {
        $this->requireAdmin();
        
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
        
        $data = [
            'title' => $input['title'],
            'version' => $input['version'],
            'date' => $input['date'] ?? date('Y-m-d'),
            'body' => $input['body'] ?? '',
            'thumb' => $input['thumb'] ?? '',
            'media_type' => $input['mediaType'] ?? 'image',
            'media_url' => $input['mediaUrl'] ?? '',
            'is_featured' => $input['is_featured'] ?? false,
        ];
        
        $id = $this->newsModel->insert($data);
        
        if (!$id) {
            $this->json(['error' => 'Failed to create news'], 500);
            return;
        }
        
        $news = $this->newsModel->find($id);
        $this->json($news, 201);
    }
    
    /**
     * Update news - PUT /news/update/{id}
     */
    public function update(int $id): void
    {
        $this->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'PUT' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['error' => 'Method not allowed'], 405);
            return;
        }
        
        $existing = $this->newsModel->find($id);
        if (!$existing) {
            $this->json(['error' => 'News not found'], 404);
            return;
        }
        
        $input = $this->getJsonInput();
        
        $data = [];
        if (isset($input['title'])) $data['title'] = $input['title'];
        if (isset($input['version'])) $data['version'] = $input['version'];
        if (isset($input['date'])) $data['date'] = $input['date'];
        if (isset($input['body'])) $data['body'] = $input['body'];
        if (isset($input['thumb'])) $data['thumb'] = $input['thumb'];
        if (isset($input['mediaType'])) $data['media_type'] = $input['mediaType'];
        if (isset($input['mediaUrl'])) $data['media_url'] = $input['mediaUrl'];
        if (isset($input['is_featured'])) $data['is_featured'] = $input['is_featured'];
        
        $this->newsModel->update($id, $data);
        
        $news = $this->newsModel->find($id);
        $this->json($news);
    }
    
    /**
     * Delete news - DELETE /news/delete/{id}
     */
    public function delete(int $id): void
    {
        $this->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['error' => 'Method not allowed'], 405);
            return;
        }
        
        $existing = $this->newsModel->find($id);
        if (!$existing) {
            $this->json(['error' => 'News not found'], 404);
            return;
        }
        
        $this->newsModel->delete($id);
        $this->json(['message' => 'News deleted successfully']);
    }
}
