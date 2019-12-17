<?php
include_once 'db_connect.php';

if (!$user->is_logged_in()) {
    redirect('index.php');
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
    redirect('index.php');
}

if (isset($_POST['takebook_id'])) {
    $id_books = $_POST['takebook_id'];
    $id_user = $returned_row['id_users'];
    try {
        $sql = "SELECT temp_owner_id FROM books WHERE id_books=:id_books";
        $query = $db_connect->prepare($sql);
        $query->bindParam(':id_books', $id_books);
        $query->execute();
        $returned_clashes_row = $query->fetch(PDO::FETCH_ASSOC);
        if ($book->takeBook($id_user, $id_books)) {
            echo "updated";
        }
    } catch (PDOException $exception) {
        array_push($errors, $exception->getMessage());
    }
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
<form action="" method="post">
    <div class="input-group form-group">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-user"></i></span>
        </div>
        <input type="text" class="form-control" name="takebook_id" placeholder="Almak Istediginiz Kitap ID" required>
    </div>
    <div class="row align-items-center remember">
    </div>
    <div class="form-group">
        <input type="submit" name="submit" value="Kitabı Al" class="btn float-right login_btn">
    </div>
</form>


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
    $query = "SELECT * FROM users";
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
    $show = "SELECT users.*, b1.*, b2.*, b1.name AS books_owner_name, b2.name AS books_temp_owner FROM users 
                                   LEFT JOIN books AS b1 ON (users.id_users=b1.owner_id)
                                   LEFT JOIN books AS b2 ON (users.id_users=b2.temp_owner_id)  
                                                 WHERE users.id_users=:id_users 
                                                 ORDER BY users.id_users ASC LIMIT $starting_limit,$limit";
    $r = $db_connect->prepare($show);
    $r->bindParam(':id_users', $returned_row['id_users']);
    $r->execute();
    foreach ($r->fetchAll(PDO::FETCH_ASSOC) as $item) {
        ?>
        <tr>
            <td><?php echo $item["id_users"]; ?></td>
            <td><?php echo $item["firstname"]; ?></td>
            <td><?php echo $item["lastname"]; ?></td>
            <td><?php echo $item["email"]; ?></td>
            <td><?php echo $item["phone_number"]; ?></td>
            <td><?php echo $item["books_owner_name"]; ?></td>
            <td><?php echo $item["books_temp_owner"]; ?></td>
        </tr>
        <?php
    }


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
    $show = "SELECT books.*, u1.*, u2.*, u1.firstname AS owner_firstname, u2.firstname AS temp_owner_firstname FROM books 
                                   LEFT JOIN users AS u1 ON (books.owner_id=u1.id_users)
                                   LEFT JOIN users AS u2 ON (books.temp_owner_id=u2.id_users)  
                                                 ORDER BY books.id_books ASC LIMIT $starting_limit,$limit";
    $r = $db_connect->prepare($show);
    $r->bindParam(':id_users', $returned_row['id_users']);
    $r->execute();
    foreach ($r->fetchAll(PDO::FETCH_ASSOC) as $item) {
        ?>
        <tr>
            <td><?php echo $item["id_books"]; ?></td>
            <td><?php echo $item["name"]; ?></td>
            <td><?php echo $item["author"]; ?></td>
            <td><?php echo $item["language"]; ?></td>
            <td><?php echo $item["owner_firstname"]; ?></td>
            <td><?php echo $item["temp_owner_firstname"]; ?></td>
        </tr>
        <?php
    }

    for ($page = 1; $page <= $total_pages; $page++) : ?>
        <a href='<?php echo "?page=$page"; ?>' class="btn float login_btn"><?php echo $page; ?>
        </a>
    <?php endfor; ?>
    </tbody>
</table>
</body>

</html>