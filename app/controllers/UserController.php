<?php
/**
 * User Controller
 */
class UserController extends BaseController {
    private $userModel;
    
    public function __construct() {
        parent::__construct();
        $this->requireAuth();
        $this->userModel = new User();
    }
    
    public function profile() {
        $user = $this->getCurrentUser();
        $errors = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->sanitize($_POST);
            
            // Validate input
            $validation = $this->validateInput($_POST, [
                'first_name' => ['required' => true, 'min' => 2, 'max' => 100],
                'last_name' => ['required' => true, 'min' => 2, 'max' => 100]
            ]);
            
            if (empty($validation)) {
                $this->userModel->update($_SESSION['user_id'], $data);
                $_SESSION['user_name'] = $data['first_name'] . ' ' . $data['last_name'];
                $user = $this->getCurrentUser(); // Refresh user data
                
                $success = 'Perfil actualizado exitosamente';
            } else {
                $errors = $validation;
            }
        }
        
        $this->render('user/profile', [
            'title' => 'Mi Perfil',
            'user' => $user,
            'errors' => $errors,
            'success' => $success ?? null
        ]);
    }
}
?>