<?php
session_start();

function generateAvailableSeats() {
    $availableSeats = array();
    $rows = range('A', 'F');

    foreach ($rows as $row) {
        $seatsInRow = rand(4, 10); // Generating random number of seats for each row
        $tags = array("window", "aisle", "middle");
        $rowSeats = array_map(function($seatNumber) use ($row, $tags) {
            $tag = $tags[array_rand($tags)]; 
            return array("seat" => $row . $seatNumber, "tag" => $tag);
        }, range(1, $seatsInRow));
        $availableSeats = array_merge($availableSeats, $rowSeats);
    }

    shuffle($availableSeats);
    return $availableSeats;
}

if (!empty($_SESSION['selectedSeat'])) {
    $_SESSION["seat"] = $_POST['seat'];
}

$availableSeats = generateAvailableSeats();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" type="image/png" href="logos.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="seat_select.css">
    <title>Seat Selection</title>
</head>
<body>
    <header>
        <h1>Seat Selection</h1>
    </header>

    <div class="ticket">
        <h2>Ticket Details</h2>
        <p><strong>Departure:</strong> <?php echo $_SESSION['departure']; ?></p>
        <p><strong>Destination:</strong> <?php echo $_SESSION['destination']; ?></p>
        <p><strong>Date:</strong> <?php echo $_SESSION['date']; ?></p>
        <p><strong>Travel Mode:</strong> <?php echo $_SESSION['mode']; ?></p>
        <p><strong>Amount:</strong> <?php 
            if($_SESSION["mode"] == "flight"){
                echo "₹4000/-";  $_SESSION["amount"] = "4000/-";
            }else if($_SESSION["mode"] == "bus"){
                echo "₹500/-";   $_SESSION["amount"] = "500/-";
            }else if($_SESSION["mode"] == "train"){
                echo "₹250/-";   $_SESSION["amount"] = "250/-";
            }
        ?> </p>
    </div>

    <div class="seat-selection">
        <h2>Select Your Seat</h2>
        <form method="post" id="seatForm">
            <label for="seat">Choose a Seat:</label>
            <select id="seat" name="seat" name="selectedSeat">
                <?php
                foreach ($availableSeats as $seatData) {
                    echo '<option value="' . $seatData['seat'] . '">' . $seatData['seat'] . ' (' . ucfirst($seatData['tag']) . ')</option>';
                }
                ?>
            </select>
            <input type="hidden" id="selectedSeat"  value="">
            <button type="button" id="proceedButton" name="proceedButton" class="button">Proceed to Payment</button>
        </form>
    </div>


    <footer>
        <p>&copy; <?php echo date("Y"); ?> Seat Selection. All rights reserved.</p>
    </footer>

    <script>
     document.getElementById('proceedButton').addEventListener('click', function() {
        var seatSelect = document.getElementById("seat"); 
        var selectedSeatInput = document.getElementById("selectedSeat"); 
        
        var selectedSeat = seatSelect.value;
        selectedSeatInput.value = selectedSeat;
        
        window.location.href = 'store_selected_seat.php?selectedSeat=' + encodeURIComponent(selectedSeat);
    });
</script>


</body>
</html>
