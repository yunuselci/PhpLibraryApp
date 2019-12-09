<?php

include_once 'db_connect.php';
if (!$user->is_logged_in()) {
    $user->redirect('index.php');
}

try {
    $sql = "SELECT * FROM users WHERE id=:id";
    $query = $db_connect->prepare($sql);
    $query->bindParam(':id', $_SESSION['user_session']);
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

<?php if (count($errors > 0)): ?>
    <p>Error(s):</p>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach ?>
    </ul>
<?php endif ?>

<p>Welcome, <?= $returned_row['username']; ?>. <a href="?logout=true">Log out</a></p>
</body>
</html>
