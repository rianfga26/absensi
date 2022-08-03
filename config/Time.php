<?php 

// beberapa waktu yang lalu
function waktu_lalu($secs)
{
    $bit = array(
        ' tahun'        => $secs / 31556926 % 12,
        ' minggu'        => $secs / 604800 % 52,
        ' hari'        => $secs / 86400 % 7,
        ' jam'        => $secs / 3600 % 24,
        ' menit'    => $secs / 60 % 60,
        ' detik'    => $secs % 60
    );

    foreach ($bit as $k => $v) {
        if ($v > 1) $ret[] = $v . $k;
        if ($v == 1) $ret[] = $v . $k;
    }

    array_splice($ret, count($ret) - 1, 0, '');
    $ret[] = 'lalu.';

    return join(' ', $ret);
}