<?php

namespace App\Http\Controllers\const;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\statuses;

class StatusController extends Controller
{
    public function index()
    {
        return view('const.status.index')->with('statuses', statuses::all());
    }

    public function create()
    {
        return view('const.status.create');
    }

    public function store(Request $request)
    {
        $request -> validate([
            'status' => ['required', 'string', 'unique:statuses'],
        ]);
        statuses::create([
            'status'=>$request -> Input('status'),
        ]);
        return redirect('const/status') -> with('message', 'تم إضافة الحالة الفنية بنجاح');
    }

    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
        return view('const.status.edit')->with('statuses', statuses::where('id', $id)->first());
    }

    public function update(Request $request, string $id)
    {
        $request -> validate([
            'status' => 'required|string|unique:statuses,status,' . $id,
        ]);
        statuses::where('id', $id)
            ->update([
                'status'=>$request -> Input('status'),
            ]);
        return redirect('const/status') -> with('message', 'تم التعديل على الحالة الفنية بنجاح');
    }

    public function destroy(string $id)
    {
        $statuses = statuses::findOrFail($id);
        if ($statuses->canDelete()) {
            $statuses -> delete();
            return redirect('const/status') -> with('message', 'تم حذف الحالة الفنية بنجاح');
        } else {
            return redirect('const/status') -> with('message', 'لا يمكن حذف الحالة الفنية لوجود أجهزة مرتبطة , في حال رغبتك في حذف الحالة الفنية يرجى حذف الأجهزة المرتبطة ثم إعادة المحاولة');
        }
    }
}
