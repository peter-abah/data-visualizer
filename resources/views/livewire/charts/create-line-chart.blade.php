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
            <x-input-label for="x-axis-column" :value="__('Column for X axis*')" />
            <select id="x-axis-column" required wire:model="xAxisColumn">
                <option value="">{{ __('--Select an option--') }}</option>
                @foreach ($project->columns as $column)
                    <option value="{{ $column }}" {{ $column === old('xAxisColumn') ? 'selected' : '' }}>
                        {{ $column }}</option>
                @endforeach
            </select>

            <x-input-error :messages="$errors->get('xAxisColumn')" />
        </div>

        <div class="mt-4">
            <x-input-label for="data-column" :value="__('Data Column (Ensure it is numeric)*')" />
            <select id="data-column" wire:model="dataColumn" required>
                <option value="">{{ __('--Select an option--') }}</option>
                @foreach ($project->columns as $column)
                    <option value="{{ $column }}" {{ $column === old('data-column') ? 'selected' : '' }}>
                        {{ $column }}</option>
                @endforeach
            </select>

            <x-input-error :messages="$errors->get('dataColumn')" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
            <a href="{{ route('dashboard') }}" class="ml-4">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>
