<footer style="background-color: #1a1a1a; padding: 40px 20px; font-family: Arial, sans-serif; color: #ffffff;">
    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; max-width: 1200px; margin: auto; padding: 20px 0;">
        <!-- Coluna 1: Redes sociais + logo -->
        <div style="flex: 1 1 300px; margin-bottom: 20px;">
            <p><strong>Siga-nos</strong></p>
            <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                <a href="#"><img src="https://cdn-icons-png.flaticon.com/24/2111/2111463.png" alt="Instagram" style="filter: invert(1);" /></a>
                <a href="#"><img src="https://cdn-icons-png.flaticon.com/24/733/733547.png" alt="Facebook" style="filter: invert(1);" /></a>
                <a href="#"><img src="https://cdn-icons-png.flaticon.com/24/1384/1384060.png" alt="YouTube" style="filter: invert(1);" /></a>
                <a href="#"><img src="https://cdn-icons-png.flaticon.com/24/145/145807.png" alt="LinkedIn" style="filter: invert(1);" /></a>
            </div>
            <img src="/site_dash/public/img/imagemF_fire.png" alt="FireWatch Logo" style="width: 120px;">
        </div>

        <!-- Coluna 2: Informações da empresa -->
        <div style="flex: 1 1 300px; margin-bottom: 20px;">
            <p style="font-size: 12px; color: #aaa;">
                <strong>FIREWATCH MONITORAMENTO LTDA</strong><br>
                CNPJ 00.000.000/0001-00<br>
                Inscrição 000.000.000.000<br>
                Av. São Francisco, Nº 218, Jardim São José<br>
                CEP 12916-900 - Bragança Paulista – SP
            </p>
        </div>
    </div>

    <!-- Linha de direitos autorais -->
    <div style="border-top: 1px solid #ff5500; max-width: 1200px; margin: 0 auto; padding: 20px 0;">
        <div style="text-align: center;">
            <small style="color: #ff9966;">&copy; <span id="current-year">2024</span> FireWatch - Todos os direitos reservados.</small>
        </div>
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const yearSpan = document.getElementById('current-year');
        if (yearSpan) {
            yearSpan.textContent = new Date().getFullYear();
        }
    });
</script>