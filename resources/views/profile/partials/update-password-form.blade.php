<div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 mt-8">
    <h2 class="text-xl font-bold mb-6 flex items-center gap-2 text-blue-700">
        <i class="fas fa-lock"></i>
        Modifier le mot de passe
    </h2>
    @if (session('status') === 'password-updated')
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800">Mot de passe mis à jour avec succès.</div>
    @endif
    @if ($errors->updatePassword->any())
        <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
            <ul class="list-disc pl-5">
                @foreach ($errors->updatePassword->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Mot de passe actuel</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-input h-8 text-xs px-2 border border-gray-300 rounded-md bg-white w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Nouveau mot de passe</label>
            <input id="update_password_password" name="password" type="password" class="form-input h-8 text-xs px-2 border border-gray-300 rounded-md bg-white w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Confirmer le mot de passe</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-input h-8 text-xs px-2 border border-gray-300 rounded-md bg-white w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>
        <div class="flex items-center gap-4 mt-8">
            <button type="submit" class="bg-blue-600 text-sm hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition flex items-center justify-center w-full sm:w-auto">
                <i class="fas fa-save mr-1"></i>Enregistrer
            </button>
        </div>
    </form>
</div>
