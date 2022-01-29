<?php
//キャッシュ制御
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', FALSE );
header( 'Pragma:no-cache' );
require_once __DIR__ . '/function.php';
//CSS設定
$cssinclude = external_cssfiles("index.php");
//セッション利用
setSession();
$id = session_id();
//データベース値取得
$sqldata= selectData();
//ポストのみ動作する
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //ポストデータ取得
	$flags= filter_input(INPUT_POST, 'sender');
    $word = filter_input(INPUT_POST, 'word');
    $name = filter_input(INPUT_POST, 'name');
    $icon = filter_input(INPUT_POST, 'icon');
    if($name=="") $name="名無し";
    //削除フラグ取得
    $check= deletflags();
	switch($flags){
		case "コメントを投稿":
            dbwrite($word, $name, $id, $icon);
        break;
		case "書込みを消去":
            dbdelete($check, $id);
        break;
        default:
        break;
    }
    //データベース値取得
    $sqldata= selectData();
    header("Location: " . $_SERVER['PHP_SELF']);
}
//削除フラグ
function deletflags(){
    $check=[];
    foreach($_POST as $key=>$val){
        if(preg_match('/check/', $key)){
            $num = preg_replace('/[^0-9]/', '', $key);
            $check[$num]=filter_input(INPUT_POST, $key);
        }
    }
    return $check;
}
//データ書き込み
function dbwrite($word, $name, $id, $icon){
    if($word!="" && $name!=""){
        $No=tableRows()+1;
        intoData($No, $word, $name, $id, $icon);
    }
}
//データ削除
function dbdelete($check, $id){
    global $sqldata;
    foreach($check as $key=>$val){
        if($val=="on"){
            foreach($sqldata as $data){
                if($data["No"]==$key && $data["sessionid"]==$id){
                    deleteData($key);
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ja" dir="ltr">
<head>
<meta charset="UTF-8">
<meta name="robots" content="noindex">
<?php echo $cssinclude; ?>
<title>サンプルページ</title>
<style>
</style>
</head>
<body>
    <header><h1>サンプルページ[MySQL操作]</h1></header>
    <nav>
        <ul>
            <li class="linkset"><a href="index.php">MySQL操作</a></li>
            <li class="linkset"><a href="index2.php">PHPによるCSS生成</a></li>
        </ul>
    </nav>
    <main id="mainbg">
        <div class="msgboard">
            <form id="form" method="post" action="" enctype="multipart/form-data">
                <?php foreach($sqldata as $data): ?>
                    <div class="balloon">
                        <div class="faceicon">
                            <img src="img/icon<?php echo $data['icon']; ?>.png"class="icon"><br/>
                            <?php if($data["sessionid"]==$id):?>
                                <input id="check<?php echo $data['No']; ?>" name="check<?php echo $data['No']; ?>" type="checkbox" form="form" />
                            <?php endif; ?>
                            <?php echo $data['name']; ?>
                        </div>
                        <div class="chatting">
                            <div class="says">
                                <p><?php echo $data['val']; ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
                <label>コメント <br/>
                <textarea id="word" name="word" placeholder="入力してください" cols="45" maxlength="128"></textarea></label><br/><br/>
                <label>名前 <input id="name" type="text" name="name" placeholder="入力してください" value=""/></label>
                <label>アイコン 
                    <select name="icon">
                        <option value="1">ネコ</option>
                        <option value="2">ヒヨコ</option>
                        <option value="3">クマ</option>
                        <option value="4">ウサギ</option>
                        <option value="5">アルパカ</option>
                        <option value="6">ペンギン</option>
                    </select>
                </label><br/>
                <br/>
                <input id="write"  type="submit" value="コメントを投稿" class="clickEvent" name="sender" />
                <input id="reset"  type="submit" value="書込みを消去" class="clickEvent" name="sender" />
            </form>
        </div>
    </main>
    <footer>&copy;Copyright Nakai.2022</footer>
</body>
</html>
