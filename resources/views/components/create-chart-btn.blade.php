<x-dropdown>
    <x-slot name="trigger">
        <button class=" px-4 py-2 rounded-md text-sm font-medium border hover:bg-slate-50">
            {{ __('Create chart') }}
        </button>
    </x-slot>

    <x-slot name="content">
        <x-dropdown-link :href="route('projects.charts.create', ['project' => $project->id, 'type' => 'line_chart'])">
            {{ __('Line chart') }}
        </x-dropdown-link>

        <x-dropdown-link :href="route('projects.charts.create', ['project' => $project->id, 'type' => 'bar_chart'])">
            {{ __('Bar chart') }}
        </x-dropdown-link>
    </x-slot>
</x-dropdown>
