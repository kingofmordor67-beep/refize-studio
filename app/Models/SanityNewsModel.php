<?php
/**
 * Sanity News Model
 * Fetches news from Sanity CMS instead of local database
 */

namespace App\Models;

require_once __DIR__ . '/../../cms/SanityService.php';

use \SanityService;

class SanityNewsModel
{
    private $sanity;
    private $useFallback = false;

    public function __construct()
    {
        try {
            $this->sanity = new SanityService();
        } catch (\Exception $e) {
            $this->useFallback = true;
        }
    }

    /**
     * Check if Sanity is properly configured
     */
    public function isConfigured(): bool
    {
        $config = require __DIR__ . '/../../cms/sanity-config.php';
        return $config['project_id'] !== 'YOUR_PROJECT_ID';
    }

    /**
     * Get all news ordered by date
     */
    public function getLatest(int $limit = 20): array
    {
        // If not configured, use fallback
        if (!$this->isConfigured() || $this->useFallback) {
            return $this->getFallbackNews();
        }

        try {
            $news = $this->sanity->getAllNews();
            
            // Transform Sanity format to match existing format
            return array_map(function($item) {
                return [
                    'id' => $item['_id'],
                    'title' => $item['title'] ?? '',
                    'version' => $item['version'] ?? '',
                    'date' => $item['date'] ?? date('Y-m-d'),
                    'body' => $item['body'] ?? '',
                    'thumb' => $item['thumb'] ?? '',
                    'media_type' => 'image',
                ];
            }, array_slice($news, 0, $limit));
        } catch (\Exception $e) {
            error_log("Sanity fetch error: " . $e->getMessage());
            return $this->getFallbackNews();
        }
    }

    /**
     * Get single news by ID
     */
    public function find($id): ?array
    {
        if (!$this->isConfigured() || $this->useFallback) {
            $fallback = $this->getFallbackNews();
            foreach ($fallback as $item) {
                if ($item['id'] == $id) return $item;
            }
            return null;
        }

        try {
            $item = $this->sanity->getNewsById($id);
            if (!$item) return null;

            return [
                'id' => $item['_id'],
                'title' => $item['title'] ?? '',
                'version' => $item['version'] ?? '',
                'date' => $item['date'] ?? date('Y-m-d'),
                'body' => $item['body'] ?? '',
                'thumb' => $item['thumb'] ?? '',
                'media_type' => 'image',
            ];
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Create news (requires admin authentication)
     */
    public function insert(array $data): ?string
    {
        if (!$this->isConfigured()) {
            throw new \Exception('Sanity CMS not configured');
        }

        try {
            $result = $this->sanity->createNews($data);
            return $result['results'][0]['id'] ?? null;
        } catch (\Exception $e) {
            error_log("Sanity create error: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update news
     */
    public function update($id, array $data): bool
    {
        if (!$this->isConfigured()) {
            throw new \Exception('Sanity CMS not configured');
        }

        try {
            $this->sanity->updateNews($id, $data);
            return true;
        } catch (\Exception $e) {
            error_log("Sanity update error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete news
     */
    public function delete($id): bool
    {
        if (!$this->isConfigured()) {
            throw new \Exception('Sanity CMS not configured');
        }

        try {
            $this->sanity->deleteNews($id);
            return true;
        } catch (\Exception $e) {
            error_log("Sanity delete error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Verify admin key
     */
    public function verifyAdminKey(string $key): bool
    {
        return $this->sanity->verifyAdminKey($key);
    }

    /**
     * Fallback news data when Sanity is unavailable
     */
    private function getFallbackNews(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'The Great Awakening Update',
                'version' => 'v2.0',
                'date' => '2025-01-15',
                'body' => 'The world of Monster Adventure has never been more alive! This massive update introduces the Elder Evolution system, where your companions can now reach their ultimate forms. New biomes include the Crystal Caves and the Floating Isles.',
                'thumb' => 'https://images.unsplash.com/photo-1511512578047-dfb367046420?w=800',
                'media_type' => 'image',
            ],
            [
                'id' => 2,
                'title' => 'Companion Collection Expansion',
                'version' => 'v1.8',
                'date' => '2025-01-08',
                'body' => 'Meet 12 brand new companions waiting to join your adventure! From the fiery Blazekin to the mysterious Shadowmere, each new companion brings unique abilities and evolution paths.',
                'thumb' => 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?w=800',
                'media_type' => 'image',
            ],
            [
                'id' => 3,
                'title' => 'Winter Wonderland Event',
                'version' => 'v1.7',
                'date' => '2024-12-20',
                'body' => 'The snow is falling in Monster Adventure! Join our limited-time Winter Wonderland event featuring exclusive holiday-themed companions and festive decorations.',
                'thumb' => 'https://images.unsplash.com/photo-1418985991508-e47386d96a71?w=800',
                'media_type' => 'image',
            ],
            [
                'id' => 4,
                'title' => 'Performance & Bug Fixes',
                'version' => 'v1.6.5',
                'date' => '2024-12-10',
                'body' => 'This patch focuses on stability and performance improvements based on your feedback. We\'ve squashed numerous bugs and optimized the game for smoother gameplay.',
                'thumb' => 'https://images.unsplash.com/photo-1504639725590-34d0984388bd?w=800',
                'media_type' => 'image',
            ],
        ];
    }
}
