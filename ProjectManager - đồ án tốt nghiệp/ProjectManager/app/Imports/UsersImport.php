<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Validators\Failure;

class UsersImport implements ToModel, WithHeadingRow, SkipsOnFailure
{
 use SkipsFailures;

 public static $failedRows = []; // Lưu các dòng bị lỗi

 public function model(array $row)
 {
  $validator = Validator::make($row, [
   'name' => 'required|string|max:255',
   'email' => 'required|email|unique:users,email',
   'password' => 'required|min:4',
  ]);

  if ($validator->fails()) {
   // Lưu lỗi vào danh sách thất bại
   self::$failedRows[] = [
    'name' => $row['name'] ?? '',
    'email' => $row['email'] ?? '',
    'password' => $row['password'] ?? '',
    'errors' => implode(', ', $validator->errors()->all()),
   ];
   return null; // Bỏ qua dòng này
  }

  return new User([
   'name' => $row['name'],
   'email' => $row['email'],
   'password' => bcrypt($row['password']),
  ]);
 }
}
