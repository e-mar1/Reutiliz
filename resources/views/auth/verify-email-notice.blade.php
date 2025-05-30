<x-guest-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden p-6">
            <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Vérification de l'adresse e-mail</h2>
            
            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
                Un lien de vérification a été envoyé à votre adresse e-mail. Veuillez vérifier votre boîte de réception et cliquer sur le lien pour activer votre compte.
            </div>
            
            <p class="text-gray-600 mb-6">Si vous n'avez pas reçu l'e-mail, vous pouvez demander un nouveau lien de vérification.</p>
            
            <div class="flex flex-col space-y-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Renvoyer l'email de vérification
                    </button>
                </form>

                <a href="{{ route('login') }}" class="text-center text-blue-600 hover:text-blue-800">
                    Retour à la connexion
                </a>
            </div>
        </div>
    </div>
</x-guest-layout> 