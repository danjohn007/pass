<div class="container mt-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-dark text-white">
                <div class="card-body">
                    <h2 class="card-title mb-0">
                        <i class="bi bi-gear me-2"></i>Panel de Administración
                    </h2>
                    <p class="card-text">Gestión y estadísticas del sistema PASS</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center border-primary">
                <div class="card-body">
                    <i class="bi bi-people text-primary" style="font-size: 2rem;"></i>
                    <h3 class="mt-2"><?= $userStats['total_users'] ?></h3>
                    <p class="text-muted mb-0">Total Usuarios</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-success">
                <div class="card-body">
                    <i class="bi bi-person-check text-success" style="font-size: 2rem;"></i>
                    <h3 class="mt-2"><?= $userStats['active_users'] ?></h3>
                    <p class="text-muted mb-0">Usuarios Activos</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-info">
                <div class="card-body">
                    <i class="bi bi-clipboard-data text-info" style="font-size: 2rem;"></i>
                    <h3 class="mt-2"><?= $assessmentStats['total_assessments'] ?></h3>
                    <p class="text-muted mb-0">Evaluaciones Total</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-warning">
                <div class="card-body">
                    <i class="bi bi-exclamation-triangle text-warning" style="font-size: 2rem;"></i>
                    <h3 class="mt-2"><?= $assessmentStats['critical_cases'] ?></h3>
                    <p class="text-muted mb-0">Casos Críticos</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Recent Users -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-person-plus me-2"></i>Usuarios Recientes
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($recentUsers)): ?>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Usuario</th>
                                        <th>Email</th>
                                        <th>Registro</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentUsers as $user): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></td>
                                            <td><?= htmlspecialchars($user['email']) ?></td>
                                            <td><?= date('d/m/Y', strtotime($user['created_at'])) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">No hay usuarios recientes</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Recent Assessments -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-clipboard-check me-2"></i>Evaluaciones Recientes
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($recentAssessments)): ?>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Usuario</th>
                                        <th>Evaluación</th>
                                        <th>Resultado</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentAssessments as $assessment): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($assessment['first_name'] . ' ' . $assessment['last_name']) ?></td>
                                            <td><?= htmlspecialchars($assessment['assessment_name']) ?></td>
                                            <td>
                                                <span class="badge bg-<?php
                                                    switch($assessment['severity_level']) {
                                                        case 'minimal': echo 'success'; break;
                                                        case 'mild': echo 'warning'; break;
                                                        case 'moderate': echo 'info'; break;
                                                        case 'severe': echo 'danger'; break;
                                                        default: echo 'secondary';
                                                    }
                                                ?>">
                                                    <?= ucfirst($assessment['severity_level']) ?>
                                                </span>
                                            </td>
                                            <td><?= date('d/m', strtotime($assessment['completed_at'])) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">No hay evaluaciones recientes</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- System Status -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-shield-check me-2"></i>Estado del Sistema
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <span>Base de Datos: Conectada</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <span>Sesiones: Funcionando</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <span>Seguridad: Activa</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h6>Información del Sistema</h6>
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>Versión PHP:</strong> <?= PHP_VERSION ?>
                                </div>
                                <div class="col-md-3">
                                    <strong>Versión App:</strong> <?= APP_VERSION ?>
                                </div>
                                <div class="col-md-3">
                                    <strong>Tiempo Activo:</strong> <?= date('d/m/Y H:i') ?>
                                </div>
                                <div class="col-md-3">
                                    <strong>Zona Horaria:</strong> <?= TIMEZONE ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>