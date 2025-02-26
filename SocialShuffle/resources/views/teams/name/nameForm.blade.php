@extends('layouts.app')

@section('title', isset($team) ? 'Modifier l\'équipe' : 'Créer l\'équipe')

@section('content')

    <h2 class="text-2xl font-semibold mb-5">{{ isset($team) ? 'Modifier l\'équipe' : 'Créer l\'équipe' }}</h2>

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
                @error('name')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            @if (isset($team))
                <div class=" self-end mb-5">
                    <input type="submit" value="Modifier" class="text-white bg-indigo-500 hover:bg-indigo-400 px-3 py-1 rounded">
                </div>
            @else
                <div class=" self-end mb-5">
                    <input type="submit" value="Suivant" dusk="next-button" class="text-white bg-indigo-500 hover:bg-indigo-400 px-3 py-1 rounded">
                </div>
            @endif
            

        </form>
    </div>

@endsection