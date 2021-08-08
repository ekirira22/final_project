
<div class="main-block">
    <div class="pb-16">
        <h2 class="main-heading">Create a staff</h2>
        <p class="secondary-font">Enter the required fields</p>
    </div>

    <form action="" method="post">
        <div>
            <label for="">Names</label>
            <input type="text" class="form-input " name="names" value="<?php echo $model->names ?? "";?>"/>

            <div class="error">
                <small><?php echo $model->getErrors('names') ?? '' ?></small>
            </div>
        </div>


        <div>
            <label for="">ID</label>
            <input type="text" class="form-input" name="id_number" value="<?php echo $model->id_number ?? "";?>"/>

            <div class="error">
                <small><?php echo $model->getErrors('id_number') ?? '' ?></small>
            </div>
        </div>

        <div>
            <label for="">Mobile no.</label>
            <input type="text" class="form-input" name="mobile_no" value="<?php echo $model->mobile_no ?? "";?>"/>

            <div class="error">
                <small><?php echo $model->getErrors('mobile_no') ?? ''?></small>
            </div>
        </div>

        <div>
            <label for="">Email</label>
            <input type="text" class="form-input" name="email" value="<?php echo $model->email ?? "";?>"/>

            <div class="error">
                <small><?php echo $model->getErrors('email') ?? '' ?></small>
            </div>
        </div>

        <div>
            <label for="">Password</label>
            <input type="password" class="form-input" name="password"/>

            <div class="error">
                <small><?php echo "" ?? $model->getErrors('password') ?></small>
            </div>
        </div>

        <div>
            <label for="">Confirm Password</label>
            <input type="password" class="form-input" name="confirmPassword"/>

            <div class="error">
                <small><?php echo $model->getErrors('confirmPassword') ?></small>
            </div>
        </div>

        <div>
            <label for="">Status</label>
            <select name="status" class="form-input">
                <option selected></option>
                <option value="active">Active</option>
                <option value="inactive">InActive</option>
            </select>

            <div class="error">
                <small><?php echo $model->getErrors('status') ?></small>
            </div>
        </div>

        <div>
            <label for="">Staff level</label>
            <select name="user_type" class="form-input">
                <option selected></option>
                <option value="admin">Admin</option>
                <option value="cec">Chief Officer</option>
                <option value="pm">Project Manager</option>
                <option value="st">Staff</option>
            </select>

            <div class="error">
                <small><?php echo $model->getErrors('user_type') ?></small>
            </div>
        </div>


        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>