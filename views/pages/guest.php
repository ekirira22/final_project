<?php

/*
 * Counters for project statuses
 */

$completed = $params['counters']['completed'];
$approved = $params['counters']['approved'];
$pending = $params['counters']['pending'];
$ongoing = $params['counters']['ongoing'];
$delayed = $params['counters']['delayed'];

?>
<main>

    <div class="container">

        <div>
            <div>
                <h1 class="main-heading py-16">
                    Nyeri County Projects
                </h1>
                <h2 class="sub-heading">All Projects</h2>
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
                            <?php echo count($completed)?>
                        </h3>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header py-8">
                        <h2 class="card-heading">Approved Projects</h2>
                    </div>
                    <div class="card-content">
                        <h3 class="card-text">
                            <?php echo count($approved)?>
                        </h3>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header py-8">
                        <h2 class="card-heading">Pending Projects</h2>
                    </div>
                    <div class="card-content">
                        <h3 class="card-text">
                            <?php echo count($pending)?>
                        </h3>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header py-8">
                        <h2 class="card-heading">Ongoing Projects</h2>
                    </div>
                    <div class="card-content">
                        <h3 class="card-text">
                            <?php echo count($ongoing)?>
                        </h3>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header py-8">
                        <h2 class="card-heading">Delayed Projects</h2>
                    </div>
                    <div class="card-content">
                        <h3 class="card-text">
                            <?php echo count($delayed)?>
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
                    <div class="table-responsive">
                        <table>
                            <thead>
                            <tr>
                                <th>Project</th>
                                <th>Sub County - Ward</th>
                                <th>Department</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Budget</th>
                                <th>F. Year</th>
                                <th>Approval Status</th>
                                <th>Status</th>
                            </tr>
                            </thead>

                            <tbody>

                            <tr>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                                <span class="badge badge-success">

                                    </span>


                                    <span class="badge badge-warning">

                                        </span>


                                    <span class="badge badge-danger">

                                        </span>

                                </td>
                                <td>

                                </td>
                            </tr>

                            </tbody>
                        </table>
                        <!-- End of Table -->
                    </div>
                </div>

            </div>
            <!-- /Table -->
        </div>

    </div>

</main>
