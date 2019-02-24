<?php
	unset($session->data['admin']);
	$common->addAlert('success', 'Successfully logged out.');
	$sys->redirect(HTTP_ADMIN);
?>