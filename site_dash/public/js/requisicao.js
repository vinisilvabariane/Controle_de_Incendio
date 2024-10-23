$(document).ready(function() {
    $.ajax({
        url: '/router/router.php?action=getData',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.length > 0) {
                $('#dataTableBody').empty();
                data.forEach(item => {
                    let row = `
                        <tr>
                            <td>${item.idDados}</td>
                            <td>${item.umidade}</td>
                            <td>${item.temperatura}</td>
                            <td>${item.chama}</td>
                            <td>${item.fumaça}</td>
                            <td>${item.data_verificacao}</td>
                            <td>${item.resultado}</td>
                        </tr>
                    `;
                    $('#dataTableBody').append(row);
                });
            } else {
                $('#dataTableBody').html('<tr><td colspan="6">Nenhum dado encontrado</td></tr>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Erro ao carregar dados:', error);
        }
    });
});
