<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get the form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $user = new User($db);
    $user->register($username, $email, $password, $confirm_password);
}
// $db = $database->connect();
?>
<!-- <body class=" bg-pattern"> -->
<div class="account-pages my-5 pt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center mb-5">
                    <a href="" class="logo">
                        <svg xmlns="http://www.w3.org/2000/svg" width="78" height="24" fill="none">
                            <path fill="#000" d="M38.47 20.047c2.754-1.13 4.518-3.812 4.448-6.847 0-1.976-.777-3.812-2.118-5.224-1.341-1.411-3.247-2.188-5.153-2.117-2.965 0-5.576 1.765-6.706 4.588-1.13 2.753-.494 5.93 1.553 8.047 2.118 2.118 5.224 2.753 7.977 1.553Zm-2.823-2.823c-2.047 0-3.67-1.624-3.67-3.953 0-2.33 1.623-3.953 3.67-3.953 2.047 0 3.67 1.623 3.67 3.953 0 2.329-1.623 3.953-3.67 3.953Zm37.977 3.035a5.33 5.33 0 0 0-1.977-10.236c-2.118 0-4.023 1.271-4.87 3.318-.777 1.977-.353 4.306 1.129 5.788 1.553 1.483 3.741 1.906 5.718 1.13Zm-2.047-2.612c-1.271 0-2.26-.988-2.26-2.33 0-1.411.989-2.329 2.26-2.329 1.27 0 2.258.988 2.258 2.33 0 1.34-.988 2.329-2.258 2.329ZM48.212 5.506V20.47h-3.883V5.506h3.883Zm5.788 0V20.47h-3.67V5.506H54Zm5.153 12.353-4.165-7.906h3.883l2.188 4.306 2.188-4.306h3.812L59.435 24h-3.74l3.458-6.141Z"></path>
                            <path fill="#0BC1C0" d="M4.447 9.459c0-2.33.847-4.447 2.259-6.141a10.334 10.334 0 0 0 3.741 19.976c4.447 0 8.259-2.823 9.741-6.776a9.407 9.407 0 0 1-6.211 2.329 9.371 9.371 0 0 1-9.53-9.388ZM13.906 0c-2.894 0-5.435 1.27-7.2 3.318a10.376 10.376 0 0 1 14.117 9.6c0 1.27-.211 2.47-.635 3.53a9.297 9.297 0 0 0 3.247-7.06C23.365 4.235 19.13 0 13.905 0Z"></path>
                        </svg>
                    </a>
                    <h5 class="font-size-16 text-black-50 mb-4"><b>E M S</b> - Event Management System</h5>
                </div>
            </div>
        </div>
        <!-- end row -->
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="p-2">
                            <h5 class="mb-5 text-center">Register Account to E M S</h5>


                            <?php if (isset($_GET['error'])): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php
                                    switch ($_GET['error']) {
                                        case 'empty_fields':
                                            echo "Please fill in all fields.";
                                            break;
                                        case 'password_mismatch':
                                            echo "Passwords do not match.";
                                            break;
                                        case 'user_exists':
                                            echo "Username or email already exists.";
                                            break;
                                        case 'insert_failed':
                                            echo "Registration failed. Please try again.";
                                            break;
                                    }
                                    ?>
                                </div>
                            <?php endif; ?>

                            <form class="form-horizontal" action="#" method="POST">

                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group mb-4">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="useremail">Email</label>
                                            <input type="email" class="form-control" id="useremail" name="email" placeholder="Enter email">
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="userpassword">Password</label>
                                            <input type="password" class="form-control" id="userpassword" name="password" placeholder="Enter password">
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="userpassword">Confirm Password</label>
                                            <input type="password" name="confirm_password" class="form-control" id="userpassword" placeholder="Enter password">
                                        </div>
                                        <div class="mt-4">
                                            <button class="btn btn-info btn-block waves-effect waves-light" type="submit">Register</button>
                                        </div>
                                        <div class="mt-4 text-center">
                                            <a href="?page=login" class="text-muted"><i class="mdi mdi-account-circle mr-1"></i> Already have account?</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
</div>
</body>