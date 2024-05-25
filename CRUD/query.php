<?php
include "dbcon.php";

if(isset($_POST['searchInp'])){
    $inp = $_POST['searchInp'];
    $query = $pdo->prepare("select * from users where name like :val");
    $inp = "%$inp%";
    $query->bindParam(':val', $inp);
    $query->execute();
    $allusers = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach ($allusers as $user) {
        ?>
        <tr>
            <td><?php echo $user['name']?></td>
            <td><?php echo $user['email']?></td>
            <td><?php echo $user['password']?></td>
        </tr>
        <?php
    }
}

?>