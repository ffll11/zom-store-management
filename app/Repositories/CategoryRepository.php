<?php

namespace App\Repositories;

use App\Http\Resources\CategoryResource;
use App\Interfaces\BaseRepository;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryRepository implements BaseRepository
{
    public function all($request)
    {
        if (! Category::all()) {
            return 'No categories found';
        }

        return CategoryResource::collection(Category::all());
    }

    public function menuData()
    {
        $rows = DB::table('menu_view')->get();

        // Convert to json

        $menu = [];

        foreach ($rows as $row) {

            // ---- CATEGORIES ----
            if (! isset($menu[$row->category_slug])) {
                $menu[$row->category_slug] = [
                    'id' => $row->category_id,
                    'name' => $row->category_name,
                    'slug' => $row->category_slug,
                    'subcategories' => [],
                ];
            }

            // ---- SUBCATEGORIES ----
            if (! isset($menu[$row->category_slug]['subcategories'][$row->subcategory_slug])) {
                $menu[$row->category_slug]['subcategories'][$row->subcategory_slug] = [
                    'id' => $row->subcategory_id,
                    'name' => $row->subcategory_name,
                    'slug' => $row->subcategory_slug,
                    'families' => [],
                ];
            }

            // ---- FAMILIES ----
            if (! isset($menu[$row->category_slug]['subcategories'][$row->subcategory_slug]['families'][$row->family_slug])) {
                $menu[$row->category_slug]['subcategories'][$row->subcategory_slug]['families'][$row->family_slug] = [
                    'id' => $row->family_id,
                    'name' => $row->family_name,
                    'slug' => $row->family_slug,
                    'subfamilies' => [],
                ];
            }

            // ---- SUBFAMILIES ----
            $menu[$row->category_slug]['subcategories'][$row->subcategory_slug]['families'][$row->family_slug]['subfamilies'][] = [
                'id' => $row->subfamily_id,
                'name' => $row->subfamily_name,
                'slug' => $row->subfamily_slug,
            ];
        }

        // Convert associative keys to clean arrays
        $menu = array_values(array_map(function ($cat) {
            $cat['subcategories'] = array_values(array_map(function ($sub) {
                $sub['families'] = array_values(array_map(function ($fam) {
                    return $fam;
                }, $sub['families']));

                return $sub;
            }, $cat['subcategories']));

            return $cat;
        }, $menu));
        Log::info('Menu JSON:', $menu);

        $response = response()->json([
            'data' => $menu,
        ]);

        Log::info('menu response', ['response' => $response]);

        return $response;

    }

    public function find($id)
    {
        if (empty($id)) {
            return 'Id is required';
        }

        $category = Category::find($id);

        if ($category) {
            return new CategoryResource($category);
        }

        return 'Category not found';
    }

    public function create(array $attributes)
    {
        if (! $attributes) {
            return 'Attributes are required';
        }

        return new CategoryResource(resource: Category::create($attributes));
    }

    public function update($id, array $attributes)
    {
        if (empty($id)) {
            return 'Id is required';
        }

        if (! $attributes) {
            return 'Attributes are required';
        }

        $category = Category::find($id);

        if ($category) {

            $category->update($attributes);

            return new CategoryResource($category);
        }

        return 'Category not found';
    }

    public function delete($id)
    {
        if (! $id) {
            return null;
        }

        if (empty($id)) {
            return 'Id is required';
        }

        $category = Category::find($id);

        if ($category->subcategories()->count() > 0) {
            return 'Cannot delete category with existing subcategories';
        } else {
            $category->delete();

            return response()->noContent();
        }
    }
}
