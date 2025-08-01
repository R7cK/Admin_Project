
<?= $this->extend('layouts/main') ?> <!-- Asume que tienes un layout principal -->

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Gestión de Catálogos</h1>
    
    <div class="row">
        <!-- Tarjeta para Estatus -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="<?= site_url('catalogos/list/estatus') ?>" class="card-link">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                
                                <div class="h5 mb-0 font-weight-bold text-primary text-middle">Estatus</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Tarjeta para Prioridades -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="<?= site_url('catalogos/list/prioridades') ?>" class="card-link">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="h5 mb-0 font-weight-bold text-gray-800 text-warning">Prioridades</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <!-- Tarjeta para Roles -->
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="<?= site_url('catalogos/list/roles') ?>" class="card-link">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="h5 mb-0 font-weight-bold text-info">Roles de Usuario</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-shield fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            
    </div>
</div>
             
<style>
    .card-link {
        text-decoration: none;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15)!important;
        transition: transform 0.2s;
    }
</style>
<?= $this->endSection() ?>