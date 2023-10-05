<x-app-layout>
    <div class="max-w-2xl mx-auto">
        <h1 class="text-xl font-bold mb-6">Create Chart</h1>
        <form x-data="{ columnsNo: 0 }" method="POST"
            action="{{ route('projects.charts.store', ['project' => $project]) }}">
            @csrf

            <div class="mt-4">
                <x-input-label for="name" :value="__('Name*')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                    required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="type" :value="__('Chart type*')" />
                <select name="type" id="type" required>
                    <option value="">{{ __('--Select an option--') }}</option>
                    @foreach (\App\Enums\ChartType::cases() as $type)
                        <option value="{{ $type->value }}" @selected($type->value === old('type'))>
                            {{ ucfirst(str_replace('_', ' ', $type->value)) }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('type')" />
            </div>

            <div class="mt-4">
                <x-input-label for="categoryColumn" :value="__('Category Column*')" />
                <select name="categoryColumn" id="categoryColumn" required>
                    <option value="">{{ __('--Select an option--') }}</option>
                    @foreach ($project->columns as $column)
                        <option value="{{ $column }}" {{ $column === old('categoryColumn') ? 'selected' : '' }}>
                            {{ $column }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('categoryColumn')" />
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
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
                <a href="{{ route('dashboard') }}" class="ml-4">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>
