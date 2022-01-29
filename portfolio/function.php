<?php
//定数の読込み
require_once __DIR__ . '/mypass/sqlpass.php';
// 変数内のnullバイトを削除
$_GET = delete_null_byte($_GET); // $_GET内のnullバイトを削除
$_POST = delete_null_byte($_POST); // $_POST内のnullバイトを削除
$_COOKIE = delete_null_byte($_COOKIE); // $_COOKIE内のnullバイトを削除
$_REQUEST = delete_null_byte($_REQUEST); // $_REQUEST内のnullバイトを削除
/**
* 文字列中のnullバイトを削除する関数
* 引数が配列の場合は、配列の要素に対して再帰的に処理を行う
*/
function delete_null_byte($value){
    if (is_string($value) === true) {
        $value = str_replace("\0", "", $value);
    } elseif (is_array($value) === true) {
        $value = array_map('delete_null_byte', $value);
    }
    return $value;
}
/*********
 * フォルダ内削除
 * $dir ディレクトリパス
***********/
function dirFilesDel($dir){
    $dirFiles = glob($dir);
    $output=[];
    try {
        if($dirFiles!==[]){
            foreach ($dirFiles as $file){
                if(chmod($file,0666)){
                    //ファイルを削除する
                    if (unlink($file)){
                        //何もしない
                    }else{
                        throw new Exception($file.'の削除に失敗しました'); 
                    }
                }else{
                    throw new Exception($file.'の権限付与に失敗しました'); 
                }
            }
        }
    } catch (Exception $e) {
        array_push($output,$e->getMessage());
    }
    return $output;
}
/**********
 * ファイル生成書き込み
********/
function fileinput($file, $string){
    $output=[];
    try {
        touch(__DIR__ . $file);
        chmod(__DIR__ . $file,0666);
        if (file_put_contents(__DIR__ . $file, $string, FILE_APPEND | LOCK_EX)){
            //何もしない
        }else{
            throw new Exception($file.'の書き込みに失敗しました'); 
        }
    } catch (Exception $e) {
        array_push($output,$e->getMessage());
    }
    return $output;
}
/******
 * 書き込み文生成
**********/
function inputCSSstrings($url){
    $cssArr = parse_ini_file(__DIR__ . '/nic/css.ini', true);
    switch($url){
        case "index.php":
            return $cssArr['all']['resetcss'].$cssArr['all']['allsetcss'].$cssArr['index']['indexcss'];
        break;
        case "index2.php":
            return $cssArr['all']['resetcss'].$cssArr['all']['allsetcss'].$cssArr['index2'][mt_rand(1, 6)];
        break;
        default:
            return;
        break;
    }
}
/******
 * CSS外部ファイル生成
**********/
function external_cssfiles($url){
    //cssフォルダクリア
    $dir= __DIR__ .'/css/*';
    $flags= dirFilesDel($dir);
    if($flags===[]){
        $setString= inputCSSstrings($url);
        if($setString!=null){
            $file= '/css/CSS'.date("YmdHis").'.css';
            $flags= fileinput($file, $setString);
            if($flags===[]){
                $jsUrl= (empty($_SERVER["HTTPS"]) ? "http://" : "https://").$_SERVER["HTTP_HOST"] .'/portfolio'.$file;
                return '<link href="'.$jsUrl.'" rel="stylesheet" type="text/css" media="all" id="css" />';
            }else{
                var_dump($flags);
            }
        }
    }
}
function external_cssfiles_name($url){
    //cssフォルダクリア
    $dir= __DIR__ .'/css/*';
    $flags= dirFilesDel($dir);
    if($flags===[]){
        $setString= inputCSSstrings($url);
        if($setString!=null){
            $file= '/css/CSS'.date("YmdHis").'.css';
            $flags= fileinput($file, $setString);
            if($flags===[]){
                $jsUrl= (empty($_SERVER["HTTPS"]) ? "http://" : "https://").$_SERVER["HTTP_HOST"] .'/portfolio'.$file;
                return '"'.$jsUrl.'"';
            }else{
                var_dump($flags);
            }
        }
    }
}
/**********
 * SQL POD execute
 * $sql="SELECT `img` FROM `image_data` WHERE `No` = :no";
 * $params=[keyString=>['value'=>setValue,'param'=>'srt'or'int'or'bool'or'null'or'lob']]
***************/
function sqlPDOexe($sql, array $params){
    //一般的なパラメタ,date無かったのでSTRで、boolはキャストしないといけないかも
    $prmStr=[
        "str" =>PDO::PARAM_STR,
        "int" =>PDO::PARAM_INT,
        "bool"=>PDO::PARAM_BOOL,
        "null"=>PDO::PARAM_NULL,
        "date"=>PDO::PARAM_STR,
        "lob" =>PDO::PARAM_LOB
    ];
    try{
        $pdo = new PDO(SQLSETTING, USERNAME, PASSWORD);
        //エラー表示
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare($sql);
        foreach($params as $key => $param){
            $stmt->bindValue($key, $param['value'], $prmStr[$param['param']]);
            // $stmt->bindValue($key, $param['value']);
        }
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }catch(PDOException $e){
        echo 'error:' .$e;
        die();
    }
}
/** 
 * データの読み出し
 * SELECT * FROM `sample` WHERE 1;
***/
function selectData(){
    $sql= "SELECT * FROM(SELECT * FROM `sample` WHERE :no ORDER BY No DESC LIMIT 5) AS A ORDER BY No;";
    $params=[
        ':no'  =>['value'=>1,'param'=>'int']
    ];
    $stmt= sqlPDOexe($sql, $params);
    return $stmt;
}
/**
 * データの削除
 * DELETE FROM `data` WHERE `data`.`No` = ??
 ***/
