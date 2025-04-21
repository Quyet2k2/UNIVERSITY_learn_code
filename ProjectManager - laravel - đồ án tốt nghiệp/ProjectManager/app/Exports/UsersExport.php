<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UsersExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
 /**
  * @return \Illuminate\Support\Collection
  */
 public function collection()
 {
  return User::select('id', 'name', 'email', 'avatar', 'created_at', 'updated_at')->get()->map(function ($user) {
   return [
    'id' => $user->id,
    'name' => $user->name,
    'email' => $user->email,
    'avatar' => $user->avatar,
    'created_at' => \Carbon\Carbon::parse($user->created_at)->setTimezone('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s'),
    'updated_at' => \Carbon\Carbon::parse($user->updated_at)->setTimezone('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s'),
   ];
  });
 }


 // Tiêu đề cột
 public function headings(): array
 {
  return ['ID', 'Name', 'Email', 'Avatar', 'Created At (UTC+7)', 'Updated At (UTC+7)'];
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
  ];
 }
}
