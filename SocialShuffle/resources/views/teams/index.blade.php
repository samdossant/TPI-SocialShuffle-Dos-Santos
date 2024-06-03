@extends('layouts.app')

@section('title', 'Équipes')

@section('content')
    @auth
        <h2 class="text-2xl font-semibold">Vos équipes</h2>
    @endauth

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4 ">

        @auth
            @forelse ($userTeams as $team)
                <div class=" flex bg-blue-200 rounded-lg shadow-md ">
                    <div class=" bg-blue-200 rounded-lg">
                        <div class=" row-span-2 flex-1 p-4">
                            <h3 class="font-semibold text-lg">{{ $team->name }}</h3>
                            <p class="text-sm text-gray-600">Membres : <span class="font-bold">{{ $team->members_count }}</span></p>
                        </div>

                        <div class=" flex justify-between p-2">
                            <a href="{{ route('team.show', $team->id) }}" class=" ">
                                <svg width="24px" height="24px" viewBox="0 0 24 24" stroke-width="1.5" fill="none" xmlns="http://www.w3.org/2000/svg" color="#000000"><path d="M3 12L21 12M21 12L12.5 3.5M21 12L12.5 20.5" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                Aucune équipe n'a encore été créée
            @endforelse
        @endauth
        
    </div>

    <h2 class="text-2xl font-semibold mt-10">Toutes les équipes</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4 ">
        @forelse ($allTeams as $team)
            <div class=" flex bg-blue-200 rounded-lg shadow-md ">
                <div class=" bg-blue-200 rounded-lg">
                    <div class=" row-span-2 flex-1 p-4">
                        <h3 class="font-semibold text-lg">{{ $team->name }}</h3>
                        <p class="text-sm text-gray-600">Membres : <span class="font-bold">{{ $team->members_count }}</span></p>
                    </div>

                    <div class=" flex justify-between p-2">
                        <a href="{{ route('team.show', $team->id) }}" class=" ">
                            <svg width="24px" height="24px" viewBox="0 0 24 24" stroke-width="1.5" fill="none" xmlns="http://www.w3.org/2000/svg" color="#000000"><path d="M3 12L21 12M21 12L12.5 3.5M21 12L12.5 20.5" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            Aucune équipe n'a encore été créée
        @endforelse
        </div>
@endsection