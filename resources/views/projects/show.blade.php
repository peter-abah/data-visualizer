<x-app-layout>
    <header class="pb-4 mb-6 border-b">
        <div class="flex items-center">
            <h1 class="font-bold tracking-tight text-3xl text-gray-800 dark:text-gray-200">
                {{ $project->name }}
            </h1>

            <div class="ml-auto flex gap-4 justify-end">
                <x-dropdown>
                    <x-slot name="trigger">
                        <button class=" px-4 py-2 rounded-md text-sm font-medium border hover:bg-slate-50">
                            {{ __('Create chart') }}
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link
                            :href="route('projects.charts.create', ['project' => $project->id, 'type' => 'line_chart'])"
                        >
                            {{ __('Line chart') }}
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>

                <a href={{ route('projects.edit', $project) }}
                    class="px-4 py-2 rounded-md text-sm font-medium border hover:bg-slate-50">
                    Edit
                </a>

                <a href="#"
                    class="px-4 py-2 rounded-md text-sm shadow-sm font-bold bg-red-500 text-white hover:bg-red-700">
                    Delete Project
                </a>
            </div>
        </div>

        <p class="text-gray-500 dark:text-gray-300">
            {{ $project->description ?? 'No description' }}
        </p>
    </header>



    <div>
        <h2 class="text-2xl font-bold mb-4">Charts</h2>

        <div class="flex flex-col w-fit mx-auto items-center mt-8">
            <p class="text-xl md:text-3xl mb-4">No charts created yet!</p>
            <a href="#" class="w-fit px-4 py-2 rounded-md text-sm font-medium border hover:bg-slate-50">
                Create a chart
            </a>
        </div>

    </div>
</x-app-layout>
