<x-app-layout>
    <div class="max-w-2xl">
        <h1 class="mb-6 text-xl font-bold">Create Chart</h1>
        <form x-data="{ columnsNo: 0, showScaleTypeInput: false }" method="POST"
            action="{{ route('projects.charts.store', ['project' => $project]) }}">
            @csrf

            <div class="mt-4">
                <x-input-label for="name" :value="__('Name*')" />
                <x-text-input id="name" class="mt-1 block w-full" type="text" name="name"
                    :value="old('name')"
                    required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="type" :value="__('Chart type*')" />
                <select name="type" id="type" required
                    x-on:change="showScaleTypeInput = @js(\App\Enums\ChartType::getCartesianTypes()).includes($event.target.value)">
                    <option value="">{{ __('--Select an option--') }}</option>
                    @foreach (\App\Enums\ChartType::cases() as $type)
                        <option value="{{ $type->value }}" @selected($type->value === old('type'))>
                            {{ ucfirst(str_replace('_', ' ', $type->value)) }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('type')" />
            </div>

            <div class="mt-4" x-data="{ showTimeInfo: false }">
                <x-input-label for="categoryColumn" :value="__('Category Column*')" />

                <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
                    <select name="categoryColumn" id="categoryColumn" required>
                        <option value="">{{ __('--Select an option--') }}</option>
                        @foreach ($project->columns as $column)
                            <option value="{{ $column }}" @selected($column === old('categoryColumn'))>
                                {{ $column }}</option>
                        @endforeach
                    </select>

                    <div class="inline-flex flex-col" x-cloak x-show="showScaleTypeInput">
                        <div class="inline-flex items-center">
                            <x-input-label for="scaleType" :value="__('scale type')" class="mr-2 text-sm" />
                            <select name="scaleType" id="scaleType" required class="text-sm"
                                x-on:change="showTimeInfo = $event.target.value === '{{ \App\Enums\ScaleType::Time->value }}'">
                                @foreach (\App\Enums\ScaleType::cases() as $option)
                                    <option value="{{ $option->value }}"
                                        @selected(old('scaleType') ? $option->value === old('scaleType') : $option === \App\Enums\ScaleType::Category)>
                                        {{ ucfirst($option->value) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- TODO: Add link explaining date formats --}}
                <p x-show="showTimeInfo" x-cloak class="mt-2 text-sm">Category column for date/time
                    charts should be in <strong>ISO format</strong>. Some components can
                    be omited see: <strong>todo link here</strong></p>

                <x-input-error :messages="$errors->get('categoryColumn')" />
            </div>

            <div x-data="{ isVisible: true }" class="mb-8 mt-6">
                <div class="flex">
                    <p class="font-bold">Data Columns</p>
                    <button type="button" @click="isVisible = !isVisible" class="px-2">
                        <span x-text="isVisible ? 'condense' : 'expand'" class="sr-only"></span>
                        <x-icons.expand-more class="rotate-180"
                            x-bind:class="{ 'rotate-0': !isVisible }" />
                    </button>
                </div>

                <div x-bind:class="{ 'hidden': !isVisible }">
                    <ul>
                        <li class="mt-2">
                            <x-input-label for="dataColumns.1" :value="__('Data Column 1 (Ensure it is numeric)*')" />
                            <select name="dataColumns[]" id="dataColumns.1" required>
                                <option value="">{{ __('--Select an option--') }}</option>
                                @foreach ($project->columns as $column)
                                    <option value="{{ $column }}">{{ $column }}
                                    </option>
                                @endforeach
                            </select>
                        </li>

                        <template x-for="i in columnsNo">
                            <li class="mt-4">
                                <x-input-label x-bind:for="`dataColumns.*.${i + 1}`"
                                    x-text="`Data Column ${i + 1} (Ensure it is numeric)*`" />
                                <select x-bind:id="`dataColumns.${i + 1}}`" name="dataColumns[]"
                                    required>
                                    <option value="">{{ __('--Select an option--') }}
                                    </option>
                                    @foreach ($project->columns as $column)
                                        <option value="{{ $column }}">
                                            {{ $column }}</option>
                                    @endforeach
                                </select>
                            </li>
                        </template>
                    </ul>

                    <x-input-error :messages="\App\Services\Helpers::mergeDataColumnsErrors(
                        $errors,
                        count(old('dataColumns') ?? []),
                    )" />

                    <div class="mt-4 flex gap-4">
                        <x-primary-button type="button" @click="columnsNo++"
                            x-show="columnsNo < 2 ">{{ __('Add data column') }}</x-primary-button>
                        <x-primary-button type="button" @click="columnsNo--" x-cloak
                            x-show="columnsNo > 0">{{ __('Remove data column') }}</x-primary-button>
                    </div>
                </div>
            </div>

            <div class="mt-4 flex items-center justify-end">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
                <a href="{{ route('projects.show', $project) }}"
                    class="ml-4">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>
