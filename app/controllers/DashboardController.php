<?php
/**
 * Dashboard Controller
 */
class DashboardController extends BaseController {
    private $assessmentModel;
    
    public function __construct() {
        parent::__construct();
        $this->requireAuth();
        $this->assessmentModel = new Assessment();
    }
    
    public function index() {
        $userId = $_SESSION['user_id'];
        
        // Get recent assessments
        $recentAssessments = $this->assessmentModel->getUserAssessments($userId, 5);
        
        // Get assessment types available
        $assessmentTypes = $this->assessmentModel->getAssessmentTypes();
        
        // Check for critical levels
        $criticalAssessments = $this->assessmentModel->checkCriticalLevels($userId);
        
        // Get latest scores for each assessment type
        $latestScores = [];
        foreach ($assessmentTypes as $type) {
            $latest = $this->assessmentModel->getLatestAssessment($userId, $type['code']);
            if ($latest) {
                $latestScores[$type['code']] = $latest;
            }
        }
        
        // Get daily tracking if exists
        $dailyTracking = $this->getDailyTrackingData($userId);
        
        $this->render('dashboard/index', [
            'title' => 'Dashboard',
            'recentAssessments' => $recentAssessments,
            'assessmentTypes' => $assessmentTypes,
            'criticalAssessments' => $criticalAssessments,
            'latestScores' => $latestScores,
            'dailyTracking' => $dailyTracking
        ]);
    }
    
    private function getDailyTrackingData($userId) {
        $sql = "SELECT * FROM daily_tracking 
                WHERE user_id = ? 
                ORDER BY tracking_date DESC 
                LIMIT 7";
        
        return $this->db->fetchAll($sql, [$userId]);
    }
}
?>