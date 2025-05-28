@extends('layouts.admin')

@section('content')
<div class="max-w-lg mx-auto bg-white rounded-2xl shadow-lg p-8 mt-10 border border-gray-100">
    <h2 class="text-xl font-bold mb-6 flex items-center gap-2 text-green-700">
        <i class="fas fa-bullhorn"></i>
        Publier une annonce
    </h2>
    @if(session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('publier') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Titre</label>
            <input type="text" name="title" value="{{ old('title') }}" class="form-input h-8 text-xs px-2 border border-gray-300 rounded-md bg-white w-full" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
            <textarea name="description" class="form-input h-20 text-xs px-2 border border-gray-300 rounded-md bg-white w-full" required minlength="20">{{ old('description') }}</textarea>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Type d'annonce</label>
            <div class="flex items-center gap-4">
                <label class="flex items-center">
                    <input type="radio" name="is_free" value="1" {{ old('is_free') == '1' ? 'checked' : '' }} class="form-radio text-green-600"> <span class="ml-2 text-xs">Gratuit</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="is_free" value="0" {{ old('is_free') == '0' ? 'checked' : '' }} class="form-radio text-green-600"> <span class="ml-2 text-xs">Avec prix</span>
                </label>
            </div>
        </div>
        <div class="mb-4" id="price-input-wrapper">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Prix</label>
            <input type="number" name="price" id="price-input" value="{{ old('price') }}" class="form-input h-8 text-xs px-2 border border-gray-300 rounded-md bg-white w-full" min="0">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Ville</label>
            <input type="text" name="city" value="{{ old('city') }}" class="form-input h-8 text-xs px-2 border border-gray-300 rounded-md bg-white w-full" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Catégorie</label>
            <input type="text" name="category" value="{{ old('category') }}" class="form-input h-8 text-xs px-2 border border-gray-300 rounded-md bg-white w-full">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Image</label>
            <input type="file" name="image" class="form-input h-8 text-xs px-2 border border-gray-300 rounded-md bg-white w-full" accept="image/*">
            <small class="text-xs text-gray-500">Taille max: 5 Mo</small>
        </div>
        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
        <div class="flex flex-col sm:flex-row justify-between items-center mt-8 gap-3">
            <button type="submit" class="bg-green-600 text-sm hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition flex items-center justify-center w-full sm:w-auto">
                <i class="fas fa-save mr-1"></i>Publier
            </button>
        </div>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const freeRadio = document.querySelector('input[name="is_free"][value="1"]');
        const priceRadio = document.querySelector('input[name="is_free"][value="0"]');
        const priceInput = document.getElementById('price-input');
        function togglePriceInput() {
            if (freeRadio.checked) {
                priceInput.value = 0;
                priceInput.setAttribute('disabled', 'disabled');
                priceInput.removeAttribute('required');
            } else {
                priceInput.removeAttribute('disabled');
                priceInput.setAttribute('required', 'required');
            }
        }
        freeRadio.addEventListener('change', togglePriceInput);
        priceRadio.addEventListener('change', togglePriceInput);
        togglePriceInput();
    });
</script>
@endsection
