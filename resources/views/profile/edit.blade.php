<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Réglages du profil - Reutiliz</title>
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
    <div class="min-h-screen flex flex-col">
        <header class="bg-white/90 backdrop-blur sticky top-0 z-50 shadow-sm rounded-b-xl">
            <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-16">
                <a href="{{ route('welcome') }}" class="flex items-center space-x-2 text-xl font-bold text-blue-600">
                    <i class="fas fa-recycle"></i>
                    <span>Reutiliz</span>
                </a>
                <nav class="flex items-center space-x-2">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600 px-2 py-1 rounded text-xs transition"><i class="fas fa-home mr-1"></i>Home</a>
                    <a href="{{ route('profile.edit') }}" class="text-blue-600 font-semibold px-2 py-1 rounded text-xs transition"><i class="fas fa-cog mr-1"></i>Réglages</a>
                </nav>
            </div>
        </header>
        <main class="flex-1 py-10 bg-gray-50">
            <div class="max-w-2xl mx-auto px-4">
                <div class="flex items-center mb-8">
                    <i class="fas fa-cog text-blue-500 text-2xl mr-3"></i>
                    <h2 class="text-2xl font-bold text-gray-900">Réglages du profil</h2>
                </div>
                <div class="bg-white rounded-xl shadow p-8 space-y-8">
                    <div>
                        @include('profile.partials.update-profile-information-form')
                    </div>
                    <div>
                        @include('profile.partials.update-password-form')
                    </div>
                    <div>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
