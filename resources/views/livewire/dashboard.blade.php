<div class="max-w-7xl mx-auto sm:px-6 lg:px-10 space-y-6 mt-8">
    <div class="bg-gray-100 p-6 sm:p-10 rounded-xl shadow-md">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Overzicht</h1>
        </div>

        @if($zelftoets->isEmpty())
            <div class="flex justify-center mt-6">
                <p class="font-semibold text-pink-500 bg-white shadow-md p-6 rounded-xl w-full mx-4 text-center">
                    Nog geen uitdagingen gevonden
                </p>
            </div>
        @else
            <div class="flex justify-end mt-6">
                <button class="flex items-center justify-between px-6 py-3 bg-pink-400 text-white font-semibold rounded-lg shadow hover:bg-pink-500 active:bg-pink-600 transition focus:outline-none" wire:click="toggleVoltooid">
                    <span class="mr-3">
                        @if ($showVoltooid)
                            Toon onvoltooide uitdagingen
                        @else
                            Toon voltooide uitdagingen
                        @endif
                    </span>
                    <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="currentColor" d="M3.9 54.9C10.5 40.9 24.5 32 40 32h432c15.5 0 29.5 8.9 36.1 22.9s4.6 30.5-5.2 42.5L320 320.9V448c0 12.1-6.8 23.2-17.7 28.6s-23.8 4.3-33.5-3l-64-48c-8.1-6-12.8-15.5-12.8-25.6V320.9L9 97.3C-.7 85.4-2.8 68.8 3.9 54.9z" />
                    </svg>
                </button>
            </div>
            <div>
                <table class="bg-white w-full mx-4 mt-6 rounded-md overflow-hidden shadow-md">
                    <thead>
                        <tr class="bg-blue-100 text-blue-600">
                            <th class="p-4 text-left text-sm font-semibold">Hoofdthema</th>
                            <th class="p-4 text-left text-sm font-semibold">Deelthema</th>
                            <th class="p-4 text-left text-sm font-semibold">Niveau</th>
                            <th class="p-4 text-left text-sm font-semibold">Status</th>
                            <th class="p-4 text-left text-sm font-semibold">Feedback</th>
                            <th class="p-4 text-left text-sm font-semibold">Link</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @if($showVoltooid)
                            @foreach($zelftoets as $toets)
                                @if($validatie->where('uitdaging_id', $toets->uitdaging_id)->where('voltooid', true)->isNotEmpty())
                                    <tr class="hover:bg-gray-50">
                                        <td class="p-4 text-gray-700">{{ $toets->hoofdthema->naam ?? 'N/A' }}</td>
                                        <td class="p-4 text-gray-700">{{ $toets->deelthema->naam ?? 'N/A' }}</td>
                                        <td class="p-4 text-gray-700">{{ $toets->uitdaging->niveau ?? 'N/A' }}</td>
                                        <td class="p-4">
                                            @if($validatie->where('uitdaging_id', $toets->uitdaging_id)->where('voltooid', true)->isNotEmpty())
                                                <span class="text-green-500 font-semibold">Voltooid</span>
                                            @elseif($validatie->where('uitdaging_id', $toets->uitdaging_id)->where('validatie_antwoord')->isNotEmpty())
                                                <span class="text-blue-500 font-semibold">Staat open voor review</span>
                                            @else
                                                <span class="text-gray-500">Nog niet voltooid</span>
                                            @endif
                                        </td>
                                        <td class="p-4">
                                            @if($showFeedback && $validatie->where('uitdaging_id', $toets->uitdaging_id)->where('feedback')->isNotEmpty())
                                                <div>{{ $validatie->where('uitdaging_id', $toets->uitdaging_id)->where('feedback')->first()->feedback }}</div>
                                                <button wire:click="toggleFeedback" class="text-blue-600 underline hover:text-blue-700 mt-2">
                                                    Verberg Feedback
                                                </button>
                                            @elseif($validatie->where('uitdaging_id', $toets->uitdaging_id)->where('feedback')->isNotEmpty())
                                                <button wire:click="toggleFeedback" class="text-blue-600 underline hover:text-blue-700">
                                                    Toon feedback
                                                </button>
                                            @else
                                                <span class="text-gray-500">n.n.b.</span>
                                            @endif
                                        </td>
                                        <td class="p-4">
                                            <button wire:click="toDeelthema({{ $toets->deelthema->id }})" class="text-blue-600 underline hover:text-blue-700">
                                                Naar deelthema
                                            </button>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @else
                            @foreach($zelftoets as $toets)
                                @if($validatie->where('uitdaging_id', $toets->uitdaging_id)->where('voltooid', false)->isNotEmpty() || !$validatie->where('uitdaging_id', $toets->uitdaging_id)->where('voltooid', true)->isNotEmpty())
                                    <tr class="hover:bg-gray-50">
                                        <td class="p-4 text-gray-700">{{ $toets->hoofdthema->naam ?? 'N/A' }}</td>
                                        <td class="p-4 text-gray-700">{{ $toets->deelthema->naam ?? 'N/A' }}</td>
                                        <td class="p-4 text-gray-700">{{ $toets->uitdaging->niveau ?? 'N/A' }}</td>
                                        <td class="p-4">
                                            @if($validatie->where('uitdaging_id', $toets->uitdaging_id)->where('validatie_antwoord')->isNotEmpty())
                                                <span class="text-blue-500 font-semibold">Staat open voor review</span>
                                            @else
                                                <span class="text-gray-500">Nog niet voltooid</span>
                                            @endif
                                        </td>
                                        <td class="p-4">
                                            @if($showFeedback && $validatie->where('uitdaging_id', $toets->uitdaging_id)->where('feedback')->isNotEmpty())
                                                <div>{{ $validatie->where('uitdaging_id', $toets->uitdaging_id)->where('feedback')->first()->feedback }}</div>
                                            @elseif($validatie->where('uitdaging_id', $toets->uitdaging_id)->where('feedback')->isNotEmpty())
                                                <button wire:click="toggleFeedback" class="text-blue-600 underline hover:text-blue-800">
                                                    Toon feedback
                                                </button>
                                            @else
                                                <span class="text-gray-500">n.n.b.</span>
                                            @endif
                                        </td>
                                        <td class="p-4">
                                            <button wire:click="toDeelthema({{ $toets->deelthema->id }})" class="text-blue-600 underline hover:text-blue-800">
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