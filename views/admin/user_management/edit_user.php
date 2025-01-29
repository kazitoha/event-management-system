<div class="modal fade" id="user-modal-<?= urlencode(encode($row['id'])); ?>" tabindex="-1"
    role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Edit User</h5>
                <button type="button" class="close"
                    data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="">
                    <div class="form-group">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                        <input type="hidden" name="user_id" value="<?= urlencode($row['id']); ?>">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control" id="username" value="<?= $row['username'] ?>" placeholder="Enter username">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email" value="<?= $row['email'] ?>" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Enter password">
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" id="confirmPassword" placeholder="Enter confirm password">
                    </div>
                    <button type="submit" class="btn btn-primary" name="update_user">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>