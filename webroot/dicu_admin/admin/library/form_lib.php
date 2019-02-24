<?php
	$common->adminAccess();
	$document->setTitle('Add form');
	$breadcrumb = $common->breadcrumb(array(
		array('text'=>'Home','href'=>HTTP_ADMIN),
		array('text'=>'Categories','href'=>HTTP_ADMIN.'form.php'),
	));
	
	$page['title']		 = 'Categories';
?>