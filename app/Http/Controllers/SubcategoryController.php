<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubcategoryResource;
use App\Models\Subcategory;
use App\Http\Requests\StoreSubcategoryRequest;
use App\Http\Requests\UpdateSubcategoryRequest;
use App\Repositories\SubcategoryRepository;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
   protected $subcategoryRepository;

   public function __construct(SubcategoryRepository $subcategoryRepository)
   {
       $this->subcategoryRepository = $subcategoryRepository;
   }
    public function index(Request $request)
    {
        return $this->subcategoryRepository->all($request);
    }

    public function store(StoreSubcategoryRequest $request)
    {
        return $this->subcategoryRepository->create($request->validated());
    }
    public function show( $id)
    {
      return  $this->subcategoryRepository->find($id);
    }

    public function update(UpdateSubcategoryRequest $request, $id)
    {
        return $this->subcategoryRepository->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->subcategoryRepository->delete($id);
    }
}
