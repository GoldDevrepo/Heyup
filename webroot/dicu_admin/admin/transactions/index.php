<?php require_once('../system/startup.php'); ?>
<?php require_once('library/index_lib.php'); ?>
<?php require_once(HTTP_ROOT_ADMIN.'common/header_start.php'); ?>
<?php require_once(HTTP_ROOT_ADMIN.'common/header_end.php'); ?>
<?php require_once(HTTP_ROOT_ADMIN.'common/header_start.php'); ?>
<?php die();?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
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
							<label class="control-label" for="input-amount">Amount</label>
							<input id="input-amount" class="form-control" type="text" placeholder="Amount" value="<?php echo $filter_amount; ?>" name="filter_amount">
						</div>
					</div>
					
					<div class="col-sm-3">
						<div class="form-group">
							<label class="control-label" for="input-itunes_product">iTunes Product</label>
							<input id="input-itunes_product" class="form-control" type="text" placeholder="iTunes Product" value="<?php echo $filter_itunes_product; ?>" name="filter_itunes_product">
						</div>
						<div class="form-group">
							<label class="control-label" for="input-created">Date Added</label>
							<div class="input-group date"><input type="text" name="filter_created" value="<?php echo $filter_created; ?>" placeholder="Date Added" data-date-format="YYYY-MM-DD" id="input-date-added" class="form-control" />
							<span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div>
							
						</div>
					</div>
					
					<div class="col-sm-3">
						<div class="form-group">
							<label class="control-label" for="input-description">Description</label>
							<input id="input-description" class="form-control" type="text" placeholder="Description" value="<?php echo $filter_description; ?>" name="filter_description">
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
			
        <form action="" method="post" enctype="multipart/form-data" id="form-transactions">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><a <?php if(isset($request->get['sort'])){ if($request->get['sort']=='name'){ echo $order_class; } } ?> href="<?php $common->pageUrl('transactions/index');?>?sort=name<?php echo $order_by.$page_no.$filter_string; ?>">Name</a></td>
									<td class="text-left"><a <?php if(isset($request->get['sort'])){ if($request->get['sort']=='email'){ echo $order_class; } } ?> href="<?php $common->pageUrl('transactions/index');?>?sort=email<?php echo $order_by.$page_no.$filter_string; ?>">Email</a></td>
                  <td class="text-left"><a <?php if(isset($request->get['sort'])){ if($request->get['sort']=='itunes_product'){ echo $order_class; } } ?> href="<?php $common->pageUrl('transactions/index');?>?sort=itunes_product<?php echo $order_by.$page_no.$filter_string; ?>">iTunes Product</a></td>
                  <td class="text-left"><a <?php if(isset($request->get['sort'])){ if($request->get['sort']=='description'){ echo $order_class; } } ?> href="<?php $common->pageUrl('transactions/index');?>?sort=description<?php echo $order_by.$page_no.$filter_string; ?>">Description</a></td>
                  <td class="text-right"><a <?php if(isset($request->get['sort'])){ if($request->get['sort']=='amount'){ echo $order_class; } } ?> href="<?php $common->pageUrl('transactions/index');?>?sort=amount<?php echo $order_by.$page_no.$filter_string; ?>">Amount</a></td>
                  <td class="text-right"><a <?php if(isset($request->get['sort'])){ if($request->get['sort']=='created'){ echo $order_class; } } ?> href="<?php $common->pageUrl('transactions/index');?>?sort=created<?php echo $order_by.$page_no.$filter_string; ?>">Date Added</a></td>
                </tr>
              </thead>
              <tbody>
								<?php if(sizeof($results)){ foreach($results as $result){ ?>
								<tr>
                  <td class="text-center"><input type="checkbox" name="selected[]" value="<?php echo $result['id']; ?>" /></td>
                  <td class="text-left"><?php echo $result['name']; ?></td>
									<td class="text-left"><?php echo $result['email']; ?></td>
                  <td class="text-left"><?php echo $result['itunes_product']; ?></td>
                  <td class="text-left"><?php echo $result['description']; ?></td>
                  <td class="text-right"><?php echo $result['amount']; ?></td>
                  <td class="text-right"><?php echo $common->dateLongFormat($result['created']); ?></td>
                </tr>
								<?php } } else { ?>
								<tr><td colspan="8" class="text-center">No results!</td></tr>
								<?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="row">
          
					<?php	echo pagination($statement,$limit,$page,$common->pageUrl('transactions/index',true).'?'.$order_paging.$sort_by.$filter_string.'&'); ?>
					
          
        </div>
      </div>
    </div>
  </div>
</div>
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	url = '<?php echo $common->pageUrl('transactions/index',true).'?'.$order_paging.$sort_by; ?>';
	
	var filter_name = $('input[name=\'filter_name\']').val();
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
	
	var filter_itunes_product = $('input[name=\'filter_itunes_product\']').val();
	if (filter_itunes_product) {
		url += '&filter_itunes_product=' + encodeURIComponent(filter_itunes_product);
	}
	
	var filter_description = $('input[name=\'filter_description\']').val();
	if (filter_description) {
		url += '&filter_description=' + encodeURIComponent(filter_description);
	}
	
	var filter_email = $('input[name=\'filter_email\']').val();
	if (filter_email) {
		url += '&filter_email=' + encodeURIComponent(filter_email);
	}
	
	var filter_amount = $('input[name=\'filter_amount\']').val();
	if (filter_amount) {
		url += '&filter_amount=' + encodeURIComponent(filter_amount);
	}
	
	var filter_created = $('input[name=\'filter_created\']').val();
	if (filter_created) {
		url += '&filter_created=' + encodeURIComponent(filter_created);
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