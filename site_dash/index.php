<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/index.css">
    <title>FireWatch</title>
</head> 

<body>
  
    <div class="container">
        <h1 style="margin-bottom: 70px; color: #ffffff;">Bem-vindo ao Sistema de Prevenção de Incêndios</h1>
        <p style="margin-bottom: 70px;font-size: 25px;">Selecione uma opção abaixo:</p>
        <a href="view/medidor.php" class="btn btn-custom;" style ="background-color: #680000; color:aliceblue"><img src="img/icons8-gráfico-50.png" style="width: 80px; height: 60px;margin-right: 10px; ">Medidor de Índice</a>
        <a href="view/tabela.php" class="btn btn-custom" style ="background-color: #680000; color:aliceblue"><img src="img/icons8-inserir-tabela-60.png" style="width: 80px; height: 60px;margin-right: 10px; ">Visualizar Tabela</a>
    </div>

    <footer>
        <p>&copy; 2024 FireWatch. Todos os direitos reservados.</p>
    </footer>


    <script src='/public/js/graficos.js'></script>
    <script src='/public/js/requisicao.js'></script>
    <script src='/public/js/script.js'></script>
</body>

</html>
