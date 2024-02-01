<x-filament-panels::page>
    <div class="grid grid-cols-1 gap-16">
        @foreach ($requests as $index => $request)
            @livewire('api-request', ['request' => $request], key($index))
        @endforeach
    </div>
</x-filament-panels::page>
