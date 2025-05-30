<header class="bg-white/90 backdrop-blur sticky top-0 z-50 shadow-sm rounded-b-xl">
    <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-16">
        <a href="{{ route('welcome') }}" class="flex items-center space-x-2 text-xl font-bold text-blue-600">
            <i class="fas fa-recycle"></i>
            <span>Reutiliz</span>
        </a>
        
        <nav class="flex items-center space-x-2">
            @auth
                @unless(Auth::user()->isAdmin())
                    <a href="{{ route('publier') }}" class="hidden sm:inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 transition"><i class="fas fa-plus-circle mr-1"></i>Publier</a>
                @endunless
            @else
                <a href="{{ route('publier') }}" class="hidden sm:inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 transition"><i class="fas fa-plus-circle mr-1"></i>Publier</a>
            @endauth
            @auth
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center space-x-2 px-2 py-1 rounded text-xs text-gray-700 hover:text-blue-600 focus:outline-none">
                        <i class="fas fa-user-circle text-lg"></i>
                        <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50 py-1">
                        @if(Auth::user()->isAdmin()) {{-- Assuming you have an isAdmin method on User model --}}
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-gray-700 hover:bg-blue-50">
                                <i class="fas fa-tachometer-alt"></i> Tableau de bord Admin
                            </a>
                            <a href="{{ route('admin.annonces.index') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-gray-700 hover:bg-blue-50">
                                <i class="fas fa-bullhorn"></i> Annonces (Admin)
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-gray-700 hover:bg-blue-50">
                                <i class="fas fa-users"></i> Utilisateurs (Admin)
                            </a>
                        @else
                            <a href="{{ route('welcome') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-gray-700 hover:bg-blue-50">
                                <i class="fas fa-home"></i> Accueil
                            </a>
                            <a href="{{ route('user.annonces') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-gray-700 hover:bg-blue-50">
                                <i class="fas fa-bullhorn"></i> Mes annonces
                            </a>
                            <a href="{{ route('user.favorites') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-gray-700 hover:bg-blue-50">
                                <i class="fas fa-heart"></i> Mes favoris
                            </a>
                        @endif
                        @if (!Auth::user()->hasVerifiedEmail())
                            <a href="{{ route('verification.notice') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-red-600 hover:bg-red-50">
                                <i class="fas fa-exclamation-triangle"></i> Vérifier l'e-mail
                            </a>
                        @endif
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-gray-700 hover:bg-blue-50">
                            <i class="fas fa-cog"></i> Réglages
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-blue-50">
                                <i class="fas fa-sign-out-alt"></i> Se déconnecter
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 px-2 py-1 rounded text-xs transition"><i class="fas fa-sign-in-alt mr-1"></i>Connexion</a>
                <a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-600 px-2 py-1 rounded text-xs transition"><i class="fas fa-user-plus mr-1"></i>S'inscrire</a>
            @endauth
        </nav>

        <!-- Mobile Menu Button -->
        <div class="sm:hidden">
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': mobileMenuOpen, 'inline-flex': !mobileMenuOpen }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    <path :class="{'hidden': !mobileMenuOpen, 'inline-flex': mobileMenuOpen }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="sm:hidden border-t border-gray-200 bg-white shadow-md rounded-b-xl absolute top-full inset-x-0 z-40">
        <div class="px-4 py-3 space-y-2">
            @auth
                @unless(Auth::user()->isAdmin())
                    <a href="{{ route('publier') }}" class="block px-3 py-1 rounded-md text-xs font-medium text-white bg-blue-600 hover:bg-blue-700"><i class="fas fa-plus-circle mr-1"></i>Publier une annonce</a>
                @endunless
            @else
                <a href="{{ route('publier') }}" class="block px-3 py-1 rounded-md text-xs font-medium text-white bg-blue-600 hover:bg-blue-700"><i class="fas fa-plus-circle mr-1"></i>Publier une annonce</a>
            @endauth
            @auth
                 @if(Auth::user()->isAdmin()) {{-- Assuming you have an isAdmin method on User model --}}
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-1 rounded-md text-xs font-medium text-gray-700 hover:bg-gray-50 hover:text-blue-600">Tableau de bord Admin</a>
                 @else
                    <a href="{{ route('dashboard') }}" class="block px-3 py-1 rounded-md text-xs font-medium text-gray-700 hover:bg-gray-50 hover:text-blue-600">Mon Tableau de bord</a>
                 @endif
                @if (!Auth::user()->hasVerifiedEmail())
                    <a href="{{ route('verification.notice') }}" class="block px-3 py-1 rounded-md text-xs font-medium text-red-600 hover:bg-red-50 hover:text-red-700">
                        <i class="fas fa-exclamation-triangle mr-1"></i> Vérifier l'e-mail
                    </a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit" class="w-full text-left block px-3 py-1 rounded-md text-xs font-medium text-gray-700 hover:bg-gray-50 hover:text-blue-600"><i class="fas fa-sign-out-alt mr-1"></i>Déconnexion</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-3 py-1 rounded-md text-xs font-medium text-gray-700 hover:bg-gray-50 hover:text-blue-600"><i class="fas fa-sign-in-alt mr-1"></i>Connexion</a>
                <a href="{{ route('register') }}" class="block px-3 py-1 rounded-md text-xs font-medium text-gray-700 hover:bg-gray-50 hover:text-blue-600"><i class="fas fa-user-plus mr-1"></i>S'inscrire</a>
            @endauth
        </div>
    </div>
</header>