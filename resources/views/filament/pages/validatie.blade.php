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
                        <th class="px-4 py-2">Reset validatie</th>
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
                            <td class="border px-4 py-2">
                                <button wire:click="confirmVoltooiUitdaging({{ $validatie->id }})"
                                        style="color: blue;"
                                        class="underline">Voltooi uitdaging
                                </button>
                            </td>
                            <td class="border px-4 py-2">
                                @if($validatie->validatie_antwoord !== null)
                                    <button wire:click="downloadPDF({{ $validatie->id }})" style="color: blue;"
                                            class="underline">Download PDF
                                    </button>
                                @else
                                    Geen validatie beschikbaar
                                @endif
                            </td>
                            <td class="border px-4 py-2">
                                <button wire:click="confirmDelete({{ $validatie->id }})" style="color: red;"
                                        class="underline">Reset validatie
                                </button>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
        @if ($confirmingDeletion)
            <div
                style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 40;">
                <div
                    style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; display: flex; align-items: center; justify-content: center; z-index: 50;">
                    <div
                        style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                        <h2 style="font-size: 1.25rem; font-weight: bold;">Bevestig verwijdering</h2>
                        <p>Weet je zeker dat je deze validatie wilt verwijderen?</p>
                        <div style="margin-top: 16px; display: flex; justify-content: flex-end;">
                            <button wire:click="cancelDelete"
                                    style="background-color: gray; color: white; padding: 8px 16px; border-radius: 4px; margin-right: 8px; border: none; cursor: pointer;">
                                Annuleren
                            </button>
                            <button wire:click="deleteValidatie({{ $deletingValidatieId }})"
                                    style="background-color: red; color: white; padding: 8px 16px; border-radius: 4px; border: none; cursor: pointer;">
                                Verwijder
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if($confirmingVoltooiUitdaging)
            <div
                style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 40;">
                <div
                    style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; display: flex; align-items: center; justify-content: center; z-index: 50;">
                    <div
                        style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                        <h2 style="font-size: 1.25rem; font-weight: bold;">Voltooi uitdaging</h2>
                        <p>Weet je zeker dat je deze uitdaging als voltooid wilt zetten?</p>
                        <div style="margin-top: 16px; display: flex; justify-content: flex-end;">
                            <button wire:click="cancelVoltooiUitdaging"
                                    style="background-color: gray; color: white; padding: 8px 16px; border-radius: 4px; margin-right: 8px; border: none; cursor: pointer;">
                                Annuleren
                            </button>
                            <button wire:click="voltooiUitdaging({{ $validatie->id }})"
                                    style="background-color: blue; color: white; padding: 8px 16px; border-radius: 4px; border: none; cursor: pointer;">
                                Ja, Voltooi uitdaging
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if($givingFeedback)
            <div
                style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 40;">
                <div
                    style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; display: flex; align-items: center; justify-content: center; z-index: 50;">
                    <div
                        style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                        <h2 style="font-size: 1.25rem; font-weight: bold;">Geef Feedback</h2>
                        <textarea wire:model="feedbackText"
                                  style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                                  placeholder="Voer uw feedback in..."></textarea>
                        <div style="margin-top: 16px; display: flex; justify-content: flex-end;">
                            <button wire:click="cancelFeedback"
                                    style="background-color: gray; color: white; padding: 8px 16px; border-radius: 4px; margin-right: 8px; border: none; cursor: pointer;">
                                Annuleren
                            </button>
                            <button wire:click="submitFeedback"
                                    style="background-color: blue; color: white; padding: 8px 16px; border-radius: 4px; border: none; cursor: pointer;">
                                Feedback Opslaan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
</x-filament-panels::page>
