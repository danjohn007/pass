<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-0">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                    </h4>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($errors['login'])): ?>
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-circle me-2"></i><?= $errors['login'] ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" id="loginForm">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" 
                                   class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                                   id="email" 
                                   name="email" 
                                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                                   required>
                            <?php if (isset($errors['email'])): ?>
                                <div class="invalid-feedback">
                                    <?= $errors['email'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" 
                                   class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                                   id="password" 
                                   name="password" 
                                   required>
                            <?php if (isset($errors['password'])): ?>
                                <div class="invalid-feedback">
                                    <?= $errors['password'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                            </button>
                        </div>
                    </form>
                    
                    <hr class="my-4">
                    
                    <div class="text-center">
                        <p class="text-muted mb-0">¿No tienes una cuenta?</p>
                        <a href="<?= BASE_URL ?>/register" class="btn btn-link">
                            Registrarse aquí
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Demo credentials -->
            <div class="card mt-3">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="bi bi-info-circle me-2"></i>Credenciales de Prueba
                    </h6>
                    <small class="text-muted">
                        <strong>Usuario:</strong> user@example.com<br>
                        <strong>Admin:</strong> admin@pass.com<br>
                        <strong>Contraseña:</strong> password123
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>