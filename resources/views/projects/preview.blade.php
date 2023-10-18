<x-app-layout>
    <header class="mb-8">
        <h1 class="text-3xl font-bold">
            <a class="hover:underline" href={{ route('projects.show', $project) }}>{{ $project->name }}</a>
        </h1>
    </header>
    <div class="overflow-x-auto shadow-lg">
        <table class="relative w-full table-fixed">
            <!-- head -->
            <thead class="sticky top-0 bg-black p-4 text-white">
                <tr>
                    @foreach ($data[0] as $column => $_)
                        <th class="w-32 p-4 text-start sm:w-48 truncate">{{ $column }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $row)
                    <tr>
                        @foreach ($row as $value)
                            <td class="border border-r-0">
                                <div class="truncate px-4 py-2" width="100%">{{ $value }}
                                </div>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
