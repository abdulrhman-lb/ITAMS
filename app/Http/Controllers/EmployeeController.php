<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\itams_employees;
use App\Models\itams_branches;
use App\Models\itams_dates;
use App\Models\itams_sub_branches;
use App\Models\itams_departments;
use App\Models\itams_devices;
use App\Models\itams_jop_titles;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('clear')) {
            // إعادة تعيين القيم إلى الحالة الافتراضية
            $request->replace([
                'branch_id' => null,
                'sub_branch_id' => null,
                'department_id' => null,
                'full_name' => null,
                ]);
            }
        if (Auth::user()->role == '1') {
            $query = itams_employees::select('itams_employees.*', DB::raw('COUNT(DISTINCT itams_devices.id) as devices_count'),)
                        ->leftJoin('itams_devices', 'itams_devices.employee_id', '=', 'itams_employees.id')
                        ->groupBy('itams_employees.id')
                        ->groupBy('itams_employees.email')
                        ->groupBy('itams_employees.phone')
                        ->groupBy('itams_employees.mobile')
                        ->groupBy('itams_employees.ena')
                        ->groupBy('itams_employees.branch_id')
                        ->groupBy('itams_employees.sub_branch_id')
                        ->groupBy('itams_employees.department_id')
                        ->groupBy('itams_employees.jop_title_id')
                        ->groupBy('itams_employees.created_at')
                        ->groupBy('itams_employees.updated_at')
                        ->groupBy('itams_employees.full_name')
                        ->orderBy('branch_id' , 'ASC')
                        ->orderBy('ena' , 'desc');
            if ($request->input('branch_id')) {$query->where('itams_employees.branch_id', $request->input('branch_id'));}
            if ($request->input('sub_branch_id')) {$query->where('itams_employees.sub_branch_id', $request->input('sub_branch_id'));}
            if ($request->input('department_id')) {$query->where('itams_employees.department_id', $request->input('department_id'));}
            if ($request->input('full_name')) {$query->where('itams_employees.full_name', 'like' , '%'.$request->input('full_name').'%');}
            $par = ['branches' => itams_branches::orderBy('branch' , 'ASC')->get(),
                    'sub_branches' => itams_sub_branches::where('branch_id', $request->sub_branch_id)->orderBy('sub_branch' , 'ASC')->get(),
                    'departments' => itams_departments::orderBy('department' , 'ASC')->get(),
                    'search_branch' => $request->branch_id,
                    'search_sub_branch' => $request->sub_branch_id,
                    'search_department' => $request->department_id,
                    'search_full_name' => $request->full_name,
                    'employees' => $query -> get()
                    ];
            return view('employee.index')->with('list', $par);
        } else {
            $query = itams_employees::select('itams_employees.*', DB::raw('COUNT(DISTINCT itams_devices.id) as devices_count'),)
                    ->leftJoin('itams_devices', 'itams_devices.employee_id', '=', 'itams_employees.id')
                    ->groupBy('itams_employees.id')
                    ->groupBy('itams_employees.email')
                    ->groupBy('itams_employees.phone')
                    ->groupBy('itams_employees.mobile')
                    ->groupBy('itams_employees.ena')
                    ->groupBy('itams_employees.branch_id')
                    ->groupBy('itams_employees.sub_branch_id')
                    ->groupBy('itams_employees.department_id')
                    ->groupBy('itams_employees.jop_title_id')
                    ->groupBy('itams_employees.created_at')
                    ->groupBy('itams_employees.updated_at')
                    ->groupBy('itams_employees.full_name')
                    ->where('itams_employees.branch_id',Auth::user()->branch_id)
                    ->orderBy('branch_id' , 'ASC')
                    ->orderBy('ena' , 'desc');
            if ($request->input('branch_id')) {$query->where('itams_employees.branch_id', $request->input('branch_id'));}
            if ($request->input('sub_branch_id')) {$query->where('itams_employees.sub_branch_id', $request->input('sub_branch_id'));}
            if ($request->input('department_id')) {$query->where('itams_employees.department_id', $request->input('department_id'));}
            if ($request->input('full_name')) {$query->where('itams_employees.full_name', 'like' , '%'.$request->input('full_name').'%');}
            $par = ['branches' => itams_branches::where('id', Auth::user()->branch_id)->orderBy('branch' , 'ASC')->get(),
                    'sub_branches' => itams_sub_branches::where('branch_id', $request->sub_branch_id)->orderBy('sub_branch' , 'ASC')->get(),
                    'departments' => itams_departments::orderBy('department' , 'ASC')->get(),
                    'search_branch' => $request->branch_id,
                    'search_sub_branch' => $request->sub_branch_id,
                    'search_department' => $request->department_id,
                    'search_full_name' => $request->full_name,
                    'employees' => $query -> get()
                    ];
            return view('employee.index')->with('list', $par);
        }
    }

    public function create()
    {
        if (Auth::user()->role == '1') {
            $par = ['branches' => itams_branches::orderBy('branch' , 'ASC')->get(),
                    'departments' => itams_departments::orderBy('department' , 'ASC')->get(),
                    'jop_titles' => itams_jop_titles::orderBy('jop_title' , 'ASC')->get(),
                    ];
        } else {
            $par = ['branches' => itams_branches::where('id',Auth::user()->branch_id)->get(),
                    'departments' => itams_departments::orderBy('department' , 'ASC')->get(),
                    'jop_titles' => itams_jop_titles::orderBy('jop_title' , 'ASC')->get(),
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
            'mobile' => ['required', 'digits:10', 'unique:itams_employees'],
            'phone' => ['digits:10'],
            'email' => ['required', 'email', 'unique:itams_employees'],
            'jop_title_id' => ['required', 'min_digits:1'],
        ]);
        itams_employees::create([
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

        $test = itams_employees::where('id', $id)->first();
        if (Auth::user()->role == '1') {
            $par = ['branches' => itams_branches::orderBy('branch' , 'ASC')->get(),
                    'sub_branches' => itams_sub_branches::where('branch_id',$test->branch_id)->orderBy('sub_branch' , 'ASC')->get(),
                    'departments' => itams_departments::orderBy('department' , 'ASC')->get(),
                    'jop_titles' => itams_jop_titles::orderBy('jop_title' , 'ASC')->get(),
                    'employees' => itams_employees::where('id', $id)->first()
                    ];
            return view('employee.edit')->with('list', $par);
        } else {
            if ($test->branch_id == Auth::user()->branch_id) {
                $par = ['branches' => itams_branches::where('id',Auth::user()->branch_id)->get(),
                        'sub_branches' => itams_sub_branches::where('branch_id',$test->branch_id)->orderBy('sub_branch' , 'ASC')->get(),
                        'departments' => itams_departments::orderBy('department' , 'ASC')->get(),
                        'jop_titles' => itams_jop_titles::orderBy('jop_title' , 'ASC')->get(),
                        'employees' => itams_employees::where('id', $id)->first()
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
            'mobile' => ['required', 'digits:10', 'unique:itams_employees,mobile,' . $id],
            'phone' => ['digits:10'],
            'email' => ['required', 'email', 'unique:itams_employees,email,' . $id],
            'jop_title_id' => ['required', 'min_digits:1'],
        ]);
        $employee = itams_employees::where('id', $id)->first();
        if (!($employee -> branch_id == $request -> Input('branch_id'))) {
            $devices = itams_devices::where('employee_id', $employee -> id)->get();
            foreach ($devices as $key => $device) {
                //تعديل الفرع في جدول الأجهزة
                $device -> update([
                    'branch_id' => $request -> Input('branch_id')
                ]);

                //اغلاق الاستلام في جدول الاستلام والتسليم
                itams_dates::where('employee_id', $employee -> id)->where('device_id', $device->id)->where('end_date', Null)
                    -> update([
                        'end_date'=> now()
                    ]);
                
                //فتح استلام جديد حسب الفرع الجديد
                itams_dates::create(['start_date'=> now(),
                                'branch_id'=> $request ->Input('branch_id'),
                                'sub_branch_id'=> $request -> Input('sub_branch_id'),
                                'department_id'=> $request -> Input('department_id'),
                                'employee_id'=> $employee -> id,
                                'device_id'=> $device -> id,
                                ]);
            }
        }
        itams_employees::where('id', $id)
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
        $employees = itams_employees::findOrFail($id);
        if (!$employees->canDelete()) {
            return redirect('employee') -> with('message', 'لا يمكن حذف الموظف لوجود أجهزة على عهدته');
        } else {
            $dates = itams_dates::where('employee_id', $id)->get();
            if ($dates->isEmpty()) {
                $employees -> delete();
                return redirect('employee') -> with('message', 'تم حذف الموظف بنجاح');
            } else {
                return redirect('employee') -> with('message', 'لا يمكن حذف الموظف لوجود حركات استلام وتسليم له');
            }
        }
    }
}

