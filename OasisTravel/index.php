    <?php
    session_start();
    require_once "db_config.php"; 
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    $login_error = $registration_success = $registration_error = "";

    $userLoggedIn = false;
    $username = "";

    if (isset($_SESSION["username"])) {
        $userLoggedIn = true;
        $username = $_SESSION["username"];
    }
    if (isset($_POST["logout"])) {
        session_destroy();
        header("Location: index.php"); 
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
        $username = sanitize_input($_POST["username"]);
        $password = sanitize_input($_POST["password"]);

        if (empty($username) || empty($password)) {
            $login_error = "Please enter a username and password";
        } else {
            $sql = "SELECT * FROM users WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $hashs = password_hash($password,PASSWORD_DEFAULT);
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                
                if (password_verify($password, $row["password"])) {
                    $_SESSION["username"] = $row["username"];
                    $userLoggedIn = true;
                    header("Location: index.php");
                    exit(); 
                } else {
                    $login_error = "Invalid username or password";
                    echo "Login Error: Invalid username or password";
                }
            } else {
                $login_error = "Invalid username or password";
            }

            $stmt->close();
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
        $username = sanitize_input($_POST["username"]);
        $email = sanitize_input($_POST["email"]);
        $password = $_POST["password"];

        if (empty($username) || empty($email) || empty($password)) {
            $registration_error = "Please enter all fields";
        } else {
            $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $username, $email, password_hash($password,PASSWORD_DEFAULT));

            if ($stmt->execute()) {
                $registration_success = "Registration successful!";
                header("Location: index.php");
                exit(); 
            } else {
                $registration_error = "Error during registration";
            }

            $stmt->close();
        }
    }

    function sanitize_input($input) {
        return $input;
    }
    ?>


    <!DOCTYPE html>
    <html>
    <head>
        <link rel="icon" type="image/png" href="logos.png" sizes="64x64">
        <title>Oasis Travel</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <body>
        
        <header class="header">
            <div class="container" height="10vh" style="display:flex;">
                <img class="toplogo" src="logos.png" width="auto">
                <h1 class="logo">Oasis Travel</h1>
            </div>
        </header>
        
        <nav class="navbar">
            <div class="container">
                <ul class="nav">
                    <li><a >Home</a></li>
                    <?php if (isset($_SESSION["username"])){ echo'  
                        <li><a >Welcome, <?php echo $_SESSION["username"]; ?></a></li>
                        
                        <li><a href="logout.php">Logout</a></li>
                        <li><a >Settings</a></li>';}
                        else{ echo '
                        <li ><a class="popup-link" onclick="openlog()" >Login</a></li>
                        <li ><a class="popup-link" onclick="openreg()">Register</a></li>
                        ';}
                    ?>
                </ul>
            </div>
        </nav>
        <div class="photo_back">

            <div class="left"></div>
            <div class="right">
                <div class="search-box">
                    <h2>Plan Your Travel</h2>
                    <form action="results_page.php" method="post" autocomplete="off">
                        <label for="departure">Departure City:</label>
                        <input type="text" id="departure" name="departure" class="cityInput" placeholder="Enter departure city">
                        <div id="departureSuggestions" class="suggestionBox"></div>

                        <label for="destination">Destination City:</label>
                        <input type="text" id="destination" name="destination" class="cityInput" placeholder="Enter destination city">
                        <div id="destinationSuggestions" class="suggestionBox"></div>

                        <label for="date">Travel Date</label>
                        <input type="date" id="date" name="date" required>
                        
                        <label for="mode">Travel Mode</label>
                        <select id="mode" name="mode">
                            <option value="flight">Flight</option>
                            <option value="bus">Bus</option>
                            <option value="train">Train</option>
                        </select>
                        
                        <button name="btn" type="submit">Search</button>
                    </form>
                </div>
            </div>
            <!-- Login Popup -->
    <div class="popup" id="login-popup">
        <div class="popup-content">
            <span onclick="closelog()" class="close-popup">&times;</span>
            <h2>Login</h2>
        <form method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required autofocus><br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br>
                <button name="login" type="submit" class="button">Login</button>
            </form>
        </div>
    </div>

    <!-- Register Popup -->
    <div class="popup" id="register-popup">
        <div class="popup-content">
            <span class="close-popup" onclick="closereg()">&times;</span>
            <h2>Register</h2>
            <form method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required><br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br>
                <button name="register" type="submit" class="button">Register</button>
            </form>
        </div>
    </div>

        </div>
        <footer class="footer">
            <div class="container">
                <p>&copy; 2023 Travel Booking. All rights reserved.</p>
            </div>
        </footer>
        <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>  
        <script src="script.js"></script>
    </body>
    </html>
