<header class="bg-white/90 backdrop-blur sticky top-0 z-50 shadow-sm rounded-b-xl">
    <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-16">
        {{-- Logo --}}
        <a href="{{ route('welcome') }}" class="flex items-center space-x-2 text-xl font-bold text-blue-600">
            <i class="fas fa-recycle"></i>
            <span>Reutiliz</span>
        </a>
        {{-- Desktop Navigation --}}
        @include('components.navigation.desktop')
        {{-- Mobile Menu Button --}}
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="sm:hidden p-2 rounded-md text-gray-600 hover:text-blue-600 focus:outline-none">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    {{-- Mobile Navigation --}}
    @include('components.navigation.mobile')
</header> 