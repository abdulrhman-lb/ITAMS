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

class ExportDeviceEmployee implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        // قائمة بأسماء الأعمدة
        return [
            'التصنيف',
            'الصنف',
            'النوع',
            'الرقم المتسلسل',
            'الحالة الفنية',
            'ملاحظات',
        ];
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {

                // اضافة معلومات الموظف فوق الاعمدة
                $event->sheet->mergeCells('A1:F1');
                $event->sheet->getDelegate()->getCell('A1')->setValue('معلومات الموظف');

                $event->sheet->getDelegate()->getCell('A2')->setValue('الفرع');
                $event->sheet->getDelegate()->getCell('B2')->setValue(request('branch'));
                $event->sheet->getDelegate()->getCell('A3')->setValue('الشعبة');
                $event->sheet->getDelegate()->getCell('B3')->setValue(request('sub_branch'));
                $event->sheet->getDelegate()->getCell('A4')->setValue('القسم');
                $event->sheet->getDelegate()->getCell('B4')->setValue(request('department'));

                $event->sheet->getDelegate()->getCell('C2')->setValue('اسم الموظف');
                $event->sheet->getDelegate()->getCell('D2')->setValue(request('full_name'));
                $event->sheet->getDelegate()->getCell('C3')->setValue('التوصيف الوظيفي');
                $event->sheet->getDelegate()->getCell('D3')->setValue(request('jop_title'));

                $event->sheet->getDelegate()->getCell('E2')->setValue('رقم الهاتف');
                $event->sheet->getDelegate()->getCell('F2')->setValue(request('phone'));
                $event->sheet->getDelegate()->getCell('E3')->setValue('رقم الموبايل');
                $event->sheet->getDelegate()->getCell('F3')->setValue(request('mobile'));
                $event->sheet->getDelegate()->getCell('E4')->setValue('البريد الالكتروني');
                $event->sheet->getDelegate()->getCell('F4')->setValue(request('email'));
                // تعديل تنسيق الخلية
                $event->sheet->mergeCells('A5:F5');
                $event->sheet->mergeCells('A6:F6');
                $event->sheet->getDelegate()->getCell('A5')->setValue(' ');
                $event->sheet->getDelegate()->getCell('A6')->setValue('العهدة الشخصية');
                $event->sheet->getStyle('1')->getFont()->setBold(true);
                $event->sheet->getStyle('A2')->getFont()->setBold(true);
                $event->sheet->getStyle('A3')->getFont()->setBold(true);
                $event->sheet->getStyle('A4')->getFont()->setBold(true);
                $event->sheet->getStyle('A6')->getFont()->setBold(true);
                $event->sheet->getStyle('C2')->getFont()->setBold(true);
                $event->sheet->getStyle('C3')->getFont()->setBold(true);
                $event->sheet->getStyle('E2')->getFont()->setBold(true);
                $event->sheet->getStyle('E3')->getFont()->setBold(true);
                $event->sheet->getStyle('E4')->getFont()->setBold(true);
            },
        ];
    }

    public function map($row): array
    {
        return [
            'class' => $row->class->class,
            'category' => $row->category->category,
            'model' => $row->model->model,
            'serial_number' => $row->serial_number,
            'status' => $row->status->status,
            'notes' => $row->notes,
        ];
    }

    public function styles(Worksheet $sheet)
    {
         // تحديد توسيط النص لكل الخلايا في الورقة
         $sheet->getStyle($sheet->calculateWorksheetDimension())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // تحديد تنسيقات النص
        $sheet->getStyle('7')->getFont()->setBold(true);
        $sheet->getStyle('7')->getBorders()->getAllBorders(true);

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
        $employee_id = request('employee_id');
        $query = devices::where('employee_id', $employee_id);
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
