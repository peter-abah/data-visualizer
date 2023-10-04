<div class="max-w-2xl mx-auto">
    <h1 class="text-xl font-bold mb-6">Create Line Chart</h1>
    <form wire:submit='save'>
        @csrf

        <div class="mt-4">
            <x-input-label for="name" :value="__('Name*')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" wire:model="name" required autofocus
                autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="xAxisColumn" :value="__('Column for X axis*')" />
            <select id="xAxisColumn" required wire:model="xAxisColumn">
                <option value="">{{ __('--Select an option--') }}</option>
                @foreach ($project->columns as $column)
                    <option value="{{ $column }}" {{ $column === old('xAxisColumn') ? 'selected' : '' }}>
                        {{ $column }}</option>
                @endforeach
            </select>

            <x-input-error :messages="$errors->get('xAxisColumn')" />
        </div>

        <ul x-data="{ columnsNo: {{ $dataColumnsNo }} }">
            @for ($i = 0; $i < $dataColumnsNo; $i++)
                <li class="mt-4">
                    <x-input-label for="dataColumn{{ $i }}" :value="__('Data Column ' . ($i + 1) . ' (Ensure it is numeric)*')" />
                    <select id="dataColumn{{ $i }}" wire:model="dataColumns.{{ $i }}" required>
                        <option value="">{{ __('--Select an option--') }}</option>
                        @foreach ($project->columns as $column)
                            <option value="{{ $column }}">
                                {{ $column }}</option>
                        @endforeach
                    </select>
                </li>
            @endfor

            <template x-for="i in (columnsNo - {{ $dataColumnsNo }})">
                <li class="mt-4">
                    <x-input-label x-bind:for="`dataColumn${i + {{ $dataColumnsNo }}}`"
                        x-text="`Data Column ${i + {{ $dataColumnsNo }}} (Ensure it is numeric)*`" />
                    <select x-bind:id="`dataColumn${i + {{ $dataColumnsNo }}}`" x-bind:name="`dataColumns.*.${i - 1}`"
                        required>
                        <option value="">{{ __('--Select an option--') }}</option>
                        @foreach ($project->columns as $column)
                            <option value="{{ $column }}">
                                {{ $column }}</option>
                        @endforeach
                    </select>
                </li>
            </template>

            <x-primary-button type="button" class="mt-2"
                @click="columnsNo++">{{ __('Add more lines') }}</x-primary-button>
            <x-input-error :messages="$errors->get('dataColumns')" />
        </ul>


        {{-- <ul x-data="{ columnsNo: {{ $dataColumnsNo }} }">
            <template x-for="i in columnsNo">
                <li class="mt-4">
                    <x-input-label x-bind:for="`dataColumn${i}`" :value="__('Data Column (Ensure it is numeric)*')" />
                    <select x-bind:id="`dataColumn${i}`" wire:model="dataColumn" required>
                        <option value="">{{ __('--Select an option--') }}</option>
                        @foreach ($project->columns as $column)
                            <option value="{{ $column }}"
                                {{ $column === old('dataColumn') ? 'selected' : '' }}>
                                {{ $column }}</option>
                        @endforeach
                    </select>

                    <x-input-error :messages="$errors->get('dataColumn')" />
                </li>
            </template>
        </ul> --}}

        {{-- <div class="mt-4">
            <x-input-label for="dataColumn" :value="__('Data Column (Ensure it is numeric)*')" />
            <select id="dataColumn" wire:model="dataColumn" required>
                <option value="">{{ __('--Select an option--') }}</option>
                @foreach ($project->columns as $column)
                    <option value="{{ $column }}" {{ $column === old('dataColumn') ? 'selected' : '' }}>
                        {{ $column }}</option>
                @endforeach
            </select>

            <x-input-error :messages="$errors->get('dataColumn')" />
        </div> --}}

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
            <a href="{{ route('dashboard') }}" class="ml-4">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>
