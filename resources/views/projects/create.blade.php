<x-app-layout>
    <div class="max-w-2xl mx-auto">
        <h1 class="text-xl font-bold mb-6">Create Project</h1>
        <form method="POST" action="{{ route('projects.store') }}" enctype="multipart/form-data">
            @csrf
            @method('post')

            <div class="mt-4">
                <x-input-label for="name" :value="__('Name*')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                    required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="description" :value="__('Description')" />
                <textarea type="text" id="description"
                    class="w-full h-28 mt-1 border-gray-300  dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    name="description"></textarea>
                <x-input-error :messages="$errors->get('description')" />
            </div>

            <div class="mt-4">
                <x-input-label for="description" class="mb-1" :value="__('File* (Select CSV containing data)')" />
                <input type="file" id="file" name="file" accept=".txt,text/csv" required />
                <x-input-error :messages="$errors->get('file')" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
                <a href="{{ route('dashboard') }}" class="ml-4">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>
