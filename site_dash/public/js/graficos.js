async function carregarDados() {
    try {
        const response = await fetch('/router/router.php?action=getData');
        const dados = await response.json();
        const dadosTemperatura = dados.map(item => item.temperatura);
        const dadosUmidade = dados.map(item => item.umidade);
        const dadosFumaca = dados.map(item => item.fumaca);
        const labels = dados.map(item => item.data_verificacao);
        atualizarGrafico(chartTemperatura, labels, dadosTemperatura);
        atualizarGrafico(chartUmidade, labels, dadosUmidade);
        atualizarGrafico(chartFumaca, labels, dadosFumaca);
    } catch (error) {
        console.error("Erro ao carregar dados:", error);
    }
}

// Função para atualizar um gráfico com novos dados
function atualizarGrafico(grafico, labels, dados) {
    grafico.data.labels = labels;
    grafico.data.datasets[0].data = dados;
    grafico.update();
}

// Criação dos gráficos com Chart.js
const ctxTemperatura = document.getElementById('chartTemperatura').getContext('2d');
const chartTemperatura = new Chart(ctxTemperatura, {
    type: 'line',
    data: {
        labels: [], // Inicialmente vazio
        datasets: [{
            label: 'Temperatura (°C)',
            data: [],
            borderColor: 'red',
            fill: false
        }]
    }
});

const ctxUmidade = document.getElementById('chartUmidade').getContext('2d');
const chartUmidade = new Chart(ctxUmidade, {
    type: 'line',
    data: {
        labels: [],
        datasets: [{
            label: 'Umidade (%)',
            data: [],
            borderColor: 'blue',
            fill: false
        }]
    }
});

carregarDados();