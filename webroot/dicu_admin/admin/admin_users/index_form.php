<?php require_once('../system/startup.php'); ?>
<?php require_once('library/index_form_lib.php'); ?>
<?php require_once(HTTP_ROOT_ADMIN.'common/header_start.php'); ?>
<?php require_once(HTTP_ROOT_ADMIN.'common/header_end.php'); ?>
<?php require_once(HTTP_ROOT_ADMIN.'common/header_start.php'); ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-user" data-toggle="tooltip" title="Save" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php $common->pageUrl('admin_users/index')?>" data-toggle="tooltip" title="Cancel" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $page['title']; ?></h1>
			<?php echo $breadcrumb; ?>
    </div>
  </div>
  <div class="container-fluid">
			<?php echo $common->displayAlert(); ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $page['title']; ?> Form</h3>
      </div>
      <div class="panel-body">
        <form action="" method="post" enctype="multipart/form-data" id="form-user" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active in" id="tab-general">
              <div class="tab-content">

								<div class="form-group required">
									<label class="col-sm-2 control-label" for="input-username">Username</label>
									<div class="col-sm-10"><input type="text" name="username" value="<?php echo $username; ?>" placeholder="Username" id="input-username" class="form-control required" /></div>
								</div>
								
								<div class="form-group <?php echo (empty($admin_id))?'required':''; ?>">
									<label class="col-sm-2 control-label" for="input-password">Password</label>
									<div class="col-sm-10"><input type="password" name="password" value="" placeholder="Password" id="input-password" class="form-control <?php echo (empty($admin_id))?'required':''; ?>" /></div>
								</div>
								
								<div class="form-group <?php echo (empty($admin_id))?'required':''; ?>">
									<label class="col-sm-2 control-label" for="input-confirm">Confirm Password</label>
									<div class="col-sm-10"><input type="password" name="confirm" value="" placeholder="Confirm" id="input-confirm" class="form-control <?php echo (empty($admin_id))?'required':''; ?>" /></div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-first_name">First name</label>
									<div class="col-sm-10"><input type="text" name="first_name" value="<?php echo $first_name; ?>" placeholder="First Name" id="input-first_name" class="form-control" /></div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-last_name">Last name</label>
									<div class="col-sm-10"><input type="text" name="last_name" value="<?php echo $last_name; ?>" placeholder="Last Name" id="input-last_name" class="form-control" /></div>
								</div>
								
								<div class="form-group required">
									<label class="col-sm-2 control-label" for="input-email">Email</label>
									<div class="col-sm-10"><input type="text" name="email" value="<?php echo $email; ?>" placeholder="Email" id="input-email" class="form-control email required" /></div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-phone">Phone</label>
									<div class="col-sm-10"><input type="text" name="phone" value="<?php echo $phone; ?>" placeholder="Phone" id="input-phone" class="form-control" /></div>
								</div>
								
								<div class="form-group required">
									<label class="col-sm-2 control-label" for="input-status">Status</label>
									<div class="col-sm-10">
										<select class="form-control required" id="input-status" name="status">
										<option value="1" <?php echo ($status == 1)?'selected="selected"':''; ?>>Enabled</option>
										<option value="0" <?php echo ($status == 0)?'selected="selected"':''; ?>>Disabled</option>
										</select>
									</div>
								</div>

              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<script type="text/javascript"><!--
$('#form-user').validate({
rules: {
	password:{
		minlength: 5
	},
	confirm:{
		minlength: 5,
		equalTo: 'input[name="password"]'
	}
}
});
//-->
</script>
<?php require_once(HTTP_ROOT_ADMIN.'common/footer.php'); ?>