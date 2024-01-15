<?php

namespace App\Http\Controllers;

use App\Models\dates;
use App\Models\devices;
use App\Models\employees;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportDates;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

class DatesController extends Controller
{
    public function index(Request $request)
    {
        $employee = employees::query(); 
        if (Auth::user()->role == '0') {$employee->where('branch_id', $request->branch_id);}
        $par = ['dates' => Dates::where('device_id',$request -> id)->orderBy('start_date' , 'ASC')->orderBy('id' , 'ASC')->get(),
                'devices' => devices::where('id',$request -> id)->first(),
                'employees' => $employee -> get(),
                'back' => $request -> back
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
        $old_employee = $dates -> employee_id;
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
        if ($request -> back == '0') {
            return redirect('/dates?id='.$devices -> id)->with('message', $message);

        } else {
            return redirect('/device-employee?id='.$old_employee)->with('message', $message);
        }
    }

    public function index_add_all(Request $request)
    {
        // dd($request -> new_employee_id);
        $request -> validate([
            'new_employee_id' => ['required', 'min_digits:1'],
        ]);
        $new_employee = employees::where('id',$request -> new_employee_id)->first();
        $old_employee = employees::where('id',$request -> old_employee_id)->first();
        $devices = devices::where('employee_id',$request -> old_employee_id)->get();
        if (!$devices->isEmpty()) {
            foreach ($devices as $device) {
                // dd($device);
                $dates = Dates::where('device_id',$device -> id)->where('end_date', null)->first();
                // dd($dates);
                 //تسجيل تاريخ انتاء التسليم للموظف السابق
                $dates -> update(['end_date'=> now()]);
                //انشاء سجل استلام جديد للموظف الحالي
                Dates::create(['start_date'=> now(),
                                'branch_id'=> $new_employee -> branch_id,
                                'sub_branch_id'=> $new_employee -> sub_branch_id,
                                'department_id'=> $new_employee -> department_id,
                                'employee_id'=> $new_employee -> id,
                                'device_id'=> $device -> id,
                                ]);
                //تحديث بيانات جدول الجهاز
                $device -> update([
                        'employee_id'=> $new_employee -> id,
                        'branch_id'=> $new_employee -> branch_id,
                    ]);
            }
            $message = 'تم نقل كامل التجهيزات من الموظف ' . $old_employee -> full_name . ' إلى الموظف ' . $new_employee -> full_name;
            return redirect('/device-employee?id='.$old_employee->id)->with('message', $message);

        } else {
            $message = 'لا يوجد أي تجهيزات لنقلها من الموظف  ' . $old_employee -> full_name ;
            return redirect('/device-employee?id='.$old_employee->id)->with('message', $message);
        }
    }
    
    public function exportdates(Request $request){
        
        return Excel::download(new ExportDates, $request -> model . ' ' . $request -> serial_number .'.xlsx');
    }
}
