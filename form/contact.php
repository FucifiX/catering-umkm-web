<?php
// Include your DB connection
include '../koneksi.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Get and sanitize inputs
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $subject = mysqli_real_escape_string($conn, $_POST['subject']);
  $message = mysqli_real_escape_string($conn, $_POST['message']);

  // Prepare SQL
  $sql = "INSERT INTO contact_messages (name, email, subject, message) 
          VALUES ('$name', '$email', '$subject', '$message')";

  if ($conn->query($sql) === TRUE) {
    echo "OK";  // Frontend script listens for this
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
}
?>
