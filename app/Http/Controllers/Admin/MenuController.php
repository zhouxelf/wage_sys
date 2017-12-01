<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Node;

class MenuController extends Controller
{
    public function getMenu()
    {
        $nodes = new Node;
        return response()->json($nodes->getFormatMenu());
    }
}
