<?php
/**
 * Tracking Controller
 */
class TrackingController extends BaseController {
    
    public function __construct() {
        parent::__construct();
        $this->requireAuth();
    }
    
    public function index() {
        $userId = $_SESSION['user_id'];
        
        // Get recent tracking data
        $sql = "SELECT * FROM daily_tracking 
                WHERE user_id = ? 
                ORDER BY tracking_date DESC 
                LIMIT 30";
        
        $trackingData = $this->db->fetchAll($sql, [$userId]);
        
        $this->render('tracking/index', [
            'title' => 'Seguimiento Diario',
            'trackingData' => $trackingData
        ]);
    }
    
    public function add() {
        $errors = [];
        $today = date('Y-m-d');
        
        // Check if already tracked today
        $existing = $this->db->fetch(
            "SELECT id FROM daily_tracking WHERE user_id = ? AND tracking_date = ?",
            [$_SESSION['user_id'], $today]
        );
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->sanitize($_POST);
            
            // Validate input
            $validation = $this->validateInput($_POST, [
                'mood_level' => ['required' => true, 'numeric' => true],
                'stress_level' => ['required' => true, 'numeric' => true],
                'anxiety_level' => ['required' => true, 'numeric' => true]
            ]);
            
            if (empty($validation)) {
                if ($existing) {
                    // Update existing record
                    $sql = "UPDATE daily_tracking 
                            SET mood_level = ?, stress_level = ?, anxiety_level = ?, notes = ?
                            WHERE user_id = ? AND tracking_date = ?";
                    
                    $this->db->query($sql, [
                        $data['mood_level'],
                        $data['stress_level'],
                        $data['anxiety_level'],
                        $data['notes'] ?? '',
                        $_SESSION['user_id'],
                        $today
                    ]);
                } else {
                    // Insert new record
                    $sql = "INSERT INTO daily_tracking (user_id, tracking_date, mood_level, stress_level, anxiety_level, notes)
                            VALUES (?, ?, ?, ?, ?, ?)";
                    
                    $this->db->query($sql, [
                        $_SESSION['user_id'],
                        $today,
                        $data['mood_level'],
                        $data['stress_level'],
                        $data['anxiety_level'],
                        $data['notes'] ?? ''
                    ]);
                }
                
                $this->redirect('tracking');
            } else {
                $errors = $validation;
            }
        }
        
        $this->render('tracking/add', [
            'title' => 'Registrar Estado de Ánimo',
            'errors' => $errors,
            'existing' => $existing,
            'today' => $today
        ]);
    }
}
?>