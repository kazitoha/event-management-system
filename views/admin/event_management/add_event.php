<div class="modal fade" id="add-event-modal" tabindex="-1"
    role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Add Event</h5>
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
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" required
                                    placeholder="Enter event Name" />
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea type="text" name="description" class="form-control" required
                                    placeholder="Enter event description like tohar biye or somthing"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Location</label>
                                <input type="text" name="location" class="form-control" required
                                    placeholder="Enter event location" />
                            </div>

                            <div class="form-group">
                                <label>date</label>
                                <div>
                                    <input type="date" name="date" class="form-control" required />
                                    <span>mm/dd/yyy</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="time">Event Time</label>
                                <input type="time" name="time" value="<?= date('H:i') ?>" class="form-control" required />
                            </div>


                            <div class="form-group">
                                <label>Max Capacity</label>
                                <input type="number" name="max_capacity" class="form-control" required
                                    placeholder="Enter max capacity of this event" />
                            </div>

                            <div class="form-group mb-0">
                                <div>
                                    <button type="submit"
                                        class="btn btn-primary waves-effect waves-light mr-1" name="add_event">
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
    </div>
</div>