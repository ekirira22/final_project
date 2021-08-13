<?php

if($_SESSION['user']['user_type'] !== 'admin' ):
    Application::$app->response->redirect('/invalid-path');
endif;

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
                <label for="">Password</label>
                <input type="password" class="form-input" name="password"/>

                <div class="error">
                    <small><?php echo $staff->getErrors('password') ?? "" ?></small>
                </div>
            </div>

            <div>
                <label for="">Confirm Password</label>
                <input type="password" class="form-input" name="confirmPassword"/>

                <div class="error">
                    <small><?php echo $staff->getErrors('confirmPassword') ?? "" ?></small>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
