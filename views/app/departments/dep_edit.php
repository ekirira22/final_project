<?php
/** Department Edit page */
if($_SESSION['user']['user_type'] !== 'admin' ):
    Application::$app->response->redirect('/invalid-path');
endif;
$department = $model;
?>

<div class="main-block">
    <div class="title">
        <h2 class="main-heading">Update Department</h2>
    </div>
    <form action="/department_edit?id=<?php echo $department->id;?>" method="post">
        <div>
            <label for="">Department</label>
            <input class="form-input" type="text" name="dep_name" value="<?php echo $department->dep_name; ?>">

            <div class="error">
                <small><?php echo $department->getErrors('dep_name') ?></small>
            </div>

        </div>

        <div>
            <label for="">Status</label>
            <select name="status" class="form-input">
                <option value="" selected>Select one</option>
                <option value="active">Active</option>
                <option value="inactive">InActive</option>
            </select>

            <div class="error">
                <small><?php echo $department->getErrors('status') ?></small>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

