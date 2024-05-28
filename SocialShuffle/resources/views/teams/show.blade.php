@extends('layouts.app')

@section('title', 'Détails')

@section('content')
    <h2 class="text-4xl font-semibold mb-5">Détails de l'équipe</h2>

    <div class="flex flex-wrap gap-5 items-center mb-10">
        <p class="text-2xl font-semibold">{{ $team->name }}</p>
        @if(Auth::user()->id == $team->user_id || Auth::user()->admin)
            <a href="{{ route('team.edit', ['team' => $team]) }}" class="border border-black rounded">
                <svg class="hover:fill-indigo-500" width="24px" height="24px" viewBox="0 0 24 24" stroke-width="1.5" fill="none" xmlns="http://www.w3.org/2000/svg" color="#000000"><path d="M14.3632 5.65156L15.8431 4.17157C16.6242 3.39052 17.8905 3.39052 18.6716 4.17157L20.0858 5.58579C20.8668 6.36683 20.8668 7.63316 20.0858 8.41421L18.6058 9.8942M14.3632 5.65156L4.74749 15.2672C4.41542 15.5993 4.21079 16.0376 4.16947 16.5054L3.92738 19.2459C3.87261 19.8659 4.39148 20.3848 5.0115 20.33L7.75191 20.0879C8.21972 20.0466 8.65806 19.8419 8.99013 19.5099L18.6058 9.8942M14.3632 5.65156L18.6058 9.8942" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
            </a>

            <form action="{{ route('team.destroy', ['team' => $team]) }}" method="POST" class="border border-black rounded">
                @csrf
                @method('DELETE')
                <label>
                    <input type="submit" class=" hidden">
                    <svg class="hover:fill-red-500" width="24px" height="24px" viewBox="0 0 24 24" stroke-width="1.5" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 9L18.005 20.3463C17.8369 21.3026 17.0062 22 16.0353 22H7.96474C6.99379 22 6.1631 21.3026 5.99496 20.3463L4 9" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M21 6L15.375 6M3 6L8.625 6M8.625 6V4C8.625 2.89543 9.52043 2 10.625 2H13.375C14.4796 2 15.375 2.89543 15.375 4V6M8.625 6L15.375 6" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                </label>
            </form>
        @endif
    </div>

    @if(isset($groups))
        @php
            $generation = -1            
        @endphp

        @foreach ($groups as $group)
            @if ($generation != $group->generation)
                {{ $group->generation }}
            @endif
            @php
                $generation = $group->generation;
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 bg-blue-200 mb-4">

                {{-- <p>{{ dd($group->members) }}</p> --}}
                {{-- <div class="flex justify-start">{{ $group->generation }}</div>    --}}

                <div >
                    <p>{{ $generation + 1}}</p>
                    @foreach ($group->members as $member)
                            <p>{{ $member->firstname }} {{ $member->lastname }}</p>                        
                    @endforeach

                </div>

                
            </div>
        @endforeach
    
    @endif    
        
    @if(Auth::user()->id == $team->user_id || Auth::user()->admin)
        <a href="{{ route('team.members.create', ['team' => $team, 'members' => $members]) }}" class="text-white bg-indigo-500 px-3 py-1 rounded hover:bg-indigo-400">Ajouter des membres</a>
    @endif

    @include('layouts.membersComponent')

    <p class="text-lg mb-3"><span class="font-bold">5</span> personnes par groupe</p>

@endsection
