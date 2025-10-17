<?php

namespace App\Http\Controllers;

use App\Models\Subfamily;
use App\Http\Requests\StoreSubfamilyRequest;
use App\Http\Requests\UpdateSubfamilyRequest;
use Illuminate\Http\Request;
use App\Repositories\SubfamilyRepository;
class SubfamilyController extends Controller
{
    protected $subfamilyRepository;

    public function __construct(SubfamilyRepository $subfamilyRepository)
    {
        $this->subfamilyRepository = $subfamilyRepository;
    }
    public function index(Request $request)
    {
        return $this->subfamilyRepository->all($request);
    }

    public function store(StoreSubfamilyRequest $request)
    {
        return $this->subfamilyRepository->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        return $this->subfamilyRepository->find($id);
    }

    public function update(UpdateSubfamilyRequest $request, $id)
    {
        return $this->subfamilyRepository->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->subfamilyRepository->delete($id);
    }
}
