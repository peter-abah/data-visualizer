<x-app-layout>
    <header class="pb-4 mb-6">
        <div class="flex items-center">
            <h1 class="font-bold tracking-tight text-3xl text-gray-800 dark:text-gray-200">
                {{ $project->name }}
            </h1>

            <div class="ml-auto flex gap-4 justify-end">
                <a href={{ route('projects.charts.create', $project) }}
                    class="px-4 py-2 rounded-md text-sm font-medium border hover:bg-slate-50">
                    Create chart
                </a>

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
        <h2 class="text-2xl font-bold mb-4 sr-only">Charts</h2>

        @if (count($project->charts) === 0)
            <div class="flex flex-col w-fit mx-auto items-center mt-16">
                <p class="text-xl md:text-3xl mb-4">No charts created yet!</p>
                <a href={{ route('projects.charts.create', $project) }}
                    class="px-4 py-2 rounded-md text-sm font-medium border hover:bg-slate-50">
                    Create chart
                </a>
            </div>
        @else
            <div class="flex flex-col">
                @foreach ($project->charts as $chart)
                    <a href="{{ route('charts.show', ['chart' => $chart]) }}"
                        class="border-b last:border-none hover:underline">
                        <div class="py-4 flex items-center">
                            <h2 class="text-lg font-bold">{{ $chart->name }}</h2>
                            <p class="ml-10 truncate text-sm">({{ $chart->type }})</p>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
