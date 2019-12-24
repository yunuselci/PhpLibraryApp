<?php
require_once 'db_connect.php';
if (isset($_POST['submit'])) {
    $sql = "SELECT * FROM users WHERE firstname=:firstname";
    $query = $db_connect->prepare($sql);
    $query->bindParam(':firstname', $_POST['firstname']);
    $query->execute();
    $returned_row = $query->fetch(PDO::FETCH_ASSOC);
    $owner_id = $returned_row['id_users'];
    $temp_owner_id = $returned_row['id_users'];
    $name = $_POST['name'] ?? null;
    $author = $_POST['author'] ?? null;
    $image_url = $_POST['image_url'] ?? null;
    $language = $_POST['language'] ?? null;
    $errors_from_post = [];
    if (!$name) {
        array_push($errors_from_post, "İsim");
    }
    if (!$author) {
        array_push($errors_from_post, "Yazar");
    }
    if (!$image_url) {
        array_push($errors_from_post, "Link");
    }
    if (!$language) {
        array_push($errors_from_post, "Dil");
    }
    if (!$owner_id) {
        array_push($errors_from_post, "Sahip");
    }
    if (!$temp_owner_id) {
        array_push($errors_from_post, "Kişi");
    }
    if (!$name || !$author || !$image_url || !$language || !$owner_id || !$temp_owner_id) {
        foreach ($errors_from_post as $value) {
            echo '<div class="alert alert-danger" role="alert">' . $value . ' Girmediniz<br>' . '</div>';
        }
    } else {
        try {
            if ($book->add($name, $author, $image_url, $language, $owner_id, $temp_owner_id)) {
                echo "Registered";
            }
        } catch (PDOException $exception) {
            array_push($errors, $exception->getMessage());
        }
    }
}
?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<!DOCTYPE html>
<html>

<head>
    <title>Sign Up Page</title>
    <!--Made with love by Mutiullah Samim -->

    <!--Bootsrap 4 CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!--Custom styles-->
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
<div class="container">
    <div class="d-flex justify-content-center h-100">
        <div class="card">
            <div class="card-header">
                <h3>Kitap Ekle,Tüm Alanlar Zorunludur</h3>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                        </div>
                        <input type="text" class="form-control" name="name" placeholder="Kitap İsmi" required>
                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                        </div>
                        <input type="text" class="form-control" name="author" placeholder="Yazarı" required>

                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                        </div>
                        <input type="text" class="form-control" name="image_url" placeholder="Kitap Resmi İçin Link"
                               required>

                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                        </div>
                        <input type="text" class="form-control" name="language" placeholder="Kitap dili" required>

                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                        </div>
                        <div class="custom-select" style="width:200px;">
                            <select name="firstname">
                                <?php
                                $users = "SELECT * FROM users ORDER BY id_users";
                                $query = $db_connect->prepare($users);
                                $query->execute();

                                foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $item) {
                                    ?>
                                    <option value="<?php $item['firstname']; ?>"><?php echo $item["firstname"]; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row align-items-center remember">
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" value="Ekle" class="btn float-right login_btn">
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-center links">
                    <a href="home.php">Geri Dön</a>
                </div>

            </div>
        </div>
    </div>
</div>
</body>