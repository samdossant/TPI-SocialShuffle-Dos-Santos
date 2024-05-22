@extends('layouts.app')

@section('title', 'Équipes')

@section('content')

    <h2 class="text-2xl font-semibold">Vos équipes</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4 ">

        @forelse ($teams as $team)
            <div class=" flex bg-blue-200 rounded-lg shadow-md ">
                <div class=" bg-blue-200 rounded-lg">
                    <div class=" row-span-2 flex-1 p-4">
                        <h3 class="font-semibold text-lg">{{ $team->name }}</h3>
                        <p class="text-sm text-gray-600">Members count : <span class="font-bold">{{ $team->members_count }}</span></p>
                        <p class="text-sm text-gray-600">Location:</p>
                    </div>

                    <div class=" flex justify-between p-2">
                        <a href="" class=" ">
                            <svg width="24px" height="24px" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="#000000"><path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M19.6224 10.3954L18.5247 7.7448L20 6L18 4L16.2647 5.48295L13.5578 4.36974L12.9353 2H10.981L10.3491 4.40113L7.70441 5.51596L6 4L4 6L5.45337 7.78885L4.3725 10.4463L2 11V13L4.40111 13.6555L5.51575 16.2997L4 18L6 20L7.79116 18.5403L10.397 19.6123L11 22H13L13.6045 19.6132L16.2551 18.5155C16.6969 18.8313 18 20 18 20L20 18L18.5159 16.2494L19.6139 13.598L21.9999 12.9772L22 11L19.6224 10.3954Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </a>
                        <a href="{{ route('team.show', $team->id) }}" class=" ">
                            <svg width="24px" height="24px" viewBox="0 0 24 24" stroke-width="1.5" fill="none" xmlns="http://www.w3.org/2000/svg" color="#000000"><path d="M3 12L21 12M21 12L12.5 3.5M21 12L12.5 20.5" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            Aucune équipe n'a encore été créée
        @endforelse

        {{-- One card --}}
        
    </div>
@endsection