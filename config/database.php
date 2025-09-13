<?php
/**
 * Database Configuration for LoveConnect
 * 
 * This file contains database connection settings and utility functions
 * for the LoveConnect dating platform.
 */

// Database configuration constants
define('DB_HOST', 'localhost');
define('DB_NAME', 'loveconnect_db');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
            ];
            
            $this->connection = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    // Prevent cloning and serialization
    private function __clone() {}
    public function __wakeup() {}
}

/**
 * Get database connection instance
 */
function getDB() {
    return Database::getInstance()->getConnection();
}

/**
 * Execute a prepared statement with parameters
 */
function executeQuery($query, $params = []) {
    try {
        $db = getDB();
        $stmt = $db->prepare($query);
        $stmt->execute($params);
        return $stmt;
    } catch (PDOException $e) {
        error_log("Query execution failed: " . $e->getMessage());
        return false;
    }
}

/**
 * Fetch a single row from database
 */
function fetchOne($query, $params = []) {
    $stmt = executeQuery($query, $params);
    return $stmt ? $stmt->fetch() : false;
}

/**
 * Fetch multiple rows from database
 */
function fetchAll($query, $params = []) {
    $stmt = executeQuery($query, $params);
    return $stmt ? $stmt->fetchAll() : false;
}

/**
 * Insert data and return last insert ID
 */
function insertData($table, $data) {
    $columns = implode(',', array_keys($data));
    $placeholders = ':' . implode(', :', array_keys($data));
    $query = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
    
    $stmt = executeQuery($query, $data);
    return $stmt ? getDB()->lastInsertId() : false;
}

/**
 * Update data in table
 */
function updateData($table, $data, $conditions) {
    $setClause = [];
    foreach ($data as $key => $value) {
        $setClause[] = "{$key} = :{$key}";
    }
    $setClause = implode(', ', $setClause);
    
    $whereClause = [];
    foreach ($conditions as $key => $value) {
        $whereClause[] = "{$key} = :where_{$key}";
        $data["where_{$key}"] = $value;
    }
    $whereClause = implode(' AND ', $whereClause);
    
    $query = "UPDATE {$table} SET {$setClause} WHERE {$whereClause}";
    return executeQuery($query, $data);
}

/**
 * Delete data from table
 */
function deleteData($table, $conditions) {
    $whereClause = [];
    foreach ($conditions as $key => $value) {
        $whereClause[] = "{$key} = :{$key}";
    }
    $whereClause = implode(' AND ', $whereClause);
    
    $query = "DELETE FROM {$table} WHERE {$whereClause}";
    return executeQuery($query, $conditions);
}

/**
 * Check if table exists
 */
function tableExists($tableName) {
    $query = "SHOW TABLES LIKE :table_name";
    $result = fetchOne($query, ['table_name' => $tableName]);
    return $result !== false;
}

/**
 * Get user by email
 */
function getUserByEmail($email) {
    return fetchOne("SELECT * FROM users WHERE email = :email", ['email' => $email]);
}

/**
 * Get user by ID
 */
function getUserById($id) {
    return fetchOne("SELECT * FROM users WHERE id = :id", ['id' => $id]);
}

/**
 * Create new user
 */
function createUser($userData) {
    // Hash password before storing
    if (isset($userData['password'])) {
        $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
    }
    
    // Add timestamps
    $userData['created_at'] = date('Y-m-d H:i:s');
    $userData['updated_at'] = date('Y-m-d H:i:s');
    
    return insertData('users', $userData);
}

/**
 * Verify user password
 */
function verifyUserPassword($email, $password) {
    $user = getUserByEmail($email);
    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }
    return false;
}

/**
 * Update user last login
 */
function updateUserLogin($userId) {
    return updateData('users', 
        ['last_login' => date('Y-m-d H:i:s')], 
        ['id' => $userId]
    );
}

/**
 * Get recent posts for feed
 */
