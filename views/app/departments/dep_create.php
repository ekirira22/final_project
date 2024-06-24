<?php
/*
 * Departments create is only limited to admin alone
 * We check from user_type in session if they are admin, proceed
 * If not tell user they don't have permission
 */

if($_SESSION['user']['user_type'] !== 'admin' ):
    Application::$app->response->redirect('/invalid-path');
endif;

//get params of department and store in departments
$departments = $model;
?>
<div class="main-block">
    <div class="pb-16">
        <h2 class="main-heading">Create Department</h2>
        <p class="secondary-font">Enter the required fields</p>
    </div>

    <form action="/department_create" method="post">
        <div class="">
            <label for="">Department</label>
            <input class="form-input" type="text" name="dep_name" value="<?php echo $departments->dep_name ?? "" ?>"/>

            <div class="error">
                <small><?php echo $departments->getErrors('dep_name') ?? "" ?></small>
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
                <small><?php echo $departments->getErrors('status') ?? "" ?></small>
            </div>
        </div>



        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
