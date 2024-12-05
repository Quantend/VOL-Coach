<div class="max-w-7xl mx-auto sm:px-6 lg:px-10 space-y-6 mt-8">
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-xl">
        <div class="m mx-auto">
            @if(!empty($home->content))
            {!! $home->content !!}
            @else
                <p>Je kunt een homepagina aanmaken in de url als je naar /admin gaat.</p>
            @endif
        </div>
    </div>
</div>
@if(session('message'))
<div class="bg-green-600 text-white p-4 rounded mt-4">
    {{ session('message') }}
</div>
@endif