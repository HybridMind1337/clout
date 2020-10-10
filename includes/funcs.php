<?php
if(preg_match('/funcs.php/', $_SERVER['SCRIPT_NAME'])) { 
    header('Location: ../');
}

// Функция за проверка на SMS кодовете от Mobio
function mobio_checkcode($servID, $code, $debug = 0) {
    $res_lines = file("http://www.mobio.bg/code/checkcode.php?servID=$servID&code=$code");
    $ret = 0;
    if ($res_lines) {
        if (strstr("PAYBG=OK", $res_lines[0])) {
            $ret = 1;
        } else {
            if ($debug) echo $line . "\n";
        }
    } else {
        if ($debug) echo "Unable to connect to mobio.bg server.\n";
        $ret = 0;
    }
    return $ret;
}

function mysqli_result($result, $row, $field = 0) {
    if ($result === false) return false;
    if ($row >= mysqli_num_rows($result)) return false;
    if (is_string($field) && !(strpos($field, ".") === false)) {
        $t_field = explode(".", $field);
        $field = - 1;
        $t_fields = mysqli_fetch_fields($result);
        for ($id = 0;$id < mysqli_num_fields($result);$id++) {
            if ($t_fields[$id]->table == $t_field[0] && $t_fields[$id]->name == $t_field[1]) {
                $field = $id;
                break;
            }
        }
        if ($field == - 1) return false;
    }
    mysqli_data_seek($result, $row);
    $line = mysqli_fetch_array($result);
    return isset($line[$field]) ? $line[$field] : false;
}

function get_credits($id) {
    global $conn;
    $get = mysqli_query($conn, "SELECT credits from phpbb_users WHERE user_id='$id'");
    $row = mysqli_fetch_assoc($get);
    @mysqli_free_result($get);
    return $row['credits'];
}

function set_credits($id, $amount) {
    global $conn;
    $get = mysqli_query($conn, "UPDATE phpbb_users SET credits=credits+'$amount' WHERE user_id='$id'");
    @mysqli_free_result($get);
    return '<div class="success-box alert"> <div class="msg">Успешно!</div></div>';
}

function remove_credits($id, $amount) {
    global $conn;
    $get = mysqli_query($conn, "UPDATE phpbb_users SET credits=credits-'$amount' WHERE user_id='$id'");
    @mysqli_free_result($get);
}

function pagination($results, $properties = array()) {
	$defaultProperties = array(
		'get_vars'	=> array(),
		'per_page' 	=> 15,
		'per_side'	=> 4,
		'get_name'	=> 'page'
	);
	
	foreach($defaultProperties as $name => $default) { $properties[$name] = (isset($properties[$name])) ? $properties[$name] : $default; }
	
	foreach($properties['get_vars'] as $name => $value) {
		if (isset($_GET[$name]) && $name != $properties['get_name']) {
			$GETItems[] = $name.'='.$value;
		}
	}
	$l = (empty($GETItems)) ? '?'.$properties['get_name'].'=' : '?'.implode('&', $GETItems).'&'.$properties['get_name'].'=';
	
	$totalPages		= ceil($results / $properties['per_page']);
	$currentPage 	= (isset($_GET[$properties['get_name']]) && $_GET[$properties['get_name']] > 1) ? $_GET[$properties['get_name']] : 1;
	$currentPage 	= ($currentPage > $totalPages) ? $totalPages : $currentPage;
	
	$previousPage 	= $currentPage - 1;
	$nextPage 		= $currentPage + 1;
	
// calculate which pages to show
if ($totalPages <= ($properties['per_side'] * 2) + 1) {
	$loopStart = 1;
	$loopRange = $totalPages;
} else {
	$loopStart = $currentPage - $properties['per_side'];
	$loopRange = $currentPage + $properties['per_side'];
	
	$loopStart = ($loopStart < 1) ? 1 : $loopStart;
	while ($loopRange - $loopStart < $properties['per_side'] * 2) { $loopRange++; }
	
	$loopRange = ($loopRange > $totalPages) ? $totalPages : $loopRange;
	while ($loopRange - $loopStart < $properties['per_side'] * 2) { $loopStart--; }
}

// start placing data to output
$output = '';
$output .= '<ul class="pagination pagination-responsive justify-content-center">';

// first and previous page
if ($currentPage != 1) {
	$output	.= '<li class="page-item"><a class="page-link" href=\''.$l.'1\'>&#171;</a></li>';
	$output .= '<li class="page-item"><a class="page-link" href=\''.$l.$previousPage.'\'>‹</a></li>';
} else {
	$output .= '<li class="page-item"><span class="page-link">&#171;</span></li>';
	$output .= '<li class="page-item"><span class="page-link">‹</span></li>';
}


// add the pages
for ($p = $loopStart; $p <= $loopRange; $p++) {
	if ($p != $currentPage) {
		$output .= '<li class="page-item"><a class="page-link" href=\''.$l.$p.'\'>'.$p.'</a></li>';
	} else {
		$output .= '<li class="page-item disabled"><a class="page-link" href="#">'.$p.'</a></li>';
	}
}
// next and last page
if ($currentPage != $totalPages) {
	$output .= '<li class="page-item"><a class="page-link" href=\''.$l.$nextPage.'\' class=\'active\'>›</a></li>';
	$output .= '<li class="page-item"><a class="page-link" href=\''.$l.$totalPages.'\' class=\'active\'>&#187;</a></li>';
} else {
	$output .= '<li class="page-item"><span class="page-link">›</span></li>';
	$output .= '<li class="page-item"><span class="page-link">&#187;</span></li>';
}

$output .= '</ul>';
// end of output
	
	return array(
		'limit' => array(
			'first' 	=> $previousPage * $properties['per_page'],
			'second' 	=> $properties['per_page']
		),
		
		'output' => $output
	);
}

// Изтрива изтеклите админи, ако префиксите на датабазата са ви различни - променете си ги!
mysqli_query($conn, "DELETE w,e FROM amx_amxadmins w INNER JOIN  amx_admins_servers e ON e.admin_id=w.id WHERE w.expired<UNIX_TIMESTAMP() AND w.expired !=0") or die(mysqli_error($conn));