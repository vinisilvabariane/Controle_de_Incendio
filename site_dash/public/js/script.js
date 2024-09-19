const chartResultados = document.getElementById('chart-resultados').getContext('2d');
const chartReceita = document.getElementById('chart-receita').getContext('2d');
const chartMargemLiquida = document.getElementById('chart-margem-liquida').getContext('2d');
const chartLucratividade = document.getElementById('chart-lucratividade').getContext('2d');
const inputCSV = document.getElementById('input-csv');

// Inicializando os gráficos com dados fictícios
const chartResultadosInstance = new Chart(chartResultados, {
  type: 'bar',
  data: {
    labels: [], // Labels serão atualizados com os dados do CSV
    datasets: [
      {
        label: 'Tempo',
        data: [], // Dados serão atualizados com os dados do CSV
        backgroundColor: '#42c59f',
        borderColor: '#42c59f',
        borderWidth: 1
      },
      {
        label: 'Falha',
        data: [], // Dados serão atualizados com os dados do CSV
        backgroundColor: '#f06292',
        borderColor: '#f06292',
        borderWidth: 1
      },
      {
        label: 'Índice',
        data: [], // Dados serão atualizados com os dados do CSV
        backgroundColor: '#ffcc00',
        borderColor: '#ffcc00',
        borderWidth: 1
      }
    ]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});

const chartReceitaInstance = new Chart(chartReceita, {
  type: 'line',
  data: {
    labels: [], // Labels serão atualizados com os dados do CSV
    datasets: [
      {
        label: 'Tempo',
        data: [], // Dados serão atualizados com os dados do CSV
        backgroundColor: '#42c59f',
        borderColor: '#42c59f',
        borderWidth: 1
      }
    ]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});

const chartMargemLiquidaInstance = new Chart(chartMargemLiquida, {
  type: 'doughnut',
  data: {
    labels: ['Margem Líquida'],
    datasets: [{
      data: [0], // Valor inicial será atualizado com os dados do CSV
      backgroundColor: ['#2980b9'],
      borderWidth: 0
    }]
  },
  options: {
    plugins: {
      legend: {
        display: false
      }
    }
  }
});

const chartLucratividadeInstance = new Chart(chartLucratividade, {
  type: 'doughnut',
  data: {
    labels: ['Tempo', 'Índice', 'Falha'],
    datasets: [{
      data: [0, 0, 0], // Valores iniciais serão atualizados com os dados do CSV
      backgroundColor: ['#42c59f', '#ffcc00', '#f06292'],
      borderWidth: 0
    }]
  },
  options: {
    plugins: {
      legend: {
        display: true,
        position: 'bottom'
      }
    }
  }
});

// Função para atualizar gráficos com dados do CSV
function atualizarGraficos(dadosCSV) {
  // Verifique se os dados estão sendo recebidos corretamente
  console.log(dadosCSV);

  // Verifique se os dados possuem as colunas esperadas
  if (!dadosCSV.length || !dadosCSV[0]['Falhas'] || !dadosCSV[0]['Tempo(s)'] || !dadosCSV[0]['Coeficiente']) {
    console.error('O CSV não contém as colunas esperadas: Falhas, Tempo(s), Coeficiente.');
    return;
  }

  const labels = dadosCSV.map(row => row['Coeficiente']); // Usando 'Coeficiente' para labels
  const receitas = dadosCSV.map(row => parseFloat(row['Tempo(s)']));
  const gastos = dadosCSV.map(row => parseFloat(row['Falhas']));
  const lucro = receitas.map((rec, index) => rec - gastos[index]);

  // Atualizando gráficos
  chartResultadosInstance.data.labels = labels;
  chartResultadosInstance.data.datasets[0].data = receitas;
  chartResultadosInstance.data.datasets[1].data = gastos;
  chartResultadosInstance.data.datasets[2].data = lucro;
  chartResultadosInstance.update();

  chartReceitaInstance.data.labels = labels;
  chartReceitaInstance.data.datasets[0].data = receitas;
  chartReceitaInstance.update();

  const margemLiquida = (lucro.reduce((a, b) => a + b, 0) / receitas.reduce((a, b) => a + b, 0)) * 100;
  chartMargemLiquidaInstance.data.datasets[0].data = [margemLiquida];
  chartMargemLiquidaInstance.update();

  const totalReceita = receitas.reduce((a, b) => a + b, 0);
  const totalLucro = lucro.reduce((a, b) => a + b, 0);
  const totalGastos = gastos.reduce((a, b) => a + b, 0);
  chartLucratividadeInstance.data.datasets[0].data = [totalReceita, totalLucro, totalGastos];
  chartLucratividadeInstance.update();
}

// Função para carregar e processar o CSV
function carregarCSV(event) {
  const file = event.target.files[0];
  if (file) {
    Papa.parse(file, {
      header: true,
      skipEmptyLines: true,
      complete: (results) => {
        // Verifique o conteúdo dos resultados
        console.log(results);
        atualizarGraficos(results.data);
      },
      error: (error) => {
        console.error('Erro ao ler o arquivo CSV:', error);
      }
    });
  }
}

// Adicionando um listener para o input de arquivo CSV
inputCSV.addEventListener('change', carregarCSV);
