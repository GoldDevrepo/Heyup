<?php require_once('system/startup.php'); ?>
<?php require_once('library/dashboard_lib.php'); ?>
<?php require_once(HTTP_ROOT_ADMIN . 'common/header_start.php'); ?>
<?php require_once(HTTP_ROOT_ADMIN . 'common/header_end.php'); ?>
<?php require_once(HTTP_ROOT_ADMIN . 'common/header_start.php'); ?>

<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <h1><?php echo $page['title']; ?></h1>
            <?php echo $breadcrumb; ?>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="tile">
                    <div class="tile-heading">Total Users</div>
                    <div class="tile-body"><i class="fa fa-user"></i><h2 class="pull-right"><?php echo $total_users; ?></h2></div>
                    <div class="tile-footer"><a href="<?php $common->pageUrl('users/index'); ?>">View more...</a></div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="tile">
                    <div class="tile-heading">Total Users in <?php echo date('F'); ?></div>
                    <div class="tile-body"><i class="fa fa-user"></i><h2 class="pull-right"><?php echo $total_users_month; ?></h2></div>
                    <div class="tile-footer"><a href="<?php $common->pageUrl('users/index'); ?>">View more...</a></div>
                </div>
            </div>

    <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="tile">
                    <div class="tile-heading">Total Sales</div>
                    <div class="tile-body"><i class="fa fa-credit-card"></i><h2 class="pull-right"><?php  //echo $common->priceFormat($total_sales); ?></h2></div>
                    <div class="tile-footer"><a href="<?php  //$common->pageUrl('transactions/index'); ?>">View more...</a></div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="tile">
                    <div class="tile-heading">Total Sales in <?php // echo date('F'); ?></div>
                    <div class="tile-body"><i class="fa fa-credit-card"></i><h2 class="pull-right"><?php  //echo $common->priceFormat($total_sales_month); ?></h2></div>
                    <div class="tile-footer"><a href="<?php  //$common->pageUrl('transactions/index'); ?>">View more...</a></div>
                </div>
            </div>

        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-user"></i> Users</h3>
                    </div>
                    <div class="panel-body" style="overflow:auto">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th rowspan="1" colspan="1" style="display: none;">ID
                                        <input type="text" class="form-control input-sm col_filter" data-filer-index="0" /></th>
                                    <th style="display: none;" rowspan="1" colspan="1">Photo</th>
                                    <th rowspan="1" colspan="1">Name<br>
                                        <input type="text" class="form-control input-sm col_filter" data-filer-index="2" placeholder="Name" /></th>
                                    <th rowspan="1" colspan="1">Email<br>
                                        <input type="text" class="form-control input-sm col_filter" data-filer-index="3" placeholder="Email" /></th>
                                    <th rowspan="1" colspan="1">Date Added<br>
                                        <input type="text" class="form-control input-sm col_filter" data-filer-index="4" placeholder="Date Added" /></th>
                                    <th rowspan="1" colspan="1">
                                        Status<div class="spacer"></div>
                            <select class="form-control col_filter input-sm" data-filer-index="5">
                                <option value=""></option>
                                <option value="0">Disabled</option>
                                <option value="1">Enabled</option>
                            </select>
                            </th>
                            <th rowspan="1" colspan="1">Country<br>
                                <input type="text" class="form-control input-sm col_filter" data-filer-index="6" placeholder="Country" /></th>
                            <th rowspan="1" colspan="1" >Device
                            <div class="spacer"></div>
                            <select class="form-control col_filter input-sm" data-filer-index="7">
                                <option value=""></option>
                                <option value="1">iOS</option>
                                <option value="2">Android</option>
                            </select>
                            </th>
                            </tr>
                            </thead>
                        </table>
                        <table id="user-table" class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Date Added</th>
                                    <th>Status</th>
                                    <th>Country</th>
                                    <th>Device</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Date Added</th>
                                    <th>Status</th>
                                    <th>Country</th>
                                    <th>Device</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Users Analytics</h3>
                        </div>
                        <div class="panel-body" style="overflow:auto">
                            <div id="users_graph" style="height: 250px;width:100%;" ></div>
                        </div>
                    </div>
                    <?php //rsort($users); //var_dump($users); ?>

                </div><!-- col-md-2 -->
                <script type="text/javascript">
                    var tableDT;
                    var tableDT_url = "./library/dash_server_processing.php";
                    $(document).ready(function() {
                        $('.col_filter').on('keyup change', function() {
                            tableDT.column($(this).attr('data-filer-index')).search(this.value).draw();
                        });
                        ;
                        // DataTable
                        tableDT = $('#user-table').DataTable({
                            "processing": true,
                            "serverSide": true,
                            "order": [[0, "desc"]],
                            "columnDefs": [
                                {
                                    "targets": [0],
                                    "visible": false,
                                    "searchable": false
                                }
                            ],
                            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            "ajax": tableDT_url
                        });

                    });

                    $(function() {
                        var data = [<?php
                    foreach ($users as $user) {
                        echo '["' . $user['month'] . "<br>" . $user['year'] . '", ' . $user['total'] . "],";
                    }
                    ?>];
                        $.plot("#users_graph", [data], {
                            series: {
                                bars: {
                                    show: true,
                                    barWidth: 0.5,
                                    align: "center"
                                }
                            },
                            xaxis: {
                                mode: "categories",
                                tickLength: 0
                            }
                        });
                    });
                </script>
                <div class="col-md-6 col-sm-6">
                    <?php //rsort($sales); //var_dump($sales);  ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Sales Analytics</h3>
                        </div>
                        <div class="panel-body"  style="overflow:auto">
                            <div id="sales_graph" style="height: 250px;width:100%;"></div>
                        </div>
                    </div>
                    <?php //var_dump($users);  ?>

                </div><!-- col-md-2 -->
  <!--              <script type="text/javascript">

                    $(function() {

                        var data = [<?php
                   // foreach ($sales as $sale) {
                     // echo '["' . $sale['month'] . "<br>" . $sale['year'] . '", ' . $sale['total'] . "],";
                    //}
                    ?>];
                        $.plot("#sales_graph", [data], {
                            series: {
                                bars: {
                                    show: true,
                                    barWidth: 0.5,
                                    align: "center"
                                }
                            },
                            xaxis: {
                                mode: "categories",
                                tickLength: 0
                            }
                        });
                    });

                </script> -->
            </div><!-- col-md-2 -->
