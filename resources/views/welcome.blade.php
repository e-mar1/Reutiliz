<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reutiliz - Annonces de Qualité</title>
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
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 mt-4">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 mt-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            </div>
        @endif
        <!-- Main Content -->
        <main class="py-8">
            <div class="container mx-auto px-4">
                <!-- Filters Section -->
                  <div class="max-w-7xl mx-auto px-4">
                <!-- Catégories populaires Section -->
                @if(isset($popularCategories) && count($popularCategories) > 0)
                <section class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2 flex items-center"><i class="fas fa-fire text-orange-500 mr-2"></i>Catégories populaires</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($popularCategories as $category)
                            <a href="{{ route('category.items', $category) }}" class="inline-block bg-blue-100 text-blue-700 text-xs font-semibold rounded px-3 py-1 hover:bg-blue-200 transition">{{ $category }}</a>
                        @endforeach
                    </div>
                </section>
                @endif




<section aria-labelledby="filter-heading" class="bg-white p-4 md:p-6 rounded-xl shadow mb-8 max-w-7xl mx-auto">
    <form action="{{ route('welcome') }}" method="GET">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <div>
                <label for="search" class="block text-xs font-medium text-gray-600 mb-1">Mot-clé</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Ex: Smartphone..." class="form-input h-8 text-xs px-2 border border-gray-300 rounded-md bg-white w-full">
            </div>
            <div>
                <label for="city" class="block text-xs font-medium text-gray-600 mb-1">Ville</label>
                <select name="city" id="city" class="form-select h-8 text-xs px-2 border border-gray-300 rounded-md bg-white w-full">
                    <option value="">Toutes</option>
                    @foreach($cities as $city)
                        <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="min_price" class="block text-xs font-medium text-gray-600 mb-1">Prix min</label>
                <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}" placeholder="0" class="form-input h-8 text-xs px-2 border border-gray-300 rounded-md bg-white w-full">
            </div>
            <div>
                <label for="max_price" class="block text-xs font-medium text-gray-600 mb-1">Prix max</label>
                <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}" placeholder="Illimité" class="form-input h-8 text-xs px-2 border border-gray-300 rounded-md bg-white w-full">
            </div>
        </div>
        <div class="flex flex-col md:flex-row justify-end gap-2 mt-3">
            <a href="{{ route('welcome') }}" class="btn-secondary-outline px-3 py-1 text-xs h-8 flex items-center justify-center md:w-auto w-full"><i class="fas fa-undo-alt mr-1"></i>Réinit.</a>
            <button type="submit" class="btn-primary-solid px-3 py-1 text-xs h-8 flex items-center justify-center md:w-auto w-full"><i class="fas fa-filter mr-1"></i>Filtrer</button>
        </div>
    </form>
</section>
<!-- Nouvelles annonces Section Title -->
                <div class="flex items-center mb-4 mt-8">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                        <i class="fas fa-bolt text-yellow-400 mr-2"></i>
                        @isset($currentCategory)
                            Catégorie : {{ $currentCategory }}
                        @else
                            Nouvelles annonces
                        @endisset
                    </h2>
                </div>

                @if($items->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                        @foreach($items as $item)
                            <article class="bg-white rounded-xl shadow hover:shadow-lg transition-all duration-200 flex flex-col overflow-hidden">
                                <a href="{{ route('items.show', $item->id) }}" class="block bg-gray-100 aspect-[4/3] overflow-hidden">
                                    <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover object-center transition-transform duration-200 hover:scale-105">
                                </a>
                                <div class="p-4 flex flex-col flex-grow">
                                    <span class="inline-block bg-blue-100 text-blue-700 text-xs font-semibold rounded px-2 py-0.5 mb-2">{{ $item->category ?: 'Non classé' }}</span>
                                    <h3 class="text-base font-semibold text-gray-900 mb-1 leading-tight">
                                        <a href="{{ route('items.show', $item->id) }}" class="hover:text-blue-600 transition-colors">{{ Str::limit($item->title, 45) }}</a>
                                    </h3>
                                    <p class="text-xs text-gray-500 mb-2 flex items-center"><i class="fas fa-map-marker-alt mr-1 text-gray-400"></i>{{ $item->city ?: 'Ville non spécifiée' }}</p>
                                    <p class="text-gray-600 text-xs mb-3 flex-grow">{{ Str::limit($item->description, 60) }}</p>
                                    <div class="mt-auto flex flex-col gap-2">
                                        <span class="text-lg font-bold text-blue-600">{{ $item->is_free ? 'Gratuit' : number_format($item->price, 2, ',', ' ') . ' DH' }}</span>
                                        <div class="flex gap-2">
                                            <button onclick="window.location='{{ route('items.show', $item->id) }}'" class="flex-1 btn-primary-solid text-xs py-2 mb-3"><i class="fas fa-shopping-cart mr-1"></i>Acheter</button>
                                            @auth
                                                <form action="{{ route('favorites.toggle', $item->id) }}" method="POST" class="flex-1">
                                                    @csrf
                                                    <button type="submit" class="w-full {{ Auth::user()->favorites->contains('item_id', $item->id) ? 'btn-danger-solid' : 'btn-secondary-outline' }} text-xs py-2">
                                                        <i class="fas fa-heart mr-1"></i>{{ Auth::user()->favorites->contains('item_id', $item->id) ? 'Retirer' : 'Favori' }}
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('login') }}" class="flex-1 btn-secondary-outline text-xs py-2 text-center"><i class="fas fa-heart mr-1"></i>Favori</a>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    <!-- Pagination -->
                    <nav aria-label="Pagination" class="mt-8 flex items-center justify-center">
                        {{ $items->appends(request()->query())->links('vendor.pagination.tailwind') }}
                    </nav>
                @else
                    <div class="text-center py-16 bg-white rounded-xl shadow">
                        <i class="fas fa-box-open fa-4x text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-800 mb-1">Aucun résultat</h3>
                        <p class="text-gray-600 max-w-md mx-auto text-sm">Nous n'avons trouvé aucun article correspondant à vos critères. Essayez d'élargir votre recherche ou de modifier vos filtres.</p>
                        <div class="mt-4">
                            <a href="{{ route('welcome') }}" class="btn-primary-solid text-sm px-4 py-2"><i class="fas fa-sync-alt mr-1"></i>Réinitialiser</a>
                        </div>
                    </div>
                @endif
            </div>
        </main>
        <x-footer />

    </div>
</body>
