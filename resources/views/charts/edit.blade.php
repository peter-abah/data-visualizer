<x-app-layout>
    <div class="mx-auto max-w-2xl">
        <h1 class="mb-6 text-2xl font-bold">Chart Settings</h1>
        <div class="mb-8">
            <h2 class="border-b border-gray-400 pb-4 text-xl font-bold">General</h2>
            <form x-data="{
                columnsNo: 0,
                removedColumns: {},
                chartColumns: JSON.parse('{{ json_encode($chart->config['dataColumns']) }}'),
                showScaleTypeInput: {{ json_encode($chart->type->isCartesian()) }}
            }"
                method="POST"
                action="{{ route('charts.update', ['chart' => $chart]) }}">
                @csrf
                @method('PUT')
                <div class="mt-4">
                    <x-input-label for="name" :value="__('Name*')" />
                    <x-text-input id="name" class="mt-1 block w-full" type="text"
                        name="name"
                        :value="old('name') ?? $chart->name" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mt-4"
                    x-data="{ showFormatInput: {{ json_encode(($chart->config['scaleType'] ?? '') === 'time') }} }">
                    <x-input-label for="categoryColumn" :value="__('Category Column*')" />

                    <select name="categoryColumn" id="categoryColumn" required>
                        <option value="">{{ __('--Select an option--') }}
                        </option>
                        @foreach ($chart->project->columns as $column)
                            <option value="{{ $column }}"
                                @selected($column === (old('categoryColumn') ? old('categoryColumn') : $chart->config['categoryColumn']))>
                                {{ $column }}</option>
                        @endforeach
                    </select>

                    <div class="ml-4 inline-flex flex-col"
                        x-cloak
                        x-show="showScaleTypeInput">
                        <div class="inline-flex items-center">
                            <x-input-label for="scaleType" :value="__('scale type')" class="mr-2 text-sm" />
                            <select name="scaleType" id="scaleType" required class="text-sm"
                                x-on:change="showFormatInput = $event.target.value === '{{ \App\Enums\ScaleType::Time->value }}'">
                                @foreach (\App\Enums\ScaleType::cases() as $option)
                                    <option value="{{ $option->value }}"
                                        @selected($option->value === (old('scaleType') ? old('scaleType') : $chart->config['scaleType'] ?? ''))>
                                        {{ ucfirst($option->value) }}</option>
                                @endforeach
                            </select>
                            {{--
                                TODO: Show info on how to input date formats. Strings in ISO dates do not need a custom format
                            --}}
                        </div>

                        <div class="mt-2 inline-flex items-center"
                            x-cloak
                            x-show="showFormatInput">
                            <x-input-label for="dateFormat" :value="__('date format')"
                                class="mr-2 text-sm" />
                            <x-text-input type="text" name="dateFormat" id="dateFormat"
                                class="text-sm" :value="old('dateFormat') ??
                                    ($chart->config['dateFormat'] ?? '')" />
                        </div>
                    </div>

                    <x-input-error :messages="$errors->get('categoryColumn')" />
                </div>

                <div x-data="{ isVisible: true }" class="mt-6">
                    <div class="flex">
                        <p class="font-bold">Data Columns</p>
                        <button type="button" @click="isVisible = !isVisible" class="px-2">
                            <span x-text="isVisible ? 'condense' : 'expand'" class="sr-only"></span>
                            <x-icons.expand-more class="rotate-180"
                                x-bind:class="{ 'rotate-0': !isVisible }" />
                        </button>
                    </div>

                    <x-input-error :messages="$errors->get('dataColumns')" />


                    <div x-bind:class="{ 'hidden': !isVisible }">
                        <ul>
                            @foreach ($chart->config['dataColumns'] as $column)
                                <li class="mt-4 flex items-center"
                                    x-show="!removedColumns['{{ $column }}']">
                                    <p class="mr-4 w-fit border border-gray-500 px-3 py-2">
                                        {{ $column }}</p>
                                    <x-primary-button type="button" class="!p-2"
                                        x-on:click="removedColumns['{{ $column }}'] = !removedColumns['{{ $column }}']">
                                        {{ __('remove') }}
                                    </x-primary-button>
                                </li>
                            @endforeach
                        </ul>

                        {{-- Send removed columns to backend --}}
                        <template x-for="column in Object.keys(removedColumns)">
                            <input type="hidden" name="removedColumns[]"
                                x-bind:value="column">
                        </template>

                        <ul>

                            <template x-for="i in columnsNo">
                                <li class="mt-4">
                                    <x-input-label x-bind:for="`dataColumns.*.${i + 1}`"
                                        x-text="`Data Column ${i + 1} (Ensure it is numeric)*`" />
                                    <select x-bind:id="`dataColumns.${i + 1}}`" name="dataColumns[]"
                                        required>
                                        <option value="">{{ __('--Select an option--') }}
                                        </option>
                                        @foreach ($chart->project->columns as $column)
                                            <option value="{{ $column }}">
                                                {{ $column }}
                                            </option>
                                        @endforeach
                                    </select>
                                </li>
                            </template>
                        </ul>


                        <div class="mt-4 flex gap-4">
                            <x-primary-button type="button" @click="columnsNo++"
                                x-show="(columnsNo + chartColumns.length - Object.keys(removedColumns).length) < 3 ">
                                {{ __('Add data column') }}</x-primary-button>
                            <x-primary-button type="button" @click="columnsNo--" x-cloak
                                x-show="(columnsNo) > 0 ">
                                {{ __('Remove data column') }}</x-primary-button>
                            <x-primary-button type="button"
                                x-on:click="removedColumns={};columnsNo=0" x-cloak
                                x-show="columnsNo > 1 || Object.keys(removedColumns).length > 0">
                                {{ __('Reset') }}</x-primary-button>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <x-input-label for="aggregationOption"
                        :value="__('Aggregation option')" />

                    <select name="aggregationOption"
                        id="aggregationOption"
                        required>
                        @foreach (\App\Enums\AggregationOption::cases() as $option)
                            <option value="{{ $option }}"
                                @selected($option->value === (old('aggregationOption') ? old('aggregationOption') : $chart->config['aggregationOption']))>
                                {{ ucwords($option->value) }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('aggregationOption')" />
                </div>

                <x-primary-button class="mt-4">{{ __('Save') }}</x-primary-button>
            </form>
        </div>


        <div>
            <h2 class="border-b border-gray-400 pb-4 text-xl font-bold">Others</h2>
            @if (($chart->config['scaleType'] ?? null) === \App\Enums\ScaleType::Time->value)
                <div class="mt-4 flex items-center justify-between">
                    <div class="w-9/12">
                        <strong class="text-lg">Sort data by date</strong>
                        <p class="text-sm">This will sort the chart data using date and will only work if the
                            <strong>scale type</strong> is set to <strong>time</strong>
                        </p>
                    </div>


                    <form method="POST" action="{{ route('charts.sort', ['chart' => $chart]) }}">
                        @csrf
                        @method('PUT')

                        <x-primary-button>Sort data</x-primary-button>
                    </form>
                </div>
            @endif

            <div class="mt-4 flex items-center justify-between">
                <div class="w-9/12">
                    <strong class="">Rebuild chart data</strong>
                    <p class="text-sm">This is important if you update or change project data. Chart data is not
                        automatically changed in case of invalid columns in the new project
                        data.</strong>
                    </p>
                    <x-input-error :messages="$errors->get('rebuildData')" class="mt-1" />
                </div>


                <form method="POST" action="{{ route('charts.rebuildData', ['chart' => $chart]) }}">
                    @csrf
                    @method('PUT')

                    <x-primary-button>Rebuild data</x-primary-button>
                </form>
            </div>

            {{-- <div class="mt-4">
                <form method="POST"
                    action="{{ route('charts.config', ['chart' => $chart]) }}">
                    @csrf
                    @method('PUT')

                    <x-input-label for="sectorLimit" :value="__('Sector Limit (leave blank for no limit)')" />
                    <x-text-input id="sector-limit" class="mt-1 block w-full" type="number"
                        name="sectorLimit"
                        :value="old('sectorLimit') ?? ($chart->config['sectorLimit'] ?? '')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </form>
            </div> --}}
        </div>

    </div>


    </div>
</x-app-layout>
