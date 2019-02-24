<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
<meta charset="UTF-8" />
<title>Administration</title>
<base href="http://local.urocko.com/admin/" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
<script type="text/javascript" src="javascript/jquery/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="javascript/bootstrap/js/bootstrap.min.js"></script>
<link href="javascript/bootstrap/opencart/opencart.css" type="text/css" rel="stylesheet" />
<link href="javascript/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
<link href="javascript/summernote/summernote.css" rel="stylesheet" />
<script type="text/javascript" src="javascript/summernote/summernote.js"></script>
<script src="javascript/jquery/datetimepicker/moment.js" type="text/javascript"></script>
<script src="javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<link href="javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />
<link type="text/css" href="stylesheet/stylesheet.css" rel="stylesheet" media="screen" />
<script src="javascript/common.js" type="text/javascript"></script>
</head>
<body>
<div id="container">
<header id="header" class="navbar navbar-static-top">
  <div class="navbar-header">
        <a href="http://local.urocko.com/admin/index.php?route=common/dashboard" class="navbar-brand"><img src="image/logo.png" alt="uRocko" title="uRocko" /></a></div>
  </header>
<div id="content">
  <div class="container-fluid"><br />
    <br />
    <div class="row">
      <div class="col-sm-offset-4 col-sm-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h1 class="panel-title"><i class="fa fa-lock"></i> Please enter your login details.</h1>
          </div>
          <div class="panel-body">
					<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> No match for Username and/or Password.<button type="button" class="close" data-dismiss="alert">&times;</button></div>
             <form action="" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label for="input-username">Username</label>
                <div class="input-group"><span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="text" name="username" value="" placeholder="Username" id="input-username" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label for="input-password">Password</label>
                <div class="input-group"><span class="input-group-addon"><i class="fa fa-lock"></i></span>
                  <input type="password" name="password" value="" placeholder="Password" id="input-password" class="form-control" />
                </div>
                              </div>
              <div class="text-right">
                <button type="submit" class="btn btn-primary"><i class="fa fa-key"></i> Login</button>
              </div>
                            <input type="hidden" name="redirect" value="http://local.urocko.com/admin/index.php?route=common/login" />
              </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<footer id="footer"><a href="http://www.opencart.com">uRocko</a> &copy; 2009-2015 All Rights Reserved.<br /></footer></div>
</body></html>