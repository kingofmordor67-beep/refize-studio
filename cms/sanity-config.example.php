<?php
/**
 * Konfigurasi Sanity CMS (Contoh)
 * 
 * Salin file ini menjadi 'sanity-config.php' dan isi dengan kredensial Anda.
 */

return [
    // Sanity Project ID
    'project_id' => 'YOUR_PROJECT_ID',
    
    // Sanity Dataset
    'dataset' => 'production',
    
    // API Version
    'api_version' => '2026-01-28',
    
    // Read Token (opsional jika dataset public)
    'read_token' => '',
    
    // Write Token (RAHASIA - Jangan di-commit!)
    'write_token' => 'YOUR_WRITE_TOKEN_HERE',
    
    // Admin Key (untuk akses CMS lokal)
    'admin_key' => 'YOUR_SECRET_ADMIN_KEY',
    
    // CDN URL
    'cdn_url' => 'https://cdn.sanity.io',
];
