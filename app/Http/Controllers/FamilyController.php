<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Http\Requests\StoreFamilyRequest;
use App\Http\Requests\UpdateFamilyRequest;
use App\Repositories\FamilyRepository;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    protected $familyRepository;

    public function __construct(FamilyRepository $familyRepository)
    {
        $this->familyRepository = $familyRepository;
    }

    public function index(Request $request)
    {
        return $this->familyRepository->all($request);
    }

    public function store(StoreFamilyRequest $request)
    {
        return $this->familyRepository->create($request->validated());
    }

    public function show($id)
    {
        return $this->familyRepository->find($id);
    }

    public function update(UpdateFamilyRequest $request, $id)
    {
        return $this->familyRepository->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->familyRepository->delete($id);
    }
}
