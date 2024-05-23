@extends('layouts.app')

@section('title', 'Créer une équipe')

@section('content')

    <h2 class="text-2xl font-semibold mb-5">Créer une nouvelle équipe</h2>

    <div class="flex justify-center w-full">

        <form action="{{ isset($team) ? route('team.update', ['team' => $team]) : route('team.store') }}" method="POST" class="flex flex-col w-full max-w-sm">
            @csrf

            @isset($team)
                @method('PUT')
            @endisset
    
            <div class="mb-5">
                <input type="text" name="name" id="name" placeholder="Nom de l'équipe"
                    value="{{ $team->name ?? old('name') }}"
                    class="border shadow rounded w-full px-2 py-1 focus:border-indigo-500 border-solid">
            </div>

            @isset($team)
                
            @endisset

            @if (isset($team))
                <div class=" self-end mb-5">
                    <input type="submit" value="Modifier" class="text-white bg-indigo-500 px-3 py-1 rounded">
                </div>
            @else
                <div class=" self-end mb-5">
                    <input type="submit" value="Suivant" class="text-white bg-indigo-500 px-3 py-1 rounded">
                </div>
            @endif
            

        </form>
    </div>

@endsection