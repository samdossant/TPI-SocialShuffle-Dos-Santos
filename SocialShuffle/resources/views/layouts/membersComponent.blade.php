@if (isset($members))  
    <p class="text-lg mb-3"><span class="font-bold">{{ $members->count() }}</span> {{ Str::plural('membre', $members->count()) }}</p>

    <div class="overflow-y-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-4 mb-5 h-96 shadow border rounded-lg">

        @forelse ($members as $existingMember)
            {{-- card --}}
            <div class=" flex h-36 bg-blue-200 rounded-lg shadow-md ">
                <div class=" bg-blue-200 rounded-lg">
                    <div class=" row-span-2 flex-1 p-4">
                        <h3 class="font-semibold text-lg">{{ $existingMember->firstname }} {{ $existingMember->lastname }}</h3>
                        <p class="text-gray-600">{{ $existingMember->email }} </p>
                        <p class="text-gray-600">{{ $existingMember->phoneNumber }}</p>
                    </div>

                    @can('update', $team)
                        <div class=" flex justify-start gap-10 mb-4">
                            
                            <a href="{{ route('team.members.edit', ['team' => $team, 'member' => $existingMember]) }}" class="ml-4">
                                <svg width="24px" height="24px" viewBox="0 0 24 24" stroke-width="1.5" fill="none" xmlns="http://www.w3.org/2000/svg" color="#000000"><path d="M17 17L21 21" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M3 11C3 15.4183 6.58172 19 11 19C13.213 19 15.2161 18.1015 16.6644 16.6493C18.1077 15.2022 19 13.2053 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>                        </a>
                        </div>                        
                    @endcan
                </div>
            </div>
        @empty
            Cette équipe n'a pas encore de membres !
        @endforelse

    </div>
@else
    <div class="overflow-y-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-4 mt-5 mb-5 h-96 shadow border rounded-lg">
        Cette équipe n'a pas encore de membres !
    </div>
@endif
