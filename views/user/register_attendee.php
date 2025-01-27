<link href="assets/css/register_attendee.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register_attendee'])) {

    $eventId = validateString($_POST['encode_id']);
    $maxCapacity = validateString($_POST['max_capacity']);
    $full_name = validateString($_POST['full_name'], 3, 100);
    $email = validateEmail($_POST['email']);
    $phone_number = validateString($_POST['phone_number'], 4, 20);
    $attendee = new AttendeeClass($db);
    $attendee->registerAttendee($eventId, $maxCapacity, $full_name, $email, $phone_number);
}
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="event-header" id="header">
                <img class="flower-icon" src="https://img.icons8.com/?size=100&id=113573&format=png&color=000000" alt="Flower Icon">
                <h1 class="paint-order">
                    <span><?= ucwords($checkEventDetails[0]['name']); ?></span>
                </h1>
                <h2 class="mt-5 event-name"></h2>
                <p class="event-description"><?= $checkEventDetails[0]['description']; ?></p>
                <p><b><i class="fas fa-map-marker-alt"></i> Location: </b><?= $checkEventDetails[0]['location']; ?></p>
                <p><b><i class="fas fa-calendar-alt"></i> Date & Time: </b><?= $checkEventDetails[0]['date']; ?>, <?= date('g:i A', strtotime($checkEventDetails[0]['time'])); ?></p>
            </div>
            <div class="form-container">
                <div id="confirmationMessage" style="display:none; margin-top:20px;" class="alert alert-info"></div>
                <form id="registrationForm" method="post">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="encode_id" value="<?= $event_encode_id; ?>">
                    <input type="hidden" name="max_capacity" value="<?= $checkEventDetails[0]['max_capacity']; ?>">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" class="form-control" name="full_name" placeholder="Enter your full name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input
                            type="tel"
                            class="form-control"
                            name="phone_number"
                            id="phone"
                            placeholder="Enter your phone number"
                            required
                            pattern="^(\+8801|01)[3-9]\d{8}$"
                            title="Phone number must be a valid Bangladeshi number, e.g., +8801XXXXXXXXX or 01XXXXXXXXX">
                    </div>

                    <button type="submit" class="btn btn-info btn-block" name="register_attendee">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- SweetAlert2 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>