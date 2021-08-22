<?php
/** Project showcase */
use app\core\Application;

$project = $params['model']['projects'];
$tasks = $params['model']['tasks'];


?>

<div class="pb-16">
    <h1 class="main-heading py-16">Nyeri County Project Management System</h1>
    <h2 class="sub-heading">Project</h2>
</div>

<div class="card">
    <div class="d-flex justify-space-between justify-space-between  align-items-center card-header py-8">
        <h1 class="primary-font grey">
            <?php echo $project->project_name ?>
        </h1>

        <h2 class="secondary-font secondary">
            Status: <?php echo ucfirst($project->pr_status )?>
        </h2>

    </div>
    <div class="d-flex justify-space-between pb-16">
        <h4 class="secondary-font secondary">
            Start date: <?php echo date_format(date_create($project->start_date), 'd-M-Y') ?>
        </h4>
        <h4 class="secondary-font secondary">
            End date: <?php echo date_format(date_create($project->end_date), 'd-M-Y') ?>
        </h4>
    </div>


    <div class="card-content">
        <h3 class="secondary-font grey pb-8">
            Sub County - Ward: <?php echo $project->sub_name ?> - <?php echo $project->ward ?>
        </h3>
        <h3 class="secondary-font secondary pb-8">
            Budget: Ksh <?php echo number_format($project->budget) ?>
        </h3>
        <h3 class="secondary-font grey pb-8">
            Department: <?php echo $project->dep_name ?>
        </h3>

        <h4 class="secondary-font grey pb-8">
            Remarks: <br/>
            <?php echo $project->remarks ?>
        </h4>


        <div class="py-16">
            <div class="pb-8">
                <h2 class="primary-font grey">
                    Tasks - <?php echo count($tasks) ?>
                </h2>

            </div>


            <?php if($tasks): ?>
                <div>
                    <ol class="px-24">
                        <?php foreach ($tasks as $task): ?>
                            <li class="card py-8 secondary-font">
                                <h4 class="secondary">Task name: <?php echo $task['task_name'] ?></h4>
                                <h5>Description: <?php echo $task['description'] ?></h5>
                                <h5>Budget: Ksh <?php echo number_format($task['budget']) ?></h5>


                            </li>
                        <?php endforeach; ?>
                    </ol>
                </div>

                <?php else: ?>
                  <div class="py-8">
                      <h4 class="secondary-font grey">
                          No task available
                      </h4>
                  </div>
            <?php endif; ?>

            <div class="py-24">
                <h3 class="primary-font grey">
                    Budget Remaining: Ksh <?php echo $project->budget ?>
                </h3>
            </div>
        </div>
    </div>

<!--    We want to display this isn such a way that only the admin and staff in charge of the project can add tasks-->

    <?php if (in_array(Application::$app->user->user_type, ['staff', 'admin'])):?>
        <?php if ($project->budget !=0 ): ?>
            <hr>
            <form action="" method="post">
                <div class="info">
                    <h2 class="primary-font grey" >Finance and Task options</h2>
                    <div>
                        <label for="">Task Name</label>
                        <input type="text" class="form-input" name="task_name"/>

                    </div>
                    <div style="display: none">
                        <label for="">Project ID</label>
                        <input type="text" class="form-input" name="proj_id" value="<?php echo $project->id ;?>"/>

                    </div>
                    <div>
                        <label for="">Task Description</label>
                        <input type="text" class="form-input" name="description"/>

                    </div>

                    <div>
                        <label for="">Budget</label>
                        <input type="number" class="form-input" name="budget"/>

                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Add Task</button>
            </form>
        <?php else: ?>
<!--            Meaning they have permission to this form but have no money, i.e budget is zero-->
            <div class="info">
                <h2 class="primary-font grey" >Account Balance is Ksh 0</h2>
            </div>
        <?php endif; ?>
    <?php endif; ?>

</div>


