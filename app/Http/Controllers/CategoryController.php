<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function navbar(){
        return $this->categoryRepository->navbarData();
    }

    public function index(Request $request)
    {
        return $this->categoryRepository->all($request);
    }

    public function store(StoreCategoryRequest $request)
    {
        return $this->categoryRepository->create($request->validated());
    }

    public function show( $id)
    {
        return $this->categoryRepository->find($id);
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        return $this->categoryRepository->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->categoryRepository->delete($id);
    }
}
