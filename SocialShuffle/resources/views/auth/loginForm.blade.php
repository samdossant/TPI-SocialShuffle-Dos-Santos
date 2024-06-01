@extends('layouts.app')
@section('title', 'Se connecter')

@section('content')



    <div class="flex justify-center w-full">
        <form action="{{ route('auth.applyLogin') }}" method="POST"
            class="flex flex-col w-full max-w-sm space-y-5">
            @csrf
            <h2 class="text-2xl font-semibold mb-5">Se connecter</h2>
            
            <div>
                <input type="text" name="email" id="email" placeholder="Email ou Nom d'utilisateur"
                    class="border shadow rounded w-full p-2">
            </div>
            <div>
                <input type="password" name="password" id="password" placeholder="Mot de passe"
                    class="border shadow rounded w-full p-2">
            </div>
            <div class="self-end text-white bg-indigo-500 rounded p-2">
                <input type="submit" value="Se connecter" dusk="login-button">
            </div>
        </form>
    </div>
@endsection