<?php
    $id = $_GET['id'];
    
    if ($id != null) {
        include("header.php");

        $sql = "SELECT `Title`, `Announce_image_path`, `Format_annonce_image`, DATE_FORMAT( `Publish_date` , '%d' ) AS `Pub_d`, DATE_FORMAT( `Publish_date` , '%m' ) AS `Pub_m`, DATE_FORMAT( `Publish_date` , '%Y' ) AS `Pub_y`, `Announce` FROM `news` WHERE `ID_new` = $id";
        $result = mysqli_query($db, $sql);
        $myrow = mysqli_fetch_array($result);
        echo "
            <div class=\"new\">
                <div class=\"title\">
                    <p><strong>" . $myrow['Title'] . "</strong></p>
                    <div class=\"publish-date\">" . $myrow['Pub_d'] . "." . $myrow['Pub_m'] . "." . $myrow['Pub_y'] . "</div>
                </div>";
                if ($myrow['Announce_image_path'] != null) {
                    echo "<img src=\"" . $myrow['Announce_image_path'].".".$myrow['Format_annonce_image'] . "\">";
                }
        echo "
                <div class=\"textNew\">"
                    . $myrow['Announce'] .
                "</div>
            </div>";
    }
    else {
        echo "<div><h3>Страница не найдена</h3>
        <p>Страница устарела, была удалена или не существовала вовсе</p></div>";
    }
?>

</body>
</html>