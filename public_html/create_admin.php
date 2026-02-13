<?php
include('inc/db_connect.php');

// Admin user details
$email = 'admin@travsavers.com';
$password = 'Admin123!'; // Change this to your desired password
$first_name = 'Admin';
$last_name = 'User';
$user_type = 'admin';

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Check if admin user already exists
$check_stmt = $con->prepare("SELECT id FROM users WHERE email = ? AND user_type = 'admin'");
$check_stmt->bind_param("s", $email);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows > 0) {
    echo "Admin user with email '$email' already exists!\n";
    echo "You can login at: http://localhost:8000/admin/login.php\n";
} else {
    // Insert admin user
    $stmt = $con->prepare("INSERT INTO users (email, password, first_name, last_name, user_type) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $email, $hashed_password, $first_name, $last_name, $user_type);

    if ($stmt->execute()) {
        echo "✓ Admin user created successfully!\n\n";
        echo "Login Credentials:\n";
        echo "==================\n";
        echo "Email: $email\n";
        echo "Password: $password\n";
        echo "\nYou can now login at: http://localhost:8000/admin/login.php\n";
    } else {
        echo "Error creating admin user: " . $stmt->error . "\n";
    }
    $stmt->close();
}

$check_stmt->close();
$con->close();
?>
