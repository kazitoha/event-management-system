<?php
$table = 'users';
$perPage = 2;
$paginator = new Datatable($db, $table, $perPage);

$currentPage = isset($_GET['paginate']) && is_numeric($_GET['paginate']) ? (int)$_GET['paginate'] : 1;
$data = $paginator->getData($currentPage);

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

$baseUrl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$links = $paginator->createLinks($baseUrl);





if (isset($_POST['update'])) {;
    $userId = validateInt($_POST['user_id']);

    $username = validateString($_POST['username'], 4, 20);

    $username = validateString($_POST['username'], 4, 20);

    $email = validateEmail($_POST['email']);

    $role = validateString($_POST['role'], 4, 6);
    $password = '';
    $confirm_password = '';
    if (!empty($_POST['password']) && !empty($_POST['confirm_password'])) {
        $password = validateString($_POST['password'], 4, 20);
        $confirm_password = validateString($_POST['confirm_password'], 4, 20);
    }
    $user = new User($db);
    $user->updateUser($userId, $username, $email, $role, $password, $confirm_password);
}




?>
<div class="card">
    <div class="card-body">
        <h4 class="header-title">User List</h4>
        <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created at</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['username']); ?></td>
                        <td><?= htmlspecialchars($row['email']); ?></td>
                        <td><?= htmlspecialchars($row['role']); ?></td>
                        <td><?= htmlspecialchars($row['created_at']); ?></td>
                        <td>

                            <!-- Button -->
                            <button type="button"
                                class="btn btn-primary btn-sm waves-effect waves-light"
                                data-toggle="modal"
                                data-target="#user-modal-<?= urlencode($row['id']); ?>">Edit</button>

                            <!-- Modal -->
                            <?php include 'edit_user.php'; ?>


                            <button class="btn btn-outline-danger btn-sm btn-sm waves-effect waves-light" href="&id= <?= urlencode($row['id']); ?>" class="">delete</button>
                        </td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- Display pagination links -->
        <?= $links; ?>
    </div>
</div>