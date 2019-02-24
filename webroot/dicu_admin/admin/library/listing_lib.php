<?php
	$common->adminAccess();
	$document->setTitle('Listing');
	$breadcrumb = $common->breadcrumb(array(
		array('text'=>'Home','href'=>HTTP_ADMIN),
		array('text'=>'Categories','href'=>HTTP_ADMIN.'listing.php'),
	));
	
	$page['title']		 = 'Categories List';
?>