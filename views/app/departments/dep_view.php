<?php
/** Department View page */
if($_SESSION['user']['user_type'] !== 'admin' ):
    Application::$app->response->redirect('/invalid-path');
endif;
$departments = $params['model'];
?>

<div class="d-flex justify-space-between align-items-center">
    <div>
        <h1 class="main-heading py-16">Nyeri County Project Management System</h1>
        <h2 class="sub-heading">Departments</h2>
    </div>

    <div>
        <a href="/department_create" class="btn btn-primary">Add new</a>
    </div>
</div>

<div class="recent">
    <!-- activity section -->
    <div class="activity-card">
        <!-- tables where we will display recent projects -->
        <div class="table-responsive">
            <table>
                <thead>
                <tr>
                    <th>Department</th>
                    <th>Status</th>
                    <th>Created at</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($departments as $department): ?>
                    <tr>
                        <td>
                            <?php echo $department['dep_name'] ?>
                        </td>
                        <td>
                            <span class="badge <?php if($department['status'] == 'active') echo 'badge-success'; else echo 'badge-danger' ?>">
                                <?php echo ucfirst($department['status']) ?>
                            </span>
                        </td>
                        <td>
                            <?php echo  date_format(date_create($department['created_at']), 'd-M-Y') ?>
                        </td>
                        <td>
                            <a href="/department_edit?id=<?php echo $department['id'] ?>" class="btn btn-secondary btn-inline">Edit</a>
                            <a onclick="function confirm(){confirm('You wanna?');}" href="/department_del?id=<?php echo $department['id'] ?>" class="btn btn-danger btn-inline">Delete</a>

                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <!-- End of Table -->
        </div>
    </div>
</div>
