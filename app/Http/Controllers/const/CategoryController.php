<?php

namespace App\Http\Controllers\const;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\categories;
use App\Models\classes;

class CategoryController extends Controller
{
    public function index()
    {
        return view('const.category.index')->with('categories', categories::orderBy('class_id' , 'ASC')->get());
    }

    public function create()
    {
        return view('const.category.create')->with('classes', classes::get());
    }

    public function store(Request $request)
    {
        $request -> validate([
            'class_id' => ['required'],
            'category' => ['required', 'string', 'unique:categories'],
        ]);
        categories::create([
            'class_id'=>$request -> Input('class_id'),
            'category'=>$request -> Input('category'),
        ]);
        return redirect('const/category') -> with('message', 'تم إضافة الصنف بنجاح');
    }

    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
        $par = ['classes' => classes::orderBy('class' , 'ASC')->get(),
                'categories' => categories::where('id', $id)->first()];
        return view('const.category.edit')->with('list', $par);
    }

    public function update(Request $request, string $id)
    {
        $request -> validate([
            'category' => 'required|string|unique:classes,class,' . $id,
            'class_id' => 'required',
        ]);
        categories::where('id', $id)
            ->update([
                'category' => $request -> input('category'),
                'class_id' => $request -> input('class_id'),

            ]);
        return redirect('const/category') -> with('message', 'تم التعديل على الصنف بنجاح');
    } 

    public function destroy(string $id)
    {
        $categories = categories::findOrFail($id);
        if ($categories->canDelete()) {
            $categories -> delete();
            return redirect('const/category') -> with('message', 'تم حذف الصنف بنجاح');
        } else {
            return redirect('const/category') -> with('message', 'لا يمكن حذف الصنف لوجود موديلات مرتبطة , في حال رغبتك في حذف الصنف يرجى حذف الموديلات المرتبطة ثم إعادة المحاولة');
        }

        $po = categories::find($id);
        $po -> delete();
        return redirect('const/category') -> with('message', 'تم حذف الصنف بنجاح');
    }
}
