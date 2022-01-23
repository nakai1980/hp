<?php
//db_set
define("COOKIE_PATH","/photo");
define("COOKIE_DOMAIN","localhost");
define("COOKIE_SECURE",true);
define("COOKIE_HTTPONLY",true);
//定数の読込み
require_once('sqlpass.php');
// 変数内のnullバイトを削除
$_GET = delete_null_byte($_GET); // $_GET内のnullバイトを削除
$_POST = delete_null_byte($_POST); // $_POST内のnullバイトを削除
$_COOKIE = delete_null_byte($_COOKIE); // $_COOKIE内のnullバイトを削除
$_REQUEST = delete_null_byte($_REQUEST); // $_REQUEST内のnullバイトを削除
// グローバル変数 遷移先、遷移元の一時記憶
$motourl=[];
$ima_url=[];

/**
 * ログイン状態によってリダイレクトを行う
 * 初回時または失敗時にヘッダを設定して
 */
function require_unlogined_session()
{
    // セッション開始
    @session_start();
    // 遷移元の格納
    transion_source();
    // セッションの有効時間チェック
    session_timeup();
    // ログインしていれば遷移元に遷移
    if (isset($_SESSION['username'])) {
        $tmp = transion_source();
        sleep(1);
        header('Location: '.$tmp);
        exit;
    }
}
function require_logined_session()
{
    // セッション開始
    @session_start();
    // 遷移元の格納
    transion_source();
    // セッションの有効時間チェック
    session_timeup();
    // ログインしていなければ /login.php に遷移
    if (!isset($_SESSION['username'])) {
        sleep(1);
        header('Location: ./login.php');
        exit;
    }
}
/**
 * 遷移前の調査
 * セッション内外でのチェックを行う
 *
 **/
