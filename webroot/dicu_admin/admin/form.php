<?php require_once('system/startup.php'); ?>
<?php require_once('library/listing_lib.php'); ?>
<?php require_once(HTTP_ROOT_ADMIN.'common/header_start.php'); ?>
<?php require_once(HTTP_ROOT_ADMIN.'common/header_end.php'); ?>
<?php require_once(HTTP_ROOT_ADMIN.'common/header_start.php'); ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-category" data-toggle="tooltip" title="Save" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="http://local.urocko.com/admin/index.php?route=catalog/category&amp;token=ec7d18a3fa699d5a01a8f7cc4c43efb7" data-toggle="tooltip" title="Cancel" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $page['title']; ?></h1>
			<?php echo $breadcrumb; ?>
    </div>
  </div>
  <div class="container-fluid">
			<?php echo $common->displayAlert(); ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> Add Category</h3>
      </div>
      <div class="panel-body">
        <form action="http://local.urocko.com/admin/index.php?route=catalog/category/add&amp;token=ec7d18a3fa699d5a01a8f7cc4c43efb7" method="post" enctype="multipart/form-data" id="form-category" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
            <li><a href="#tab-data" data-toggle="tab">Data</a></li>
            <li><a href="#tab-design" data-toggle="tab">Design</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active in" id="tab-general">
              <ul class="nav nav-tabs" id="language">
                                <li><a href="#language1" data-toggle="tab"><img src="image/flags/gb.png" title="English" /> English</a></li>
                              </ul>
              <div class="tab-content">
                                <div class="tab-pane" id="language1">
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-name1">Category Name</label>
                    <div class="col-sm-10">
                      <input type="text" name="category_description[1][name]" value="" placeholder="Category Name" id="input-name1" class="form-control" />
                                          </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-description1">Description</label>
                    <div class="col-sm-10">
                      <textarea name="category_description[1][description]" placeholder="Description" id="input-description1" class="form-control"></textarea>
                    </div>
                  </div>
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-meta-title1">Meta Tag Title</label>
                    <div class="col-sm-10">
                      <input type="text" name="category_description[1][meta_title]" value="" placeholder="Meta Tag Title" id="input-meta-title1" class="form-control" />
                                          </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-description1">Meta Tag Description</label>
                    <div class="col-sm-10">
                      <textarea name="category_description[1][meta_description]" rows="5" placeholder="Meta Tag Description" id="input-meta-description1" class="form-control"></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-keyword1">Meta Tag Keywords</label>
                    <div class="col-sm-10">
                      <textarea name="category_description[1][meta_keyword]" rows="5" placeholder="Meta Tag Keywords" id="input-meta-keyword1" class="form-control"></textarea>
                    </div>
                  </div>
                </div>
                              </div>
            </div>
            <div class="tab-pane fade" id="tab-data">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-parent">Parent</label>
                <div class="col-sm-10">
                  <input type="text" name="path" value="" placeholder="Parent" id="input-parent" class="form-control" />
                  <input type="hidden" name="parent_id" value="0" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-filter"><span data-toggle="tooltip" title="(Autocomplete)">Filters</span></label>
                <div class="col-sm-10">
                  <input type="text" name="filter" value="" placeholder="Filters" id="input-filter" class="form-control" />
                  <div id="category-filter" class="well well-sm" style="height: 150px; overflow: auto;">
                                      </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Stores</label>
                <div class="col-sm-10">
                  <div class="well well-sm" style="height: 150px; overflow: auto;">
                    <div class="checkbox">
                      <label>
                                                <input type="checkbox" name="category_store[]" value="0" checked="checked" />
                        Default                                              </label>
                    </div>
                                      </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-keyword"><span data-toggle="tooltip" title="Do not use spaces, instead replace spaces with - and make sure the keyword is globally unique.">SEO Keyword</span></label>
                <div class="col-sm-10">
                  <input type="text" name="keyword" value="" placeholder="SEO Keyword" id="input-keyword" class="form-control" />
                                  
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Image</label>
                <div class="col-sm-10"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="http://local.urocko.com/image/cache/no_image-100x100.png" alt="" title="" data-placeholder="http://local.urocko.com/image/cache/no_image-100x100.png" /></a>
                  <input type="hidden" name="image" value="" id="input-image" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-top"><span data-toggle="tooltip" title="Display in the top menu bar. Only works for the top parent categories.">Top</span></label>
                <div class="col-sm-10">
                  <div class="checkbox">
                    <label>
                                            <input type="checkbox" name="top" value="1" id="input-top" />
                                            &nbsp; </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-column"><span data-toggle="tooltip" title="Number of columns to use for the bottom 3 categories. Only works for the top parent categories.">Columns</span></label>
                <div class="col-sm-10">
                  <input type="text" name="column" value="1" placeholder="Columns" id="input-column" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-sort-order">Sort Order</label>
                <div class="col-sm-10">
                  <input type="text" name="sort_order" value="0" placeholder="Sort Order" id="input-sort-order" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status">Status</label>
                <div class="col-sm-10">
                  <select name="status" id="input-status" class="form-control">
                                        <option value="1" selected="selected">Enabled</option>
                    <option value="0">Disabled</option>
                                      </select>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-design">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left">Stores</td>
                      <td class="text-left">Layout Override</td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-left">Default</td>
                      <td class="text-left"><select name="category_layout[0]" class="form-control">
                          <option value=""></option>
                                                                              <option value="6">Account</option>
                                                                                                        <option value="10">Affiliate</option>
                                                                                                        <option value="3">Category</option>
                                                                                                        <option value="7">Checkout</option>
                                                                                                        <option value="12">Compare</option>
                                                                                                        <option value="8">Contact</option>
                                                                                                        <option value="4">Default</option>
                                                                                                        <option value="1">Home</option>
                                                                                                        <option value="11">Information</option>
                                                                                                        <option value="5">Manufacturer</option>
                                                                                                        <option value="2">Product</option>
                                                                                                        <option value="13">Search</option>
                                                                                                        <option value="9">Sitemap</option>
                                                                            </select></td>
                    </tr>
                                      </tbody>
                </table>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$('#input-description1').summernote({
	height: 300
});
//--></script> 
  <script type="text/javascript"><!--
$('input[name=\'path\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/category/autocomplete&token=ec7d18a3fa699d5a01a8f7cc4c43efb7&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				json.unshift({
					category_id: 0,
					name: ' --- None --- '
				});

				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['category_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'path\']').val(item['label']);
		$('input[name=\'parent_id\']').val(item['value']);
	}
});
//--></script> 
  <script type="text/javascript"><!--
$('input[name=\'filter\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/filter/autocomplete&token=ec7d18a3fa699d5a01a8f7cc4c43efb7&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['filter_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter\']').val('');

		$('#category-filter' + item['value']).remove();

		$('#category-filter').append('<div id="category-filter' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="category_filter[]" value="' + item['value'] + '" /></div>');
	}
});

$('#category-filter').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});
//--></script> 
  <script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script></div>

<?php require_once(HTTP_ROOT_ADMIN.'common/footer.php'); ?>