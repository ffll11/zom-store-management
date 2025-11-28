<?php

namespace App\Repositories;

use App\Interfaces\BaseRepository;
use App\Models\Banner;
use App\Http\Resources\BannerResource;

class BannerRepository implements BaseRepository{

    public function all($request)
    {
        if(!Banner::all()) {
            return "No banners found";
        }

        return BannerResource::collection(Banner::all());
    }

    public function activeBanners(){
        $banners = Banner::active()->get();

        if ($banners->isEmpty()) {
            return "No active banners found";
        }

        return BannerResource::collection($banners);
    }

    public function find($id)
    {
        if (empty($id)) {
            return "Id is required";
        }

        $banner = Banner::find($id);
        if ($banner) {
            return new BannerResource($banner);
        }
        return "Banner not found";
    }
    public function create(array $attributes)
    {
        if (!$attributes) {
            return "Attributes are required";
        }
        return new BannerResource(resource: Banner::create($attributes));
    }

    public function update($id, array $attributes)
    {
        if (empty($id)) {
            return "Id is required";
        }

        if (!$attributes) {
            return "Attributes are required";
        }

        $banner = Banner::find($id);
        if ($banner) {
            $banner->update($attributes);
            return new BannerResource($banner);
        }
        return "Banner not found";
    }

    public function delete($id)
    {
        if (! $id) {
            return null;
        }

        $banner = Banner::find($id);
        if ($banner) {
            $banner->delete();
            return "Banner deleted successfully";
        }
        return "Banner not found";
    }
}
