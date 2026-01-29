-- =====================================================
-- REFIZE STUDIO DATABASE SETUP
-- Monster Adventure Landing Page - CodeIgniter Edition
-- =====================================================

USE refize_studio;

-- =====================================================
-- USERS TABLE
-- =====================================================
DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    reset_token VARCHAR(255) NULL,
    reset_expires DATETIME NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_email (email),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- NEWS TABLE (Game Changelogs)
-- =====================================================
DROP TABLE IF EXISTS news;
CREATE TABLE news (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    version VARCHAR(50) NOT NULL,
    date DATE NOT NULL,
    body TEXT NOT NULL,
    thumb VARCHAR(500) NULL COMMENT 'Thumbnail image URL',
    media_type ENUM('image', 'video', 'youtube') DEFAULT 'image',
    media_url VARCHAR(500) NULL COMMENT 'Optional embedded media URL',
    is_featured BOOLEAN DEFAULT FALSE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_version (version),
    INDEX idx_date (date),
    INDEX idx_featured (is_featured)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- NEWSLETTER SUBSCRIBERS TABLE (Bonus!)
-- =====================================================
DROP TABLE IF EXISTS subscribers;
CREATE TABLE subscribers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL UNIQUE,
    is_verified BOOLEAN DEFAULT FALSE,
    subscribed_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- SEED DATA: Admin User
-- Password: admin123 (hashed with bcrypt)
-- =====================================================
INSERT INTO users (username, email, password, role) VALUES 
('Admin', 'admin@refize.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('TestUser', 'user@refize.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user');

-- =====================================================
-- SEED DATA: Sample News/Changelogs
-- =====================================================
INSERT INTO news (title, version, date, body, thumb, media_type, is_featured) VALUES 
(
    'The Great Awakening Update',
    'v2.0',
    '2025-01-15',
    'The world of Monster Adventure has never been more alive! This massive update introduces the Elder Evolution system, where your companions can now reach their ultimate forms. New biomes include the Crystal Caves and the Floating Isles. We''ve also added a complete overhaul of the combat system with elemental weaknesses and combo attacks.\n\nKey Features:\n• Elder Evolution for all starter companions\n• 2 new expansive biomes to explore\n• Revamped combat with elemental system\n• 50+ new items and equipment\n• Quality of life improvements',
    'https://images.unsplash.com/photo-1511512578047-dfb367046420?w=800',
    'image',
    TRUE
),
(
    'Companion Collection Expansion',
    'v1.8',
    '2025-01-08',
    'Meet 12 brand new companions waiting to join your adventure! From the fiery Blazekin to the mysterious Shadowmere, each new companion brings unique abilities and evolution paths. This update also introduces the Companion Bond system - the stronger your bond, the more powerful your team becomes.\n\nNew Companions:\n• Blazekin (Fire type)\n• Shadowmere (Dark type)\n• Crystalwing (Ice type)\n• And 9 more to discover!',
    'https://images.unsplash.com/photo-1550745165-9bc0b252726f?w=800',
    'image',
    FALSE
),
(
    'Winter Wonderland Event',
    'v1.7',
    '2024-12-20',
    'The snow is falling in Monster Adventure! Join our limited-time Winter Wonderland event featuring exclusive holiday-themed companions, festive decorations for your camp, and special seasonal quests. Collect Snowflake Tokens to unlock unique rewards including the legendary Frostbite Dragon!\n\nEvent Duration: Dec 20 - Jan 10\n\n• Daily login rewards\n• Exclusive winter skins\n• Snowball fight mini-game\n• Holiday music and atmosphere',
    'https://images.unsplash.com/photo-1418985991508-e47386d96a71?w=800',
    'image',
    FALSE
),
(
    'Performance & Bug Fixes',
    'v1.6.5',
    '2024-12-10',
    'This patch focuses on stability and performance improvements based on your feedback. We''ve squashed numerous bugs and optimized the game for smoother gameplay across all devices.\n\nFixes:\n• Fixed rare crash during evolution sequences\n• Improved loading times by 40%\n• Fixed inventory sorting issues\n• Resolved multiplayer sync problems\n• Various UI/UX improvements',
    'https://images.unsplash.com/photo-1504639725590-34d0984388bd?w=800',
    'image',
    FALSE
);

-- =====================================================
-- SEED DATA: Newsletter Subscribers
-- =====================================================
INSERT INTO subscribers (email, is_verified) VALUES 
('fan@example.com', TRUE),
('gamer@example.com', TRUE),
('betatester@example.com', TRUE);

-- =====================================================
-- VERIFICATION QUERY
-- =====================================================
SELECT 'Database setup complete!' AS status;
SELECT CONCAT('Users: ', COUNT(*)) AS count FROM users;
SELECT CONCAT('News: ', COUNT(*)) AS count FROM news;
SELECT CONCAT('Subscribers: ', COUNT(*)) AS count FROM subscribers;
