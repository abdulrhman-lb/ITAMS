<?php

namespace App\Http\Controllers;

use App\Models\dates;
use App\Models\devices;
use App\Models\employees;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportDates;
use Illuminate\Support\Facades\Auth;

class DatesController extends Controller
{
    public function index(Request $request)
    {
        $employee = employees::query(); 
        if (Auth::user()->role == '0') {$employee->where('branch_id', $request->branch_id);}
        $par = ['dates' => Dates::where('device_id',$request -> id)->orderBy('start_date' , 'ASC')->orderBy('id' , 'ASC')->get(),
                'devices' => devices::where('id',$request -> id)->first(),
                'employees' => $employee -> get()
                ];
        return view('dates.index')->with('list' , $par);
    }

    public function index_add(Request $request)
    {
        $request -> validate([
            'employee_id' => ['required', 'min_digits:1'],
        ]);
        $devices = devices::where('id',$request -> device_id)->first();
        $employees = employees::where('id',$request -> employee_id)->first();
        $dates = Dates::where('device_id',$request -> device_id)->where('end_date', null)->orderBy('start_date' , 'desc')->first();

        if (is_null($devices -> employee)) {
            $priev = null;
        } else {
            $priev = $devices -> employee -> full_name;
        }
        $next = $employees -> full_name;
        if (is_null($priev)) {
            $message = 'تم تسليم الجهاز للموظف ' . $next;
        } else {
            $message = 'تم نقل الجهاز من الموظف ' . $priev . ' إلى الموظف ' . $next;
        }
        //تسجيل تاريخ انتاء التسليم للموظف السابق
        if (!is_null($dates)) {
            $dates -> update(['end_date'=> now()]);
        };
        //انشاء سجل استلام جديد للموظف الحالي
        Dates::create(['start_date'=> now(),
                        'branch_id'=> $employees -> branch_id,
                        'sub_branch_id'=> $employees -> sub_branch_id,
                        'department_id'=> $employees -> department_id,
                        'employee_id'=> $employees -> id,
                        'device_id'=> $devices -> id,
                        ]);
        //تحديث بيانات جدول الجهاز
        $devices -> update([
            'employee_id'=> $employees -> id,
            'branch_id'=> $employees -> branch_id,
        ]);


        
        // $par = ['dates' => Dates::where('device_id',$request -> device_id)->orderBy('start_date' , 'ASC')->get(),
        //         'devices' => devices::where('id',$request -> device_id)->first(),
        //         'employees' => employees::orderby('full_name', 'ASC')->get(),
        //         'message' => 'تم نقل الجهاز من الموظف ' . $priev . ' إلى الموظف ' . $next,
        //         ];
        $request->replace([
            'employee_id' => null,
            'device_id' => null,
        ]);
        return redirect('/dates?id='.$devices -> id)->with('message', $message);
    }

    public function exportdates(Request $request){
        
        return Excel::download(new ExportDates, $request -> model . ' ' . $request -> serial_number .'.xlsx');
    }
}
