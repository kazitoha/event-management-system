<?php
$search = new SearchClass($db);

if (isset($_POST['search'])) {
    $searchTerm = $_POST['search'];
    $searchResult = $search->searchEventsAndAttendees($searchTerm);
}
?>

<div class="card shadow-sm">
    <div class="card-body">
        <!-- Search Form -->
        <div class="text-left p-3">
            <form method="post" action="#" class="d-flex align-items-center">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                <input type="text" id="search-input" name="search" placeholder="Search for events or attendees..."
                    class="form-control form-control-lg mr-2">
                <button type="submit" class="btn btn-outline-primary btn-lg">Search</button>
            </form>
        </div>

        <!-- Results Table -->
        <div class="table-responsive mt-4">
            <?php if (!empty($searchResult)): ?>
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Event Name</th>
                            <th>Description</th>
                            <th>Location</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Max Capacity</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Attendee Name</th>
                            <th>Attendee Email</th>
                            <th>Attendee Phone</th>
                            <th>Registered At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($searchResult as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['description']) ?></td>
                                <td><?= htmlspecialchars($row['location']) ?></td>
                                <td><?= htmlspecialchars($row['date']) ?></td>
                                <td><?= htmlspecialchars($row['time']) ?></td>
                                <td><?= htmlspecialchars($row['max_capacity']) ?></td>
                                <td><?= $row['status'] == 1 ? 'Active' : 'Inactive' ?></td>
                                <td><?= htmlspecialchars($row['created_at']) ?></td>
                                <td><?= htmlspecialchars($row['attendee_name']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['phone']) ?></td>
                                <td><?= htmlspecialchars($row['registered_at']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-warning" role="alert">
                    No results found.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>