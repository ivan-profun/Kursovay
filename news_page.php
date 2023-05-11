<?php
    include("header.php");

    // получение титульника и главного изображения
    $sql = "SELECT `ID_new`, `Title`, `Announce_image_path`, `Format_annonce_image`, DATE_FORMAT( `Publish_date` , '%d' ) AS `Pub_d`, DATE_FORMAT( `Publish_date` , '%m' ) AS `Pub_m`, DATE_FORMAT( `Publish_date` , '%Y' ) AS `Pub_y` FROM `news` ORDER BY Publish_date DESC";
    $result = mysqli_query($db, $sql);

    echo "<div class=\"header_new\"><h1>Новости</h1></div>";

    while ($myrow = mysqli_fetch_array($result)){
        echo "<a class=\"new-blok\" href=\"new_page.php?id=".$myrow['ID_new']."\"><div class=\"new\"><div class=\"title\"><p><strong>" . $myrow['Title'] . "</strong></p>";
        echo "<div class=\"publish-date\">" . $myrow['Pub_d'] . "." . $myrow['Pub_m'] . "." . $myrow['Pub_y'] . "</div></div>";
        if ($myrow['Announce_image_path'] != null) {
            echo "<img src=\"" . $myrow['Announce_image_path'].".".$myrow['Format_annonce_image'] . "\">";
        }
        echo "</div></a><br><br><br>";
    }
?>





</body>
</html>