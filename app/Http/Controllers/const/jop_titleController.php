<?php

namespace App\Http\Controllers\const;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\jop_titles;

class jop_titleController extends Controller
{
    public function index()
    {
        return view('const.title.index')->with('jop_titles', jop_titles::all());
    }

    public function create()
    {
        return view('const.title.create');
    }

    public function store(Request $request)
    {
        $request -> validate([
            'jop_title' => ['required', 'string', 'unique:jop_titles'],
        ]);
        jop_titles::create([
            'jop_title'=>$request -> Input('jop_title'),
        ]);
        return redirect('const/title') -> with('message', 'تم إضافة التوصيف الوظيفي بنجاح');
    }

    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
        return view('const.title.edit')->with('jop_titles', jop_titles::where('id', $id)->first());
    }

    public function update(Request $request, string $id)
    {
        $request -> validate([
            'jop_title' => 'required|string|unique:jop_titles,jop_title,' . $id,
        ]);
        jop_titles::where('id', $id)
            ->update([
                'jop_title'=>$request -> Input('jop_title'),
            ]);
        return redirect('const/title') -> with('message', 'تم التعديل على التوصيف الوظيفي بنجاح');
    }

    public function destroy(string $id)
    {
        $jop_titles = jop_titles::findOrFail($id);
        if ($jop_titles->canDelete()) {
            $jop_titles -> delete();
            return redirect('const/title') -> with('message', 'تم حذف التوصيف الوظيفي بنجاح');
        } else {
            return redirect('const/title') -> with('message', 'لا يمكن حذف التوصيف الظيفي لوجود موظفين مرتبطة , في حال رغبتك في حذف التوصيف الوظيفي يرجى حذف الموظفين المرتبطة ثم إعادة المحاولة');
        }
    }
}
