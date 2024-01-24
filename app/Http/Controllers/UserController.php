<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\itamsUser;
use App\Models\branches;
use App\Models\itams_branches;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index')->with('User', itamsUser::orderBy('active' , 'desc')->orderBy('role' , 'desc')->orderBy('branch_id' , 'asc')->get());
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
        $par = ['branches' => itams_branches::orderBy('branch' , 'ASC')->get(),
                'User' =>  itamsUser::where('id', $id)->first(),
                ];
        return view('user.edit')->with('list', $par);
    }

    public function update(Request $request, string $id)
    {
        $test = itamsUser::where('id', $id)->get();
        if (is_null($request -> input('password'))) {
            $request -> validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:itams_users,email,' . $id],
            ]);
            itamsUser::where('id', $id)
            ->update([
                'name'=>$request -> Input('name'),
                'email'=>$request -> Input('email'),
                'role'=>$request -> Input('role'),
                'active'=>$request -> Input('active'),
                'branch_id'=>$request -> Input('branch_id'),
            ]);
        }
        else {
            $request -> validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:itams_users,email,' . $id],
                'passwordd' => ['string', 'min:8'],
            ]);
            itamsUser::where('id', $id)
            ->update([
                'name'=>$request -> Input('name'),
                'email'=>$request -> Input('email'),
                'role'=>$request -> Input('role'),
                'active'=>$request -> Input('active'),
                'branch_id'=>$request -> Input('branch_id'),
                'password'=>Hash::make($request -> Input('passwordd')),
            ]);
        }

        return redirect('user') -> with('message', 'تم التعديل على الفرع بنجاح');
    }

    public function destroy(string $id)
    {
    }
}
