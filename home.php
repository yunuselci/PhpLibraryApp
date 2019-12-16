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
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
<h1>Home</h1>
<p>Welcome, <?= $returned_row['username']; ?>. <a href="?logout=true">Log out</a></p>
<p>Kullanıcı Bilgilerini <a href="change.php">Düzenle!</a></p>
<p>Kitap <a href="add_book.php">Ekle!</a></p>


</table>
<table class="table table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>Isim</th>
        <th>Soy Isim</th>
        <th>Email</th>
        <th>Telefon Numarası</th>
        <th>Sahip Olduğunuz Kitaplar</th>
        <th>Şuan Elinizde Olan Kitaplar</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $limit = 5;
    $query = "SELECT * FROM users WHERE id_users=:id_users";
    $s = $db_connect->prepare($query);
    $s->bindParam(':id_users', $returned_row['id_users']);
    $s->execute();
    $total_results = $s->rowCount();
    $total_pages = ceil($total_results / $limit);
    if (!isset($_GET['page'])) {
        $page = 1;
    } else {
        $page = $_GET['page'];
    }
    $starting_limit = ($page - 1) * $limit;
    $show = "SELECT * FROM users WHERE id_users=:id_users ORDER BY id_users ASC LIMIT $starting_limit,$limit";
    $r = $db_connect->prepare($show);
    $r->bindParam(':id_users', $returned_row['id_users']);
    $r->execute();
    $show_books = "SELECT * FROM books WHERE owner_id=:id_usersORDER BY id_books ASC LIMIT $starting_limit,$limit";
    $rb = $db_connect->prepare($show_books);
    $rb->bindParam('id_users', $returned_row['id_users']);
    $rb->execute();
    $show_books_temp = "SELECT * FROM books WHERE temp_owner_id=:id_users ORDER BY id_books ASC LIMIT $starting_limit,$limit";
    $rbt = $db_connect->prepare($show_books_temp);
    $rbt->bindParam('id_users',$returned_row['id_users']);
    $rbt->execute();
    while ($res = $r->fetch(PDO::FETCH_ASSOC)) :
        ?>
        <tr>
            <td><?php echo $res['id_users']; ?></td>
            <td><?php echo $res['firstname']; ?></td>
            <td><?php echo $res['lastname']; ?></td>
            <td><?php echo $res['email']; ?></td>
            <td><?php echo $res['phone_number']; ?></td>
            <td></td>
            <td></td>

        </tr>
    <?php
    endwhile;
    while ($resb = $rb->fetch(PDO::FETCH_ASSOC)) :
        ?>
        <tr>
            <td><?php echo $res['id_users']; ?></td>
            <td><?php echo $res['firstname']; ?></td>
            <td><?php echo $res['lastname']; ?></td>
            <td><?php echo $res['email']; ?></td>
            <td><?php echo $res['phone_number']; ?></td>
            <td><?php echo $resb['name']; ?></td>
            <td></td>

        </tr>
    <?php
    endwhile;
    while ($resbt = $rbt->fetch(PDO::FETCH_ASSOC)) :
        ?>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><?php echo $resbt['name']; ?></td>
        </tr>
    <?php
    endwhile;
    for ($page = 1; $page <= $total_pages; $page++) : ?>
        <a href='<?php echo "?page=$page"; ?>' class="btn float login_btn"><?php echo $page; ?>
        </a>
    <?php endfor; ?>
    </tbody>
</table>
</table>
<table class="table table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>Kitap İsmi</th>
        <th>Yazarı</th>
        <th>Dil</th>
        <th>Kitap Sahibi</th>
        <th>Kitap Şuan Kimde?</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $limit = 10;
    $query = "SELECT * FROM books";
    $s = $db_connect->prepare($query);
    $s->execute();
    $total_results = $s->rowCount();
    $total_pages = ceil($total_results / $limit);
    if (!isset($_GET['page'])) {
        $page = 1;
    } else {
        $page = $_GET['page'];
    }
    $starting_limit = ($page - 1) * $limit;
    $show = "SELECT * FROM books ORDER BY id_books ASC LIMIT $starting_limit, $limit";
    $r = $db_connect->prepare($show);
    $r->execute();
    while ($res = $r->fetch(PDO::FETCH_ASSOC)) :
        ?>
        <tr>
            <td><?php echo $res['id_books']; ?></td>
            <td><?php echo $res['name']; ?></td>
            <td><?php echo $res['author']; ?></td>
            <td><?php echo $res['language']; ?></td>
            <td><?php echo $res['owner_id']; ?></td>
            <td><?php echo $res['temp_owner_id']; ?></td>

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