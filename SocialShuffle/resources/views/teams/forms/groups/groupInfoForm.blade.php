@extends('layouts.app')
@section('title', 'Créer les groupes')

@section('content')
    <h2 class="text-2xl font-semibold mb-5">Créer les groupes</h2>

    <div class="flex justify-center w-full">

        <form action="{{ route('team.createGroups', ['team' => $team]) }}" method="POST" class="flex flex-col w-full max-w-sm">
            @csrf

            <div class="mb-5">
                <input type="text" name="nbMemberPerGroup" id="nbMemberPerGroup" placeholder="Nombre de membres par équipes"
                    value="{{ $team->nbMemberPerGroup ?? old('nbMemberPerGroup') }}"
                    class="border shadow rounded w-full px-2 py-1 focus:border-indigo-500 border-solid">
                @error('nbMemberPerGroup')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <input type="text" name="nbActivities" id="nbActivities" placeholder="Nombre d'activités (générations)"
                    value="{{ $team->nbActivities ?? old('nbActivities') }}"
                    class="border shadow rounded w-full px-2 py-1 focus:border-indigo-500 border-solid">
                @error('nbActivities')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            @if (isset($team))
                <div class=" self-end mb-5">
                    <input type="submit" value="Modifier" class="text-white bg-indigo-500 px-3 py-1 rounded">
                </div>
            @else
                <div class=" self-end mb-5">
                    <input type="submit" value="Créer les groupes" class="text-white bg-indigo-500 px-3 py-1 rounded">
                </div>
            @endif
            

        </form>
    </div>
@endsection