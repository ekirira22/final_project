<?php
/** Financial year create */

use app\core\Application;

/*
 * Financial year create is only limited to admin alone
 * We check from user_type in session if they are admin, proceed
 * If not tell user they don't have permission
 */

if($_SESSION['user']['user_type'] !== 'admin' ):
    Application::$app->response->redirect('/invalid-path');
endif;
//get params of financial years and store in fy
$fy = $params['model'];
?>

<div class="main-block">
    <div class="pb-16">
        <h2 class="main-heading">Create Financial Year</h2>
        <p class="secondary-font">Enter the required fields</p>
    </div>
    <form action="" method="post">
        <div class="info">
            <label for="">Financial Year</label>
            <input class="form-input" type="text" name="year_name" value="<?php echo $fy->year_name; ?>">

            <div class="error">
                <small><?php echo $fy->getErrors('year_name') ?></small>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
