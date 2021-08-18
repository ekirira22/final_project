<?php
/** Project view */

use app\core\Application;

$projects = $params['model'];

?>


<div class="d-flex justify-space-between align-items-center">
    <div>
        <h1 class="main-heading py-16">Nyeri County Project Management System</h1>
        <h2 class="sub-heading">Projects</h2>
    </div>

        <div>
            <a href="/project_create" class="btn btn-primary">Add new</a>
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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $projects as $project):?>
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
                            <td>
                                <?php if($project['pr_status'] === "pending" || $project['pr_status'] === "delayed"): ?>
                                <div style="display: flex; justify-content: space-evenly">
                                    <a href="/project_edit?id=<?php echo $project['id'] ?>" class="btn btn-secondary btn-inline">Edit</a>
                                    <a href="/project_del?id=<?php echo $project['id'] ?>" class="btn btn-secondary btn-danger">Delete</a>
                                </div>
                                <?php endif;?>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
            <!-- End of Table -->
        </div>
    </div>
</section>
