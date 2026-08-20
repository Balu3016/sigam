<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Sistema de Apoyos Sociales - Ocoyoacac') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        <!-- Lucide Icons CDN -->
        <script src="https://unpkg.com/lucide@latest"></script>

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /*! tailwindcss v4.0.7 */
                @layer theme{:root,:host{--font-sans:'Instrument Sans',ui-sans-serif,system-ui,sans-serif;}}
            </style>
        @endif
    </head>
    <body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 min-h-screen flex flex-col justify-between font-sans selection:bg-emerald-700 selection:text-white">

        <!-- Header / Navbar -->
        <header class="w-full bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 sticky top-0 z-50 shadow-sm">
            <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                
                <!-- Identidad Municipal -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-emerald-800 flex items-center justify-center text-amber-400 shadow-md">
                        <i data-lucide="building-2" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <span class="font-bold text-slate-900 dark:text-white text-base tracking-tight block">
                            GOBIERNO MUNICIPAL DE OCOYOACAC
                        </span>
                        <span class="text-xs font-medium text-emerald-800 dark:text-emerald-400">
                            Dirección de Bienestar y Desarrollo Social
                        </span>
                    </div>
                </div>

                <!-- Botón Único: Registro -->
                <nav class="flex items-center gap-3">
                    @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="px-5 py-2.5 rounded-lg bg-emerald-800 hover:bg-emerald-900 text-white font-semibold text-sm shadow-sm transition-all flex items-center gap-2"
                        >
                            <i data-lucide="user-plus" class="w-4 h-4 text-amber-400"></i>
                            Registro de Usuarios
                        </a>
                    @endif
                </nav>
            </div>
        </header>

        <!-- Main Content -->
        <main class="w-full max-w-7xl mx-auto px-6 py-10 flex-grow flex flex-col gap-10">
            
            <!-- Hero / Banner Principal con Verde Institucional -->
            <div class="rounded-2xl p-8 lg:p-12 bg-gradient-to-r from-emerald-900 via-emerald-800 to-teal-900 text-white shadow-xl relative overflow-hidden border-b-4 border-amber-500">
                <div class="absolute -right-10 -bottom-10 opacity-10 text-white pointer-events-none">
                    <i data-lucide="shield" class="w-96 h-96"></i>
                </div>
                
                <div class="max-w-3xl relative z-10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-950/60 border border-emerald-700/50 text-amber-300 text-xs font-semibold uppercase tracking-wider mb-5">
                        <i data-lucide="award" class="w-3.5 h-3.5"></i>
                        Plataforma Oficial de Control
                    </div>
                    
                    <h1 class="text-3xl lg:text-5xl font-extrabold tracking-tight mb-4 leading-tight">
                        Sistema Municipal de Registro y Entrega de Apoyos Sociales
                    </h1>
                    
                    <p class="text-emerald-100 text-base lg:text-lg leading-relaxed mb-8 max-w-2xl">
                        Herramienta institucional para la administración transparente, padrón de beneficiarios y seguimiento en tiempo real de los programas sociales en Ocoyoacac.
                    </p>

                    @if (Route::has('register'))
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('dashboard') }}" class="px-7 py-3.5 rounded-lg bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold text-sm shadow-md transition-all flex items-center gap-2">
                                <i data-lucide="clipboard-signature" class="w-4 h-4"></i>
                                -> Ingresar al sistema
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Métricas Principales (KPIs) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- KPI 1 -->
                <div class="p-6 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider block mb-1">Padrón de Beneficiarios</span>
                        <div class="text-3xl font-bold text-slate-900 dark:text-white">
                            {{ $totalBeneficiarios ?? '12,450' }}
                        </div>
                        <p class="text-xs text-emerald-700 dark:text-emerald-400 font-medium mt-1">Registrados en el municipio</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 flex items-center justify-center text-emerald-800 dark:text-emerald-300">
                        <i data-lucide="users" class="w-6 h-6"></i>
                    </div>
                </div>

                <!-- KPI 2 -->
                <div class="p-6 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider block mb-1">Apoyos Otorgados</span>
                        <div class="text-3xl font-bold text-slate-900 dark:text-white">
                            {{ $totalEntregas ?? '34,890' }}
                        </div>
                        <p class="text-xs text-emerald-700 dark:text-emerald-400 font-medium mt-1">Entregas comprobadas</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-amber-50 dark:bg-amber-950/60 border border-amber-200 dark:border-amber-800 flex items-center justify-center text-amber-700 dark:text-amber-400">
                        <i data-lucide="package-check" class="w-6 h-6"></i>
                    </div>
                </div>

                <!-- KPI 3 -->
                <div class="p-6 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider block mb-1">Programas Activos</span>
                        <div class="text-3xl font-bold text-slate-900 dark:text-white">
                            {{ $totalProgramas ?? '8' }}
                        </div>
                        <p class="text-xs text-emerald-700 dark:text-emerald-400 font-medium mt-1">Rubros de atención</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-teal-50 dark:bg-teal-950/60 border border-teal-200 dark:border-teal-800 flex items-center justify-center text-teal-800 dark:text-teal-300">
                        <i data-lucide="layers" class="w-6 h-6"></i>
                    </div>
                </div>

            </div>

            <!-- Rubros y Programas Social -->
            <div class="p-8 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm">
                <div class="mb-6 pb-4 border-b border-slate-100 dark:border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-2">
                    <div>
                        <h2 class="text-xl font-bold text-slate-900 dark:text-white">Programas de Apoyo Municipal</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Categorías de apoyos brindados a las comunidades de Ocoyoacac.</p>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md text-xs font-semibold bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                        <i data-lucide="check-circle" class="w-3.5 h-3.5"></i> En Operación
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    
                    <!-- Tarjeta 1 -->
                    <div class="p-5 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/40">
                        <div class="w-9 h-9 rounded-md bg-emerald-800 text-amber-400 flex items-center justify-center mb-3">
                            <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 dark:text-white text-sm mb-1">Apoyo Alimentario</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Canastas de nutrición y despensas familiares.</p>
                    </div>

                    <!-- Tarjeta 2 -->
                    <div class="p-5 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/40">
                        <div class="w-9 h-9 rounded-md bg-emerald-800 text-amber-400 flex items-center justify-center mb-3">
                            <i data-lucide="home" class="w-4 h-4"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 dark:text-white text-sm mb-1">Mejoramiento de Vivienda</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Láminas, tinacos y materiales de construcción.</p>
                    </div>

                    <!-- Tarjeta 3 -->
                    <div class="p-5 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/40">
                        <div class="w-9 h-9 rounded-md bg-emerald-800 text-amber-400 flex items-center justify-center mb-3">
                            <i data-lucide="graduation-cap" class="w-4 h-4"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 dark:text-white text-sm mb-1">Becas y Educación</h3>
                        <p class="text-xs text-slate-400 text-slate-500">Útiles escolares y estímulos educativos.</p>
                    </div>

                    <!-- Tarjeta 4 -->
                    <div class="p-5 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/40">
                        <div class="w-9 h-9 rounded-md bg-emerald-800 text-amber-400 flex items-center justify-center mb-3">
                            <i data-lucide="heart-pulse" class="w-4 h-4"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 dark:text-white text-sm mb-1">Salud Municipal</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Medicamentos y aparatos funcionales.</p>
                    </div>

                </div>
            </div>

        </main>

        <!-- Footer Oficial -->
        <footer class="w-full bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 py-6 text-center text-xs text-slate-500 dark:text-slate-400">
            <div class="max-w-7xl mx-auto px-6 flex flex-col sm:flex-row justify-between items-center gap-3">
                <span>&copy; {{ date('Y') }} H. Ayuntamiento de Ocoyoacac. Todos los derechos reservados.</span>
                <span class="font-medium text-emerald-800 dark:text-emerald-400">Dirección de Desarrollo Social</span>
            </div>
        </footer>

        <!-- Inicializador de Íconos -->
        <script>
            lucide.createIcons();
        </script>
    </body>
</html>