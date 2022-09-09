<x-layout>
    @include('partials._hero')
    @include('partials._search')

    <div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">

        @unless(count($listings) == 0) {{-- Laravel allow us to use @unless instead of @if --}}
            @foreach($listings as $job)
                <x-listing-card :job="$job"></x-listing-card>
            @endforeach
        @else
            <p>No job Listing found</p>
        @endunless
    </div>
    <div class="mt-6 p-4">
        {{$listings->links()}} {{-- link() allow us to generate pagination page --}}
    </div>
</x-layout>
