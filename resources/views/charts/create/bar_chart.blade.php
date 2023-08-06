<x-app-layout>
    <div class="max-w-2xl mx-auto">
        <h1 class="text-xl font-bold mb-6">Create Bar Chart</h1>
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
                    @foreach ($columns as $column)
                        <option value="{{ $column }}" {{ $column === old('x-axis-column') ? 'selected' : '' }}>
                            {{ $column }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('x-axis-column')" />
            </div>

            <div class="mt-4">
                <x-input-label for="data-column" :value="__('Data Column (Ensure it is numeric)*')" />
                <select name="data-column" id="data-column" required>
                    <option value="">{{ __('--Select an option--') }}</option>
                    @foreach ($columns as $column)
                        <option value="{{ $column }}" {{ $column === old('data-column') ? 'selected' : '' }}>
                            {{ $column }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('data-column')" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
                <a href="{{ route('dashboard') }}" class="ml-4">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>
