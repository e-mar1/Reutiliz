<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reutiliz - Mes Favoris</title>
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
        <header class="bg-white/90 backdrop-blur sticky top-0 z-50 shadow-sm rounded-b-xl">
            <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-16">
                <a href="{{ route('welcome') }}" class="flex items-center space-x-2 text-xl font-bold text-blue-600">
                    <i class="fas fa-recycle"></i>
                    <span>Reutiliz</span>
                </a>
                
                <nav class="flex items-center space-x-2">
                    <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 transition"><i class="fas fa-plus-circle mr-1"></i>Publier</a>
                    @auth
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center space-x-2 px-2 py-1 rounded text-xs text-gray-700 hover:text-blue-600 focus:outline-none">
                                <i class="fas fa-user-circle text-lg"></i>
                                <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50 py-1">
                                <a href="{{ route('user.annonces') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-gray-700 hover:bg-blue-50">
                                    <i class="fas fa-bullhorn"></i> Mes annonces
                                </a>
                                <a href="{{ route('user.orders') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-gray-700 hover:bg-blue-50">
                                    <i class="fas fa-shopping-cart"></i> Mes commandes
                                </a>
                                <a href="{{ route('user.favorites') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-gray-700 hover:bg-blue-50">
                                    <i class="fas fa-heart"></i> Mes favoris
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

                <!-- Mobile Menu -->
                <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" class="sm:hidden border-t border-gray-200 bg-white shadow-md rounded-b-xl">
                    <div class="px-4 py-3 space-y-2">
                        <a href="{{ route('login') }}" class="block px-3 py-1 rounded-md text-xs font-medium text-white bg-blue-600 hover:bg-blue-700"><i class="fas fa-plus-circle mr-1"></i>Publier</a>
                        @auth
                            <a href="{{ route('dashboard') }}" class="block px-3 py-1 rounded-md text-xs font-medium text-gray-700 hover:bg-gray-50 hover:text-blue-600">Dashboard</a>
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
            </div>
        </header>

        <!-- Main Content -->
        <main class="py-8">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                        <i class="fas fa-heart text-red-500 mr-2"></i>
                        Mes Favoris
                    </h2>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-4">
                    @if(session('success'))
                        <div class="bg-white-100 border border-green-400 text-green-700 px-3 py-2 rounded relative mb-3 text-sm" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if($favorites->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                    @foreach($favorites as $favorite)
                        <article class="bg-white rounded-xl shadow hover:shadow-lg transition-all duration-200 flex flex-col overflow-hidden">
                            <a href="#" class="block bg-gray-100 aspect-[4/3] overflow-hidden">
                                <img src="{{ asset('storage/' . $favorite->item->image) }}" alt="{{ $favorite->item->title }}" class="w-full h-full object-cover object-center transition-transform duration-200 hover:scale-105">
                            </a>
                            <div class="p-4 flex flex-col flex-grow">
                                <span class="inline-block bg-blue-100 text-blue-700 text-xs font-semibold rounded px-2 py-0.5 mb-2">{{ $favorite->item->category ?: 'Non classé' }}</span>
                                <h3 class="text-base font-semibold text-gray-900 mb-1 leading-tight">
                                    <a href="#" class="hover:text-blue-600 transition-colors">{{ Str::limit($favorite->item->title, 45) }}</a>
                                </h3>
                                <p class="text-xs text-gray-500 mb-2 flex items-center"><i class="fas fa-map-marker-alt mr-1 text-gray-400"></i>{{ $favorite->item->city ?: 'Ville non spécifiée' }}</p>
                                <p class="text-gray-600 text-xs mb-3 flex-grow">{{ Str::limit($favorite->item->description, 60) }}</p>
                                <div class="mt-auto flex flex-col gap-2">
                                    <span class="text-lg font-bold text-blue-600">{{ $favorite->item->is_free ? 'Gratuit' : number_format($favorite->item->price, 2, ',', ' ') . ' €' }}</span>
                                    <div class="flex gap-2">
                                        <button class="flex-1 btn-primary-solid text-xs py-2"><i class="fas fa-shopping-cart mr-1"></i>Acheter</button>
                                        <form action="{{ route('favorites.toggle', $favorite->item->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" class="w-full btn-danger-solid text-xs py-2">
                                                <i class="fas fa-heart mr-1"></i>Retirer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                    </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-heart-broken fa-3x text-gray-300 mb-3"></i>
                            <h3 class="text-lg font-semibold text-gray-800 mb-1">Aucun favori</h3>
                            <p class="text-gray-600 max-w-md mx-auto text-sm">Vous n'avez pas encore ajouté d'articles à vos favoris. Parcourez les annonces et cliquez sur le cœur pour les ajouter ici.</p>
                            <div class="mt-3">
                                <a href="{{ route('welcome') }}" class="btn-primary-solid text-xs px-3 py-1.5"><i class="fas fa-search mr-1"></i>Retoure au Home</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 text-gray-300 mt-10">
            <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-8">
                    <!-- Logo and Description -->
                    <div class="flex-1 mb-6 md:mb-0">
                        <a href="{{ route('welcome') }}" class="flex items-center space-x-2 text-2xl font-bold text-white mb-2">
                            <i class="fas fa-recycle"></i>
                            <span>Reutiliz</span>
                        </a>
                        <p class="text-gray-400 text-sm max-w-xs">La plateforme pour donner une seconde vie à vos objets et trouver des trésors près de chez vous.</p>
                    </div>
                    <!-- Navigation Links -->
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
                    <!-- Social Media -->
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