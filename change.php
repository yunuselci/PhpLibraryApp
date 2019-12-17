<?php
include_once 'db_connect.php';
try {
    $sql = "SELECT * FROM users WHERE id_users=:id_users";
    $query = $db_connect->prepare($sql);
    $query->bindParam(':id_users', $_SESSION['user_session']);
    $query->execute();
    $returned_row = $query->fetch(PDO::FETCH_ASSOC);
    $id_to_change = $returned_row['id_users'];
} catch (PDOException $exception) {
    array_push($errors, $exception->getMessage());
}
if (isset($_POST['username'])) {
    $username = $_POST['username'] ?? null;
    if (empty($username)) {
        echo '<div class="alert alert-danger" role="alert">' . 'Güncellemek İstediğiz Değer Boş Olamaz<br>' . '</div>';
    } else {
        try {
            $sql = "SELECT username FROM users WHERE username=:username";
            $query = $db_connect->prepare($sql);
            $query->bindParam(':username', $username);
            $query->execute();
            $returned_clashes_row = $query->fetch(PDO::FETCH_ASSOC);
            if ($returned_clashes_row['username'] == $username) {
                echo '<div class="alert alert-danger" role="alert"> Kullanıcı Adı Zaten Alınmış<br>' . '</div>';
            } else {
                if ($user->updateUsername($username, $id_to_change)) {
                    echo "updated";
                }
            }
        } catch (PDOException $exception) {
            array_push($errors, $exception->getMessage());
        }
    }
}
if (isset($_POST['password'])) {
    $password = $_POST['password'] ?? null;
    if (empty($password)) {
        echo '<div class="alert alert-danger" role="alert">' . 'Güncellemek İstediğiiz Değer Boş Olamaz<br>' . '</div>';
    } else {
        try {
            $sql = "SELECT password FROM users WHERE password=:password";
            $query = $db_connect->prepare($sql);
            $query->bindParam(':password', $password);
            $query->execute();
            $returned_clashes_row = $query->fetch(PDO::FETCH_ASSOC);
            if ($user->updatePassword($password, $id_to_change)) {
                echo "updated";
            }
        } catch (PDOException $exception) {
            array_push($errors, $exception->getMessage());
        }
    }
}

if (isset($_POST['firstname'])) {
    $firstname = $_POST['firstname'] ?? null;
    if (empty($firstname)) {
        echo '<div class="alert alert-danger" role="alert">' . 'Güncellemek İstediğiiz Değer Boş Olamaz<br>' . '</div>';
    } else {
        try {
            $sql = "SELECT firstname FROM users WHERE firstname=:firstname";
            $query = $db_connect->prepare($sql);
            $query->bindParam(':firstname', $firstname);
            $query->execute();
            $returned_clashes_row = $query->fetch(PDO::FETCH_ASSOC);
            if ($user->updateFirstname($firstname, $id_to_change)) {
                echo "updated";
            }
        } catch (PDOException $exception) {
            array_push($errors, $exception->getMessage());
        }
    }
}

if (isset($_POST['lastname'])) {
    $lastname = $_POST['lastname'] ?? null;
    if (empty($lastname)) {
        echo '<div class="alert alert-danger" role="alert">' . 'Güncellemek İstediğiiz Değer Boş Olamaz<br>' . '</div>';
    } else {
        try {
            $sql = "SELECT lastname FROM users WHERE lastname=:lastname";
            $query = $db_connect->prepare($sql);
            $query->bindParam(':lastname', $lastname);
            $query->execute();
            $returned_clashes_row = $query->fetch(PDO::FETCH_ASSOC);
            if ($user->updateLastname($lastname, $id_to_change)) {
                echo "updated";
            }
        } catch (PDOException $exception) {
            array_push($errors, $exception->getMessage());
        }
    }
}
if (isset($_POST['phone_number'])) {
    $phone_number = $_POST['phone_number'] ?? null;
    if (empty($phone_number)) {
        echo '<div class="alert alert-danger" role="alert">' . 'Güncellemek İstediğiiz Değer Boş Olamaz<br>' . '</div>';
    } else {
        try {
            $sql = "SELECT phone_number FROM users WHERE phone_number=:phone_number";
            $query = $db_connect->prepare($sql);
            $query->bindParam(':phone_number', $phone_number);
            $query->execute();
            $returned_clashes_row = $query->fetch(PDO::FETCH_ASSOC);
            if ($user->updatePhone_number($phone_number, $id_to_change)) {
                echo "updated";
            }
        } catch (PDOException $exception) {
            array_push($errors, $exception->getMessage());
        }
    }
}

if (isset($_POST['email'])) {
    $email = $_POST['email'] ?? null;
    if (empty($email)) {
        echo '<div class="alert alert-danger" role="alert">' . 'Güncellemek İstediğiz Değer Boş Olamaz<br>' . '</div>';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<div class="alert alert-danger" role="alert">' . 'Geçerli Bir E-Posta Girmediniz<br>' . '</div>';
    } else {
        try {
            $sql = "SELECT email FROM users WHERE email=:email";
            $query = $db_connect->prepare($sql);
            $query->bindParam(':email', $email);
            $query->execute();
            $returned_clashes_row = $query->fetch(PDO::FETCH_ASSOC);
            if ($returned_clashes_row['email'] == $email) {
                echo '<div class="alert alert-danger" role="alert"> Email Zaten Alınmış<br>' . '</div>';
            } else {
                if ($user->updateEmail($email, $id_to_change)) {
                    echo "updated";
                }
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
<!DOCTYPE html>
<html>

<head>
    <title>Sign Up Page</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
<div class="container">
    <div class="d-flex justify-content-center h-100">
        <div class="card">
            <div class="card-header">
                <h3><?= $returned_row['username']; ?> İçin Yeni Bilgileri Giriniz</h3>

            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" name="username"
                               placeholder="<?= $returned_row['username']; ?>">
                        <div class="form-group">
                            <input type="submit" name="Güncelle" value="Güncelle" class="btn float-right login_btn">
                        </div>
                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" class="form-control" name="password" placeholder="Yeni Şifre">
                        <div class="form-group">
                            <input type="submit" value="Güncelle" class="btn float-right login_btn">
                        </div>

                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                        </div>
                        <input type="text" class="form-control" name="firstname"
                               placeholder="<?= $returned_row['firstname']; ?>">
                        <div class="form-group">
                            <input type="submit" value="Güncelle" class="btn float-right login_btn">
                        </div>

                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                        </div>
                        <input type="text" class="form-control" name="lastname"
                               placeholder="<?= $returned_row['lastname']; ?>">
                        <div class="form-group">
                            <input type="submit" value="Güncelle" class="btn float-right login_btn">
                        </div>

                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                        </div>
                        <input type="text" class="form-control" name="phone_number"
                               placeholder="<?= $returned_row['phone_number']; ?>">
                        <div class="form-group">
                            <input type="submit" value="Güncelle" class="btn float-right login_btn">
                        </div>

                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                        </div>
                        <input type="email" class="form-control" name="email"
                               placeholder="<?= $returned_row['email']; ?>">
                        <div class="form-group">
                            <input type="submit" value="Güncelle" class="btn float-right login_btn">
                        </div>

                    </div>

                    <div class="row align-items-center remember">
                    </div>

                </form>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-center links">
                    <a href="home.php">Anasayfan</a>
                </div>

            </div>
        </div>
    </div>
</div>
</body>

</html>