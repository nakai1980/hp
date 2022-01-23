<?php
//db name pass
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/dbpass.php';


// セッションのチェックと開始
require_unlogined_session();


// 事前に生成したユーザごとのパスワードハッシュの配列下はダミー
// echo password_hash("パスワード", PASSWORD_BCRYPT);
$hashes = [
    'username' => '$2y$10$5oJchTrDqSp7L9PsZ.WxPOHw7f7YAjpiUbQvRNKMb2tNPcBfl.CMu.',
];

// ユーザから受け取ったユーザ名とパスワード
$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST, 'password');

//db_load
if($username!=null && $password!=null){
    // ---------呼び出しSQL_実行( key(username), 書き込みデータ, 　SQL文格納配列,　　戻り値flag：1アリ)  
    $getpass = calSQL_Execution($username, null, $sqlSTRings['id_load_hash'], 1);
    if($getpass["output"]=="func_end"){
        //SQLからハッシュ取り出し
        $hashes = [
            $getpass[0]["id"] => $getpass[0]["temp_pass"]
        ];
    }else{
        //echo $getpass[0];
    }
    // 使い終わったら空に
    $getpass = array();
}

// POSTメソッドのときのみ実行
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        validate_token(filter_input(INPUT_POST, 'token')) &&
        password_verify(
            $password,
            isset($hashes[$username])
                ? $hashes[$username]
                : '$2y$10$abcdefghijklmnopqrstuv' // ユーザ名が存在しないときだけ極端に速くなるのを防ぐ
        )
    ) {
        // 認証が成功したとき
        // セッションIDの追跡を防ぐ
        session_regenerate_id(true);
        // ユーザ名をセット
        $_SESSION['username'] = $username;
        // 表示年季節分類をセット
        $_SESSION['setYear']=2003;
        $_SESSION['season']="spr";
        $_SESSION['class']="tyou";
        // 編集フラグセッションの初期化
        $_SESSION['TransFlag']=false;
        $_SESSION['position']="0,0";
        $_SESSION['changedNumber']=null;
        $_SESSION['type']=0;
        $_SESSION['Return']=null;
        $_SESSION["edit"] = [
            'flag'=>False,
            'TOPMenu'=>False,
            'SIDEMenu'=>False,
            'topPage' =>False,
            'infoPage' =>False,
            'linkList'=>[],
            'ImageList'=>[],
            'ImageDelete'=>[]
        ];
        for($i=0;$i<=50;$i++){
            $_SESSION["edit"]['linkList'][$i]=False;
        }
        for($i=0;$i<=200;$i++){
            $_SESSION["edit"]['ImageList'][$i]=False;
        }
        for($i=0;$i<=200;$i++){
            $_SESSION["edit"]['ImageDelete'][$i]=False;
        }
        // ログイン時をセット
        $_SESSION['last_login_time'] = date('Y-m-d H:i:s');
        
        // ログイン完了後に 遷移元各編集に遷移
            $tmp = transion_source();
            header('Location: '.$tmp);
            echo "ログインに成功しました。リンクをクリックしてページ移動してください。<br> <a href='${tmp}'>編集用ページ</a>";
            echo <<<EOD
            <script>
            sleep(5);
            window.location.href = '$tmp';
            </script>
            EOD;
            ob_flush();
            flush();
            exit;
    }
    // 認証が失敗したとき
    http_response_code(403);
}
header('Content-Type: text/html; charset=UTF-8');
//$pass="";
//echo password_hash($pass, PASSWORD_BCRYPT);
?>
<!DOCTYPE html>
<html lang="ja" dir="ltr">
<head>
<meta charset="UTF-8">
<meta name="robots" content="noindex">
<title>ログインページ</title>
</head>
<body>
<h1>ログインしてください</h1>
<form method="post" action="">
    ユーザ名: <input type="text" name="username" value="">
    パスワード: <input type="password" name="password" value="">
    <input type="hidden" name="token" value="<?=h(generate_token())?>">
    <input type="submit" value="ログイン">
</form>
<?php if (http_response_code() === 403): ?>
<p style="color: red;">ユーザ名またはパスワードが違います</p>
<?php endif; ?>
</body>
</html>
