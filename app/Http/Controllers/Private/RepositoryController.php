<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Repository;

use App\Http\Resources\RepositoryResource;

use App\Services\Process\ImageProcessService;
use App\Traits\HasFlashMessages;

class RepositoryController extends Controller
{
    use HasFlashMessages;

    private ImageProcessService $image;
    private $render = 'private/Marketing';

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

    public function indexRepositories()
    {
        if (request()->user()->cannot('viewAny', Repository::class)) {
            return null;
        }
        return RepositoryResource::collection(
            Repository::active()
                ->get()
        );
    }

    public function showRepository(Repository $repository)
    {
        if (request()->user()->cannot('view', $repository)) {
            return null;
        }
        return new RepositoryResource($repository);
    }

    public function createRepository(Request $request)
    {
        if ($request->user()->cannot('create', Repository::class)) {
            return null;
        }
        $request->validate([
            'name' => 'required|unique:repositories,name',
            'url' => 'required|unique:repositories,url',
            'image' => 'required',
            'type' => 'required',
        ]);

        Repository::create([
            'name' => $request->input('name'),
            'url' => $request->input('url'),
            'image' => $this->image->store('repository', $request->file('image'), 'public'),
            'type' => $request->input('type'),
        ]);

        return $this->flashMessage('save');
    }

    function updateRepository(Request $request, Repository $repository)
    {
        if ($request->user()->cannot('update', $repository)) {
            return null;
        }
        $repository->fill([
            'name' => $request->input('name', $repository->name),
            'url' => $request->input('url', $repository->url),
            'image' => $this->image->store('repository', $request->file('image'), 'public', $repository->image),
            'type' => $request->input('type', $repository->type),
        ]);

        if ($repository->isDirty()) {
            $repository->save();
        }

        return $this->flashMessage('update');
    }

    public function deactivateRepository(Repository $repository)
    {
        if (request()->user()->cannot('delete', $repository)) {
            return null;
        }
        $repository->update([
            'is_active' => false,
        ]);

        return $this->flashMessage('deactivate');
    }

    public function render()
    {
        return Inertia::render($this->render, [
            'repositories' => $this->indexRepositories(),
        ]);
    }
}
