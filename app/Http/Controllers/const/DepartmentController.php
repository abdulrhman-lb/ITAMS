<?php

namespace App\Http\Controllers\const;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\departments;

class DepartmentController extends Controller
{
    public function index()
    {
        return view('const.department.index')->with('departments', departments::all());
    }

    public function create()
    {
        return view('const.department.create');
    }

    public function store(Request $request)
    {
        $request -> validate([
            'department' => ['required', 'string', 'unique:departments'],
            'department_en' => ['required', 'string', 'unique:departments'],
        ]);
        departments::create([
            'department'=>$request -> Input('department'),
            'department_en'=>$request -> Input('department_en'),
        ]);
        return redirect('const/department') -> with('message', 'تم إضافة القسم بنجاح');
    }

    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
        return view('const.department.edit')->with('departments', departments::where('id', $id)->first());
    }

    public function update(Request $request, string $id)
    {
        $request -> validate([
            'department' => 'required|string|unique:departments,department,' . $id,
            'department_en' => 'required|string|unique:departments,department_en,' . $id,
        ]);
        departments::where('id', $id)
            ->update([
                'department'=>$request -> Input('department'),
                'department_en'=>$request -> Input('department_en'),
            ]);
        return redirect('const/department') -> with('message', 'تم التعديل على القسم بنجاح');
    }

    public function destroy(string $id)
    {
        $departments = departments::findOrFail($id);
        if ($departments->canDelete()) {
            $departments -> delete();
            return redirect('const/department') -> with('message', 'تم حذف القسم بنجاح');
        } else {
            return redirect('const/department') -> with('message', 'لا يمكن حذف القسم لوجود موظفين مرتبطة , في حال رغبتك في حذف القسم يرجى حذف الموظفين المرتبطة ثم إعادة المحاولة');
        }
    }
}
