<?php

namespace App\Http\Controllers\Admin\InternalTeam;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\InternalTeam\InternalTeamService;
use App\Http\Requests\InternalTeam\StoreInternalTeamRequest;
use App\Http\Requests\InternalTeam\UpdateInternalTeamRequest;

class InternalTeamController extends Controller
{
    protected InternalTeamService $internalTeamService;

    public function __construct(InternalTeamService $internalTeamService)
    {
        $this->internalTeamService = $internalTeamService;
    }

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        return $this->internalTeamService->getAll($perPage);
    }

    public function store(StoreInternalTeamRequest $request)
    {
        return $this->internalTeamService->create($request->validated());
    }

    public function show(int $id)
    {
        return $this->internalTeamService->getById($id);
    }

    public function update(UpdateInternalTeamRequest $request, int $id)
    {
        return $this->internalTeamService->update($id, $request->validated());
    }

    public function destroy(int $id)
    {
        return $this->internalTeamService->delete($id);
    }
}
