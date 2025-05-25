<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" class="flex items-center space-x-2 px-2 py-1 rounded text-xs text-gray-700 hover:text-blue-600 focus:outline-none">
        <i class="fas fa-user-circle text-lg"></i>
        <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
    </button>
    <div x-show="open" @click.away="open = false" 
         class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-md shadow-lg z-50 py-1">
        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-xs text-gray-700 hover:bg-blue-50">
            Profil
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left block px-4 py-2 text-xs text-gray-700 hover:bg-blue-50">
                Déconnexion
            </button>
        </form>
    </div>
</div> 