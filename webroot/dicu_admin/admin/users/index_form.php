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
        <a href="<?php $common->pageUrl('users/index')?>" data-toggle="tooltip" title="Cancel" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
            <li><a href="#tab-personal" data-toggle="tab">Personal</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active in" id="tab-general">
              <div class="tab-content">

								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-name">Profile Photo</label>
									<div class="col-sm-10"><a href="<?php echo (!empty($profile_img))?PROFILE_IMG.$profile_img:'javascript:void(0);'; ?>" target="_blank"><img style="max-width: 150px;max-height:150px;" src="<?php $img = (!empty($profile_img))?PROFILE_IMG.$profile_img:''; //echo $sys->thumbImage($img,150) ?> <?php echo $img; ?>" /></a></div>
								</div>
								
								<div class="form-group required">
									<label class="col-sm-2 control-label" for="input-name">Name</label>
									<div class="col-sm-10"><input type="text" name="name" value="<?php echo $name; ?>" placeholder="Name" id="input-name" class="form-control required" /></div>
								</div>
								
								<div class="form-group <?php echo (empty($id))?'required':''; ?>">
									<label class="col-sm-2 control-label" for="input-password">Password</label>
									<div class="col-sm-10"><input type="password" name="password" value="" placeholder="Password" id="input-password" class="form-control <?php echo (empty($id))?'required':''; ?>" /></div>
								</div>
								
								<div class="form-group <?php echo (empty($id))?'required':''; ?>">
									<label class="col-sm-2 control-label" for="input-confirm">Confirm Password</label>
									<div class="col-sm-10"><input type="password" name="confirm" value="" placeholder="Confirm" id="input-confirm" class="form-control <?php echo (empty($id))?'required':''; ?>" /></div>
								</div>
								
								<div class="form-group required">
									<label class="col-sm-2 control-label" for="input-email">Email</label>
									<div class="col-sm-10"><input type="text" name="email" value="<?php echo $email; ?>" placeholder="Email" id="input-email" class="form-control email required" /></div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-mobile_no">Mobile Number</label>
									<div class="col-sm-10"><input type="text" name="mobile_no" value="<?php echo $mobile_no; ?>" placeholder="Mobile Number" id="input-mobile_no" class="form-control" /></div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-lat">Latitude</label>
									<div class="col-sm-10"><input type="text" name="lat" value="<?php echo $lat; ?>" placeholder="Latitude" id="input-lat" class="form-control" /></div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-lng">Longitude</label>
									<div class="col-sm-10"><input type="text" name="lng" value="<?php echo $lng; ?>" placeholder="Latitude" id="input-lng" class="form-control" /></div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-tagline">Tag line</label>
									<div class="col-sm-10"><input type="text" name="tagline" value="<?php echo $tagline; ?>" placeholder="Tag Line" id="input-tagline" class="form-control" /></div>
								</div>
								
								<div class="form-group required">
									<label class="col-sm-2 control-label" for="input-device_id">Device</label>
									<div class="col-sm-10">
										<select class="form-control required" id="input-device_id" name="device_id">
										<option value="1" <?php echo ($device_id == 1)?'selected="selected"':''; ?>>iOS</option>
										<option value="2" <?php echo ($device_id == 2)?'selected="selected"':''; ?>>Android</option>
										</select>
									</div>
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
								
								<?php if($sys->notEmpty($latest_activity)){ ?>
								<div class="form-group">
									<label class="col-sm-2 control-label">Latest Activity</label>
									<div class="col-sm-10"><label class="control-label"><?php echo $common->dateLongFormat($latest_activity)?></label></div>
								</div>
								<?php } ?>
								
								<?php if($sys->notEmpty($modified)){ ?>
								<div class="form-group">
									<label class="col-sm-2 control-label">Modified Date</label>
									<div class="col-sm-10"><label class="control-label"><?php echo $common->dateLongFormat($modified)?></label></div>
								</div>
								<?php } ?>
								
								<?php if($sys->notEmpty($created)){ ?>
								<div class="form-group">
									<label class="col-sm-2 control-label">Created Date</label>
									<div class="col-sm-10"><label class="control-label"><?php echo $common->dateLongFormat($created)?></label></div>
								</div>
								<?php } ?>

              </div>
            </div>
						
						<div class="tab-pane" id="tab-personal">
              <div class="tab-content">
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-relationship">Relationship</label>
									<div class="col-sm-10"><input type="text" name="relationship" value="<?php echo $relationship; ?>" placeholder="Relationship" id="input-relationship" class="form-control" /></div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-dob">DOB</label>
									<div class="col-sm-10"><input type="text" name="dob" value="<?php echo $dob; ?>" placeholder="DOB" id="input-dob" class="form-control date" /></div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-height_ft">Height(ft)</label>
									<div class="col-sm-10"><input type="text" name="height_ft" value="<?php echo $height_ft; ?>" placeholder="Height(ft)" id="input-height_ft" class="form-control" /></div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-height_inch">Height(inch)</label>
									<div class="col-sm-10"><input type="text" name="height_inch" value="<?php echo $height_inch; ?>" placeholder="Height(inch)" id="input-height_inch" class="form-control" /></div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-gender">Gender</label>
									<div class="col-sm-10">
										<select class="form-control" id="input-gender" name="gender">
										<option value=""></option>
										<option value="female" <?php echo ($gender == 'female')?'selected="selected"':''; ?>>Female</option>
										<option value="male" <?php echo ($gender == 'male')?'selected="selected"':''; ?>>Male</option>
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-hair_color">Hair Color</label>
									<div class="col-sm-10"><input type="text" name="hair_color" value="<?php echo $hair_color; ?>" placeholder="Hair Color" id="input-hair_color" class="form-control" /></div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-about_me">About Me</label>
									<div class="col-sm-10"><input type="text" name="about_me" value="<?php echo $about_me; ?>" placeholder="About Me" id="input-about_me" class="form-control" /></div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-lives_in">Lives In</label>
									<div class="col-sm-10"><input type="text" name="lives_in" value="<?php echo $lives_in; ?>" placeholder="Lives In" id="input-lives_in" class="form-control" /></div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-looking_for">Looking For</label>
									<div class="col-sm-10"><input type="text" name="looking_for" value="<?php echo $looking_for; ?>" placeholder="Looking For" id="input-looking_for" class="form-control" /></div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-ethnicity">Ethnicity</label>
									<div class="col-sm-10"><input type="text" name="ethnicity" value="<?php echo $ethnicity; ?>" placeholder="Ethnicity" id="input-ethnicity" class="form-control" /></div>
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
<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false,
	format: 'YYYY-MM-DD'
});
//--></script>
<?php require_once(HTTP_ROOT_ADMIN.'common/footer.php'); ?>
