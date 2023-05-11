<?php
    include('db.php');
    $sql="SELECT MAX(ID_group) AS ID_group FROM groups";
    $result=mysqli_query($db,$sql); 
    $myrow=mysqli_fetch_array($result); 
    $isNotUser = 0;
    for ($i = 1; $i <= $myrow['ID_group']; $i++) {
        if ($_SESSION['ID_group'] != $i) {
            ++$isNotUser;
        }
    }
    if ($isNotUser === 8) {
        session_destroy();
        echo "<script>document.location.href = 'index.php'</script>";
    }
?>