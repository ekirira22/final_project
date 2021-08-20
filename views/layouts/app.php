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
                <a class="nav-link" href="/home">
                    <img src="assets/icons/dashboard.svg" alt="" style="width: 15px; height: 15px;"> Dashboard
                </a>
            </li>
            <li class="nav-list">
                <div class="dropdown">
                    <a class="drop-prop" href="#">
                        <img src="assets/icons/workflow.svg" alt="" style="width: 15px; height: 15px;"> Workflow
                    </a>
                    <div class="dropdown-content">
                        <?php if(in_array(Application::$app->user->user_type, ['admin', 'cec', 'pm', 'staff'] )): ?>
                            <a class="nav-link" href="/projects_view">Track Projects</a>
                        <?php endif; ?>

                        <?php if(in_array(Application::$app->user->user_type, ['admin', 'cec'] )): ?>
                            <a class="nav-link" href="/projects_pending">Approve/Decline Projects</a>
                        <?php endif; ?>
                    </div>
                </div>
            </li>
            <li class="nav-list">
                <div class="dropdown">
                    <a class="drop-prop" href="#">
                        <img src="assets/icons/layers.svg" alt="" style="width: 15px; height: 15px;"> Projects & Tasks
                    </a>
                    <div class="dropdown-content">
                        <?php if(in_array(Application::$app->user->user_type, ['admin', 'pm'] )): ?>
                            <a class="nav-link" href="/project_create">Add projects</a>
                        <?php endif; ?>

                        <?php if(in_array(Application::$app->user->user_type, ['admin', 'pm'] )): ?>
                            <a class="nav-link" href="/projects">Manage Projects</a>
                        <?php endif; ?>

                    </div>
                </div>
            </li>
            <?php if(in_array(Application::$app->user->user_type, ['admin', 'cec', 'pm'])):?>
            <li class="nav-list">
                    <div class="dropdown">
                        <a class="drop-prop" href="#">
                            <img src="assets/icons/settings.svg" alt="" style="width: 15px; height: 15px;"> Settings
                        </a>
                        <div class="dropdown-content">

                            <?php if(in_array(Application::$app->user->user_type, ['admin'])):?>
                                <a class="nav-link" href="/financial_years">Financial year</a>
                                <a class="nav-link" href="/departments">Departments</a>
                                <a class="nav-link" href="/sub_counties">Sub Counties</a>
                                <a class="nav-link" href="/staff">Staffs</a>
                                <hr>
                                <a class="nav-link" href="/user_activity">User Activity</a>
                            <?php endif;?>
                            <a class="nav-link" href="/reports">Reports</a>


                        </div>
                    </div>
            </li>
            <?php endif;?>
            <li class="nav-list">
                <div class="dropdown">
                    <a class="drop-prop" href="#">
                        <img src="assets/icons/projects.svg" alt="" style="width: 15px; height: 15px;"> Profile
                    </a>
                    <div class="dropdown-content">
                        <a class="nav-link" href="/staff_edit_profile">Edit Profile</a>
                        <a class="nav-link" href="/staff_change_password">Change Password</a>
                        <a class="nav-link" href="/logout">Log out</a>
                    </div>
                </div>
            </li>

                <li class="nav-list" style="margin-left: 800px">
                    <a class="nav-link">
                        Welcome <?php echo $user->names;?>
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

    <?php if(Application::$app->session->getFlashMessage('failed')): ?>

        <div class="alert alert-danger">
            <?php echo Application::$app->session->getFlashMessage('failed'); ?>
        </div>

    <?php endif; ?>



    {{content}}

</div>
<!--/Content-->
</body>
<script>
    // For deletion buttons
    function deleteConfig(){

        var del=confirm("Are you sure you want to delete this record? This action cannot be reversed");
        if (del==false){
            return del;
        }

    }

    //For approval and delay buttons
    function approve(){
        var del=confirm("Approve this project? This action cannot be reversed");
        if (del==false){
            return del;
        }
    }
    function delay(){
        var del=confirm("Delay this project? This action cannot be reversed");
        if (del==false){
            return del;
        }
    }
</script>
</html>

