<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark shadow-sm py-2" style="border-bottom: 1px solid #ff5500;">
  <div class="container-fluid d-flex justify-content-start">

    <!-- Logo -->
    <a class="navbar-brand d-flex align-items-center fs-4 fw-bold" href="/site_dash/views/home/" style="color: #ffffff;">
      <img src="/site_dash/public/img/imagemF_fire.png" width="40" class="me-2" alt="FireWatch Logo">
    </a>

    <!-- Botão para mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggle" aria-controls="navbarToggle" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Itens do menu -->
    <div class="collapse navbar-collapse justify-content-end" id="navbarToggle">
      <ul class="navbar-nav align-items-center gap-2 gap-lg-3">
        <li class="nav-item">
          <a class="nav-link position-relative px-2 px-lg-3 py-2" href="/site_dash/views/dash/" style="color: #ffffff; font-weight: 500;">
            <i class="bi bi-fire me-1 d-lg-none"></i>
            <span>Alertas de Incêndio</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-2 px-lg-3 py-2" href="/site_dash/views/doubts/" style="color: #ffffff; font-weight: 500;">
            <i class="bi bi-question-circle me-1 d-lg-none"></i>
            <span>Dúvidas</span>
          </a>
        </li>
        <li class="nav-item dropdown d-none d-lg-block">
          <a class="nav-link dropdown-toggle px-3 py-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: #ffffff; font-weight: 500;">
            <i class="bi bi-person-circle me-1"></i>
            Minha Conta
          </a>
          <ul class="dropdown-menu dropdown-menu-end mt-2 border-0 shadow-sm" style="min-width: 200px; background-color: #333;">
            <li><a class="dropdown-item py-2 text-light" href="/site_dash/views/profile/index.php"><i class="bi bi-person me-2"></i> Perfil</a></li>
            <li><hr class="dropdown-divider" style="border-color: #555;"></li>
            <li><a class="dropdown-item py-2 text-danger" href="/site_dash/views/login/"><i class="bi bi-box-arrow-right me-2"></i> Sair</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>