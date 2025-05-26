<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin - Reutiliz')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.5/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
    </style>
</head>
<body class="antialiased">
    <div x-data="{ mobileMenuOpen: false }">
        <!-- Header -->
        <header class="bg-white/90 backdrop-blur sticky top-0 z-50 shadow-sm rounded-b-xl">
            <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-16">
                <a href="{{ route('welcome') }}" class="flex items-center space-x-2 text-xl font-bold text-blue-600">
                    <i class="fas fa-recycle"></i>
                    <span>Reutiliz</span>
                </a>
                <nav class="flex items-center space-x-2">
                    @auth
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center space-x-2 px-2 py-1 rounded text-xs text-gray-700 hover:text-blue-600 focus:outline-none">
                                <i class="fas fa-user-circle text-lg"></i>
                                <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50 py-1">
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-gray-700 hover:bg-blue-50">
                                    <i class="fas fa-tachometer-alt"></i> Tableau de bord
                                </a>
                                <a href="{{ route('admin.annonces.index') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-gray-700 hover:bg-blue-50">
                                    <i class="fas fa-bullhorn"></i> Annonces 
                                </a>
                                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-gray-700 hover:bg-blue-50">
                                    <i class="fas fa-user"></i> Utilisateurs
                                </a>
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
            </div>
        </header>
        <main class="py-8">
            @yield('content')
        </main>
        <footer class="bg-gray-900 text-gray-300 mt-10">
            <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-8">
                    <div class="flex-1 mb-6 md:mb-0">
                        <a href="{{ route('welcome') }}" class="flex items-center space-x-2 text-2xl font-bold text-white mb-2">
                            <i class="fas fa-recycle"></i>
                            <span>Reutiliz</span>
                        </a>
                        <p class="text-gray-400 text-sm max-w-xs">La plateforme pour donner une seconde vie à vos objets et trouver des trésors près de chez vous.</p>
                    </div>
                    <div class="flex-1 grid grid-cols-2 sm:grid-cols-4 gap-6 text-sm">
                        <div>
                            <h3 class="text-gray-200 font-semibold mb-2 uppercase text-xs tracking-wider">Solutions</h3>
                            <ul class="space-y-1">
                                <li><a href="#" class="hover:text-white transition">Vendre</a></li>
                                <li><a href="#" class="hover:text-white transition">Acheter</a></li>
                                <li><a href="#" class="hover:text-white transition">Échanger</a></li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-gray-200 font-semibold mb-2 uppercase text-xs tracking-wider">Support</h3>
                            <ul class="space-y-1">
                                <li><a href="#" class="hover:text-white transition">FAQ</a></li>
                                <li><a href="#" class="hover:text-white transition">Contactez-nous</a></li>
                                <li><a href="#" class="hover:text-white transition">Sécurité</a></li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-gray-200 font-semibold mb-2 uppercase text-xs tracking-wider">Entreprise</h3>
                            <ul class="space-y-1">
                                <li><a href="#" class="hover:text-white transition">À propos</a></li>
                                <li><a href="#" class="hover:text-white transition">Carrières</a></li>
                                <li><a href="#" class="hover:text-white transition">Presse</a></li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-gray-200 font-semibold mb-2 uppercase text-xs tracking-wider">Légal</h3>
                            <ul class="space-y-1">
                                <li><a href="#" class="hover:text-white transition">Confidentialité</a></li>
                                <li><a href="#" class="hover:text-white transition">Conditions</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="flex-1 flex md:justify-end items-start">
                        <div class="flex space-x-4">
                            <a href="#" class="hover:text-blue-400 transition"><i class="fab fa-facebook-f fa-lg"></i></a>
                            <a href="#" class="hover:text-pink-400 transition"><i class="fab fa-instagram fa-lg"></i></a>
                            <a href="#" class="hover:text-blue-300 transition"><i class="fab fa-twitter fa-lg"></i></a>
                        </div>
                    </div>
                </div>
                <div class="mt-10 border-t border-gray-700 pt-6 text-center text-xs text-gray-400">
                    &copy; {{ date('Y') }} Reutiliz. Tous droits réservés.
                </div>
            </div>
        </footer>
    </div>
</body>
</html> 