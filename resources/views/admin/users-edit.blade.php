@extends('layouts.admin')

@section('content')
<div class="max-w-lg mx-auto bg-white rounded-2xl shadow-lg p-8 mt-10 border border-gray-100">
    <h2 class="text-xl font-bold mb-6 flex items-center gap-2 text-blue-700">
        <i class="fas fa-user-edit"></i>
        Modifier utilisateur
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
    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Nom</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-input h-8 text-xs px-2 border border-gray-300 rounded-md bg-white w-full" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-input h-8 text-xs px-2 border border-gray-300 rounded-md bg-white w-full" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Rôle</label>
            <input type="text" name="role" value="{{ old('role', $user->role) }}" class="form-input h-8 text-xs px-2 border border-gray-300 rounded-md bg-white w-full">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Statut</label>
            <input type="text" name="status" value="{{ old('status', $user->status) }}" class="form-input h-8 text-xs px-2 border border-gray-300 rounded-md bg-white w-full">
        </div>
        <div class="flex justify-between items-center mt-8 gap-2">
            <button type="submit" class="bg-blue-600 text-sm hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition">
                <i class="fas fa-save mr-1"></i>Enregistrer
            </button>
            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-sm hover:bg-red-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition">
                    <i class="fas fa-trash mr-1"></i>Supprimer
                </button>
            </form>
        </div>
    </form>
</div>
@endsection