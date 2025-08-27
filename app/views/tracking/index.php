<div class="container mt-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                <div class="card-body text-white text-center py-4">
                    <h2 class="mb-2">
                        <i class="bi bi-graph-up me-2"></i>Seguimiento Diario
                    </h2>
                    <p class="mb-0">Monitorea tu bienestar mental día a día</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Action Button -->
    <div class="row mb-4">
        <div class="col-12 text-center">
            <a href="<?= BASE_URL ?>/tracking/add" class="btn btn-primary btn-lg">
                <i class="bi bi-plus-circle me-2"></i>Registrar Estado de Hoy
            </a>
        </div>
    </div>
    
    <!-- Tracking History -->
    <?php if (!empty($trackingData)): ?>
        <!-- Chart -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-bar-chart me-2"></i>Tu Progreso en los Últimos 30 Días
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="trackingChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Data Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-table me-2"></i>Historial de Registros
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Estado de Ánimo</th>
                                        <th>Nivel de Estrés</th>
                                        <th>Nivel de Ansiedad</th>
                                        <th>Notas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($trackingData as $entry): ?>
                                        <tr>
                                            <td>
                                                <strong><?= date('d/m/Y', strtotime($entry['tracking_date'])) ?></strong>
                                                <br>
                                                <small class="text-muted">
                                                    <?= date('l', strtotime($entry['tracking_date'])) ?>
                                                </small>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="badge bg-<?php
                                                        if ($entry['mood_level'] <= 3) echo 'danger';
                                                        elseif ($entry['mood_level'] <= 6) echo 'warning';
                                                        else echo 'success';
                                                    ?> me-2">
                                                        <?= $entry['mood_level'] ?>/10
                                                    </span>
                                                    <?php if ($entry['mood_level'] <= 3): ?>
                                                        <i class="bi bi-emoji-frown text-danger"></i>
                                                    <?php elseif ($entry['mood_level'] <= 6): ?>
                                                        <i class="bi bi-emoji-neutral text-warning"></i>
                                                    <?php else: ?>
                                                        <i class="bi bi-emoji-smile text-success"></i>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?php
                                                    if ($entry['stress_level'] >= 8) echo 'danger';
                                                    elseif ($entry['stress_level'] >= 5) echo 'warning';
                                                    else echo 'success';
                                                ?>">
                                                    <?= $entry['stress_level'] ?>/10
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?php
                                                    if ($entry['anxiety_level'] >= 8) echo 'danger';
                                                    elseif ($entry['anxiety_level'] >= 5) echo 'warning';
                                                    else echo 'success';
                                                ?>">
                                                    <?= $entry['anxiety_level'] ?>/10
                                                </span>
                                            </td>
                                            <td>
                                                <?php if (!empty($entry['notes'])): ?>
                                                    <span class="text-truncate d-inline-block" style="max-width: 200px;" 
                                                          title="<?= htmlspecialchars($entry['notes']) ?>">
                                                        <?= htmlspecialchars($entry['notes']) ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted">Sin notas</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    <?php else: ?>
        <!-- Empty State -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-graph-up text-muted" style="font-size: 5rem;"></i>
                        <h3 class="text-muted mt-3">No hay registros aún</h3>
                        <p class="text-muted">Comienza a registrar tu estado de ánimo diario para ver tu progreso</p>
                        <a href="<?= BASE_URL ?>/tracking/add" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Hacer mi primer registro
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php if (!empty($trackingData)): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('trackingChart').getContext('2d');
    
    const data = {
        labels: [
            <?php foreach (array_reverse($trackingData) as $entry): ?>
                '<?= date('d/m', strtotime($entry['tracking_date'])) ?>',
            <?php endforeach; ?>
        ],
        datasets: [
            {
                label: 'Estado de Ánimo',
                data: [
                    <?php foreach (array_reverse($trackingData) as $entry): ?>
                        <?= $entry['mood_level'] ?>,
                    <?php endforeach; ?>
                ],
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                tension: 0.4
            },
            {
                label: 'Nivel de Estrés',
                data: [
                    <?php foreach (array_reverse($trackingData) as $entry): ?>
                        <?= $entry['stress_level'] ?>,
                    <?php endforeach; ?>
                ],
                borderColor: '#ffc107',
                backgroundColor: 'rgba(255, 193, 7, 0.1)',
                tension: 0.4
            },
            {
                label: 'Nivel de Ansiedad',
                data: [
                    <?php foreach (array_reverse($trackingData) as $entry): ?>
                        <?= $entry['anxiety_level'] ?>,
                    <?php endforeach; ?>
                ],
                borderColor: '#dc3545',
                backgroundColor: 'rgba(220, 53, 69, 0.1)',
                tension: 0.4
            }
        ]
    };
    
    const config = {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Evolución de tu bienestar mental'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 10,
                    title: {
                        display: true,
                        text: 'Puntuación (1-10)'
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
    height: 400px;
    width: 100%;
}

.bg-gradient {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%) !important;
}

@media (max-width: 768px) {
    .chart-container {
        height: 300px;
    }
}
</style>