<?php
 class BaseModel{
 	public $connect;

 	public function __construct()
 	{
 		$this->connect = new PDO("mysql:host=localhost;dbname=the_band_mvc;charset=utf8",'root','');
 	}

 	public function insert(){
        $this->queryBuilder = "insert into $this->tableName (";
        // $this->queryBuilder = "insert into <Tên bảng khi được kế thừa> (";
        foreach ($this->columns as $col) {
            // Lặp để lấy tên các cột trong bảng
            if($this->{$col} == null){
                continue;
                // Nếu tên cột trả về null thì thoát vòng lặp (đã lấy hết cột trong bảng)
            }
            $this->queryBuilder .= "$col, ";
            // Nếu chưa lấy hết cột thì còn nối thêm tên cột vào chuỗi truy vấn
        }
        $this->queryBuilder = rtrim($this->queryBuilder, ", ");
        // Khi lấy hết tên cột và nối vào chuỗi truy vấn thì cắt bớt dấu phẩy ở cuối chuỗi truy vấn
        $this->queryBuilder .= ") values ( ";
        // Nối thêm phần _") values ( "_ cho chuỗi truy vấn
        foreach ($this->columns as $col) {
            // Lặp lại các cột trong bảng
            if($this->{$col} == null){
                continue;
                // Nếu không còn thì thoát lặp
            }
            $this->queryBuilder .= "'" . $this->{$col} ."', ";
            // Nếu còn thì nối thêm chuỗi _"'" . $this->{$col} ."', "_ ($this->{$col} là dữ liệu đầu vào cần gán)
        }
        $this->queryBuilder = rtrim($this->queryBuilder, ", ");
        // Cắt dấu phẩy cuối cùng của chuỗi khi gán xong
        $this->queryBuilder .= ")";
        // Đóng ngoặc khi kết thúc chuỗi truy vấn

        $stmt = $this->connect->prepare($this->queryBuilder);
        // Biến '$stmt' dùng để chuẩn bị sử dụng chuỗi truy vấn để thực thi
        try{
            // thử chạy khối câu lệnh
            $stmt->execute();
            // thực thi biến chuẩn bị '$stmt' 
            $this->id = $this->connect->lastInsertId();
            // Lấy ra id cuối cùng và gán vào id của đối tượng này.
            return $this;
            // Trả về đối tượng này
        }catch(Exception $ex){
            var_dump($ex->getMessage());die;
            // Nếu có lỗi thì hiển thị lỗi và ngắt kết nối dữ liệu
        }
    }
 } 
?>