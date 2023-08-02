<?php
session_start();

if (empty($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

require_once 'text.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $note_id = $_POST['note_id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM notes WHERE id = :note_id");
        $stmt->bindparam(':note_id',$note_id);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error deleting note: " . $e->getMessage();
    }
}

header("Location: note.php");
exit();
?>
