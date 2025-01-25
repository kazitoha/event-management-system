<?php
// Check if the success message session variable is set
if (isset($_SESSION['success_msg'])) {
    // Output JavaScript to trigger SweetAlert2
    echo "
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{$_SESSION['success_msg']}',
                confirmButtonText: 'OK'
            });
        });
    </script>
    ";
    // Unset the session variable after displaying the alert
    unset($_SESSION['success_msg']);
}

if (isset($_SESSION['error_msg'])) {
    // Output JavaScript to trigger SweetAlert2
    echo "
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{$_SESSION['error_msg']}',
                confirmButtonText: 'OK'
            });
        });
    </script>
    ";
    // Unset the session variable after displaying the alert
    unset($_SESSION['error_msg']);
}
