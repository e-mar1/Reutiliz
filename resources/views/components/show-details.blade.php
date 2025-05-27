@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow rounded">

    <img src="https://inmedia.ma/wp-content/uploads/2024/12/pc-gamer-asus.webp" alt="Produit" class="w-full h-96 object-cover rounded-lg" />

    <h2 class="text-2xl font-bold mt-4">{{ $item->title }}</h2>

    <p class="text-gray-600 mt-2">{{ $item->description }}</p>
    <p class="text-lg font-semibold mt-4">
        @if ($item->is_free)
            <span class="font-bold text-green-600">Gratuit</span>
        @else
            Prix: {{ number_format($item->price, 2) }} MAD
        @endif
    </p>

    {{-- Contact Information --}}
    <div class="mt-6 space-x-4">
        @if ($item->admin_whatsapp)
            <a
              href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->admin_whatsapp) }}"
              target="_blank"
              class="inline-flex items-center bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg"
            >
                <i class="fab fa-whatsapp mr-2"></i> Contacter par WhatsApp
            </a>
        @endif

        @if ($item->admin_email)
            <a
              href="mailto:{{ $item->admin_email }}"
              class="inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg"
            >
                <i class="fas fa-envelope mr-2"></i> Envoyer un Email
            </a>
        @endif

        @if (!$item->admin_whatsapp && !$item->admin_email)
            <p class="text-gray-500">Aucune information de contact disponible pour cet article.</p>
        @endif
    </div>

    {{-- New: Favoris & Report Buttons --}}
    <div class="mt-6 flex space-x-4">
        @auth {{-- باش يبانو البوتونات غير للمستخدمين المسجلين الدخول --}}
            {{-- Bouton Favoris --}}
            <form action="{{ route('items.toggleFavorite', $item->id) }}" method="POST">
                @csrf
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 rounded-lg
                               @if(auth()->user()->favorites->contains($item->id))
                                   bg-yellow-500 hover:bg-yellow-600 text-white
                               @else
                                   bg-gray-200 hover:bg-gray-300 text-gray-800
                               @endif">
                    <i class="fas fa-star mr-2"></i>
                    @if(auth()->user()->favorites->contains($item->id))
                        Retirer des Favoris
                    @else
                        Ajouter aux Favoris
                    @endif
                </button>
            </form>

            {{-- Bouton Signaler (Report) --}}
            <a href="{{ route('reports.create', ['item_id' => $item->id]) }}"
               class="inline-flex items-center bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-flag mr-2"></i> Signaler l'article
            </a>
        @else
            <p class="text-gray-500">Connectez-vous pour ajouter aux favoris ou signaler cet article.</p>
        @endauth
    </div>

    {{-- Retour Link --}}
    <div class="mt-6">
        <a href="{{ route('welcome') }}" class="text-blue-500 hover:underline">
            &larr; Retour à la liste des articles
        </a>
    </div>

</div>

@endsection