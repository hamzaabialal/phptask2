<?php
$conn = new mysqli('localhost', 'root', '', 'football_league');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM football_teams WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: generate_report.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
