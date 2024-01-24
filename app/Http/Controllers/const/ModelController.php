<?php

namespace App\Http\Controllers\const;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\itams_models;
use App\Models\itams_categories;

class ModelController extends Controller
{
    public function index()
    {
        return view('const.model.index')->with('models', itams_models::orderBy('category_id' , 'ASC')->get());
    }

    public function create()
    {
        return view('const.model.create')->with('categories', itams_categories::get());
    }

    public function store(Request $request)
    {
        $request -> validate([
            'category_id' => ['required'],
            'model' => ['required', 'string', 'unique:itams_models'],
        ]);
        $slug = Str::slug($request->model, '-');
        if (is_null($request -> image)) {
            $NewImageName = '';
        } else {
            $NewImageName =$slug . '.' . $request->image->extension();
            $request -> image ->move(public_path('images/model'), $NewImageName);
        };
        itams_models::create([
            'category_id'=>$request -> Input('category_id'),
            'model'=>$request -> Input('model'),
            'image' => $NewImageName
        ]);
        return redirect('const/model') -> with('message', 'تم إضافة الموديل بنجاح');
    }

    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
        $par = ['categories' => itams_categories::orderBy('category' , 'ASC')->get(),
                'models' => itams_models::where('id', $id)->first()];
        return view('const.model.edit')->with('list', $par);
    }

    public function update(Request $request, string $id)
    {
        $request -> validate([
            'model' => 'required|string|unique:itams_models,model,' . $id,
            'category_id' => 'required',
        ]);
        $slug = Str::slug($request->model, '-');
        if (is_null($request -> image)) {
            itams_models::where('id', $id)
                ->update([
                    'model' => $request -> input('model'),
                    'category_id' => $request -> input('category_id'),
                ]);
        }
        else {
            $NewImageName =$slug . '.' . $request->image->extension();
            $request -> image ->move(public_path('images/model'), $NewImageName);
            itams_models::where('id', $id)
            ->update([
                'model' => $request -> input('model'),
                'category_id' => $request -> input('category_id'),
                'image' => $NewImageName
            ]);
            
        }
        return redirect('const/model') -> with('message', 'تم التعديل على الموديل بنجاح');
    }

    public function destroy(string $id)
    {
        $po = itams_models::find($id);
        $po -> delete();
        return redirect('const/model') -> with('message', 'تم حذف الموديل بنجاح');
    }
}