<!--                SELECT c.`name`, COUNT(c.`name`) as count
FROM country c
LEFT JOIN users u ON c.iso_code_2 = u.country or c.iso_code_3 = u.country GROUP BY c.`name` ORDER BY count DESC-->

<div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Leading Countries </h3>
                        </div>
                        <div class="panel-body" style="overflow:auto">
                            <div id="users_graph" style="height: 250px;width:100%;" ></div>
                        </div>
                    </div>
                    <?php //rsort($users); //var_dump($users); ?>

                </div><!-- col-md-2 -->
                <script type="text/javascript">
                          $(function() {
                        var data = [<?php
                    foreach ($leading_countries as $leading_countrie) {
                        echo '["' . $leading_countrie['month'] . "<br>" . $leading_countrie['year'] . '", ' . $leading_countrie['total'] . "],";
                    }
                    ?>];
                        $.plot("#leading_countrie", [data], {
                            series: {
                                bars: {
                                    show: true,
                                    barWidth: 0.5,
                                    align: "center"
                                }
                            },
                            xaxis: {
                                mode: "categories",
                                tickLength: 0
                            }
                        });
                    });
                </script>
</div>


        </div><!-- row -->
    </div><!-- container fluid-->

</div>

<?php require_once(HTTP_ROOT_ADMIN . 'common/footer.php'); ?>
