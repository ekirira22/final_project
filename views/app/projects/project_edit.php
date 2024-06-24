<?php
/** Project Edit page */
/*
 *
 * Project  create is only limited to admin and pm alone
 * We check from user_type in session if they are admin and pm, proceed
 * If not tell user they don't have permission
 */
use app\core\Application;
if (!in_array(Application::$app->user->user_type, ['admin', 'pm'])):
    Application::$app->response->redirect('/invalid-path');
endif;

$data = $params['model'];
//Loads data for departments, sub_counties and financial years, loops and displays as values
//for selection
$project = $params['model']['project']  ?? [];
//Loads current project data per the project id and displays on user input fields
//var_dump($project->id);

?>

<div class="main-block">
    <div class="pb-16">
        <h2 class="main-heading">Update Project</h2>
        <p class="secondary-font">Enter the required fields</p>
    </div>

    <form action="/project_update?id=<?php echo $project->id; ?>" method="post">
        <div>
            <label for="">Project Name</label>
            <label>
                <input type="text" class="form-input" name="project_name" value="<?php echo $project->project_name; ?>"/>
            </label>
        </div>

        <!--Loop through the departments, subcounties and financial years passed an associative array via model,
        and display all of them as options. If the department['id], sub_county['id'] and f_year['id'] in the database is the same as the one
        that was fetched via project id, set that option to selected for it to come as selected for the user-->
        <div>
            <label for="">County Staff</label>
            <label>
                <select name="staff_id" class="form-input">
                    <option value="" selected>Select one</option>
                    <?php foreach ($data['staffs'] as $staff): ?>
                        <option value="<?php echo $staff['id'] ?>" <?php if($staff['id'] == $project->staff_id) echo 'selected=selected' ?>>
                            <?php echo $staff['names'] . ' - ' . $staff['dep_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>

        <div>
            <label for="">Department</label>
            <label>
                <select name="dep_id" class="form-input">
                    <option value="" selected>Select one</option>
                    <?php foreach ($data['departments'] as $department): ?>
                        <option value="<?php echo $department['id'] ?>" <?php if($department['id'] == $project->dep_id) echo 'selected=selected' ?>>
                            <?php echo $department['dep_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>

        <div>
            <label for="">Sub County</label>
            <label>
                <select name="sub_id" class="form-input">
                    <option value="" selected>Select one</option>
                    <?php foreach ($data['sub_counties'] as $sub_county): ?>
                        <option value="<?php echo $sub_county['id'] ?>" <?php if($sub_county['id'] == $project->sub_id) echo 'selected=selected' ?>>
                            <?php echo $sub_county['sub_name'] ?> - <?php echo $sub_county['ward'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>

        <div>
            <label for="">Financial Year</label>
            <label>
                <select name="year_id" class="form-input">
                    <option value="" selected>Select one</option>
                    <?php foreach ($data['f_years'] as $year): ?>
                        <option value="<?php echo $year['id'] ?>" <?php if($project->year_id) echo 'selected=selected' ?>><?php echo $year['year_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>

        <div>
            <label for="">Budget</label>
            <label>
                <input type="text" class="form-input" name="budget" value="<?php echo $project->budget; ?>"/>
            </label>
        </div>


        <div>
            <label for="">Start date</label>
            <label>
                <input type="date" class="form-input" name="start_date" value="<?php echo $project->start_date; ?>"/>
            </label>
        </div>

        <div>
            <label for="">End date</label>
            <label>
                <input type="date" class="form-input" name="end_date" value="<?php echo $project->end_date; ?>"/>
            </label>
        </div>

        <div>
            <label for="">Remarks</label>
            <label>
                <textarea name="remarks" class="form-input"><?php echo $project->remarks; ?></textarea>
            </label>
        </div>

        <div>
            <label for="">Reasons for Re-Approval / Delay</label>
            <label>
                <textarea name="reasons" class="form-input"><?php echo $project->reasons; ?></textarea>
            </label>
        </div>


        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
