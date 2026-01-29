<?php
/**
 * Application Configuration
 */

namespace App\Config;

class App
{
    // Application name
    public static string $appName = 'Monster Adventure';
    
    // Base URL (auto-detect or set manually)
    public static string $baseURL = '';
    
    // Session settings
    public static array $session = [
        'name' => 'refize_session',
        'lifetime' => 7200, // 2 hours
    ];
    
    // Email settings
    public static array $email = [
        'protocol' => 'smtp',
        'SMTPHost' => 'smtp.gmail.com',
        'SMTPPort' => 587,
        'SMTPUser' => 'predator7193@gmail.com',
        'SMTPPass' => 'wgoq ehkn lwfc bagm',
        'mailType' => 'html',
    ];
    
    /**
     * Get base URL
     */
    public static function baseURL(): string
    {
        if (empty(self::$baseURL)) {
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
            $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
            $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
            $scriptDir = $scriptDir === '\\' || $scriptDir === '/' ? '' : $scriptDir;
            self::$baseURL = "{$protocol}://{$host}{$scriptDir}/";
        }
        return self::$baseURL;
    }
}
