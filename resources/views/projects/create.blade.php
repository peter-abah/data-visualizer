<x-app-layout>
    <div class="max-w-2xl">
        <h1 class="mb-6 text-xl font-bold">Create Project</h1>
        <form method="POST" action="{{ route('projects.store') }}" enctype="multipart/form-data">
            @csrf
            @method('post')

            <div class="mt-4">
                <x-input-label for="name" :value="__('Name*')" />
                <x-text-input id="name" class="mt-1 block w-full" type="text" name="name"
                    :value="old('name')"
                    required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="description" :value="__('Description')" />
                <textarea type="text" id="description"
                    class="mt-1 h-28 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600"
                    name="description">{{ old('description') }}</textarea>
                <x-input-error :messages="$errors->get('description')" />
            </div>

            <div class="mt-4">
                <x-input-label for="description" class="mb-1" :value="__('Data File* (Select CSV containing data)')" />
                <input type="file" id="file" name="file" accept=".txt,text/csv"
                    required />
                <x-input-error :messages="$errors->get('file')" />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
                <a href="{{ route('dashboard') }}" class="ml-4">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>
