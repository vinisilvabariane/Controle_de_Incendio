<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/site_dash/configs/authenticator.php"); ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" sizes="16x16" href="/site_dash/public/img/imagemF_fire.png">
    <title>FireWatch - FAQ</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/darkly/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/site_dash/public/css/fonts.css">
    <link rel="stylesheet" href="./style.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/site_dash/includes/navbar.php"); ?>

    <!-- Cabeçalho do FAQ -->
    <header class="faq-header">
        <!-- Particles.js Container -->
        <div id="particles-js-faq"></div>

        <div class="container text-center position-relative z-2">
            <div class="mb-4">
                <span
                    class="badge bg-danger bg-opacity-25 text-warning rounded-pill px-3 py-2 mb-3 d-inline-block fade-in">
                    <i class="bi bi-question-circle-fill me-2"></i>Central de Ajuda
                </span>
            </div>

            <h1 class="display-3 fw-bold mb-4 text-white hero-title">
                <span class="d-block">Perguntas</span>
                <span class="text-danger">Frequentes</span>
            </h1>

            <p class="lead text-warning mb-5 mx-auto fade-in delay-1" style="max-width: 700px;">
                Encontre respostas rápidas para todas as suas dúvidas sobre o FireWatch.
            </p>

            <div class="search-box fade-in delay-2">
                <div class="input-group input-group-lg mb-3 mx-auto" style="max-width: 600px;">
                    <span class="input-group-text bg-dark border-danger text-warning">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" id="faq-search" class="form-control bg-dark border-danger text-white py-3"
                        placeholder="Buscar no FAQ..." autocomplete="off">
                    <button class="btn btn-danger px-4" type="button" id="search-button">
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </div>

            <div class="scroll-indicator fade-in delay-3">
                <a href="#faq-content" class="text-warning d-inline-block">
                    <i class="bi bi-chevron-down fs-4 animate-bounce"></i>
                </a>
            </div>
        </div>

        <!-- Divisor de Chamas -->
        <div class="flames-divider">
            <svg viewBox="0 0 1200 120" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path
                    d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z"
                    opacity=".25" class="shape-fill"></path>
                <path
                    d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z"
                    opacity=".5" class="shape-fill"></path>
                <path
                    d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z"
                    class="shape-fill"></path>
            </svg>
        </div>
    </header>

    <!-- Conteúdo Principal -->
    <main class="container my-5" id="faq-content">
        <div class="row">
            <div class="col-lg-8" id="faq-accordion">
                <!-- Categoria: Acesso ao Sistema -->
                <div class="faq-category fade-in delay-1" data-category="acesso">
                    <h3 class="text-warning"><i class="bi bi-door-open me-2"></i> Acesso ao Sistema</h3>
                    <div class="accordion" id="accordionAccess">
                        <div class="accordion-item mb-3 border-danger bg-dark bg-opacity-25 shadow-sm fade-in delay-2"
                            data-search="acesso portal firewatch login credenciais primeiro acesso senha">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed bg-dark text-white" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#accessQuestion1">
                                    Como faço para acessar o FireWatch?
                                </button>
                            </h2>
                            <div id="accessQuestion1" class="accordion-collapse collapse bg-dark"
                                data-bs-parent="#accordionAccess">
                                <div class="accordion-body text-white-75">
                                    Para acessar o FireWatch, você precisa utilizar as credenciais fornecidas
                                    pela sua organização. Basta acessar a página de login e inserir seu e-mail
                                    e senha. Caso seja seu primeiro acesso, você receberá um e-mail com instruções
                                    para criar sua senha.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item mb-3 border-danger bg-dark bg-opacity-25 shadow-sm fade-in delay-2"
                            data-search="esqueci senha redefinir recuperar login e-mail spam suporte técnico">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed bg-dark text-white" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#accessQuestion2">
                                    Esqueci minha senha. O que fazer?
                                </button>
                            </h2>
                            <div id="accessQuestion2" class="accordion-collapse collapse bg-dark"
                                data-bs-parent="#accordionAccess">
                                <div class="accordion-body text-white-75">
                                    Na página de login, clique em "Esqueci minha senha" e insira o e-mail cadastrado.
                                    Você receberá um link para redefinir sua senha. Caso não receba o e-mail em alguns
                                    minutos, verifique sua pasta de spam ou entre em contato com o suporte técnico.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Categoria: Monitoramento -->
                <div class="faq-category fade-in delay-2" data-category="monitoramento">
                    <h3 class="text-warning"><i class="bi bi-thermometer-sun me-2"></i> Monitoramento</h3>
                    <div class="accordion" id="accordionMonitoring">
                        <div class="accordion-item mb-3 border-danger bg-dark bg-opacity-25 shadow-sm fade-in delay-3"
                            data-search="consultar status alertas monitorar validade filtrar">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed bg-dark text-white" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#monitoringQuestion1">
                                    Como consulto os alertas de incêndio?
                                </button>
                            </h2>
                            <div id="monitoringQuestion1" class="accordion-collapse collapse bg-dark"
                                data-bs-parent="#accordionMonitoring">
                                <div class="accordion-body text-white-75">
                                    Após fazer login no sistema, acesse a seção "Painel de Monitoramento". Lá você
                                    encontrará
                                    uma lista de todos os alertas ativos, com informações sobre localização, intensidade
                                    e
                                    tempo de detecção. Você pode filtrar por região ou nível de risco para encontrar os
                                    alertas mais relevantes.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item mb-3 border-danger bg-dark bg-opacity-25 shadow-sm fade-in delay-3"
                            data-search="receber notificações alertas configuração e-mail sms push">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed bg-dark text-white" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#monitoringQuestion2">
                                    Como receber notificações de alertas?
                                </button>
                            </h2>
                            <div id="monitoringQuestion2" class="accordion-collapse collapse bg-dark"
                                data-bs-parent="#accordionMonitoring">
                                <div class="accordion-body text-white-75">
                                    Para configurar notificações, acesse "Configurações" > "Notificações". Você pode
                                    escolher
                                    receber alertas por e-mail, SMS ou notificações push. É possível definir quais tipos
                                    de
                                    alertas deseja receber e o nível mínimo de risco para cada canal de notificação.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Categoria: Problemas Técnicos -->
                <div class="faq-category fade-in delay-3" data-category="tecnico">
                    <h3 class="text-warning"><i class="bi bi-tools me-2"></i> Problemas Técnicos</h3>
                    <div class="accordion" id="accordionTech">
                        <div class="accordion-item mb-3 border-danger bg-dark bg-opacity-25 shadow-sm fade-in delay-4"
                            data-search="sistema lento não carrega desempenho navegador atualizar cache cookies internet conexão chrome firefox edge">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed bg-dark text-white" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#techQuestion1">
                                    O sistema está lento ou não carrega corretamente. O que fazer?
                                </button>
                            </h2>
                            <div id="techQuestion1" class="accordion-collapse collapse bg-dark"
                                data-bs-parent="#accordionTech">
                                <div class="accordion-body text-white-75">
                                    Se estiver enfrentando problemas de desempenho, recomendamos:
                                    <ol>
                                        <li>Atualizar seu navegador para a versão mais recente</li>
                                        <li>Limpar o cache e os cookies do navegador</li>
                                        <li>Verificar sua conexão com a internet</li>
                                        <li>Tentar acessar por outro navegador (Chrome, Firefox, Edge)</li>
                                    </ol>
                                    Se o problema persistir, entre em contato com nosso suporte técnico.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item mb-3 border-danger bg-dark bg-opacity-25 shadow-sm fade-in delay-4"
                            data-search="visualizar baixar relatórios pdf mapas adobe reader pop-ups firewall antivírus download">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed bg-dark text-white" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#techQuestion2">
                                    Não consigo visualizar ou baixar relatórios. Como resolver?
                                </button>
                            </h2>
                            <div id="techQuestion2" class="accordion-collapse collapse bg-dark"
                                data-bs-parent="#accordionTech">
                                <div class="accordion-body text-white-75">
                                    Alguns relatórios podem exigir softwares específicos para visualização. Verifique
                                    se:
                                    <ul>
                                        <li>Você tem um leitor de PDF instalado (como Adobe Reader)</li>
                                        <li>Seu navegador não está bloqueando pop-ups</li>
                                        <li>Seu firewall ou antivírus não está bloqueando o download</li>
                                    </ul>
                                    Caso continue com problemas, tente acessar de outro dispositivo.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar de Contato -->
            <div class="col-lg-4">
                <div class="card shadow-sm mb-4 border-danger bg-dark bg-opacity-25 fade-in delay-2">
                    <div class="card-body contact-card">
                        <h4 class="card-title mb-3 text-warning"><i class="bi bi-headset me-2"></i> Precisa de mais
                            ajuda?</h4>
                        <p class="card-text text-white-75">Se não encontrou resposta para sua dúvida, nossa equipe de
                            suporte está
                            pronta para ajudar.</p>

                        <div class="mb-3">
                            <h5 class="text-warning"><i class="bi bi-envelope me-2"></i> E-mail</h5>
                            <p class="text-white-75">suporte@firewatch.com.br</p>
                        </div>

                        <div class="mb-3">
                            <h5 class="text-warning"><i class="bi bi-telephone me-2"></i> Telefone</h5>
                            <p class="text-white-75">(11) 9876-5432 (Seg-Sex, 9h-18h)</p>
                        </div>

                        <div class="mb-3">
                            <h5 class="text-warning"><i class="bi bi-chat-left-text me-2"></i> Chat Online</h5>
                            <p class="text-white-75">Disponível no canto inferior direito da tela durante o horário
                                comercial</p>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-danger bg-dark bg-opacity-25 fade-in delay-3">
                    <div class="card-body">
                        <h4 class="card-title mb-3 text-warning"><i class="bi bi-info-circle me-2"></i> Dicas Rápidas
                        </h4>
                        <ul class="list-group list-group-flush bg-transparent">
                            <li
                                class="list-group-item d-flex align-items-center bg-transparent text-white-75 border-danger fade-in delay-4">
                                <i class="bi bi-search me-3 text-danger"></i>
                                <span>Use palavras-chave na busca para encontrar respostas mais rápido</span>
                            </li>
                            <li
                                class="list-group-item d-flex align-items-center bg-transparent text-white-75 border-danger fade-in delay-4">
                                <i class="bi bi-bookmark me-3 text-danger"></i>
                                <span>Marque páginas importantes nos seus favoritos para acesso rápido</span>
                            </li>
                            <li
                                class="list-group-item d-flex align-items-center bg-transparent text-white-75 border-danger fade-in delay-4">
                                <i class="bi bi-download me-3 text-danger"></i>
                                <span>Mantenha cópias digitais dos relatórios importantes</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Rodapé -->
    <footer class="mt-auto py-3 bg-black">
        <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/site_dash/includes/footer.php"); ?>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script src="/site_dash/public/js/fade-in.js"></script>
    <script src="/site_dash/public/js/doubts.js"></script>
</body>

</html>