function transion_source()
{
    //格納変数(グローバル配列)
    global $motourl;
    global $ima_url;
    $motourl["name"]="";
    $motourl["hash"]="";
    $motourl["search"]="";
    //出力
    $url_output="";
    //現URLの格納
    $tmp_url = $_SERVER['SCRIPT_NAME'];
    $tmp_url = explode("photo/",$tmp_url,2);
    //現URL
    $ima_url["name"] = $tmp_url[1];
    $ima_url["query"] = $_SERVER['QUERY_STRING'];
    // 遷移元を格納
    if(isset($_SERVER['HTTP_REFERER'])){
        //REFERER
        $tmp_url = $_SERVER['HTTP_REFERER'];
        $tmp_url = explode("photo/",$tmp_url,2);
        $tmp_url = $tmp_url[1];
        //search
        if(strpos($tmp_url,"?")){
            $tmp_url = explode("?",$tmp_url,2);
            $motourl["search"] = $tmp_url[1];
            $tmp_url = $tmp_url[0];
        }else{
            $motourl["search"] = "err";
        }
        //hash生成
        $motourl["hash"]=locahash($tmp_url, $motourl["search"]);
        //遷移元
        $motourl["name"] = $tmp_url;
    }else{
        $motourl["name"] = "index.php";
    }
    // セッションのチェック
    if(session_status() == PHP_SESSION_ACTIVE){
        // 遷移を確認してセッションと変数に格納
        if($ima_url["name"]=="login.php" and $motourl["name"]!="login.php"){
            //ログインに入ってきた
            //ログイン処理で遷移元が消える->ログイン処理でcookieに入れる。
            setcookie("motourl[name]", $motourl["name"]);
            setcookie("motourl[hash]", $motourl["hash"]);
            setcookie("motourl[search]", $motourl["search"]);
        }elseif($motourl["name"]=="login.php"){
            // ログイン処理中
            // 消えた遷移元を復活
            if (isset($_COOKIE["motourl"])){
                $cookout=$_COOKIE['motourl'];
                $motourl["name"] = $cookout['name'];
                $motourl["hash"] = $cookout['hash'];
                $motourl["search"] = $cookout['search'];
            }
        }elseif($motourl["name"]=="photoEdit.php" and $ima_url["name"]=="photo.php" ){
            //編集ページに移動の際に行先が消える->cookieに入れる。
            setcookie("ima_url[name]", $ima_url["name"] );
            setcookie("ima_url[query]", $ima_url["query"]);
        }elseif($motourl["name"]=="topEdit.php" and $ima_url["name"]=="index.php" ){
            //編集ページに移動の際に行先が消える->cookieに入れる。
            setcookie("ima_url[name]", $ima_url["name"] );
            setcookie("ima_url[query]", $ima_url["query"]);
        }
        //遷移元から遷移先URLを作成
        if(isset($motourl["name"])){
            //変数名変更
            $moto_name=$motourl["name"];
            $ima_name=$ima_url["name"];
            //通常ページから編集へ
            if(($moto_name=="index.php")or($moto_name=="")or($moto_name=="photo.php")){
                //ログイン？
                if($ima_name=="login.php"){
                    $searchstr="";
                    if($motourl["search"]!="err"){
                        $searchstr="?".$motourl["search"];
                    }
                    $hashstr="";
                    if($motourl["hash"]!="err"){
                        $hashstr="#".$motourl["hash"];
                    }
                    //ログインページにいる
                    switch($moto_name){
                        //編集ページへ
                        case "index.php":
                            $url_output = "./topEdit.php".$searchstr.$hashstr;
                        break;
                        case "photo.php":
                            $url_output = "./photoEdit.php".$searchstr.$hashstr;
                        break;
                        //ログイン失敗
                        default:
                            $url_output = "./login.php";
                        break;
                    }
                }
            //編集ページから編集ページへ
            }elseif(($moto_name=="photoEdit.php")or($moto_name=="topEdit.php")or($moto_name=="writephoto.php")or($moto_name=="writetop.php")){
                //今通常ページか？
                if($ima_name=="index.php" or $ima_name=="photo.php"){
                    $searchstr="";
                    if($motourl["search"]!="err"){
                        //編集ページ移動ならサーチ書き換え
                        if($moto_name=="photoEdit.php" and $ima_name=="index.php"){
                            $motourl["search"]="m=0";
                        }elseif($moto_name=="topEdit.php" and $ima_name=="photo.php"){
                            $motourl["search"]="y=3&s=1&c=1";
                        }
                        $searchstr="?".$ima_url["query"];
                    }
                    $hashstr="";
                    if($motourl["hash"]!="err"){
                        //編集ページ移動ならハッシュ書き換え
                        if($moto_name=="photoEdit.php" and $ima_name=="index.php"){
                            $motourl["hash"]="menu0";
                        }elseif($moto_name=="topEdit.php" and $ima_name=="photo.php"){
                            $motourl["hash"]="photo1";
                        }
                        $hashstr="#".$motourl["hash"];
                    }
                    //通常ページなので編集に入れる
                    switch($ima_name){
                        //編集ページへ
                        case "index.php":
                            $url_output = "./topEdit.php".$searchstr.$hashstr;
                        break;
                        case "photo.php":
                            $url_output = "./photoEdit.php".$searchstr.$hashstr;
                        break;
                        //ログイン失敗
                        default:
                            $url_output = "./login.php";
                        break;
                    }
                }else{
                    //通常ページではない＝＞ログアウト？
                    if($ima_name=="logout.php"){
                        $searchstr="";
                        if($motourl["search"]!="err"){
                            $searchstr="?".$motourl["search"];
                        }
                        $hashstr="";
                        if($motourl["hash"]!="err"){
                            $hashstr="#".$motourl["hash"];
                        }
                        //ログアウトページにいる
                        switch($moto_name){
                            //通常ページへ
                            case "photoEdit.php":
                            case "writephoto.php":
                                $url_output = "./photo.php".$searchstr.$hashstr;
                            break;
                            case "topEdit.php":
                            case "writetop.php":
                                $url_output = "./index.php".$searchstr.$hashstr;
                            break;
                            //ログアウト失敗
                            default:
                                $url_output = "./login.php";
                            break;
                        }
                    }
                }
            }
        }
    }
    //URLを反す
    return $url_output;
}
/**
 * セッションを開始して遷移元調査して遷移
 * ログイン状態で別編集ページに飛ぼうとしたとき
 */
function transion_source_edit()
{
    global $motourl;
    global $motourl_tmp;
    if(session_status() == PHP_SESSION_NONE) {
        // セッションは有効で、開始していないとき
        @session_start();
        if(isset($_SESSION['username'])){
            $tmp = transion_source();
            if($tmp){
                header('Location: '.$tmp);
                exit;
            };
        }
    }
}
/**
 * CSRFトークンの生成
 *
 * @return string トークン
 */
function generate_token()
{
    // セッションIDからハッシュを生成
    return hash('sha256', session_id());
}

/**
 * CSRFトークンの検証
 *
 * @param string $token
 * @return bool 検証結果
 */
