<?php

session_destroy();
echo '<script>alert("Logged out!")</script>';
header('Location:index.php');

?>