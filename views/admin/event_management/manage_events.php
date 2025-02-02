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
    $event->deleteEventWithAttendee(eventId: $delete_id);
}
$event = new EventClass($db);
$perPage = 2; // Number of events per page
$paginator = new DatatableClass($event, $perPage);

$currentPage = isset($_GET['paginate']) && is_numeric($_GET['paginate']) ? (int)$_GET['paginate'] : 1;
$sortBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'name';
$sortOrder = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$statusFilter = isset($_GET['status_filter']) ? $_GET['status_filter'] : '';
$dateFilter = isset($_GET['date_filter']) ? $_GET['date_filter'] : '';


$data = $paginator->getData($currentPage, $sortBy, $sortOrder, $searchTerm, $page, $statusFilter, $dateFilter);

$links = $paginator->createLinks(BASE_URL);
?>

<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="header-title mb-0">Event List</h4>
                <button class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#add-event-modal">Add Event</button>
            </div>
        </div>

        <div class="card-body">
            <div class="text-left p-3 mb-4 bg-light rounded">
                <form id="search-form" method="GET" class="form-inline">
                    <div class="form-group mb-2">
                        <input type="text" id="search-input" name="search" class="form-control form-control-sm search-btn" placeholder="Search..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <select name="status_filter" id="status-input" class="form-control form-control-sm search-btn">
                            <option value="">All Status</option>
                            <option value="1" <?= isset($_GET['status_filter']) && $_GET['status_filter'] == '1' ? 'selected' : '' ?>>Active</option>
                            <option value="0" <?= isset($_GET['status_filter']) && $_GET['status_filter'] == '0' ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <input type="date" name="date_filter" id="date-input" class="form-control form-control-sm search-btn" value="<?= isset($_GET['date_filter']) ? htmlspecialchars($_GET['date_filter']) : '' ?>">
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm mb-2 ml-2" onclick="submitSearch()">Filter</button>
                </form>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>
                                <a class="text-dark" href="?page=event_management&paginate=<?= $currentPage ?>&sort_by=name&sort_order=<?= ($sortBy == 'name' && $sortOrder == 'ASC') ? 'DESC' : 'ASC' ?>">Event Name <i class="mdi mdi-arrow-up-down-bold"></i></a>
                            </th>
                            <th>
                                <a class="text-dark" href="?page=event_management&paginate=<?= $currentPage ?>&sort_by=location&sort_order=<?= ($sortBy == 'location' && $sortOrder == 'ASC') ? 'DESC' : 'ASC' ?>">Location <i class="mdi mdi-arrow-up-down-bold"></i></a>
                            </th>
                            <th>
                                <a class="text-dark" href="?page=event_management&paginate=<?= $currentPage ?>&sort_by=date&sort_order=<?= ($sortBy == 'date' && $sortOrder == 'ASC') ? 'DESC' : 'ASC' ?>">Date <i class="mdi mdi-arrow-up-down-bold"></i></a>
                            </th>
                            <th>
                                <a class="text-dark" href="?page=event_management&paginate=<?= $currentPage ?>&sort_by=max_capacity&sort_order=<?= ($sortBy == 'max_capacity' && $sortOrder == 'ASC') ? 'DESC' : 'ASC' ?>"> Max Capacity <i class="mdi mdi-arrow-up-down-bold"></i></a>
                            </th>
                            <th>
                                <a class="text-dark" href="?page=event_management&paginate=<?= $currentPage ?>&sort_by=max_capacity&sort_order=<?= ($sortBy == 'max_capacity' && $sortOrder == 'ASC') ? 'DESC' : 'ASC' ?>"> Total Register <i class="mdi mdi-arrow-up-down-bold"></i></a>
                            </th>
                            <th>
                                <a class="text-dark" href="?page=event_management&paginate=<?= $currentPage ?>&sort_by=status&sort_order=<?= ($sortBy == 'status' && $sortOrder == 'ASC') ? 'DESC' : 'ASC' ?>">Status <i class="mdi mdi-arrow-up-down-bold"></i></a>
                            </th>
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
                                    <div class="btn-group" role="group" aria-label="Event Actions">
                                        <!-- Status button -->
                                        <a href="?page=event_management&eventId=<?= encode($row['id']); ?>&status=<?= ($row['status'] == '1') ? encode(0) : encode(1); ?>" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" title="Change Status">
                                            <i class="mdi mdi-refresh"></i>
                                        </a>
                                        <!-- Edit button -->
                                        <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#event-modal-<?= urlencode($key); ?>" data-toggle="tooltip" title="Edit Event">
                                            <i class="dripicons-pencil"></i>
                                        </button>

                                        <?php include 'edit_event.php'; ?>

                                        <!-- Delete button -->
                                        <button class="btn btn-outline-danger btn-sm" onclick="confirmDelete('<?= encode($row['id']); ?>')" data-toggle="tooltip" title="Delete Event">
                                            <i class="dripicons-trash"></i>
                                        </button>

                                        <!-- Copy Link button -->
                                        <button type="button" class="btn btn-outline-dark btn-sm copy-link-btn" data-link="<?= WEBSITE_URL . '?attendees_url=' . encode($row['id']) . '/' . urlencode($row['name']); ?>" data-toggle="tooltip" title="Copy this link and share it with the attendees who have registered for this event.">
                                            <i class="fa fa-link"></i>
                                        </button>

                                        <!-- CSV Export Button -->
                                        <a href="views/admin/report/export_attendee.php?event_id=<?= encode($row['id']); ?>" class="btn btn-outline-dark btn-sm" data-toggle="tooltip" title="Export Attendees">
                                            <i class="fas fa-file-csv"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <?= $links; ?>
            </nav>
        </div>
    </div>
</div>

<!-- Add Event Modal -->
<?php include 'add_event.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const copyButtons = document.querySelectorAll('.copy-link-btn');

        copyButtons.forEach(button => {
            button.addEventListener('click', () => {
                const link = button.getAttribute('data-link');

                navigator.clipboard.writeText(link)
                    .then(() => {
                        alert('Link copied to clipboard: ' + link);
                    })
                    .catch(err => {
                        console.error('Failed to copy link: ', err);
                        alert('Failed to copy link. Please try again.');
                    });
            });
        });

        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();
    });



    function confirmDelete(eventId) {
        if (confirm('Are you sure you want to delete this event? This will also delete all attendees associated with it.')) {
            window.location.href = '?page=event_management&delete_id=' + eventId;
        }
    }


    function submitSearch() {
        var searchTerm = document.getElementById('search-input').value;
        var statusFilter = document.querySelector('[name="status_filter"]').value;
        var dateFilter = document.querySelector('[name="date_filter"]').value;

        var queryParams = new URLSearchParams(window.location.search);

        queryParams.set("search", encodeURIComponent(searchTerm));
        queryParams.set("status_filter", encodeURIComponent(statusFilter));
        queryParams.set("date_filter", encodeURIComponent(dateFilter));

        window.location.href = "?page=event_management&" + queryParams.toString();
    }

    document.getElementById('search-input').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            submitSearch();
        }
    });
    document.getElementById('status-input').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            submitSearch();
        }
    });
    document.getElementById('date-input').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            submitSearch();
        }
    });
</script>