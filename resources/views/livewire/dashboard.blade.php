<div>
    <div class="mt-10">
        <h1 class="flex justify-center">In desperate need of styling</h1>
    </div>

    <div class="flex justify-center mt-20">
        @if($zelftoets->isEmpty())
            <p>No records found.</p>
        @else

            <table class="">
                <thead>
                <tr>
                    <th>Hoofdthema</th>
                    <th>Deelthema</th>
                    <th>Niveau</th>
                    <th>Button so cool</th>
                </tr>
                </thead>
                <tbody>
                @foreach($zelftoets as $toets)
                    <tr>
                        <td>{{ $toets->hoofdthema->naam ?? 'N/A' }}</td>
                        <td>{{ $toets->deelthema->naam ?? 'N/A' }}</td>
                        <td>{{ $toets->uitdaging->niveau ?? 'N/A' }}</td>
                        <td><button wire:click="toDeelthema({{ $toets->deelthema->id }})">
                                Button naar deelthema
                            </button></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
