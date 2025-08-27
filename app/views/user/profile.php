<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="bi bi-person-circle me-2"></i>Mi Perfil
                    </h4>
                </div>
                <div class="card-body">
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle me-2"></i><?= $success ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">Nombre</label>
                                <input type="text" 
                                       class="form-control <?= isset($errors['first_name']) ? 'is-invalid' : '' ?>" 
                                       id="first_name" 
                                       name="first_name" 
                                       value="<?= htmlspecialchars($user['first_name']) ?>"
                                       required>
                                <?php if (isset($errors['first_name'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $errors['first_name'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Apellido</label>
                                <input type="text" 
                                       class="form-control <?= isset($errors['last_name']) ? 'is-invalid' : '' ?>" 
                                       id="last_name" 
                                       name="last_name" 
                                       value="<?= htmlspecialchars($user['last_name']) ?>"
                                       required>
                                <?php if (isset($errors['last_name'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $errors['last_name'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" 
                                   class="form-control" 
                                   id="email" 
                                   value="<?= htmlspecialchars($user['email']) ?>"
                                   disabled>
                            <small class="form-text text-muted">El email no se puede cambiar</small>
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
                                       value="<?= htmlspecialchars($user['age'] ?? '') ?>">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="gender" class="form-label">Género</label>
                                <select class="form-select" id="gender" name="gender">
                                    <option value="">Seleccionar...</option>
                                    <option value="male" <?= $user['gender'] === 'male' ? 'selected' : '' ?>>Masculino</option>
                                    <option value="female" <?= $user['gender'] === 'female' ? 'selected' : '' ?>>Femenino</option>
                                    <option value="other" <?= $user['gender'] === 'other' ? 'selected' : '' ?>>Otro</option>
                                    <option value="prefer_not_to_say" <?= $user['gender'] === 'prefer_not_to_say' ? 'selected' : '' ?>>Prefiero no decir</option>
                                </select>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="country" class="form-label">País</label>
                                <select class="form-select" id="country" name="country">
                                    <option value="">Seleccionar...</option>
                                    <option value="México" <?= $user['country'] === 'México' ? 'selected' : '' ?>>México</option>
                                    <option value="España" <?= $user['country'] === 'España' ? 'selected' : '' ?>>España</option>
                                    <option value="Argentina" <?= $user['country'] === 'Argentina' ? 'selected' : '' ?>>Argentina</option>
                                    <option value="Colombia" <?= $user['country'] === 'Colombia' ? 'selected' : '' ?>>Colombia</option>
                                    <!-- Add more countries as needed -->
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Miembro desde</label>
                                <p class="form-control-plaintext">
                                    <?= date('d/m/Y', strtotime($user['created_at'])) ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Último acceso</label>
                                <p class="form-control-plaintext">
                                    <?= $user['last_login'] ? date('d/m/Y H:i', strtotime($user['last_login'])) : 'Nunca' ?>
                                </p>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="<?= BASE_URL ?>/dashboard" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Volver
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Actualizar Perfil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>