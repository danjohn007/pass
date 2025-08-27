<?php
/**
 * Home Controller
 */
class HomeController extends BaseController {
    
    public function index() {
        if ($this->isLoggedIn()) {
            $this->redirect('dashboard');
        }
        
        $this->render('home/index', [
            'title' => 'Inicio'
        ]);
    }
}
?>