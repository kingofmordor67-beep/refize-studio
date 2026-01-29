<?php
/**
 * Base Model
 * Provides common database operations
 */

namespace App\Models;

use App\Config\Database;

abstract class BaseModel
{
    protected ?\PDO $db;
    protected string $table = '';
    protected string $primaryKey = 'id';
    protected array $allowedFields = [];
    
    public function __construct()
    {
        $this->db = Database::connect();
    }
    
    /**
     * Find all records
     */
    public function findAll(string $orderBy = 'id DESC'): array
    {
        if (!$this->db) return [];
        
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY {$orderBy}");
        return $stmt->fetchAll();
    }
    
    /**
     * Find by ID
     */
    public function find(int $id): ?array
    {
        if (!$this->db) return null;
        
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
    
    /**
     * Find by field
     */
    public function where(string $field, mixed $value): array
    {
        if (!$this->db) return [];
        
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$field} = ?");
        $stmt->execute([$value]);
        return $stmt->fetchAll();
    }
    
    /**
     * Find first by field
     */
    public function firstWhere(string $field, mixed $value): ?array
    {
        if (!$this->db) return null;
        
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$field} = ? LIMIT 1");
        $stmt->execute([$value]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
    
    /**
     * Insert record
     */
    public function insert(array $data): int|false
    {
        if (!$this->db) return false;
        
        // Filter to allowed fields
        $data = array_intersect_key($data, array_flip($this->allowedFields));
        
        $fields = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        
        $stmt = $this->db->prepare("INSERT INTO {$this->table} ({$fields}) VALUES ({$placeholders})");
        $stmt->execute(array_values($data));
        
        return (int) $this->db->lastInsertId();
    }
    
    /**
     * Update record
     */
    public function update(int $id, array $data): bool
    {
        if (!$this->db) return false;
        
        // Filter to allowed fields
        $data = array_intersect_key($data, array_flip($this->allowedFields));
        
        $setClause = implode(', ', array_map(fn($k) => "{$k} = ?", array_keys($data)));
        $values = array_values($data);
        $values[] = $id;
        
        $stmt = $this->db->prepare("UPDATE {$this->table} SET {$setClause} WHERE {$this->primaryKey} = ?");
        return $stmt->execute($values);
    }
    
    /**
     * Delete record
     */
    public function delete(int $id): bool
    {
        if (!$this->db) return false;
        
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?");
        return $stmt->execute([$id]);
    }
    
    /**
     * Count all records
     */
    public function countAll(): int
    {
        if (!$this->db) return 0;
        
        $stmt = $this->db->query("SELECT COUNT(*) FROM {$this->table}");
        return (int) $stmt->fetchColumn();
    }
}
