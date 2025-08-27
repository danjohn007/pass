<?php
/**
 * User Model
 */
class User {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function create($data) {
        $sql = "INSERT INTO users (email, password_hash, first_name, last_name, age, gender, country, consent_given) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $this->db->query($sql, [
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['first_name'],
            $data['last_name'],
            $data['age'] ?? null,
            $data['gender'] ?? null,
            $data['country'] ?? null,
            $data['consent_given'] ?? false
        ]);
        
        return $this->db->lastInsertId();
    }
    
    public function findByEmail($email) {
        return $this->db->fetch("SELECT * FROM users WHERE email = ?", [$email]);
    }
    
    public function findById($id) {
        return $this->db->fetch("SELECT * FROM users WHERE id = ?", [$id]);
    }
    
    public function updateLastLogin($userId) {
        $this->db->query("UPDATE users SET last_login = NOW() WHERE id = ?", [$userId]);
    }
    
    public function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
    
    public function emailExists($email) {
        $user = $this->findByEmail($email);
        return $user !== false;
    }
    
    public function update($userId, $data) {
        $fields = [];
        $values = [];
        
        $allowedFields = ['first_name', 'last_name', 'age', 'gender', 'country'];
        
        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                $fields[] = $field . ' = ?';
                $values[] = $data[$field];
            }
        }
        
        if (!empty($fields)) {
            $values[] = $userId;
            $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?";
            $this->db->query($sql, $values);
        }
    }
    
    public function getStats() {
        $stats = [];
        
        $stats['total_users'] = $this->db->fetch("SELECT COUNT(*) as count FROM users")['count'];
        $stats['active_users'] = $this->db->fetch("SELECT COUNT(*) as count FROM users WHERE is_active = 1")['count'];
        $stats['new_users_month'] = $this->db->fetch(
            "SELECT COUNT(*) as count FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)"
        )['count'];
        
        return $stats;
    }
}
?>