<?php
/** Financial year page */
use app\core\Application;

if($_SESSION['user']['user_type'] !== 'admin' ):
    Application::$app->response->redirect('/invalid-path');
endif;

$financial_years = $params['model']

?>

<div class="d-flex justify-space-between align-items-center">
    <div>
        <h1 class="main-heading py-16">Nyeri County Project Management System</h1>
        <h2 class="sub-heading">Financial Year</h2>
    </div>

    <div>
        <a href="/f_year_create" class="btn btn-primary">Add new</a>
    </div>
</div>



<div class="py-24">
    <!-- activity section -->
    <div class="activity-card">
        <!-- tables where we will display recent projects -->
        <div class="table-responsive">
            <table>
                <thead>
                <tr>
                    <th>Financial Year</th>
                    <th>Created at</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($financial_years as $year): ?>
                    <tr>
                        <td>
                            <?php echo $year['year_name'] ?>
                        </td>
                        <td>
                            <?php echo date_format(date_create($year['created_at']), 'd-M-Y') ?>
                        </td>
                        <td>
                            <a class="btn btn-secondary btn-inline" href="/f_year_edit?id=<?php echo $year['id'] ?>">Edit</a>
                            <a class="btn btn-danger btn-inline" href="/f_year_del?id=<?php echo $year['id'] ?>">Delete</a>

                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <!-- End of Table -->
        </div>
    </div>
</div>


