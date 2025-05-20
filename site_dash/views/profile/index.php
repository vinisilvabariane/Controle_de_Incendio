<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/site_dash/configs/authenticator.php"); ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" sizes="16x16" href="/site_dash/public/img/play.svg">
    <title>Multi Garantia - Perfil</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/cosmo/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="/site_dash/public/css/fonts.css">
    <link rel="stylesheet" href="./style.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/site_dash/includes/navbar.php"); ?>
    
    <section class="profile-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="profile-card fade-in">
                        <div class="profile-header">
                            <div class="profile-icon">
                                <i class="bi bi-person-circle"></i>
                            </div>
                            <h1 class="profile-name"><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Usuário'); ?></h1>
                            <p class="profile-role"><?php echo htmlspecialchars($_SESSION['user_role'] ?? 'Membro'); ?></p>
                        </div>
                        
                        <div class="profile-body">
                            <div class="detail-group fade-in delay-1">
                                <h5>Informações Pessoais</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <div class="detail-label">Email</div>
                                            <div class="detail-value"><?php echo htmlspecialchars($_SESSION['user_email'] ?? 'email@exemplo.com'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <div class="detail-label">Telefone</div>
                                            <div class="detail-value"><?php echo htmlspecialchars($_SESSION['user_phone'] ?? '(00) 00000-0000'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <div class="detail-label">CPF</div>
                                            <div class="detail-value"><?php echo htmlspecialchars($_SESSION['user_cpf'] ?? '000.000.000-00'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <div class="detail-label">Data de Cadastro</div>
                                            <div class="detail-value"><?php echo htmlspecialchars($_SESSION['user_created_at'] ?? '00/00/0000'); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="detail-group fade-in delay-2">
                                <h5>Endereço</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <div class="detail-label">Logradouro</div>
                                            <div class="detail-value">
                                                <?php 
                                                    $street = ($_SESSION['user_street'] ?? 'Rua Exemplo') . ', ' . ($_SESSION['user_number'] ?? '00');
                                                    echo htmlspecialchars($street);
                                                    if (!empty($_SESSION['user_complement'])) {
                                                        echo ', ' . htmlspecialchars($_SESSION['user_complement']);
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <div class="detail-label">Bairro</div>
                                            <div class="detail-value"><?php echo htmlspecialchars($_SESSION['user_district'] ?? 'Bairro'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="detail-item">
                                            <div class="detail-label">Cidade</div>
                                            <div class="detail-value"><?php echo htmlspecialchars($_SESSION['user_city'] ?? 'Cidade'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="detail-item">
                                            <div class="detail-label">Estado</div>
                                            <div class="detail-value"><?php echo htmlspecialchars($_SESSION['user_state'] ?? 'UF'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="detail-item">
                                            <div class="detail-label">CEP</div>
                                            <div class="detail-value"><?php echo htmlspecialchars($_SESSION['user_zipcode'] ?? '00000-000'); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-center mt-4 fade-in delay-3">
                                <a href="/site_dash/views/profile/edit.php" class="btn btn-edit">
                                    <i class="bi bi-pencil-square me-2"></i> Editar Perfil
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Rodapé -->
    <footer class="mt-auto py-3">
        <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/site_dash/includes/footer.php"); ?>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Animação de aparecimento suave
        document.addEventListener('DOMContentLoaded', function() {
            // Mostrar elementos com atraso
            const animateElements = () => {
                document.querySelectorAll('.fade-in').forEach((el, index) => {
                    setTimeout(() => {
                        el.classList.add('visible');
                    }, index * 150);
                });
            };
            
            // Iniciar animações
            animateElements();
            
            // Configurar observer para elementos que possam aparecer durante o scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, { threshold: 0.1 });
            
            document.querySelectorAll('.fade-in').forEach(el => {
                observer.observe(el);
            });
        });
    </script>
</body>

</html>