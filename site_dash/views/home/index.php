<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/site_dash/configs/authenticator.php"); ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" sizes="16x16" href="/site_dash/public/img/imagemF_fire.png">
    <title>FireWatch - Monitoramento de Incêndios</title>
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
    <section class="hero-section vh-100 d-flex align-items-center">
        <!-- Particles.js Container -->
        <div id="particles-js"></div>
        
        <div class="container h-100">
            <div class="row align-items-center h-100">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <h1 class="hero-title fade-in slide-up">
                            <span>Monitoramento de</span>
                            <span class="text-danger">Incêndios</span>
                        </h1>
                        <p class="hero-subtitle fade-in slide-up delay-1">
                            O FireWatch oferece uma solução completa para monitorar e prevenir incêndios florestais. 
                            Acompanhe em tempo real, receba alertas e gerencie situações de risco com nossa plataforma.
                        </p>
                        <div class="hero-buttons d-flex gap-3 fade-in slide-up delay-2">
                            <a href="/site_dash/views/dash/" class="btn btn-hero-primary">
                                <i class="bi bi-fire me-2"></i> Ver Alertas
                            </a>
                            <a href="#features" class="btn btn-hero-outline">
                                <i class="bi bi-info-circle me-2"></i> Como Funciona
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="hero-animation fade-in delay-3">
                        <img src="/site_dash/public/img/imagemF_fire.png" alt="FireWatch" class="img-fluid" style="max-height: 400px;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Divisor de Chamas -->
        <div class="flames-divider">
            <svg viewBox="0 0 1200 120" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="shape-fill"></path>
                <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="shape-fill"></path>
                <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="shape-fill"></path>
            </svg>
        </div>
    </section>

    <!-- Seção de Recursos -->
    <section id="features" class="py-5 bg-dark">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col">
                    <h2 class="fw-bold fade-in text-light">Como o FireWatch pode te ajudar</h2>
                    <p class="text-warning fade-in delay-1">Conheça nossos principais recursos de monitoramento</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm fade-in bg-danger bg-opacity-10">
                        <div class="card-body text-center p-4">
                            <div class="bg-danger bg-opacity-25 p-3 rounded-circle d-inline-block mb-3">
                                <i class="bi bi-thermometer-sun text-danger" style="font-size: 1.5rem;"></i>
                            </div>
                            <h5 class="card-title text-light">Detecção em Tempo Real</h5>
                            <p class="card-text text-warning">Monitore focos de incêndio e temperaturas críticas em tempo real com nossa tecnologia avançada.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm fade-in delay-1 bg-warning bg-opacity-10">
                        <div class="card-body text-center p-4">
                            <div class="bg-warning bg-opacity-25 p-3 rounded-circle d-inline-block mb-3">
                                <i class="bi bi-bell-fill text-warning" style="font-size: 1.5rem;"></i>
                            </div>
                            <h5 class="card-title text-light">Alertas Imediatos</h5>
                            <p class="card-text text-warning">Receba notificações instantâneas quando novos focos de incêndio forem detectados em sua região.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm fade-in delay-2 bg-success bg-opacity-10">
                        <div class="card-body text-center p-4">
                            <div class="bg-success bg-opacity-25 p-3 rounded-circle d-inline-block mb-3">
                                <i class="bi bi-map text-success" style="font-size: 1.5rem;"></i>
                            </div>
                            <h5 class="card-title text-light">Mapas de Calor</h5>
                            <p class="card-text text-warning">Visualize áreas de risco através de nossos mapas de calor e dados históricos de incêndios.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Rodapé -->
    <footer class="mt-auto py-3 bg-black">
        <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/site_dash/includes/footer.php"); ?>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/site_dash/public/js/fade-in.js"></script>
    <!-- Particles.js -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        // Inicialização do particles.js com tema de fogo
        document.addEventListener('DOMContentLoaded', function() {
            particlesJS('particles-js', {
                "particles": {
                    "number": {
                        "value": 80,
                        "density": {
                            "enable": true,
                            "value_area": 800
                        }
                    },
                    "color": {
                        "value": ["#ff5e00", "#ff2200", "#ff9900"]
                    },
                    "shape": {
                        "type": "circle",
                        "stroke": {
                            "width": 0,
                            "color": "#000000"
                        },
                        "polygon": {
                            "nb_sides": 5
                        }
                    },
                    "opacity": {
                        "value": 0.5,
                        "random": true,
                        "anim": {
                            "enable": true,
                            "speed": 1,
                            "opacity_min": 0.1,
                            "sync": false
                        }
                    },
                    "size": {
                        "value": 3,
                        "random": true,
                        "anim": {
                            "enable": true,
                            "speed": 2,
                            "size_min": 0.1,
                            "sync": false
                        }
                    },
                    "line_linked": {
                        "enable": true,
                        "distance": 150,
                        "color": "#ff5500",
                        "opacity": 0.4,
                        "width": 1
                    },
                    "move": {
                        "enable": true,
                        "speed": 1,
                        "direction": "none",
                        "random": true,
                        "straight": false,
                        "out_mode": "out",
                        "bounce": false,
                        "attract": {
                            "enable": true,
                            "rotateX": 600,
                            "rotateY": 1200
                        }
                    }
                },
                "interactivity": {
                    "detect_on": "canvas",
                    "events": {
                        "onhover": {
                            "enable": true,
                            "mode": "grab"
                        },
                        "onclick": {
                            "enable": true,
                            "mode": "push"
                        },
                        "resize": true
                    },
                    "modes": {
                        "grab": {
                            "distance": 140,
                            "line_linked": {
                                "opacity": 1
                            }
                        },
                        "bubble": {
                            "distance": 400,
                            "size": 40,
                            "duration": 2,
                            "opacity": 8,
                            "speed": 3
                        },
                        "repulse": {
                            "distance": 200,
                            "duration": 0.4
                        },
                        "push": {
                            "particles_nb": 4
                        },
                        "remove": {
                            "particles_nb": 2
                        }
                    }
                },
                "retina_detect": true
            });
        });
    </script>
