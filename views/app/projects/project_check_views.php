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

    <?php if (Application::isAdmin() || Application::isPM()): ?>
        <div>
            <a href="/project_create" class="btn btn-primary">Add new</a>
        </div>
    <?php endif; ?>
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
                    <th>Sub County - Ward</th>
                    <th>Staff</th>
                    <th>Financial Year</th>
                    <th>Department</th>
                    <th>Budget</th>
                    <th>Status</th>
                    <th>Approval Status</th>
                    <th>Start date</th>
                    <th>End date</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($projects as $project): ?>
                    <tr>
                        <td>
                            <?php echo $project['project_name'] ?>
                        </td>
                        <td>
                            <?php echo $project['sub_name'] ?> - <?php echo $project['ward'] ?>
                        </td>
                        <td>
                            <?php echo $project['names'] ?>
                        </td>
                        <td>
                            <?php echo $project['year_name'] ?>
                        </td>
                        <td>
                            <?php echo $project['dep_name'] ?>
                        </td>
                        <td>
                            Ksh <?php echo number_format($project['budget'], ) ?>
                        </td>
                        <td>
                            <?php echo ucfirst($project['pr_status']) ?>
                        </td>
                        <td>
                            <?php if($project['status_approval'] == 'approved'): ?>
                                <span class="badge badge-success">
                                        <?php echo ucfirst($project['status_approval']) ?>
                                    </span>

                            <?php elseif ($project['status_approval'] == 'pending'): ?>
                                <span class="badge badge-warning">
                                            <?php echo ucfirst($project['status_approval']) ?>
                                        </span>

                            <?php else: ?>
                                <span class="badge badge-danger">
                                            <?php echo ucfirst($project['status_approval']) ?>
                                        </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php echo date_format(date_create($project['start_date'] ), 'd-M-Y')?>
                        </td>
                        <td>
                            <?php echo date_format(date_create($project['end_date']), 'd-M-Y') ?>
                        </td>
                        <td>
                            <?php if (Application::isAdmin() || Application::isCEC()): ?>
                                <a class="btn btn-primary btn-inline"
                                   onclick="event.preventDefault(); document.getElementById('status_req_<?php echo $project['id'] ?>').submit();">
                                    Approve
                                </a>

                                <form id="status_req_<?php echo $project['id'] ?>" action="/project_ap_status?id=<?php echo $project['id'] ?>" method="post" style="display: none">
                                    <input type="text" name="ap_approval" value="approved">
                                </form>
                            <?php endif; ?>

                            <?php if (Application::isAdmin() || Application::isCEC()): ?>
                                <a class="btn btn-danger btn-inline"
                                   onclick="event.preventDefault(); document.getElementById('status_req_d_<?php echo $project['id'] ?>').submit();">
                                    Disapprove
                                </a>

                                <form id="status_req_d_<?php echo $project['id'] ?>" action="/project_ap_status?id=<?php echo $project['id'] ?>" method="post" style="display: none">
                                    <input type="text" name="ap_approval" value="disapproved">
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <!-- End of Table -->
        </div>
    </div>
</section>
