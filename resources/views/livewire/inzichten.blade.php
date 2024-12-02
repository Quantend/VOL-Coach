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
                <select
                    class="px-6 py-3 bg-white border border-gray-300 rounded-lg shadow text-gray-700 font-semibold focus:ring-2 focus:ring-blue-500"
                    wire:model="filterStatus" wire:change="getFilteredData">
                    <option value="all">Toon alle uitdagingen</option>
                    <option value="completed">Toon voltooide uitdagingen</option>
                    <option value="incomplete">Toon onvoltooide uitdagingen</option>
                </select>
            </div>
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
                    <tbody>
                    @foreach($filteredZelftoets as $toets)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4">{{ $toets->hoofdthema->naam ?? 'N/A' }}</td>
                            <td class="p-4">{{ $toets->deelthema->naam ?? 'N/A' }}</td>
                            <td class="p-4">{{ $toets->uitdaging->niveau ?? 'N/A' }}</td>
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
                                <button wire:click="toDeelthema({{ $toets->deelthema->id }})" class="text-blue-600 underline">
                                    Naar deelthema
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
    </div>
</div>
