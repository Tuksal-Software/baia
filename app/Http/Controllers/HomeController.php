<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Feature;
use App\Models\HomeSection;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the home page
     */
    public function index(): View
    {
        // Get active home sections
        $sections = HomeSection::active()->ordered()->get();

        // Prepare data for each section type
        $data = [];

        foreach ($sections as $section) {
            $sectionData = $this->getSectionData($section);
            $data[$section->id] = $sectionData;
        }

        // Get sliders for hero section
        $sliders = Slider::published()->ordered()->get();

        // Get features for features bar
        $features = Feature::active()->ordered()->get();

        return view('home', compact('sections', 'data', 'sliders', 'features'));
    }

    /**
     * Get data for a specific section
     */
    private function getSectionData(HomeSection $section): array
    {
        return match ($section->type) {
            'categories' => $this->getCategoriesData($section),
            'products' => $this->getProductsData($section),
            'banner' => $this->getBannerData($section),
            default => [],
        };
    }

    /**
     * Get categories data
     */
    private function getCategoriesData(HomeSection $section): array
    {
        $limit = $section->getSetting('limit', 6);
        $showAllLink = $section->getSetting('show_all_link', true);

        $categories = Category::with('children')
            ->active()
            ->root()
            ->ordered()
            ->take($limit)
            ->get();

        return [
            'categories' => $categories,
            'showAllLink' => $showAllLink,
        ];
    }

    /**
     * Get products data
     */
    private function getProductsData(HomeSection $section): array
    {
        $type = $section->getSetting('type', 'new');
        $limit = $section->getSetting('limit', 12);
        $categoryId = $section->getSetting('category_id');

        $query = Product::with(['category', 'images', 'variants'])->active();

        // Apply type filter
        switch ($type) {
            case 'new':
                $query->new();
                $viewAllLink = route('products.new');
                break;
            case 'bestseller':
                $query->orderBy('reviews_count', 'desc')->orderBy('rating', 'desc');
                $viewAllLink = route('products.index', ['sort' => 'bestseller']);
                break;
            case 'sale':
                $query->onSale();
                $viewAllLink = route('products.sale');
                break;
            case 'featured':
                $query->featured();
                $viewAllLink = route('products.featured');
                break;
            case 'category':
                if ($categoryId) {
                    $query->where('category_id', $categoryId);
                    $category = Category::find($categoryId);
                    $viewAllLink = $category ? route('categories.show', $category->slug) : route('products.index');
                } else {
                    $viewAllLink = route('products.index');
                }
                break;
            default:
                $viewAllLink = route('products.index');
        }

        $products = $query->take($limit)->get();

        return [
            'products' => $products,
            'viewAllLink' => $viewAllLink,
        ];
    }

    /**
     * Get banner data
     */
    private function getBannerData(HomeSection $section): array
    {
        $position = $section->getSetting('position', 'home_middle');

        $banner = Banner::published()
            ->position($position)
            ->ordered()
            ->first();

        return [
            'banner' => $banner,
        ];
    }

    /**
     * Display about page
     */
    public function about(): View
    {
        return view('pages.about');
    }

    /**
     * Display contact page
     */
    public function contact(): View
    {
        return view('pages.contact');
    }

    /**
     * Search products
     */
    public function search(): View
    {
        $query = request('q');

        $products = Product::with(['category', 'primaryImage', 'variants'])
            ->active()
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('short_description', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%")
                    ->orWhere('sku', 'like', "%{$query}%");
            })
            ->paginate(12)
            ->withQueryString();

        return view('search', compact('products', 'query'));
    }
}
