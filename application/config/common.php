<?php

/* 파일버전 */
$config['ver'] = "?v=".strtotime(date('Y-m-d H:i:s'));

/* 좌석 배치 수 */
$config['maxX'] = 30;
$config['maxY'] = 20;

/* 사용시간 */

$config['useTime'] = array(
    0 => array('hour' => 2, 'amount' => 4000),
    1 => array('hour' => 3, 'amount' => 6000),
    2 => array('hour' => 5, 'amount' => 9000),
    3 => array('hour' => 12, 'amount' => 20000)
);


?>