<?php

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/dbpass.php';
require_logined_session();

// CSRFトークンを検証
if (!validate_token(filter_input(INPUT_GET, 'token'))) {
    // 「400 Bad Request」
    header('Content-Type: text/plain; charset=UTF-8', true, 400);
    exit('トークンが無効です');
}
// セッションにある時間をセット
$time = array(h($_SESSION['last_login_time']));
$username = h($_SESSION['username']);
// ---------呼び出しSQL_実行( key(username), 書き込みデータ配列, 　SQL文格納配列,　　戻り値flag：0ナシ)  
calSQL_Execution($username,$time, $sqlSTRings['id_update_time'],0);
//遷移元の確保
$tmp = transion_source();
// セッション用Cookieの破棄
setcookie(session_name(), '', 1);
// セッションファイルの破棄
session_destroy();
// ログアウト完了後に $tmp に遷移
echo "ログアウトに成功しました。リンクをクリックしてページ移動してください。<br> <a href='".$tmp."'>通常ページ</a>";
echo <<<EOD
<script>
window.location.href = '$tmp';
</script>
EOD;
ob_flush();
flush();
?>