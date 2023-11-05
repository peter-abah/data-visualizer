<x-app-layout>
    <div class="max-w-2xl">
        <header class="flex mb-6  items-center justify-between gap-8">
            <h1 class="text-xl font-bold">Project Settings</h1>
            <a href="{{ route('projects.show', $project) }}"
                class="flex items-center hover:underline"><x-icons.arrow-back class="fill-text" /> Back</a>
        </header>
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
                    class="mt-1 h-48 w-full resize-none rounded-md border-border-input shadow-sm focus:border-indigo-500 focus:ring-indigo-500      sm:h-32"
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
            </div>
        </form>

        <div class="mb-8 mt-12 flex items-center justify-between border-t py-6">
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

                    <h2 class="text-lg font-medium text-text ">
                        {{ __('Are you sure you want to delete the project?') }}
                    </h2>

                    <p class="mt-1 text-sm text-text-light">
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
