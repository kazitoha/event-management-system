<?php

$event = new Event($db);

if (isset($_POST['add_event'])) {


    $name = validateString($_POST['name'], 4, 100);
    $description = validateString($_POST['description'], 4, 100);
    $location = validateString($_POST['location'], 1, 300);
    $date = validateString($_POST['date'], 5, 20);
    $max_capacity = validateInt($_POST['max_capacity']);

    $event->createEvent($name, $date, $location, $description, $max_capacity);
}

if (isset($_POST['update_event'])) {
    $eventId = validateInt($_POST['id']);
    $name = validateString($_POST['name'], 4, 100);
    $description = validateString($_POST['description'], 4, 100);
    $location = validateString($_POST['location'], 1, 300);
    $date = validateString($_POST['date'], 5, 20);
    $max_capacity = validateInt($_POST['max_capacity']);

    $event->updateEvent($eventId, $name, $date, $location, $description, $max_capacity);
}


$table = 'events';
$perPage = 4;
$paginator = new Datatable($db, $table, $perPage);

$currentPage = isset($_GET['paginate']) && is_numeric($_GET['paginate']) ? (int)$_GET['paginate'] : 1;
$data = $paginator->getData($currentPage);

$links = $paginator->createLinks(BASE_URL);

?>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="header-title">Event List</h4>
            <button class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#add-event-modal">Add Event</button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Event Name</th>
                        <th>Location</th>
                        <th>Date</th>
                        <th>Max capacity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['name']); ?></td>
                            <td><?= htmlspecialchars($row['location']); ?></td>
                            <td><?= htmlspecialchars($row['date']); ?></td>
                            <td><?= htmlspecialchars($row['max_capacity']); ?></td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <!-- Button with properly constructed link -->
                                    <?php
                                    $link = WEBSITE_URL . '/' . base64_encode($row['id']) . '/' . urlencode($row['name']); // Full event link
                                    ?>
                                    <button type="button"
                                        class="btn btn-outline-dark btn-sm copy-link-btn"
                                        data-link="<?= $link; ?>">
                                        Copy Link <i class="fa fa-link" aria-hidden="true"></i>
                                    </button>

                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#event-modal-<?= urlencode($row['id']); ?>">Edit <i class=" fas fa-pen " aria-hidden="true"></i></button>
                                    <!-- Include edit user Modal -->
                                    <?php include 'edit_event.php'; ?>
                                    <!-- Delete Button -->
                                    <button class="btn btn-outline-danger btn-sm" onclick="confirmDelete(<?= urlencode($row['id']); ?>)">Delete</button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <nav aria-label="Page navigation">
            <?= $links; ?>
        </nav>
    </div>
</div>
<?php include 'add_event.php'; ?>


<script>
    function confirmDelete(userId) {
        if (confirm('Are you sure you want to delete this user?')) {
            window.location.href = 'delete_user.php?id=' + userId;
        }
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Add event listener to all buttons with the class 'copy-link-btn'
        const copyButtons = document.querySelectorAll('.copy-link-btn');

        copyButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Get the link from the data-link attribute
                const link = button.getAttribute('data-link');

                // Copy the link to the clipboard
                navigator.clipboard.writeText(link)
                    .then(() => {
                        // Notify the user that the link has been copied
                        alert('Link copied to clipboard: ' + link);
                    })
                    .catch(err => {
                        // Handle errors if copying fails
                        console.error('Failed to copy link: ', err);
                        alert('Failed to copy link. Please try again.');
                    });
            });
        });
    });
</script>