<x-app-layout>
    <header class="mb-6 pb-4">
        <div class="flex flex-wrap items-center justify-between gap-x-6 gap-y-2 mb-4">
            <h2 class="text-3xl font-bold tracking-tight text-text">
                {{ $project->name }}
            </h2>

            <div class="flex flex-wrap gap-x-4 gap-y-2">
                <a href={{ route('projects.charts.create', $project) }}
                    class="rounded-md border px-4 py-2 text-sm font-medium hover:bg-bg-hover">
                    Create chart
                </a>

                <a href={{ route('projects.preview', $project) }}
                    class="rounded-md border px-4 py-2 text-sm font-medium hover:bg-bg-hover">
                    View data
                </a>

                <a href={{ route('projects.edit', $project) }}
                    class="rounded-md border px-4 py-2 text-sm font-medium hover:bg-bg-hover">
                    Settings
                </a>
            </div>
        </div>

        <p class="text-text-light">
            {{ $project->description ?? 'No description' }}
        </p>
    </header>

    <div>
        <h2 class="sr-only mb-4 text-2xl font-bold">Charts</h2>

        @if (count($project->charts) === 0)
            <div class="mx-auto mt-16 flex w-fit flex-col items-center">
                <p class="mb-4 text-xl md:text-3xl">No charts created yet!</p>
                <a href={{ route('projects.charts.create', $project) }}
                    class="rounded-md border px-4 py-2 text-sm font-medium hover:bg-bg-hover">
                    Create chart
                </a>
            </div>
        @else
            <div class="flex flex-col">
                @foreach ($project->charts as $chart)
                    <div class="py-4 border-b last:border-none">
                        <h2 class="text-xl font-bold"><a
                                href="{{ route('charts.show', ['chart' => $chart]) }}"
                                class="hover:underline">{{ $chart->name }}</a>
                        </h2>
                        <p class="flex items-center gap-1">
                            <x-dynamic-component
                                :component="$chartIcons[$chart->type->value]" class="w-4 fill-current" />
                            <span
                                class="text-sm">{{ str_replace('_', ' ', $chart->type->value) }}</span>
                        </p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
