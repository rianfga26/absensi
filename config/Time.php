<?php 
ini_set('display_errors', '0');

// beberapa waktu yang lalu
function waktu_lalu($secs)
{
    $bit = array(
        ' tahun'        => $secs / 31556926 % 12 | 0,
        ' minggu'        => $secs / 604800 % 52 | 0,
        ' hari'        => $secs / 86400 % 7 | 0,
        ' jam'        =>  $secs / 3600 % 24 | 0,
        ' menit'    => $secs / 60 % 60 | 0,
        ' detik'    => $secs % 60 | 0
    );

    foreach ($bit as $k => $v) {
        if ($v > 1) $ret[] = $v . $k;
        if ($v == 1) $ret[] = $v . $k;
    }
    

    array_splice($ret, count($ret) - 1, 0, '');
    $ret[] = 'lalu.';

    return join(' ', $ret);
}