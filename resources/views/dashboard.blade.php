<x-app-layout>
    <header class="flex items-center">
        <h1 class="font-bold tracking-tight text-3xl text-gray-800 dark:text-gray-200">
            {{ __('Data visualizer') }}
        </h1>

        <a href={{ route('projects.create') }}
            class="ml-auto px-4 py-2 rounded-md text-sm font-medium border hover:bg-slate-50">
            Create Project
        </a>
    </header>

    <div class="py-12">
        @if (count($projects) === 0)
            <div class="flex flex-col w-fit mx-auto items-center mt-8">
                <p class="text-xl md:text-3xl mb-4">No projects created yet!</p>
                <a href={{ route('projects.create') }}
                    class="w-fit px-4 py-2 rounded-md text-sm font-medium border hover:bg-slate-50">
                    Create new project
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($projects as $project)
                <a href="{{ route('projects.show', ['project' => $project]) }}">
                    <div class="rounded-lg border shadow-sm hover:shadow-md p-6">
                        <h2 class="text-lg font-bold mb-4">{{ $project->name }}</h2>
                        <p class="truncate text-sm">{{ $project->description ?? 'No description' }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
