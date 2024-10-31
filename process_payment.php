<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'sijawaruang');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = $_POST['booking_id'];
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];

    // Insert payment details into the payments table
    $sql = "INSERT INTO payments (booking_id, amount, payment_method) VALUES ('$booking_id', '$amount', '$payment_method')";

    if ($conn->query($sql) === TRUE) {
        // Fetch the booking details for the confirmation message
        $booking_sql = "SELECT * FROM bookings WHERE id = $booking_id";
        $booking_result = $conn->query($booking_sql);
        
        if ($booking_result->num_rows > 0) {
            $booking = $booking_result->fetch_assoc(); // Get the booking details
        } else {
            $booking = null; // No booking found
        }

        // Display success message and booking details
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Payment Successful</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body {
                    background-color: #f8f9fa;
                }
                .container {
                    max-width: 600px;
                    margin-top: 50px;
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                }
            </style>
        </head>

        <body>
            <div class="container">
                <h2 class="text-center mb-4">Payment Successful</h2>
                <div class="alert alert-success text-center">Payment has been successfully processed!</div>
                <?php if ($booking): ?>
                    <ul class="list-group mb-4">
                        <li class="list-group-item"><strong>Name:</strong> <?php echo htmlspecialchars($booking['name']); ?></li>
                        <li class="list-group-item"><strong>Email:</strong> <?php echo htmlspecialchars($booking['email']); ?></li>
                        <li class="list-group-item"><strong>Phone:</strong> <?php echo htmlspecialchars($booking['phone']); ?></li>
                        <li class="list-group-item"><strong>Booking Type:</strong> <?php echo htmlspecialchars($booking['booking_type']); ?></li>
                        <li class="list-group-item"><strong>Room or Hall:</strong> <?php echo htmlspecialchars($booking['room_or_hall']); ?></li>
                        <li class="list-group-item"><strong>Booking Date:</strong> <?php echo htmlspecialchars($booking['booking_date']); ?></li>
                        <li class="list-group-item"><strong>Duration:</strong> <?php echo htmlspecialchars($booking['duration']); ?> days/months</li>
                        <li class="list-group-item"><strong>Payment Amount:</strong> <?php echo htmlspecialchars($amount); ?></li>
                        <li class="list-group-item"><strong>Payment Method:</strong> <?php echo htmlspecialchars($payment_method); ?></li>
                    </ul>
                <?php else: ?>
                    <div class="alert alert-warning text-center">No booking details available.</div>
                <?php endif; ?>

                <div class="text-center">
                    <a href="index.html" class="btn btn-primary">Back to Home</a>
                </div>
            </div>
        </body>

        </html>
        <?php
    } else {
        echo "<div class='alert alert-danger text-center'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}

$conn->close();
?>
