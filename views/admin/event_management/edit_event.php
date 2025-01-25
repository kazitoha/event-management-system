<div class="modal fade" id="event-modal-<?= urlencode($row['id']); ?>" tabindex="-1"
    role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Edit Event</h5>
                <button type="button" class="close"
                    data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="custom-validation" action="#" method="post">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="<?= $row['name'] ?>" required
                            placeholder="Enter event Name" />
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" name="description" class="form-control" value="<?= $row['description'] ?>" required
                            placeholder="Enter event description like tohar biye or somthing" />
                    </div>

                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" name="location" class="form-control" value="<?= $row['location'] ?>" required
                            placeholder="Enter event location" />
                    </div>

                    <div class="form-group">
                        <label>date</label>
                        <div>
                            <input type="date" name="date" class="form-control" value="<?= $row['date'] ?>" required />
                            <span>mm/dd/yyy</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Max Capacity</label>
                        <input type="number" name="max_capacity" class="form-control" value="<?= $row['max_capacity'] ?>" required
                            placeholder="Enter max capacity of this event" />
                    </div>

                    <div class="form-group mb-0">
                        <div>
                            <button type="submit"
                                class="btn btn-primary waves-effect waves-light mr-1" name="update_event">
                                Submit
                            </button>
                            <button type="reset" class="btn btn-secondary waves-effect">
                                Reset
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>