<?php
    include('header_adm.php');

    
    include('db.php');
    
    $sql_quantity_news = "SELECT COUNT(ID_new) AS quantity_news FROM news";
    $sql_quantity_users = "SELECT COUNT(ID_user) AS quantity_users FROM users";
    $sql_quantity_in_group = "SELECT ID_group,COUNT(ID_user) AS quantity_users FROM users GROUP BY ID_group";

    $result_q_n = mysqli_query($db,$sql_quantity_news);
    $result_q_i_g = mysqli_query($db,$sql_quantity_in_group);
    $result_q_u = mysqli_query($db,$sql_quantity_users);

    $myrow_q_n = mysqli_fetch_array($result_q_n);
    $myrow_q_u = mysqli_fetch_array($result_q_u);
?>


<div class='allStatistic'>
    <div class='partOne'>
        <div class='publication'>
            <h4>Количество публикаций:</h4>
            <p>
                <?php    
                    echo $myrow_q_n['quantity_news'];
                ?>
            </p>
        </div>
        <div class='users'>
            <h4>Количество пользователей:</h4>
            <p>
                <?php 
                    echo $myrow_q_u['quantity_users'];          
                ?>
            </p>
        </div>
    </div>
    <div class='usersInGroup'>
        <div class='more'>
            <h4>Подробнее</h4>
            <?php  
                $is_written  = false;
                while ($myrow_q_i_g = mysqli_fetch_array($result_q_i_g)) {
                    if ($myrow_q_i_g['ID_group'] > 2 && !$is_written) { echo "</div><div class='groups'><h5>Ансамбли:</h5><div class='part1_2'><div class='part1'>"; $is_written = true;};
                    switch ($myrow_q_i_g['ID_group']) { 
                        case 1:
                            echo "<div class='other'><p class='p-text'>Родители: ";
                            break;
                        case 2:
                            echo "<p class='p-text'>Дети без группы: ";
                            break;
                        case 3:
                            echo '<p class="p-text">"Выше радуги": ';
                            break;
                        case 4:
                            echo '<p class="p-text">"Радуга": ';
                            break;
                        case 5:
                            echo '<p class="p-text">"12 Кадров": ';
                            break;
                        case 6:
                            echo '</div><div class="part2"><p class="p-text">"StarKids": ';
                            break;
                        case 7:
                            echo '<p class="p-text">"Звонкий дождь": "';
                            break;
                        case 8:
                            echo '<p class="p-text">"Капельки": ';
                            break;
                    }
                    if ($myrow_q_i_g['ID_group'] > 0) {
                        echo $myrow_q_i_g['quantity_users'].'</p>';
                    }
                    if ($myrow_q_i_g['ID_group'] == 8) { echo '</div></div>'; }
                }
            ?>
            </div>
        </div>
    </div>
</div>

</body>
</html>