</body>

</html>

<style>
  .hero-section {
      background: linear-gradient(135deg, #1a1a1a 0%, #4d0000 100%);
      position: relative;
      overflow: hidden;
      min-height: 100vh;
  }

  #particles-js {
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      z-index: 1;
  }

  .hero-container {
      position: relative;
      z-index: 2;
      height: 100%;
  }

  .hero-content {
      max-width: 600px;
      position: relative;
      z-index: 3;
  }

  .hero-title {
      font-size: 3.5rem;
      font-weight: 800;
      line-height: 1.2;
      margin-bottom: 1.5rem;
      color: #ffffff;
      text-shadow: 0 0 10px rgba(255, 60, 0, 0.5);
  }

  .hero-title span.text-danger {
      color: #ff3300;
      text-shadow: 0 0 15px rgba(255, 80, 0, 0.8);
  }

  .hero-subtitle {
      font-size: 1.25rem;
      color: #ff9966;
      margin-bottom: 2rem;
  }

  .hero-buttons .btn {
      padding: 0.8rem 2rem;
      font-size: 1.1rem;
      font-weight: 600;
      border-radius: 50px;
      transition: all 0.3s;
  }

  .btn-hero-primary {
      background-color: #ff3300;
      border-color: #ff3300;
      color: white;
  }

  .btn-hero-primary:hover {
      background-color: #cc2900;
      transform: translateY(-3px);
      box-shadow: 0 10px 20px rgba(255, 60, 0, 0.4);
  }

  .btn-hero-outline {
      border: 2px solid #ff9966;
      color: #ff9966;
  }

  .btn-hero-outline:hover {
      background-color: rgba(255, 153, 102, 0.1);
  }

  .hero-animation {
      max-width: 600px;
      animation: float 6s ease-in-out infinite;
      position: relative;
      z-index: 3;
  }

  /* Flames Divider Styles */
  .flames-divider {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      overflow: hidden;
      line-height: 0;
      transform: rotate(180deg);
      z-index: 2;
  }

  .flames-divider svg {
      position: relative;
      display: block;
      width: calc(100% + 1.3px);
      height: 150px;
  }

  .flames-divider .shape-fill {
      fill: #ff5500;
  }

  /* Features Section Adjustment */
  #features {
      position: relative;
      z-index: 2;
  }

  /* Animações de aparecimento */
  .fade-in {
      opacity: 0;
      transition: opacity 0.6s ease-out, transform 0.6s ease-out;
  }

  .fade-in.visible {
      opacity: 1;
  }

  .slide-up {
      transform: translateY(20px);
  }

  .slide-up.visible {
      transform: translateY(0);
  }

  .delay-1 {
      transition-delay: 0.2s;
  }

  .delay-2 {
      transition-delay: 0.4s;
  }

  .delay-3 {
      transition-delay: 0.6s;
  }

  @keyframes float {
      0% {
          transform: translateY(0px);
      }
      50% {
          transform: translateY(-20px);
      }
      100% {
          transform: translateY(0px);
      }
  }

  @media (max-width: 992px) {
      .hero-section {
          padding-top: 6rem;
          padding-bottom: 6rem;
      }

      .hero-title {
          font-size: 2.5rem;
      }

      .hero-subtitle {
          font-size: 1.1rem;
      }

      .hero-animation {
          margin-top: 3rem;
          max-width: 100%;
      }

      .hero-buttons {
          flex-direction: column;
          gap: 1rem !important;
      }
  }
</style>