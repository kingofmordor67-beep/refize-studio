<?php
/**
 * Database Configuration
 */

namespace App\Config;

class Database
{
    public static array $default = [
        'hostname' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'refize_studio',
        'charset'  => 'utf8mb4',
    ];
    
    private static ?\PDO $connection = null;
    
    /**
     * Get database connection
     */
    public static function connect(): ?\PDO
    {
        if (self::$connection === null) {
            $config = self::$default;
            $dsn = "mysql:host={$config['hostname']};dbname={$config['database']};charset={$config['charset']}";
            
            try {
                self::$connection = new \PDO($dsn, $config['username'], $config['password'], [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    \PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (\PDOException $e) {
                // Return null connection for graceful fallback
                error_log("Database connection failed: " . $e->getMessage());
                return null;
            }
        }
        
        return self::$connection;
    }
}
