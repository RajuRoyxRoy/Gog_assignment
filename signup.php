<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo "Passwords do not match!";
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $checkUser = "SELECT * FROM users WHERE email='$email' OR mobile='$mobile'";
    $result = $conn->query($checkUser);

    if ($result->num_rows > 0) {
        echo "Email or Mobile already registered!";
    } else {
        $sql = "INSERT INTO users (username, email, mobile, password) VALUES ('$username', '$email', '$mobile', '$hashed_password')";
        if ($conn->query($sql) === TRUE) {
            header("Location: login.html");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
