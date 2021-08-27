<?php
/** Project showcases */
use app\core\Application;
/*
 *
 * Project  start is only limited to admin and pm alone
 * We check from user_type in session if they are admin and pm, proceed
 * If not tell user they don't have permission
 */

if (!in_array(Application::$app->user->user_type, ['admin', 'pm'])):
    Application::$app->response->redirect('/invalid-path');
endif;

//Gets all projects where status is ongoing
$projects = $params['model']['projects'];

?>


<div>
    <h1 class="main-heading py-16">Nyeri County Project Management System</h1>
    <h2 class="sub-heading">Projects</h2>

<!--Loops through the projects, if projects do exist, loop through this card and display all projects-->
<?php if($projects): ?>
<div class="g-container py-16">
    <?php foreach ($projects as $project): ?>
        <div class="card">
            <div>
                <h5 class="secondary-font">Project Handler: <?php echo ucfirst($project['names']) ?></h5>
            </div>
            <div class="d-flex justify-space-between align-items-center card-header py-8">
                <h2 class="card-heading">
                    <?php echo $project['project_name'] ?>
                </h2>
                <h4 class="secondary-font secondary">
                    Status: <?php echo ucfirst($project['pr_status'] )?>
                </h4>
            </div>



            <div class="card-content">
                <h4 class="secondary-font grey">
                    Sub County - Ward: <?php echo $project['sub_name'] ?> - <?php echo $project['ward'] ?>
                </h4>
                <h4 class="secondary-font secondary">
                    Budget: Ksh <?php echo number_format($project['budget']) ?>
                </h4>
                <h4 class="secondary-font grey">
                    Department: <?php echo $project['dep_name'] ?>
                </h4>

<!--                This buttons will defer with the user-->

                    <?php if(in_array(Application::$app->user->user_type, ['admin', 'pm'])):?>
                        <div class="py-24">
                            <a onclick="return startProject()" href="/projects_start?id=<?php echo $project['id'] ?>" class="btn btn-primary btn-warning">Start Project</a>
                        </div>
                    <?php endif;?>

            </div>
        </div>
    <?php endforeach; ?>
</div>

    <?php else: ?>
    <div class="py-32">
        <h2 class="secondary-font grey">No projects have been Approved yet.</h2>
    </div>
<?php endif ?>
