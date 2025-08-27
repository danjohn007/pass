<?php
/**
 * Assessment Model
 */
class Assessment {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function getAssessmentTypes() {
        return $this->db->fetchAll("SELECT * FROM assessment_types WHERE is_active = 1");
    }
    
    public function getAssessmentByCode($code) {
        return $this->db->fetch("SELECT * FROM assessment_types WHERE code = ? AND is_active = 1", [$code]);
    }
    
    public function saveUserAssessment($userId, $assessmentTypeId, $responses, $totalScore, $severityLevel) {
        // Encrypt responses for privacy
        $encryptedResponses = $this->encryptData(json_encode($responses));
        
        $sql = "INSERT INTO user_assessments (user_id, assessment_type_id, responses, total_score, severity_level) 
                VALUES (?, ?, ?, ?, ?)";
        
        $this->db->query($sql, [
            $userId,
            $assessmentTypeId,
            $encryptedResponses,
            $totalScore,
            $severityLevel
        ]);
        
        return $this->db->lastInsertId();
    }
    
    public function getUserAssessments($userId, $limit = 10) {
        $sql = "SELECT ua.*, at.name, at.code, at.description 
                FROM user_assessments ua
                JOIN assessment_types at ON ua.assessment_type_id = at.id
                WHERE ua.user_id = ?
                ORDER BY ua.completed_at DESC
                LIMIT ?";
        
        return $this->db->fetchAll($sql, [$userId, $limit]);
    }
    
    public function getLatestAssessment($userId, $assessmentCode) {
        $sql = "SELECT ua.*, at.name, at.code, at.description 
                FROM user_assessments ua
                JOIN assessment_types at ON ua.assessment_type_id = at.id
                WHERE ua.user_id = ? AND at.code = ?
                ORDER BY ua.completed_at DESC
                LIMIT 1";
        
        return $this->db->fetch($sql, [$userId, $assessmentCode]);
    }
    
    public function calculateScore($responses, $assessmentType) {
        $scoringInfo = json_decode($assessmentType['scoring_info'], true);
        $values = $scoringInfo['values'];
        
        $totalScore = 0;
        foreach ($responses as $response) {
            $totalScore += $values[$response] ?? 0;
        }
        
        return $totalScore;
    }
    
    public function getSeverityLevel($score, $assessmentType) {
        $scoringInfo = json_decode($assessmentType['scoring_info'], true);
        $ranges = $scoringInfo['ranges'];
        
        foreach ($ranges as $level => $range) {
            if ($score >= $range[0] && $score <= $range[1]) {
                return $level;
            }
        }
        
        return 'minimal';
    }
    
    public function getAssessmentHistory($userId, $assessmentCode, $months = 6) {
        if (defined('USE_SQLITE') && USE_SQLITE) {
            $sql = "SELECT ua.total_score, ua.severity_level, ua.completed_at,
                           DATE(ua.completed_at) as assessment_date
                    FROM user_assessments ua
                    JOIN assessment_types at ON ua.assessment_type_id = at.id
                    WHERE ua.user_id = ? AND at.code = ? 
                    AND ua.completed_at >= date('now', '-{$months} months')
                    ORDER BY ua.completed_at ASC";
            return $this->db->fetchAll($sql, [$userId, $assessmentCode]);
        } else {
            $sql = "SELECT ua.total_score, ua.severity_level, ua.completed_at,
                           DATE(ua.completed_at) as assessment_date
                    FROM user_assessments ua
                    JOIN assessment_types at ON ua.assessment_type_id = at.id
                    WHERE ua.user_id = ? AND at.code = ? 
                    AND ua.completed_at >= DATE_SUB(NOW(), INTERVAL ? MONTH)
                    ORDER BY ua.completed_at ASC";
            return $this->db->fetchAll($sql, [$userId, $assessmentCode, $months]);
        }
    }
    
    public function checkCriticalLevels($userId) {
        if (defined('USE_SQLITE') && USE_SQLITE) {
            $sql = "SELECT ua.*, at.name, at.code 
                    FROM user_assessments ua
                    JOIN assessment_types at ON ua.assessment_type_id = at.id
                    WHERE ua.user_id = ? 
                    AND ua.severity_level = 'severe'
                    AND ua.completed_at >= date('now', '-7 days')
                    ORDER BY ua.completed_at DESC";
        } else {
            $sql = "SELECT ua.*, at.name, at.code 
                    FROM user_assessments ua
                    JOIN assessment_types at ON ua.assessment_type_id = at.id
                    WHERE ua.user_id = ? 
                    AND ua.severity_level = 'severe'
                    AND ua.completed_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
                    ORDER BY ua.completed_at DESC";
        }
        
        return $this->db->fetchAll($sql, [$userId]);
    }
    
    private function encryptData($data) {
        // Simple encryption for demo - use stronger encryption in production
        return base64_encode($data);
    }
    
    private function decryptData($encryptedData) {
        return base64_decode($encryptedData);
    }
    
    public function getStats() {
        $stats = [];
        
        $stats['total_assessments'] = $this->db->fetch(
            "SELECT COUNT(*) as count FROM user_assessments"
        )['count'];
        
        if (defined('USE_SQLITE') && USE_SQLITE) {
            $stats['assessments_this_month'] = $this->db->fetch(
                "SELECT COUNT(*) as count FROM user_assessments WHERE completed_at >= date('now', '-1 month')"
            )['count'];
            
            $stats['critical_cases'] = $this->db->fetch(
                "SELECT COUNT(DISTINCT user_id) as count FROM user_assessments 
                 WHERE severity_level = 'severe' AND completed_at >= date('now', '-7 days')"
            )['count'];
        } else {
            $stats['assessments_this_month'] = $this->db->fetch(
                "SELECT COUNT(*) as count FROM user_assessments WHERE completed_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)"
            )['count'];
            
            $stats['critical_cases'] = $this->db->fetch(
                "SELECT COUNT(DISTINCT user_id) as count FROM user_assessments 
                 WHERE severity_level = 'severe' AND completed_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)"
            )['count'];
        }
        
        return $stats;
    }
}
?>