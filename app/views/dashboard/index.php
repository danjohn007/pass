<div class="container mt-4">
    <!-- Critical Alerts -->
    <?php if (!empty($criticalAssessments)): ?>
        <div class="alert alert-danger border-0 mb-4">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Atención:</strong> Se han detectado niveles críticos en evaluaciones recientes. 
            Te recomendamos <a href="<?= BASE_URL ?>/resources" class="alert-link">consultar nuestros recursos</a> 
            o buscar ayuda profesional.
        </div>
    <?php endif; ?>
    
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="card-title mb-2">
                                ¡Hola, <?= htmlspecialchars(explode(' ', $_SESSION['user_name'])[0]) ?>!
                            </h2>
                            <p class="card-text mb-0">
                                Bienvenido a tu espacio de bienestar mental. Aquí puedes monitorear tu progreso 
                                y acceder a herramientas para cuidar tu salud mental.
                            </p>
                        </div>
                        <div class="col-md-4 text-center">
                            <i class="bi bi-heart-pulse" style="font-size: 4rem; opacity: 0.8;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-clipboard-check text-primary" style="font-size: 2rem;"></i>
                    <h4 class="mt-2"><?= count($recentAssessments) ?></h4>
                    <p class="text-muted mb-0">Evaluaciones Completadas</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-graph-up text-success" style="font-size: 2rem;"></i>
                    <h4 class="mt-2"><?= count($dailyTracking) ?></h4>
                    <p class="text-muted mb-0">Días de Seguimiento</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-calendar-check text-info" style="font-size: 2rem;"></i>
                    <h4 class="mt-2">
                        <?= !empty($dailyTracking) ? date('j', strtotime($dailyTracking[0]['tracking_date'])) : 0 ?>
                    </h4>
                    <p class="text-muted mb-0">Último Registro</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-trophy text-warning" style="font-size: 2rem;"></i>
                    <h4 class="mt-2">
                        <?php 
                        $streak = 0;
                        if (!empty($dailyTracking)) {
                            $today = new DateTime();
                            $lastDate = new DateTime($dailyTracking[0]['tracking_date']);
                            $diff = $today->diff($lastDate)->days;
                            $streak = $diff <= 1 ? count($dailyTracking) : 0;
                        }
                        echo $streak;
                        ?>
                    </h4>
                    <p class="text-muted mb-0">Racha de Días</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Available Assessments -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-clipboard-check me-2"></i>Evaluaciones Disponibles
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($assessmentTypes)): ?>
                        <?php foreach ($assessmentTypes as $type): ?>
                            <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                                <div>
                                    <h6 class="mb-1"><?= htmlspecialchars($type['name']) ?></h6>
                                    <small class="text-muted"><?= htmlspecialchars($type['description']) ?></small>
                                    <?php if (isset($latestScores[$type['code']])): ?>
                                        <br>
                                        <span class="badge bg-secondary mt-1">
                                            Última: <?= $latestScores[$type['code']]['total_score'] ?> puntos 
                                            (<?= ucfirst($latestScores[$type['code']]['severity_level']) ?>)
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <a href="<?= BASE_URL ?>/assessment/<?= $type['code'] ?>" 
                                       class="btn btn-outline-primary btn-sm">
                                        <?= isset($latestScores[$type['code']]) ? 'Repetir' : 'Realizar' ?>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted">No hay evaluaciones disponibles en este momento.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-clock-history me-2"></i>Actividad Reciente
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($recentAssessments)): ?>
                        <?php foreach ($recentAssessments as $assessment): ?>
                            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                <div>
                                    <h6 class="mb-1"><?= htmlspecialchars($assessment['name']) ?></h6>
                                    <small class="text-muted">
                                        <?= date('d/m/Y H:i', strtotime($assessment['completed_at'])) ?>
                                    </small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-<?php
                                        switch($assessment['severity_level']) {
                                            case 'minimal': echo 'success'; break;
                                            case 'mild': echo 'warning'; break;
                                            case 'moderate': echo 'orange'; break;
                                            case 'severe': echo 'danger'; break;
                                            default: echo 'secondary';
                                        }
                                    ?>">
                                        <?= ucfirst($assessment['severity_level']) ?>
                                    </span>
                                    <br>
                                    <small class="text-muted"><?= $assessment['total_score'] ?> puntos</small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <div class="text-center mt-3">
                            <a href="<?= BASE_URL ?>/assessment/history" class="btn btn-link btn-sm">
                                Ver historial completo
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="bi bi-clipboard text-muted" style="font-size: 3rem;"></i>
                            <h6 class="text-muted mt-2">No hay evaluaciones aún</h6>
                            <p class="text-muted small">¡Comienza realizando tu primera evaluación!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-lightning me-2"></i>Acciones Rápidas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <a href="<?= BASE_URL ?>/tracking/add" class="btn btn-outline-primary w-100 mb-2">
                                <i class="bi bi-plus-circle me-2"></i>Registrar Estado de Ánimo
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= BASE_URL ?>/assessment/GAD7" class="btn btn-outline-success w-100 mb-2">
                                <i class="bi bi-heart me-2"></i>Evaluación de Ansiedad
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= BASE_URL ?>/assessment/PHQ9" class="btn btn-outline-info w-100 mb-2">
                                <i class="bi bi-brain me-2"></i>Evaluación de Estado de Ánimo
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= BASE_URL ?>/resources" class="btn btn-outline-warning w-100 mb-2">
                                <i class="bi bi-book me-2"></i>Recursos y Ejercicios
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-orange {
    background-color: #fd7e14 !important;
}
</style>