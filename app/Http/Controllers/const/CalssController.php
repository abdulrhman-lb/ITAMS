<?php

namespace App\Http\Controllers\const;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\classes;
use App\Models\itams_classes;

class CalssController extends Controller
{

    public function index()
    {
        return view('const.class.index')->with('classes', itams_classes::all());
    }
    public function create()
    {
        return view('const.class.create');
    }
    public function store(Request $request)
    {
        $request -> validate([
            'class' => ['required', 'string', 'unique:itams_classes'],
        ]);
        itams_classes::create([
            'class'=>$request -> Input('class'),
        ]);
        return redirect('const/class') -> with('message', 'تم إضافة التصنيف بنجاح');
    }
    public function show(string $id)
    {
    }
    public function edit(string $id)
    {
        return view('const.class.edit')->with('classes', itams_classes::where('id', $id)->first());
    }
    public function update(Request $request, string $id)
    {
        $request -> validate([
            'class' => 'required|string|unique:itams_classes,class,' . $id,
        ]);
        itams_classes::where('id', $id)
            ->update([
                'class'=>$request -> Input('class'),
            ]);
        return redirect('const/class') -> with('message', 'تم التعديل على التصنيف بنجاح');
    }
    public function destroy(string $id)
    {
        $classes = itams_classes::findOrFail($id);
        if ($classes->canDelete()) {
            $classes -> delete();
            return redirect('const/class') -> with('message', 'تم حذف التصنيف بنجاح');
        } else {
            return redirect('const/class') -> with('message', 'لا يمكن حذف التصنيف لوجود أصناف مرتبطة , في حال رغبتك في حذف التصنيف يرجى حذف الأصناف المرتبطة ثم إعادة المحاولة');
        }
    }
}
