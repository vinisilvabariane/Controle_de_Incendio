<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/style.css">
    <title>Medidor Índice</title>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="chart">
                <canvas id="chart1"></canvas>
            </div>
            <div class="legend">
                <div class="legend-item">
                    <div class="legend-color" style="background-color: red;"></div>
                    <span>Temperatura</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: #333;"></div>
                    <span>Fumaça</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: skyblue;"></div>
                    <span>Umidade</span>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-title">
                Incêndios ocorridos
            </div>
            <div class="data-label">
                208.905
            </div>
        </div>
        <div class="card">
            <div class="card-title">
                Queimadas apagadas
            </div>
            <div class="data-label">
                167.124
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <div class="chart">
                <canvas id="chart2"></canvas>
            </div>
            <div class="legend">
                <div class="legend-color" style="background-color: red;"></div>
                <span>Focos de incêndio</span>
            </div>
        </div>
    </div>

    <div class="container">
        <h2 class="mt-4">Dados Armazenados</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Umidade</th>
                    <th>Temperatura</th>
                    <th>Chama</th>
                    <th>Fumaça</th>
                    <th>Data de Verificação</th>
                </tr>
            </thead>
            <tbody id="dataTableBody">
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="/public/js/graficos.js"></script>
    <script src="/public/js/requisicao.js"></script>
</body>

</html>