<?php
/** User report View */

use app\core\Application;
/*
 * If user is not admin
 */
if(!in_array(Application::$app->user->user_type, ['admin', 'pm', 'cec']))
{
    Application::$app->response->redirect('invalid-path');
}

//$reports = $params['model']; won't be necessary

$from_date = $params['filtered']['values'][0];
$to_date = $params['filtered']['values'][1];

$filtered_reports = $params['filtered']['results'];


//var_dump($filtered_activities);
//
?>


<div class="d-flex justify-space-between align-items-center">
    <div>
        <h1 class="main-heading py-16">Nyeri County Project Management System</h1>
        <h2 class="sub-heading">Reports By Status</h2>
    </div>
</div>
<h3 class="card-heading">Filter By Dates</h3>

<div>
    <form action="" method="get">

        <!--        If user searches for no one we want to return everything-->
        <label for="">Project Status</label>
        <select name="pr_status" class="search-input">
            <option value="true" selected>Select one</option>
            <option value="pending" > Pending Projects </option>
            <option value="delayed" > Delayed Projects </option>
            <option value="approved" > Approved Projects </option>
            <option value="ongoing" > Ongoing Projects </option>
            <option value="complete" > Completed Projects </option>

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
                    <th>Project Name</th>
                    <th>In Charge</th>
                    <th>Department</th>
                    <th>SubCounty</th>
                    <th>F.Year</th>
                    <th>Budget</th>
                    <th>Start</th>
                    <th>End</th>

                </tr>
                </thead>
                <!--If filtered activities exist, do the following-->
                <?php if($filtered_reports):?>
                    <tbody>

                    <!-- Here we want to loop through each report and display it to the admin-->
                    <?php foreach ($filtered_reports as $report):?>

                        <tr>
                            <td> <?php echo $report['project_name']; ?> </td>
                            <td> <?php echo $report['names']; ?> </td>
                            <td><?php echo $report['dep_name']; ?></td>
                            <td><?php echo $report['sub_name']; ?></td>
                            <td><?php echo $report['year_name']; ?></td>
                            <td>Ksh <?php echo number_format($report['budget']) ?></td>
                            <td><?php echo date_format(date_create($report['start_date']), 'd-M-Y'); ?></td>
                            <td><?php echo date_format(date_create($report['end_date']), 'd-M-Y');; ?></td>
                        </tr>

                    <?php endforeach;?>

                    </tbody>
                    <!--If filtered activities do not exist, the do this-->
                <?php else:?>
                    <tbody>
                    <td colspan=""> No such filtered report </td>
                    </tbody>
                <?php endif;?>

            </table>
            <!-- End of Table -->
        </div>
    </div>
</section>
