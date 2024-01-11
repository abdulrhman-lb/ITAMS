<?php

namespace App\Http\Controllers\const;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\branches;

class BranchController extends Controller
{
    public function index()
    {
        return view('const.branch.index')->with('branches', branches::all());
    }

    public function create()
    {
        return view('const.branch.create');
    }

    public function store(Request $request)
    {
        $request -> validate([
            'branch' => ['required', 'string', 'unique:branches'],
            'branch_en' => ['required', 'string', 'unique:branches'],
        ]);
        branches::create([
            'branch'=>$request -> Input('branch'),
            'branch_en'=>$request -> Input('branch_en'),
        ]);
        return redirect('const/branch') -> with('message', 'تم إضافة الفرع بنجاح');
    }

    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
        return view('const.branch.edit')->with('branches', branches::where('id', $id)->first());
    }

    public function update(Request $request, string $id)
    {
        $request -> validate([
            'branch' => 'required|string|unique:branches,branch,' . $id,
            'branch_en' => 'required|string|unique:branches,branch_en,' . $id,
        ]);
        branches::where('id', $id)
            ->update([
                'branch'=>$request -> Input('branch'),
                'branch_en'=>$request -> Input('branch_en'),
            ]);
        return redirect('const/branch') -> with('message', 'تم التعديل على الفرع بنجاح');
    }

    public function destroy(string $id)
    {
        $branches = branches::findOrFail($id);
        if ($branches->canDelete()) {
            $branches -> delete();
            return redirect('const/branch') -> with('message', 'تم حذف الفرع بنجاح');
        } else {
            return redirect('const/branch') -> with('message', 'لا يمكن حذف الفرع لوجود شعب مرتبطة , في حال رغبتك في حذف الفرع يرجى حذف الشعب المرتبطة ثم إعادة المحاولة');
        }
    }
}
