<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FireWatch - Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@5/dist/darkly/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.css">
    <style>
        :root {
            --fire-primary: #ff3300;
            --fire-secondary: #ff5500;
            --fire-dark: #1a1a1a;
        }
        
        body {
            background-color: #121212;
            color: #f0f0f0;
        }
        
        .navbar {
            border-bottom: 1px solid var(--fire-primary);
            background-color: var(--fire-dark) !important;
        }
        
        .sidebar {
            background-color: #1e1e1e;
            border-right: 1px solid #333;
            height: 100vh;
            position: fixed;
        }
        
        .sidebar .nav-link {
            color: #ddd;
            border-left: 3px solid transparent;
        }
        
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: white;
            background-color: #333;
            border-left: 3px solid var(--fire-primary);
        }
        
        .sidebar .nav-link i {
            color: var(--fire-secondary);
        }
        
        .card {
            background-color: #1e1e1e;
            border: 1px solid #333;
            transition: transform 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(255, 60, 0, 0.1);
        }
        
        .card-header {
            border-bottom: 1px solid #333;
            background-color: rgba(255, 85, 0, 0.1);
        }
        
        .alert-fire {
            background-color: rgba(255, 50, 0, 0.2);
            border-left: 4px solid var(--fire-primary);
        }
        
        .flame-indicator {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }
        
        .flame-active {
            background-color: var(--fire-primary);
            box-shadow: 0 0 10px var(--fire-primary);
        }
        
        .gauge-container {
            position: relative;
            width: 100%;
            height: 120px;
            margin: 20px 0;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        
        @media (max-width: 992px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/site_dash/includes/navbar.php"); ?>

    <!-- Sidebar -->
    <div class="sidebar col-md-3 col-lg-2 d-md-block">
        <div class="position-sticky pt-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-map me-2"></i> Mapa de Sensores
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-graph-up me-2"></i> Histórico
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-exclamation-triangle me-2"></i> Alertas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-gear me-2"></i> Configurações
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid">
            <!-- Alertas -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="alert alert-fire d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill me-3 fs-4" style="color: var(--fire-primary);"></i>
                        <div>
                            <strong>Alerta Crítico</strong> - Sensor #12 detectou temperatura acima de 80°C na Área 3
                        </div>
                        <button class="btn btn-sm btn-outline-danger ms-auto">Ver Detalhes</button>
                    </div>
                </div>
            </div>

            <!-- Cards de Status -->
            <div class="row mb-4">
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-thermometer-high me-2"></i> Temperatura</span>
                            <span class="badge bg-danger">Crítico</span>
                        </div>
                        <div class="card-body text-center">
                            <h1 class="display-4 fw-bold" style="color: var(--fire-primary);">78°C</h1>
                            <p>Área 3 - Sensor #12</p>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 85%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="card h-100">
                        <div class="card-header">
                            <i class="bi bi-droplet me-2"></i> Umidade
                        </div>
                        <div class="card-body text-center">
                            <h1 class="display-4 fw-bold" style="color: #4dabf7;">32%</h1>
                            <p>Média dos sensores</p>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 32%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-fire me-2"></i> Detecção de Chamas</span>
                            <span class="badge bg-success">Estável</span>
                        </div>
                        <div class="card-body text-center">
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="flame-indicator flame-active"></div>
                                <h1 class="display-4 fw-bold m-0">2</h1>
                            </div>
                            <p>Sensores ativos</p>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 15%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráficos -->
            <div class="row mb-4">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <div class="card h-100">
                        <div class="card-header">
                            <i class="bi bi-graph-up me-2"></i> Variação de Temperatura (Últimas 24h)
                        </div>
                        <div class="card-body">
                            <canvas id="temperatureChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <i class="bi bi-pie-chart me-2"></i> Status dos Sensores
                        </div>
                        <div class="card-body">
                            <canvas id="sensorStatusChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabela de Alertas -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="bi bi-exclamation-triangle me-2"></i> Últimos Alertas
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-dark table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Data/Hora</th>
                                            <th>Sensor</th>
                                            <th>Tipo</th>
                                            <th>Valor</th>
                                            <th>Localização</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="table-danger">
                                            <td>10/06/2023 14:32</td>
                                            <td>#12</td>
                                            <td>Temperatura</td>
                                            <td>78°C</td>
                                            <td>Área 3 - Setor B</td>
                                            <td><span class="badge bg-danger">Não Resolvido</span></td>
                                        </tr>
                                        <tr>
                                            <td>10/06/2023 12:15</td>
                                            <td>#08</td>
                                            <td>Chamas</td>
                                            <td>Detectado</td>
                                            <td>Área 1 - Setor A</td>
                                            <td><span class="badge bg-success">Resolvido</span></td>
                                        </tr>
                                        <tr>
                                            <td>10/06/2023 10:47</td>
                                            <td>#05</td>
                                            <td>Umidade</td>
                                            <td>18%</td>
                                            <td>Área 2 - Setor C</td>
                                            <td><span class="badge bg-warning">Monitorando</span></td>
                                        </tr>
                                        <tr>
                                            <td>10/06/2023 08:22</td>
                                            <td>#11</td>
                                            <td>Temperatura</td>
                                            <td>65°C</td>
                                            <td>Área 3 - Setor A</td>
                                            <td><span class="badge bg-success">Resolvido</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script>
        // Gráfico de Temperatura
        const tempCtx = document.getElementById('temperatureChart').getContext('2d');
        const temperatureChart = new Chart(tempCtx, {
            type: 'line',
            data: {
                labels: Array.from({length: 24}, (_, i) => `${i}h`),
                datasets: [{
                    label: 'Temperatura Máxima (°C)',
                    data: [22, 23, 22, 23, 24, 25, 26, 28, 32, 38, 45, 52, 58, 63, 67, 71, 74, 76, 78, 75, 68, 60, 52, 45],
                    borderColor: '#ff3300',
                    backgroundColor: 'rgba(255, 51, 0, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Temperatura Média (°C)',
                    data: [20, 20, 19, 20, 21, 22, 23, 25, 28, 32, 38, 43, 48, 52, 55, 57, 58, 59, 60, 58, 54, 49, 44, 38],
                    borderColor: '#ff9966',
                    backgroundColor: 'rgba(255, 153, 102, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: '#f0f0f0'
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        },
                        ticks: {
                            color: '#f0f0f0'
                        }
                    },
                    y: {
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        },
                        ticks: {
                            color: '#f0f0f0'
                        }
                    }
                }
            }
        });

        // Gráfico de Status dos Sensores
        const statusCtx = document.getElementById('sensorStatusChart').getContext('2d');
        const sensorStatusChart = new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Normal', 'Alerta', 'Crítico', 'Offline'],
                datasets: [{
                    data: [18, 3, 1, 2],
                    backgroundColor: [
                        '#28a745',
                        '#ffc107',
                        '#dc3545',
                        '#6c757d'
                    ],
                    borderColor: '#1e1e1e',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#f0f0f0'
                        }
                    }
                },
                cutout: '70%'
            }
        });

        // Simulação de dados em tempo real
        function simulateRealTimeData() {
            // Atualiza temperatura máxima aleatoriamente
            const tempData = temperatureChart.data.datasets[0].data;
            tempData.push(tempData.shift());
            tempData[23] = Math.min(80, Math.max(20, tempData[23] + (Math.random() * 6 - 3)));
            
            // Atualiza temperatura média
            const avgData = temperatureChart.data.datasets[1].data;
            avgData.push(avgData.shift());
            avgData[23] = Math.min(60, Math.max(18, tempData[23] - 15 + (Math.random() * 4 - 2)));
            
            temperatureChart.update();
            
            // Atualiza status dos sensores periodicamente
            if (Math.random() > 0.7) {
                const statusData = sensorStatusChart.data.datasets[0].data;
                const randomIndex = Math.floor(Math.random() * 4);
                statusData[randomIndex] += Math.random() > 0.5 ? 1 : -1;
                sensorStatusChart.update();
            }
            
            setTimeout(simulateRealTimeData, 5000);
        }
        
        setTimeout(simulateRealTimeData, 5000);
    </script>
</body>
</html>