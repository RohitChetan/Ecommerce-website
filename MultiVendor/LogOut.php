<?php
 session_start();

unset($_SESSION['VENDOR_LOGIN']);
unset($_SESSION['VENDOR_USERNAME']);

?> 
<script>
	window.location.href='Vendor_login.php';
</script>
<?php
die();

?>