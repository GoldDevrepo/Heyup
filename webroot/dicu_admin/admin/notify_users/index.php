<?php require_once('../system/startup.php'); ?>
<?php require_once('library/index_lib.php'); ?>
<?php require_once(HTTP_ROOT_ADMIN . 'common/header_start.php'); ?>
<?php require_once(HTTP_ROOT_ADMIN . 'common/header_end.php'); ?>
<?php require_once(HTTP_ROOT_ADMIN . 'common/header_start.php'); ?>

<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">

                <button type="button" data-toggle="tooltip" title="Send Push" class="btn btn-info" onclick="confirm('Are you sure?') ? $('#form-users').submit() : false;"><i class="fa fa-send"></i></button>
            </div>
            <h1><?php echo $page['title']; ?></h1>
            <?php echo $breadcrumb; ?>
        </div>
    </div>
    <div class="container-fluid">
        <?php echo $common->displayAlert(); ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $page['title']; ?></h3>
            </div>
            <div class="panel-body">
                <div class="well">
                    <div class="row">

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label" for="input-name">Name</label>
                                <input id="input-name" class="form-control" type="text" placeholder="Name" value="<?php echo $filter_name; ?>" name="filter_name">
                            </div>
                            <div class="form-group">
                                <label for="input-device_name" class="control-label">Device</label>
                                <select class="form-control" id="input-device_name" name="filter_device_name">
                                    <option value="*"></option>
                                    <option value="1" <?php echo ($filter_device_name === '1') ? 'selected="selected"' : ''; ?>>iOS</option>
                                    <option value="2" <?php echo ($filter_device_name === '2') ? 'selected="selected"' : ''; ?>>Android</option>
                                </select>
                            </div>

                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label" for="input-email">Email</label>
                                <input id="input-email" class="form-control" type="text" placeholder="Email" value="<?php echo $filter_email; ?>" name="filter_email">
                            </div>
                            <div class="form-group">
                                <label for="input-status" class="control-label">Status</label>
                                <select class="form-control" id="input-status" name="filter_status">
                                    <option value="*"></option>
                                    <option value="1" <?php echo ($filter_status === '1') ? 'selected="selected"' : ''; ?>>Enabled</option>
                                    <option value="0" <?php echo ($filter_status === '0') ? 'selected="selected"' : ''; ?>>Disabled</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-3">		
                            <div class="form-group">
                                <label class="control-label" for="input-mobile_no">Mobile Number</label>
                                <input id="input-mobile_no" class="form-control" type="text" placeholder="Mobile Number" value="<?php echo $filter_mobile_no; ?>" name="filter_mobile_no">
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label" for="input-created">Date Added</label>
                                <div class="input-group date"><input type="text" name="filter_created" value="<?php echo $filter_created; ?>" placeholder="Date Added" data-date-format="YYYY-MM-DD" id="input-date-added" class="form-control" />
                                    <span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div>
                            </div>



                            <button class="btn btn-primary pull-right" id="button-filter" type="button"><i class="fa fa-search"></i> Filter</button>
                        </div>

                    </div>
                </div>

                <form action="http://109.69.238.222/users/test" method="post" enctype="multipart/form-data" id="form-users" target="_blank">
                    <div class="row">
                        <div class="col-sm-6">
                            Push message:
                            <textarea placeholder="Push Message" name="push_message" class="form-control" value="Thank you for downloading the Did I See U dating app. We do our best to ensure uses are genuine, which is why we ask all of our users to upload a clear profile picture of themselves. This is to ensure other users know who they are communicating with, or should they have a Close Encounter alert, they know who to look for." ></textarea>

                        </div>
                        <div class="col-sm-6">
                            E-mail message:
                            <textarea placeholder="Push Message" name="push_message_email" class="form-control" value="Thank you for downloading the Did I See U dating app. We do our best to ensure uses are genuine, which is why we ask all of our users to upload a clear profile picture of themselves. This is to ensure other users know who they are communicating with, or should they have a Close Encounter alert, they know who to look for." ></textarea>
                            <code>Note: Please use %user% to add user's name in your email message.<br/></code>
                            <span class="text-success">Formal DidISeeU Signature with image will be added at the end of the message. So please do not add Signature.</span>

                        </div>
                    </div>
                    <br />
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                                    <td class="text-left">Photo</td>
                                    <td class="text-left"><a <?php
                                        if (isset($request->get['sort'])) {
                                            if ($request->get['sort'] == 'name') {
                                                echo $order_class;
                                            }
                                        }
                                        ?> href="<?php $common->pageUrl('notify_users/index'); ?>?sort=name<?php echo $order_by . $page_no . $filter_string; ?>">Name</a></td>
                                    <td class="text-left"><a <?php
                                        if (isset($request->get['sort'])) {
                                            if ($request->get['sort'] == 'email') {
                                                echo $order_class;
                                            }
                                        }
                                        ?> href="<?php $common->pageUrl('notify_users/index'); ?>?sort=email<?php echo $order_by . $page_no . $filter_string; ?>">Email</a></td>
                                    <td class="text-right"><a <?php
                                        if (isset($request->get['sort'])) {
                                            if ($request->get['sort'] == 'mobile_no') {
                                                echo $order_class;
                                            }
                                        }
                                        ?> href="<?php $common->pageUrl('notify_users/index'); ?>?sort=mobile_no<?php echo $order_by . $page_no . $filter_string; ?>">Mobile Number</a></td>
                                    <td class="text-right"><a <?php
                                        if (isset($request->get['sort'])) {
                                            if ($request->get['sort'] == 'created') {
                                                echo $order_class;
                                            }
                                        }
                                        ?> href="<?php $common->pageUrl('notify_users/index'); ?>?sort=created<?php echo $order_by . $page_no . $filter_string; ?>">Date Added</a></td>
                                    <td class="text-left"><a <?php
                                        if (isset($request->get['sort'])) {
                                            if ($request->get['sort'] == 'status') {
                                                echo $order_class;
                                            }
                                        }
                                        ?> href="<?php $common->pageUrl('notify_users/index'); ?>?sort=status<?php echo $order_by . $page_no . $filter_string; ?>">Status</a></td>
                                    <td class="text-left"><a <?php
                                        if (isset($request->get['sort'])) {
                                            if ($request->get['sort'] == 'country') {
                                                echo $order_class;
                                            }
                                        }
                                        ?> href="<?php $common->pageUrl('notify_users/index'); ?>?sort=country<?php echo $order_by . $page_no . $filter_string; ?>">Country</a></td>
                                    <td class="text-left"><a <?php
                                        if (isset($request->get['sort'])) {
                                            if ($request->get['sort'] == 'device_name') {
                                                echo $order_class;
                                            }
                                        }
                                        ?> href="<?php $common->pageUrl('notify_users/index'); ?>?sort=device_name<?php echo $order_by . $page_no . $filter_string; ?>">Device</a></td>
                                    <td class="text-right">Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (sizeof($results)) {
                                    foreach ($results as $result) {
                                        ?>
                                        <tr>
                                            <td class="text-center"><input type="checkbox" name="selected[]" value="<?php echo $result['id']; ?>" /></td>
                                            <td class="text-left"><img src="<?php
                                                $img = (!empty($result['profile_img'])) ? PROFILE_IMG . $result['profile_img'] : '';
                                                echo $sys->thumbImage($img,75);  
                                                ?>" /></td>
                                            <td class="text-left"><?php echo $result['name']; ?></td>
                                            <td class="text-left"><?php echo $result['email']; ?></td>
                                            <td class="text-right"><?php echo $result['mobile_no']; ?></td>
                                            <td class="text-right"><?php echo $common->dateLongFormat($result['created']); ?></td>
                                            <td class="text-left"><?php echo ($result['status'] == 1) ? 'Enabled' : 'Disabled'; ?></td>
                                            <td class="text-left"><?php echo $result['country']; ?></td>
                                            <td class="text-left"><?php echo $result['device_name']; ?></td>
                                            <td class="text-right"><a href="<?php $common->pageUrl('users/index_form'); ?>?id=<?php echo $result['id']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr><td colspan="8" class="text-center">No results!</td></tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </form>
                <div class="row">

                    <?php echo pagination($statement, $limit, $page, $common->pageUrl('notify_users/index', true) . '?' . $order_paging . $sort_by . $filter_string . '&'); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
        url = '<?php echo $common->pageUrl('notify_users/index', true) . '?' . $order_paging . $sort_by; ?>';

        var filter_name = $('input[name=\'filter_name\']').val();
        if (filter_name) {
            url += '&filter_name=' + encodeURIComponent(filter_name);
        }

        var filter_email = $('input[name=\'filter_email\']').val();
        if (filter_email) {
            url += '&filter_email=' + encodeURIComponent(filter_email);
        }

        var filter_mobile_no = $('input[name=\'filter_mobile_no\']').val();
        if (filter_mobile_no) {
            url += '&filter_mobile_no=' + encodeURIComponent(filter_mobile_no);
        }

        var filter_created = $('input[name=\'filter_created\']').val();
        if (filter_created) {
            url += '&filter_created=' + encodeURIComponent(filter_created);
        }

        var filter_status = $('select[name=\'filter_status\']').val();
        if (filter_status != '*') {
            url += '&filter_status=' + encodeURIComponent(filter_status);
        }

        var filter_device_name = $('select[name=\'filter_device_name\']').val();
        if (filter_device_name != '*') {
            url += '&filter_device_name=' + encodeURIComponent(filter_device_name);
        }

        location = url;
    });
//--></script> 
<script type="text/javascript"><!--
    $('.date').datetimepicker({
        pickTime: false
    });
//--></script>
<?php require_once(HTTP_ROOT_ADMIN . 'common/footer.php'); ?>
<?php require_once(HTTP_ROOT_ADMIN . 'common/footer.php'); ?>
