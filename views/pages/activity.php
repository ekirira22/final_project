<?php
/** User Activity View */

use app\core\Application;
/*
 * If user is not admin
 */
if(!in_array(Application::$app->user->user_type, ['admin']))
{
    Application::$app->response->redirect('invalid-path');
}

$activities = $params['model'];

$from_date = $params['filtered']['values'][0];
$to_date = $params['filtered']['values'][1];
$filtered_activities = $params['filtered']['results'];

//fetch all the staffs for display
$staffs = $params['staffs'] ?? [];

//var_dump($filtered_activities);
//
?>


<div class="d-flex justify-space-between align-items-center">
    <div>
        <h1 class="main-heading py-16">Nyeri County Project Management System</h1>
        <h2 class="sub-heading">View All User Activity</h2>
    </div>
</div>
    <h3 class="card-heading">Filter By Dates</h3>

<div>
    <form action="" method="get">

<!--        If user searches for no one we want to return everything-->
        <label for="">Staff Name</label>
        <select name="staff_id" class="search-input">
            <option value="staff_id" selected>Select one</option>
            <?php foreach ($staffs as $staff) { ?>
                <option value="<?php echo $staff['id']; ?>" > <?php echo $staff['names']; ?> </option>
            <?php } ?>
        </select>


        <label for="">From: </label>
        <input class="search-input" type="date" name="from_date" value="<?php echo $from_date?>" >

        <label for="">To: </label>
        <input class="search-input" type="date" name="to_date" value="<?php echo $to_date?>" >
        &nbsp;
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>
</div>

<section class="recent">
    <!-- activity section -->
    <div class="activity-card">
        <!-- tables where we will display recent projects -->
        <div class="table-responsive">
            <table>
                <thead>
                <tr>
                    <th>User Name</th>
                    <th>Description</th>
                    <th>Department</th>
                    <th>Permission Level</th>
                    <th>Logged At</th>

                </tr>
                </thead>
                <!--If filtered activities exist, do the following-->
                    <?php if($filtered_activities):?>
                        <tbody>

                        <!-- Here we want to loop through each activity and display it to the admin-->
                        <?php foreach ($filtered_activities as $activity):?>

                            <tr>
                                <td><?php echo $activity['names']?></td>
                                <td><?php echo $activity['description']?></td>
                                <td><?php echo $activity['dep_name']?></td>

                                <?php if($activity['user_type'] === "admin"):?>
                                    <td><?php echo "Administrator";?></td>
                                <?php endif;?>

                                <?php if($activity['user_type'] === "cec"):?>
                                    <td><?php echo "Chief Officer";?></td>
                                <?php endif;?>

                                <?php if($activity['user_type'] === "pm"):?>
                                    <td><?php echo "Project Manager";?></td>
                                <?php endif;?>

                                <?php if($activity['user_type'] === "staff"):?>
                                    <td><?php echo "Staff";?></td>
                                <?php endif;?>

                                <td><?php echo $activity['created_at']?></td>
                            </tr>

                        <?php endforeach;?>

                        </tbody>
                        <!--If filtered activities do not exist, the do this-->
                    <?php else:?>
                        <tbody>
                            <td colspan=""> No such filtered activity </td>
                        </tbody>
                    <?php endif;?>

            </table>
            <!-- End of Table -->
        </div>
    </div>
</section>
