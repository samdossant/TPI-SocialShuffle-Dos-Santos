@extends('layouts.app')

@section('title', 'Détails')

@section('content')
    <h2 class="text-4xl font-semibold mb-5">Détails de l'équipe</h2>

    <p class="text-2xl font-semibold mb-5">{{ $team->name }}</p>

    @include('layouts.membersComponent')
    
    <p class="text-lg mb-3"><span class="font-bold">5</span> personnes par groupe</p>

@endsection