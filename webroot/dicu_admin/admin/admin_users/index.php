<?php require_once('../system/startup.php'); ?>
<?php require_once('library/index_lib.php'); ?>
<?php require_once(HTTP_ROOT_ADMIN.'common/header_start.php'); ?>
<?php require_once(HTTP_ROOT_ADMIN.'common/header_end.php'); ?>
<?php require_once(HTTP_ROOT_ADMIN.'common/header_start.php'); ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $common->pageUrl('admin_users/index_form')?>" data-toggle="tooltip" title="Add New" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="Delete" class="btn btn-danger" onclick="confirm('Are you sure?') ? $('#form-users').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
							<label class="control-label" for="input-username">Username</label>
							<input id="input-username" class="form-control" type="text" placeholder="Username" value="<?php echo $filter_username; ?>" name="filter_username">
						</div>
						<div class="form-group">
							<label class="control-label" for="input-phone">Phone</label>
							<input id="input-phone" class="form-control" type="text" placeholder="Phone" value="<?php echo $filter_phone; ?>" name="filter_phone">
						</div>
					</div>
					
					<div class="col-sm-3">
						<div class="form-group">
							<label class="control-label" for="input-first_name">First Name</label>
							<input id="input-first_name" class="form-control" type="text" placeholder="First Name" value="<?php echo $filter_first_name; ?>" name="filter_first_name">
						</div>
						<div class="form-group">
							<label class="control-label" for="input-date_added">Date Added</label>
							<div class="input-group date"><input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" placeholder="Date Added" data-date-format="YYYY-MM-DD" id="input-date-added" class="form-control" />
							<span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div>
							
						</div>
					</div>
					
					<div class="col-sm-3">
						<div class="form-group">
							<label class="control-label" for="input-last_name">Last Name</label>
							<input id="input-last_name" class="form-control" type="text" placeholder="Last Name" value="<?php echo $filter_last_name; ?>" name="filter_last_name">
						</div>
						
						<div class="form-group">
              <label for="input-status" class="control-label">Status</label>
              <select class="form-control" id="input-status" name="filter_status">
								<option value="*"></option>
                <option value="1" <?php echo ($filter_status === '1')?'selected="selected"':'';?>>Enabled</option>
                <option value="0" <?php echo ($filter_status === '0')?'selected="selected"':'';?>>Disabled</option>
               </select>
            </div>
					</div>
					
					<div class="col-sm-3">
						<div class="form-group">
							<label class="control-label" for="input-email">Email</label>
							<input id="input-email" class="form-control" type="text" placeholder="Email" value="<?php echo $filter_email; ?>" name="filter_email">
						</div>
						<button class="btn btn-primary pull-right" id="button-filter" type="button"><i class="fa fa-search"></i> Filter</button>
					</div>
					
				</div>
			</div>
			
        <form action="" method="post" enctype="multipart/form-data" id="form-users">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><a <?php if(isset($request->get['sort'])){ if($request->get['sort']=='username'){ echo $order_class; } } ?> href="<?php $common->pageUrl('admin_users/index');?>?sort=username<?php echo $order_by.$page_no.$filter_string; ?>">Username</a></td>
                  <td class="text-left"><a <?php if(isset($request->get['sort'])){ if($request->get['sort']=='first_name'){ echo $order_class; } } ?> href="<?php $common->pageUrl('admin_users/index');?>?sort=first_name<?php echo $order_by.$page_no.$filter_string; ?>">First Name</a></td>
                  <td class="text-left"><a <?php if(isset($request->get['sort'])){ if($request->get['sort']=='last_name'){ echo $order_class; } } ?> href="<?php $common->pageUrl('admin_users/index');?>?sort=last_name<?php echo $order_by.$page_no.$filter_string; ?>">Last Name</a></td>
                  <td class="text-left"><a <?php if(isset($request->get['sort'])){ if($request->get['sort']=='email'){ echo $order_class; } } ?> href="<?php $common->pageUrl('admin_users/index');?>?sort=email<?php echo $order_by.$page_no.$filter_string; ?>">Email</a></td>
                  <td class="text-right"><a <?php if(isset($request->get['sort'])){ if($request->get['sort']=='phone'){ echo $order_class; } } ?> href="<?php $common->pageUrl('admin_users/index');?>?sort=phone<?php echo $order_by.$page_no.$filter_string; ?>">Phone</a></td>
                  <td class="text-right"><a <?php if(isset($request->get['sort'])){ if($request->get['sort']=='date_added'){ echo $order_class; } } ?> href="<?php $common->pageUrl('admin_users/index');?>?sort=date_added<?php echo $order_by.$page_no.$filter_string; ?>">Date Added</a></td>
                  <td class="text-left"><a <?php if(isset($request->get['sort'])){ if($request->get['sort']=='status'){ echo $order_class; } } ?> href="<?php $common->pageUrl('admin_users/index');?>?sort=status<?php echo $order_by.$page_no.$filter_string; ?>">Status</a></td>
                  <td class="text-right">Action</td>
                </tr>
              </thead>
              <tbody>
								<?php if(sizeof($results)){ foreach($results as $result){ ?>
								<tr>
                  <td class="text-center"><input type="checkbox" name="selected[]" value="<?php echo $result['admin_id']; ?>" /></td>
                  <td class="text-left"><?php echo $result['username']; ?></td>
                  <td class="text-left"><?php echo $result['first_name']; ?></td>
                  <td class="text-left"><?php echo $result['last_name']; ?></td>
                  <td class="text-left"><?php echo $result['email']; ?></td>
                  <td class="text-right"><?php echo $result['phone']; ?></td>
                  <td class="text-right"><?php echo $common->dateLongFormat($result['date_added']); ?></td>
                  <td class="text-left"><?php echo ($result['status']==1)?'Enabled':'Disabled'; ?></td>
                  <td class="text-right"><a href="<?php $common->pageUrl('admin_users/index_form');?>?admin_id=<?php echo $result['admin_id']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                </tr>
								<?php } } else { ?>
								<tr><td colspan="8" class="text-center">No results!</td></tr>
								<?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="row">
          
					<?php	echo pagination($statement,$limit,$page,$common->pageUrl('admin_users/index',true).'?'.$order_paging.$sort_by.$filter_string.'&'); ?>
					
          
        </div>
      </div>
    </div>
  </div>
</div>
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	url = '<?php echo $common->pageUrl('admin_users/index',true).'?'.$order_paging.$sort_by; ?>';
	
	var filter_username = $('input[name=\'filter_username\']').val();
	if (filter_username) {
		url += '&filter_username=' + encodeURIComponent(filter_username);
	}
	
	var filter_first_name = $('input[name=\'filter_first_name\']').val();
	if (filter_first_name) {
		url += '&filter_first_name=' + encodeURIComponent(filter_first_name);
	}
	
	var filter_last_name = $('input[name=\'filter_last_name\']').val();
	if (filter_last_name) {
		url += '&filter_last_name=' + encodeURIComponent(filter_last_name);
	}
	
	var filter_email = $('input[name=\'filter_email\']').val();
	if (filter_email) {
		url += '&filter_email=' + encodeURIComponent(filter_email);
	}
	
	var filter_phone = $('input[name=\'filter_phone\']').val();
	if (filter_phone) {
		url += '&filter_phone=' + encodeURIComponent(filter_phone);
	}
	
	var filter_date_added = $('input[name=\'filter_date_added\']').val();
	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	}
	
	var filter_status = $('select[name=\'filter_status\']').val();
	if (filter_status!='*') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}
	
	location = url;
});
//--></script> 
<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script>
<?php require_once(HTTP_ROOT_ADMIN.'common/footer.php'); ?>
<?php require_once(HTTP_ROOT_ADMIN.'common/footer.php'); ?>