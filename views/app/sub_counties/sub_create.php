<?php
/** Sub county create page */
use app\core\Application;

if($_SESSION['user']['user_type'] !== 'admin' ):
    Application::$app->response->redirect('/invalid-path');
endif;

$sub_county = $params['model'];
?>

<div class="main-block">
    <div class="title">
        <h2 class="main-heading">Create Sub county</h2>
    </div>


    <form action="" method="post">
        <div>
            <div>
                <label for="">Sub county</label>
                <input class="form-input" type="text" name="sub_name" value="<?php echo $sub_county->sub_name ?>">

                <div class="error">
                    <small><?php echo $sub_county->getErrors('sub_name') ?></small>
                </div>
            </div>


            <div>
                <label for="">Ward</label>
                <input class="form-input" type="text" name="ward" value="<?php echo $sub_county->ward ?>">

                <div class="error">
                    <small><?php echo $sub_county->getErrors('ward') ?></small>
                </div>
            </div>

        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
