<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/style.css">
    <title>Medidor Índice</title>

<body>
    <!-- Barra de navegação -->
    <nav class="navbar navbar-expand-lg custom-navbar">
        <a class="navbar-brand" href="#">FireWatch</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/index.php" >Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="medidor.php">Medidor de Índices</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tabela.php">Tabela de dados</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Container do Dashboard -->
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Gráfico de Índices -->
            <div class="col-lg-6 col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        Gráfico de Índices
                    </div>
                    <div class="card-body">
                        <canvas id="chart1"></canvas>
                    </div>
                   
                </div>
            </div>

            <!-- Estatísticas -->
            <div class="col-lg-3 col-md-6">
            <div class="card mb-4 custom-card-graph">
                    <div class="card-body">
                    <div class="card-body position-relative"> <!-- Adicione position-relative -->
                    <img src="/img/fogo.png" class="img-overlay" ></div>
                        <h5 class="card-title">Incêndios Ocorridos</h5>
                        <p class="card-text">208.905</p>     
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
            <div class="card mb-4 custom-card-fire">
                    <div class="card-body">
                    <div class="card-body position-relative"> <!-- Adicione position-relative -->
                    <img src="/img/bombeiro.png" class="img-overlay" ></div>
                        <h5 class="card-title">Queimadas Apagadas</h5>
                        <p class="card-text">167.124</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Outro gráfico -->
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        Focos de Incêndio
                    </div>
                    <div class="card-body">
                        <canvas id="chart2"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </head>
    <footer>
        <p>&copy; 2024 FireWatch. Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="/public/js/graficos.js"></script>
    
</body>

</html>
