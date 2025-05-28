@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-lg p-8 mt-10 border border-gray-100">
    <h2 class="text-2xl font-bold mb-6 flex items-center gap-2 text-blue-700">
        <i class="fas fa-bullhorn"></i>
        Mes annonces
    </h2>
    @if(session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>
    @endif
    @if($items->isEmpty())
        <div class="text-gray-500 text-center py-8">Vous n'avez publié aucune annonce pour le moment.</div>
    @else
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ville</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($items as $item)
                <tr>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $item->title }}</td>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ Str::limit($item->description, 40) }}</td>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $item->is_free ? 'Gratuit' : number_format($item->price, 2, ',', ' ') . ' €' }}</td>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $item->city }}</td>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
