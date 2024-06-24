<?php

/*
 * Anyone can access this page so we don't need to limit
 */
$staff = $params['model'];

?>

<div class="pb-16">
    <h2 class="main-heading">Change Security Password</h2>
    <p class="secondary-font">Note: Passwords must be more than 6 characters and must match!</p>
</div>

<div class="main-block">
    <form action="/staff_change_password" method="post">
        <div class="info">
            <div>
                <label for="">Current Password</label>
                <input type="password" class="form-input" name="oldPassword"/>

            </div>
            <div>
                <label for="">New Password</label>
                <input type="password" class="form-input" name="password"/>

                <div class="error">
                    <small><?php echo $staff->getErrors('password') ?? "" ?></small>
                </div>
            </div>

            <div>
                <label for="">Confirm New Password</label>
                <input type="password" class="form-input" name="confirmPassword"/>

                <div class="error">
                    <small><?php echo $staff->getErrors('confirmPassword') ?? "" ?></small>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
