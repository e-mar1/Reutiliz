@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Signaler un article</h1>

    @if ($item)
        <p class="mb-4">Vous signalez l'article: <span class="font-semibold">{{ $item->title }}</span></p>
    @endif

    <form action="{{ route('reports.store') }}" method="POST">
        @csrf
        <input type="hidden" name="item_id" value="{{ $item ? $item->id : '' }}">

        <div class="mb-4">
            <label for="reason" class="block text-gray-700 text-sm font-bold mb-2">Raison du signalement:</label>
            <textarea name="reason" id="reason" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
        </div>

        @error('reason')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Envoyer le signalement
            </button>
            <a href="{{ route('components.show-details', $item->id) }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection