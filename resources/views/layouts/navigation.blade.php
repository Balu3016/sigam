<nav x-data="{ open: false }" class="bg-slate-950/80 backdrop-blur-md border-b border-slate-800/80 shadow-lg shadow-emerald-950/20 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <!-- Left Side: Brand & Main Navigation -->
            <div class="flex items-center gap-6">
                <!-- Logo & Identity -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-emerald-800 via-emerald-700 to-teal-600 p-[2px] shadow-lg shadow-emerald-950/50 group-hover:scale-105 transition-transform duration-200">
                            <div class="w-full h-full bg-slate-950 rounded-[10px] flex items-center justify-center">
                                <i data-lucide="shield-check" class="w-5 h-5 text-amber-400"></i>
                            </div>
                        </div>
                        <div class="hidden md:block">
                            <span class="font-extrabold text-white tracking-wide text-sm block group-hover:text-emerald-400 transition-colors">
                                OCOYOACAC
                            </span>
                            <span class="text-[9px] uppercase font-semibold text-slate-400 tracking-wider">
                                Gobierno Municipal
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Vertical Separator -->
                <div class="hidden sm:block h-6 w-px bg-slate-800"></div>

                <!-- Navigation Links -->
                <div class="hidden space-x-2 sm:-my-px sm:flex items-center">
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-sm font-semibold transition-all duration-150 {{ request()->routeIs('dashboard') ? 'bg-emerald-950/80 text-emerald-400 border border-emerald-500/30 shadow-sm shadow-emerald-950/50' : 'text-slate-300 hover:text-white hover:bg-slate-900/60' }}">
                        <i data-lucide="layout-dashboard" class="w-4 h-4 {{ request()->routeIs('dashboard') ? 'text-emerald-400' : 'text-slate-400' }}"></i>
                        <span>{{ __('Panel Principal') }}</span>
                    </a>
                </div>
            </div>

            <!-- Right Side: User Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-3 px-3 py-1.5 border border-slate-800 rounded-xl text-sm font-semibold text-slate-200 bg-slate-900/80 hover:bg-slate-900 hover:border-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition duration-150 ease-in-out shadow-inner">
                            <!-- User Avatar Badge -->
                            <div class="w-7 h-7 rounded-lg bg-emerald-900/60 border border-emerald-500/40 text-emerald-300 flex items-center justify-center text-xs font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>

                            <span class="max-w-[140px] truncate text-left">{{ Auth::user()->name }}</span>

                            <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 transition-transform duration-200 group-hover:rotate-180"></i>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- User Header Info inside dropdown -->
                        <div class="px-4 py-3 border-b border-slate-800 bg-slate-950/60">
                            <p class="text-xs text-slate-400">Sesión iniciada como</p>
                            <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name }}</p>
                            <p class="text-[11px] text-slate-400 truncate mt-0.5">{{ Auth::user()->email }}</p>
                        </div>

                        <!-- Profile Link -->
                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-300 hover:text-white hover:bg-slate-800/80 transition-colors">
                            <i data-lucide="user-cog" class="w-4 h-4 text-amber-400"></i>
                            {{ __('Mi Perfil') }}
                        </x-dropdown-link>

                        <!-- System Specs or Quick Action (Optional) -->
                        <div class="border-t border-slate-800/80"></div>

                        <!-- Authentication / Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="flex items-center gap-2 px-4 py-2 text-sm text-rose-400 hover:text-rose-300 hover:bg-rose-950/30 transition-colors">
                                <i data-lucide="log-out" class="w-4 h-4 text-rose-400"></i>
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile Button) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-900 border border-transparent hover:border-slate-800 focus:outline-none transition duration-150 ease-in-out">
                    <i data-lucide="menu" x-show="!open" class="w-6 h-6"></i>
                    <i data-lucide="x" x-show="open" class="w-6 h-6" style="display: none;"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile View) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-b border-slate-800 bg-slate-950/95 backdrop-blur-xl">
        <div class="pt-2 pb-3 space-y-1 px-3">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center gap-2 rounded-xl">
                <i data-lucide="layout-dashboard" class="w-4 h-4 text-emerald-400"></i>
                {{ __('Panel Principal') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive User Info & Actions -->
        <div class="pt-4 pb-3 border-t border-slate-800/80 px-4">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-900/60 border border-emerald-500/40 text-emerald-300 flex items-center justify-center font-bold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="font-bold text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-xs text-slate-400">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="flex items-center gap-2 text-slate-300 rounded-xl">
                    <i data-lucide="user-cog" class="w-4 h-4 text-amber-400"></i>
                    {{ __('Mi Perfil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="flex items-center gap-2 text-rose-400 hover:text-rose-300 rounded-xl">
                        <i data-lucide="log-out" class="w-4 h-4 text-rose-400"></i>
                        {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>