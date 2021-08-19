<?php
$projects = $params['model'];
$searchValue = $params['search']['value'];
$searches = $params['search']['results'] ?? false;

//echo '<pre>';
//var_dump($searches);
//echo '</pre>'
?>
<div>
    <div>
        <h1 class="main-heading py-16">
            Nyeri County Project Management System
        </h1>
        <h2 class="sub-heading">Dashboard</h2>
    </div>

    <!-- Counters -->
    <div class="g-container py-16">
        <div class="card">
            <div class="card-header py-8">
                <h2 class="card-heading">All Projects</h2>
            </div>
            <div class="card-content">
                <h3 class="card-text">
                    <?php echo count($projects)?>
                </h3>
            </div>
        </div>

        <div class="card">
            <div class="card-header py-8">
                <h2 class="card-heading">Completed Projects</h2>
            </div>
            <div class="card-content">
                <h3 class="card-text">
                </h3>
            </div>
        </div>

        <div class="card">
            <div class="card-header py-8">
                <h2 class="card-heading">Approved Projects</h2>
            </div>
            <div class="card-content">
                <h3 class="card-text">
                </h3>
            </div>
        </div>

        <div class="card">
            <div class="card-header py-8">
                <h2 class="card-heading">Pending Projects</h2>
            </div>
            <div class="card-content">
                <h3 class="card-text">
                </h3>
            </div>
        </div>

        <div class="card">
            <div class="card-header py-8">
                <h2 class="card-heading">Ongoing Projects</h2>
            </div>
            <div class="card-content">
                <h3 class="card-text">
                </h3>
            </div>
        </div>

        <div class="card">
            <div class="card-header py-8">
                <h2 class="card-heading">Delayed Projects</h2>
            </div>
            <div class="card-content">
                <h3 class="card-text">
                </h3>
            </div>
        </div>
    </div>
    <!-- Counters -->

    <!-- Innovation -->
    <div class="g-container py-16">

        <div class="card" style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('assets/img/farmer.jpg'); background-size: cover;
    background-position: center; height: 150px;">
            <div class="card-header py-8">
                <h2 class="primary-font primary">Farming Projects</h2>
            </div>
            <div class="card-content">
                <h3 class="secondary-font light">
                   Helping the county to grow
                </h3>
            </div>
        </div>

        <div class="card" style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('assets/img/school.JPG'); background-size: cover;
    background-position: center; height: 150px;">
            <div class="card-header py-8">
                <h2 class="primary-font primary">School Projects</h2>
            </div>
            <div class="card-content">
                <h3 class="secondary-font light">
                   Helping the county to grow
                </h3>
            </div>
        </div>

        <div class="card" style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ),url('assets/img/roads.JPG'); background-size: cover;
    background-position: center; height: 150px;">
            <div class="card-header py-8">
                <h2 class="primary-font primary">Road Projects</h2>
            </div>
            <div class="card-content">
                <h3 class="secondary-font light">
                   Helping the county to grow
                </h3>
            </div>
        </div>

        <div class="card" style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('assets/img/solar.png'); background-size: cover;
    background-position: center top; height: 150px;">
            <div class="card-header py-8">
                <h2 class="primary-font primary">Energy Projects</h2>
            </div>
            <div class="card-content">
                <h3 class="secondary-font light">
                   Helping the county to grow
                </h3>
            </div>
        </div>
    </div>
    <!-- /Innovation -->

    <!-- Table -->
    <div class="recent">
        <!-- activity section -->
        <div class="activity-card">
            <h3 class="pt-8">Recent Activity</h3>
            <!-- tables where we will display recent projects -->

            <div style="display: flex; justify-content: flex-start; justify-items: flex-start">
                <form action="" method="get">
                    <input class="search-input" type="text" name="search" value="<?php echo $searchValue ?>" placeholder="Search Projects">

                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                    <tr>
                        <th>Project</th>
                        <th>Department</th>
                        <th>Sub County - Ward</th>
                        <th>F. Year</th>
                        <th>Budget</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                    </tr>
                    </thead>

                        <?php if($searches):?>
                            <tbody>
                            <?php foreach ($searches as $search):?>
                                <tr>
                                    <td> <?php echo $search['project_name']; ?> </td>
                                    <td><?php echo $search['dep_name']; ?></td>
                                    <td><?php echo $search['sub_name'] . " - " . $search['ward']; ?></td>
                                    <td><?php echo $search['year_name']; ?></td>
                                    <td>Ksh <?php echo number_format($search['budget']) ?></td>
                                    <td><?php echo date_format(date_create($search['start_date']), 'd-M-Y'); ?></td>
                                    <td><?php echo date_format(date_create($search['end_date']), 'd-M-Y');; ?></td>
                                    <td>
                                        <?php if ($search['pr_status'] === "pending"): ?>
                                            <span class="badge badge-primary">
                                    <?php echo ucfirst($search['pr_status']); ?>
                                </span>
                                        <?php elseif ($search['pr_status'] === "approved"): ?>
                                            <span class="badge badge-warning">
                                    <?php echo  ucfirst($search['pr_status']); ?>
                                </span>
                                        <?php elseif($search['pr_status'] === "ongoing"): ?>
                                            <span class="badge badge-info">
                                    <?php echo ucfirst($search['pr_status']); ?>
                                </span>
                                        <?php elseif($search['pr_status'] === "complete"): ?>
                                            <span class="badge badge-success">
                                    <?php echo ucfirst($search['pr_status']); ?>
                                </span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">
                                    <?php echo ucfirst($search['pr_status']); ?>
                                </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        <?php else: ?>
                            <tbody>
                                <tr>
                                    <td colspan="">No record Found</td>
                                </tr>
                            </tbody>
                        <?php endif; ?>

                </table>
                <!-- End of Table -->
            </div>
        </div>

    </div>
    <!-- /Table -->
