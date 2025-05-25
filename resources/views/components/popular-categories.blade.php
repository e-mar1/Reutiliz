@if(isset($popularCategories) && count($popularCategories) > 0)
<section class="mb-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-2 flex items-center">
        <i class="fas fa-fire text-orange-500 mr-2"></i>Catégories populaires
    </h2>
    <div class="flex flex-wrap gap-2">
        @foreach($popularCategories as $category)
            <a href="{{ route('category.items', $category) }}" 
               class="inline-block bg-blue-100 text-blue-700 text-xs font-semibold rounded px-3 py-1 hover:bg-blue-200 transition">
                {{ $category }}
            </a>
        @endforeach
    </div>
</section>
@endif 