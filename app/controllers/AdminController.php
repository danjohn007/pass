<?php
/**
 * Admin Controller
 */
class AdminController extends BaseController {
    private $userModel;
    private $assessmentModel;
    
    public function __construct() {
        parent::__construct();
        $this->requireAdmin();
        $this->userModel = new User();
        $this->assessmentModel = new Assessment();
    }
    
    public function index() {
        // Get system statistics
        $userStats = $this->userModel->getStats();
        $assessmentStats = $this->assessmentModel->getStats();
        
        // Get recent users
        $recentUsers = $this->db->fetchAll(
            "SELECT id, email, first_name, last_name, created_at, last_login 
             FROM users 
             WHERE role = 'user' 
             ORDER BY created_at DESC 
             LIMIT 10"
        );
        
        // Get recent assessments
        $recentAssessments = $this->db->fetchAll(
            "SELECT ua.*, u.first_name, u.last_name, at.name as assessment_name
             FROM user_assessments ua
             JOIN users u ON ua.user_id = u.id
             JOIN assessment_types at ON ua.assessment_type_id = at.id
             ORDER BY ua.completed_at DESC
             LIMIT 10"
        );
        
        $this->render('admin/index', [
            'title' => 'Panel de Administración',
            'userStats' => $userStats,
            'assessmentStats' => $assessmentStats,
            'recentUsers' => $recentUsers,
            'recentAssessments' => $recentAssessments
        ]);
    }
}
?>