<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-1"><?= htmlspecialchars($assessmentType['name']) ?></h4>
                    <p class="text-muted mb-0"><?= htmlspecialchars($assessmentType['description']) ?></p>
                </div>
                <div class="card-body">
                    <?php if (isset($errors['general'])): ?>
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-circle me-2"></i><?= $errors['general'] ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Instructions -->
                    <div class="alert alert-info border-0 mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Instrucciones:</strong> Lee cada pregunta cuidadosamente y selecciona la respuesta 
                        que mejor describa cómo te has sentido durante las últimas <strong>2 semanas</strong>.
                    </div>
                    
                    <form method="POST" id="assessmentForm">
                        <?php 
                        $questions = json_decode($assessmentType['questions'], true);
                        $scoringInfo = json_decode($assessmentType['scoring_info'], true);
                        $scaleOptions = $scoringInfo['scale'];
                        ?>
                        
                        <?php foreach ($questions as $index => $question): ?>
                            <div class="question-group mb-4 p-3 border rounded">
                                <h6 class="question-number mb-3">
                                    Pregunta <?= $index + 1 ?> de <?= count($questions) ?>
                                </h6>
                                <p class="question-text mb-3"><?= htmlspecialchars($question) ?></p>
                                
                                <div class="options">
                                    <?php foreach ($scaleOptions as $optionIndex => $option): ?>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" 
                                                   type="radio" 
                                                   name="responses[<?= $index ?>]" 
                                                   id="q<?= $index ?>_<?= $optionIndex ?>" 
                                                   value="<?= $optionIndex ?>" 
                                                   required>
                                            <label class="form-check-label" for="q<?= $index ?>_<?= $optionIndex ?>">
                                                <?= htmlspecialchars($option) ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <!-- Progress indicator -->
                        <div class="progress mb-4" style="height: 8px;">
                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                                <i class="bi bi-check-circle me-2"></i>Completar Evaluación
                            </button>
                            <a href="<?= BASE_URL ?>/dashboard" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Privacy Notice -->
            <div class="card mt-3">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="bi bi-shield-check me-2"></i>Privacidad y Confidencialidad
                    </h6>
                    <small class="text-muted">
                        Tus respuestas están protegidas y encriptadas. Solo tú puedes ver tus resultados. 
                        Esta evaluación es una herramienta de apoyo y no constituye un diagnóstico médico.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('assessmentForm');
    const submitBtn = document.getElementById('submitBtn');
    const progressBar = document.querySelector('.progress-bar');
    const questions = document.querySelectorAll('.question-group');
    const totalQuestions = questions.length;
    
    // Update progress and enable submit button
    function updateProgress() {
        let answered = 0;
        
        questions.forEach((question, index) => {
            const radios = question.querySelectorAll('input[type="radio"]');
            const isAnswered = Array.from(radios).some(radio => radio.checked);
            
            if (isAnswered) {
                answered++;
                question.classList.add('answered');
                question.classList.remove('border-danger');
            } else {
                question.classList.remove('answered');
            }
        });
        
        const progress = (answered / totalQuestions) * 100;
        progressBar.style.width = progress + '%';
        
        submitBtn.disabled = answered !== totalQuestions;
        
        if (answered === totalQuestions) {
            submitBtn.classList.remove('btn-secondary');
            submitBtn.classList.add('btn-primary');
        }
    }
    
    // Listen for changes in radio buttons
    form.addEventListener('change', function(e) {
        if (e.target.type === 'radio') {
            updateProgress();
        }
    });
    
    // Form submission validation
    form.addEventListener('submit', function(e) {
        let allAnswered = true;
        
        questions.forEach(question => {
            const radios = question.querySelectorAll('input[type="radio"]');
            const isAnswered = Array.from(radios).some(radio => radio.checked);
            
            if (!isAnswered) {
                allAnswered = false;
                question.classList.add('border-danger');
                question.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
        
        if (!allAnswered) {
            e.preventDefault();
            alert('Por favor responde todas las preguntas antes de continuar.');
        }
    });
    
    // Initial progress check
    updateProgress();
});
</script>

<style>
.question-group {
    transition: all 0.3s ease;
}

.question-group.answered {
    border-color: #28a745 !important;
    background-color: #f8fff9;
}

.question-number {
    color: #6c757d;
    font-weight: 600;
}

.question-text {
    font-weight: 500;
    line-height: 1.6;
}

.form-check {
    transition: background-color 0.2s ease;
    padding: 0.5rem;
    border-radius: 0.25rem;
}

.form-check:hover {
    background-color: #f8f9fa;
}

.form-check-input:checked + .form-check-label {
    font-weight: 600;
    color: #0d6efd;
}

.progress-bar {
    transition: width 0.3s ease;
    background: linear-gradient(45deg, #4a90e2, #7b68ee);
}
</style>