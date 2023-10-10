<x-app-layout>
    <header class="mb-6 pb-4">
        <div class="flex items-center">
            <h1 class="text-3xl font-bold tracking-tight text-gray-800 dark:text-gray-200">
                {{ $project->name }}
            </h1>

            <div class="ml-auto flex justify-end gap-4">
                <a href={{ route('projects.charts.create', $project) }}
                    class="rounded-md border px-4 py-2 text-sm font-medium hover:bg-slate-50">
                    Create chart
                </a>

                <a href={{ route('projects.edit', $project) }}
                    class="rounded-md border px-4 py-2 text-sm font-medium hover:bg-slate-50">
                    Settings
                </a>

                {{-- <a href="#"
                    class="rounded-md bg-red-500 px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-red-700">
                    Delete Project
                </a> --}}
            </div>
        </div>

        <p class="text-gray-500 dark:text-gray-300">
            {{ $project->description ?? 'No description' }}
        </p>
    </header>

    <div>
        <h2 class="sr-only mb-4 text-2xl font-bold">Charts</h2>

        @if (count($project->charts) === 0)
            <div class="mx-auto mt-16 flex w-fit flex-col items-center">
                <p class="mb-4 text-xl md:text-3xl">No charts created yet!</p>
                <a href={{ route('projects.charts.create', $project) }}
                    class="rounded-md border px-4 py-2 text-sm font-medium hover:bg-slate-50">
                    Create chart
                </a>
            </div>
        @else
            <div class="flex flex-col">
                @foreach ($project->charts as $chart)
                    <a href="{{ route('charts.show', ['chart' => $chart]) }}"
                        class="border-b last:border-none hover:underline">
                        <div class="flex items-center py-4">
                            <h2 class="text-lg font-bold">{{ $chart->name }}</h2>
                            <p class="ml-10 truncate text-sm">({{ $chart->type }})</p>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
