<?php
/**
 * User Model
 */

namespace App\Models;

class UserModel extends BaseModel
{
    protected string $table = 'users';
    protected array $allowedFields = [
        'username',
        'email',
        'password',
        'role',
        'reset_token',
        'reset_expires',
    ];
    
    /**
     * Find user by email
     */
    public function findByEmail(string $email): ?array
    {
        return $this->firstWhere('email', $email);
    }
    
    /**
     * Create user with hashed password
     */
    public function createUser(string $username, string $email, string $password, string $role = 'user'): int|false
    {
        return $this->insert([
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => $role,
        ]);
    }
    
    /**
     * Verify password
     */
    public function verifyPassword(array $user, string $password): bool
    {
        return password_verify($password, $user['password']);
    }
    
    /**
     * Generate password reset token
     */
    public function generateResetToken(int $userId): string
    {
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        $this->update($userId, [
            'reset_token' => $token,
            'reset_expires' => $expires,
        ]);
        
        return $token;
    }
    
    /**
     * Validate reset token
     */
    public function validateResetToken(string $token): ?array
    {
        if (!$this->db) return null;
        
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE reset_token = ? AND reset_expires > NOW() LIMIT 1"
        );
        $stmt->execute([$token]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
}
