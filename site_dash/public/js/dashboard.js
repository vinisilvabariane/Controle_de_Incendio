document.addEventListener('DOMContentLoaded', function () {
    // Elementos do DOM
    const dashboardContainer = document.getElementById('dashboard-container');
    const loadingSpinner = document.getElementById('loading-spinner');
    const errorAlert = document.getElementById('error-alert');
    const dataChart = document.getElementById('data-chart');
    const dataTable = document.getElementById('data-table');
    const lastUpdate = document.getElementById('last-update');
    const totalIncidents = document.getElementById('total-incidents');
    const dailyAverage = document.getElementById('daily-average');
    const weeklyChange = document.getElementById('weekly-change');
    const currentAlert = document.getElementById('current-alert');

    // Configuração inicial
    let dashboardData = [];
    let movingAverageData = [];
    const movingAverageWindow = 7; // Janela de 7 dias para a média móvel

    // Inicializar o dashboard
    initDashboard();

    function initDashboard() {
        showLoading();
        fetchDashboardData();

        // Atualizar dados a cada 5 minutos
        setInterval(fetchDashboardData, 300000);
    }

    function fetchDashboardData() {
        fetch('/site_dash/configs/Router.php?action=getDashboardData')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro na resposta da rede');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    dashboardData = data.data;
                    processData();
                    renderDashboard();
                    hideLoading();
                } else {
                    throw new Error(data.message || 'Erro ao carregar dados');
                }
            })
            .catch(error => {
                console.error('Erro ao buscar dados:', error);
                showError(error.message);
                hideLoading();
            });
    }

    function processData() {
        // Ordenar dados por data
        dashboardData.sort((a, b) => new Date(a.date) - new Date(b.date));

        // Calcular médias móveis para temperatura
        movingAverageData = calculateMovingAverage(dashboardData, movingAverageWindow, 'temperatura');

        // Atualizar cards de resumo
        updateSummaryCards();
    }

    function calculateMovingAverage(data, windowSize, field) {
        const result = [];

        for (let i = 0; i < data.length; i++) {
            const start = Math.max(0, i - windowSize + 1);
            const end = i + 1;
            const windowData = data.slice(start, end);

            const sum = windowData.reduce((acc, item) => acc + item[field], 0);
            const average = sum / windowData.length;

            result.push({
                date: data[i].date,
                value: average
            });
        }

        return result;
    }

    function updateSummaryCards() {
        // Total de ocorrências com chama
        const totalFires = dashboardData.filter(item => item.chama).length;
        totalIncidents.textContent = totalFires;

        // Média de temperatura
        const avgTemp = dashboardData.reduce((sum, item) => sum + item.temperatura, 0) / dashboardData.length;
        dailyAverage.textContent = avgTemp.toFixed(1) + '°C';

        // Variação (comparando a primeira e última média móvel de temperatura)
        let weeklyChangeValue = 'N/A';
        if (movingAverageData.length >= movingAverageWindow) {
            const first = movingAverageData[0].value;
            const last = movingAverageData[movingAverageData.length - 1].value;
            const change = ((last - first) / first) * 100;
            weeklyChangeValue = `${change.toFixed(1)}%`;

            weeklyChange.textContent = weeklyChangeValue;
            weeklyChange.className = change >= 0 ? 'text-danger' : 'text-success';
        }

        // Alerta atual (baseado no último registro)
        const lastRecord = dashboardData[dashboardData.length - 1];
        let alertStatus = 'Normal';
        let alertClass = 'text-success';

        if (lastRecord.chama) {
            alertStatus = 'Incêndio!';
            alertClass = 'text-danger';
        } else if (lastRecord.temperatura > 40) {
            alertStatus = 'Alerta Temp.';
            alertClass = 'text-warning';
        } else if (lastRecord.umidade < 20) {
            alertStatus = 'Alerta Umidade';
            alertClass = 'text-warning';
        }

        currentAlert.textContent = alertStatus;
        currentAlert.className = alertClass;
    }

    function renderDashboard() {
        renderChart();
        renderTable();
        updateLastUpdateTime();
    }

    function renderChart() {
        if (typeof Chart === 'undefined') return;

        if (window.dashboardChart) {
            window.dashboardChart.destroy();
        }

        const ctx = dataChart.getContext('2d');
        const labels = dashboardData.map(item => formatDateTime(item.date));
        const temperatures = dashboardData.map(item => item.temperatura);
        const movingAverages = movingAverageData.map(item => item.value);
        const fireIndicators = dashboardData.map(item => item.chama ? 1 : 0);

        window.dashboardChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Temperatura (°C)',
                        data: temperatures,
                        borderColor: '#ff5500',
                        backgroundColor: 'rgba(255, 85, 0, 0.1)',
                        borderWidth: 2,
                        tension: 0.1,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Média Móvel (7 dias)',
                        data: movingAverages,
                        borderColor: '#0066ff',
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        borderDash: [5, 5],
                        tension: 0.4,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Incêndio Detectado',
                        data: dashboardData.map(item => item.chama ? item.temperatura : null),
                        pointBackgroundColor: dashboardData.map(item => item.chama ? '#ff0000' : 'rgba(0,0,0,0)'),
                        pointRadius: dashboardData.map(item => item.chama ? 8 : 0),
                        borderColor: 'transparent',
                        backgroundColor: 'transparent',
                        showLine: false,
                        yAxisID: 'y'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: { color: '#ffffff' }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function (context) {
                                let label = context.dataset.label || '';
                                if (label) label += ': ';
                                if (context.datasetIndex === 2) {
                                    return context.raw ? 'Incêndio detectado' : '';
                                }
                                return label + context.raw.toFixed(1) + (context.datasetIndex < 2 ? '°C' : '');
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { color: 'rgba(255, 255, 255, 0.1)' },
                        ticks: { color: '#ffffff' }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Temperatura (°C)',
                            color: '#ff5500'
                        },
                        grid: { color: 'rgba(255, 255, 255, 0.1)' },
                        ticks: { color: '#ff5500' }
                    }
                }
            }
        });
    }

    function renderTable() {
        dataTable.innerHTML = '';

        const thead = document.createElement('thead');
        thead.innerHTML = `
            <tr class="bg-dark text-light">
                <th>Data/Hora</th>
                <th>Temp. (°C)</th>
                <th>Umidade (%)</th>
                <th>Incêndio</th>
                <th>Resultado</th>
                <th>Média Temp. (7d)</th>
            </tr>
        `;
        dataTable.appendChild(thead);

        const tbody = document.createElement('tbody');

        dashboardData.forEach((item, index) => {
            const row = document.createElement('tr');
            row.className = index % 2 === 0 ? 'bg-dark bg-opacity-10' : 'bg-dark bg-opacity-20';

            const formattedDate = formatDateTime(item.date);
            const movingAvg = index >= movingAverageWindow - 1 ?
                movingAverageData[index].value.toFixed(1) : 'N/A';

            row.innerHTML = `
                <td>${formattedDate}</td>
                <td>${item.temperatura.toFixed(1)}</td>
                <td>${item.umidade.toFixed(1)}</td>
                <td>${item.chama ? '<span class="badge bg-danger">Sim</span>' : '<span class="badge bg-success">Não</span>'}</td>
                <td>${item.resultado || '-'}</td>
                <td>${movingAvg}</td>
            `;

            tbody.appendChild(row);
        });

        dataTable.appendChild(tbody);
    }

    function formatDateTime(dateString) {
        const options = {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        };
        return new Date(dateString).toLocaleDateString('pt-BR', options);
    }

    function updateLastUpdateTime() {
        const now = new Date();
        lastUpdate.textContent = `Última atualização: ${now.toLocaleTimeString('pt-BR')}`;
    }

    function showLoading() {
        loadingSpinner.classList.remove('d-none');
        dashboardContainer.classList.add('d-none');
        errorAlert.classList.add('d-none');
    }

    function hideLoading() {
        loadingSpinner.classList.add('d-none');
        dashboardContainer.classList.remove('d-none');
    }

    function showError(message) {
        errorAlert.textContent = `Erro: ${message}`;
        errorAlert.classList.remove('d-none');
        dashboardContainer.classList.add('d-none');
    }
});