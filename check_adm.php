<?php
    if ($_SESSION['ID_group'] != -1) {
        session_destroy();
        echo "<script>document.location.href = 'index.php'</script>";
    }
?>
