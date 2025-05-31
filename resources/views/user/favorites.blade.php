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
        <x-header />
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
        <x-footer />
    </div>
</body>
</html>