<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\devices;
use App\Models\branches;
use App\Models\processors;
use App\Models\memories;
use App\Models\hard_disks;
use App\Models\classes;
use App\Models\categories;
use App\Models\departments;
use App\Models\employees;
use App\Models\models;
use App\Models\statuses;
use App\Models\sub_branches;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportDeviceEmployee;

class DeviceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('clear')) {
            // إعادة تعيين القيم إلى الحالة الافتراضية
            $request->replace([
                'branch_id' => null,
                'sub_branch_id' => null,
                'department_id' => null,
                'class_id' => null,
                'category_id' => null,
                'model_id' => null,
                'status_id' => null,
                'serial_number' => null,
            ]);
        }
        $devices = devices::query(); 
        if ($request->input('branch_id')) {$devices->where('branch_id', $request->input('branch_id'));}
        // if ($request->input('s_s')) {$devices->where('sub_branch_id', $request->input('s_s'));}
        // if ($request->input('s_d')) {$devices->where('department_id', $request->input('s_d'));}
        if ($request->input('calss_id')) {$devices->where('class_id', $request->input('calss_id'));}
        if ($request->input('category_id')) {$devices->where('category_id', $request->input('category_id'));}
        if ($request->input('model_id')) {$devices->where('model_id', $request->input('model_id'));}
        if ($request->input('status_id')) {$devices->where('status_id', $request->input('status_id'));}
        if ($request->input('serial')) {$devices->where('serial_number', 'like' , '%'.$request->input('serial').'%');}

        if (Auth::user()->role == '1') {
            $branches = branches::orderBy('branch' , 'ASC');
        } else {
            $branches = branches::where('id',Auth::user()->branch_id)->orderBy('branch' , 'ASC');
            $devices->where('branch_id', Auth::user()->branch_id);
        }

        $par = ['branches' => $branches->get(),
                'sub_branches' => sub_branches::where('branch_id', $request->sub_branch_id)->orderBy('sub_branch' , 'ASC')->get(),
                'departments' => departments::orderBy('department' , 'ASC')->get(),
                'classes' => classes::orderBy('class' , 'ASC')->get(),
                'categories' => categories::where('class_id', $request->class_id)->orderBy('category' , 'ASC')->get(),
                'models' => models::where('category_id', $request->category_id)->orderBy('model' , 'ASC')->get(),
                'statuses' => statuses::orderBy('status' , 'ASC')->get(),
                'devices' => $devices->get(),
                'search_branch' => $request->branch_id,
                'search_sub_branch' => $request->sub_branch_id,
                'search_department' => $request->department_id,
                'search_class' => $request->class_id,
                'search_category' => $request->category_id,
                'search_model' => $request->model_id,
                'search_status' => $request->status_id, 
                'search_serial_number' => $request->serial, 
                ];

        return view('device.index')->with('list' , $par);
    }

    public function create()
    {
        if (Auth::user()->role == '1') {
            $par = ['branches' => branches::orderBy('branch' , 'ASC')->get(),
                    'processors' => processors::orderBy('processor' , 'ASC')->get(),
                    'memories' => memories::orderBy('kind' , 'ASC')->get(),
                    'hard_disks' => hard_disks::orderBy('kind' , 'ASC')->get(),
                    'classes' => classes::orderBy('class' , 'ASC')->get(),
                    'categories' => categories::orderBy('category' , 'ASC')->get(),
                    'models' => models::orderBy('model' , 'ASC')->get(),
                    'statuses' => statuses::orderBy('status' , 'ASC')->get(),
                    'processors' => processors::orderBy('processor' , 'ASC')->get(),
                    'memories' => memories::orderBy('kind' , 'ASC')->orderBy('size' , 'ASC')->get(),
                    'hard_disks' => hard_disks::orderBy('kind' , 'ASC')->orderBy('size' , 'ASC')->get(),
                    ];
        } else {
            $par = ['branches' => branches::where('id',Auth::user()->branch_id)->get(),
                    'processors' => processors::orderBy('processor' , 'ASC')->get(),
                    'memories' => memories::orderBy('kind' , 'ASC')->get(),
                    'hard_disks' => hard_disks::orderBy('kind' , 'ASC')->get(),
                    'classes' => classes::orderBy('class' , 'ASC')->get(),
                    'categories' => categories::orderBy('category' , 'ASC')->get(),
                    'models' => models::orderBy('model' , 'ASC')->get(),
                    'statuses' => statuses::orderBy('status' , 'ASC')->get(),
                    'processors' => processors::orderBy('processor' , 'ASC')->get(),
                    'memories' => memories::orderBy('kind' , 'ASC')->orderBy('size' , 'ASC')->get(),
                    'hard_disks' => hard_disks::orderBy('kind' , 'ASC')->orderBy('size' , 'ASC')->get(),
                    ];
        }
        return view('device.create')->with('list' , $par);
    }

    public function store(Request $request)
    {
        $request -> validate([
            'branch_id' => ['required', 'min_digits:1'],
            'class_id' => ['required', 'min_digits:1'],
            'category_id' => ['required', 'min_digits:1'],
            'model_id' => ['required', 'min_digits:1'],
            'serial_number' => ['required', 'unique:devices'],
            'status_id' => ['required', 'min_digits:1'],
        ]);
        devices::create([
            'branch_id'=>$request -> Input('branch_id'),
            'class_id'=>$request -> Input('class_id'),
            'category_id'=>$request -> Input('category_id'),
            'model_id'=>$request -> Input('model_id'),
            'serial_number'=>$request -> Input('serial_number'),
            'status_id'=>$request -> Input('status_id'),
            'notes'=>$request -> Input('notes'),
            'processor_id'=>$request -> Input('processor_id'),
            'memory1_id'=>$request -> Input('memory1_id'),
            'memory2_id'=>$request -> Input('memory2_id'),
            'hard_disk1_id'=>$request -> Input('hard_disk1_id'),
            'hard_disk2_id'=>$request -> Input('hard_disk2_id'),
        ]);
        return redirect('device') -> with('message', 'تم إضافة الجهاز بنجاح');
    }

    public function show(string $id)
    {
        $test = devices::where('id', $id)->first();
        if (is_null($test)) {
            return redirect('device') -> with('message', 'الصفحة التي قمت بطلبها غير موجودة');
        }
        if (Auth::user()->role == '1') {
            return view('device.show')->with('devices', devices::where('id', $id)->first());
        } else {
            if ($test->branch_id == Auth::user()->branch_id) {
                return view('device.show')->with('devices', devices::where('id', $id)->first());
            } else {
                return redirect('device') -> with('message', 'هذه الصفحة لجهاز من فرع آخر ليس لديك صلاحيات لعرضها');
            }
        }
    }

    public function edit(string $id)
    {
        $test = devices::where('id', $id)->first();
        if (Auth::user()->role == '1') {
            $par = ['branches' => branches::orderBy('branch' , 'ASC')->get(),
                    'processors' => processors::orderBy('processor' , 'ASC')->get(),
                    'memories' => memories::orderBy('kind' , 'ASC')->get(),
                    'hard_disks' => hard_disks::orderBy('kind' , 'ASC')->get(),
                    'classes' => classes::orderBy('class' , 'ASC')->get(),
                    'categories' => categories::where('class_id',$test->class_id)->orderBy('category' , 'ASC')->get(),
                    'models' => models::orderBy('model' , 'ASC')->get(),
                    'statuses' => statuses::orderBy('status' , 'ASC')->get(),
                    'devices' => devices::where('id', $id)->first(),
                    'processors' => processors::orderBy('processor' , 'ASC')->get(),
                    'memories' => memories::orderBy('kind' , 'ASC')->orderBy('size' , 'ASC')->get(),
                    'hard_disks' => hard_disks::orderBy('kind' , 'ASC')->orderBy('size' , 'ASC')->get(),
                    ];
            return view('device.edit')->with('list', $par);
        } else {
            if ($test->branch_id == Auth::user()->branch_id) {
                $par = ['branches' => branches::where('id',Auth::user()->branch_id)->get(),
                        'processors' => processors::orderBy('processor' , 'ASC')->get(),
                        'memories' => memories::orderBy('kind' , 'ASC')->get(),
                        'hard_disks' => hard_disks::orderBy('kind' , 'ASC')->get(),
                        'classes' => classes::orderBy('class' , 'ASC')->get(),
                        'categories' => categories::where('class_id',$test->class_id)->orderBy('category' , 'ASC')->get(),
                        'models' => models::orderBy('model' , 'ASC')->get(),
                        'statuses' => statuses::orderBy('status' , 'ASC')->get(),
                        'devices' => devices::where('id', $id)->first(),
                        'processors' => processors::orderBy('processor' , 'ASC')->get(),
                        'memories' => memories::orderBy('kind' , 'ASC')->orderBy('size' , 'ASC')->get(),
                        'hard_disks' => hard_disks::orderBy('kind' , 'ASC')->orderBy('size' , 'ASC')->get(),
                        ];
                return view('device.edit')->with('list', $par);
            } else {
                return redirect('device') -> with('message', 'هذه الصفحة لجهاز من فرع آخر ليس لديك صلاحيات لعرضها');
            }
        }
    }

    public function update(Request $request, string $id)
    {
        $request -> validate([
            'branch_id' => ['required', 'min_digits:1'],
            'class_id' => ['required', 'min_digits:1'],
            'category_id' => ['required', 'min_digits:1'],
            'model_id' => ['required', 'min_digits:1'],
            'serial_number' => ['required', 'unique:devices,serial_number,' . $id],
            'status_id' => ['required', 'min_digits:1'],
        ]);
        devices::where('id', $id)
            ->update([
            'branch_id'=>$request -> Input('branch_id'),
            'class_id'=>$request -> Input('class_id'),
            'category_id'=>$request -> Input('category_id'),
            'model_id'=>$request -> Input('model_id'),
            'serial_number'=>$request -> Input('serial_number'),
            'status_id'=>$request -> Input('status_id'),
            'notes'=>$request -> Input('notes'),
            'accossories'=>$request -> Input('accossories'),
            'processor_id'=>$request -> Input('processor_id'),
            'memory1_id'=>$request -> Input('memory1_id'),
            'memory2_id'=>$request -> Input('memory2_id'),
            'hard_disk1_id'=>$request -> Input('hard_disk1_id'),
            'hard_disk2_id'=>$request -> Input('hard_disk2_id'),
        ]);
        return redirect('device') -> with('message', 'تم التعديل على الجهاز بنجاح');
    }

    public function destroy(string $id)
    {
        //
    }

    public function device_employee(Request $request)
    { 
        $employee = employees::query(); 
        if (Auth::user()->role == '0') {$employee->where('branch_id', $request->branch_id);}
        $par = ['devices' => devices::where('employee_id',$request -> id)->get(),
                'employees' => employees::where('id',$request -> id)->first(),
                'employees_list' => $employee -> get(),
                ];
        return view('device.device')->with('list' , $par);
    }

    public function export_device_employee(Request $request){
        
        return Excel::download(new ExportDeviceEmployee, $request -> full_name .'.xlsx');
    }

}
