@php use Illuminate\Support\Str; @endphp
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reutiliz - Détail de l'annonce</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.5/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
    </style>
</head>
<body class="antialiased">
    <div x-data="{ mobileMenuOpen: false }">
        <x-header />
        <!-- Main Content -->
        <main class="py-8 ">
            <div class="container mx-auto px-">
                <div class="max-w-7xl mx-auto px-4 bg-white rounded-xl shadow p-6 md:p-10 flex flex-col md:flex-row gap-8">
                    <div class="md:w-1/2 flex flex-col items-center relative">
                        <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->title }}" class="rounded-xl w-full object-cover object-center mb-4 max-h-96">
                       
                            <div x-data="{ showReportModal: false }" class="absolute left-0 bottom-3 m-4">
                            @auth
                            <button 
                                @click="showReportModal = true"
                                type="button"
                                class="btn-secondary-outline text-sm py-2 text-red-600 border-red-400 bg-red-50 flex items-center justify-center px-3 rounded"
                            >
                                <i class="fas fa-flag fa-lg mr-1"></i>Signaler
                            </button>
                            
                            <!-- Modal de signalement -->
                           <div
                                x-show="showReportModal"
                                style="background: rgba(0,0,0,0.4)"
                                class="fixed inset-0 font- flex items-center justify-center z-50"
                            >
                                <div class="bg-white rounded-xl shadow-lg max-w-md w-full p-8 relative">
                                    <button
                                        class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-2xl"
                                        @click="showReportModal = false"
                                    >×</button>
                                    <h2 class="text-lg font-semibold mb-4 text-red-600 flex items-center"><i class="fas fa-flag mr-2"></i>Signaler cette annonce</h2>
                                    <form method="POST" action="{{ route('items.report', $item->id) }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="block text-sm font-medium mb-1">Raison du signalement</label>
                                            <select name="reason" required class="w-full border rounded px-3 py-2">
                                                <option value="">Sélectionnez une raison</option>
                                                <option value="fraudulent">Annonce frauduleuse</option>
                                                <option value="inappropriate">Contenu inapproprié</option>
                                                <option value="duplicate">Annonce en double</option>
                                                <option value="wrong_category">Mauvaise catégorie</option>
                                                <option value="other">Autre raison</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="block text-sm font-medium mb-1">Description du problème</label>
                                            <textarea name="description" required class="w-full border rounded px-3 py-2" rows="4" placeholder="Veuillez décrire le problème en détail"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="block text-sm font-medium mb-1">Votre email (facultatif)</label>
                                            <input type="email" name="reporter_email" class="w-full border rounded px-3 py-2" placeholder="Votre email pour le suivi">
                                        </div>
                                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 rounded mt-2">
                                            Envoyer le signalement
                                        </button>
                                    </form>
                                </div>
                            </div>
                                @else
                                <button 
                                    @click="window.location.href='{{ route('login') }}'"
                                    type="button"
                                    class="btn-secondary-outline text-sm py-2 text-red-600 border-red-400 bg-red-50 flex items-center justify-center px-3 rounded"
                                >
                                    <i class="fas fa-flag fa-lg mr-1"></i>Signaler 
                                </button>
                                @endauth
                        </div>
                    </div>
                    <div class="md:w-1/2 flex flex-col gap-4">
                    <div class="flex items-center gap-4 mb-2">
                            <span class="inline-block bg-blue-100 text-blue-700 text-sm font-semibold rounded px-3 py-1">
                                <i class="fas fa-tag fa-lg mr-2"></i>{{ $item->category ?: 'Non classé' }}
                            </span>
                            <span class="text-sm text-gray-500 flex items-center">
                                <i class="fas fa-map-marker-alt fa-lg mr-1"></i>{{ $item->city ?: 'Ville non spécifiée' }}
                            </span>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $item->title }}</h1>
                        <p class="text-gray-700 text-base mb-2">{{ $item->description }}</p>
                        
                        <div class="flex items-center gap-4 mb-4">
                            <span class="text-xl font-bold text-blue-600">{{ $item->is_free ? 'Gratuit' : number_format($item->price, 2, ',', ' ') . ' DH' }}</span>
                        </div>
                        <div x-data="{ showPhoneModal: false }">
                            <div class="flex gap-2 mb-4">
                                <button 
                                    class="flex-1 text-sm py-4 rounded bg-blue-600 hover:bg-blue-700 text-white font-semibold transition h-full"
                                    @click="showPhoneModal = true"
                                    type="button"
                                >
                                    <i class="fas fa-phone fa-lg mr-2"></i>Contacter le Vendeur
                                </button>
                        @auth    
                            <form action="{{ route('favorites.toggle', $item->id) }}" method="POST" class="flex-1 text-sm rounded bg-pink-100 hover:bg-pink-200 transition h-full">
                                @csrf
                                <button class="w-full h-full flex items-center justify-center text-pink-600 py-4 font-semibold rounded">
                                    <i class="fas fa-heart fa-lg mr-2"></i>{{ Auth::user()->favorites->contains('item_id', $item->id) ? 'Retirer' : 'Favori' }}
                                </button>
                            </form>
                        @else
                        <div class="flex-1 text-sm rounded bg-pink-100 hover:bg-pink-200 transition h-full">
                            <a href="{{ route('login') }}" class="w-full h-full flex items-center justify-center text-pink-600 py-4 font-semibold rounded">
                                <i class="fas fa-heart fa-lg mr-2"></i>Favori
                            </a></div>
                        @endauth
                            </div>

                            <!-- Modal -->
                            <div 
                                x-show="showPhoneModal" 
                                style="background: rgba(0,0,0,0.4)" 
                                class="fixed inset-0 flex items-center justify-center z-50"
                            >
                                <div class="bg-white rounded-xl shadow-lg max-w-md w-full p-8 relative">
                                    <button 
                                        class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-2xl"
                                        @click="showPhoneModal = false"
                                    >&times;</button>
                                    <div class="flex flex-col items-center">
                                        <img src="https://cdn-icons-png.flaticon.com/512/565/565547.png" alt="Alerte" class="w-24 mb-4">
                                        <div class="text-center mb-4">
                                            <span class="text-red-600 font-bold text-lg">Attention !</span>
                                            <p class="text-gray-700 text-sm mt-2">
                                                Il ne faut jamais envoyer de l’argent à l’avance au vendeur par virement bancaire ou à travers une agence de transfert d’argent lors de l’achat des biens disponibles sur le site.
                                            </p>
                                        </div>
                                        <div class="mb-2 text-gray-700">Appeler {{ $item->user->name ?? 'le vendeur' }}</div>
                                        <button class="w-full border rounded px-4 py-2 text-lg font-semibold flex items-center justify-center gap-2 bg-gray-50 text-gray-800 cursor-default">
                                            <i class="fas fa-phone"></i>
                                            {{ $item->user->phone ?? 'Numéro non disponible' }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between items-center text-xs text-gray-400 mb-4">
                            <div>
                                Annonce publiée par <span class="font-semibold text-gray-700"> {{ $item->user->name ?? 'Utilisateur inconnu' }}</span>
                            </div>
                            <div class="flex">
                                
                                    @php
                                        // Format WhatsApp number for Morocco (remove leading 0, add 212)
                                        $rawPhone = preg_replace('/\D/', '', $item->user->phone ?? '');
                                        if(Str::startsWith($rawPhone, '0')) {
                                            $whatsappNumber = '212' . substr($rawPhone, 1);
                                        } else {
                                            $whatsappNumber = '212' . $rawPhone;
                                        }
                                        // WhatsApp message with item name (no image)
                                        $waMessage = "Bonjour, je suis intéressé par votre annonce \"" . $item->title . "\" sur Reutiliz: " . route('items.show', $item->id);
                                    @endphp

                                    <a href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode($waMessage) }}" 
                                       target="_blank" 
                                       class="btn-secondary-outline text-sm py-2 text-green-600 flex items-center justify-center px-2 rounded-l-md hover:bg-green-50 border-0">
                                        <i class="fab fa-whatsapp fa-3x"></i>
                                    </a>
                                <div x-data="{ showMailModal: false }" class="inline">
                                    <button 
                                        @click="showMailModal = true"
                                        type="button"
                                        class="btn-secondary-outline text-sm py-2 text-blue-600 flex items-center justify-center px-2 rounded-r-md hover:bg-blue-50 border-0"
                                        style="background: none; border: none;"
                                    >
                                        <i class="fas fa-envelope fa-3x"></i>
                                    </button>
                                    <!-- Modal -->
                                    <div 
                                        x-show="showMailModal"
                                        style="background: rgba(0,0,0,0.4)"
                                        class="fixed inset-0 flex items-center justify-center z-50"
                                    >
                                        <div class="bg-white rounded-xl shadow-lg max-w-md w-full p-8 relative">
                                            <button 
                                                class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-2xl"
                                                @click="showMailModal = false"
                                            >&times;</button>
                                            <h2 class="text-lg font-semibold mb-4 text-blue-700 flex items-center"><i class="fas fa-envelope mr-2"></i>Envoyer un email au vendeur</h2>
                                            <form method="POST" action="{{ route('items.contact', $item->id) }}">
                                                @csrf
                                                <div class="mb-3">
                                                    <label class="block text-sm font-medium mb-1">De</label>
                                                    <input type="email" name="from" required class="w-full border rounded px-3 py-2" placeholder="Votre email">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="block text-sm font-medium mb-1">À</label>
                                                    <input type="email" name="to" readonly class="w-full border rounded px-3 py-2 bg-gray-100" value="{{ $item->user->email ?? '' }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="block text-sm font-medium mb-1">Sujet</label>
                                                    <input type="text" name="subject" required class="w-full border rounded px-3 py-2" value="À propos de votre annonce: {{ $item->title }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="block text-sm font-medium mb-1">Description</label>
                                                    <textarea name="description" required class="w-full border rounded px-3 py-2" rows="4" placeholder="Votre message"></textarea>
                                                </div>
                                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded mt-2">
                                                    Envoyer
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comments Section -->
                <div class="max-w-7xl mx-auto px-4 mt-10">
                    <div class="flex flex-col md:flex-row md:gap-8">
                        <!-- Comments List (Left, 50%) -->
                        <div class="md:w-1/2 w-full text-[11px]">
                            <h2 class="text-base font-bold mb-4 flex items-center gap-2 text-blue-700">
                                <i class="fas fa-comments"></i> Commentaires
                            </h2>
                            @if(isset($item->comments) && $item->comments->count())
                                <div x-data="{ showAll: false }" class="space-y-3 mb-4">
                                    @foreach($item->comments as $i => $comment)
                                        <div class="bg-gray-50 rounded-lg p-3 shadow flex flex-col" x-show="showAll || {{ $i }} < 3">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="font-semibold text-gray-800 text-[11px]">{{ $comment->user->name ?? 'Utilisateur' }}</span>
                                                <span class="text-[10px] text-gray-500">{{ \Carbon\Carbon::parse($comment->created_at)->format('d/m/Y H:i') }}</span>
                                            </div>
                                            <div class="text-yellow-500 mb-1 text-[10px]">
                                                @for($j = 0; $j < $comment->rating; $j++)
                                                    <i class="fas fa-star"></i>
                                                @endfor
                                                @for($j = $comment->rating; $j < 5; $j++)
                                                    <i class="far fa-star"></i>
                                                @endfor
                                            </div>
                                            <div class="text-gray-700 text-[11px]">{{ $comment->content }}</div>
                                        </div>
                                    @endforeach
                                    @if($item->comments->count() > 3)
                                        <button x-show="!showAll" @click="showAll = true" class="mt-2 text-blue-600 hover:underline text-[10px] font-semibold">Afficher plus de commentaires</button>
                                    @endif
                                </div>
                            @else
                                <div class="text-gray-500 mb-6 text-[11px]">Aucun commentaire pour cette annonce.</div>
                            @endif
                        </div>
                        <!-- Add Comment Form (Right, 50%) -->
                        <div class="md:w-1/2 w-full md:pl-8 flex flex-col text-[11px]" id="ajouter-commentaire">
                            <h3 class="text-sm font-semibold mb-2 flex items-center"><i class="fas fa-pen text-blue-400 mr-2"></i>Écrire un commentaire</h3>
                            @auth
                            <div class="bg-white rounded-xl shadow p-4 mb-4">
                                <form method="POST" action="{{ route('comments.store', $item->id) }}">
                                    @csrf
                                    <div class="mb-2">
                                        <label class="block font-medium mb-1 text-[11px]">Note</label>
                                        <div class="flex items-center gap-1" x-data="{ rating: 0 }">
                                            <template x-for="star in 5" :key="star">
                                                <button type="button" @click.prevent="rating = star" @mouseover="rating = star" @mouseleave="rating = $refs.input.value" :class="rating >= star ? 'text-yellow-400' : 'text-gray-300'" class="focus:outline-none">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.175c.969 0 1.371 1.24.588 1.81l-3.38 2.455a1 1 0 00-.364 1.118l1.287 3.966c.3.922-.755 1.688-1.54 1.118l-3.38-2.454a1 1 0 00-1.176 0l-3.38 2.454c-.784.57-1.838-.196-1.54-1.118l1.287-3.966a1 1 0 00-.364-1.118L2.05 9.394c-.783-.57-.38-1.81.588-1.81h4.175a1 1 0 00.95-.69l1.286-3.967z"/></svg>
                                                </button>
                                            </template>
                                            <input x-ref="input" type="hidden" name="rating" x-model="rating" required>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label class="block font-medium mb-1 text-[11px]">Commentaire</label>
                                        <textarea name="content" required class="w-full border rounded px-2 py-1 text-[11px]" rows="3" placeholder="Votre commentaire..."></textarea>
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-1 px-3 rounded text-[10px] w-auto min-w-0">
                                            Publier le commentaire
                                        </button>
                                    </div>
                                </form>
                            </div>
                            @else
                                <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded mb-6 text-[11px]">
                                    <i class="fas fa-info-circle mr-2"></i> <a href="{{ route('login') }}" class="underline">Connectez-vous</a> pour écrire un commentaire.
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>

                @if(isset($relatedItems) && $relatedItems->count() > 0)
                <div class="max-w-7xl mx-auto px-4 mt-10">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center"><i class="fas fa-link text-blue-400 mr-2"></i>Articles similaires</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach($relatedItems as $related)
                        <a href="{{ route('items.show', $related->id) }}" class="bg-white rounded-xl shadow hover:shadow-lg transition-all duration-200 flex flex-col overflow-hidden">
                            <img src="{{ asset('storage/'.$related->image) }}" alt="{{ $related->title }}" class="w-full h-48 object-cover object-center">
                            <div class="p-5 flex flex-col flex-grow">
                                <span class="inline-block bg-blue-100 text-blue-700 text-xs font-semibold rounded px-2.5 py-1 mb-2"><i class="fas fa-tag fa-sm mr-1.5"></i>{{ $related->category ?: 'Non classé' }}</span>
                                <h3 class="text-lg font-semibold text-gray-900 mb-1.5 leading-tight">{{ Str::limit($related->title, 50) }}</h3>
                                <span class="text-xs text-gray-500 mb-1.5 flex items-center"><i class="fas fa-map-marker-alt fa-sm mr-1.5"></i>{{ $related->city ?: 'Ville non spécifiée' }}</span>
                                <span class="text-lg text-blue-600 font-bold">{{ $related->is_free ? 'Gratuit' : number_format($related->price, 2, ',', ' ') . ' DH' }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                
            </div>
        </main>
        <x-footer />
    </div>
</body>