<x-app-layout>
    <div class="max-w-2xl pb-8">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold">Chart Settings</h1>
            <a href="{{ route('charts.show', $chart) }}"
                class="flex items-center hover:underline"><x-icons.arrow-back /> Back</a>
        </div>

        <div class="mb-12">
            <form x-data="{
                columnsNo: 0,
                removedColumns: {},
                chartColumns: @js($chart->config['dataColumns']),
                showScaleTypeInput: @js($chart->type->isCartesian())
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

                <div class="mt-4" x-data="{ showTimeInfo: @js(\App\Enums\ScaleType::Time->value === ($chart->config['scaleType'] ?? null)) }">
                    <x-input-label for="categoryColumn" :value="__('Category Column*')" />

                    <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
                        <select name="categoryColumn" id="categoryColumn" required>
                            <option value="">{{ __('--Select an option--') }}
                            </option>
                            @foreach ($chart->project->columns as $column)
                                <option value="{{ $column }}"
                                    @selected($column === (old('categoryColumn') ? old('categoryColumn') : $chart->config['categoryColumn']))>
                                    {{ $column }}</option>
                            @endforeach
                        </select>

                        <div class="inline-flex flex-col"
                            x-cloak
                            x-show="showScaleTypeInput">
                            <div class="inline-flex items-center">
                                <x-input-label for="scaleType" :value="__('scale type')"
                                    class="mr-2 text-sm" />
                                <select name="scaleType" id="scaleType" required class="text-sm"
                                    x-on:change="showTimeInfo = $event.target.value === @js(\App\Enums\ScaleType::Time->value)">
                                    @foreach (\App\Enums\ScaleType::cases() as $option)
                                        <option value="{{ $option->value }}"
                                            @selected($option->value === (old('scaleType') ? old('scaleType') : $chart->config['scaleType'] ?? ''))>
                                            {{ ucfirst($option->value) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- TODO: Add link explaining date formats --}}
                    <p x-show="showTimeInfo" x-cloak class="mt-2 text-sm">Category column for
                        date/time charts should be in <strong>ISO format</strong>. Some components
                        can
                        be omited see: <strong>todo link here</strong></p>

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
                            <x-primary-button type="button" @click="columnsNo++" x-cloak
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

                <x-primary-button class="ml-auto mt-4 !flex">{{ __('Save') }}</x-primary-button>
            </form>
        </div>


        <div class="mb-12">
            <h2 class="border-b border-gray-400 pb-4 text-xl font-bold">Others</h2>

            <form method="POST" class="mb-8"
                action="{{ route('charts.updateConfig', ['chart' => $chart]) }}">
                @csrf
                @method('PUT')

                <div class="mt-6 flex flex-wrap items-center gap-2">
                    <x-input-label for="aggregationOption"
                        :value="__('Aggregation option')" />

                    <select name="aggregationOption"
                        id="aggregationOption"
                        required>
                        @foreach (\App\Enums\AggregationOption::cases() as $option)
                            <option value="{{ $option }}"
                                @selected($option->value === (old('aggregationOption') ? old('aggregationOption') : $chart->config['aggregationOption'] ?? \App\Enums\AggregationOption::Sum->value))>
                                {{ ucwords($option->value) }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('aggregationOption')" />
                </div>

                @if ($chart->type === \App\Enums\ChartType::PieChart)
                    <div class="mt-4 flex flex-wrap items-center gap-2">
                        <x-input-label for="sectorLimit" class="text-black" :value="__('Sector limit for pie chart (leave blank for no limit)')" />
                        <input id="sectorLimit" class="mt-1" type="number" name="sectorLimit"
                            value="{{ old('sectorLimit') ?? ($chart->config['sectorLimit'] ?? '') }}"
                            min="2" max="{{ count($chart->data) }}" />
                        <x-input-error :messages="$errors->get('sectorLimit')" class="mt-2" />
                    </div>
                @endif

                <x-primary-button class="ml-auto mt-4 !flex">{{ __('Save') }}</x-primary-button>
            </form>

            @if (($chart->config['scaleType'] ?? null) === \App\Enums\ScaleType::Time->value)
                <div
                    class="mb-8 flex flex-wrap items-center justify-between gap-4 rounded-md border p-4 sm:flex-nowrap">
                    <div>
                        <strong class="text-lg">Sort data by date</strong>
                        <p class="text-sm">This will sort the chart data using date and will only
                            work if the
                            <strong>scale type</strong> is set to <strong>time</strong>
                        </p>
                    </div>


                    <form method="POST" action="{{ route('charts.sort', ['chart' => $chart]) }}">
                        @csrf
                        @method('PUT')

                        <x-primary-button class="w-max">Sort data</x-primary-button>
                    </form>
                </div>
            @endif

            <div
                class="mb-8 flex flex-wrap items-center justify-between gap-4 rounded-md border p-4 sm:flex-nowrap">
                <div>
                    <strong class="">Rebuild chart data</strong>
                    <p class="text-sm">This is important if you update or change project data.
                        Chart
                        data is not
                        automatically changed in case of invalid columns in the new project
                        data.</strong>
                    </p>
                    <x-input-error :messages="$errors->get('rebuildData')" class="mt-1" />
                </div>


                <form method="POST"
                    action="{{ route('charts.rebuildData', ['chart' => $chart]) }}">
                    @csrf
                    @method('PUT')

                    <x-primary-button class="w-max">Rebuild data</x-primary-button>
                </form>
            </div>
        </div>

        <div class="flex items-center justify-between px-4">
            <div class="w-9/12">
                <strong>Delete chart</strong>
            </div>
            <x-danger-button class="normal-case" x-data
                x-on:click.prevent="$dispatch('open-modal', 'confirm-chart-deletion')">Delete</x-danger-button>

            <x-modal name="confirm-chart-deletion" :show="false" focusable>
                <form method="post"
                    action="{{ route('charts.destroy', ['chart' => $chart]) }}"
                    class="p-6">
                    @csrf
                    @method('delete')

                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Are you sure you want to delete the chart?') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('This action cannot be reversed') }}</p>

                    <div class="mt-6 flex justify-end">
                        <x-secondary-button class="normal-case"
                            x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-danger-button class="ml-3 normal-case">
                            {{ __('Delete Chart') }}
                        </x-danger-button>
                    </div>
            </x-modal>
            </form>
        </div>
    </div>


    </div>
</x-app-layout>
