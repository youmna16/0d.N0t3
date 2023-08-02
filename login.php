<?php
// $_SESSION
require 'text.php'; // include the database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindparam(':username',$username);
    $stmt->execute();
    $user = $stmt->fetch();


    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $user[id];


        $token = bin2hex(openssl_random_pseudo_bytes(16));
        setcookie('auth_token', $token, time() + 3600, '/', '', true, true);
        mysqli_query($conn, "UPDATE users SET token = '$token' WHERE id = $user[id]");

        header("Location: note.php");
        exit();

    } else {
        $error_message = "Incorrect username or password.";
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>
    <style>
      body {
        background-color: #f2f2f2;
      }

      h1 {
        text-align: center;
        color: #333;
      }

      form {
        width: 50%;
        margin: 0 auto;
        background-color: #fff;
        border-radius: 5px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
      }

      label {
        display: block;
        margin-bottom: 10px;
        color: #666;
      }

      input[type="text"],
      input[type="password"] {
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 3px;
        margin-bottom: 20px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        font-size: 16px;
        color: #333;
      }

      button {
        background-color: #008000;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
      }

      button:hover {
        background-color: #005500;
      }

      .container {
        padding: 16px;
      }
    </style>
  </head>
  <body>
    <h1>0d.N0t3 Signin</h1>

    <form method="post">
      <div class="container">
        <label for="username"><b>Username</b></label>
        <input type="text" id="username" name="username" placeholder="Enter Username" required>

        <label for="password"><b>Password</b></label>
        <input type="password" id="password" name="password" placeholder="Enter Password" required>
        <?php echo $_GET['err'].'<br><br>'; ?>
        <?php if (isset($error_message)): ?>
          <p style="color: red "><?= $error_message ?></p>
        <?php endif; ?>
        <button type="submit">Login</button>
      </div>
    </form>
  </body>
</html>
