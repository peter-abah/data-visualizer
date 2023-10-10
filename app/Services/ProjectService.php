<?php

namespace App\Services;

use App\Http\Requests\Projects\StoreRequest;
use App\Http\Requests\Projects\UpdateRequest;
use App\Models\Project;

class ProjectService
{
    public function createProject(StoreRequest $request): Project
    {
        $attributes = $request->validated();

        Helpers::removeBOMFromUploadedFile($request->file('file'));

        $columns = (new CSVFile($request->file('file')->getRealPath()))->getKeys();
        $file_path = $request->file('file')->store('project_files');

        $project = new Project($attributes);
        $project->file_path = $file_path;
        $project->columns = $columns;
        $request->user()->projects()->save($project);

        return $project;
    }

    public function updateProject(UpdateRequest $request): Project
    {
        $attributes = $request->validated();
        $project = $request->project;

        if (isset($attributes['file'])) {
            $this->updateFile($request, $project);
        }

        $project->update($attributes);

        return $project;
    }

    private function updateFile($request, $project) {
        Helpers::removeBOMFromUploadedFile($request->file('file'));

        $columns = (new CSVFile($request->file('file')->getRealPath()))->getKeys();
        $file_path = $request->file('file')->store('project_files');

        $project->file_path = $file_path;
        $project->columns = $columns;
    }
}
