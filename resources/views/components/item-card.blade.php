<article class="bg-white rounded-xl shadow hover:shadow-lg transition-all duration-200 flex flex-col overflow-hidden">
    {{-- Item Image --}}
    <a href="#" class="block bg-gray-100 aspect-[4/3] overflow-hidden">
        <img src="https://inmedia.ma/wp-content/uploads/2024/12/pc-gamer-asus.webp" 
             alt="{{ $item->title }}" 
             class="w-full h-full object-cover object-center transition-transform duration-200 hover:scale-105">
    </a>
    {{-- Item Details --}}
    <div class="p-4 flex flex-col flex-grow">
        {{-- Category Badge --}}
        <span class="inline-block bg-blue-100 text-blue-700 text-xs font-semibold rounded px-2 py-0.5 mb-2">
            {{ $item->category ?: 'Non classé' }}
        </span>
        {{-- Title --}}
        <h3 class="text-base font-semibold text-gray-900 mb-1 leading-tight">
            <a href="#" class="hover:text-blue-600 transition-colors">
                {{ Str::limit($item->title, 45) }}
            </a>
        </h3>
        {{-- Location --}}
        <p class="text-xs text-gray-500 mb-2 flex items-center">
            <i class="fas fa-map-marker-alt mr-1 text-gray-400"></i>
            {{ $item->city ?: 'Ville non spécifiée' }}
        </p>
        {{-- Description --}}
        <p class="text-gray-600 text-xs mb-3 flex-grow">
            {{ Str::limit($item->description, 60) }}
        </p>
        {{-- Price and Actions --}}
        <div class="mt-auto flex flex-col gap-2">
            <span class="text-lg font-bold text-blue-600">
                {{ $item->is_free ? 'Gratuit' : number_format($item->price, 2, ',', ' ') . ' €' }}
            </span>
            <div class="flex gap-2">
                <button class="flex-1 btn-primary-solid text-xs py-2">
                    <i class="fas fa-shopping-cart mr-1"></i>Acheter
                </button>
                <button class="flex-1 btn-secondary-outline text-xs py-2">
                    <i class="fas fa-heart mr-1"></i>Favori
                </button>
            </div>
        </div>
    </div>
</article> 