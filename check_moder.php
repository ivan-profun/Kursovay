<?php
    if (!session_id()) {
        session_start();
    }
    if ($_SESSION['ID_group'] != 0) {
        session_destroy();
        echo "<script>document.location.href = 'index.php'</script>";
    }
?>
