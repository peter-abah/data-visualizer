@props(['project', 'chartType', 'errors', 'heading' => 'Create chart'])

<div class="max-w-2xl mx-auto">
    <h1 class="text-xl font-bold mb-6">Create Line Chart</h1>
    <form x-data="{ columnsNo: 0 }" method="POST" action="{{ route('projects.charts.store', ['project' => $project]) }}">
        @csrf
        @method('post')

        <input type="hidden" name="type" value="{{ $chartType }}">

        <div class="mt-4">
            <x-input-label for="name" :value="__('Name*')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="xAxisColumn" :value="__('Column for X axis*')" />
            <select name="xAxisColumn" id="xAxisColumn" required>
                <option value="">{{ __('--Select an option--') }}</option>
                @foreach ($project->columns as $column)
                    <option value="{{ $column }}" {{ $column === old('xAxisColumn') ? 'selected' : '' }}>
                        {{ $column }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('xAxisColumn')" />
        </div>

        <div x-data="{ isVisible: true }" class="mt-6">
            <div class="flex">
                <p class="font-bold">Data Columns</p>
                <button type="button" @click="isVisible = !isVisible" class="px-2">
                    <span x-text="isVisible ? 'condense' : 'expand'" class="sr-only"></span>
                    <x-icons.expand-more class="rotate-180" x-bind:class="{ 'rotate-0': !isVisible }" />
                </button>
            </div>

            <div x-bind:class="{ 'hidden': !isVisible }">
                <ul>
                    <li class="mt-2">
                        <x-input-label for="dataColumns.1" :value="__('Data Column 1 (Ensure it is numeric)*')" />
                        <select name="dataColumns[]" id="dataColumns.1" required>
                            <option value="">{{ __('--Select an option--') }}</option>
                            @foreach ($project->columns as $column)
                                <option value="{{ $column }}">{{ $column }}</option>
                            @endforeach
                        </select>
                    </li>

                    <template x-for="i in columnsNo">
                        <li class="mt-4">
                            <x-input-label x-bind:for="`dataColumns.*.${i + 1}`"
                                x-text="`Data Column ${i + 1} (Ensure it is numeric)*`" />
                            <select x-bind:id="`dataColumns.${i + 1}}`" name="dataColumns[]" required>
                                <option value="">{{ __('--Select an option--') }}</option>
                                @foreach ($project->columns as $column)
                                    <option value="{{ $column }}">
                                        {{ $column }}</option>
                                @endforeach
                            </select>
                        </li>
                    </template>
                </ul>

                <x-input-error :messages="$errors->get('dataColumns')" />

                <div class="mt-4 flex gap-4">
                    <x-primary-button type="button" @click="columnsNo++"
                        x-show="columnsNo < 2 ">{{ __('Add data column') }}</x-primary-button>
                    <x-primary-button type="button" @click="columnsNo--" x-cloak
                        x-show="columnsNo > 0">{{ __('Remove data column') }}</x-primary-button>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <x-input-label for="aggregationOption" :value="__('Aggregation option')" />

            <select name="aggregationOption" id="aggregationOption" required>
                @foreach (\App\Enums\AggregationOption::cases() as $option)
                    <option value="{{ $option }}"
                        {{ $option->value === old('aggregationOption') ? 'selected' : 'sum' }}>
                        {{ ucwords($option->value) }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('aggregationOption')" />

            {{-- TODO: SHOULD PROBABLY DELETE
                <div class="mt-2" x-cloak x-show="isVisible">
                <p class="text-sm">Applys to:</p>
                <ul class="flex wrap gap-y-2 gap-x-4">
                    <li class="flex">
                        <x-input-label for="aggregation-all" :value="__('All')" class="mr-2 text-sm" />
                        <input type="checkbox" name="aggregation-all" id="aggregation-all" value="all" checked>
                    </li>

                    <template x-for="i in columnsNo + 1">
                        <li class="flex">
                            <x-input-label x-bind:for="`aggregation-${i}`" x-text="`Data Column ${i}`"
                                class="mr-2 text-sm" />
                            <input type="checkbox" name="aggregation-to[]" x-bind:id="`aggregation-${i}`"
                                x-bind:value="i - 1">
                        </li>
                    </template>
                </ul>
            </div> --}}
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
            <a href="{{ route('dashboard') }}" class="ml-4">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>
