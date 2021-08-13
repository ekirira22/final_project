<?php
/** Financial year edit form */
use app\core\Application;

if($_SESSION['user']['user_type'] !== 'admin' ):
    Application::$app->response->redirect('/invalid-path');
endif;

$financial_year = $params['model'];
?>

<div class="main-block">
    <form action="/f_year_update?id=<?php echo $financial_year->id; ?>" method="post">
        <div class="pb-16">
            <h2 class="main-heading">Update Financial Year</h2>
            <p class="secondary-font">Update the required fields</p>
        </div>
        <div class="info">
            <label for="">Financial Year</label>
            <input class="form-input" type="text" name="year_name" value="<?php echo $financial_year->year_name; ?>">
            <div class="error">
                <small><?php echo $financial_year->getErrors('year_name') ?? '' ?></small>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
