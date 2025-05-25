<section aria-labelledby="filter-heading" class="bg-white p-4 md:p-6 rounded-xl shadow mb-8 max-w-7xl mx-auto">
    <form action="{{ route('welcome') }}" method="GET">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
            {{-- Search Input --}}
            <div>
                <label for="search" class="block text-xs font-medium text-gray-600 mb-1">Mot-clé</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                       placeholder="Ex: Smartphone..." 
                       class="form-input h-8 text-xs px-2 border border-gray-300 rounded-md bg-white w-full">
            </div>
            {{-- City Select --}}
            <div>
                <label for="city" class="block text-xs font-medium text-gray-600 mb-1">Ville</label>
                <select name="city" id="city" class="form-select h-8 text-xs px-2 border border-gray-300 rounded-md bg-white w-full">
                    <option value="">Toutes</option>
                    @foreach($cities as $city)
                        <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                            {{ $city }}
                        </option>
                    @endforeach
                </select>
            </div>
            {{-- Price Range --}}
            <div>
                <label for="min_price" class="block text-xs font-medium text-gray-600 mb-1">Prix min</label>
                <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}" 
                       placeholder="0" 
                       class="form-input h-8 text-xs px-2 border border-gray-300 rounded-md bg-white w-full">
            </div>
            <div>
                <label for="max_price" class="block text-xs font-medium text-gray-600 mb-1">Prix max</label>
                <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}" 
                       placeholder="Illimité" 
                       class="form-input h-8 text-xs px-2 border border-gray-300 rounded-md bg-white w-full">
            </div>
        </div>
        {{-- Filter Actions --}}
        <div class="flex flex-col md:flex-row justify-end gap-2 mt-3">
            <a href="{{ route('welcome') }}" 
               class="btn-secondary-outline px-3 py-1 text-xs h-8 flex items-center justify-center md:w-auto w-full">
                <i class="fas fa-undo-alt mr-1"></i>Réinit.
            </a>
            <button type="submit" 
                    class="btn-primary-solid px-3 py-1 text-xs h-8 flex items-center justify-center md:w-auto w-full">
                <i class="fas fa-filter mr-1"></i>Filtrer
            </button>
        </div>
    </form>
</section> 