<?php 
ini_set( 'display_errors', 1 );
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);
ini_set('xdebug.var_display_max_depth', -1);
$tmp = fileinput('/css/test.txt','test');
$cssArr = parse_ini_file(__DIR__ . '/nic/css.ini', true);
var_dump($cssArr);
function fileinput($file, $string){
    $output=[];
    try {
        touch(__DIR__ . $file);
        chmod(__DIR__ . $file,0666);
        if (file_put_contents(__DIR__ . $file, $string, FILE_APPEND | LOCK_EX)){
            //何もしない
        }else{
            throw new Exception($file.'の書き込みに失敗しました'); 
            var_dump("err");
        }
    } catch (Exception $e) {
        array_push($output,$e->getMessage());
    }
    return $output;
}