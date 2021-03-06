<?php

/*
 * This page to is accessible to all staff to edit their personal data
 */
use app\core\Application;
    if(!Application::$app->user->user_type):
        Application::$app->response->redirect('/invalid-path');
    endif;

    $staff = $params['model'];
    $departments = $params['departmentModel'] ?? [];

?>

<div class="pb-16">
    <h2 class="main-heading">Update staff</h2>
    <p class="secondary-font">Enter the required fields</p>
</div>

<div class="main-block">
    <form action="/staff_update?id=<?php echo $staff->id; ?>" method="post">
        <div class="info">
            <label for="">Names</label>
            <input type="text" class="form-input" name="names" value="<?php echo $staff->names; ?>"/>

            <div class="error">
                <small><?php echo $staff->getErrors('names') ?></small>
            </div>
        </div>
<!--        We give permission to edit departments only to admin alone-->
        <?php if(in_array(Application::$app->user->user_type, ['admin'])):?>
        <div>
            <label for="">Department</label>
            <select name="dep_id" class="form-input">
                <option value = "" selected>Select one</option>
                <?php foreach ($departments as $department): ?>
                    <option value="<?php echo $department['id'] ?>" <?php if ($department['id'] == $staff->dep_id) echo 'selected=selected' ?>>
                        <?php echo $department['dep_name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <div class="error">
                <small><?php echo $staff->getErrors('dep_id') ?></small>
            </div>
        </div>
        <?php endif; ?>

        <div>
            <label for="">ID</label>
            <input type="text" class="form-input" name="id_number" value="<?php echo $staff->id_number ?>"/>

            <div class="error">
                <small><?php echo $staff->getErrors('id_number') ?></small>
            </div>
        </div>

        <div>
            <label for="">Mobile no.</label>
            <input type="text" class="form-input" name="mobile_no" value="<?php echo $staff->mobile_no ?>"/>

            <div class="error">
                <small><?php echo $staff->getErrors('mobile_no') ?></small>
            </div>
        </div>

        <div>
            <label for="">Email</label>
            <input type="email" class="form-input" name="email" value="<?php echo $staff->email?>"/>

            <div class="error">
                <small><?php echo $staff->getErrors('email') ?></small>
            </div>
        </div>

        <!--        We give permission to edit status only to admin alone-->
        <?php if(in_array(Application::$app->user->user_type, ['admin'])):?>
        <div>
            <label for="">Status</label>
            <select name="status" class="form-input">
                <option value="" <?php if ($staff->status == '') echo ' selected="selected"'; ?>>Select one</option>
                <option value="inactive" <?php if ($staff->status == 'inactive') echo ' selected="selected"'; ?>>InActive</option>
                <option value="active" <?php if ($staff->status == 'active') echo ' selected="selected"'; ?>>Active</option>

            </select>

            <div class="error">
                <small><?php echo $staff->getErrors('status') ?></small>
            </div>
        </div>
        <?php endif;?>

        <!--        We give permission to edit staff level only to admin alone-->
        <?php if(in_array(Application::$app->user->user_type, ['admin'])):?>
        <div>
            <label for="">Staff level</label>
            <select name="user_type" class="form-input">
                <option value="" <?php if ($staff->status == '') echo ' selected="selected"'; ?>>Select one</option>
                <option value="admin" <?php if ($staff->user_type == 'admin') echo ' selected="selected"'; ?>>Admin</option>
                <option value="cec" <?php if ($staff->user_type == 'cec') echo ' selected="selected"'; ?>>Chief Officer</option>
                <option value="pm" <?php if ($staff->user_type == 'pm') echo ' selected="selected"'; ?>>Project Manager</option>
                <option value="staff" <?php if ($staff->user_type == 'staff') echo ' selected="selected"'; ?>>County Staff</option>
            </select>

            <div class="error">
                <small><?php echo $staff->getErrors('status') ?></small>
            </div>
        </div>
        <?php endif;?>


        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
