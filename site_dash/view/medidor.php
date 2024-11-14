<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medidor Índice</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/style.css">
</head>

<body>

    <!-- Barra de navegação -->
    <nav class="navbar navbar-expand-lg custom-navbar">
        <a class="navbar-brand" href="/index.php">FireWatch</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/index.php">Home</a>
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

    <!-- Container Principal do Dashboard -->
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card">
                    <div class="card-header">Gráfico de Temperatura</div>
                    <div class="card-body">
                        <canvas id="chartTemperatura"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card">
                    <div class="card-header">Gráfico de Umidade</div>
                    <div class="card-body">
                        <canvas id="chartUmidade"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2024 FireWatch. Todos os direitos reservados.</p>
        <p>
            <a href="/index.php">Home</a> |
            <a href="medidor.php">Medidor de Índices</a> |
            <a href="tabela.php">Tabela de Dados</a>
        </p>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="/public/js/graficos.js"></script>
</body>

</html>
