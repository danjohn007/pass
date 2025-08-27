<div class="container mt-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-white text-center py-5">
                    <h1 class="display-5 fw-bold mb-3">
                        <i class="bi bi-book me-3"></i>Recursos para tu Bienestar
                    </h1>
                    <p class="lead mb-0">
                        Descubre técnicas, ejercicios y recursos diseñados para apoyar tu salud mental
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Categories -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="nav nav-pills justify-content-center" role="tablist">
                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#all" type="button">
                    <i class="bi bi-grid me-2"></i>Todos
                </button>
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#techniques" type="button">
                    <i class="bi bi-gear me-2"></i>Técnicas
                </button>
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#exercises" type="button">
                    <i class="bi bi-play-circle me-2"></i>Ejercicios
                </button>
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#articles" type="button">
                    <i class="bi bi-file-text me-2"></i>Artículos
                </button>
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#videos" type="button">
                    <i class="bi bi-play-btn me-2"></i>Videos
                </button>
            </div>
        </div>
    </div>
    
    <!-- Content -->
    <div class="tab-content">
        <!-- All Resources -->
        <div class="tab-pane fade show active" id="all">
            <div class="row">
                <?php foreach ($resources as $resource): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 resource-card" data-category="<?= $resource['category'] ?>">
                            <?php if ($resource['is_featured']): ?>
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge bg-warning">
                                        <i class="bi bi-star-fill"></i> Destacado
                                    </span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="card-body">
                                <div class="d-flex align-items-start mb-3">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="icon-circle bg-<?php
                                            switch($resource['category']) {
                                                case 'technique': echo 'primary'; break;
                                                case 'exercise': echo 'success'; break;
                                                case 'article': echo 'info'; break;
                                                case 'video': echo 'warning'; break;
                                                default: echo 'secondary';
                                            }
                                        ?> text-white">
                                            <i class="bi bi-<?php
                                                switch($resource['category']) {
                                                    case 'technique': echo 'gear'; break;
                                                    case 'exercise': echo 'play-circle'; break;
                                                    case 'article': echo 'file-text'; break;
                                                    case 'video': echo 'play-btn'; break;
                                                    default: echo 'bookmark';
                                                }
                                            ?>"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="card-title"><?= htmlspecialchars($resource['title']) ?></h5>
                                        <span class="badge bg-light text-dark">
                                            <?= ucfirst($resource['category']) ?>
                                        </span>
                                    </div>
                                </div>
                                
                                <p class="card-text"><?= htmlspecialchars($resource['content']) ?></p>
                                
                                <?php if ($resource['tags']): ?>
                                    <div class="mb-3">
                                        <?php 
                                        $tags = json_decode($resource['tags'], true) ?? [];
                                        foreach ($tags as $tag): 
                                        ?>
                                            <span class="badge bg-secondary me-1">#<?= htmlspecialchars($tag) ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($resource['url']): ?>
                                    <a href="<?= htmlspecialchars($resource['url']) ?>" 
                                       target="_blank" 
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-link-45deg me-2"></i>Ver Recurso
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Techniques -->
        <div class="tab-pane fade" id="techniques">
            <div class="row">
                <?php if (isset($groupedResources['technique'])): ?>
                    <?php foreach ($groupedResources['technique'] as $resource): ?>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="bi bi-gear text-primary me-2"></i>
                                        <?= htmlspecialchars($resource['title']) ?>
                                    </h5>
                                    <p class="card-text"><?= htmlspecialchars($resource['content']) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-gear text-muted" style="font-size: 3rem;"></i>
                        <h4 class="text-muted mt-3">No hay técnicas disponibles</h4>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Exercises -->
        <div class="tab-pane fade" id="exercises">
            <div class="row">
                <?php if (isset($groupedResources['exercise'])): ?>
                    <?php foreach ($groupedResources['exercise'] as $resource): ?>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="bi bi-play-circle text-success me-2"></i>
                                        <?= htmlspecialchars($resource['title']) ?>
                                    </h5>
                                    <p class="card-text"><?= htmlspecialchars($resource['content']) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-play-circle text-muted" style="font-size: 3rem;"></i>
                        <h4 class="text-muted mt-3">No hay ejercicios disponibles</h4>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Articles -->
        <div class="tab-pane fade" id="articles">
            <div class="row">
                <?php if (isset($groupedResources['article'])): ?>
                    <?php foreach ($groupedResources['article'] as $resource): ?>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="bi bi-file-text text-info me-2"></i>
                                        <?= htmlspecialchars($resource['title']) ?>
                                    </h5>
                                    <p class="card-text"><?= htmlspecialchars($resource['content']) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-file-text text-muted" style="font-size: 3rem;"></i>
                        <h4 class="text-muted mt-3">No hay artículos disponibles</h4>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Videos -->
        <div class="tab-pane fade" id="videos">
            <div class="row">
                <?php if (isset($groupedResources['video'])): ?>
                    <?php foreach ($groupedResources['video'] as $resource): ?>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="bi bi-play-btn text-warning me-2"></i>
                                        <?= htmlspecialchars($resource['title']) ?>
                                    </h5>
                                    <p class="card-text"><?= htmlspecialchars($resource['content']) ?></p>
                                    <?php if ($resource['url']): ?>
                                        <a href="<?= htmlspecialchars($resource['url']) ?>" 
                                           target="_blank" 
                                           class="btn btn-warning btn-sm">
                                            <i class="bi bi-play-fill me-2"></i>Ver Video
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-play-btn text-muted" style="font-size: 3rem;"></i>
                        <h4 class="text-muted mt-3">No hay videos disponibles</h4>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Quick Help -->
    <div class="card mt-5 border-primary">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-life-preserver me-2"></i>¿Necesitas ayuda inmediata?
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <h6>Crisis 24/7</h6>
                    <p class="text-muted">Línea Nacional de Prevención del Suicidio</p>
                    <a href="tel:988" class="btn btn-danger btn-sm">
                        <i class="bi bi-telephone me-2"></i>988
                    </a>
                </div>
                <div class="col-md-4">
                    <h6>Chat de Crisis</h6>
                    <p class="text-muted">Apoyo inmediato por mensaje</p>
                    <a href="#" class="btn btn-info btn-sm">
                        <i class="bi bi-chat-dots me-2"></i>Iniciar Chat
                    </a>
                </div>
                <div class="col-md-4">
                    <h6>Encuentra Ayuda</h6>
                    <p class="text-muted">Profesionales cerca de ti</p>
                    <a href="#" class="btn btn-success btn-sm">
                        <i class="bi bi-geo-alt me-2"></i>Buscar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.icon-circle {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.resource-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.resource-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.nav-pills .nav-link {
    border-radius: 25px;
    margin: 0 0.25rem;
}

.bg-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
}
</style>