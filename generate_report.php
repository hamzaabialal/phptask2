<?php
$conn = new mysqli('localhost', 'root', '', 'football_league');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM football_teams ORDER BY points DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Football Teams Report</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        input[type="checkbox"] {
            margin: 0;
        }
        #selectAll {
            cursor: pointer;
        }
        .chart-container {
            width: 100%;
            height: 400px;
        }
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-edit {
            background-color: #28a745;
            color: white;
        }
        .btn-edit:hover {
            background-color: #218838;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
        .btn i {
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Football Teams Report</h1>
        <?php
        if ($result->num_rows > 0) {
            echo '<table id="teamsTable">';
            echo '<thead>';
            echo '<tr>';
            echo '<th><input type="checkbox" id="selectAll"></th>';
            echo '<th>Team Name</th>';
            echo '<th>Matches Played</th>';
            echo '<th>Wins</th>';
            echo '<th>Losses</th>';
            echo '<th>Draws</th>';
            echo '<th>Points</th>';
            echo '<th>Remaining Games</th>';
            echo '<th>Actions</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            $team_names = [];
            $matches_played = [];
            $wins = [];
            $losses = [];
            $draws = [];
            $points = [];
            $remaining_games = [];

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td><input type="checkbox" name="team_ids[]" value="' . htmlspecialchars($row['id']) . '"></td>';
                echo '<td>' . htmlspecialchars($row['team_name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['matches_played']) . '</td>';
                echo '<td>' . htmlspecialchars($row['wins']) . '</td>';
                echo '<td>' . htmlspecialchars($row['losses']) . '</td>';
                echo '<td>' . htmlspecialchars($row['draws']) . '</td>';
                echo '<td>' . htmlspecialchars($row['points']) . '</td>';
                echo '<td>' . htmlspecialchars($row['remaining_games']) . '</td>';
                echo '<td>';
                echo '<button class="btn btn-edit" onclick="editRow(' . htmlspecialchars($row['id']) . ')"><i class="fas fa-edit"></i>Edit</button>';
                echo '<button class="btn btn-delete" onclick="deleteRow(' . htmlspecialchars($row['id']) . ')"><i class="fas fa-trash"></i>Delete</button>';
                echo '</td>';
                echo '</tr>';

                // Collect data for chart
                $team_names[] = $row['team_name'];
                $matches_played[] = $row['matches_played'];
                $wins[] = $row['wins'];
                $losses[] = $row['losses'];
                $draws[] = $row['draws'];
                $points[] = $row['points'];
                $remaining_games[] = $row['remaining_games'];
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p>No data found.</p>';
        }

        $conn->close();
        ?>

        <!-- Bar Chart -->
        <div class="chart-container">
            <canvas id="barChart"></canvas>
        </div>

        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        <script>
            // Get data from PHP
            const teamNames = <?php echo json_encode($team_names); ?>;
            const matchesPlayed = <?php echo json_encode($matches_played); ?>;
            const wins = <?php echo json_encode($wins); ?>;
            const losses = <?php echo json_encode($losses); ?>;
            const draws = <?php echo json_encode($draws); ?>;
            const points = <?php echo json_encode($points); ?>;
            const remainingGames = <?php echo json_encode($remaining_games); ?>;

            // Bar Chart
            const ctx = document.getElementById('barChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: teamNames,
                    datasets: [
                        {
                            label: 'Matches Played',
                            data: matchesPlayed,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Wins',
                            data: wins,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Losses',
                            data: losses,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Draws',
                            data: draws,
                            backgroundColor: 'rgba(255, 159, 64, 0.2)',
                            borderColor: 'rgba(255, 159, 64, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Points',
                            data: points,
                            backgroundColor: 'rgba(153, 102, 255, 0.2)',
                            borderColor: 'rgba(153, 102, 255, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Remaining Games',
                            data: remainingGames,
                            backgroundColor: 'rgba(255, 206, 86, 0.2)',
                            borderColor: 'rgba(255, 206, 86, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            beginAtZero: true
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            function editRow(id) {
                window.location.href = 'edit.php?id=' + id;
            }

            function deleteRow(id) {
                if (confirm('Are you sure you want to delete this team?')) {
                    window.location.href = 'delete.php?id=' + id;
                }
            }
        </script>
    </div>
</body>
</html>
