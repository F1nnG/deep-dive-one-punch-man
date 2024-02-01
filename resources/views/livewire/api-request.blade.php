<div>
    <h1 class="text-3xl text-black dark:text-white font-bold">{{ $request['title'] }}</h1>
    <p class="text-gray-200 text-base mb-6 mt-2">{{ $request['description'] }}</p>

    <div class="rounded-lg relative bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 flex items-center">
        <h3 class="{{ $request['type'] == 'GET' ? 'text-green-500' : 'text-orange-400' }} font-semibold px-4 py-2 border-r border-gray-950/5 dark:border-white/10 w-fit">{{ $request['type']  }}</h3>
        <p class="flex-grow px-4 text-base text-gray-200 font-normal">{{ $route }}</p>
        <button wire:click="testRequest" class="h-full py-2 px-8 hover:brightness-110 {{ $request['type'] == 'GET' ? 'bg-green-600' : 'bg-orange-500' }} font-semibold rounded-r-lg ring-1 ring-gray-950/5 dark:ring-white/10">Test</button>
    </div>

    <div class="divide-y mt-8 divide-gray-200 overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:divide-white/10 dark:bg-gray-900 dark:ring-white/10">
        @if (count($request['params']))
            <h2 class="px-4 py-3 text-xl font-bold">Params</h2>
            @foreach($request['params'] as $paramId => $param)
                <div class="grid grid-cols-12 text-center">
                    <p class="col-span-2 py-3">{{ $param['slug']  }}</p>
                    <label>
                        <input type="text" class="col-span-3 bg-transparent ring-0 border-0 focus:ring-0 focus:outline-none border-x border-gray-950/5 dark:border-white/10 py-3" wire:model.live="request.params.{{ $paramId  }}.default">
                    </label>
                    <p class="col-span-7 py-3">{{ $param['description']  }}</p>
                </div>
            @endforeach
        @endif
        <h2 class="px-4 py-3 text-xl font-bold">Response</h2>
        <div class="px-4 py-3">
            @if ($response)
                @dump($response)
            @else
                <p class="text-gray-400">No response yet.</p>
            @endif
        </div>
    </div>
</div>
