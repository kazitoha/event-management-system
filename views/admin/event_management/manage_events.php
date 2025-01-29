<?php

$event = new EventClass($db);

if (isset($_POST['add_event'])) {
    $name = validateString($_POST['name'], 3, 100);
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

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $event->deleteEventWithAttendee($delete_id);
}

$table = 'events';
$perPage = 3;
$paginator = new DatatableClass($db, $table, $perPage);

$currentPage = isset($_GET['paginate']) && is_numeric($_GET['paginate']) ? (int)$_GET['paginate'] : 1;
$sortBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'name';
$sortOrder = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$data = $paginator->getEventData($currentPage, $sortBy, $sortOrder, $searchTerm);

$links = $paginator->createLinks(BASE_URL);


?>

<div class="card">
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="header-title">Event List</h4>
            <button class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#add-event-modal">Add Event</button>
        </div>
        <div class="text-left p-2">
            <form id="search-form">
                <input type="text" id="search-input" name="search" placeholder="Search..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                <button type="button" class="btn btn-outline-primary btn-sm" onclick="submitSearch()">Search</button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead class="thead-light">
                    <tr class="">
                        <th>
                            <a class="text-dark" href="?page=event_management&paginate=<?= $currentPage ?>&sort_by=name&sort_order=<?= ($sortBy == 'name' && $sortOrder == 'ASC') ? 'DESC' : 'ASC' ?>">Event Name <i class=" mdi mdi-arrow-up-down-bold "></i></a>
                        </th>
                        <th><a class="text-dark" href="?page=event_management&paginate=<?= $currentPage ?>&sort_by=location&sort_order=<?= ($sortBy == 'location' && $sortOrder == 'ASC') ? 'DESC' : 'ASC' ?>">Location <i class=" mdi mdi-arrow-up-down-bold "></i></a></th>
                        <th><a class="text-dark" href="?page=event_management&paginate=<?= $currentPage ?>&sort_by=date&sort_order=<?= ($sortBy == 'date' && $sortOrder == 'ASC') ? 'DESC' : 'ASC' ?>">Date <i class=" mdi mdi-arrow-up-down-bold "></i></a></th>
                        <th><a class="text-dark" href="?page=event_management&paginate=<?= $currentPage ?>&sort_by=max_capacity&sort_order=<?= ($sortBy == 'max_capacity' && $sortOrder == 'ASC') ? 'DESC' : 'ASC' ?>">Max Capacity <i class=" mdi mdi-arrow-up-down-bold "></i></a></th>
                        <th><a class="text-dark" href="?page=event_management&paginate=<?= $currentPage ?>&sort_by=total_register&sort_order=<?= ($sortBy == 'total_register' && $sortOrder == 'ASC') ? 'DESC' : 'ASC' ?>">Total Register <i class=" mdi mdi-arrow-up-down-bold "></i></a></th>
                        <th><a class="text-dark" href="?page=event_management&?paginate=<?= $currentPage ?>&sort_by=status&sort_order=<?= ($sortBy == 'status' && $sortOrder == 'ASC') ? 'DESC' : 'ASC' ?>">Status <i class=" mdi mdi-arrow-up-down-bold "></i></a></th>
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
                                    <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#event-modal-<?= urlencode($key); ?>"><i class="dripicons-pencil" aria-hidden="true"> </i> Edit</button>

                                    <!-- Include edit user Modal -->
                                    <?php include 'edit_event.php'; ?>

                                    <!-- Delete Button -->
                                    <button class="btn btn-outline-danger btn-sm" onclick="confirmDelete('<?= encode($row['id']); ?>')"> <i class=" dripicons-trash " aria-hidden="true"> </i> Delete </button>

                                    <!-- Button with properly constructed link -->
                                    <?php
                                    $link = WEBSITE_URL . '?attendees_url=' . encode($row['id']) . '/' . urlencode($row['name']); // Full event link
                                    ?>
                                    <button type="button"
                                        class="btn btn-outline-dark btn-sm copy-link-btn"
                                        data-link="<?= $link; ?>">
                                        <i class="fa fa-link" aria-hidden="true"></i> Copy Link
                                    </button>
                                    <a href="views/admin/report/export_attendee.php?event_id=<?= encode($row['id']); ?>" class="btn btn-outline-dark"> <i class=" fas fa-file-csv aria-hidden=" true"></i> CSV</a>
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

    function confirmDelete(userId) {
        if (confirm('Are you sure you want to delete this user?')) {
            window.location.href = '?page=event_management&delete_id=' + userId;
        }
    }

    function submitSearch() {
        var searchTerm = document.getElementById('search-input').value;
        var encodedSearchTerm = encodeURIComponent(searchTerm); // URL encode the search term

        // Redirect to the search results page with the encoded search term
        window.location.href = "?page=event_management&search=" + encodedSearchTerm;
    }
</script>