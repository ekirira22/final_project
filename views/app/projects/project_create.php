<?php
/** Project create page */

use app\core\Application;

/*
 *
 * Project  create is only limited to admin and pm alone
 * We check from user_type in session if they are admin and pm, proceed
 * If not tell user they don't have permission
 */

if (!in_array(Application::$app->user->user_type, ['admin', 'pm'])):
    Application::$app->response->redirect('/invalid-path');
endif;

$subcounties = $params['subCountyModel'];
//Returns an object with all the sub counties from the database
$departments = $params['departmentModel'];
//Returns an object with all the departments from the database
$fyears = $params['fyearModel'];
//Returns an object with all the financial years from the database
$projects = $params['projectModel'];
//Returns and object with all the projects information loaded from the user input
$staffs = $params['staffs']

?>

<div class="main-block">
    <div class="pb-16">
        <h2 class="main-heading">Create Project</h2>
        <p class="secondary-font">Enter the required fields</p>
    </div>

    <form action="" method="post">
        <div class="info">
            <label for="">Name</label>
            <input type="text" class="form-input" name="project_name" value="<?php echo $projects->project_name ?? '' ?>"/>
        </div>

        <div class="error">
            <small><?php echo $projects->getErrors('project_name') ?? "" ?></small>
        </div>

        <div>
            <label for="">County Staff</label>
            <select name="staff_id" class="form-input">
                <option value="" selected>Select one</option>
                <?php foreach ($staffs as $staff) { ?>
                    <option value="<?php echo $staff['id']; ?>" > <?php echo $staff['names'] . ' - ' . $staff['dep_name']; ?> </option>
                <?php } ?>
            </select>
        </div>

        <div>
            <label for="">Department</label>
            <select name="dep_id" class="form-input">
                <option value="" selected>Select one</option>
                <?php foreach ($departments as $department) { ?>
                    <option value="<?php echo $department['id']; ?>" > <?php echo $department['dep_name']; ?> </option>
                <?php } ?>
            </select>
        </div>

        <div class="error">
            <small><?php echo $projects->getErrors('dep_id') ?? "" ?></small>
        </div>

        <div>
            <label for="">Sub County</label>
            <select name="sub_id" class="form-input">
                <option value="" selected>Select one</option>
                <?php foreach ($subcounties as $subcounty) { ?>
                    <option value="<?php echo $subcounty['id']; ?>" > <?php echo $subcounty['sub_name'] . '  -  ' .  $subcounty['ward']; ?> </option>
                <?php } ?>
            </select>
        </div>

        <div class="error">
            <small><?php echo $projects->getErrors('sub_id') ?? "" ?></small>
        </div>


        <div>
            <label for="">Financial Year</label>
            <select name="year_id" class="form-input">
                <option value="" selected>Select one</option>
                <?php foreach ($fyears as $fyear) { ?>
                    <option value="<?php echo $fyear['id']; ?>" > <?php echo $fyear['year_name']; ?> </option>
                <?php } ?>
            </select>
        </div>
        <div class="error">
            <small><?php echo $projects->getErrors('year_id') ?? "" ?></small>
        </div>

        <div>
            <label for="">Budget</label>
            <input type="text" class="form-input" name="budget" value="<?php echo $projects->budget ?? '' ?>"/>
        </div>
        <div class="error">
            <small><?php echo $projects->getErrors('budget') ?? "" ?></small>
        </div>

        <div>
            <label for="">Start date</label>
            <input type="date" class="form-input" name="start_date" value="<?php echo $projects->start_date ?? '' ?>"/>
        </div>
        <div class="error">
            <small><?php echo $projects->getErrors('start_date') ?? "" ?></small>
        </div>

        <div>
            <label for="">End date</label>
            <input type="date" class="form-input" name="end_date" value="<?php echo $projects->end_date ?? '' ?>"/>
        </div>

        <div class="error">
            <small><?php echo $projects->getErrors('end_date') ?? "" ?></small>
        </div>

        <div>
            <label for="">Remarks</label>
            <textarea name="remarks" class="form-input" value="<?php echo $projects->remarks ?? ''  ?>"></textarea>
        </div>

        <div class="error">
            <small><?php echo $projects->getErrors('remarks') ?? "" ?></small>
        </div>


        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

