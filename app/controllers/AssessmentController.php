<?php
/**
 * Assessment Controller
 */
class AssessmentController extends BaseController {
    private $assessmentModel;
    
    public function __construct() {
        parent::__construct();
        $this->requireAuth();
        $this->assessmentModel = new Assessment();
    }
    
    public function take($assessmentCode) {
        $assessmentType = $this->assessmentModel->getAssessmentByCode($assessmentCode);
        
        if (!$assessmentType) {
            http_response_code(404);
            $this->render('errors/404');
            return;
        }
        
        $errors = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $responses = $_POST['responses'] ?? [];
            
            // Validate responses
            $questions = json_decode($assessmentType['questions'], true);
            if (count($responses) !== count($questions)) {
                $errors['general'] = 'Por favor responde todas las preguntas.';
            } else {
                // Calculate score
                $totalScore = $this->assessmentModel->calculateScore($responses, $assessmentType);
                $severityLevel = $this->assessmentModel->getSeverityLevel($totalScore, $assessmentType);
                
                // Save assessment
                $assessmentId = $this->assessmentModel->saveUserAssessment(
                    $_SESSION['user_id'],
                    $assessmentType['id'],
                    $responses,
                    $totalScore,
                    $severityLevel
                );
                
                // Check if critical level and create alert
                if ($severityLevel === 'severe') {
                    $this->createCriticalAlert($_SESSION['user_id'], $assessmentType['name'], $totalScore);
                }
                
                // Redirect to results
                $this->redirect("assessment/{$assessmentCode}/result?id={$assessmentId}");
            }
        }
        
        $this->render('assessment/take', [
            'title' => $assessmentType['name'],
            'assessmentType' => $assessmentType,
            'errors' => $errors
        ]);
    }
    
    public function result($assessmentCode) {
        $assessmentId = $_GET['id'] ?? null;
        if (!$assessmentId) {
            $this->redirect('dashboard');
            return;
        }
        
        // Get assessment result
        $sql = "SELECT ua.*, at.name, at.code, at.description, at.scoring_info
                FROM user_assessments ua
                JOIN assessment_types at ON ua.assessment_type_id = at.id
                WHERE ua.id = ? AND ua.user_id = ?";
        
        $result = $this->db->fetch($sql, [$assessmentId, $_SESSION['user_id']]);
        
        if (!$result) {
            $this->redirect('dashboard');
            return;
        }
        
        // Get interpretation and recommendations
        $interpretation = $this->getInterpretation($result['severity_level'], $result['code']);
        $recommendations = $this->getRecommendations($result['severity_level'], $result['code']);
        
        // Get historical data for comparison
        $history = $this->assessmentModel->getAssessmentHistory($_SESSION['user_id'], $result['code'], 6);
        
        $this->render('assessment/result', [
            'title' => 'Resultado de ' . $result['name'],
            'result' => $result,
            'interpretation' => $interpretation,
            'recommendations' => $recommendations,
            'history' => $history
        ]);
    }
    
    private function createCriticalAlert($userId, $assessmentName, $score) {
        $sql = "INSERT INTO alerts (user_id, alert_type, message) VALUES (?, ?, ?)";
        $message = "Nivel crítico detectado en {$assessmentName} (Puntuación: {$score}). Se recomienda buscar ayuda profesional.";
        
        $this->db->query($sql, [$userId, 'crisis_risk', $message]);
    }
    
    private function getInterpretation($severityLevel, $assessmentCode) {
        $interpretations = [
            'GAD7' => [
                'minimal' => 'Tus niveles de ansiedad están en el rango mínimo. Esto sugiere que experimentas muy pocos síntomas de ansiedad en tu vida diaria.',
                'mild' => 'Presentas síntomas leves de ansiedad. Aunque no son severos, es importante prestar atención a tu bienestar emocional.',
                'moderate' => 'Tus síntomas de ansiedad están en un nivel moderado. Te recomendamos considerar estrategias de manejo del estrés y posiblemente buscar apoyo.',
                'severe' => 'Los resultados indican síntomas severos de ansiedad que pueden estar afectando significativamente tu vida diaria. Es importante buscar ayuda profesional.'
            ],
            'PHQ9' => [
                'minimal' => 'Tus niveles de estado de ánimo están en el rango normal. Esto sugiere un buen bienestar emocional general.',
                'mild' => 'Presentas algunos síntomas que podrían afectar tu estado de ánimo. Mantén un seguimiento de cómo te sientes.',
                'moderate' => 'Tus síntomas sugieren un impacto moderado en tu estado de ánimo. Considera implementar estrategias de autocuidado y buscar apoyo.',
                'severe' => 'Los resultados indican síntomas que requieren atención inmediata. Es crucial buscar ayuda profesional de un psicólogo o psiquiatra.'
            ]
        ];
        
        return $interpretations[$assessmentCode][$severityLevel] ?? 'Interpretación no disponible.';
    }
    
    private function getRecommendations($severityLevel, $assessmentCode) {
        $recommendations = [
            'minimal' => [
                'Mantén hábitos saludables como ejercicio regular y sueño adecuado',
                'Practica técnicas de mindfulness o meditación',
                'Continúa monitoreando tu bienestar mental regularmente'
            ],
            'mild' => [
                'Implementa técnicas de relajación como respiración profunda',
                'Considera hablar con amigos, familia o un consejero',
                'Mantén una rutina diaria estructurada',
                'Limita el consumo de cafeína y alcohol'
            ],
            'moderate' => [
                'Busca apoyo de un profesional de salud mental',
                'Practica ejercicios de respiración y mindfulness diariamente',
                'Considera terapia cognitivo-conductual',
                'Mantén un diario de emociones y pensamientos'
            ],
            'severe' => [
                'Busca ayuda profesional inmediatamente',
                'Contacta a un psicólogo, psiquiatra o línea de crisis',
                'No enfrentes esto solo - busca apoyo de familiares y amigos',
                'Considera opciones de tratamiento intensivo si es necesario'
            ]
        ];
        
        return $recommendations[$severityLevel] ?? [];
    }
}
?>