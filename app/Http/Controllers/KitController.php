<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KitController extends Controller
{
    public function show()
    {
        $kitResources = json_decode(
            file_get_contents(app_path('shippingkit.json'))
        );

        return view('kit.show', compact('kitResources'));
    }
}
