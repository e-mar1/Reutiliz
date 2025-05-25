<div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" 
     class="sm:hidden border-t border-gray-200 bg-white shadow-md rounded-b-xl">
    <div class="px-4 py-3 space-y-2">
        <a href="{{ route('login') }}" class="block px-3 py-1 rounded-md text-xs font-medium text-white bg-blue-600 hover:bg-blue-700">
            <i class="fas fa-plus-circle mr-1"></i>Publier
        </a>
        @auth
            <a href="{{ route('dashboard') }}" class="block px-3 py-1 rounded-md text-xs font-medium text-gray-700 hover:bg-gray-50 hover:text-blue-600">
                Dashboard
            </a>
            <form method="POST" action="{{ route('logout') }}" class="block">
                @csrf
                <button type="submit" class="w-full text-left block px-3 py-1 rounded-md text-xs font-medium text-gray-700 hover:bg-gray-50 hover:text-blue-600">
                    <i class="fas fa-sign-out-alt mr-1"></i>Déconnexion
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="block px-3 py-1 rounded-md text-xs font-medium text-gray-700 hover:bg-gray-50 hover:text-blue-600">
                <i class="fas fa-sign-in-alt mr-1"></i>Connexion
            </a>
            <a href="{{ route('register') }}" class="block px-3 py-1 rounded-md text-xs font-medium text-gray-700 hover:bg-gray-50 hover:text-blue-600">
                <i class="fas fa-user-plus mr-1"></i>S'inscrire
            </a>
        @endauth
    </div>
</div> 