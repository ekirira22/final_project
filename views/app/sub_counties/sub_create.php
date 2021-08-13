<?php
/** Sub county create page */
$sub_county = $params['model'];
?>

<div class="main-block">
    <div class="title">
        <h2 class="main-heading">Create Sub county</h2>
    </div>


    <form action="/sub_counties" method="post">
        <div>
            <div>
                <label for="">Sub county</label>
                <input class="form-input <?php if($sub_county->hasError('sub_name')) echo 'input-invalid' ?>" type="text" name="sub_name">

                <div class="error">
                    <small><?php echo $sub_county->getFirstError('sub_name') ?></small>
                </div>
            </div>


            <div>
                <label for="">Ward</label>
                <input class="form-input <?php if($sub_county->hasError('ward')) echo 'input-invalid' ?>" type="text" name="ward">

                <div class="error">
                    <small><?php echo $sub_county->getFirstError('ward') ?></small>
                </div>
            </div>

        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
