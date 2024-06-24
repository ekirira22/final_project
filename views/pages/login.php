<div class="login-form">
    <div class="py-16">
        <h2 class="sub-heading">Welcome to</h2>
        <h1 class="primary-font grey">Nyeri Project Management System</h1>

        <h4 class="secondary-font grey pt-16">Enter your credentials</h4>
    </div>

    <form action="" method="post">
        <div>
            <label for="">Email</label>
            <input name="email" class="form-input" value="<?php echo $model->email ?? "";?>">

            <div class="error">
                <small><?php echo $model->getErrors('email') ?? '' ?></small>
            </div>
        </div>

        <div>
            <label for="">Password</label>
            <input type="password" name="password" class="form-input">

            <div class="error">
                <small><?php echo $model->getErrors('password') ?? '' ?></small>
            </div>
        </div>

        <div>
            <button class="btn btn-primary" type="submit">Login</button>
        </div>
        <br>

    </form>
</div>
