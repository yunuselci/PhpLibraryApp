<?php

include_once 'db_connect.php';
if (!$user->is_logged_in()) {
    $user->redirect('index.php');
}
try {
    $sql = "SELECT * FROM users WHERE id_users=:id_users";
    $query = $db_connect->prepare($sql);
    $query->bindParam(':id_users', $_SESSION['user_session']);
    $query->execute();
    $returned_row = $query->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $exception) {
    array_push($errors, $exception->getMessage());
}
if (isset($_GET['logout']) && ($_GET['logout'] == 'true')) {
    $user->log_out();
    $user->redirect('index.php');
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>Home</h1>
    <p>Welcome, <?= $returned_row['username']; ?>. <a href="?logout=true">Log out</a></p>
    <p>Kullanıcı Bilgilerini <a href="change.php">Düzenle!</a></p>

    </table>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Isim</th>
                <th>Soy Isim</th>
                <th>Email</th>
                <th>Telefon Numarası</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $limit = 1;
            $query = "SELECT * FROM users WHERE id_users=:id_users";
            $s = $db_connect->prepare($query);
            $s->bindParam(':id_users', $_SESSION['user_session']);
            $s->execute();
            $total_results = $s->rowCount();
            $total_pages = ceil($total_results / $limit);
            if (!isset($_GET['page'])) {
                $page = 1;
            } else {
                $page = $_GET['page'];
            }
            $starting_limit = ($page - 1) * $limit;
            $show = "SELECT * FROM users ORDER BY id_users ASC LIMIT $starting_limit, $limit";
            $r = $db_connect->prepare($show);
            $r->execute();
            while ($res = $r->fetch(PDO::FETCH_ASSOC)) :
                ?>
                <tr>
                    <td><?php echo $res['id_users']; ?></td>
                    <td><?php echo $res['firstname']; ?></td>
                    <td><?php echo $res['lastname']; ?></td>
                    <td><?php echo $res['email']; ?></td>
                    <td><?php echo $res['phone_number']; ?></td>
                </tr>
            <?php
            endwhile;
            for ($page = 1; $page <= $total_pages; $page++) : ?>
                <a href='<?php echo "?page=$page"; ?>' class="btn float login_btn"><?php echo $page; ?>
                </a>
            <?php endfor; ?>
        </tbody>
    </table>
</body>

</html>