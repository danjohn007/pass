<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-1">
                        <i class="bi bi-heart me-2"></i>Registrar Estado de Ánimo
                    </h4>
                    <p class="text-muted mb-0">¿Cómo te sientes hoy?</p>
                </div>
                <div class="card-body">
                    <?php if ($existing): ?>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            Ya registraste tu estado de ánimo hoy. Puedes actualizarlo si quieres.
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" id="trackingForm">
                        <!-- Mood Level -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="bi bi-emoji-smile me-2"></i>Estado de Ánimo
                            </label>
                            <p class="small text-muted">1 = Muy triste, 10 = Muy feliz</p>
                            <div class="row text-center">
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <div class="col">
                                        <input type="radio" 
                                               class="btn-check" 
                                               name="mood_level" 
                                               id="mood<?= $i ?>" 
                                               value="<?= $i ?>" 
                                               required>
                                        <label class="btn btn-outline-primary w-100" for="mood<?= $i ?>">
                                            <?= $i ?>
                                        </label>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                        
                        <!-- Stress Level -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="bi bi-lightning me-2"></i>Nivel de Estrés
                            </label>
                            <p class="small text-muted">1 = Sin estrés, 10 = Muy estresado</p>
                            <div class="row text-center">
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <div class="col">
                                        <input type="radio" 
                                               class="btn-check" 
                                               name="stress_level" 
                                               id="stress<?= $i ?>" 
                                               value="<?= $i ?>" 
                                               required>
                                        <label class="btn btn-outline-warning w-100" for="stress<?= $i ?>">
                                            <?= $i ?>
                                        </label>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                        
                        <!-- Anxiety Level -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="bi bi-exclamation-triangle me-2"></i>Nivel de Ansiedad
                            </label>
                            <p class="small text-muted">1 = Sin ansiedad, 10 = Muy ansioso</p>
                            <div class="row text-center">
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <div class="col">
                                        <input type="radio" 
                                               class="btn-check" 
                                               name="anxiety_level" 
                                               id="anxiety<?= $i ?>" 
                                               value="<?= $i ?>" 
                                               required>
                                        <label class="btn btn-outline-danger w-100" for="anxiety<?= $i ?>">
                                            <?= $i ?>
                                        </label>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                        
                        <!-- Notes -->
                        <div class="mb-4">
                            <label for="notes" class="form-label fw-bold">
                                <i class="bi bi-journal-text me-2"></i>Notas (Opcional)
                            </label>
                            <textarea class="form-control" 
                                      id="notes" 
                                      name="notes" 
                                      rows="3" 
                                      placeholder="¿Qué eventos o sentimientos destacarías del día?"></textarea>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>
                                <?= $existing ? 'Actualizar Registro' : 'Guardar Registro' ?>
                            </button>
                            <a href="<?= BASE_URL ?>/tracking" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Ver Historial
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Tips -->
            <div class="card mt-3">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="bi bi-lightbulb me-2"></i>Consejos para un mejor seguimiento
                    </h6>
                    <ul class="list-unstyled small text-muted mb-0">
                        <li>• Registra tu estado a la misma hora cada día</li>
                        <li>• Sé honesto con tus sentimientos</li>
                        <li>• Usa las notas para recordar eventos importantes</li>
                        <li>• Revisa tu progreso semanalmente</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('trackingForm');
    
    // Visual feedback for selections
    form.addEventListener('change', function(e) {
        if (e.target.type === 'radio') {
            const group = e.target.name;
            const value = parseInt(e.target.value);
            
            // Update button colors based on value
            const buttons = document.querySelectorAll(`input[name="${group}"]`);
            buttons.forEach(button => {
                const label = document.querySelector(`label[for="${button.id}"]`);
                label.classList.remove('btn-success', 'btn-warning', 'btn-danger');
                
                if (button.checked) {
                    if (group === 'mood_level') {
                        if (value <= 3) label.classList.add('btn-danger');
                        else if (value <= 6) label.classList.add('btn-warning');
                        else label.classList.add('btn-success');
                    } else {
                        if (value >= 8) label.classList.add('btn-danger');
                        else if (value >= 5) label.classList.add('btn-warning');
                        else label.classList.add('btn-success');
                    }
                }
            });
        }
    });
});
</script>