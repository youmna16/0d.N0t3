<?php
session_start();

if (empty($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

require_once 'text.php';

$user_id = $_SESSION['id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    try {
        $stmt = $pdo->prepare("INSERT INTO notes (user_id, title, content) VALUES (:user_id,:title, :content)");
        $stmt->bindparam(':user_id',$user_id);
        $stmt->bindparam(':title',$title);
        $stmt->bindparam(':content',$content);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error inserting data: " . $e->getMessage();
    }

}

$stmt = $pdo->prepare("SELECT id, title, content FROM notes WHERE user_id = :user_id");
$stmt->bindparam(':user_id',$user_id);
$stmt->execute();
$notes = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <title>0d.N0t3 - Notes</title>
    <style>
        /* Global styles */
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            /* font-family: Arial, sans-serif; */
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
            background-color: #f2f2f2;
        }

        h1, h2 {
            margin-top: 30px;
            font-weight: normal;
        }

        /* Container styles */
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 5px;
            margin-top: 50px;
        }

        /* Form styles */
        form {
            display: flex;
            flex-direction: column;
            margin-top: 30px;
        }

        label {
            font-weight: bold;
            margin-bottom: 10px;
        }

        input[type="text"],
        textarea {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            margin-bottom: 20px;
        }

        input[type="text"] {
            width: 100%;
        }

        textarea {
            width: 100%;
            height: 150px;
            resize: vertical;
        }

        input[type="submit"] {
            background-color: #008000;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #3e8e41;
        }

        /* Notes styles */
        .notes {
            margin-top: 30px;
        }

        .note {
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .note h3 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 20px;
        }

        .note p {
            margin: 0;
            font-size: 16px;
            line-height: 1.5;
        }

        .no-notes {
            margin-top: 30px;
            font-size: 16px;
            text-align: center;
        }

        /* Logout button styles */
        .logout {
            margin-top: 30px;
            text-align: center;
        }

        .logout a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ddd;
            color: #333;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .logout a:hover {
            background-color: #ccc;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>0d.N0t3</h1>
        <p>Welcome, <?= $_SESSION['username'] ?>!</p>
        <form method="post">
            <label>Title:</label>
            <input type="text" name="title" required>
            <label>Content:</label>
            <textarea name="content" required></textarea>
            <input type="submit" value="Save">
        </form>
        <div class="notes">
            <?php if (count($notes)): ?>
              <?php foreach ($notes as $note): ?>
                    <div class="note">
                        <h3><?= $note['title'] ?></h3>
                        <p><?= $note['content'] ?></p>
                        <form method="post" action="delete.php">
                            <input type="hidden" name="note_id" value="<?= $note['id'] ?>">
                            <input type="submit" value="Delete">
                        </form>
                        <form method="get" action="edit.php">
                            <input type="hidden" name="note_id" value="<?= $note['id'] ?>">
                            <input type="submit" value="Edit">
                        </form>
                    </div>
                  <?php endforeach; ?>
            <?php else: ?>
                <p class="no-notes">You haven't created any notes yet.</p>
            <?php endif; ?>
        </div>
        <div class="logout">
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
