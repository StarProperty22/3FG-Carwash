<?php
// Start session
session_start();

// Redirect to admin dashboard if session exists
if (isset($_SESSION['id_user'])) {
    header("Location: ./admin.php");
    die();
}

// Include database connection
include "koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aplikasi 3FG Carwash </title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style type="text/css">
        body {
            padding-top: 40px;
            padding-bottom: 40px;
            background: linear-gradient(to right, #00c6ff, #0072ff);
            font-family: 'Montserrat', sans-serif;
        }
        .card {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            background-color: white;
        }
        .form-signin {
            width: 100%;
        }
        .form-signin .form-control {
            height: auto;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ddd;
            transition: border-color 0.3s;
        }
        .form-signin .form-control:focus {
            border-color: #0072ff;
            box-shadow: 0 0 5px rgba(0, 114, 255, 0.5);
        }
        .btn-primary {
            background-color: #0072ff;
            border: none;
            border-radius: 5px;
            padding: 10px;
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn-primary:hover {
            background-color: #005bb5;
            transform: translateY(-2px);
        }
        .alert-message {
            margin-bottom: 15px;
        }
        
    </style>
</head>

<body>

<div class="container">
    <?php
    // Handle login form submission
    if (isset($_REQUEST['login'])) {
        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];

        $sql = mysqli_query($koneksi, "SELECT id_user, username, nama, level FROM user WHERE username='$username' AND password=MD5('$password')");

        if ($sql) {
            list($id_user, $username, $nama, $level) = mysqli_fetch_array($sql);
            $_SESSION['id_user'] = $id_user;
            $_SESSION['username'] = $username;
            $_SESSION['nama'] = $nama;
            $_SESSION['level'] = $level;

            header("Location: ./admin.php");
            die();
        } else {
            $_SESSION['err'] = '<strong>ERROR!</strong> Username dan Password tidak ditemukan.';
            header('Location: ./');
            die();
        }
    } else {
    ?>
        <div class="card animate__animated animate__fadeInDown">
            <form class="form-signin" method="post" action="" role="form">
                <?php
                if (isset($_SESSION['err'])) {
                    $err = $_SESSION['err'];
                    echo '<div class="alert alert-warning alert-message">' . $err . '</div>';
                    unset($_SESSION['err']);
                }
                ?>
                <h2 class="form-signin-heading text-center">Login User</h2>
				<input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Login</button>
        <a href="register.php" class="btn btn-link">Daftar Akun</a>
    </form>
</div>
            </form>
        </div>
    <?php
    }
    ?>
</div> <!-- /container -->

<!-- Bootstrap core JavaScript, Placed at the end of the document so the pages load faster -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(".alert-message").alert().delay(3000).slideUp('slow');
</script>
</body>
</html>