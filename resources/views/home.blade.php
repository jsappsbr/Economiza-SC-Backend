@extends('layouts.app')

@section('content')
    <!-- Seção do Herói -->
    <section class="container mx-auto px-4 py-16 text-center">
        <h2 class="text-4xl md:text-5xl font-bold mb-4">Economize nas suas Compras de Mercado!</h2>
        <p class="text-lg md:text-xl text-gray-700 mb-8">O Economiza SC ajuda você a encontrar os melhores preços nos
            produtos de supermercado.</p>
        <div class="flex justify-center">
            <button class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-md text-lg md:text-xl font-medium">
                Baixe o App agora mesmo
            </button>
        </div>
    </section>

    <!-- Seção de Recursos -->
    <section class="bg-gray-200 py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-8">Recursos</h2>
            <div class="flex flex-col md:flex-row justify-center items-center gap-8">
                <!-- Item de Recurso 1 -->
                <div class="flex-1 max-w-xs bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold mb-4">Comparação de Preços</h3>
                    <p class="text-gray-700">Compare facilmente os preços em vários supermercados.</p>
                </div>
                <!-- Item de Recurso 2 -->
                <div class="flex-1 max-w-xs bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold mb-4">Notificações Inteligentes</h3>
                    <p class="text-gray-700">Receba alertas sobre quedas de preços e ofertas especiais.</p>
                </div>
                <!-- Item de Recurso 3 -->
                <div class="flex-1 max-w-xs bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold mb-4">Listas de Compras</h3>
                    <p class="text-gray-700">Organize e gerencie suas listas de compras de forma eficiente.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="container mx-auto px-4 py-16 mt-8"></section>
@endsection
 