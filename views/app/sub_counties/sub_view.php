<?php
/** Sub county */
$sub_counties = $params['model'];
?>

<div class="d-flex justify-space-between align-items-center">
    <div>
        <h1 class="main-heading py-16">Nyeri County Project Management System</h1>
        <h2 class="sub-heading">Sub County</h2>
    </div>

    <div>
        <a href="/sub_county_create" class="btn btn-primary">Add new</a>
    </div>
</div>


<div class="recent">
    <!-- activity section -->
    <div class="activity-card">
        <!-- tables where we will display recent projects -->
        <div class="table-responsive">
            <table>
                <thead>
                <tr>
                    <th>Sub County</th>
                    <th>Ward</th>
                    <th>Created at</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($sub_counties as $sub_county): ?>
                    <tr>
                        <td>
                            <?php echo $sub_county['sub_name'] ?>
                        </td>
                        <td>
                            <?php echo  $sub_county['ward'] ?>
                        </td>
                        <td>
                            <?php echo date_format(date_create($sub_county['created_at']), 'd-M-Y')  ?>
                        </td>
                        <td>
                            <a href="/sub_county_edit?id=<?php echo $sub_county['id'] ?>" class="btn btn-secondary btn-inline">Edit</a>
                            <a class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('delete_req').submit()">Delete</a>
                            <form action="/sub_county_del?id=<?php echo $sub_county['id'] ?>" method="post" style="display: none">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <!-- End of Table -->
        </div>
    </div>
</div>
