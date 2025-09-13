-- LoveConnect Dating Platform Database Schema
-- This file contains the complete database structure for the dating network

CREATE DATABASE IF NOT EXISTS loveconnect_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE loveconnect_db;

-- Users table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    birth_date DATE NOT NULL,
    gender ENUM('male', 'female', 'non-binary', 'other') NOT NULL,
    looking_for ENUM('male', 'female', 'both') NOT NULL,
    bio TEXT,
    location VARCHAR(255),
    latitude DECIMAL(10, 8),
    longitude DECIMAL(11, 8),
    profile_image VARCHAR(500),
    status ENUM('active', 'inactive', 'banned', 'pending') DEFAULT 'active',
    is_premium BOOLEAN DEFAULT FALSE,
    is_verified BOOLEAN DEFAULT FALSE,
    is_online BOOLEAN DEFAULT FALSE,
    is_bot BOOLEAN DEFAULT FALSE,
    last_activity TIMESTAMP NULL,
    last_login TIMESTAMP NULL,
    email_verified_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_users_location (latitude, longitude),
    INDEX idx_users_status (status),
    INDEX idx_users_gender_looking (gender, looking_for),
    INDEX idx_users_online (is_online),
    INDEX idx_users_bot (is_bot),
    INDEX idx_users_premium (is_premium)
);

-- User profiles extended info
CREATE TABLE user_profiles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    height INT, -- in centimeters
    occupation VARCHAR(200),
    education VARCHAR(200),
    interests TEXT, -- JSON array of interests
    lifestyle JSON, -- smoking, drinking, etc.
    relationship_goals ENUM('casual', 'serious', 'marriage', 'friendship'),
    personality_traits JSON,
    languages JSON, -- array of languages spoken
    photos JSON, -- array of photo URLs
    preferences JSON, -- age range, distance, etc.
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_profile (user_id)
);

-- User photos/media
CREATE TABLE user_media (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    media_type ENUM('photo', 'video') DEFAULT 'photo',
    file_path VARCHAR(500) NOT NULL,
    caption TEXT,
    is_primary BOOLEAN DEFAULT FALSE,
    status ENUM('active', 'pending', 'rejected') DEFAULT 'pending',
    order_index INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_media_user_status (user_id, status),
    INDEX idx_media_primary (user_id, is_primary)
);

-- Matching system
CREATE TABLE matches (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user1_id INT NOT NULL,
    user2_id INT NOT NULL,
    status ENUM('pending', 'matched', 'rejected', 'blocked') DEFAULT 'pending',
    compatibility_score DECIMAL(5,2), -- 0-100 compatibility percentage
    matched_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user1_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (user2_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_match (user1_id, user2_id),
    INDEX idx_matches_user1_status (user1_id, status),
    INDEX idx_matches_user2_status (user2_id, status),
    INDEX idx_matches_compatibility (compatibility_score DESC)
);

-- Likes and swipes
CREATE TABLE user_likes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    liker_id INT NOT NULL,
    liked_id INT NOT NULL,
    like_type ENUM('like', 'super_like', 'pass') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (liker_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (liked_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_like (liker_id, liked_id),
    INDEX idx_likes_liked_type (liked_id, like_type),
    INDEX idx_likes_liker (liker_id)
);

-- Conversations/Chat
CREATE TABLE conversations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user1_id INT NOT NULL,
    user2_id INT NOT NULL,
    status ENUM('active', 'archived', 'blocked') DEFAULT 'active',
    last_message_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user1_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (user2_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_conversation (user1_id, user2_id),
    INDEX idx_conversations_user1 (user1_id),
    INDEX idx_conversations_user2 (user2_id),
    INDEX idx_conversations_last_message (last_message_at DESC)
);

-- Messages
CREATE TABLE messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    conversation_id INT NOT NULL,
    sender_id INT NOT NULL,
    content TEXT NOT NULL,
    message_type ENUM('text', 'image', 'gif', 'emoji', 'file', 'location') DEFAULT 'text',
    file_path VARCHAR(500),
    is_read BOOLEAN DEFAULT FALSE,
    read_at TIMESTAMP NULL,
    is_ai_generated BOOLEAN DEFAULT FALSE,
    ai_context JSON, -- Store AI context/prompts
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (conversation_id) REFERENCES conversations(id) ON DELETE CASCADE,
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_messages_conversation (conversation_id, created_at),
    INDEX idx_messages_sender (sender_id),
    INDEX idx_messages_unread (conversation_id, is_read, created_at),
    FULLTEXT(content)
);

-- Posts/Social Feed
CREATE TABLE posts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    content TEXT,
    media_urls JSON, -- Array of image/video URLs
    post_type ENUM('text', 'image', 'video', 'story') DEFAULT 'text',
    location VARCHAR(255),
    privacy ENUM('public', 'friends', 'private') DEFAULT 'public',
    status ENUM('published', 'draft', 'deleted') DEFAULT 'published',
    likes_count INT DEFAULT 0,
    comments_count INT DEFAULT 0,
    shares_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_posts_user_status (user_id, status),
    INDEX idx_posts_type_created (post_type, created_at DESC),
    INDEX idx_posts_public_created (privacy, status, created_at DESC),
    FULLTEXT(content)
);

