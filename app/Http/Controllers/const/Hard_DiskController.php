<?php

namespace App\Http\Controllers\const;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\itams_hard_disks;

class Hard_DiskController extends Controller
{
    public function index()
    {
        return view('const.hd.index')->with('hard_disks', itams_hard_disks::all());
    }

    public function create()
    {
        return view('const.hd.create');
    }

    public function store(Request $request)
    {
        $request -> validate([
            'kind' => ['required', 'string'],
            'size' => ['required', 'numeric'],
        ]);
        itams_hard_disks::create([
            'kind'=>$request -> Input('kind'),
            'size'=>$request -> Input('size'),
        ]);
        return redirect('const/hd') -> with('message', 'تم إضافة القرص الصلب بنجاح');
    }

    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
        return view('const.hd.edit')->with('hard_disks', itams_hard_disks::where('id', $id)->first());
    }

    public function update(Request $request, string $id)
    {
        $request -> validate([
            'kind' => 'required|string',
            'size' => 'required|numeric',
        ]);
        itams_hard_disks::where('id', $id)
            ->update([
                'kind'=>$request -> Input('kind'),
                'size'=>$request -> Input('size'),
            ]);
        return redirect('const/hd') -> with('message', 'تم التعديل على نوع القرص الصلب بنجاح');
    }

    public function destroy(string $id)
    {
        $po = itams_hard_disks::find($id);
        $po -> delete();
        return redirect('const/hd') -> with('message', 'تم حذف القرص الصلب بنجاح');
    }
}
