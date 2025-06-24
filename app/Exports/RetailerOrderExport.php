<?php

namespace app\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;

class RetailerOrderExport implements WithEvents, FromView
{

    protected $datas;
    protected $order;

    function __construct($datas, $order)
    {
        $this->datas = $datas;
        $this->order = $order;
    }

    public function registerEvents(): array
    {
        return [
            BeforeExport::class  => function (BeforeExport $event) {
                $event->writer->getDelegate()->getSecurity()->setLockWindows(true);
                $event->writer->getDelegate()->getSecurity()->setLockStructure(true);
                $event->writer->getDelegate()->getSecurity()->setWorkbookPassword("Your password");
            },
            AfterSheet::class => function (AfterSheet $event) {
                // Auto-size all columns
                $event->sheet->getDelegate()->getColumnDimension('A')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('B')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('C')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('d')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('e')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('f')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('g')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('h')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('i')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('j')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('k')->setAutoSize(true);

                // Center the image in the cell
                $event->sheet->getDelegate()->getStyle('B1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // Set padding and vertical alignment for cell C10
                $event->sheet->getDelegate()->getStyle('C10')->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getStyle('C10')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle('C10')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('C10')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                //Background-color
                $event->sheet->getDelegate()->getStyle('12')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $event->sheet->getDelegate()->getStyle('12')->getFill()->getStartColor()->setARGB('#89ad40');
            }
        ];
    }

    public function view(): View
    {
        return view('exports.retailerorder', [
            'details' => $this->datas,
            'orders' => $this->order
        ]);
    }
}
