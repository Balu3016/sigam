<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIGAM | Plataforma Central Ocoyoacac</title>
    
    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&family=Space+Grotesk:wght@500;700&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-dark: #030712;
            --primary-emerald: #10b981;
            --primary-cyan: #06b6d4;
            --primary-indigo: #6366f1;
            --glass-border: rgba(255, 255, 255, 0.08);
            --glass-border-active: rgba(16, 185, 129, 0.5);
        }

        * {
            box-sizing: border-box;
        }

        body {
            background-color: var(--bg-dark);
            color: #f8fafc;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow-x: hidden;
            position: relative;
        }

        /* Particle Canvas Background */
        #particles-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 0;
            pointer-events: none;
        }

        /* Ambient Animated Glow Gradient Spheres */
        .ambient-glow-1 {
            position: fixed;
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, rgba(3, 7, 18, 0) 70%);
            top: -200px;
            left: -150px;
            z-index: 0;
            pointer-events: none;
            animation: floatGlow 12s infinite alternate ease-in-out;
        }

        .ambient-glow-2 {
            position: fixed;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(6, 182, 212, 0.12) 0%, rgba(3, 7, 18, 0) 70%);
            bottom: -250px;
            right: -200px;
            z-index: 0;
            pointer-events: none;
            animation: floatGlow 15s infinite alternate ease-in-out;
        }

        @keyframes floatGlow {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(50px, 40px) scale(1.15); }
        }

        /* Grid Pattern Overlay */
        .bg-grid-pattern {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: linear-gradient(to right, rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
            background-size: 50px 50px;
            z-index: 0;
            pointer-events: none;
        }

        /* Glassmorphism Ultra Card */
        .ultra-glass-card {
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(24px) saturate(180%);
            -webkit-backdrop-filter: blur(24px) saturate(180%);
            border: 1px solid var(--glass-border);
            border-radius: 2rem;
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.75),
                        0 0 40px -10px rgba(16, 185, 129, 0.15);
            position: relative;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .ultra-glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--primary-emerald), var(--primary-cyan), transparent);
        }

        /* Feature Cyber Card */
        .cyber-card {
            background: rgba(30, 41, 59, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 1.25rem;
            padding: 1.5rem;
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }

        .cyber-card:hover {
            background: rgba(30, 41, 59, 0.75);
            border-color: var(--glass-border-active);
            transform: translateY(-6px);
            box-shadow: 0 15px 30px -10px rgba(16, 185, 129, 0.25);
        }

        /* Tech Icon Box */
        .tech-icon-box {
            width: 52px;
            height: 52px;
            border-radius: 1rem;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.25) 0%, rgba(6, 182, 212, 0.15) 100%);
            border: 1px solid rgba(16, 185, 129, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #34d399;
            font-size: 1.5rem;
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.2);
        }

        /* Cyber Button Primary */
        .btn-cyber {
            position: relative;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            border: none;
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            font-size: 1.05rem;
            padding: 1rem 2.5rem;
            border-radius: 1rem;
            letter-spacing: 0.05em;
            transition: all 0.35s ease;
            box-shadow: 0 10px 30px -5px rgba(16, 185, 129, 0.4);
            overflow: hidden;
        }

        .btn-cyber::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.2), transparent);
            transform: rotate(45deg);
            transition: all 0.6s ease;
        }

        .btn-cyber:hover::after {
            left: 100%;
        }

        .btn-cyber:hover {
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
            color: #ffffff;
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 15px 35px -5px rgba(16, 185, 129, 0.6);
        }

        /* Typography & Gradient Text */
        .title-display {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            letter-spacing: -0.03em;
        }

        .text-gradient-white {
            background: linear-gradient(180deg, #ffffff 0%, #94a3b8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .text-gradient-cyber {
            background: linear-gradient(135deg, #34d399 0%, #06b6d4 50%, #818cf8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Live Status Badge */
        .live-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            border-radius: 9999px;
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.75rem;
            color: #34d399;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background-color: var(--primary-emerald);
            border-radius: 50%;
            box-shadow: 0 0 12px var(--primary-emerald);
            animation: pulseDot 2s infinite;
        }

        @keyframes pulseDot {
            0% { transform: scale(0.95); opacity: 0.8; }
            50% { transform: scale(1.3); opacity: 1; box-shadow: 0 0 18px var(--primary-emerald); }
            100% { transform: scale(0.95); opacity: 0.8; }
        }

        .metric-counter {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: #ffffff;
        }
    </style>
</head>
<body>

    <!-- Dynamic Canvas Particles -->
    <canvas id="particles-canvas"></canvas>

    <!-- Grid & Glow Overlay -->
    <div class="bg-grid-pattern"></div>
    <div class="ambient-glow-1"></div>
    <div class="ambient-glow-2"></div>

    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top py-3 z-3" style="background: rgba(3, 7, 18, 0.7); backdrop-filter: blur(16px); border-bottom: 1px solid var(--glass-border);">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-3" href="#">
                <div class="p-2.5 rounded-3 d-flex align-items-center justify-content-center" style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3);">
                    <i class="bi bi-shield-check text-emerald fs-4" style="color: var(--primary-emerald);"></i>
                </div>
                <div>
                    <span class="fw-bold tracking-wider text-uppercase d-block lh-1 text-white fs-5" style="font-family: 'Space Grotesk';">OCOYOACAC</span>
                    <span class="text-secondary font-monospace" style="font-size: 0.68rem; letter-spacing: 0.12em;">GOBIERNO MUNICIPAL DIGITAL</span>
                </div>
            </a>

            <div class="d-flex align-items-center gap-3">
                <div class="live-status d-none d-md-flex">
                    <span class="status-dot"></span>
                    <span>SERVIDOR EN LÍNEA • 99.9%</span>
                </div>

                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-cyber py-2 px-4 fs-6">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-cyber py-2 px-4 fs-6">
                        <i class="bi bi-shield-lock-fill me-2"></i> Acceso Oficial
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Content -->
    <main class="container my-auto py-5 z-2">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-11 col-xl-10">
                
                <div class="ultra-glass-card p-4 p-md-5 text-center">
                    
                    <!-- Top Badge -->
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill mb-4" style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.1);">
                        <i class="bi bi-cpu-fill text-gradient-cyber fs-6"></i>
                        <span class="font-monospace fw-semibold" style="font-size: 0.75rem; color: #cbd5e1; letter-spacing: 0.08em;">
                            SISTEMA CENTRAL DE INFORMACIÓN Y APOYOS (SIGAM)
                        </span>
                    </div>

                    <!-- Main Title -->
                    <h1 class="display-4 title-display mb-3 text-gradient-white">
                        Gestión Operativa y Control de <br class="d-none d-md-inline">
                        <span class="text-gradient-cyber">Programas Sociales Municipales</span>
                    </h1>

                    <p class="text-secondary fs-6 col-lg-9 mx-auto mb-5 fw-normal leading-relaxed">
                        Infraestructura tecnológica de alta velocidad para el padrón consolidado, control de inventario de apoyos y validación geográfica de entregas en Ocoyoacac.
                    </p>

                    <!-- Core Modules Grid -->
                    <div class="row g-3 text-start mb-5">
                        <div class="col-md-4">
                            <div class="cyber-card h-100">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="tech-icon-box">
                                        <i class="bi bi-people-fill"></i>
                                    </div>
                                    <span class="font-monospace text-secondary" style="font-size: 0.7rem;">MÓDULO 01</span>
                                </div>
                                <h5 class="text-white fw-bold mb-1" style="font-family: 'Space Grotesk';">Padrón Único</h5>
                                <p class="text-secondary mb-0" style="font-size: 0.8rem; line-height: 1.4;">
                                    Cotejo de datos socioeconómicos y registro verificado por localidad.
                                </p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="cyber-card h-100">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="tech-icon-box">
                                        <i class="bi bi-diagram-3-fill"></i>
                                    </div>
                                    <span class="font-monospace text-secondary" style="font-size: 0.7rem;">MÓDULO 02</span>
                                </div>
                                <h5 class="text-white fw-bold mb-1" style="font-family: 'Space Grotesk';">Control de Apoyos</h5>
                                <p class="text-secondary mb-0" style="font-size: 0.8rem; line-height: 1.4;">
                                    Catálogo unificado, asignación de inventarios y trazabilidad.
                                </p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="cyber-card h-100">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="tech-icon-box">
                                        <i class="bi bi-patch-check-fill"></i>
                                    </div>
                                    <span class="font-monospace text-secondary" style="font-size: 0.7rem;">MÓDULO 03</span>
                                </div>
                                <h5 class="text-white fw-bold mb-1" style="font-family: 'Space Grotesk';">Evidencia Digital</h5>
                                <p class="text-secondary mb-0" style="font-size: 0.8rem; line-height: 1.4;">
                                    Verificación operativa en campo con registro fotográfico y firma digital.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Call To Action Section -->
                    <div class="d-flex flex-column flex-sm-row justify-content-center align-items-center gap-3">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-cyber w-100 w-sm-auto">
                                ACCEDER AL DASHBOARD CENTRAL <i class="bi bi-arrow-right-short fs-4 ms-1"></i>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-cyber w-100 w-sm-auto">
                                INICIAR SESIÓN DE USUARIO <i class="bi bi-lock-fill ms-2 fs-6"></i>
                            </a>
                        @endauth
                    </div>

                </div>

            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="container py-4 text-center z-2">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 border-top border-secondary border-opacity-10 pt-3">
            <span class="text-secondary font-monospace" style="font-size: 0.75rem;">
                © {{ date('Y') }} H. Ayuntamiento Constitucional de Ocoyoacac
            </span>
            <span class="text-secondary font-monospace" style="font-size: 0.75rem;">
                <i class="bi bi-terminal-fill text-success me-1"></i> SIGAM ENGINE v3.0 • NODO OCOYOACAC
            </span>
        </div>
    </footer>

    <!-- Interactive Canvas Particles Script -->
    <script>
        const canvas = document.getElementById('particles-canvas');
        const ctx = canvas.getContext('2d');

        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);

        const particles = [];
        const particleCount = 45;

        class Particle {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.vx = (Math.random() - 0.5) * 0.4;
                this.vy = (Math.random() - 0.5) * 0.4;
                this.radius = Math.random() * 1.5 + 1;
            }

            update() {
                this.x += this.vx;
                this.y += this.vy;

                if (this.x < 0 || this.x > canvas.width) this.vx *= -1;
                if (this.y < 0 || this.y > canvas.height) this.vy *= -1;
            }

            draw() {
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                ctx.fillStyle = 'rgba(16, 185, 129, 0.4)';
                ctx.fill();
            }
        }

        for (let i = 0; i < particleCount; i++) {
            particles.push(new Particle());
        }

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            for (let i = 0; i < particles.length; i++) {
                particles[i].update();
                particles[i].draw();

                for (let j = i + 1; j < particles.length; j++) {
                    const dx = particles[i].x - particles[j].x;
                    const dy = particles[i].y - particles[j].y;
                    const distance = Math.sqrt(dx * dx + dy * dy);

                    if (distance < 140) {
                        ctx.beginPath();
                        ctx.moveTo(particles[i].x, particles[i].y);
                        ctx.lineTo(particles[j].x, particles[j].y);
                        ctx.strokeStyle = `rgba(16, 185, 129, ${0.12 - distance / 1400})`;
                        ctx.lineWidth = 0.8;
                        ctx.stroke();
                    }
                }
            }

            requestAnimationFrame(animate);
        }

        animate();
    </script>
</body>
</html>