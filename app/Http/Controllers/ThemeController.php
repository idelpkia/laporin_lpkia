<?php

namespace App\Http\Controllers;

use App\Services\SettingService;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function generateCSS()
    {
        $css = ":root { ";
        foreach (SettingService::getCSSColors() as $prop => $val) {
            $css .= "$prop: $val; ";
        }
        $css .= "}";

        file_put_contents(public_path('css/custom-theme.css'), $css);

        return response()->json(['success' => true]);
    }
}
