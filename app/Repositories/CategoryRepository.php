<?php

namespace App\Repositories;

use App\Http\Resources\CategoryResource;
use App\Interfaces\BaseRepository;
use App\Models\Category;

class CategoryRepository implements BaseRepository
{

    public function all($request)
    {
        if(!Category::all()) {
            return "No categories found";
        }

        return CategoryResource::collection(Category::all());
    }

    public function find($id)
    {
        if (empty($id)) {
            return "Id is required";
        }

        $category = Category::find($id);

        if ($category) {
            return new CategoryResource($category);
        }
        return "Category not found";
    }

    public function create(array $attributes)
    {
        if (!$attributes) {
            return "Attributes are required";
        }

        return new CategoryResource(resource: Category::create($attributes));
    }

    public function update($id, array $attributes)
    {
        if (empty($id)) {
            return "Id is required";
        }

        if (!$attributes) {
            return "Attributes are required";
        }

        $category = Category::find($id);

        if ($category) {

            $category->update($attributes);
            return new CategoryResource($category);
        }
        return "Category not found";
    }

    public function delete($id)
    {
        if (! $id) {
            return null;
        }

        if(empty($id)){
            return "Id is required";
        }

        $category = Category::find($id);

        if ($category->subcategories()->count() > 0) {
            return "Cannot delete category with existing subcategories";
        }else{
            $category->delete();
            return response()->noContent();
        }
    }
}
