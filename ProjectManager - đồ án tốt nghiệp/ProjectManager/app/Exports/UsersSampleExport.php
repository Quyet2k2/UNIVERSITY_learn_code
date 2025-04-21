<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Collection;

class UsersSampleExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
 // Tiêu đề cột
 public function headings(): array
 {
  return ['Name', 'Email', 'Password'];
 }

 // Dữ liệu mẫu để người dùng tham khảo
 public function collection()
 {
  return new Collection([
   ['John Doe', 'johndoe@mail.com', 'johndoe_aht4410'],
   ['Jane Smith', 'janesmith@mail.com', 'janesmith_aht128421'],
   ['', '', ''], // Dòng trống để ngăn cách dữ liệu
   ['NOTE:', 'All fields are required, and the password must be at least 4 characters.', ''], // Lưu ý cho người dùng
  ]);
 }

 // Style tiêu đề & bảng
 public function styles(Worksheet $sheet)
 {
  // Định dạng viền bảng
  $highestRow = $sheet->getHighestRow();
  $highestColumn = $sheet->getHighestColumn();

  $sheet->getStyle("A1:{$highestColumn}{$highestRow}")->applyFromArray([
   'borders' => [
    'allBorders' => [
     'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
     'color' => ['rgb' => '000000'],
    ],
   ],
  ]);

  return [
   1 => [ // Style cho tiêu đề
    'font' => ['bold' => true],
    'alignment' => ['horizontal' => 'center'],
   ],
   5 => [ // Style cho dòng "NOTE:"
    'font' => ['italic' => true, 'color' => ['rgb' => 'FF0000']],
   ],
  ];
 }
}

