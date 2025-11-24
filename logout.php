<?php
session_start();
session_unset();  // hapus semua data session
session_destroy(); // destroy session

header("Location: index.php");
exit();
?>
