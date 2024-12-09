<div class="max-w-7xl mx-auto sm:px-6 lg:px-10 space-y-6 mt-8">
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-xl">
        <div class="m mx-auto">
            @if(!empty($home->content))
                {!! $home->content !!}
            @else
                <p>Je kunt een homepagina aanmaken in de url als je naar /admin gaat.</p>
            @endif
            @if(!empty($videoId))
                <div class="flex justify-center my-10">
                    <iframe height="400" width="100%" class="rounded-lg shadow-md"
                            src="https://www.youtube.com/embed/{{ $videoId }}"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                </div>
            @endif
        </div>
    </div>
</div>
@if(session('message'))
    <div class="bg-green-600 text-white p-4 rounded mt-4">
        {{ session('message') }}
    </div>
@endif
