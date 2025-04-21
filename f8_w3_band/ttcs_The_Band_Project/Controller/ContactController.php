<?php 
require_once 'Model/Contacts.php';
	class ContactController {
		public function saveContact()
		{
			$name = $_POST['name'];
			$email = $_POST['email'];
      		$message = $_POST['message'];

			// var_dump($email);
			// die;
			$contact = new Contacts();
			$contact->name = $name;
			$contact->email = $email;
			$contact->message = $message;
			$contact->insert();
			 $script = "
    <script>
	  function confirmNavigation() {
	    window.alert('Bạn đã đăng ký nhận thông tin thành công. Bấm OK để tiếp tục!');
	    window.location.href = 'index.php#contact';
	  }

  	confirmNavigation();
	</script> 
	";

  // Xuất ra đoạn mã JavaScript
  echo $script;
			// header("location:index.php");
		}
	}
 ?>