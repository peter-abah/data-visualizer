@props(['project', 'chartType', 'errors', 'heading' => 'Create chart'])

<div class="max-w-2xl mx-auto">
    <h1 class="text-xl font-bold mb-6">Create Line Chart</h1>
    <form method="POST" action="{{ route('projects.charts.store', ['project' => $project]) }}">
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
            <x-input-label for="x-axis-column" :value="__('Column for X axis*')" />
            <select name="x-axis-column" id="x-axis-column" required>
                <option value="">{{ __('--Select an option--') }}</option>
                @foreach ($project->columns as $column)
                    <option value="{{ $column }}" {{ $column === old('x-axis-column') ? 'selected' : '' }}>
                        {{ $column }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('x-axis-column')" />
        </div>

        <ul x-data="{ columnsNo: 0 }" class="mt-8">
            <li class="mt-4">
                <x-input-label for="data-columns.1" :value="__('Data Column 1 (Ensure it is numeric)*')" />
                <select name="data-columns[]" id="data-columns.1" required>
                    <option value="">{{ __('--Select an option--') }}</option>
                    @foreach ($project->columns as $column)
                        <option value="{{ $column }}"
                            {{ old('data-columns') && $column === old('data-columns')[0] ? 'selected' : '' }}>
                            {{ $column }}</option>
                    @endforeach
                </select>
            </li>

            <template x-for="i in columnsNo">
                <li class="mt-4">
                    <x-input-label x-bind:for="`data-columns.*.${i + 1}`"
                        x-text="`Data Column ${i + 1} (Ensure it is numeric)*`" />
                    <select x-bind:id="`data-columns.${i + 1}}`" name="data-columns[]" required>
                        <option value="">{{ __('--Select an option--') }}</option>
                        @foreach ($project->columns as $column)
                            <option value="{{ $column }}">
                                {{ $column }}</option>
                        @endforeach
                    </select>
                </li>
            </template>

            <x-input-error :messages="$errors->get('data-columns')" />

            <div class="mt-4 flex gap-4">
                <x-primary-button type="button" @click="columnsNo++"
                    x-show="columnsNo < 2 ">{{ __('Add dataset') }}</x-primary-button>
                <x-primary-button type="button" @click="columnsNo--"
                    x-show="columnsNo > 0">{{ __('Delete dataset') }}</x-primary-button>
            </div>
        </ul>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
            <a href="{{ route('dashboard') }}" class="ml-4">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>
