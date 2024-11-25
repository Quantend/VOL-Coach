{{--IMPORTANT, SOME TAILWIND CSS DOESN'T WORK LIKE COLORS AND STUFF (no time to fix ¯\_(ツ)_/¯ )--}}
<x-filament-panels::page>
    <div>
        <div class="flex justify-center mb-4">

            <button wire:click="toggleVoltooid" class="flex justify-center"
                    style="background-color: blue; color: white; padding: 8px 16px; border-radius: 4px; margin-right: 8px; border: none; cursor: pointer;">
                @if ($showVoltooid)
                    Toon onvoltooide uitdagingen
                @else
                    Toon voltooide uitdagingen
                @endif
            </button>

        </div>
        <div class="justify-center flex space-y-6">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>

                <tr>
                    @if($showVoltooid)
                        <th class="px-4 py-2">Gebruiker</th>
                        <th class="px-4 py-2">Hoofdthema</th>
                        <th class="px-4 py-2">Deelthema</th>
                        <th class="px-4 py-2">Niveau</th>
                        <th class="px-4 py-2">Voltooid</th>
                        <th class="px-4 py-2">Download validatie</th>
                        <th class="px-4 py-2">Feedback</th>
                    @else
                        <th class="px-4 py-2">Gebruiker</th>
                        <th class="px-4 py-2">Hoofdthema</th>
                        <th class="px-4 py-2">Deelthema</th>
                        <th class="px-4 py-2">Niveau</th>
                        <th class="px-4 py-2">Voltooid</th>
                        <th class="px-4 py-2">Download validatie</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach ($validaties as $validatie)
                    @if($showVoltooid && $validatie->voltooid === 1)
                        <tr>
                            <td class="border px-4 py-2">{{ $validatie->user->name ?? 'Unknown' }}</td>
                            <td class="border px-4 py-2">{{ $validatie->deelthema->hoofdthema->naam ?? 'Unknown' }}</td>
                            <td class="border px-4 py-2">{{ $validatie->deelthema->naam ?? 'Unknown' }}</td>
                            <td class="border px-4 py-2">{{ $validatie->uitdaging->niveau ?? 'Unknown' }}</td>
                            <td class="border px-4 py-2">Voltooid</td>
                            <td class="border px-4 py-2">
                                @if($validatie->validatie_antwoord !== null)
                                    <button wire:click="downloadPDF({{ $validatie->id }})" style="color: blue;"
                                            class="underline">Download PDF
                                    </button>
                                @else
                                    Geen validatie beschikbaar
                                @endif
                            </td>
                            <td class="border px-4 py-2">{{ $validatie->feedback }}</td>
                        </tr>
                    @elseif(!$showVoltooid && $validatie->voltooid === 0 )
                        <tr>
                            <td class="border px-4 py-2">{{ $validatie->user->name ?? 'Unknown' }}</td>
                            <td class="border px-4 py-2">{{ $validatie->deelthema->hoofdthema->naam ?? 'Unknown' }}</td>
                            <td class="border px-4 py-2">{{ $validatie->deelthema->naam ?? 'Unknown' }}</td>
                            <td class="border px-4 py-2">{{ $validatie->uitdaging->niveau ?? 'Unknown' }}</td>
                            <td class="border px-4 py-2">Nog niet Voltooid</td>
                            <td class="border px-4 py-2">
                                @if($validatie->validatie_antwoord !== null)
                                    <button wire:click="downloadPDF({{ $validatie->id }})" style="color: blue;"
                                            class="underline">Download PDF
                                    </button>
                                @else
                                    Geen validatie beschikbaar
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-filament-panels::page>
