<div class="max-w-7xl mx-auto sm:px-6 lg:px-10 space-y-6 mt-8">
    <div class="p-4 sm:p-8 sm:rounded-lg">
        <div>
            <h1 class="">Dashboard</h1>
        </div>


        @if($zelftoets->isEmpty())
            <div class="flex justify-center">
                <p class="font-bold text-pink-400 p-4 bg-white rounded-2xl w-full mx-4 text-center">Nog geen uitdagingen
                    gevonden</p>
            </div>
        @else
            <div class="flex justify-center">
                <button wire:click="toggleVoltooid"
                        class="my-4 px-3 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    @if ($showVoltooid)
                        Verberg voltooide uitdagingen
                    @else
                        Toon voltooide uitdagingen
                    @endif
                </button>
            </div>

            <div>
                <table class="bg-white w-full mx-4">
                    <thead>
                    <tr>
                        <th class="p-4 border border-black text-pink-400 text-xl rounded-tl-2xl">Hoofdthema</th>
                        <th class="p-4 border border-black text-pink-400 text-xl">Deelthema</th>
                        <th class="p-4 border border-black text-pink-400 text-xl">Niveau</th>
                        <th class="p-4 border border-black text-pink-400 text-xl">Status</th>
                        <th class="p-4 border border-black text-pink-400 text-xl rounded-tl-2xr">Link</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($showVoltooid)
                        @foreach($zelftoets as $toets)
                            <tr>

                                <td class="p-4 border border-black text-center">{{ $toets->hoofdthema->naam ?? 'N/A' }}</td>
                                <td class="p-4 border border-black text-center">{{ $toets->deelthema->naam ?? 'N/A' }}</td>
                                <td class="p-4 border border-black text-center">{{ $toets->uitdaging->niveau ?? 'N/A' }}</td>
                                <td class="p-4 border border-black text-center">
                                    @if($validatie->where('uitdaging_id', $toets->uitdaging_id)->where('voltooid', true)->isNotEmpty())
                                        <div class="text-green-500">Voltooid</div>
                                    @elseif($validatie->where('uitdaging_id', $toets->uitdaging_id)->where('validatie_antwoord')->isNotEmpty())
                                        <div class="text-blue-500">Staat open voor review</div>
                                    @else
                                        <div class="">Nog niet voltooid</div>
                                    @endif
                                </td>
                                <td class="p-4 border border-black text-center">
                                    <button wire:click="toDeelthema({{ $toets->deelthema->id }})"
                                            class="text-blue-600 underline cursor-pointer hover:text-blue-800">
                                        Naar deelthema
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        @foreach($zelftoets as $toets)
                            @if(!$validatie->where('uitdaging_id', $toets->uitdaging_id)->where('voltooid', true)->isNotEmpty())
                                <tr>
                                    <td class="p-4 border border-black text-center">{{ $toets->hoofdthema->naam ?? 'N/A' }}</td>
                                    <td class="p-4 border border-black text-center">{{ $toets->deelthema->naam ?? 'N/A' }}</td>
                                    <td class="p-4 border border-black text-center">{{ $toets->uitdaging->niveau ?? 'N/A' }}</td>
                                    <td class="p-4 border border-black text-center">
                                        @if($validatie->where('uitdaging_id', $toets->uitdaging_id)->where('validatie_antwoord')->isNotEmpty())
                                            <div class="text-blue-500">Staat open voor review</div>
                                        @else
                                            <div class="">Nog niet voltooid</div>
                                        @endif
                                    </td>
                                    <td class="p-4 border border-black text-center">
                                        <button wire:click="toDeelthema({{ $toets->deelthema->id }})"
                                                class="text-blue-600 underline cursor-pointer hover:text-blue-800">
                                            Naar deelthema
                                        </button>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        @endif

    </div>
</div>
