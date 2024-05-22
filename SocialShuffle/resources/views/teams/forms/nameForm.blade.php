@extends('layouts.app')

@section('title', 'Créer une équipe')

@section('content')

    <h2 class="text-2xl font-semibold mb-5">Créer une nouvelle équipe</h2>

    <div class="flex justify-center w-full">

        <form action="{{ route('team.store') }}" method="post" class="flex flex-col w-full max-w-sm">
            @csrf
    
            <div class="mb-5">
                {{-- <label for="name" class="block">Nom de l'équipe</label> --}}
                <input type="text" name="name" id="name" placeholder="Nom de l'équipe" class="border shadow rounded w-full px-2 py-1 focus:border-indigo-500 border-solid">
            </div>
            <div class=" self-end mb-5">
                <input type="submit" value="Suivant" class="text-white bg-indigo-500 px-3 py-1 rounded">
            </div>

        </form>
    </div>

@endsection