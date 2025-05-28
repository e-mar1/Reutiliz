<footer class="bg-gray-900 text-gray-300 mt-10">
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-8">
            <!-- Logo and Description -->
            <div class="flex-1 mb-6 md:mb-0">
                <a href="{{ route('welcome') }}" class="flex items-center space-x-2 text-2xl font-bold text-white mb-2">
                    <i class="fas fa-recycle"></i>
                    <span>Reutiliz</span>
                </a>
                <p class="text-gray-400 text-sm max-w-xs">La plateforme pour donner une seconde vie à vos objets et trouver des trésors près de chez vous.</p>
            </div>
            <!-- Navigation Links -->
            <div class="flex-1 grid grid-cols-2 sm:grid-cols-4 gap-6 text-sm">
                <div>
                    <h3 class="text-gray-200 font-semibold mb-2 uppercase text-xs tracking-wider">Solutions</h3>
                    <ul class="space-y-1">
                        <li><a href="#" class="hover:text-white transition">Vendre</a></li>
                        <li><a href="#" class="hover:text-white transition">Acheter</a></li>
                        <li><a href="#" class="hover:text-white transition">Échanger</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-gray-200 font-semibold mb-2 uppercase text-xs tracking-wider">Support</h3>
                    <ul class="space-y-1">
                        <li><a href="#" class="hover:text-white transition">FAQ</a></li>
                        <li><a href="#" class="hover:text-white transition">Contactez-nous</a></li>
                        <li><a href="#" class="hover:text-white transition">Sécurité</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-gray-200 font-semibold mb-2 uppercase text-xs tracking-wider">Entreprise</h3>
                    <ul class="space-y-1">
                        <li><a href="#" class="hover:text-white transition">À propos</a></li>
                        <li><a href="#" class="hover:text-white transition">Carrières</a></li>
                        <li><a href="#" class="hover:text-white transition">Presse</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-gray-200 font-semibold mb-2 uppercase text-xs tracking-wider">Légal</h3>
                    <ul class="space-y-1">
                        <li><a href="#" class="hover:text-white transition">Confidentialité</a></li>
                        <li><a href="#" class="hover:text-white transition">Conditions</a></li>
                    </ul>
                </div>
            </div>
            <!-- Social Media Links -->
            <div class="flex-1 flex md:justify-end items-start">
                <div class="flex space-x-4">
                    <a href="#" class="hover:text-blue-400 transition"><i class="fab fa-facebook-f fa-lg"></i></a>
                    <a href="#" class="hover:text-pink-400 transition"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="hover:text-blue-300 transition"><i class="fab fa-twitter fa-lg"></i></a>
                </div>
            </div>
        </div>
        <div class="mt-10 border-t border-gray-700 pt-6 text-center text-xs text-gray-400">
            &copy; {{ date('Y') }} Reutiliz. Tous droits réservés.
        </div>
    </div>
</footer>