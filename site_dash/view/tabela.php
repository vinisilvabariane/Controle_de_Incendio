<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/public/css/tabela.css">
 

    <title>Tabela</title>
       <!-- Barra de navegação -->
    <nav class="navbar navbar-expand-lg custom-navbar">
        <a class="navbar-brand" href="#">FireWatch</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php" >Home</a>
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

</head>

<body>
    
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
    <footer>
        <p>&copy; 2024 FireWatch. Todos os direitos reservados.</p>
    </footer>
</html>