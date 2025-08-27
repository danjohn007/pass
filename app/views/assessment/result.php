<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Result Summary Card -->
            <div class="card mb-4">
                <div class="card-header text-center bg-<?php
                    switch($result['severity_level']) {
                        case 'minimal': echo 'success'; break;
                        case 'mild': echo 'warning'; break;
                        case 'moderate': echo 'info'; break;
                        case 'severe': echo 'danger'; break;
                        default: echo 'secondary';
                    }
                ?> text-white">
                    <h3 class="mb-1">Resultado de tu Evaluación</h3>
                    <h5 class="mb-0"><?= htmlspecialchars($result['name']) ?></h5>
                </div>
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="display-4 fw-bold text-<?php
                                switch($result['severity_level']) {
                                    case 'minimal': echo 'success'; break;
                                    case 'mild': echo 'warning'; break;
                                    case 'moderate': echo 'info'; break;
                                    case 'severe': echo 'danger'; break;
                                    default: echo 'secondary';
                                }
                            ?>"><?= $result['total_score'] ?></div>
                            <p class="text-muted">Puntuación Total</p>
                        </div>
                        <div class="col-md-4">
                            <div class="display-6 fw-bold text-<?php
                                switch($result['severity_level']) {
                                    case 'minimal': echo 'success'; break;
                                    case 'mild': echo 'warning'; break;
                                    case 'moderate': echo 'info'; break;
                                    case 'severe': echo 'danger'; break;
                                    default: echo 'secondary';
                                }
                            ?>"><?= ucfirst($result['severity_level']) ?></div>
                            <p class="text-muted">Nivel de Severidad</p>
                        </div>
                        <div class="col-md-4">
                            <div class="display-6 fw-bold text-muted">
                                <?= date('d/m/Y', strtotime($result['completed_at'])) ?>
                            </div>
                            <p class="text-muted">Fecha de Evaluación</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Interpretation -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-lightbulb me-2"></i>Interpretación de Resultados
                    </h5>
                </div>
                <div class="card-body">
                    <p class="lead"><?= htmlspecialchars($interpretation) ?></p>
                    
                    <?php if ($result['severity_level'] === 'severe'): ?>
                        <div class="alert alert-danger border-0">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Importante:</strong> Los resultados sugieren que podrías beneficiarte de 
                            apoyo profesional. No dudes en contactar a un psicólogo, psiquiatra o línea de crisis.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Recommendations -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-heart me-2"></i>Recomendaciones Personalizadas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php foreach ($recommendations as $index => $recommendation): ?>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <span class="badge bg-primary rounded-pill"><?= $index + 1 ?></span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-0"><?= htmlspecialchars($recommendation) ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <!-- Historical Comparison -->
            <?php if (!empty($history) && count($history) > 1): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-graph-up me-2"></i>Tu Progreso en el Tiempo
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="progressChart"></canvas>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Emergency Resources -->
            <?php if ($result['severity_level'] === 'severe'): ?>
                <div class="card mb-4 border-danger">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-telephone me-2"></i>Recursos de Emergencia
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Líneas de Crisis 24/7</h6>
                                <ul class="list-unstyled">
                                    <li><i class="bi bi-telephone-fill me-2 text-danger"></i>Línea Nacional: 800-111-1111</li>
                                    <li><i class="bi bi-telephone-fill me-2 text-danger"></i>Emergencias: 911</li>
                                    <li><i class="bi bi-chat-dots-fill me-2 text-info"></i>Chat de Crisis: crisis.chat</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6>Centros de Ayuda</h6>
                                <ul class="list-unstyled">
                                    <li><i class="bi bi-hospital me-2 text-success"></i>Hospital más cercano</li>
                                    <li><i class="bi bi-person-hearts me-2 text-warning"></i>Centro de Salud Mental</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Actions -->
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">¿Qué hacer a continuación?</h6>
                    <div class="d-grid d-md-flex gap-2">
                        <a href="<?= BASE_URL ?>/dashboard" class="btn btn-primary">
                            <i class="bi bi-speedometer2 me-2"></i>Ir al Dashboard
                        </a>
                        <a href="<?= BASE_URL ?>/resources" class="btn btn-outline-success">
                            <i class="bi bi-book me-2"></i>Explorar Recursos
                        </a>
                        <a href="<?= BASE_URL ?>/tracking/add" class="btn btn-outline-info">
                            <i class="bi bi-plus-circle me-2"></i>Registrar Estado de Ánimo
                        </a>
                        <a href="<?= BASE_URL ?>/assessment/<?= $result['code'] ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise me-2"></i>Repetir Evaluación
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($history) && count($history) > 1): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('progressChart').getContext('2d');
    
    const chartData = {
        labels: [
            <?php foreach ($history as $entry): ?>
                '<?= date('d/m', strtotime($entry['assessment_date'])) ?>',
            <?php endforeach; ?>
        ],
        datasets: [{
            label: 'Puntuación',
            data: [
                <?php foreach ($history as $entry): ?>
                    <?= $entry['total_score'] ?>,
                <?php endforeach; ?>
            ],
            borderColor: '#4a90e2',
            backgroundColor: 'rgba(74, 144, 226, 0.1)',
            tension: 0.4,
            fill: true
        }]
    };
    
    const config = {
        type: 'line',
        data: chartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Evolución de tu puntuación'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Puntuación'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Fecha'
                    }
                }
            }
        }
    };
    
    new Chart(ctx, config);
});
</script>
<?php endif; ?>

<style>
.chart-container {
    position: relative;
    height: 300px;
    width: 100%;
}
</style>