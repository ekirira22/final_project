<!--Main Application Layout-->
<?php
use app\core\Application;

if(!$_SESSION['user']):
    Application::$app->response->redirect('/invalid-path');
endif;

$user = Application::$app->user;


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nyeri PMS</title>

    <!-- Styles -->
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <!-- Left navigation -->
        <ul class="left-nav">
            <li class="nav-list">
                <a class="nav-link" href="/">
                    <img src="assets/icons/dashboard.svg" alt="" style="width: 15px; height: 15px;"> Dashboard
                </a>
            </li>
            <li class="nav-list">
                <div class="dropdown">
                    <a class="drop-prop" href="#">
                        <img src="assets/icons/workflow.svg" alt="" style="width: 15px; height: 15px;"> Workflow
                    </a>
                    <div class="dropdown-content">

                    </div>
                </div>
            </li>
            <li class="nav-list">
                <div class="dropdown">
                    <a class="drop-prop" href="#">
                        <img src="assets/icons/layers.svg" alt="" style="width: 15px; height: 15px;"> Projects & Tasks
                    </a>
                    <div class="dropdown-content">

                    </div>
                </div>
            </li>

            <li class="nav-list">
                    <div class="dropdown">
                        <a class="drop-prop" href="#">
                            <img src="assets/icons/settings.svg" alt="" style="width: 15px; height: 15px;"> Settings
                        </a>
                        <div class="dropdown-content">
                            <a class="nav-link" href="/financial_year">Financial year</a>
                            <a class="nav-link" href="/departments">Departments</a>
                            <a class="nav-link" href="/sub_counties">Sub Counties</a>
                            <a class="nav-link" href="/county_staffs">Staffs</a>
                        </div>
                    </div>
            </li>

                <li class="nav-list" style="margin-left: 800px">
                    <a class="nav-link" href="/logout">
                        Welcome <?php echo $user->names;?>
                        (Logout)
                    </a>
                </li>

        </ul>
        <!-- /Left navigation -->

        <!-- Right navigation -->
        <!-- Right navigation -->
    </nav>
    <!-- /Navigation -->


<!--Content-->
<div class="container">

    <?php if(Application::$app->session->getFlashMessage('success')): ?>

        <div class="alert alert-success">
            <?php echo Application::$app->session->getFlashMessage('success'); ?>
        </div>

    <?php endif; ?>



    {{content}}

</div>
<!--/Content-->
</body>
</html>

