<?php
/** Project view */

use app\core\Application;
/*
 *
 * Project  create is only limited to admin and chief officer alone
 * We check from user_type in session if they are admin and cec, proceed
 * If not tell user they don't have permission
 */

if (!in_array(Application::$app->user->user_type, ['admin', 'cec'])):
    Application::$app->response->redirect('/invalid-path');
endif;

$projects = $params['model'];
?>


<div class="d-flex justify-space-between align-items-center">
    <div>
        <h1 class="main-heading py-16">Nyeri County Project Management System</h1>
        <h2 class="sub-heading">Approve or Decline County Projects</h2>
    </div>

</div>

<section class="recent">
    <!-- activity section -->
    <div class="activity-card">
        <!-- tables where we will display recent projects -->
        <div class="table-responsive">
            <table>
                <thead>
                <tr>
                    <th>Project Name</th>
                    <th>Department</th>
                    <th>SubCounty</th>
                    <th>F.Year</th>
                    <th>Budget</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Status</th>
                    <th>Reasons</th>
                    <th>Actions</th>
                </tr>
                </thead>
<!--                Checks if projects exist, if the do execute the code below-->
                <?php if($projects):?>
                <tbody>
                     <?php foreach ($projects as $project): ?>
                    <tr>
                        <td> <?php echo $project['project_name']; ?> </td>
                        <td><?php echo $project['dep_name']; ?></td>
                        <td><?php echo $project['sub_name']; ?></td>
                        <td><?php echo $project['year_name']; ?></td>
                        <td>Ksh <?php echo number_format($project['budget']) ?></td>
                        <td><?php echo date_format(date_create($project['start_date']), 'd-M-Y'); ?></td>
                        <td><?php echo date_format(date_create($project['end_date']), 'd-M-Y');; ?></td>
                        <td>
                            <?php if ($project['pr_status'] === "pending"): ?>
                                <span class="badge badge-primary">
                                    <?php echo ucfirst($project['pr_status']); ?>
                                </span>
                            <?php elseif($project['pr_status'] === "approved"): ?>
                                <span class="badge badge-warning">
                                    <?php echo  ucfirst($project['pr_status']); ?>
                                </span>
                            <?php elseif($project['pr_status'] === "ongoing"): ?>
                                <span class="badge badge-info">
                                    <?php echo ucfirst($project['pr_status']); ?>
                                </span>
                            <?php elseif($project['pr_status'] === "complete"): ?>
                                <span class="badge badge-success">
                                    <?php echo ucfirst($project['pr_status']); ?>
                                </span>
                            <?php else: ?>
                                <span class="badge badge-danger">
                                    <?php echo ucfirst($project['pr_status']); ?>
                                </span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo $project['reasons']; ?></td>
                        <td>
                            <div style="display: flex; justify-content: space-evenly">
                                <a onclick="return approve()" href="/projects_approve?id=<?php echo $project['id'] ?>" class="btn btn-primary btn-inline">Approve</a>
                                <a onclick="return delay()" href="/projects_delay?id=<?php echo $project['id'] ?>" class="btn btn-secondary btn-danger">Delay</a>
                            </div>
                        </td>

                    </tr>
                <?php endforeach; ?>
                </tbody>

<!--                If no pending projects exist, Echo this out-->
                <?php else:?>
                <tbody>
                    <td colspan="">No Projects to Approve/Delay</td>
                </tbody>
                <?php endif; ?>

            </table>
            <!-- End of Table -->
        </div>
    </div>
</section>
