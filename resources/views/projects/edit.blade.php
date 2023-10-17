<x-app-layout>
    <div class="max-w-2xl">
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
                    class="mt-1 h-48 sm:h-32 resize-none w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600"
                    name="description">{{ old('description') ?? $project->description }}</textarea>
                <x-input-error :messages="$errors->get('description')" />
            </div>

            <div class="mt-4 overflow-x-hidden">
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

        <div class="mt-12 p-6 mb-8 border-t flex items-center justify-between">
            <div class="w-9/12">
                <strong>Delete Project</strong>
            </div>
            <x-danger-button class="normal-case" x-data
                x-on:click.prevent="$dispatch('open-modal', 'confirm-project-deletion')">Delete</x-danger-button>

            <x-modal name="confirm-project-deletion" :show="false" focusable>
                <form method="post"
                    action="{{ route('projects.destroy', ['project' => $project]) }}"
                    class="p-6">
                    @csrf
                    @method('delete')

                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Are you sure you want to delete the project?') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('This will also delete all charts belonging to the project.') }}
                    </p>

                    <div class="mt-6 flex justify-end">
                        <x-secondary-button class="normal-case" x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-danger-button class="ml-3 normal-case">
                            {{ __('Delete Project') }}
                        </x-danger-button>
                    </div>
            </x-modal>
            </form>
        </div>
    </div>
</x-app-layout>
