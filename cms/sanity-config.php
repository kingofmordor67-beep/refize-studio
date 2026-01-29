<?php
/**
 * Sanity CMS Configuration
 * 
 * Instructions to set up Sanity CMS:
 * 1. Go to https://www.sanity.io/ and create a free account
 * 2. Create a new project (use the "Clean project with no predefined schemas" template)
 * 3. In your Sanity Studio, create a schema for "news" with fields:
 *    - title (string)
 *    - version (string)
 *    - date (date)
 *    - thumb (image or url)
 *    - body (text)
 * 4. Get your Project ID from the project settings
 * 5. Create a read-only API token for public access
 * 6. Create a write token for admin operations
 * 7. Update the values below with your credentials
 */

return [
    // Sanity Project ID - Get this from your Sanity project settings
    'project_id' => 'qjlvyi8k',
    
    // Sanity Dataset - Usually 'production'
    'dataset' => 'production',
    
    // API Version - Use current date format
    'api_version' => '2026-01-28',
    
    // Read Token (for public API access) - Can be empty if dataset is public
    'read_token' => '',
    
    // Write Token (for admin operations) - Keep this secret!
    'write_token' => 'sk2y4hNfi2JLjM9ffmsekvNHAISFSn0IyKiOpy5CmHhsCLfxQgiLM5BhTg6ptu6TwQpJ4WNDhDR6HrQN56Fkdu57n5fkZPlQHclegvu1h70gCG6qIKNbfyvz138Dt8ehQ3n9YLmzJ6k9WAj6Br6NdqLmQljB8rmnmbeDNafKMLZ9OqN98Gsg',
    
    // Admin Key - Used to access the CMS admin interface
    // Change this to a secure random string!
    'admin_key' => 'monster-adventure-cms-2026',
    
    // CDN URL for Sanity
    'cdn_url' => 'https://cdn.sanity.io',
];
