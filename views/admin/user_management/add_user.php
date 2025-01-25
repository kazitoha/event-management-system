<div class="modal fade" id="add-user-modal" tabindex="-1"
    role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Add User</h5>
                <button type="button" class="close"
                    data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form class="custom-validation" action="#" method="post">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                            <div class="form-group">
                                <label>User Name</label>
                                <input type="text" name="username" class="form-control" required
                                    placeholder="Type something" />
                            </div>
                            <div class="form-group">
                                <label>E-Mail</label>
                                <div>
                                    <input type="email" name="email" class="form-control" required parsley-type="email"
                                        placeholder="Enter a valid e-mail" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <div>
                                    <input type="password" name="password" id="pass2" class="form-control" required
                                        placeholder="Password" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <div class="mt-2">
                                    <input type="password" name="confirm_password" class="form-control" required
                                        data-parsley-equalto="#pass2" placeholder="Re-Type Password" />
                                </div>
                            </div>


                            <div class="form-group mb-0">
                                <div>
                                    <button type="submit"
                                        class="btn btn-primary waves-effect waves-light mr-1" name="add_user">
                                        Submit
                                    </button>
                                    <button type="reset" class="btn btn-secondary waves-effect">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>