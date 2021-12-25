<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class FrontProductListController extends Controller
{
    public function index()
    {
        $products = Product::latest()
            ->limit(9)
            ->get();
        $randomActiveProducts = Product::inRandomOrder()
            ->limit(3)
            ->get();
        $randomActiveProductIds = [];

        foreach ($randomActiveProducts as $product) {
            array_push($randomActiveProductIds, $product->id);
        }

        $randomItemProducts = Product::whereNotIn("id", $randomActiveProductIds)
            ->limit(3)
            ->get();
        $sliders = Slider::get();

        return view(
            "product",
            compact(
                "products",
                "randomItemProducts",
                "randomActiveProducts",
                "sliders"
            )
        );
    }

    public function allProducts($name, Request $request)
    {
        $filterSubCategories = [];
        $category = Category::where("slug", $name)->first();
        $categoryId = $category->id;

        // if checked
        if ($request->subcategory) {
            $products = $this->filterProducts($request);
            $filterSubCategories = $this->getSubcategoriesId($request);
        } elseif ($request->min || $request->max) {
            $products = $this->filterByPrice($request);
        } else {
            $products = Product::where("category_id", $category->id)->get();
            // dd('else');
        }

        $subcategories = Subcategory::where(
            "category_id",
            $category->id
        )->get();
        $slug = $name;

        return view(
            "category",
            compact(
                "products",
                "subcategories",
                "slug",
                "filterSubCategories",
                "categoryId"
            )
        );
    }

    public function filterProducts(Request $request)
    {
        $subId = [];
        $subcategory = Subcategory::whereIn("id", $request->subcategory)->get();

        foreach ($subcategory as $sub) {
            array_push($subId, $sub->id);
        }

        $products = Product::whereIn("subcategory_id", $subId)->get();

        return $products;
    }

    public function filterByPrice(Request $request)
    {
        $categoryId = $request->categoryId;
        $product = Product::whereBetween("price", [
            $request->min,
            $request->max,
        ])
            ->where("category_id", $categoryId)
            ->get();

        return $product;
    }

    public function getSubcategoriesId(Request $request)
    {
        $subId = [];
        $subcategory = Subcategory::whereIn("id", $request->subcategory)->get();

        foreach ($subcategory as $sub) {
            array_push($subId, $sub->id);
        }

        return $subId;
    }

    public function show($id)
    {
        $product = Product::find($id);
        // get products in same category as current product that are not the same product
        $productFromSameCategories = Product::inRandomOrder()
            ->where("category_id", $product->category_id)
            ->where("id", "!=", $product->id)
            ->limit(3)
            ->get();

        // categories = laptops, books, phones
        // subcategories = brands
        // products = single product

        return view("show", compact("product", "productFromSameCategories"));
    }

    public function moreProducts(Request $request)
    {
        // Search
        if ($request->search) {
            $products = Product::where(
                "name",
                "like",
                "%" . $request->search . "%"
            )
                ->orWhere("description", "like", "%" . $request->search . "%")
                ->orWhere(
                    "additional_info",
                    "like",
                    "%" . $request->search . "%"
                )
                ->paginate(50);

            return view("all-products", compact("products"));
        }

        $products = Product::latest()->paginate(2);

        return view("all-products", compact("products"))->with(
            request()->input("page")
        );
    }
}
