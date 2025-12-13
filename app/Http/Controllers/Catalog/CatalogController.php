<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Subfamily;
use App\Repositories\BannerRepository;
use App\Repositories\Catalog\ProductRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CatalogController extends Controller
{
    protected $productRepository;

    protected $bannerRepository;

    protected $categoryRepository;

    public function __construct(ProductRepository $productRepository, BannerRepository $bannerRepository, CategoryRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->bannerRepository = $bannerRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function banners()
    {
        return $this->bannerRepository->activeBanners();
    }

    public function menu()
    {
        Log::info('Fetching menu data');

        return $this->categoryRepository->menuData();

    }

    public function getFilters()
    {
        // Brands
        $brands = Brand::all(['id', 'name', 'slug']);

        // Subfamilies
        $subfamilies = Subfamily::all(['id', 'name', 'slug']);

        // others

        $sort = [
            ['value' => 'price_asc', 'label' => 'Price: Low to High'],
            ['value' => 'price_desc', 'label' => 'Price: High to Low'],
            ['value' => 'name_asc', 'label' => 'Name: A to Z'],
            ['value' => 'name_desc', 'label' => 'Name: Z to A'],
        ];

        return response()->json([
            'data' => [
                'brands' => $brands,
                'subfamilies' => $subfamilies,
                'sort' => $sort,
            ],
        ]);

    }

    // use search from product repository
    public function search(Request $request)
    {
        $term = $request->input('term', ''); // or $request->query('term')

        return $this->productRepository->search($term);
    }
}
