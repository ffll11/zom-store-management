<?php

namespace App\Http\Controllers;

use App\Repositories\BannerRepository;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    //
   private $bannerRepository;
    public function __construct(BannerRepository $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }
    public function index(Request $request)
    {
       //+ return $this->bannerRepository->all($request);
        return $this->bannerRepository->activeBanners();

    }

    public function activeBanners()
    {
        return $this->bannerRepository->activeBanners();
    }

}
