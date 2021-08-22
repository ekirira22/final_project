<?php
/** Project showcases */
use app\core\Application;
//Gets all projects where status is ongoing
$projects = $params['model']['projects'];

//Gets all the projects for this specific user
$staffProjects = $params['model']['staffProjects'];


?>



<div>
    <h1 class="main-heading py-16">Nyeri County Project Management System</h1>
    <h2 class="sub-heading">Projects</h2>

    <!--We want to check if the user is admin, cec or pm-->
    <!--If they are execute everything in this if, if they are not-->
    <!--Execute everything in the else statement-->

    <?php if(in_array(Application::$app->user->user_type, ['admin', 'cec', 'pm'])):?>
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

                            <!-- This buttons will defer with the user-->

                            <?php if(in_array(Application::$app->user->user_type, ['admin', 'cec', 'pm'])):?>
                                <div class="py-24">
                                    <a class="btn btn-secondary" href="/projects_showcase?id=<?php echo $project['id'] ?>">Track Project</a>
                                </div>
                            <?php endif;?>
                            <?php if(in_array(Application::$app->user->user_type, ['admin', 'pm'])):?>
                                <div class="py-24">
                                    <a onclick="return completeProject()" href="/projects_complete?id=<?php echo $project['id'] ?>" class="btn btn-primary btn-primary">Finish Project</a>
                                </div>
                            <?php endif;?>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php else: ?>
            <div class="py-32">
                <h2 class="secondary-font grey">No Ongoing Projects</h2>
            </div>
        <?php endif ?>

<?php else:?>
<!--Execute this if they are staff-->
<!--We want to do the same this as above, if the user is staff, do this except with their own specific projects in mind-->
        <?php if($staffProjects): ?>
            <div class="g-container py-16">
                <?php foreach ($staffProjects as $project): ?>
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
                            <!--                We dont need to restrict buttons since this appears only for staff-->
                                <div class="py-24">
                                    <a class="btn btn-secondary" href="/projects_showcase?id=<?php echo $project['id'] ?>">Track Project</a>
                                </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
<!--        Else meaning the no projects have been started yet-->
        <?php else: ?>
            <div class="py-32">
                <h2 class="secondary-font grey">No Ongoing Projects</h2>
            </div>

        <?php endif ?>

<?php endif;?>
