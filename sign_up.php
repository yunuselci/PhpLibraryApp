<?php
require_once 'db_connect.php';
if (isset($_POST['submit'])) {
    $username = $_POST['username'] ?? null;
    $password = $_POST['password'] ?? null;
    $firstname = $_POST['firstname'] ?? null;
    $lastname = $_POST['lastname'] ?? null;
    $phone_number = $_POST['phone_number'] ?? null;
    $email = $_POST['email'] ?? null;
    $errors_from_post = [];
    if (!$username) {
        array_push($errors_from_post, "Kullanıcı Adı");
    }if (!$password) {
        array_push($errors_from_post, "Şifre");
    }if (!$firstname) {
        array_push($errors_from_post, "İsim");
    }if (!$lastname) {
        array_push($errors_from_post, "Soy İsim");
    }if (!$phone_number) {
        array_push($errors_from_post, "Telefon Numarası");
    }if (!$email) {
        array_push($errors_from_post, "Email");
    }if (!$username || !$password || !$firstname || !$lastname || !$email || !$phone_number) {
        /*$length = count($error_messages);
        for($i=0; $i<$length; $i++){
            echo $error_messages[$i]." Girmediniz".'<br>';
        }*/
        foreach ($errors_from_post as $value) {
            echo '<div class="alert alert-danger" role="alert">' . $value . ' Girmediniz<br>' . '</div>';
        }
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<div class="alert alert-danger" role="alert">' . 'Geçerli Bir E-Posta Girmediniz<br>' . '</div>';
    } else {
        try {
            $sql = "SELECT username, email FROM users WHERE username=:username OR email=:email";
            $query = $db_connect->prepare($sql);
            $query->bindParam(':username', $username);
            $query->bindParam(':email', $email);
            $query->execute();
            $returned_clashes_row = $query->fetch(PDO::FETCH_ASSOC);
            if ($returned_clashes_row['username'] == $username) {
                echo '<div class="alert alert-danger" role="alert"> Kullanıcı Adı Zaten Alınmış<br>' . '</div>';
                //array_push($errors, "Kullanıcı adı zaten alınmış.Lütfen farklı bir tane seçin.");
            } elseif ($returned_clashes_row['email'] == $email) {
                echo '<div class="alert alert-danger" role="alert"> E-Mail Adresi Zaten Mevcut<br>' . '</div>';
                //array_push($errors, "E-Mail adresi zaten alınmış.Lütfen farklı bir tane seçin.");
            } else {
                if ($user->register($firstname, $lastname, $email,$username,$password,$phone_number)) {
                    echo "Registered";
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
<!------ Include the above in your HEAD tag ---------->
<!DOCTYPE html>
<html>

<head>
    <title>Sign Up Page</title>
    <!--Made with love by Mutiullah Samim -->

    <!--Bootsrap 4 CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!--Custom styles-->
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
<div class="container">
    <div class="d-flex justify-content-center h-100">
        <div class="card">
            <div class="card-header">
                <h3>Kayıt Ol</h3>
                <div class="d-flex justify-content-end social_icon">
                    <span><i class="fab fa-facebook-square"></i></span>
                    <span><i class="fab fa-google-plus-square"></i></span>
                    <span><i class="fab fa-twitter-square"></i></span>
                </div>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" name="username" placeholder="Kullanıcı Adı" required>
                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" class="form-control" name="password" placeholder="Şifre" required>

                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                        </div>
                        <input type="text" class="form-control" name="firstname" placeholder="İsim" required>

                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                        </div>
                        <input type="text" class="form-control" name="lastname" placeholder="Soyisim" required>

                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                        </div>
                        <input type="text" class="form-control" name="phone_number" placeholder="Telefon Numaranız" required>

                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                        </div>
                        <input type="email" class="form-control" name="email" placeholder="E-Mail" required>

                    </div>

                    <div class="row align-items-center remember">
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" value="Kayıt Ol" class="btn float-right login_btn">
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-center links">
                    <a href="sign_in.php">Giriş Yap</a>
                </div>

            </div>
        </div>
    </div>
</div>
</body>

</html>