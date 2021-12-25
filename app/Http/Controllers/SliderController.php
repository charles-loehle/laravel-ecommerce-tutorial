<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::get();

        return view("admin.slider.index", compact("sliders"));
    }

    public function create()
    {
        return view("admin.slider.create");
    }

    public function store(Request $request)
    {
        // dd($request->file("image"));
        $this->validate($request, [
            "image" => "required|mimes:jpeg,jpg,png",
        ]);

        $image = $request->file("image")->store("public/slider");
        Slider::create([
            "image" => $image,
        ]);

        notify()->success("Image uploaded successfully");
        return redirect()->back();
    }

    public function destroy($id)
    {
        Slider::find($id)->delete();

        notify()->success("Image deleted successfully");
        return redirect()->back();
    }
}
