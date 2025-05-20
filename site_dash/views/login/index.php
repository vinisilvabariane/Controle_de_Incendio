<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" sizes="16x16" href="/site_dash/public/img/firewatch-icon.png">
    <title>Fire Watch - Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@5/dist/darkly/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/site_dash/public/css/fonts.css">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a1a 0%, #4d0000 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .login-container {
            flex: 1;
            display: flex;
            align-items: center;
            padding: 20px 0;
        }
        
        .login-card {
            background-color: rgba(33, 37, 41, 0.9);
            border: 1px solid #ff5500;
            border-radius: 10px;
            max-width: 400px;
            width: 100%;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(255, 85, 0, 0.2);
        }
        
        .login-card:before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            z-index: -1;
            border-radius: 10px;
            animation: glowing 3s linear infinite;
        }
        
        @keyframes glowing {
            0% { filter: blur(5px); opacity: 0.7; }
            50% { filter: blur(7px); opacity: 1; }
            100% { filter: blur(5px); opacity: 0.7; }
        }
        
        .form-control:focus {
            border-color: #ff5500;
            box-shadow: 0 0 0 0.25rem rgba(255, 85, 0, 0.25);
        }
        
        .btn-login {
            background-color: #ff3300;
            border: none;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            background-color: #cc2900;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 60, 0, 0.4);
        }
        
        .footer {
            background-color: rgba(0, 0, 0, 0.7);
            color: #ff9966;
            padding: 15px 0;
        }
        
        #particles-js {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
        }
    </style>
</head>

<body>
    <!-- Particles Background -->
    <div id="particles-js"></div>
    
    <div class="login-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card shadow login-card">
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <img src="/site_dash/public/img/firewatch-icon.png" alt="FireWatch Logo" width="70" class="mb-3">
                                <h2 class="fw-bold" style="color: #ff5500;">Fire<span style="color: #ffffff;">Watch</span></h2>
                                <p class="text-muted mb-4">Sistema de Monitoramento</p>
                            </div>
                            <form id="login">
                                <div class="mb-3">
                                    <label for="username" class="form-label" style="color: #ffffff;">Usuário</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-dark" style="border-color: #ff5500;">
                                            <i class="bi bi-person-fill" style="color: #ff5500;"></i>
                                        </span>
                                        <input type="text" class="form-control bg-dark text-light" id="username" name="username"
                                            placeholder="Insira seu usuário" required style="border-color: #ff5500;">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label" style="color: #ffffff;">Senha</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-dark" style="border-color: #ff5500;">
                                            <i class="bi bi-lock-fill" style="color: #ff5500;"></i>
                                        </span>
                                        <input type="password" class="form-control bg-dark text-light" id="password" name="password"
                                            placeholder="Insira sua senha" required style="border-color: #ff5500;">
                                        <button class="btn btn-outline-danger" type="button" id="toggle-type">
                                            <i class="bi bi-eye-fill" id="toggle-icon"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-login btn-danger w-100 fw-bold py-2">
                                    <i class="bi bi-fire me-2"></i> Acessar Sistema
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Recuperação de Senha -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-light">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title text-danger" id="forgotPasswordModalLabel">Recuperação de Senha</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Envie um e-mail para <strong class="text-warning">suporte@firewatch.com.br</strong> para recuperar sua senha.</p>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer text-center mt-auto">
        <small>&copy; <span id="current-year">2024</span> FireWatch - Todos os direitos reservados.</small>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const yearSpan = document.getElementById('current-year');
            if (yearSpan) {
                yearSpan.textContent = new Date().getFullYear();
            }
        });
    </script>
    
    <!-- Particles.js -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        particlesJS('particles-js', {
            "particles": {
                "number": {
                    "value": 60,
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
                }
            },
            "retina_detect": true
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="/site_dash/public/js/login.js"></script>
</body>

</html>