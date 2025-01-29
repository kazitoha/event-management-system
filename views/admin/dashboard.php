<?php
$dashboard = new DashboardClass($db);
$getActiveEvent = $dashboard->getActiveEvent();


?>
<link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
<div class="row">
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="media-body">
                        <h5 class="font-size-14">Total Created Event</h5>
                    </div>
                    <div class="avatar-xs">
                        <span class="avatar-title rounded-circle bg-primary">
                            <i class="dripicons-box"></i>
                        </span>
                    </div>
                </div>
                <h4 class="m-0 align-self-center"><?= $dashboard->getTotalEvent(); ?></h4>
                <p class="mb-0 mt-3 text-muted"><span class="text-success">1.23 % <i
                            class="mdi mdi-trending-up mr-1"></i></span> From previous period</p>
            </div>
        </div>
    </div>
    <?php
    if (isset($getActiveEvent[0])) { ?>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="media">
                        <div class="media-body">
                            <h5 class="font-size-14">Active Event</h5>
                        </div>
                        <div class="avatar-xs">
                            <span class="avatar-title rounded-circle bg-primary">
                                <i class="dripicons-tags"></i>
                            </span>
                        </div>
                    </div>
                    <h4 class="m-0 align-self-center"> <?= $getActiveEvent[0]['total']; ?>
                    </h4>
                    <p class="mb-0 mt-3 text-muted"><span class="text-success">7.21 %
                            <i class="mdi mdi-trending-up mr-1"></i></span> From previous period</p>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="media-body">
                        <h5 class="font-size-14">Inactive Or Completed Event</h5>
                    </div>
                    <div class="avatar-xs">
                        <span class="avatar-title rounded-circle bg-primary">
                            <i class="dripicons-cart"></i>
                        </span>
                    </div>
                </div>
                <h4 class="m-0 align-self-center"><?= $dashboard->getInactiveEvent(); ?></h4>
                <p class="mb-0 mt-3 text-muted"><span class="text-success">7.21 % <i
                            class="mdi mdi-trending-up mr-1"></i></span> From previous period</p>
            </div>
        </div>

    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="media-body">
                        <h5 class="font-size-14">Total Attendee</h5>
                    </div>
                    <div class="avatar-xs">
                        <span class="avatar-title rounded-circle bg-primary">
                            <i class="dripicons-briefcase"></i>
                        </span>
                    </div>
                </div>
                <h4 class="m-0 align-self-center"><?= $dashboard->getTotalAttendee(); ?></h4>
                <p class="mb-0 mt-3 text-muted"><span class="text-danger">4.35 % <i
                            class="mdi mdi-trending-down mr-1"></i></span> From previous period</p>
            </div>
        </div>
    </div>



</div>
<?php if (isset($getActiveEvent[0])) { ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div dir="ltr">
                        <h5>Active Events</h5>
                        <div class="row justify-content-center">

                            <div class="col-lg-8">
                                <div class="slick-slider slider-for hori-timeline-desc">
                                    <?php foreach ($getActiveEvent as $row) { ?>
                                        <div>
                                            <h5 class="text-primary"><?= $row['date']; ?></h5>
                                            <p><?= $row['name']; ?></p>
                                            <p>" <?= $row['description']; ?>"</p>
                                        </div>

                                    <?php } ?>

                                </div>


                                <div class="slick-slider slider-nav hori-timeline-nav">
                                    <?php foreach ($getActiveEvent as $row) { ?>
                                        <div class="slider-nav-item py-2">
                                            <h5 class="mb-1"><?= $row['date']; ?></h5>
                                            <p class="mb-0 d-none d-sm-block font-size-13"><?= $row['location']; ?></p>
                                        </div>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<!-- end row -->



<!-- JAVASCRIPT -->
<script src="assets/libs/jquery/jquery.min.js"></script>

<script src="assets/libs/slick-slider/slick/slick.min.js"></script>

<script src="assets/js/pages/timline.init.js"></script>


<!-- <script src="assets/js/app.js"></script> -->