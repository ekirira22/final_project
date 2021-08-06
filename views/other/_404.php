<?php
    use app\core\Application;
?>
<div>
    <h1 class="main-heading">HTTP ERROR: <?php echo Application::$app->response->getStatusCode(); ?></h1>
    <h2 class="secondary-font grey">Ooops!! You don't have permission to access this page!</h2>

</div>
