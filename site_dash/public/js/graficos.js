const chart1Data = {
  labels: ['800', '598', '100', '200', '400', '750', '900', '1000'],
  datasets: [{
    label: 'Temperatura',
    data: [100, 150, 300, 500, 750, 900, 1050, 1150],
    backgroundColor: 'red',
    borderColor: 'red',
    borderWidth: 1
  }, {
    label: 'Fumaça',
    data: [800, 600, 100, 200, 400, 750, 900, 1000],
    backgroundColor: 'white',
    borderColor: 'white',
    borderWidth: 1
  }, {
    label: 'Umidade',
    data: [100, 100, 50, 50, 50, 50, 50, 50],
    backgroundColor: 'skyblue',
    borderColor: 'skyblue',
    borderWidth: 1
  }]
};

const chart2Data = {
  labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
  datasets: [{
    label: 'Focos de incêndio',
    data: [2000, 1000, 3000, 6000, 8000, 12000, 16000, 30000, 45000, 48000, 28000, 10000],
    backgroundColor: 'red',
    borderColor: 'red',
    borderWidth: 2
  }]
};

const chart1Canvas = document.getElementById('chart1');
const chart1 = new Chart(chart1Canvas, {
  type: 'line',
  data: chart1Data,
  options: {
    scales: {
      x: { // Eixo X definido corretamente
        beginAtZero: true, // Inicia o eixo a partir de zero
        ticks: {
          color: 'white' // Define a cor dos rótulos do eixo x
        }
      },
      y: { // Eixo Y
        beginAtZero: true,
        ticks: {
          color: 'white' // Define a cor dos rótulos do eixo y
        }
      }
    }
  }
});

const chart2Canvas = document.getElementById('chart2');
const chart2 = new Chart(chart2Canvas, {
  type: 'bar',
  data: chart2Data,
  options: {
    scales: {
      x: { // Eixo X definido corretamente
        beginAtZero: true, // Inicia o eixo a partir de zero
        ticks: {
          color: 'white' // Define a cor dos rótulos do eixo x
        }
      },
      y: { // Eixo Y
        beginAtZero: true,
        ticks: {
          color: 'white' // Define a cor dos rótulos do eixo y
        }
      }
    }
  }
});