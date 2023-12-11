<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Economiza SC</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="antialiased flex flex-col w-screen h-screen">
<header class="bg-red-600 text-white py-4">
    <div class="container mx-auto px-4 flex items-center justify-between">
        <h1 class="text-2xl md:text-3xl font-bold">
            <a href="/">Economiza SC</a>
        </h1>
        <nav>
            <a href="/privacy-policy" class="text-sm md:text-base font-medium mr-4">Política de privacidade</a>
            <a href="#" class="text-sm md:text-base font-medium">Baixar</a>
        </nav>
    </div>
</header>

@yield('content')

<footer class="bg-red-600 text-white py-6 mt-auto">
    <div class="container mx-auto px-4 text-center">
        <p>&copy; {{ now()->year  }} Economiza SC. Todos os direitos reservados.</p>
    </div>
</footer>
</body>
</html>