function deleteData($No){
    $sql= "DELETE FROM `sample` WHERE `sample`.`No` = :no ;";
    $params=[
        ':no'  =>['value'=>$No,'param'=>'int']
    ];
    $stmt= sqlPDOexe($sql, $params);
    return $stmt;
}
/** 
 * データの追加
 * INSERT INTO `sample` (`No`, `val`) VALUES ('2', 'テストデータ2');
***/
function intoData($No, $str, $name, $id, $icon){
    $sql= "INSERT INTO `sample` (`No`, `val`, `sessionid`, `name`, `icon`) VALUES (:no, :str, :id, :name, :icon);";
    $params=[
        ':no'  =>['value'=>$No,  'param'=>'int'],
        ':str' =>['value'=>$str, 'param'=>'str'],
        ':id'  =>['value'=>$id,  'param'=>'str'],
        ':name'=>['value'=>$name,'param'=>'str'],
        ':icon'=>['value'=>$icon,'param'=>'int']
    ];
    $stmt= sqlPDOexe($sql, $params);
    return $stmt;
}
/** 
 * データ上書き
 * UPDATE `sample` SET `val` = 'テストデータ2' WHERE `sample`.`No` = 2;
***/
function updateData($No, $str){
    $sql= "UPDATE `sample` SET `val` = :str WHERE `sample`.`No` = :no ;";
    $params=[
        ':no'  =>['value'=>$No, 'param'=>'int'],
        ':str' =>['value'=>$str,'param'=>'str']
    ];
    $stmt= sqlPDOexe($sql, $params);
    return $stmt;
}
/**
 * テーブルのデータ数を取得
 */
function tableRows(){
    $table_name = "sample";
    $row=[];
    //画像データ数
    $pdo = new PDO(SQLSETTING, USERNAME, PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT MAX(`No`) as `No` FROM ".$table_name.";";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();;
    while($buff = $stmt->fetch(PDO::FETCH_ASSOC)){
        $row[] = $buff['No'];
    }
    return $row[0];
}
/** 
 * セッション
 * セッションのチェック
***/
function setSession(){
    if(session_status() == PHP_SESSION_NONE) {
        // セッションは有効で、開始していないとき
        my_session_start();
    }elseif(session_status() == PHP_SESSION_ACTIVE){
        // セッションは有効で、開始しているとき
    }elseif(session_status() == PHP_SESSION_DISABLED){
        // セッションは無効な時
        my_session_start();
        newSessionID();
    }
}
/** 
 * セッション
 * セッションの生成
***/
function my_session_start(){
    @session_start();
    if(isset($_SESSION['destroyed'])){
        if($_SESSION['destroyed'] < time()-300) {
            if(ini_get("session.use_cookies")){
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }
            session_destroy();
            session_abort();
            die ('session err');
        }
        if(isset($_SESSION['new_session_id'])) {
            session_commit();
            session_id($_SESSION['new_session_id']);
            @session_start();
            return;
        }
    }
}
/** 
 * セッション
 * セッションIDの生成
***/
function newSessionID(){
    $new_session_id = session_create_id();
    $_SESSION['new_session_id'] = $new_session_id;
    $_SESSION['destroyed'] = time();
    session_commit();
    session_id($new_session_id);
    ini_set('session.use_strict_mode', 0);
    @session_start();
    ini_set('session.use_strict_mode', 1);
    unset($_SESSION['destroyed']);
    unset($_SESSION['new_session_id']);
}
?>