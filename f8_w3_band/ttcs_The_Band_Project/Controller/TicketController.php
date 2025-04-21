<?php 
require_once 'Model/Tickets.php';
	class TicketController {
		public function saveTicket()
		{
		  $quantity = $_POST['quantity'];
		  $email = $_POST['email'];

		  $ticket = new Tickets();
		  $ticket->quantity = $quantity;
		  $ticket->email = $email;
		  $ticket->insert();

		  // Đoạn mã JavaScript để tạo hộp thoại xác nhận và chuyển hướng trang
		  $script = "
		    <script>
			  function confirmNavigation() {
			    window.alert('Bạn đã đặt vé thành công. Bấm OK để tiếp tục!');
			    window.location.href = 'index.php#tour';
			  }

			  confirmNavigation();
			</script>
		  ";

		  // Xuất ra đoạn mã JavaScript
		  echo $script;
		}
	}
 ?>