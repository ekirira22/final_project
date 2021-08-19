<?php
/** Staff view */
use app\core\Application;
if($_SESSION['user']['user_type'] !== 'admin' ):
    Application::$app->response->redirect('/invalid-path');
endif;

$staffs = $params['model'];


?>

<!--<pre>-->
<!--    --><?php //var_dump($staffs);?>
<!--</pre>-->

<div class="d-flex justify-space-between align-items-center">
    <div>
        <h1 class="main-heading py-16">Nyeri County Project Management System</h1>
        <h2 class="sub-heading">County Staffs</h2>
    </div>

    <div>
        <a href="/register" class="btn btn-primary">Add new</a>
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
                    <th>Names</th>
                    <th>Department</th>
                    <th>Email</th>
                    <th>User type</th>
                    <th>Id no.</th>
                    <th>Mobile no.</th>
                    <th>Created at</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($staffs as $staff): ?>
                    <tr>
                        <td>
                            <?php echo $staff['names'] ?>
                        </td>
                        <td>
                            <?php echo $staff['dep_name'] ?>
                        </td>
                        <td>
                            <?php echo  $staff['email'] ?>
                        </td>
                        <td>
                            <?php echo  $staff['user_type'] ?>
                        </td>
                        <td>
                            <?php echo  $staff['id_number'] ?>
                        </td>
                        <td>
                            <?php echo  $staff['mobile_no'] ?>
                        </td>
                        <td>
                            <?php echo  date_format(date_create($staff['created_at']), 'd-M-Y') ?>
                        </td>
                        <td>
                            <div style="display: flex; justify-content: space-evenly">
                                <a href="/staff_edit?id=<?php echo $staff['id'] ?>" class="btn btn-secondary">Edit</a>
                                <a onclick="return deleteConfig()"  href="/staff_del?id=<?php echo $staff['id'] ?>" class="btn btn-danger btn-inline">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <!-- End of Table -->
        </div>
    </div>
</section>
