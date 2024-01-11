<?php

namespace App\Http\Controllers\const;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\memories;

class MemoryController extends Controller
{
    public function index()
    {
        return view('const.mem.index')->with('memories', memories::all());
    }

    public function create()
    {
        return view('const.mem.create');
    }

    public function store(Request $request)
    {
        $request -> validate([
            'kind' => ['required', 'string'],
            'size' => ['required', 'numeric'],
        ]);
        memories::create([
            'kind'=>$request -> Input('kind'),
            'size'=>$request -> Input('size'),
        ]);
        return redirect('const/mem') -> with('message', 'تم إضافة الذاكرة بنجاح');
    }

    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
        return view('const.mem.edit')->with('memories', memories::where('id', $id)->first());
    }

    public function update(Request $request, string $id)
    {
        $request -> validate([
            'kind' => 'required|string',
            'size' => 'required|numeric',
        ]);
        memories::where('id', $id)
            ->update([
                'kind'=>$request -> Input('kind'),
                'size'=>$request -> Input('size'),
            ]);
        return redirect('const/mem') -> with('message', 'تم التعديل على نوع الذاكرة بنجاح');
    }

    public function destroy(string $id)
    {
        $po = memories::find($id);
        $po -> delete();
        return redirect('const/mem') -> with('message', 'تم حذف الذاكرة بنجاح');
    }
}
