<?php
namespace App\Repositories;

use App\Interfaces\BaseRepository;
use App\Http\Resources\SubfamilyResource;
use App\Models\Subfamily;
use Illuminate\Support\Facades\Log;

class SubfamilyRepository implements BaseRepository
{
    public function all($request)
    {
        if(!Subfamily::all()) {
            return "No subfamilies found";
        }

        return SubfamilyResource::collection(Subfamily::all());
    }

    public function getNameSubfamily()
    {
       $subfamily =  Subfamily::query()->select('id', 'name')->get();

        return response()->json($subfamily,200);
    }

    public function find($id)
    {
        if (empty($id)) {
            return "Id is required";
        }

        $subfamily = Subfamily::find($id);
        if ($subfamily) {
            return new SubfamilyResource($subfamily);
        }
        return "Subfamily not found";
    }

    public function create(array $attributes)
    {
        if (!$attributes) {
            return "Attributes are required";
        }

        return new SubfamilyResource(resource: Subfamily::create($attributes));
    }
    public function update($id, array $attributes)
    {
        if (empty($id)) {
            return "Id is required";
        }

        if (!$attributes) {
            return "Attributes are required";
        }

        $subfamily = Subfamily::find($id);
        if ($subfamily) {
            $subfamily->update($attributes);
            return new SubfamilyResource($subfamily);
        }
        return "Subfamily not found";
    }
    public function delete($id)
    {
        if (! $id) {
            return null;
        }

        if(empty($id)){
            return "Id is required";
        }
        $subfamily = Subfamily::find($id);
        if ($subfamily) {
            $subfamily->delete();

            return response()->noContent();
        }
        return "Subfamily not found";
    }
}
