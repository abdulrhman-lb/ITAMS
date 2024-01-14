<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\employees;
use App\Models\branches;
use App\Models\dates;
use App\Models\sub_branches;
use App\Models\departments;
use App\Models\devices;
use App\Models\jop_titles;
use Illuminate\Support\Facades\Date;

class EmployeeController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == '1') {
            return view('employee.index')->with('employees', employees::orderBy('branch_id' , 'ASC')->orderBy('ena' , 'desc')->get(),);
        } else {
            return view('employee.index')->with('employees', employees::where('branch_id',Auth::user()->branch_id)->orderBy('ena' , 'desc')->get());
        }
    }

    public function create()
    {
        if (Auth::user()->role == '1') {
            $par = ['branches' => branches::orderBy('branch' , 'ASC')->get(),
                    'departments' => departments::orderBy('department' , 'ASC')->get(),
                    'jop_titles' => jop_titles::orderBy('jop_title' , 'ASC')->get(),
                    ];
        } else {
            $par = ['branches' => branches::where('id',Auth::user()->branch_id)->get(),
                    'departments' => departments::orderBy('department' , 'ASC')->get(),
                    'jop_titles' => jop_titles::orderBy('jop_title' , 'ASC')->get(),
                    ];
        }
        return view('employee.create')->with('list' , $par);
    }

    public function store(Request $request)
    {
        $request -> validate([
            'branch_id' => ['required', 'min_digits:1'],
            'sub_branch_id' => ['required', 'min_digits:1'],
            'department_id' => ['required', 'min_digits:1'],
            'full_name' => ['required', 'string'],
            'mobile' => ['required', 'digits:10', 'unique:employees'],
            'phone' => ['digits:10'],
            'email' => ['required', 'email', 'unique:employees'],
            'jop_title_id' => ['required', 'min_digits:1'],
        ]);
        employees::create([
            'branch_id'=>$request -> Input('branch_id'),
            'sub_branch_id'=>$request -> Input('sub_branch_id'),
            'department_id'=>$request -> Input('department_id'),
            'full_name'=>$request -> Input('full_name'),
            'mobile'=>$request -> Input('mobile'),
            'phone'=>$request -> Input('phone'),
            'email'=>$request -> Input('email'),
            'jop_title_id'=>$request -> Input('jop_title_id'),
            'ena'=>$request -> Input('ena'),
        ]);
        return redirect('employee') -> with('message', 'تم إضافة الموظف بنجاح');
    }

    public function show(string $id)
    {
    }

    public function edit(string $id)
    {

        $test = employees::where('id', $id)->first();
        if (Auth::user()->role == '1') {
            $par = ['branches' => branches::orderBy('branch' , 'ASC')->get(),
                    'sub_branches' => sub_branches::where('branch_id',$test->branch_id)->orderBy('sub_branch' , 'ASC')->get(),
                    'departments' => departments::orderBy('department' , 'ASC')->get(),
                    'jop_titles' => jop_titles::orderBy('jop_title' , 'ASC')->get(),
                    'employees' => employees::where('id', $id)->first()
                    ];
            return view('employee.edit')->with('list', $par);
        } else {
            if ($test->branch_id == Auth::user()->branch_id) {
                $par = ['branches' => branches::where('id',Auth::user()->branch_id)->get(),
                        'sub_branches' => sub_branches::where('branch_id',$test->branch_id)->orderBy('sub_branch' , 'ASC')->get(),
                        'departments' => departments::orderBy('department' , 'ASC')->get(),
                        'jop_titles' => jop_titles::orderBy('jop_title' , 'ASC')->get(),
                        'employees' => employees::where('id', $id)->first()
                        ];
                return view('employee.edit')->with('list', $par);
            } else {
                return redirect('employee') -> with('message', 'هذه الصفحة لموظف من فرع آخر ليس لديك صلاحيات لعرضها');
            }
        }
    }

    public function update(Request $request, string $id)
    {
        $request -> validate([
            'branch_id' => ['required', 'min_digits:1'],
            'sub_branch_id' => ['required', 'min_digits:1'],
            'department_id' => ['required', 'min_digits:1'],
            'full_name' => ['required', 'string'],
            'mobile' => ['required', 'digits:10', 'unique:employees,mobile,' . $id],
            'phone' => ['digits:10'],
            'email' => ['required', 'email', 'unique:employees,email,' . $id],
            'jop_title_id' => ['required', 'min_digits:1'],
        ]);
        $employee = employees::where('id', $id)->first();
        if (!($employee -> branch_id == $request -> Input('branch_id'))) {
            $devices = devices::where('employee_id', $employee -> id)->get();
            foreach ($devices as $key => $device) {
                //تعديل الفرع في جدول الأجهزة
                $device -> update([
                    'branch_id' => $request -> Input('branch_id')
                ]);

                //اغلاق الاستلام في جدول الاستلام والتسليم
                dates::where('employee_id', $employee -> id)->where('device_id', $device->id)->where('end_date', Null)
                    -> update([
                        'end_date'=> now()
                    ]);
                
                //فتح استلام جديد حسب الفرع الجديد
                dates::create(['start_date'=> now(),
                                'branch_id'=> $request ->Input('branch_id'),
                                'sub_branch_id'=> $request -> Input('sub_branch_id'),
                                'department_id'=> $request -> Input('department_id'),
                                'employee_id'=> $employee -> id,
                                'device_id'=> $device -> id,
                                ]);
            }
        }
        employees::where('id', $id)
            ->update([
            'branch_id'=>$request -> Input('branch_id'),
            'sub_branch_id'=>$request -> Input('sub_branch_id'),
            'department_id'=>$request -> Input('department_id'),
            'full_name'=>$request -> Input('full_name'),
            'mobile'=>$request -> Input('mobile'),
            'phone'=>$request -> Input('phone'),
            'email'=>$request -> Input('email'),
            'jop_title_id'=>$request -> Input('jop_title_id'),
            'ena'=>$request -> Input('ena'),
        ]);
       
        return redirect('employee') -> with('message', 'تم التعديل على الموظف بنجاح');
    }

    public function destroy(string $id)
    {
        $po = employees::find($id);
        $po -> delete();
        return redirect('employee') -> with('message', 'تم حذف الموظف بنجاح');
    }
}
