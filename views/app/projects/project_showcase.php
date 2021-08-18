<?php
/** Project showcase */
$project = $params['model']['project'];
$tasks = $params['model']['tasks'];
$total_task_budget = $params['model']['tasks_budget'];
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
                <h3 class="secondary-font secondary">
                    Total task budget - Ksh <?php echo number_format($total_task_budget) ?>
                </h3>
            </div>


            <?php if($tasks): ?>
                <div>
                    <ol class="px-24">
                        <?php foreach ($tasks as $task): ?>
                            <li class="card py-8 secondary-font">
                                <h4 class="secondary">Task name: <?php echo $task['task_name'] ?></h4>
                                <h5>Description: <?php echo $task['task_desc'] ?></h5>
                                <h5>Budget: Ksh <?php echo number_format($task['task_budget']) ?></h5>

                                <div class="pt-16">
                                    <h4 class="secondary">
                                        Status: <?php echo ucfirst($task['status']) ?>
                                    </h4>
                                </div>
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
                    Budget Remaining: Ksh <?php echo number_format($project->budget - $total_task_budget )?>
                </h3>
            </div>
        </div>
    </div>
</div>


