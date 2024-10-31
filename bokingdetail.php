<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'sijawaruang');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if 'id' is set in the URL
if (isset($_GET['id'])) {
    $booking_id = intval($_GET['id']); // Get the booking ID from the URL

    // Fetch booking details from the database
    $sql = "SELECT * FROM bookings WHERE id = $booking_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $booking = $result->fetch_assoc(); // Get the booking details
    } else {
        $booking = null; // No booking found
    }
} else {
    $booking = null; // No booking ID provided
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Detail</title>
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
        <h2 class="text-center mb-4">Booking Details</h2>

        <?php if ($booking): ?>
            <?php if (isset($_GET['payment_status']) && $_GET['payment_status'] == 'success'): ?>
                <div class="alert alert-success text-center">Payment successful!</div>
            <?php endif; ?>
            <ul class="list-group mb-4">
                <li class="list-group-item"><strong>Name:</strong> <?php echo htmlspecialchars($booking['name']); ?></li>
                <li class="list-group-item"><strong>Email:</strong> <?php echo htmlspecialchars($booking['email']); ?></li>
                <li class="list-group-item"><strong>Phone:</strong> <?php echo htmlspecialchars($booking['phone']); ?></li>
                <li class="list-group-item"><strong>Booking Type:</strong> <?php echo htmlspecialchars($booking['booking_type']); ?></li>
                <li class="list-group-item"><strong>Room or Hall:</strong> <?php echo htmlspecialchars($booking['room_or_hall']); ?></li>
                <li class="list-group-item"><strong>Booking Date:</strong> <?php echo htmlspecialchars($booking['booking_date']); ?></li>
                <li class="list-group-item"><strong>Duration:</strong> <?php echo htmlspecialchars($booking['duration']); ?> days/months</li>
            </ul>

            <!-- Payment form -->
            <div>
                <h4>Payment Details</h4>
                <form action="process_payment.php" method="post">
                    <input type="hidden" name="booking_id" value="<?php echo htmlspecialchars($booking['id']); ?>">
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method</label>
                        <select class="form-select" id="payment_method" name="payment_method" required>
                            <option value="" disabled selected>Select Payment Method</option>
                            <option value="BCA">BCA</option>
                            <option value="BRI">BRI</option>
                            <option value="BSI Syariah">BSI Syariah</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Make Payment</button>
                </form>
            </div>
        <?php else: ?>
            <div class="alert alert-danger text-center">No booking details available. Please check the booking ID.</div>
        <?php endif; ?>
    </div>
</body>

</html>
