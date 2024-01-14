<?php

namespace App\Exports;
use App\Models\dates;
use App\Models\devices;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithEvents;

class Exportdates implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function headings(): array
    {
        // قائمة بأسماء الأعمدة
        return [
            'اسم الموظف',
            'الفرع',
            'الشعبة',
            'القسم',
            'تاريخ الاستلام',
            'تاريخ التسليم',
        ];
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {

                // اضافة معلومات الجهاز فوق الاعمدة
                $event->sheet->mergeCells('A1:B1');
                $event->sheet->getDelegate()->getCell('A1')->setValue('معلومات الجهاز');
                $event->sheet->getDelegate()->getCell('A2')->setValue('التصنيف');
                $event->sheet->getDelegate()->getCell('B2')->setValue(request('class'));
                $event->sheet->getDelegate()->getCell('A3')->setValue('الصنف');
                $event->sheet->getDelegate()->getCell('B3')->setValue(request('category'));
                $event->sheet->getDelegate()->getCell('A4')->setValue('الموديل');
                $event->sheet->getDelegate()->getCell('B4')->setValue(request('model'));
                $event->sheet->getDelegate()->getCell('A5')->setValue('الرقم المتسلسل');
                $event->sheet->getDelegate()->getCell('B5')->setValue(request('serial_number'));
                $event->sheet->getDelegate()->getCell('A6')->setValue('الحالة الفنية');
                $event->sheet->getDelegate()->getCell('B6')->setValue(request('status'));

                $event->sheet->mergeCells('C1:D1');
                $event->sheet->getDelegate()->getCell('C1')->setValue('معلومات مستلم الجهاز');
                $event->sheet->getDelegate()->getCell('C2')->setValue('اسم الموظف');
                $event->sheet->getDelegate()->getCell('D2')->setValue(request('employee'));
                $event->sheet->getDelegate()->getCell('C3')->setValue('الفرع');
                $event->sheet->getDelegate()->getCell('D3')->setValue(request('branch'));
                $event->sheet->getDelegate()->getCell('C4')->setValue('الشعبة');
                $event->sheet->getDelegate()->getCell('D4')->setValue(request('sub_branch'));
                $event->sheet->getDelegate()->getCell('C5')->setValue('القسم');
                $event->sheet->getDelegate()->getCell('D5')->setValue(request('department'));
                $event->sheet->getDelegate()->getCell('C6')->setValue('التوصيف الوظيفي');
                $event->sheet->getDelegate()->getCell('D6')->setValue(request('jop_title'));

                $event->sheet->mergeCells('E1:F1');
                $event->sheet->getDelegate()->getCell('E1')->setValue('معلومات إضافية');
                $event->sheet->getDelegate()->getCell('E2')->setValue('المعالج');
                $event->sheet->getDelegate()->getCell('F2')->setValue(request('processor'));
                $event->sheet->getDelegate()->getCell('E3')->setValue('ذاكرة 1');
                $event->sheet->getDelegate()->getCell('F3')->setValue(request('memory1'));
                $event->sheet->getDelegate()->getCell('E4')->setValue('ذاكرة 2');
                $event->sheet->getDelegate()->getCell('F4')->setValue(request('memory2'));
                $event->sheet->getDelegate()->getCell('E5')->setValue('هارد 1');
                $event->sheet->getDelegate()->getCell('F5')->setValue(request('hard_disk1'));
                $event->sheet->getDelegate()->getCell('E6')->setValue('هارد 2');
                $event->sheet->getDelegate()->getCell('F6')->setValue(request('hard_disk2'));

                $event->sheet->mergeCells('A7:F7');
                // تعديل تنسيق الخلية
                $event->sheet->getStyle('A1')->getFont()->setBold(true);
                $event->sheet->getStyle('A2')->getFont()->setBold(true);
                $event->sheet->getStyle('A3')->getFont()->setBold(true);
                $event->sheet->getStyle('A4')->getFont()->setBold(true);
                $event->sheet->getStyle('A5')->getFont()->setBold(true);
                $event->sheet->getStyle('A6')->getFont()->setBold(true);
                $event->sheet->getStyle('C1')->getFont()->setBold(true);
                $event->sheet->getStyle('C2')->getFont()->setBold(true);
                $event->sheet->getStyle('C3')->getFont()->setBold(true);
                $event->sheet->getStyle('C4')->getFont()->setBold(true);
                $event->sheet->getStyle('C5')->getFont()->setBold(true);
                $event->sheet->getStyle('C6')->getFont()->setBold(true);
                $event->sheet->getStyle('E1')->getFont()->setBold(true);
                $event->sheet->getStyle('E2')->getFont()->setBold(true);
                $event->sheet->getStyle('E3')->getFont()->setBold(true);
                $event->sheet->getStyle('E4')->getFont()->setBold(true);
                $event->sheet->getStyle('E5')->getFont()->setBold(true);
                $event->sheet->getStyle('E6')->getFont()->setBold(true);
            },
        ];
    }

    public function map($row): array
    {
        return [
            'employee' => $row->employee->full_name,
            'branch' => $row->branch->branch,
            'sub_branch' => $row->sub_branch->sub_branch,
            'department' => $row->department->department,
            'start_date' => $row->start_date,
            'end_date' => $row->end_date,
        ];
    }

    public function styles(Worksheet $sheet)
    {
         // تحديد توسيط النص لكل الخلايا في الورقة
         $sheet->getStyle($sheet->calculateWorksheetDimension())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // تحديد تنسيقات النص
        $sheet->getStyle('8')->getFont()->setBold(true);
        $sheet->getStyle('8')->getBorders()->getAllBorders(true);

        $sheet->setRightToLeft(true);

        // تحديد خصائص الحدود لكل الخلايا في الورقة
        $sheet->getStyle($sheet->calculateWorksheetDimension())->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

    }

    public function collection()
    {

        $device_id = request('device_id');
        $query = dates::where('device_id', $device_id);
        return $query->get();
    }

    public function sheetView(): array
    {
        // تحديد خصائص عرض الورقة لتغيير اتجاه الكتابة للورقة بأكملها
        return [
            'sheetView' => [
                'rightToLeft' => true,
            ],
        ];
    }
}
