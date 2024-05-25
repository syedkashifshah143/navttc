<?php
include "query.php";

$query= $pdo->query("select * from users");
$users = $query->fetchAll(PDO::FETCH_ASSOC);
foreach ($users as $user) {
    ?>
    <tr>
        <td scope="row"><?php echo $user['name']?></td>
        <td><?php echo $user['email']?></td>
        <td><?php echo $user['password']?></td>
    </tr>
    <?php
}

?>