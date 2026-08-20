<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sistema Municipal - Ocoyoacac') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Lucide Icons CDN -->
        <script src="https://unpkg.com/lucide@latest"></script>

        <!-- Scripts / Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-950 text-slate-100 min-h-screen flex flex-col justify-between selection:bg-emerald-600 selection:text-white relative overflow-x-hidden">

        <!-- Ambient Lights (Efectos de luz verde esmeralda y dorado en el fondo) -->
        <div class="fixed inset-0 pointer-events-none overflow-hidden -z-10">
            <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[700px] h-[700px] bg-emerald-800/20 rounded-full blur-[160px]"></div>
            <div class="absolute -bottom-20 -left-20 w-[500px] h-[500px] bg-teal-600/15 rounded-full blur-[140px]"></div>
            <div class="absolute top-1/3 -right-20 w-[400px] h-[400px] bg-emerald-900/20 rounded-full blur-[140px]"></div>
        </div>

        <!-- Header mínimo superior con retorno a Inicio -->
        <header class="w-full max-w-7xl mx-auto px-6 py-6 flex items-center justify-between relative z-10">
            <a href="/" class="flex items-center gap-3 group">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-emerald-800 via-emerald-700 to-teal-600 p-[2px] shadow-lg shadow-emerald-950/50 group-hover:scale-105 transition-transform">
                    <div class="w-full h-full bg-slate-950 rounded-[10px] flex items-center justify-center">
                        <i data-lucide="shield-check" class="w-5 h-5 text-amber-400"></i>
                    </div>
                </div>
                <div>
                    <span class="font-extrabold text-white tracking-wide text-base block group-hover:text-emerald-400 transition-colors">
                        OCOYOACAC
                    </span>
                    <span class="text-[10px] uppercase font-semibold text-slate-400 tracking-wider">
                        Desarrollo Social
                    </span>
                </div>
            </a>

            <a href="/" class="text-xs font-semibold text-slate-400 hover:text-white flex items-center gap-1.5 transition-colors px-3 py-1.5 rounded-lg bg-slate-900/60 border border-slate-800">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5 text-amber-400"></i>
                Regresar al Inicio
            </a>
        </header>

        <!-- Contenedor Principal (Tarjeta de Formulario) -->
        <main class="w-full max-w-md mx-auto my-auto px-4 py-6 relative z-10">
            
            <!-- Logo & Membrete Institucional arriba de la tarjeta -->
            <div class="text-center mb-6">
                <a href="/" class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-slate-900/80 border border-slate-800 backdrop-blur-xl mb-3 shadow-xl shadow-emerald-950/40 border-b-2 border-b-amber-500">
                    <i data-lucide="building-2" class="w-7 h-7 text-emerald-400"></i>
                </a>
                <h2 class="text-xl font-extrabold text-white tracking-tight">
                    Plataforma Institucional
                </h2>
                <p class="text-xs text-slate-400 font-medium mt-1">
                    H. Ayuntamiento de Ocoyoacac &bull; Registro de Usuarios
                </p>
            </div>

            <!-- Card donde entra el slot (Login / Registro) con forzado de contraste de texto e inputs -->
            <div class="w-full p-8 rounded-2xl bg-slate-900/80 border border-slate-800 backdrop-blur-xl shadow-2xl relative overflow-hidden border-t-2 border-t-emerald-500
                        [&_label]:text-slate-200 [&_label]:font-semibold [&_label]:text-xs [&_label]:mb-1 [&_label]:block
                        [&_input[type=text]]:bg-slate-950/80 [&_input[type=text]]:text-white [&_input[type=text]]:border-slate-800 [&_input[type=text]]:rounded-xl [&_input[type=text]]:focus:border-emerald-500 [&_input[type=text]]:focus:ring-emerald-500/20
                        [&_input[type=email]]:bg-slate-950/80 [&_input[type=email]]:text-white [&_input[type=email]]:border-slate-800 [&_input[type=email]]:rounded-xl [&_input[type=email]]:focus:border-emerald-500 [&_input[type=email]]:focus:ring-emerald-500/20
                        [&_input[type=password]]:bg-slate-950/80 [&_input[type=password]]:text-white [&_input[type=password]]:border-slate-800 [&_input[type=password]]:rounded-xl [&_input[type=password]]:focus:border-emerald-500 [&_input[type=password]]:focus:ring-emerald-500/20
                        [&_a]:text-emerald-400 [&_a:hover]:text-emerald-300">
                {{ $slot }}
            </div>

            <!-- Insignia de seguridad municipal -->
            <div class="mt-6 text-center">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-900/60 border border-slate-800 text-[11px] text-slate-400">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Conexión Segura &bull; Sistema Interno
                </span>
            </div>
        </main>

        <!-- Footer discreto -->
        <footer class="w-full max-w-7xl mx-auto px-6 py-4 text-center text-xs text-slate-500 relative z-10">
            &copy; {{ date('Y') }} H. Ayuntamiento de Ocoyoacac. Todos los derechos reservados.
        </footer>

        <!-- Script de Inicialización de Íconos Lucide -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            });
        </script>
    </body>
</html>