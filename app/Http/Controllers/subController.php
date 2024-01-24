<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\itams_sub_branches;
use App\Models\itams_categories;
use App\Models\itams_models;
// use App\Models\devices;

class subController extends Controller
{
    public function getsub(Request $request)
    {
        $branchId = $request->id;
        $sub_branches = itams_sub_branches::where('branch_id', $branchId)->get();
        return response()->json($sub_branches);
    }

    public function getcategory(Request $request)
    {
        $classId = $request->id;
        $categories = itams_categories::where('class_id', $classId)->get();
        return response()->json($categories);
    }

    public function getmodel(Request $request)
    {
        $categoryId = $request->id;
        $models = itams_models::where('category_id', $categoryId)->get();
        return response()->json($models);
    }

    // public function devicesearch(Request $request)
    // {
    //     $branch_id = $request->id;
    //     $results = devices::where('branch_id', $branch_id);
    //     return view('device.index', compact('results'));
    // }
}
