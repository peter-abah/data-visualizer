<x-app-layout>
    <div class="mx-auto max-w-2xl">
        <h1 class="mb-6 text-xl font-bold">Project Settings</h1>
        <form method="POST" action="{{ route('projects.update', $project) }}"
            enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="mt-4">
                <x-input-label for="name" :value="__('Name*')" />
                <x-text-input id="name" class="mt-1 block w-full" type="text" name="name"
                    :value="old('name') ?? $project->name" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="description" :value="__('Description')" />
                <textarea type="text" id="description"
                    class="mt-1 h-28 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600"
                    name="description">{{ old('description') ?? $project->description }}</textarea>
                <x-input-error :messages="$errors->get('description')" />
            </div>

            <div class="mt-4">
                <x-input-label for="description" class="mb-1" :value="__('Change Data File')" />
                <input type="file" id="file" name="file" accept=".txt,text/csv" />
                <x-input-error :messages="$errors->get('file')" />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <x-primary-button>{{ __('Update') }}</x-primary-button>
                <a href="{{ route('projects.show', $project) }}"
                    class="ml-4">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>
