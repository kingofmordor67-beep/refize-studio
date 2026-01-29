<?php
/**
 * News Model
 */

namespace App\Models;

class NewsModel extends BaseModel
{
    protected string $table = 'news';
    protected array $allowedFields = [
        'title',
        'version',
        'date',
        'body',
        'thumb',
        'media_type',
        'media_url',
        'is_featured',
    ];
    
    /**
     * Get all news ordered by date
     */
    public function getLatest(int $limit = 20): array
    {
        if (!$this->db) return $this->getFallbackNews();
        
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} ORDER BY date DESC, id DESC LIMIT ?"
        );
        $stmt->execute([$limit]);
        $result = $stmt->fetchAll();
        
        return $result ?: $this->getFallbackNews();
    }
    
    /**
     * Get featured news
     */
    public function getFeatured(): array
    {
        return $this->where('is_featured', 1);
    }
    
    /**
     * Fallback news data when database is unavailable
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
