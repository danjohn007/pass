<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-0">
                        <i class="bi bi-person-plus me-2"></i>Crear Cuenta
                    </h4>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($errors['general'])): ?>
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-circle me-2"></i><?= $errors['general'] ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" id="registerForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">Nombre *</label>
                                <input type="text" 
                                       class="form-control <?= isset($errors['first_name']) ? 'is-invalid' : '' ?>" 
                                       id="first_name" 
                                       name="first_name" 
                                       value="<?= htmlspecialchars($formData['first_name'] ?? '') ?>"
                                       required>
                                <?php if (isset($errors['first_name'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $errors['first_name'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Apellido *</label>
                                <input type="text" 
                                       class="form-control <?= isset($errors['last_name']) ? 'is-invalid' : '' ?>" 
                                       id="last_name" 
                                       name="last_name" 
                                       value="<?= htmlspecialchars($formData['last_name'] ?? '') ?>"
                                       required>
                                <?php if (isset($errors['last_name'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $errors['last_name'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" 
                                   class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                                   id="email" 
                                   name="email" 
                                   value="<?= htmlspecialchars($formData['email'] ?? '') ?>"
                                   required>
                            <?php if (isset($errors['email'])): ?>
                                <div class="invalid-feedback">
                                    <?= $errors['email'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Contraseña *</label>
                                <input type="password" 
                                       class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                                       id="password" 
                                       name="password" 
                                       minlength="<?= PASSWORD_MIN_LENGTH ?>"
                                       required>
                                <?php if (isset($errors['password'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $errors['password'] ?>
                                    </div>
                                <?php endif; ?>
                                <small class="form-text text-muted">
                                    Mínimo <?= PASSWORD_MIN_LENGTH ?> caracteres
                                </small>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="password_confirm" class="form-label">Confirmar Contraseña *</label>
                                <input type="password" 
                                       class="form-control <?= isset($errors['password_confirm']) ? 'is-invalid' : '' ?>" 
                                       id="password_confirm" 
                                       name="password_confirm" 
                                       required>
                                <?php if (isset($errors['password_confirm'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $errors['password_confirm'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="age" class="form-label">Edad</label>
                                <input type="number" 
                                       class="form-control" 
                                       id="age" 
                                       name="age" 
                                       min="13" 
                                       max="120"
                                       value="<?= htmlspecialchars($formData['age'] ?? '') ?>">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="gender" class="form-label">Género</label>
                                <select class="form-select" id="gender" name="gender">
                                    <option value="">Seleccionar...</option>
                                    <option value="male" <?= ($formData['gender'] ?? '') === 'male' ? 'selected' : '' ?>>Masculino</option>
                                    <option value="female" <?= ($formData['gender'] ?? '') === 'female' ? 'selected' : '' ?>>Femenino</option>
                                    <option value="other" <?= ($formData['gender'] ?? '') === 'other' ? 'selected' : '' ?>>Otro</option>
                                    <option value="prefer_not_to_say" <?= ($formData['gender'] ?? '') === 'prefer_not_to_say' ? 'selected' : '' ?>>Prefiero no decir</option>
                                </select>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="country" class="form-label">País</label>
                                <select class="form-select" id="country" name="country">
                                    <option value="">Seleccionar...</option>
                                    <option value="México" <?= ($formData['country'] ?? '') === 'México' ? 'selected' : '' ?>>México</option>
                                    <option value="España" <?= ($formData['country'] ?? '') === 'España' ? 'selected' : '' ?>>España</option>
                                    <option value="Argentina" <?= ($formData['country'] ?? '') === 'Argentina' ? 'selected' : '' ?>>Argentina</option>
                                    <option value="Colombia" <?= ($formData['country'] ?? '') === 'Colombia' ? 'selected' : '' ?>>Colombia</option>
                                    <option value="Chile" <?= ($formData['country'] ?? '') === 'Chile' ? 'selected' : '' ?>>Chile</option>
                                    <option value="Perú" <?= ($formData['country'] ?? '') === 'Perú' ? 'selected' : '' ?>>Perú</option>
                                    <option value="Venezuela" <?= ($formData['country'] ?? '') === 'Venezuela' ? 'selected' : '' ?>>Venezuela</option>
                                    <option value="Ecuador" <?= ($formData['country'] ?? '') === 'Ecuador' ? 'selected' : '' ?>>Ecuador</option>
                                    <option value="Uruguay" <?= ($formData['country'] ?? '') === 'Uruguay' ? 'selected' : '' ?>>Uruguay</option>
                                    <option value="Paraguay" <?= ($formData['country'] ?? '') === 'Paraguay' ? 'selected' : '' ?>>Paraguay</option>
                                    <option value="Bolivia" <?= ($formData['country'] ?? '') === 'Bolivia' ? 'selected' : '' ?>>Bolivia</option>
                                    <option value="Costa Rica" <?= ($formData['country'] ?? '') === 'Costa Rica' ? 'selected' : '' ?>>Costa Rica</option>
                                    <option value="Guatemala" <?= ($formData['country'] ?? '') === 'Guatemala' ? 'selected' : '' ?>>Guatemala</option>
                                    <option value="Honduras" <?= ($formData['country'] ?? '') === 'Honduras' ? 'selected' : '' ?>>Honduras</option>
                                    <option value="Nicaragua" <?= ($formData['country'] ?? '') === 'Nicaragua' ? 'selected' : '' ?>>Nicaragua</option>
                                    <option value="Panamá" <?= ($formData['country'] ?? '') === 'Panamá' ? 'selected' : '' ?>>Panamá</option>
                                    <option value="El Salvador" <?= ($formData['country'] ?? '') === 'El Salvador' ? 'selected' : '' ?>>El Salvador</option>
                                    <option value="República Dominicana" <?= ($formData['country'] ?? '') === 'República Dominicana' ? 'selected' : '' ?>>República Dominicana</option>
                                    <option value="Puerto Rico" <?= ($formData['country'] ?? '') === 'Puerto Rico' ? 'selected' : '' ?>>Puerto Rico</option>
                                    <option value="Cuba" <?= ($formData['country'] ?? '') === 'Cuba' ? 'selected' : '' ?>>Cuba</option>
                                    <option value="Estados Unidos" <?= ($formData['country'] ?? '') === 'Estados Unidos' ? 'selected' : '' ?>>Estados Unidos</option>
                                    <option value="Otro" <?= ($formData['country'] ?? '') === 'Otro' ? 'selected' : '' ?>>Otro</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input <?= isset($errors['consent_given']) ? 'is-invalid' : '' ?>" 
                                       type="checkbox" 
                                       id="consent_given" 
                                       name="consent_given" 
                                       required>
                                <label class="form-check-label" for="consent_given">
                                    Acepto el <strong>consentimiento informado</strong> para el tratamiento de mis datos sensibles de salud mental *
                                </label>
                                <?php if (isset($errors['consent_given'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $errors['consent_given'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <small class="form-text text-muted">
                                Sus datos están protegidos y solo serán utilizados para mejorar su experiencia en la plataforma.
                            </small>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-person-plus me-2"></i>Crear Cuenta
                            </button>
                        </div>
                    </form>
                    
                    <hr class="my-4">
                    
                    <div class="text-center">
                        <p class="text-muted mb-0">¿Ya tienes una cuenta?</p>
                        <a href="<?= BASE_URL ?>/login" class="btn btn-link">
                            Iniciar sesión aquí
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registerForm');
    const password = document.getElementById('password');
    const passwordConfirm = document.getElementById('password_confirm');
    
    // Password confirmation validation
    passwordConfirm.addEventListener('input', function() {
        if (password.value !== passwordConfirm.value) {
            passwordConfirm.setCustomValidity('Las contraseñas no coinciden');
        } else {
            passwordConfirm.setCustomValidity('');
        }
    });
    
    password.addEventListener('input', function() {
        if (passwordConfirm.value && password.value !== passwordConfirm.value) {
            passwordConfirm.setCustomValidity('Las contraseñas no coinciden');
        } else {
            passwordConfirm.setCustomValidity('');
        }
    });
});
</script>