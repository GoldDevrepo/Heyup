<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
<meta charset="UTF-8" />
<title><?php echo $document->getTitle(); ?></title>
<base href="<?php echo HTTP_ADMIN; ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

<?php $links = $document->getLinks(); 
if(sizeof($links)){ foreach($links as $link){ ?>
<link type="text/css" href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php }} ?>

<?php $scripts = $document->getScripts(); 
if(sizeof($scripts)){ foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php }} ?>