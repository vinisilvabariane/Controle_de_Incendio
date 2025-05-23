<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FireWatch - Dashboard</title>
    <link rel="icon" type="image/svg+xml" sizes="16x16" href="/site_dash/public/img/imagemF_fire.png">
    <link rel="stylesheet" href="https://bootswatch.com/5/darkly/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/site_dash/public/css/fonts.css">
    <link rel="stylesheet" href="./style.css">
    <style>
        body {
            padding-top: 56px;
        }

        .dashboard-header {
            padding-top: 1rem;
        }
    </style>
</head>

<body class="bg-dark text-light">
    <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/site_dash/includes/navbar.php"); ?>

    <div class="container-fluid dashboard-header">
        <div class="row mb-4">
            <div class="col">
                <h1 class="display-4">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard de Monitoramento
                </h1>
                <p class="text-warning">Visualização em tempo real dos dados de incêndios florestais</p>
            </div>
        </div>
    </div>

    <div class="container-fluid py-4">
        <div id="loading-spinner" class="loading-spinner text-center">
            <div class="spinner-border text-danger" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Carregando...</span>
            </div>
            <p class="mt-3">Carregando dados do dashboard...</p>
        </div>

        <div id="error-alert" class="alert alert-danger d-none" role="alert"></div>

        <div id="dashboard-container" class="d-none">
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="card dashboard-card bg-dark border-danger">
                        <div class="card-header bg-danger bg-opacity-25">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-graph-up me-2"></i> Tendência de Incêndios
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="data-chart"></canvas>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <small class="last-update" id="last-update"></small>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card dashboard-card bg-dark border-warning mb-4">
                        <div class="card-header bg-warning bg-opacity-25">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-exclamation-triangle me-2"></i> Resumo
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6 mb-3">
                                    <div class="p-3 bg-danger bg-opacity-10 rounded">
                                        <h6 class="text-warning">Total de Ocorrências</h6>
                                        <h3 id="total-incidents" class="text-danger">-</h3>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="p-3 bg-warning bg-opacity-10 rounded">
                                        <h6 class="text-warning">Média Diária</h6>
                                        <h3 id="daily-average" class="text-warning">-</h3>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 bg-success bg-opacity-10 rounded">
                                        <h6 class="text-warning">Variação (7 dias)</h6>
                                        <h3 id="weekly-change" class="text-success">-</h3>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 bg-info bg-opacity-10 rounded">
                                        <h6 class="text-warning">Alerta Atual</h6>
                                        <h3 id="current-alert" class="text-info">-</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card dashboard-card bg-dark border-info">
                        <div class="card-header bg-info bg-opacity-25">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-info-circle me-2"></i> Legenda
                            </h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush bg-transparent">
                                <li class="list-group-item bg-transparent text-light border-secondary">
                                    <span class="badge bg-danger me-2">●</span> Dados Diários
                                </li>
                                <li class="list-group-item bg-transparent text-light border-secondary">
                                    <span class="badge bg-primary me-2">●</span> Média Móvel (7 dias)
                                </li>
                                <li class="list-group-item bg-transparent text-light border-secondary">
                                    <span class="badge bg-success me-2">↑</span> Tendência de melhora
                                </li>
                                <li class="list-group-item bg-transparent text-light border-secondary">
                                    <span class="badge bg-danger me-2">↓</span> Tendência de piora
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="card dashboard-card bg-dark border-success">
                        <div class="card-header bg-success bg-opacity-25">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-table me-2"></i> Dados Detalhados
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-container">
                                <table class="table table-hover mb-0" id="data-table">
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/site_dash/includes/footer.php"); ?>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/site_dash/public/js/dashboard.js"></script>
</body>

</html>