function getRecentPosts($limit = 10, $offset = 0) {
    $query = "SELECT p.*, u.username, u.profile_image 
              FROM posts p 
              JOIN users u ON p.user_id = u.id 
              WHERE p.status = 'published' 
              ORDER BY p.created_at DESC 
              LIMIT :limit OFFSET :offset";
    
    return fetchAll($query, ['limit' => $limit, 'offset' => $offset]);
}

/**
 * Get matches for user
 */
function getUserMatches($userId, $limit = 10) {
    $query = "SELECT u.*, m.compatibility_score 
              FROM matches m 
              JOIN users u ON (m.user2_id = u.id AND m.user1_id = :user_id) 
                           OR (m.user1_id = u.id AND m.user2_id = :user_id)
              WHERE m.status = 'matched' 
              ORDER BY m.created_at DESC 
              LIMIT :limit";
    
    return fetchAll($query, ['user_id' => $userId, 'limit' => $limit]);
}

/**
 * Get chat conversations for user
 */
function getUserConversations($userId) {
    $query = "SELECT c.*, u.username, u.profile_image, u.is_online,
              (SELECT content FROM messages 
               WHERE conversation_id = c.id 
               ORDER BY created_at DESC 
               LIMIT 1) as last_message,
              (SELECT created_at FROM messages 
               WHERE conversation_id = c.id 
               ORDER BY created_at DESC 
               LIMIT 1) as last_message_time
              FROM conversations c
              JOIN users u ON (c.user1_id = u.id AND c.user2_id = :user_id)
                           OR (c.user2_id = u.id AND c.user1_id = :user_id)
              WHERE c.user1_id = :user_id OR c.user2_id = :user_id
              ORDER BY last_message_time DESC";
    
    return fetchAll($query, ['user_id' => $userId]);
}

/**
 * Get chat messages
 */
function getChatMessages($conversationId, $limit = 50) {
    $query = "SELECT m.*, u.username, u.profile_image 
              FROM messages m 
              JOIN users u ON m.sender_id = u.id 
              WHERE m.conversation_id = :conversation_id 
              ORDER BY m.created_at ASC 
              LIMIT :limit";
    
    return fetchAll($query, ['conversation_id' => $conversationId, 'limit' => $limit]);
}

/**
 * Send message
 */
function sendMessage($conversationId, $senderId, $content, $messageType = 'text') {
    return insertData('messages', [
        'conversation_id' => $conversationId,
        'sender_id' => $senderId,
        'content' => $content,
        'message_type' => $messageType,
        'created_at' => date('Y-m-d H:i:s')
    ]);
}

/**
 * Create or get conversation between two users
 */
function getOrCreateConversation($user1Id, $user2Id) {
    // Check if conversation already exists
    $query = "SELECT * FROM conversations 
              WHERE (user1_id = :user1_id AND user2_id = :user2_id)
                 OR (user1_id = :user2_id AND user2_id = :user1_id)";
    
    $conversation = fetchOne($query, ['user1_id' => $user1Id, 'user2_id' => $user2Id]);
    
    if (!$conversation) {
        // Create new conversation
        $conversationId = insertData('conversations', [
            'user1_id' => $user1Id,
            'user2_id' => $user2Id,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        return $conversationId;
    }
    
    return $conversation['id'];
}

/**
 * Update user online status
 */
function updateUserOnlineStatus($userId, $isOnline = true) {
    return updateData('users', 
        [
            'is_online' => $isOnline ? 1 : 0,
            'last_activity' => date('Y-m-d H:i:s')
        ], 
        ['id' => $userId]
    );
}

/**
 * Get bot users (AI assistants)
 */
function getBotUsers() {
    return fetchAll("SELECT * FROM users WHERE is_bot = 1 AND status = 'active'");
}

/**
 * Log bot activity
 */
function logBotActivity($botId, $activity, $targetUserId = null) {
    return insertData('bot_activities', [
        'bot_id' => $botId,
        'activity' => $activity,
        'target_user_id' => $targetUserId,
        'created_at' => date('Y-m-d H:i:s')
    ]);
}

?>