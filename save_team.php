<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['team_name'], $_POST['matches_played'], $_POST['wins'], $_POST['losses'], $_POST['draws'], $_POST['points'], $_POST['remaining_games'])) {
        $team_name = $_POST['team_name'];
        $matches_played = $_POST['matches_played'];
        $wins = $_POST['wins'];
        $losses = $_POST['losses'];
        $draws = $_POST['draws'];
        $points = $_POST['points'];
        $remaining_games = $_POST['remaining_games'];

        $conn = new mysqli('localhost', 'root', '', 'football_league');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare the SQL statement with the correct number of placeholders
        $stmt = $conn->prepare("INSERT INTO football_teams (team_name, matches_played, wins, losses, draws, points, remaining_games) VALUES (?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE matches_played = VALUES(matches_played), wins = VALUES(wins), losses = VALUES(losses), draws = VALUES(draws), points = VALUES(points), remaining_games = VALUES(remaining_games)");

        // Bind the parameters correctly
        $stmt->bind_param('siiiiii', $team_name, $matches_played, $wins, $losses, $draws, $points, $remaining_games);

        if ($stmt->execute()) {
            echo "<div class='alert success'>Team data saved successfully!</div>";
        } else {
            echo "<div class='alert error'>Error: " . $stmt->error . "</div>";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "<div class='alert error'>Error: Missing form data.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Save Team Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .alert {
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
        }
        .alert.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php">Back to Data Entry</a>
                <a href="generate_report.php" class="btn">Generate Report</a>

    </div>
</body>
</html>