function validate_token($token)
{
    // 送信されてきた$tokenがこちらで生成したハッシュと一致するか検証
    return $token === generate_token();
}

/**
 * htmlspecialchars関数
 *
 * @param string $str
 * @return string
 */
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

/**
 * セッションのタイムアップ処理
 *
 */
function session_timeup()
{
    // セッションの有無
    $timeStrNow = strtotime(date('Y-m-d H:i:s'));
    $timeStr1 = 0;
    $timeCheck = 0;
    if(isset($_SESSION['username'])){
        $timeStr1 = strtotime($_SESSION['last_login_time']);
        $timeCheck = $timeStrNow - $timeStr1;
        // 1Hならセッションをクリア
        if($timeCheck >= (60*60*1)){
            // セッション用Cookieの破棄
            setcookie(session_name(), '', 1);
            // セッションファイルの破棄
            session_destroy();
            // ログアウト完了後に /index.php に遷移
            header('Location: ./index.php?m=0#menu0');
            exit;
        }
    }
}

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

/**
* サイドメニュー用のアドレス関数
* わたされた分類の一番古い写真データのアドレスを反す
*/
function TimeListOld($class_name){
    global $top_menu3_year;
    $seasonAry = [1=>'spr', 2=>'sum', 3=>'aut', 4=>'win'];
    $classAry = ["tyou"=>1,"kino"=>2,"yacy"=>3,"plan"=>4,"dog"=>5,"flow"=>6,"tea"=>7,"trav"=>8,"fiel"=>9];
    for($i=2003;$i<2022;$i++){
        foreach($seasonAry as $key=>$tmp){
            if($top_menu3_year[$class_name][$tmp][$i]){
                $tp1=$i-2000;
                $tp2=$key;
                $tp3=$classAry[$class_name];
                $output = "photo.php?y=".$tp1."&s=".$tp2."&c=".$tp3."#photo".$tp2;
                return $output;
            }
        }
    }
}
/***
 * SQLロードが長いときの対応
 * ローディング画面表示
 * */
