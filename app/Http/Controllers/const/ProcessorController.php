<?php

namespace App\Http\Controllers\const;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\processors;

class ProcessorController extends Controller
{
    public function index()
    {
        return view('const.cpu.index')->with('processors', processors::all());
    }

    public function create()
    {
        return view('const.cpu.create');
    }

    public function store(Request $request)
    {
        $request -> validate([
            'processor' => ['required', 'string', 'unique:processors'],
        ]);
        processors::create([
            'processor'=>$request -> Input('processor'),
        ]);
        return redirect('const/cpu') -> with('message', 'تم إضافة المعالج بنجاح');
    }

    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
        return view('const.cpu.edit')->with('processors', processors::where('id', $id)->first());
    }

    public function update(Request $request, string $id)
    {
        $request -> validate([
            'processor' => 'required|string|unique:processors,processor,' . $id,
        ]);
        processors::where('id', $id)
            ->update([
                'processor'=>$request -> Input('processor'),
            ]);
        return redirect('const/cpu') -> with('message', 'تم التعديل على المعالج بنجاح');
    }

    public function destroy(string $id)
    {
        $po = processors::find($id);
        $po -> delete();
        return redirect('const/cpu') -> with('message', 'تم حذف المعالج بنجاح');
    }
}
