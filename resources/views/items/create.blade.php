<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold mb-4">Publier un objet</h2>

                    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Image Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Photo de l'objet</label>
                            <div class="mt-1 flex items-center">
                                <input type="file" name="image" accept=".jpg,.png"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0 file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('image') border-red-500 @enderror">
                            </div>
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-500">JPG ou PNG. 5 MB maximum.</p>
                        </div>

                        <!-- Titre -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('title') border-red-500 @enderror">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Ville -->
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700">Ville</label>
                            <input type="text" name="city" id="city" value="{{ old('city') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('city') border-red-500 @enderror">
                            @error('city')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Catégorie -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Catégorie</label>
                            <select name="category" id="category"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('category') border-red-500 @enderror">
                                <option value="">Sélectionnez une catégorie</option>
                                <option value="electronics" {{ old('category') == 'electronics' ? 'selected' : '' }}>Électronique</option>
                                <option value="furniture" {{ old('category') == 'furniture' ? 'selected' : '' }}>Meubles</option>
                                <option value="clothing" {{ old('category') == 'clothing' ? 'selected' : '' }}>Vêtements</option>
                                <option value="books" {{ old('category') == 'books' ? 'selected' : '' }}>Livres</option>
                                <option value="sports" {{ old('category') == 'sports' ? 'selected' : '' }}>Sports</option>
                                <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Autre</option>
                            </select>
                            @error('category')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Prix -->
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="is_free" id="is_free" {{ old('is_free') ? 'checked' : '' }}
                                    class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 @error('is_free') border-red-500 @enderror">
                                <label for="is_free" class="ml-2 block text-sm text-gray-700">Gratuit</label>
                            </div>
                            @error('is_free')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <div id="price-field">
                                <label for="price" class="block text-sm font-medium text-gray-700">Prix (€)</label>
                                <input type="number" name="price" id="price" min="0" step="0.01" value="{{ old('price') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('price') border-red-500 @enderror">
                                @error('price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end gap-2">
                            <button type="submit"
                                class=" rounded-md border py-2 px-4 text-sm font-medium text-balck shadow ">
                                Publier l'objet
                            </button>
                            <a href="/" class="rounded-md border py-2 px-4 text-sm font-medium text-balck shadow ">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // ... existing code ...
    </script>
    @endpush
</x-app-layout>
