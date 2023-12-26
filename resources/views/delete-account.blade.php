@extends('layouts.app')

@section('content')
    <form  class="flex flex-col gap-2 m-auto" method="POST" action="/delete-account">
        @csrf
        <h2 class="text-center text-3xl md:text-4xl font-bold mb-2">Deletar Conta</h2>
        <span>Você tem certeza que deseja deletar sua conta?</span>

        <div class="flex flex-col">
            <label for="email">E-mail</label>
            <input class="p-2 border" name="email" placeholder="Digite o seu email" required />

            @if($errors->has('email'))
                <div class="text-sm text-red-800">{{ $errors->first('email') }}</div>
            @endif
        </div>

        <div class="flex flex-col">
            <label for="password">Senha</label>
            <input type="password" class="p-2 border" name="password" placeholder="Digite a sua senha" required />

            @if($errors->has('password'))
                <div class="text-sm text-red-800">{{ $errors->first('password') }}</div>
            @endif
        </div>

        <div class="flex justify-center">
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-md text-lg md:text-xl font-medium">
                Deletar Conta
            </button>
        </div>
    </form>
@endsection