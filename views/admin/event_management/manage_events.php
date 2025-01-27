<?php

$event = new EventClass($db);

if (isset($_POST['add_event'])) {
    $name = validateString($_POST['name'], 4, 100);
    $description = validateString($_POST['description'], 4, 400);
    $location = validateString($_POST['location'], 1, 300);
    $date = validateString($_POST['date'], 5, 20);
    $time = validateString($_POST['time'], 5, 10);
    $max_capacity = validateInt($_POST['max_capacity']);

    $event->createEvent($name, $description, $location, $date, $time, $max_capacity);
}

if (isset($_POST['update_event'])) {
    $eventId = validateString(($_POST['id']));
    $name = validateString($_POST['name'], 4, 100);
    $description = validateString($_POST['description'], 4, 400);
    $location = validateString($_POST['location'], 1, 300);
    $date = validateString($_POST['date'], 5, 20);
    $max_capacity = validateInt($_POST['max_capacity']);
    $event->updateEvent($eventId, $name, $date, $location, $description, $max_capacity);
}
if (isset($_GET['eventId']) && isset($_GET['status'])) {
    $eventId = validateString($_GET['eventId']);
    $status = validateString($_GET['status']);
    $event->changeStatus($eventId, $status);
}

$table = 'events';
$perPage = 5;
$paginator = new DatatableClass($db, $table, $perPage);

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
            <table class="table table-bordered table-hover text-center">
                <thead class="thead-light">
                    <tr>
                        <th>Event Name</th>
                        <th>Location</th>
                        <th>Date</th>
                        <th>Max capacity</th>
                        <th>Total Register</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $key => $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['name']); ?></td>
                            <td><?= htmlspecialchars($row['location']); ?></td>
                            <td><?= htmlspecialchars($row['date']); ?></td>
                            <td><?= htmlspecialchars($row['max_capacity']); ?></td>
                            <td><span class="badge badge-success"><?= $event->sumTotalAttendee($row['id']); ?></span></td>

                            <td>
                                <span class="badge <?= $row['status'] == '1' ? 'badge-success' : 'badge-danger'; ?>">
                                    <?= $row['status'] == '1' ? 'Active' : 'Inactive'; ?>
                                </span>
                            </td>

                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <!-- status button -->
                                    <a href="?page=event_management&eventId=<?= encode($row['id']); ?>&status=<?= ($row['status'] == '1') ? encode(0) : encode(1); ?>"
                                        class="btn btn-outline-primary btn-sm"><i class=" mdi mdi-refresh " aria-hidden="true"></i> Status</a>
                                    <!-- edit button -->
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#event-modal-<?= urlencode($key); ?>"> Edit
                                        <i class="dripicons-pencil" aria-hidden="true"> </i></button>
                                    <!-- Include edit user Modal -->
                                    <?php include 'edit_event.php'; ?>
                                    <!-- Delete Button -->
                                    <button class="btn btn-outline-danger btn-sm" onclick="confirmDelete(<?= urlencode($row['id']); ?>)"> <i class=" dripicons-trash " aria-hidden="true"> </i> Delete </button>
                                    <!-- Button with properly constructed link -->
                                    <?php
                                    $link = WEBSITE_URL . '?attendees_url=' . encode($row['id']) . '/' . urlencode($row['name']); // Full event link
                                    ?>
                                    <button type="button"
                                        class="btn btn-outline-dark btn-sm copy-link-btn"
                                        data-link="<?= $link; ?>">
                                        <i class="fa fa-link" aria-hidden="true"></i> Copy Link
                                    </button>
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