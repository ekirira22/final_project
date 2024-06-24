<?php
    use app\core\Application;
?>

<div>
    <h1 class="main-heading">HTTP ERROR: <?php echo Application::$app->response->getStatusCode(); ?></h1><hr>
    <h2 class="secondary-font grey">Aw, snap!! <br> You don't have permission to access this page!</h2>
    <br>
    <h3 class="secondary-font grey">Go back to <a href="/">Home</a> Page</h3>

</div>
