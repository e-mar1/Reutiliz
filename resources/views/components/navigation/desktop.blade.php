<nav class="hidden sm:flex items-center space-x-2">
    <a href="{{ route('login') }}" class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 transition">
        <i class="fas fa-plus-circle mr-1"></i>Publier
    </a>
    @auth
        @include('components.navigation.user-dropdown')
    @else
        @include('components.navigation.guest-links')
    @endauth
</nav> 