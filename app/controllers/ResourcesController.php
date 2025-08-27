<?php
/**
 * Resources Controller
 */
class ResourcesController extends BaseController {
    
    public function index() {
        // Get all active resources
        $sql = "SELECT * FROM resources WHERE is_active = 1 ORDER BY is_featured DESC, created_at DESC";
        $resources = $this->db->fetchAll($sql);
        
        // Group by category
        $groupedResources = [];
        foreach ($resources as $resource) {
            $groupedResources[$resource['category']][] = $resource;
        }
        
        $this->render('resources/index', [
            'title' => 'Recursos y Ejercicios',
            'resources' => $resources,
            'groupedResources' => $groupedResources
        ]);
    }
}
?>