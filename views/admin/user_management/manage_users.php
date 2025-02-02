<?php

$user = new UserClass($db);

if (isset($_POST['add_user'])) {
    $username = validateString($_POST['username'], 4, 20);
    $email = validateEmail($_POST['email']);
    $password = validateString($_POST['password'], 4, 20);
    $confirm_password = validateString($_POST['confirm_password'], 4, 20);
    $user->register($username, $email, $password, $confirm_password);
}


if (isset($_POST['update_user'])) {
    $userId = validateInt($_POST['user_id']);
    $username = validateString($_POST['username'], 4, 20);
    $username = validateString($_POST['username'], 4, 20);
    $email = validateEmail($_POST['email']);

    $password = '';
    $confirm_password = '';

    if (!empty($_POST['password']) && !empty($_POST['confirm_password'])) {
        $password = validateString($_POST['password'], 4, 20);
        $confirm_password = validateString($_POST['confirm_password'], 4, 20);
    }
    $user->updateUser($userId, $username, $email,  $password, $confirm_password);
}
if (isset($_GET['delete_id'])) {
    $user_id = $_GET['delete_id'];
    $user->deleteUser($user_id);
}

$perPage = 2;
$paginator = new DatatableClass($user, $perPage);

$currentPage = isset($_GET['paginate']) && is_numeric($_GET['paginate']) ? (int)$_GET['paginate'] : 1;
$sortBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'name';
$sortOrder = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$data = $paginator->getData($currentPage, $sortBy, $sortOrder, $searchTerm, $page);
$links = $paginator->createLinks(BASE_URL);


?>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="header-title">User List</h4>
            <button class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#add-user-modal">Add User</button>
        </div>
        <div class="text-left p-2">
            <form id="search-form">
                <input type="text" id="search-input" name="search" placeholder="Search..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                <button type="button" class="btn btn-outline-primary btn-sm" onclick="submitSearch()">Search</button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>

                        <th>
                            <a class="text-dark" href="?page=user_management&paginate=<?= $currentPage ?>&sort_by=name&sort_order=<?= ($sortBy == 'name' && $sortOrder == 'ASC') ? 'DESC' : 'ASC' ?>">User Name<i class=" mdi mdi-arrow-up-down-bold "></i></a>
                        </th>
                        <th>
                            <a class="text-dark" href="?page=user_management&paginate=<?= $currentPage ?>&sort_by=name&sort_order=<?= ($sortBy == 'name' && $sortOrder == 'ASC') ? 'DESC' : 'ASC' ?>"> Email <i class=" mdi mdi-arrow-up-down-bold "></i></a>
                        </th>
                        <th>
                            <a class="text-dark" href="?page=user_management&paginate=<?= $currentPage ?>&sort_by=name&sort_order=<?= ($sortBy == 'name' && $sortOrder == 'ASC') ? 'DESC' : 'ASC' ?>"> Created at<i class=" mdi mdi-arrow-up-down-bold "></i></a>
                        </th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars($row['username']); ?>
                                <?= encode($row['id']) == $_SESSION['user_id'] ? "<span class='badge badge-success'>you</span>" : ''; ?>
                            </td>
                            <td><?= htmlspecialchars($row['email']); ?></td>
                            <td><?= htmlspecialchars($row['created_at']); ?></td>
                            <td>
                                <!-- Edit Button -->
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#user-modal-<?= urlencode(encode($row['id'])); ?>">Edit</button>
                                <!-- Include edit user Modal -->
                                <?php include 'edit_user.php'; ?>
                                <!-- Delete Button -->
                                <?php if (encode($row['id']) != $_SESSION['user_id']) { ?>
                                    <button class="btn btn-outline-danger btn-sm" onclick="confirmDelete('<?= encode($row['id']); ?>')">Delete</button>
                                <?php } ?>

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
<?php include 'add_user.php'; ?>


<script>
    function confirmDelete(encodedUserId) {
        var userId = decodeURIComponent(encodedUserId); // Decode the ID

        console.log("Delete button clicked for user ID: " + userId); // Log the decoded userId

        if (confirm('Are you sure you want to delete this user?')) {
            window.location.href = '?page=user_management&delete_id=' + userId;
        }
    }

    function submitSearch() {
        var searchTerm = document.getElementById('search-input').value;
        var encodedSearchTerm = encodeURIComponent(searchTerm); // URL encode the search term

        // Redirect to the search results page with the encoded search term
        window.location.href = "?page=user_management&search=" + encodedSearchTerm;
    }
</script>