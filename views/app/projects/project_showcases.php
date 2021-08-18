<?php
/** Project showcases */
$projects = $params['model']['projects'];
$sub_counties = $params['model']['sub_counties']
?>


<div>
    <h1 class="main-heading py-16">Nyeri County Project Management System</h1>
    <h2 class="sub-heading">Projects</h2>

    <div class="pt-24 pb-8">
        <h3 class="secondary-font grey">Filters</h3>
        <small class="secondary-font">Filter by sub-county</small>
    </div>

    <form action="/project_showcase_filtered" method="post">
        <div class="d-flex justify-space-between">
            <div>
                <label for="">Sub County</label>
                <select name="sub_county_id" class="form-input" required>
                    <option selected>Select one</option>
                    <?php foreach ($sub_counties as $sub_county): ?>
                        <option value="<?php echo $sub_county['id'] ?>">
                            <?php echo $sub_county['sub_name'] ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div>
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>
</div>

<?php if($projects): ?>
<div class="g-container py-16">
    <?php foreach ($projects as $project): ?>
        <div class="card">
            <div>
                <h5 class="secondary-font">Approval: <?php echo ucfirst($project['status_approval']) ?></h5>
            </div>
            <div class="d-flex justify-space-between align-items-center card-header py-8">
                <h2 class="card-heading">
                    <?php echo $project['project_name'] ?>
                </h2>
                <h4 class="secondary-font secondary">
                    Status: <?php echo ucfirst($project['pr_status'] )?>
                </h4>
            </div>

            <div class="d-flex justify-space-between pb-16">
                <h4 class="secondary-font secondary">
                    Start date: <?php echo date_format(date_create($project['start_date']), 'd-M-Y') ?>
                </h4>
                <h4 class="secondary-font secondary">
                    End date: <?php echo date_format(date_create($project['end_date']), 'd-M-Y') ?>
                </h4>
            </div>

            <div class="card-content">
                <h4 class="secondary-font grey">
                    Sub County - Ward: <?php echo $project['sub_name'] ?> - <?php echo $project['ward'] ?>
                </h4>
                <h4 class="secondary-font secondary">
                    Budget: Ksh <?php echo number_format($project['budget']) ?>
                </h4>
                <h4 class="secondary-font grey">
                    Department: <?php echo $project['dep_name'] ?>
                </h4>

                <div class="py-24">
                    <a class="btn btn-primary" href="/project_showcase?id=<?php echo $project['id'] ?>">View Tasks</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

    <?php else: ?>
    <div class="py-32">
        <h2 class="secondary-font grey">No projects added yet.</h2>
    </div>
<?php endif ?>

