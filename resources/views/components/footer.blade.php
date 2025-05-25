<footer class="bg-gray-900 text-gray-300 mt-10">
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-8">
            {{-- Logo and Description --}}
            <div class="flex-1 mb-6 md:mb-0">
                <a href="{{ route('welcome') }}" class="flex items-center space-x-2 text-2xl font-bold text-white mb-2">
                    <i class="fas fa-recycle"></i>
                    <span>Reutiliz</span>
                </a>
                <p class="text-gray-400 text-sm max-w-xs">
                    La plateforme pour donner une seconde vie à vos objets et trouver des trésors près de chez vous.
                </p>
            </div>
            {{-- Navigation Links --}}
            <div class="flex-1 grid grid-cols-2 sm:grid-cols-4 gap-6 text-sm">
                @include('components.footer.nav-column', [
                    'title' => 'Solutions',
                    'links' => [
                        ['text' => 'Vendre', 'url' => '#'],
                        ['text' => 'Acheter', 'url' => '#'],
                        ['text' => 'Échanger', 'url' => '#'],
                    ]
                ])
                @include('components.footer.nav-column', [
                    'title' => 'Support',
                    'links' => [
                        ['text' => 'FAQ', 'url' => '#'],
                        ['text' => 'Contactez-nous', 'url' => '#'],
                        ['text' => 'Sécurité', 'url' => '#'],
                    ]
                ])
                @include('components.footer.nav-column', [
                    'title' => 'Entreprise',
                    'links' => [
                        ['text' => 'À propos', 'url' => '#'],
                        ['text' => 'Carrières', 'url' => '#'],
                        ['text' => 'Presse', 'url' => '#'],
                    ]
                ])
                @include('components.footer.nav-column', [
                    'title' => 'Légal',
                    'links' => [
                        ['text' => 'Confidentialité', 'url' => '#'],
                        ['text' => 'Conditions', 'url' => '#'],
                    ]
                ])
            </div>
            {{-- Social Media --}}
            <div class="flex-1 flex md:justify-end items-start">
                @include('components.footer.social-links')
            </div>
        </div>
        {{-- Copyright --}}
        <div class="mt-10 border-t border-gray-700 pt-6 text-center text-xs text-gray-400">
            &copy; {{ date('Y') }} Reutiliz. Tous droits réservés.
        </div>
    </div>
</footer> 