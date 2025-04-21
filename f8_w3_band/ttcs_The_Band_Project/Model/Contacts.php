<?php 
   require_once 'BaseModel.php';
   // Nhúng một lần class 'BaseModel.php'
   class Contacts extends BaseModel{
   //đặt tên giống file, kế thừa class BaseModel
   	public $tableName= 'contacts';
      // gán biến tableName = tên bảng
   	public $columns=['id','name','email','message'];
      // gán tên các cột giống tên trong csdl để lặp trong class BaseModel
   }
 ?>