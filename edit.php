<?php
session_start();

if (empty($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

require_once 'text.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $note_id = $_GET['note_id'];

    try {
        $stmt = $pdo->prepare("SELECT title, content FROM notes WHERE id = :note_id");
        $stmt->bindparam(':note_id',$note_id);
        $stmt->execute();
        $note = $stmt->fetch();
    } catch (PDOException $e) {
        echo "Error retrieving note: " . $e->getMessage();
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $note_id = $_POST['note_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    try {
        $stmt = $pdo->prepare("UPDATE notes SET title = :title, content = :content WHERE id = :note_id");
        $stmt->bindparam(':title',$title);
        $stmt->bindparam(':content',$content);
        $stmt->bindparam(':note_id',$note_id);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error updating note: " . $e->getMessage();
    }

    header("Location: note.php");
    exit();
} else {
    header("Location: note.php");
    exit();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Edit Note</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;

        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px #ddd;
        }
        h1 {
            font-size: 32px;
            text-align: center;
            margin-bottom: 20px;
        }
        form label {
            display: block;
            font-size: 20px;
            margin-bottom: 10px;
        }
        form input[type="text"],
        form textarea {
            display: block;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 20px;
        }
        form input[type="submit"] {
            background-color: #008000;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        form input[type="submit"]:hover {
            background-color: #3e8e41;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Note</h1>
        <form method="post">
            <label>Title:</label>
            <input type="text" name="title" value="<?= $note['title'] ?>" required>
            <label>Content:</label>
            <textarea name="content" required><?= $note['content'] ?></textarea>
            <input type="hidden" name="note_id" value="<?= $note_id ?>">
            <input type="submit" value="Save">
        </form>
    </div>
</body>
</html>
