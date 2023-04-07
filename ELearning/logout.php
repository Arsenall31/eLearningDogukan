<?php

session_destroy();
echo '<script>alert("Logged out!")</script>';
header("Refresh:0.1; url=index.php")

?>