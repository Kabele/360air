<?php
if($this->Account_model->isLoggedIn()) {
	echo $this->load->view('widgets/account_info', NULL, true);
} else {
	echo $this->load->view('widgets/login', NULL, true);
}
echo anchor("/admin", "Admin Flights", "");
echo '<br>';
echo anchor("/admin/orders", "Admin Orders", "");
?>