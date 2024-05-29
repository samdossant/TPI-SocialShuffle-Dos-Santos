@extends('layouts.app')

@section('title', 'Créer une équipe')

@section('content')

    <h2 class="text-2xl font-semibold mb-5">{{ isset($member) ? 'Modifier le membre' : 'Ajouter les membres' }}</h2>

    <div class="flex justify-center w-full">

        <form action="{{ isset($member) ? route('team.members.update', ['team' => $team, 'member' => $member]) : route('team.members.store', ['team' => $team]) }}" method="post" 
            class="flex flex-col w-full max-w-sm space-y-5">
            @csrf

            @isset($member)
                @method('PUT')
            @endisset

            <div>
                <input type="text" name="firstname" id="firstname" placeholder="Prénom" 
                    value="{{ $member->firstname ?? old('firstname') }}"
                    class="border shadow rounded w-full px-2 py-1 focus:border-indigo-500 border-solid">
                @error('firstname')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <input type="text" name="lastname" id="lastname" placeholder="Nom" 
                    value="{{ $member->lastname ?? old('lastname') }}"
                    class="border shadow rounded w-full px-2 py-1 focus:border-indigo-500 border-solid">
                @error('lastname')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <input type="text" name="email" id="email" placeholder="Email" 
                    value="{{ $member->email ?? old('email') }}"
                    class="border shadow rounded w-full px-2 py-1 focus:border-indigo-500 border-solid">
                @error('email')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <input type="text" name="phoneNumber" id="phoneNumber" placeholder="Numéro de téléphone" 
                    value="{{ $member->phoneNumber ?? old('phoneNumber') }}"
                    class="border shadow rounded w-full px-2 py-1 focus:border-indigo-500 border-solid">
                @error('phoneNumber')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-between">
                @if (isset($member))
                    <input type="submit" value="Modifier le membre" class="text-white bg-indigo-500 hover:bg-indigo-400 px-3 py-1 rounded">
                @else
                    <input type="submit" value="+ Ajouter un membre" class="text-white bg-indigo-500 hover:bg-indigo-400 px-3 py-1 rounded">
                    <a href="{{ route('team.groupForm', ['team' => $team]) }}" class="flex gap-2 text-white bg-indigo-500 hover:bg-indigo-400 px-3 py-1 rounded">
                        Suivant <svg width="24px" height="24px" viewBox="0 0 24 24" stroke-width="1.5" fill="none" xmlns="http://www.w3.org/2000/svg" color="#ffffff"><path d="M3 12L21 12M21 12L12.5 3.5M21 12L12.5 20.5" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    </a>
                @endif
            </div>
                
        </form>

        @isset($member)
            <form action="{{ route('team.members.destroy', ['team' => $team, 'member' => $member]) }}" method="POST" 
                class="self-end border border-black rounded">
                @csrf
                @method('DELETE')
    
                <label>
                    <input type="submit" class=" hidden">
                    <svg class="hover:fill-red-500" width="24px" height="24px" viewBox="0 0 24 24" stroke-width="1.5" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 9L18.005 20.3463C17.8369 21.3026 17.0062 22 16.0353 22H7.96474C6.99379 22 6.1631 21.3026 5.99496 20.3463L4 9" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M21 6L15.375 6M3 6L8.625 6M8.625 6V4C8.625 2.89543 9.52043 2 10.625 2H13.375C14.4796 2 15.375 2.89543 15.375 4V6M8.625 6L15.375 6" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                </label>
            </form>
        @endisset
    </div>

    @include('layouts.membersComponent')

@endsection