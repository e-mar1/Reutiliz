{{-- Section Title --}}
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
    {{-- Items Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
        @foreach($items as $item)
            @include('components.item-card', ['item' => $item])
        @endforeach
    </div>
    {{-- Pagination --}}
    <nav aria-label="Pagination" class="mt-8 flex items-center justify-center">
        {{ $items->appends(request()->query())->links('vendor.pagination.tailwind') }}
    </nav>
@else
    @include('components.no-results')
@endif 