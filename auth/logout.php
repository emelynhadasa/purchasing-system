<?php
session_start();
session_destroy();
session_unset();
echo "<script>alert('See yaa!');window.location.href='login.php'</script>";
exit();
