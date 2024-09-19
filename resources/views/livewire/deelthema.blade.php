<div class="max-w-7xl mx-auto sm:px-6 lg:px-10 space-y-6 mt-8">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div>
            <h1 class="text-3xl">{{ $deelthema->naam }}</h1>
            <button wire:click="backToHoofdthema({{ $deelthema->hoofdthema_id }})" class="mt-4 text-blue-500 underline">
                Terug naar Hoofdthema's
            </button>
            <div class="flex justify-center my-2">
                <video width="600" controls>
                    <source src="{{ asset('storage/' . $deelthema->media) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <p class="text-gray-800">{{ $deelthema->beschrijving }}</p>
        </div>
    </div>
</div>
