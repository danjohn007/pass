<?php
/**
 * Authentication Controller
 */
class AuthController extends BaseController {
    private $userModel;
    
    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
    }
    
    public function login() {
        if ($this->isLoggedIn()) {
            $this->redirect('dashboard');
        }
        
        $errors = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $this->sanitize($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            
            // Validate input
            $validation = $this->validateInput($_POST, [
                'email' => ['required' => true, 'email' => true],
                'password' => ['required' => true]
            ]);
            
            if (empty($validation)) {
                $user = $this->userModel->findByEmail($email);
                
                if ($user && $this->userModel->verifyPassword($password, $user['password_hash'])) {
                    // Set session data
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
                    $_SESSION['role'] = $user['role'];
                    
                    // Update last login
                    $this->userModel->updateLastLogin($user['id']);
                    
                    $this->redirect('dashboard');
                } else {
                    $errors['login'] = 'Email o contraseña incorrectos';
                }
            } else {
                $errors = $validation;
            }
        }
        
        $this->render('auth/login', ['errors' => $errors]);
    }
    
    public function register() {
        if ($this->isLoggedIn()) {
            $this->redirect('dashboard');
        }
        
        $errors = [];
        $formData = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formData = $this->sanitize($_POST);
            
            // Validate input
            $validation = $this->validateInput($_POST, [
                'email' => ['required' => true, 'email' => true],
                'password' => ['required' => true, 'min' => PASSWORD_MIN_LENGTH],
                'password_confirm' => ['required' => true],
                'first_name' => ['required' => true, 'min' => 2, 'max' => 100],
                'last_name' => ['required' => true, 'min' => 2, 'max' => 100],
                'consent_given' => ['required' => true]
            ]);
            
            if (empty($validation)) {
                // Check if passwords match
                if ($_POST['password'] !== $_POST['password_confirm']) {
                    $errors['password_confirm'] = 'Las contraseñas no coinciden';
                }
                
                // Check if email already exists
                if ($this->userModel->emailExists($formData['email'])) {
                    $errors['email'] = 'Este email ya está registrado';
                }
                
                // Check consent
                if (!isset($_POST['consent_given'])) {
                    $errors['consent_given'] = 'Debe aceptar el consentimiento informado';
                }
                
                if (empty($errors)) {
                    // Create user
                    $userData = [
                        'email' => $formData['email'],
                        'password' => $_POST['password'],
                        'first_name' => $formData['first_name'],
                        'last_name' => $formData['last_name'],
                        'age' => $formData['age'] ?? null,
                        'gender' => $formData['gender'] ?? null,
                        'country' => $formData['country'] ?? null,
                        'consent_given' => true
                    ];
                    
                    $userId = $this->userModel->create($userData);
                    
                    if ($userId) {
                        // Auto login
                        $_SESSION['user_id'] = $userId;
                        $_SESSION['user_email'] = $userData['email'];
                        $_SESSION['user_name'] = $userData['first_name'] . ' ' . $userData['last_name'];
                        $_SESSION['role'] = 'user';
                        
                        $this->redirect('dashboard');
                    } else {
                        $errors['general'] = 'Error al crear la cuenta. Inténtelo de nuevo.';
                    }
                }
            } else {
                $errors = $validation;
            }
        }
        
        $this->render('auth/register', ['errors' => $errors, 'formData' => $formData]);
    }
    
    public function logout() {
        session_destroy();
        $this->redirect('home');
    }
}
?>