<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "esp32_control";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle AJAX request
if (isset($_POST['led']) && isset($_POST['status'])) {
    $led = $_POST['led'];
    $status = $_POST['status'];

    $sql = "UPDATE led_status SET $led=$status WHERE id=1";
    $conn->query($sql);
    exit;
}

// Retrieve LED status
$sql = "SELECT * FROM led_status WHERE id=1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>ESP LED Control</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
            margin: 10px 0;
        }
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        input:checked + .slider {
            background-color: #4CAF50;
        }
        input:checked + .slider:before {
            transform: translateX(26px);
        }
    </style>
    <script>
        function toggleLED(led, status) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("led=" + led + "&status=" + status);
        }

        function handleToggle(event) {
            var led = event.target.name;
            var status = event.target.checked ? 1 : 0;
            toggleLED(led, status);
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>ESP LED Control</h1>
        <label class="toggle-switch">
            <input type="checkbox" name="led1" <?php if ($row['led1']) echo 'checked'; ?> onchange="handleToggle(event)">
            <span class="slider"></span>
        </label> LED 1<br>
        <label class="toggle-switch">
            <input type="checkbox" name="led2" <?php if ($row['led2']) echo 'checked'; ?> onchange="handleToggle(event)">
            <span class="slider"></span>
        </label> LED 2<br>
        <label class="toggle-switch">
            <input type="checkbox" name="led3" <?php if ($row['led3']) echo 'checked'; ?> onchange="handleToggle(event)">
            <span class="slider"></span>
        </label> LED 3<br>
        <label class="toggle-switch">
            <input type="checkbox" name="led4" <?php if ($row['led4']) echo 'checked'; ?> onchange="handleToggle(event)">
            <span class="slider"></span>
        </label> LED 4<br>
    </div>
</body>
</html>
