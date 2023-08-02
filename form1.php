<?php
require 'function.php';
require 'text.php';

if (isset($_POST['show'])) {
    $fname = check($_POST['fname']);
    $uname = check($_POST['uname']);
    $pass = check($_POST['pass']);
    $email = check($_POST['email']);
    $comments = check($_POST['comments']);

    $error = array();

    // Validate input fields
    if (empty($fname) || !ctype_alpha(str_replace(' ', '', $fname)) || strlen($fname) > 20) {
        $error['fname'] = 'Invalid full name';
    }

    if (empty($uname) || !ctype_alnum($uname) || strlen($uname) > 15) {
        $error['uname'] = 'Invalid user name';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?"); // bindparam
        $stmt->execute([$uname]);
        if ($stmt->rowCount() > 0) {
            $error['uname'] = 'Username already exists';
        }
    }

    if (empty($pass) || !ctype_alnum($pass) || strlen($pass) < 6 || strlen($pass) > 20) {
        $error['pass'] = 'Invalid password';
    } else {
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = 'Invalid email';
    }

    if (empty($_POST['gender'])) {
        $error['gender'] = 'Please choose your gender';
    } else {
        $gender = $_POST['gender'];
    }

    // Insert data to database
    if (empty($error)) {
        $stmt = $pdo->prepare("INSERT INTO users (username,password,full_name,email)
        VALUES (:uname, :hashed_password, :fname, :email)");

        $stmt->bindParam(':uname', $uname);
        $stmt->bindParam(':hashed_password', $hashed_password);
        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':email', $email);

        $stmt->execute();
        header('Location: login.php');
        exit();
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
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

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        td {
            padding: 10px;
            border: 1px solid #ccc;
            font-size: 16px;
            color: #333;
            vertical-align: middle;
        }

        td:first-child {
            font-weight: bold;
            width: 150px;
        }

        input[type="text"],
        input[type="password"],
        input[type="file"],
        textarea {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 3px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            font-size: 16px;
            color: #333;
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        input[type="submit"],
        input[type="reset"] {
            background-color: #008000;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        input[type="submit"]:hover,
        input[type="reset"]:hover {
            background-color: #005500;
        }
    </style>
</head>
<body>
<h1>0d.N0t3 Signup</h1>
<form method="post" enctype="multipart/form-data">
    Full name:<br>
    <input type="text" name="fname" placeholder="Full name" value="<?php echo isset($fname) ? $fname : ''; ?>">
    <?php echo isset($error['fname']) ? '<b>'.$error['fname'].'</b><br><br>' : ''; ?>

    User name:<br>
    <input type="text" name="uname" placeholder="User name" value="<?php echo isset($uname) ? $uname : ''; ?>">
    <?php echo isset($error['uname']) ? '<b>'.$error['uname'].'</b><br><br>' : ''; ?>

    Password:<br>
    <input type="password" name="pass" placeholder="Password">
    <?php echo isset($error['pass']) ? '<b>'.$error['pass'].'</b><br><br>' : ''; ?>

    Email:<br>
    <input type="text" name="email" placeholder="Email" value="<?php echo isset($email) ? $email :''; ?>">
    <?php echo isset($error['email']) ? '<b>'.$error['email'].'</b><br><br>' : ''; ?>

    Gender:<br>
    <input type="radio" name="gender" value="Male" <?php echo isset($gender) && $gender == 'Male' ? 'checked' : ''; ?>>Male
    <input type="radio" name="gender" value="Female" <?php echo isset($gender) && $gender == 'Female' ? 'checked' : ''; ?>>Female
    <?php echo isset($error['gender']) ? '<b>'.$error['gender'].'</b><br><br>' : ''; ?>

    <br><br>Comments:<br>
    <textarea name="comments" placeholder="Comments"><?php echo isset($comments) ? $comments : ''; ?></textarea><br><br>

    <input type="submit" name="show" value="Sign up">
    <input type="reset" value="Reset">
</form>
</body>
</html>
