
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" type="image/png" href="logos.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="results.css">
    <title>Travel Results</title>
</head>
<body>
    
<div class="container"> 
        <h1 class="header"> Oasis - Travel Results</h1>
        <?php
       
        session_start();
        $departure = $_POST['departure'];
        $destination = $_POST['destination'];
        $date = $_POST['date'];
        $mode = $_POST['mode'];
        $_SESSION["mode"] = $mode;
        $_SESSION["departure"] = $departure;
        $_SESSION["destination"] = $destination;
        $_SESSION["date"] = $date;
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "travel";
        $connection = new mysqli($servername, $username, $password, $dbname);

        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }

        $query = "SELECT * FROM travel_data 
                  WHERE departure = '$departure' 
                    AND destination = '$destination' 
                    AND date = '$date' 
                    AND mode = '$mode'";
        
        $results = mysqli_query($connection, $query);
        function generateRandomTime() {
            return rand(0, 23) . ':' . str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT);
        }
        
        function calculateDuration($departureTime, $arrivalTime) {
            $departure = strtotime($departureTime);
            $arrival = strtotime($arrivalTime);
            $seconds = $arrival - $departure;
            $hours = floor($seconds / 3600);
            $minutes = floor(($seconds - ($hours * 3600)) / 60);
            return $hours . ' hours ' . $minutes . ' minutes';
        }
        
        if(mysqli_num_rows($results) == 0) {
            echo '<div class="no-results">';
            echo '<p class="no-results-text">No method of travel possible :( </p><br>';
            echo '<img src="no_results.png" width="50px" height="50px" alt="No Results">';
            echo '</div>';
        } else {
            foreach ($results as $result) {
                $departureTime = generateRandomTime();
                $arrivalTime = generateRandomTime();
                $duration = calculateDuration($departureTime, $arrivalTime);
                
                echo '<div class="result-card">';
                echo '<div>';
                echo '<h3>' . $result['departure'] . ' to ' . $result['destination'] . '</h3>';
                echo '<p class="details">
                        Date: ' . $result['date'] . ' | 
                        Mode: <span class="mode">' . $result['mode'] . '</span> | 
                        Departure Time: ' . $departureTime . ' | 
                        Arrival Time: ' . $arrivalTime . ' | 
                        Duration: ' . $duration . '
                      </p>';
                echo '</div>';
                echo '<form method="post" action="seat_select.php">
                        <input type="hidden" name="mode" value="' . $_POST["mode"] . '">
                        <button type="submit" name="booknow" class="button">Book Now</button>
                      </form>';
                echo '</div>';
                
                   // More content between displaying available methods and "Additional Information"
        echo '<div class="more-content">';
        echo '<h2>More Details</h2>';
        echo '<p>Before you finalize your travel plans, consider the following:</p>';
        echo '<ul>';
        echo '<li>Compare different travel options based on convenience and comfort.</li>';
        echo '<li>Check if there are any discounts available for your chosen mode of travel.</li>';
        echo '</ul>';
        echo '</div>';
        
                echo '<div class="more-content">';
                echo '<h2>Additional Information</h2>';
                echo '<p>Thank you for exploring your travel options with us. Here are some additional tips for your trip:</p>';
                echo '<ul>';
                echo '<li>Remember to pack your essentials including passport, tickets, and travel insurance.</li>';
                echo '<li>Check the weather forecast for your destination and pack accordingly.</li>';
                echo '<li>Stay hydrated and carry some snacks for the journey.</li>';
                echo '</ul>';
                echo '</div>';
            }
        }
        ?>
    </div>
    <footer class="footer">
        <p>Contact us: query@oasistravel.com | Phone: +1-123-426-9578</p>
    </footer>
</body>
</html>