-- Post interactions (likes, comments)
CREATE TABLE post_interactions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    interaction_type ENUM('like', 'comment', 'share', 'report') NOT NULL,
    content TEXT, -- For comments
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_like (post_id, user_id, interaction_type),
    INDEX idx_interactions_post_type (post_id, interaction_type),
    INDEX idx_interactions_user (user_id)
);

-- Events/Dates
CREATE TABLE events (
    id INT PRIMARY KEY AUTO_INCREMENT,
    creator_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    event_type ENUM('date', 'meetup', 'group_date', 'virtual') NOT NULL,
    location VARCHAR(255),
    latitude DECIMAL(10, 8),
    longitude DECIMAL(11, 8),
    start_date DATETIME NOT NULL,
    end_date DATETIME,
    max_participants INT,
    is_private BOOLEAN DEFAULT FALSE,
    status ENUM('active', 'cancelled', 'completed') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (creator_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_events_creator (creator_id),
    INDEX idx_events_date_status (start_date, status),
    INDEX idx_events_location (latitude, longitude)
);

-- Event participants
CREATE TABLE event_participants (
    id INT PRIMARY KEY AUTO_INCREMENT,
    event_id INT NOT NULL,
    user_id INT NOT NULL,
    status ENUM('invited', 'accepted', 'declined', 'maybe') DEFAULT 'invited',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_participation (event_id, user_id),
    INDEX idx_participants_event_status (event_id, status),
    INDEX idx_participants_user (user_id)
);

-- AI Bot Management
CREATE TABLE bot_profiles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    personality_type VARCHAR(100), -- friendly, flirty, professional, etc.
    interaction_patterns JSON, -- response patterns, timing, etc.
    active_hours JSON, -- when the bot should be online
    target_demographics JSON, -- which users to interact with
    conversation_starters JSON, -- array of opening messages
    response_templates JSON, -- template responses for different scenarios
    chatgpt_context TEXT, -- context for ChatGPT API
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_bot_profile (user_id),
    INDEX idx_bot_active (is_active)
);

