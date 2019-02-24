<?php
session_start();
// if(!isset($_SESSION['user_id']) && empty($_SESSION['user_id'])){
	// echo 'Permission Denied!';
	// die;
// }
// if($_SESSION['user_id'] != 8){
	// echo 'Permission Denied!';
	// die;
// }
?>
<!doctype html>
<html>
<head>
<title>API tester</title>
<script type="text/javascript" src="jquery-1.10.2.min.js"></script>
<script type="text/javascript">
var start = true;
$(document).ready(function(){

$('#btnadd').click(function(){
	var field_name = $("#field_name").val();
	var html = '';
	html += '<li>'+field_name+'<input type="text" name="'+field_name+'" value="" /><button class="rem" form="" >Remove</button></li>';
	$('#fields_list').append(html);
	$("#field_name").val("");
	$("#field_name").focus();
	$('.rem').click(function(){
	$(this).parent().remove();
	});
});

$('#btnstart').click(function(){
	var post_on = $('#post_on').val();
	$.ajax({
		url: ''+post_on,
		type: 'POST',
		dataType: 'JSON',
		data: $("#form_to_post").serializeArray(),
		success: function(json){
			$.each(json, function(key,value){
				$('.results').append(key +' : ' + value + "<br />");
			});
			$('.results').append("<br />");
		}
	});
});

});

</script>
<style type="text/css">
ul {
    list-style: none outside none;
    padding: 0;
}
ul li {
    margin: 0 10px 5px 0;
}
.load {
    background-color: #FFFB95;
    background-image: url("ajax-loader.gif");
    background-position: right center;
    background-repeat: no-repeat;
    border-color: #FF0000;
}
.done {
    background-color: #EDFFF8;
    border-color: #008000;
}
</style>
</head>
<body style="font-family:arial;font-size:12px;">
Form URL <input type="text" id="post_on" value="http://119.226.42.77/cipher.php" style="width: 300px;"/><br />
<input type="text" id="field_name" value=""/><input type="button" id="btnadd" value="Add" /><br />
<form enctype="multipart/form-data" method="post" id="form_to_post">
<ul id="fields_list">
<li>auth<input type="text" value="" name="auth"><button form="" class="rem">Remove</button></li>
<li>text<input type="text" value="" name="text"><button form="" class="rem">Remove</button></li>
<li>request<input type="text" value="" name="request"><button form="" class="rem">Remove</button></li>
</ul>
</form>

<input type="button" id="btnstart" value="Check" />
<div class="results"></div>
</body>
</html>
