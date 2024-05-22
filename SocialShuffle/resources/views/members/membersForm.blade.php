@extends('layouts.app')

@section('title', 'Créer une équipe')

@section('content')

    <h2 class="text-2xl font-semibold mb-5">Ajouter les membres</h2>

    <div class="flex flex-col justify-center w-full">

        <a href="" class="">Suivant</a>

        <form action="{{ route('team.member.store', ['team' => $team]) }}" method="post" class="flex flex-col w-full max-w-sm space-y-5">
            @csrf

            <div>
                <input type="text" name="firstname" id="firstname" placeholder="Prénom" class="border shadow rounded w-full px-2 py-1 focus:border-indigo-500 border-solid">
            </div>
            <div>
                <input type="text" name="lastname" id="lastname" placeholder="Nom" class="border shadow rounded w-full px-2 py-1 focus:border-indigo-500 border-solid">
            </div>
            <div>
                <input type="text" name="email" id="email" placeholder="Email" class="border shadow rounded w-full px-2 py-1 focus:border-indigo-500 border-solid">
            </div>
            <div>
                <input type="text" name="phoneNumber" id="phoneNumber" placeholder="Numéro de téléphone" class="border shadow rounded w-full px-2 py-1 focus:border-indigo-500 border-solid">
            </div>
            <div class=" self-end">
                <input type="submit" value="Ajouter un membre" class="text-white bg-indigo-500 px-3 py-1 rounded">
            </div>

        </form>

        @include('layouts.membersComponent')

    </div>

@endsection