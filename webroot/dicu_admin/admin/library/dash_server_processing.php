<?php

require_once '../../config.php';

require_once HTTP_ROOT_SYSTEM . 'sys.php';
$sys = new Sys();

$table = 'users';
$primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array('db' => 'id', 'dt' => 0),
    array('db' => 'profile_img', 'dt' => 1,
        'formatter' => function( $d, $row ) {
    global $sys;
    $img = (!empty($d)) ? PROFILE_IMG . $d : '';
    $img_url = $sys->thumbImage($img, 50);
    $img_tag = '<img src="' . $img_url . '" />';
    return $img_tag;
}),
    array('db' => 'name', 'dt' => 2,
        'formatter' => function( $d, $row ) {
    return '<a href="./users/index_form.php?id=' . $row[0] . '">' . $d . '</a>';
}),
    array('db' => 'email', 'dt' => 3),
    array('db' => 'created', 'dt' => 4,
        'formatter' => function( $d, $row ) {
    return date('d-M-Y', strtotime($d));
}),
    array('db' => 'status', 'dt' => 5,
        'formatter' => function( $d, $row ) {
    return ($d == 1) ? "Enabled" : "Disabled";
}),
    array('db' => 'country', 'dt' => 6),
    array('db' => 'device_id', 'dt' => 7,
        'formatter' => function( $d, $row ) {
    return ($d == 1) ? "iOS" : "Android";
}),
);

$sql_details = array(
    'user' => DB_USERNAME,
    'pass' => DB_PASSWORD,
    'db' => DB_DATABASE,
    'host' => DB_HOSTNAME
);


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require( '../javascript/datatables/ssp.class.php' );
$mdi_filter = "";

echo json_encode(
        SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "", $mdi_filter)
);
