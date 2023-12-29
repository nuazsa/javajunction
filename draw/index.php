<?php

require_once '../component/functions.php';

function getParticipantsFromDatabase() {
    global $conn; // Pastikan koneksi database sudah dibuat

    $query = "SELECT invoice FROM `orders`"; // Gantilah `ORDER` dengan nama tabel yang benar
    $stmt = $conn->query($query);
    
    if ($stmt) {
        $participants = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $participants;
    } else {
        // Handle kesalahan jika query gagal dieksekusi
        return [];
    }
}

function drawWinnerFromDatabase() {
    $participants = getParticipantsFromDatabase();
    
    if (!empty($participants)) {
        $winnerIndex = array_rand($participants);
        return $participants[$winnerIndex];
    } else {
        // Handle jika tidak ada peserta atau terjadi kesalahan
        return "Tidak ada peserta";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lucky Draw</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            text-align: center;
            margin: 50px;
        }

        h1 {
            color: #333;
        }

        p {
            color: #666;
            margin-bottom: 20px;
        }

        button {
            padding: 5px 15px;
            font-size: 18px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        #loading, #result {
            display: none;
            font-size: 100px;
            margin-top: 60px;
            color: #333;
        }

        #result {
            color: #4CAF50;
            font-weight: bold;
            font-size: 100px;
            margin-top: 60px;
        }
    </style>
</head>
<body>
    <h1>Welcome to the Lucky Draw JavaJunction Home</h1>
    <p>Click the button to start the draw:</p>
    <button onclick="startLottery()">Start Draw</button>
    <div id="loading">Drawing in progress...</div>
    <div id="result"></div>

    <script>
        function startLottery() {
            document.getElementById('result').style.display = 'none';
            document.getElementById('result').innerHTML = '';
            document.getElementById('loading').style.display = 'block';

            const participants = <?php echo json_encode(getParticipantsFromDatabase()); ?>;
            let shuffledParticipants = participants.slice(); // Salin array peserta

            // Acak urutan nama menggunakan Fisher-Yates shuffle
            function shuffleArray(array) {
                for (let i = array.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [array[i], array[j]] = [array[j], array[i]];
                }
            }

            let startTime = Date.now();

            function displayRandomName() {
                let currentTime = Date.now();
                let elapsedTime = currentTime - startTime;

                if (elapsedTime < 10000) {
                    shuffleArray(shuffledParticipants);
                    document.getElementById('loading').innerHTML = 'Searching: ' + shuffledParticipants[0];
                    setTimeout(displayRandomName, 100); // Tampilkan nama secara acak selama 0.5 detik
                } else {
                    setTimeout(function() {
                        document.getElementById('loading').style.display = 'none';
                        let winner = shuffledParticipants[Math.floor(Math.random() * shuffledParticipants.length)];
                        document.getElementById('result').innerHTML = 'Winner: ' + winner;
                        document.getElementById('result').style.display = 'block';
                    }, 1000); // Tunggu 1 detik setelah selesai menampilkan nama-nama
                }
            }

            setTimeout(displayRandomName, 500);
        }
    </script>
</body>
</html>