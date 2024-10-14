{{--IMPORTANT, SOME TAILWIND CSS DOESN'T WORK LIKE COLORS AND STUFF--}}
<x-filament-panels::page>
    <div>
        <div class="justify-center flex space-y-6">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                <tr>
                    <th class="px-4 py-2">Gebruiker</th>
                    <th class="px-4 py-2">Hoofdthema</th>
                    <th class="px-4 py-2">Deelthema</th>
                    <th class="px-4 py-2">Niveau</th>
                    <th class="px-4 py-2">Download validatie pdf</th>
                    <th class="px-4 py-2">Verwijder</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($validaties as $validatie)
                    <tr>
                        <td class="border px-4 py-2">{{ $validatie->user->name ?? 'Unknown' }}</td>
                        <td class="border px-4 py-2">{{ $validatie->deelthema->hoofdthema->naam ?? 'Unknown' }}</td>
                        <td class="border px-4 py-2">{{ $validatie->deelthema->naam ?? 'Unknown' }}</td>
                        <td class="border px-4 py-2">{{ $validatie->uitdaging->niveau ?? 'Unknown' }}</td>
                        <td class="border px-4 py-2">
                            <!-- Trigger the downloadPDF action defined in ValidatiePage -->
                            <button wire:click="downloadPDF({{ $validatie->id }})" style="color: blue;" class="underline">Download PDF
                            </button>
                        </td>
                        <td class="border px-4 py-2">
                            <button wire:click="confirmDelete({{ $validatie->id }})" style="color: red;" class="underline">Verwijder
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if ($confirmingDeletion)
            <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 40;">
                <div style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; display: flex; align-items: center; justify-content: center; z-index: 50;">
                    <div style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                        <h2 style="font-size: 1.25rem; font-weight: bold;">Bevestig verwijdering</h2>
                        <p>Weet je zeker dat je deze validatie wilt verwijderen?</p>
                        <div style="margin-top: 16px; display: flex; justify-content: flex-end;">
                            <button wire:click="cancelDelete" style="background-color: gray; color: white; padding: 8px 16px; border-radius: 4px; margin-right: 8px; border: none; cursor: pointer;">
                                Annuleren
                            </button>
                            <button wire:click="deleteValidatie({{ $deletingValidatieId }})" style="background-color: red; color: white; padding: 8px 16px; border-radius: 4px; border: none; cursor: pointer;">
                                Verwijder
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
</x-filament-panels::page>
