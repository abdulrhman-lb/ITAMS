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
use GuzzleHttp\Psr7\Query;
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
            $query = employees::select('employees.*', DB::raw('COUNT(DISTINCT devices.id) as devices_count'),)
                        ->leftJoin('devices', 'devices.employee_id', '=', 'employees.id')
                        ->groupBy('employees.id')
                        ->groupBy('employees.email')
                        ->groupBy('employees.phone')
                        ->groupBy('employees.mobile')
                        ->groupBy('employees.ena')
                        ->groupBy('employees.branch_id')
                        ->groupBy('employees.sub_branch_id')
                        ->groupBy('employees.department_id')
                        ->groupBy('employees.jop_title_id')
                        ->groupBy('employees.created_at')
                        ->groupBy('employees.updated_at')
                        ->groupBy('employees.full_name')
                        ->orderBy('branch_id' , 'ASC')
                        ->orderBy('ena' , 'desc');
            if ($request->input('branch_id')) {$query->where('employees.branch_id', $request->input('branch_id'));}
            if ($request->input('sub_branch_id')) {$query->where('employees.sub_branch_id', $request->input('sub_branch_id'));}
            if ($request->input('department_id')) {$query->where('employees.department_id', $request->input('department_id'));}
            if ($request->input('full_name')) {$query->where('employees.full_name', 'like' , '%'.$request->input('full_name').'%');}
            $par = ['branches' => branches::orderBy('branch' , 'ASC')->get(),
                    'sub_branches' => sub_branches::where('branch_id', $request->sub_branch_id)->orderBy('sub_branch' , 'ASC')->get(),
                    'departments' => departments::orderBy('department' , 'ASC')->get(),
                    'search_branch' => $request->branch_id,
                    'search_sub_branch' => $request->sub_branch_id,
                    'search_department' => $request->department_id,
                    'search_full_name' => $request->full_name,
                    'employees' => $query -> get()
                    ];
            return view('employee.index')->with('list', $par);
        } else {
            $query = employees::select('employees.*', DB::raw('COUNT(DISTINCT devices.id) as devices_count'),)
                    ->leftJoin('devices', 'devices.employee_id', '=', 'employees.id')
                    ->groupBy('employees.id')
                    ->groupBy('employees.email')
                    ->groupBy('employees.phone')
                    ->groupBy('employees.mobile')
                    ->groupBy('employees.ena')
                    ->groupBy('employees.branch_id')
                    ->groupBy('employees.sub_branch_id')
                    ->groupBy('employees.department_id')
                    ->groupBy('employees.jop_title_id')
                    ->groupBy('employees.created_at')
                    ->groupBy('employees.updated_at')
                    ->groupBy('employees.full_name')
                    ->where('employees.branch_id',Auth::user()->branch_id)
                    ->orderBy('branch_id' , 'ASC')
                    ->orderBy('ena' , 'desc');
            if ($request->input('branch_id')) {$query->where('employees.branch_id', $request->input('branch_id'));}
            if ($request->input('sub_branch_id')) {$query->where('employees.sub_branch_id', $request->input('sub_branch_id'));}
            if ($request->input('department_id')) {$query->where('employees.department_id', $request->input('department_id'));}
            if ($request->input('full_name')) {$query->where('employees.full_name', 'like' , '%'.$request->input('full_name').'%');}
            $par = ['branches' => branches::where('id', Auth::user()->branch_id)->orderBy('branch' , 'ASC')->get(),
                    'sub_branches' => sub_branches::where('branch_id', $request->sub_branch_id)->orderBy('sub_branch' , 'ASC')->get(),
                    'departments' => departments::orderBy('department' , 'ASC')->get(),
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
