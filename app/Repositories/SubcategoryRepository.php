<?php
namespace App\Repositories;

use App\Http\Resources\SubcategoryResource;
use App\Models\Subcategory;
use App\Interfaces\BaseRepository;

class SubcategoryRepository implements BaseRepository
{
    public function all($request)
    {
        if(!Subcategory::all()) {
            return "No subcategories found";
        }
            return SubcategoryResource::collection(Subcategory::all());
    }

    public function find($id)
    {
        if (empty($id)) {
            return "Id is required";
        }

        $subcategory = Subcategory::find($id);
        if ($subcategory) {
            return new SubcategoryResource($subcategory);
        }
        return "Subcategory not found";
    }

    public function create(array $attributes)
    {
        if (!$attributes) {
            return "Attributes are required";
        }

        return new SubcategoryResource(Subcategory::create($attributes));
    }
    public function update($id, array $attributes)
    {
        if (empty($id)) {
            return "Id is required";
        }

        if (!$attributes) {
            return "Attributes are required";
        }

        $subcategory = Subcategory::find($id);
        if ($subcategory) {

            $subcategory->update($attributes);
            return new SubcategoryResource($subcategory);
        }
        return "Subcategory not found";
    }

    public function delete($id)
    {
        if (empty($id)) {
            return "Id is required";
        }

        $subcategory = Subcategory::find($id);
        if ($subcategory) {
            $subcategory->delete();
            return "Subcategory deleted successfully";
        }
        return "Subcategory not found";
    }

}
