<x-app-layout>
    <header class="flex flex-wrap items-center justify-between gap-4">
        <h2 class="text-3xl font-bold tracking-tight">
            {{ __('Dashboard') }}
        </h2>

        <a href={{ route('projects.create') }}
            class="rounded-md border px-4 py-2 text-sm font-medium hover:bg-bg-hover">
            {{ 'Create Project' }}
        </a>
    </header>

    <div class="py-8">
        @if (count($projects) === 0)
            <div class="mx-auto mt-8 flex w-fit flex-col items-center">
                <p class="mb-4 text-xl md:text-3xl">No projects created yet!</p>
                <a href={{ route('projects.create') }}
                    class="w-fit rounded-md border px-4 py-2 text-sm font-medium hover:bg-bg-hover">
                    Create new project
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($projects as $project)
                    <a href="{{ route('projects.show', ['project' => $project]) }}">
                        <div class="rounded-lg border p-6 hover:bg-bg-hover">
                            <h2 class="mb-4 flex items-center gap-2 text-lg font-bold">
                                <x-icons.dataset class="w-5 fill-text" />
                                <span class="truncate">{{ $project->name }}</span>
                            </h2>
                            <p class="truncate text-sm">
                                {{ $project->description ?? 'No description' }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
