<?php
/** Sub county edit */
$sub_county = $params['model'];
?>

<div class="main-block">
    <div class="pb-16">
        <h2 class="main-heading">Update sub county</h2>
        <p class="secondary-font">Enter the required fields</p>
    </div>

    <form action="/sub_county_update?id=<?php echo $sub_county->id; ?>" method="post">
        <div class="info">
            <label for="">Sub County</label>
            <input class="form-input <?php if($sub_county->hasError('sub_name')) echo 'input-invalid' ?>" type="text" name="sub_name" value="<?php echo $sub_county->sub_name ?>">

            <div class="error">
                <small><?php echo $sub_county->getFirstError('sub_name') ?></small>
            </div>
        </div>

        <div>
            <label for="">Ward</label>
            <input class="form-input <?php if($sub_county->hasError('ward')) echo 'input-invalid' ?>" type="text" name="ward" value="<?php echo $sub_county->ward ?>">

            <div class="error">
                <small><?php echo $sub_county->getFirstError('ward') ?></small>
            </div>
        </div>



        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
