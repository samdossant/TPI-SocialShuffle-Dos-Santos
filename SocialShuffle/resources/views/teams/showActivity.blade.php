@extends('layouts.app')
@section('title', 'Activité')
@section('content')

    <a href="{{ route('team.show', ['team' => $team]) }}" class="text-red-500 underline"><-Retour</a>

    <div class="mt-5">
        {{ $qrCode }}
    </div>


    @if(isset($groups))

        @php
            $currentGeneration = null; 
        @endphp

        @foreach ($groups as $group)
            @if ($currentGeneration !== $group->generation)
                @php
                    $groupCounter = 0;
                @endphp
                @if ($currentGeneration !== null)
                    </div> {{-- Close previous div --}}
                @endif
                <div class="mb-4">
                    <h2 class="text-xl font-bold my-4">Activité {{ $group->generation + 1 }}</h2></class=>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @endif
            @php
                $currentGeneration = $group->generation;
            @endphp
            <div class="flex justify-between bg-blue-200 p-3 rounded-xl">
                <div>
                    @php
                        $memberCounter = 0;
                    @endphp
                    <p class="font-semibold">{{ ++$groupCounter }}</p>
                    @foreach ($group->members as $member)
                        <p class="ml-4"><span class="font-bold">-</span> <span class="font-semibold">{{ $member->lastname }}</span> {{ $member->firstname }}</p>
                    @endforeach
                </div>
                @can('delete', $team)                    
                    <div>
                        <form action="{{ route('group.destroy', ['group' => $group]) }}" method="POST" 
                            class="self-end border border-black rounded">
                            @csrf
                            @method('DELETE')
                
                            <label>
                                <input type="submit" class=" hidden">
                                <svg class="hover:fill-red-500" width="24px" height="24px" viewBox="0 0 24 24" stroke-width="1.5" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 9L18.005 20.3463C17.8369 21.3026 17.0062 22 16.0353 22H7.96474C6.99379 22 6.1631 21.3026 5.99496 20.3463L4 9" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M21 6L15.375 6M3 6L8.625 6M8.625 6V4C8.625 2.89543 9.52043 2 10.625 2H13.375C14.4796 2 15.375 2.89543 15.375 4V6M8.625 6L15.375 6" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                            </label>
                        </form>
                    </div>
                @endcan
            </div>
        @endforeach
        @if ($currentGeneration !== null)
            </div>  {{-- Close last div --}} 
        @endif
    @endif
@endsection