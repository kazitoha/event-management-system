<?php

$user = new User($db);

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


$table = 'users';
$perPage = 4;
$paginator = new DatatableClass($db, $table, $perPage);

$currentPage = isset($_GET['paginate']) && is_numeric($_GET['paginate']) ? (int)$_GET['paginate'] : 1;
$data = $paginator->getData($currentPage);

$links = $paginator->createLinks(BASE_URL);

?>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="header-title">User List</h4>
            <button class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#add-user-modal">Add User</button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Created at</th>
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
                                <button class="btn btn-outline-danger btn-sm" onclick="confirmDelete(<?= urlencode($row['id']); ?>)">Delete</button>
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
    function confirmDelete(userId) {
        if (confirm('Are you sure you want to delete this user?')) {
            window.location.href = 'delete_user.php?id=' + userId;
        }
    }
</script>