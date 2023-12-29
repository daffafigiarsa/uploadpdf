<?php
session_start();

// Hapus sesi dan alihkan ke halaman login
session_destroy();
header("Location: login.php");
exit();
?>
