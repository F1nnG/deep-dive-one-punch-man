<x-filament-panels::page>
    @if ($this->hasInfolist())
        {{ $this->infolist }}
    @else
        {{ $this->form }}
    @endif

    @if (count($relationManagers = $this->getRelationManagers()))
        <x-filament-panels::resources.relation-managers :active-manager="$this->activeRelationManager" :managers="$relationManagers" :owner-record="$record" :page-class="static::class" />
    @endif

    @php(/** @var \App\Models\Battle $record */$record)
    @foreach ($record->logs as $roundNumber => $round)
        @php
            $newHeroHp = round($round['hero_health']);
            $newHeroHp = $newHeroHp < 0 ? 0 : $newHeroHp;

            $newMonsterHp = round($round['monster_health']);
            $newMonsterHp = $newMonsterHp < 0 ? 0 : $newMonsterHp;
        @endphp
        <div class="mx-auto w-full max-w-[50rem] divide-y divide-gray-200 overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:divide-white/10 dark:bg-gray-900 dark:ring-white/10">
            <div class="p-4">
                <h1 class="text-xl font-bold text-black dark:text-white">Round&nbsp;{{ $roundNumber }}</h1>
            </div>
            <div class="grid grid-cols-3 p-4">
                <div class="flex flex-col items-center gap-6">
                    <div class="flex items-center gap-2">
                        <h2 class="text-lg font-bold">{{ $record->hero->alias }}</h2>
                        @if ($newMonsterHp <= 0)
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 text-yellow-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0" />
                            </svg>
                        @endif
                    </div>
                    <div class="flex flex-col items-center gap-2">
                        <h4 class="text-lg font-semibold text-gray-400">{{ round($record->logs[$roundNumber - 1]['hero_health'] ?? 100) }}&nbsp;HP</h4>
                        <p class="text-sm text-red-500">-&nbsp;{{ round($round['monster_damage']) }}&nbsp;HP</p>
                        <h4 class="text-lg font-semibold">{{ $newHeroHp }}&nbsp;HP</h4>
                    </div>
                </div>
                <div class="flex flex-col items-center justify-center gap-6">
                    <div class="flex w-full justify-start">
                        <div class="flex w-fit items-center gap-2 rounded-md border bg-white/10 px-2 py-1 text-blue-500 dark:border-white/5">
                            <p class="max-w-[15rem] truncate text-sm">{{ $round['hero_power'] }}</p>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex w-full justify-end">
                        <div class="flex w-fit items-center gap-2 rounded-md border bg-white/10 px-2 py-1 text-blue-500 dark:border-white/5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
                            </svg>
                            <p class="text-sm">{{ $round['monster_power'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col items-center gap-6">
                    <div class="flex items-center gap-2">
                        <h2 class="text-lg font-bold">{{ $record->monster->alias }}</h2>
                        @if ($newHeroHp <= 0)
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 text-yellow-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0" />
                            </svg>
                        @endif
                    </div>
                    <div class="flex flex-col items-center gap-2">
                        <h4 class="text-lg font-semibold text-gray-400">{{ round($record->logs[$roundNumber - 1]['monster_health'] ?? 100) }}&nbsp;HP</h4>
                        <p class="text-sm text-red-500">-&nbsp;{{ round($round['hero_damage']) }}&nbsp;HP</p>
                        <h4 class="text-lg font-semibold">{{ $newMonsterHp }}&nbsp;HP</h4>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</x-filament-panels::page>
