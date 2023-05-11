<?php
    include('check_moder.php');
    include('db.php');
    $id = $_GET['id'];
    $sql = "SELECT * FROM news WHERE ID_new = $id";
    $result = mysqli_query($db,$sql);
    $myrow = mysqli_fetch_array($result);
    $title = $myrow['Title'];
    $content_text = $myrow['Announce'];
    $content_img = $myrow['Announce_image_path'].'.'.$myrow['Format_annonce_image'];

    //$title
    //$content_text
    //$content_img
    /*echo "<pre>";
    print_r($_POST);
    echo "<br>";
    print_r($_FILES);
    /*echo "<br>";
    print_r($myrow);
    echo "<br>";
    echo "title=> ".$title;
    echo "<br>";
    echo "content_text=> ".$content_text;
    echo "<br>";
    echo "content_img=> ".$content_img;
    echo "<br>";
    echo "</pre>";*/

    if (isset($_POST['news'])) {
        if ($_POST['news'] == 'update') {
            //отправка на сервер
            $sql_upd = "UPDATE news SET ";
            //UPDATE news SET Title='',Announce_image_path='',Format_annonce_image='',Max_image_size='',Announce='',Last_change_date='' WHERE ID_new = ''
            $isEdit = false;
            if ($_POST['title'] != $title) {
                if ($isEdit) {
                    $sql_upd .= ",";
                }
                $isEdit = true;
                $sql_upd .= "Title='".$_POST['title']."'";
            }
            if ($_POST['content_text'] != $content_text) {
                if ($isEdit) {
                    $sql_upd .= ",";
                }
                $isEdit = true;
                $sql_upd .= "Announce='".$_POST['content_text']."'";
            }
            if (isset($_POST['size_img'])) {
                if ($isEdit) {
                    $sql_upd .= ",";
                }
                $isEdit = true;
                $sql_upd .= "Max_image_size='".$_POST['size_img']."'";
            }
            if (!empty($_FILES['content_img']['tmp_name'])) {
                if ($isEdit) {
                    $sql_upd .= ",";
                }
                $isEdit = true;
                $tmp_name = $_FILES["content_img"]["tmp_name"];
                $type_img = $_FILES["content_img"]["type"];
                $parts = [];
                $tok = strtok($type_img, "/");
                while ($tok !== false) {
                    $parts[] = $tok;
                    $tok = strtok("/");
                }
                $type_file = $parts[1];
                $path_file = "/opt/lampp/htdocs/website/web-site/Content/News_image/id_".$_GET['id'].".0";
                $name = $path_file.".".$type_file;
                if (move_uploaded_file($tmp_name, $name)) {
                    //echo "<script>alert('Файл успешно загружен.');</script>";
                }
                else {
                    echo '<script>alert("Ошибка загрузки файла!\nВсе изменения отменены!");</script>';
                    echo "<script> document.location.href = 'edit_news_content.php?id=".$myrow['ID_new']."'</script>";
                }
                $sql_upd .= "Announce_image_path='Content/News_image/id_".$_GET['id'].".0',Format_annonce_image='".$type_file."'";
            }
            if ($isEdit) {
                $sql_upd .= ",Last_change_date='".date("Y-m-d")."'";
                $sql_upd .= " WHERE ID_new='".$_GET['id']."'";
                $result = mysqli_query($db, $sql_upd);
                echo "<script> document.location.href = 'edit_news.php'</script>";
            }
            else {
                unset($sql_upd);
            }
            echo "<script>alert('$sql_upd');</script>"/*<script>alert('$type_img, $type_file, $tmp_name, $name');</script>"*/;
        }
        elseif ($_POST['news'] == 'cancel') {
            //отмена действий и переход на страницу модератора
            $_FILES = array();
            $_POST = array();
            header('location: edit_news.php');
        }
    }
?>

<form action='#' method='post' enctype='multipart/form-data'>
    <div class='btn-edit-content'>
        <button type='submit' name='news' value='update'>Отправить изменения</button>
        <button type='submit' name='news' value='cancel'>Отмена</button><br><br>
        <input type='reset' value='Очистить поля'>
    </div>
    <div class='field-edit-content'>
        <?php
            echo "
                <label for='title'>Заголовок новости</label><br>
                <input size='98' maxlength='255'  type='text' name='title' placeholder='Введите заголовок новости...' value='$title'><br>
                <label for='content_text'>Содержание новости</label><br>
                <textarea rows='20' cols='100' maxlength='100000' name='content_text' placeholder='Введите содержание новости...'>$content_text</textarea><br>
                <label for='content_img'>Афиша</label><br>
                <input type='file' name='content_img' accept='image/*,.jpg,.png'>
                <label for='size_img'>Размер афиши: </label>
                <label for='size_img'>Стандартный</label>
                <input type='radio' name='size_img' id='standard' value='standard' checked>
                <label for='size_img'>Полноэкранный</label>
                <input type='radio' name='size_img' id='fullsize' value='fullsize'><br>
                <label>Путь хранения файла на сервере:</label><br>
                <input size='50' type='text' readonly pleaseholder='Путь на сервере до загруженного изображения...' value='$content_img'><br>
            ";
        ?>
    </div>
</form>