</div>











<!--<tbody>-->
<?php //foreach ($projects as $project):?>
<!--    <tr>-->
<!--        <td> --><?php //echo $project['project_name']; ?><!-- </td>-->
<!--        <td>--><?php //echo $project['dep_name']; ?><!--</td>-->
<!--        <td>--><?php //echo $project['sub_name'] . " - " . $project['ward']; ?><!--</td>-->
<!--        <td>--><?php //echo $project['year_name']; ?><!--</td>-->
<!--        <td>Ksh --><?php //echo number_format($project['budget']) ?><!--</td>-->
<!--        <td>--><?php //echo date_format(date_create($project['start_date']), 'd-M-Y'); ?><!--</td>-->
<!--        <td>--><?php //echo date_format(date_create($project['end_date']), 'd-M-Y');; ?><!--</td>-->
<!--        <td>-->
<!--            --><?php //if ($project['pr_status'] === "pending"): ?>
<!--                <span class="badge badge-primary">-->
<!--                                    --><?php //echo ucfirst($project['pr_status']); ?>
<!--                                </span>-->
<!--            --><?php //elseif($project['pr_status'] === "approved"): ?>
<!--                <span class="badge badge-warning">-->
<!--                                    --><?php //echo  ucfirst($project['pr_status']); ?>
<!--                                </span>-->
<!--            --><?php //elseif($project['pr_status'] === "ongoing"): ?>
<!--                <span class="badge badge-info">-->
<!--                                    --><?php //echo ucfirst($project['pr_status']); ?>
<!--                                </span>-->
<!--            --><?php //elseif($project['pr_status'] === "complete"): ?>
<!--                <span class="badge badge-success">-->
<!--                                    --><?php //echo ucfirst($project['pr_status']); ?>
<!--                                </span>-->
<!--            --><?php //else: ?>
<!--                <span class="badge badge-danger">-->
<!--                                    --><?php //echo ucfirst($project['pr_status']); ?>
<!--                                </span>-->
<!--            --><?php //endif; ?>
<!--        </td>-->
<!--    </tr>-->
<?php //endforeach; ?>
<!--</tbody>-->