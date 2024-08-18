<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Football League Data Entry</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
        }

        header {
            background-color: #333;
            color: white;
            padding: 20px;
            width: 100%;
            text-align: center;
        }

        .container {
            background-color: #fff;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            margin-top: 20px;
        }

        .container h2 {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        .container label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        .container input[type="text"],
        .container input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .container input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .container input[type="submit"]:hover {
            background-color: #45a049;
        }

        .report-container {
            margin-top: 30px;
        }

        .report-container h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <header>
        <h1>Football League Data Entry</h1>
    </header>
    <div class="container">
        <h2>Data Entry</h2>
        <form id="teamForm" method="post" action="save_team.php">
            <label for="team_name">Team Name:</label>
            <input type="text" id="team_name" name="team_name" required>
            <label for="matches_played">Matches Played:</label>
            <input type="number" id="matches_played" name="matches_played" required>
            <label for="wins">Wins:</label>
            <input type="number" id="wins" name="wins" required>
            <label for="losses">Losses:</label>
            <input type="number" id="losses" name="losses" required>
            <label for="draws">Draws:</label>
            <input type="number" id="draws" name="draws" required>
            <label for="points">Points:</label>
            <input type="number" id="points" name="points" required>
            <label for="remaining_games">Remaining Games:</label>
            <input type="number" id="remaining_games" name="remaining_games" required>
            <input type="submit" value="Save Team">
        </form>


    </div>
</body>
</html>
