<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
        <h2 class="text-xl font-bold mb-6 flex items-center gap-2 text-blue-700">
            <i class="fas fa-user"></i>
            Modifier profil
        </h2>
        @if(session('status') === 'profile-updated')
            <div class="mb-4 p-3 rounded bg-green-100 text-green-800">Profil mis à jour avec succès.</div>
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
        <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
            @csrf
            @method('patch')
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nom</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" class="form-input h-8 text-xs px-2 border border-gray-300 rounded-md bg-white w-full" required autofocus autocomplete="name">
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" class="form-input h-8 text-xs px-2 border border-gray-300 rounded-md bg-white w-full" required autocomplete="username">
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-gray-800">
                            {{ __('Your email address is unverified.') }}
                            <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>
                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Téléphone</label>
                <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}" class="form-input h-8 text-xs px-2 border border-gray-300 rounded-md bg-white w-full" required autocomplete="tel">
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Adresse</label>
                <input id="address" name="address" type="text" value="{{ old('address', $user->address) }}" class="form-input h-8 text-xs px-2 border border-gray-300 rounded-md bg-white w-full" autocomplete="address">
                <x-input-error class="mt-2" :messages="$errors->get('address')" />
            </div>
            <div class="flex items-center gap-4 mt-8">
                <button type="submit" class="bg-blue-600 text-sm hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition flex items-center justify-center w-full sm:w-auto">
                    <i class="fas fa-save mr-1"></i>Enregistrer
                </button>
            </div>
        </form>
    </div>
</section>
