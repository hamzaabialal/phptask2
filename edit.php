<?php
$conn = new mysqli('localhost', 'root', '', 'football_league');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM football_teams WHERE id = $id");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die("No record found with ID $id");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $team_name = $conn->real_escape_string($_POST['team_name']);
    $matches_played = intval($_POST['matches_played']);
    $wins = intval($_POST['wins']);
    $losses = intval($_POST['losses']);
    $draws = intval($_POST['draws']);
    $points = intval($_POST['points']);
    $remaining_games = intval($_POST['remaining_games']);

    $sql = "UPDATE football_teams SET
            team_name = '$team_name',
            matches_played = $matches_played,
            wins = $wins,
            losses = $losses,
            draws = $draws,
            points = $points,
            remaining_games = $remaining_games
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: generate_report.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Team</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        form div {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 0 auto;
            display: block;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }
        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Team</h1>
        <form method="post" action="edit.php">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
            <div>
                <label for="team_name">Team Name</label>
                <input type="text" id="team_name" name="team_name" value="<?php echo htmlspecialchars($row['team_name']); ?>" required>
            </div>
            <div>
                <label for="matches_played">Matches Played</label>
                <input type="number" id="matches_played" name="matches_played" value="<?php echo htmlspecialchars($row['matches_played']); ?>" required>
            </div>
            <div>
                <label for="wins">Wins</label>
                <input type="number" id="wins" name="wins" value="<?php echo htmlspecialchars($row['wins']); ?>" required>
            </div>
            <div>
                <label for="losses">Losses</label>
                <input type="number" id="losses" name="losses" value="<?php echo htmlspecialchars($row['losses']); ?>" required>
            </div>
            <div>
                <label for="draws">Draws</label>
                <input type="number" id="draws" name="draws" value="<?php echo htmlspecialchars($row['draws']); ?>" required>
            </div>
            <div>
                <label for="points">Points</label>
                <input type="number" id="points" name="points" value="<?php echo htmlspecialchars($row['points']); ?>" required>
            </div>
            <div>
                <label for="remaining_games">Remaining Games</label>
                <input type="number" id="remaining_games" name="remaining_games" value="<?php echo htmlspecialchars($row['remaining_games']); ?>" required>
            </div>
            <div>
                <button type="submit">Update</button>
            </div>
        </form>
    </div>
</body>
</html>
