<?php 
   require_once 'BaseModel.php';
   // Nhúng một lần class 'BaseModel.php'
   class Tickets extends BaseModel{
   //đặt tên giống file, kế thừa class BaseModel
   	public $tableName= 'tickets';
      // gán biến tableName = tên bảng
   	public $columns=['id','quantity','email'];
      // gán tên các cột giống tên trong csdl để lặp trong class BaseModel
   }
 ?>