-- Bot activity logs
CREATE TABLE bot_activities (
    id INT PRIMARY KEY AUTO_INCREMENT,
    bot_id INT NOT NULL,
    activity_type ENUM('login', 'logout', 'like', 'message', 'post', 'profile_view') NOT NULL,
    target_user_id INT,
    activity_data JSON, -- additional activity details
    success BOOLEAN DEFAULT TRUE,
    error_message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (bot_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (target_user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_bot_activities_bot_type (bot_id, activity_type),
    INDEX idx_bot_activities_target (target_user_id),
    INDEX idx_bot_activities_created (created_at DESC)
);

-- Notifications
CREATE TABLE notifications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    type ENUM('match', 'message', 'like', 'profile_view', 'event_invite', 'system') NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT,
    data JSON, -- additional notification data
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_notifications_user_unread (user_id, is_read),
    INDEX idx_notifications_type_created (type, created_at DESC)
);

-- User reports and moderation
CREATE TABLE user_reports (
    id INT PRIMARY KEY AUTO_INCREMENT,
    reporter_id INT NOT NULL,
    reported_id INT NOT NULL,
    report_type ENUM('spam', 'harassment', 'fake_profile', 'inappropriate_content', 'other') NOT NULL,
    description TEXT,
    status ENUM('pending', 'reviewed', 'resolved', 'dismissed') DEFAULT 'pending',
    admin_notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (reporter_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (reported_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_reports_reported_status (reported_id, status),
    INDEX idx_reports_type_status (report_type, status),
    INDEX idx_reports_created (created_at DESC)
);

-- Premium subscriptions
CREATE TABLE subscriptions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    plan_type ENUM('basic', 'premium', 'premium_plus') NOT NULL,
    status ENUM('active', 'expired', 'cancelled', 'pending') NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    amount DECIMAL(10, 2),
    payment_method VARCHAR(100),
    stripe_subscription_id VARCHAR(255),
    auto_renew BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_active_subscription (user_id, status),
    INDEX idx_subscriptions_user_status (user_id, status),
    INDEX idx_subscriptions_end_date (end_date)
);

-- Analytics and metrics
CREATE TABLE user_analytics (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    date DATE NOT NULL,
    profile_views INT DEFAULT 0,
    likes_received INT DEFAULT 0,
    likes_given INT DEFAULT 0,
    messages_sent INT DEFAULT 0,
    messages_received INT DEFAULT 0,
    matches_made INT DEFAULT 0,
    login_count INT DEFAULT 0,
    time_spent_minutes INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_date (user_id, date),
    INDEX idx_analytics_date (date),
    INDEX idx_analytics_user_date (user_id, date)
);

-- Insert sample data for testing
-- Sample users (including demo account)
INSERT INTO users (username, email, password, first_name, last_name, birth_date, gender, looking_for, bio, is_premium) VALUES
('demo_user', 'demo@loveconnect.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Demo', 'User', '1995-06-15', 'female', 'male', 'Just testing the platform! Love hiking and coffee dates.', TRUE),
('sophia_ai', 'sophia@loveconnect.ai', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Sophia', 'Martinez', '1994-03-22', 'female', 'male', 'AI Assistant here to help with your dating journey! Love giving relationship advice and planning perfect dates.', FALSE),
('alex_ai', 'alex@loveconnect.ai', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Alex', 'Thompson', '1992-08-10', 'male', 'female', 'Adventure seeker and conversation starter! Always up for exploring new places and meeting interesting people.', FALSE);

-- Update AI users to be marked as bots
UPDATE users SET is_bot = TRUE WHERE email LIKE '%@loveconnect.ai';

-- Sample bot profiles
INSERT INTO bot_profiles (user_id, personality_type, active_hours, chatgpt_context, is_active) VALUES
((SELECT id FROM users WHERE email = 'sophia@loveconnect.ai'), 'supportive_advisor', '["09:00-23:00"]', 'You are Sophia, a friendly and supportive AI dating assistant. You provide helpful dating advice, conversation tips, and emotional support. You are warm, understanding, and always encouraging.', TRUE),
((SELECT id FROM users WHERE email = 'alex@loveconnect.ai'), 'adventurous_friend', '["10:00-22:00"]', 'You are Alex, an adventurous and outgoing AI companion. You love outdoor activities, travel, and meeting new people. You are energetic, positive, and always ready for new experiences.', TRUE);

-- Sample matches
INSERT INTO matches (user1_id, user2_id, status, compatibility_score, matched_at) VALUES
(1, 2, 'matched', 95.50, NOW()),
(1, 3, 'matched', 88.25, NOW());

-- Sample conversations
INSERT INTO conversations (user1_id, user2_id, status, last_message_at) VALUES
(1, 2, 'active', NOW()),
(1, 3, 'active', NOW());

-- Sample messages
INSERT INTO messages (conversation_id, sender_id, content, is_ai_generated, created_at) VALUES
(1, 2, 'Hi! I\'m Sophia, your AI dating assistant! 👋 I\'m here to help you have better conversations and give dating advice. What would you like to chat about?', TRUE, NOW()),
(1, 1, 'Hi Sophia! I\'m nervous about my first date tomorrow. Any tips?', FALSE, NOW()),
(1, 2, 'Absolutely! Here are my top first date tips: 1) Be yourself - authenticity is attractive 2) Ask open-ended questions to show genuine interest 3) Choose a comfortable location 4) Put your phone away and be present 5) Listen actively and find common interests. What kind of date are you planning? ✨', TRUE, NOW()),
(2, 3, 'Hey there! Thanks for matching with me! I love your adventure photos - that hiking shot is amazing! 🏔️', TRUE, NOW());

-- Sample posts
INSERT INTO posts (user_id, content, post_type, likes_count, comments_count) VALUES
(2, 'Just had the most amazing coffee date at that little café downtown! ☕️ Sometimes the best connections happen when you least expect them. What\'s your favorite first date spot? 💕', 'text', 24, 8),
(3, 'Weekend hiking adventure complete! 🏔️ There\'s something magical about watching the sunrise from a mountain peak. Who else loves outdoor adventures? Looking for a hiking buddy! 🥾✨', 'text', 31, 12);

-- Update conversation last message times
UPDATE conversations c 
SET last_message_at = (
    SELECT MAX(created_at) 
    FROM messages m 
    WHERE m.conversation_id = c.id
);

-- Create indexes for better performance
CREATE INDEX idx_users_age ON users (birth_date);
CREATE INDEX idx_users_location_active ON users (latitude, longitude, status, is_online);
CREATE INDEX idx_messages_conversation_unread ON messages (conversation_id, is_read, created_at);
CREATE INDEX idx_posts_feed ON posts (status, privacy, created_at DESC);

COMMIT;