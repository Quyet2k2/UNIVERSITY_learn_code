<?php


namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport_failedImportData implements FromArray, WithHeadings, ShouldAutoSize, WithStyles
{
 protected $failedRows;

 public function __construct($failedRows)
 {
  $this->failedRows = $failedRows;
 }

 public function array(): array
 {
  return $this->failedRows;
 }

 public function headings(): array
 {
  return ['Name', 'Email', 'Password', 'Errors'];
 }

 public function styles(Worksheet $sheet)
 {
  $highestRow = $sheet->getHighestRow();
  $highestColumn = $sheet->getHighestColumn();

  // Định dạng viền bảng
  $sheet->getStyle("A1:{$highestColumn}{$highestRow}")->applyFromArray([
   'borders' => [
    'allBorders' => [
     'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
     'color' => ['rgb' => '000000'],
    ],
   ],
  ]);

  // Định dạng tiêu đề (dòng 1)
  $sheet->getStyle("A1:D1")->applyFromArray([
   'font' => ['bold' => true],
   'alignment' => ['horizontal' => 'center'],
  ]);

  // Định dạng màu chữ đỏ cho cột "Errors" (D2:D...)
  if ($highestRow > 1) { // Chỉ thực hiện nếu có dữ liệu
   $sheet->getStyle("D2:D{$highestRow}")->applyFromArray([
    'font' => ['color' => ['rgb' => 'FF0000']],
   ]);
  }

  return [];
 }

}
