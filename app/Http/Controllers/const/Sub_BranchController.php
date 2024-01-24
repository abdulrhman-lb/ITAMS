<?php

namespace App\Http\Controllers\const;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\itams_sub_branches;
use App\Models\itams_branches;

class Sub_BranchController extends Controller
{
    public function index()
    {
        return view('const.sub.index')->with('sub_branches', itams_sub_branches::orderBy('branch_id' , 'ASC')->get());
    }

    public function create()
    {
        return view('const.sub.create')->with('branches', itams_branches::get());
    }

    public function store(Request $request)
    {
        $request -> validate([
            'branch_id' => ['required'],
            'sub_branch' => ['required', 'string', 'unique:itams_sub_branches'],
            'sub_branch_en' => ['required', 'string', 'unique:itams_sub_branches'],
        ]);
        itams_sub_branches::create([
            'branch_id'=>$request -> Input('branch_id'),
            'sub_branch'=>$request -> Input('sub_branch'),
            'sub_branch_en'=>$request -> Input('sub_branch_en'),
        ]);
        return redirect('const/sub') -> with('message', 'تم إضافة الشعبة بنجاح');
    }

    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
        $par = ['branches' => itams_branches::orderBy('branch' , 'ASC')->get(),
                'sub_branches' => itams_sub_branches::where('id', $id)->first()];
        return view('const.sub.edit')->with('list', $par);
    }

    public function update(Request $request, string $id)
    {
        $request -> validate([
            'branch_id' => 'required',
            'sub_branch' => 'required|string|unique:itams_sub_branches,sub_branch,' . $id,
            'sub_branch_en' => 'required|string|unique:itams_sub_branches,sub_branch_en,' . $id,
        ]);
        itams_sub_branches::where('id', $id)
            ->update([
                'branch_id' => $request -> input('branch_id'),
                'sub_branch' => $request -> input('sub_branch'),
                'sub_branch_en' => $request -> input('sub_branch_en'),

            ]);
        return redirect('const/sub') -> with('message', 'تم التعديل على الشعبة بنجاح');
    }

    public function destroy(string $id)
    { 
        $sub_branches = itams_sub_branches::findOrFail($id);
        if ($sub_branches->canDelete()) {
            $sub_branches -> delete();
            return redirect('const/sub') -> with('message', 'تم حذف الشعبة بنجاح');
        } else {
            return redirect('const/sub') -> with('message', 'لا يمكن حذف الشعبة لوجود موظفين مرتبطة , في حال رغبتك في حذف الشعبة يرجى حذف الموظفين المرتبطة ثم إعادة المحاولة');
        }
    }
}