function Loadwaite(){
$gonext = <<<eot
 
<div id="loadendbg" style='
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0px;
    left: 0px;
    background: #000;
    z-index: 1;
'>
<div id="loadend" style='
    position: fixed;
    top: 50%;
    left: 50%;
    width: 200px;
    height: 200px;
    margin-top: -100px;
    margin-left: -100px;
    text-align: center;
    color: #fff;
    z-index: 2;
'>
<img src="./img/img-loading.gif" width="80" height="80" alt="Now Loading..." />
<p>Now Loading...</p>
</div></div>

eot;
//--ロード処理
    //ブラウザでバッファーリングされて直ぐに表示されない時は空白などを出力する
    header('Content-Type: text/html; charset=UTF-8');
    echo str_pad(" ",4096);
    ob_end_flush();
    ob_start('mb_output_handler');
    echo $gonext;
    ob_flush();
    flush();
}
/****
 * 表示データがない事への対応
 * わたされたデータが表示年がないなら表示可能な年に差し替え
*****/
function dispChk($Y,$S,$C){
    //表示フラグの呼び出し
    global $top_menu3_year;
    global $EditPage;
    $seasonNoArr = ['spr'=>1, 'sum'=>2, 'aut'=>3, 'win'=>4];
    $classNoArr = ["tyou"=>1,"kino"=>2,"yacy"=>3,"plan"=>4,"dog"=>5,"flow"=>6,"tea"=>7,"trav"=>8,"fiel"=>9];
    if(!$top_menu3_year[$C][$S][$Y]){
        $flag=false;
        for($i=2003;$i<2022;$i++){
            if($top_menu3_year[$C][$S][$i]){
                $flag=true;
                $Y=$i;
                //サーチが変わったのでページ読みなおし
                $tp1=$i-2000;
                $tp2=$seasonNoArr[$S];
                $tp3=$classNoArr[$C];
                if($EditPage=="photo"){
                    $phpSTR="photoEdit.php";
                }else{
                    $phpSTR="photo.php";
                }
                $tmp = $phpSTR."?y=".$tp1."&s=".$tp2."&c=".$tp3."#photo".$tp2;
                echo <<<EOD
                <script>
                window.location.href = '$tmp';
                </script>
                EOD;
                ob_flush();
                flush();
                break;
            }
        }
        if(!$flag){
            $Y=2003;
        }
    }
    return array($Y, $S, $C);
}
/**********
 * ロリポップでリロードが効かない時への対応
 * フラグでリロード,index.php
 * リロード対策でからヒストリを読ませリロードをかける
***********/
function reloadfunction($flag){
    $output=[];
    if($flag==null){
        echo <<<EOD
        <script>
        history.pushState(null, null, location.href);
        window.addEventListener('popstate', (e) => {
            history.go(1);
        });
        window.addEventListener('DOMContentLoaded', function(){
            sleep(3000);
            if (window.name != "any") {
                location.reload(true);
                window.name = "any";
            }else{
                window.name = "";
            }
        });
        </script>
        EOD;
    }elseif($flag=="index"){
        $output="/photo/index.php?m=0#menu0";
        echo <<<EOD
        <script>
        window.location.href = '$output';
        </script>
        EOD;
    }elseif($flag=="writephoto"){
        Transion_check("on");
        $tmp = locahash("writephoto.php", $_SERVER['QUERY_STRING']);
        $output="/photo/writephoto.php?".$_SERVER['QUERY_STRING']."#".$tmp;
        echo <<<EOD
        <script>
        window.location.href = '$output';
        </script>
        EOD;
    }elseif($flag=="photoEdit"){
        Transion_check("on");
        $query= YearSeasonReplace();
        $tmp = locahash("photoEdit.php", $query);
        $output="/photo/photoEdit.php?".$query."#".$tmp;
        echo <<<EOD
        <script>
        window.location.href = '$output';
        </script>
        EOD;
    }elseif($flag=="writetop"){
        Transion_check("on");
        $tmp = locahash("writetop.php", $_SERVER['QUERY_STRING']);
        $output="/photo/writetop.php?".$_SERVER['QUERY_STRING']."#".$tmp;
        echo <<<EOD
        <script>
        window.location.href = '$output';
        </script>
        EOD;
    }elseif($flag=="topEdit"){
        Transion_check("on");
        $tmp = locahash("topEdit.php", $_SERVER['QUERY_STRING']);
        $output="/photo/topEdit.php?".$_SERVER['QUERY_STRING']."#".$tmp;
        echo <<<EOD
        <script>
        window.location.href = '$output';
        </script>
        EOD;
    }
    //window.location.reload(true);
    //window.location.href = '$output';
    ob_flush();
    flush();
    return;
}
/****** 
 * #photo #manu ハッシュ生成 
 * $url_nameリンクファイルネーム　$searchサーチコード($_SERVER['QUERY_STRING'])
********/
function locahash($url_name, $search){
    $hash="";
    //hash生成
    switch($url_name){
        case "":
        case "index.php":
        case "topEdit.php":
        case "writetop.php":
            if($search!="err"){
                if(strpos($search,"&")){
                    $arr = explode("&", $search);
                }else{
                    $arr = array($search);
                }
                $tmp_hash=[];
                foreach($arr as $str){
                    if(strpos($str,"=")){
                        $tmp = explode("=",$str,2);
                        $tmp_hash[$tmp[0]] = $tmp[1];
                    }
                }
                //m=でハッシュを変えるようになれば使う
                //$motourl["hash"]="menu".$tmp_hash["m"];
                $hash="menu0";
            }
        break;
        case "photo.php":
        case "photoEdit.php":
        case "writephoto.php":
            if($search!="err"){
                if(strpos($search,"&")){
                    $arr = explode("&", $search);
                }else{
                    $arr = array($search);
                }
                $tmp_hash=[];
                foreach($arr as $str){
                    if(strpos($str,"=")){
                        $tmp = explode("=",$str,2);
                        $tmp_hash[$tmp[0]] = $tmp[1];
                    }
                }
                if(isset($tmp_hash["s"])){
                    $hash="photo".$tmp_hash["s"];
                }else{
                    $hash="photo1";
                }
            }
        break;
    }
    return $hash;
}
/*******
 * year season replace
 * 表示年や表示季節の差し替えがある場合
 * $_SERVER['QUERY_STRING']=>$nowY, $nowS, $nowC
*********/
function YearSeasonReplace(){
    global $imgSets;
    global $class;
    global $setYear;
    global $season;
    $setY= $setS= $setC= false;
    $nowY=3; $nowS=1; $nowC=1;
    $output="";
    if(strpos($_SERVER['QUERY_STRING'],"&")){
        $tmpArr = explode("&",$_SERVER['QUERY_STRING'],3);
        $tmp_que= [];
        foreach($tmpArr as $str){
            if(strpos($str,"=")){
                $tmp = explode("=",$str,2);
                $tmp_que[$tmp[0]] = $tmp[1];
            }
        }
        if(isset($tmp_que["y"])){$nowY= $tmp_que["y"];}
        if(isset($tmp_que["s"])){$nowS= $tmp_que["s"];}
        if(isset($tmp_que["c"])){$nowC= $tmp_que["c"];}
    }
    $type = filter_input(INPUT_POST, 'types');
    //クエリの再生成
    $Year= filter_input(INPUT_POST, 'year'.$type);
    $Season= filter_input(INPUT_POST, 'seasonSelect'.$type);
    $Year= $Year? $Year: $setYear;
    $Season= $Season? $Season: $season;
    $Year= (int)$Year- 2000;
    $seasonNoArr= ['spr'=>1, 'sum'=>2, 'aut'=>3, 'win'=>4];
    $Season= $seasonNoArr[$Season];
    if($nowY!=$Year){$setY= (int)$Year;}else{$setY= $nowY;}
    if($nowS!=$Season){$setS= $Season;}else{$setS= $nowS;}
    if(isset($nowC)){$setC= $nowC;}
    if($setY){$output= "y=".$setY;}
    if($setS){$output= $output."&s=".$setS;}
    if($setC){$output= $output."&c=".$setC;}
    return $output;
}
/*************
 * 編集した番号の記憶
 * photoEditの編集位置へのスクロールで利用
**************/
function NumStorage(){
    global $imgSets;
    global $class;
    $type = filter_input(INPUT_POST, 'types');
    //番号を記憶、photoEditのスクロールで利用
    if($type!=0){
        $num = (int)$type - 1;
        $No = $imgSets[$num]["No"];
    }else{
        //type=0ならROW+1
        $No = tableRows($class);
        $No = (int)$No[0];
        $No = (string)$No;
    }
    $_SESSION['changedNumber']= $No;
    return;
}
/******* 
 * 指定番号の年と季節どれかが変わっているか調査
********/
function changData($num){
    global $imgSets;
    $flags = FALSE;
    $type = filter_input(INPUT_POST, 'types');
    $chgSeason= filter_input(INPUT_POST, 'seasonSelect'.$type);
    $chgYear= filter_input(INPUT_POST, 'year'.$type);
    if($imgSets[$num]["Seasons"] != $chgSeason){
        $flags = TRUE;
    }
    if($imgSets[$num]["Year"] != $chgYear){
        $flags = TRUE;
    }
    return $flags;
}
/*************
 * 遷移チェックの関数
 * ページセッション後と遷移時に配置
 * ブラウザの戻るを検知する
**************/
function Transion_check($flag){
    // セッションのチェック
    if(session_status() == PHP_SESSION_ACTIVE){
        //ログイン状態
        if(isset($_SESSION['username'])){
            if($flag=="off"){
                //遷移フラグチェック
                if(isset($_SESSION['TransFlag'])){
                    if($_SESSION['TransFlag']){
                        //フラグオン
                        //きちんと遷移を通ってきた
                        $_SESSION['TransFlag']=false;
                    }else{
                        //フラグオフ
                        //戻るボタンとして対処
                        backbutton();
                    }
                }
            }elseif($flag=="on"){
                $_SESSION['TransFlag']=true;
            }
        }else{var_dump("err:Transion_check2");}
    }else{var_dump("err:Transion_check1");}
}
function backbutton(){
    //表示の初期化
    $Edit = [
        'flag'=>False,
        'TOPMenu'=>False,
        'SIDEMenu'=>False,
        'topPage' =>False,
        'infoPage' =>False,
        'linkList'=>[],
        'ImageList'=>[]
    ];
    for($i=0;$i<=50;$i++){
        $Edit['linkList'][$i]=False;
    }
    for($i=0;$i<=200;$i++){
        $Edit['ImageList'][$i]=False;
    }
    //表示用セッションも初期化
    $_SESSION["edit"]=$Edit;
    $_SESSION['Return']=null;
    $_SESSION['changedNumber']=null;
    $_SESSION['type']=0;
}
/*************
 * 文字列改行出力の関数
 * データベースからコメント読み出し時に設置
 * 改行はBRにタグ文字列はエスケープに変換
**************/
function sanitizeBR(string $str){
    return nl2br(htmlspecialchars($str, ENT_QUOTES, 'UTF-8'));
}
function ResanitizeBR(string $str){
    return str_replace('<br />', '',$str);
}

?>