<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking - SijawaRuang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2 class="text-center mb-4">Booking Form</h2>
        <form action="" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="mb-3">
                <label for="booking_type" class="form-label">Booking Type</label>
                <select class="form-select" id="booking_type" name="booking_type" required>
                    <option value="Kamar">Kamar</option>
                    <option value="Aula">Aula</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="room_or_hall" class="form-label">Room or Hall</label>
                <input type="text" class="form-control" id="room_or_hall" name="room_or_hall" required>
            </div>
            <div class="mb-3">
                <label for="booking_date" class="form-label">Booking Date</label>
                <input type="date" class="form-control" id="booking_date" name="booking_date" required>
            </div>
            <div class="mb-3">
                <label for="duration" class="form-label">Duration (Days/Months)</label>
                <input type="number" class="form-control" id="duration" name="duration" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit Booking</button>
        </form>

        <?php
        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'sijawaruang');

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $booking_type = $_POST['booking_type'];
            $room_or_hall = $_POST['room_or_hall'];
            $booking_date = $_POST['booking_date'];
            $duration = $_POST['duration'];

            $sql = "INSERT INTO bookings (name, email, phone, booking_type, room_or_hall, booking_date, duration) VALUES ('$name', '$email', '$phone', '$booking_type', '$room_or_hall', '$booking_date', '$duration')";

            if ($conn->query($sql) === TRUE) {
                // Ambil ID booking yang baru saja dibuat
                $booking_id = $conn->insert_id;
                
                // Redirect ke halaman booking_detail.php dengan ID booking
                header("Location: bokingdetail.php?id=$booking_id");
                exit(); // Pastikan exit setelah header untuk menghentikan eksekusi kode lebih lanjut
            } else {
                echo "<div class='alert alert-danger text-center mt-3'>Error: " . $sql . "<br>" . $conn->error . "</div>";
            }
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
