<?php
require_once __DIR__ . '/functions.php';
require_logined_session();
header('Expires: Tue, 1 Jan 2019 00:00:00 GMT');
header('Last-Modified:' . gmdate( 'D, d M Y H:i:s' ) . 'GMT');
header("Cache-Control:no-cache,no-store,must-revalidate,max-age=0");
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header("Pragma:no-cache");
header('Content-Type: text/html; charset=UTF-8');
//表示年をセット
$setYear=2003;
//表示季節をセット
$season='spr';
$seasonArray=array("","spr","sum","aut","win");
//表示分類をセット
$class='tyou';
$classArray=array("","tyou","kino","yacy","plan","dog","flow","tea","trav","fiel");
//編集ページのセット
$EditPage="write_edit";
//表示場所
$outputNum=$_SESSION['type'];
//読込み画面表示
//Loadwaite();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	//エラーになりそうなnullをはじく
	$_GET = delete_null_byte($_GET);
	//3～20まで
	$get_Year = filter_input(INPUT_GET, 'y', FILTER_VALIDATE_INT, [
	"options" => [
		"default" => 3,
		"max_range" => 20,
		"min_range" => 0
		]
	]);
	$get_Year +=2000;//2000年代に修正
	//1～4まで
	$get_Season = filter_input(INPUT_GET, 's', FILTER_VALIDATE_INT, [
	"options" => [
		"default" => 1,
		"max_range" => 4,
		"min_range" => 1
		]
	]);
	//1～9まで
	//"","tyou","kino","yacy","plan","dog","flow","tea","trav","fiel"
	$get_Class = filter_input(INPUT_GET, 'c', FILTER_VALIDATE_INT, [
	"options" => [
		"default" => 1,
		"max_range" => 9,
		"min_range" => 1
		]
	]);
	$setYear=$get_Year;
	$season=$seasonArray[$get_Season];
	$class=$classArray[$get_Class];
	//セッションに記憶
	$_SESSION['setYear']=$setYear;
	$_SESSION['season']=$season;
	$_SESSION['class']=$class;
}
//セッション記憶の引き出し
$setYear=isset($_SESSION['setYear'])?h($_SESSION['setYear']):$setYear;
$season=isset($_SESSION['season'])?h($_SESSION['season']):$season;
$class=isset($_SESSION['class'])?h($_SESSION['class']):$class;
//db値をセット
require_once __DIR__ . '/dbset.php';
foreach($imgSets as $key=>$val){
	$imgSets[$key]['comment']=ResanitizeBR($val['comment']);
}
//name set
$name = h($_SESSION['username']);
//表示位置の初期化
Transion_check("off");
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
if(isset($_SESSION['edit'])){ $Edit = $_SESSION['edit'];}

// POSTメソッドのときのみ実行
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	//エラーになりそうなnullをはじく
	$_POST = delete_null_byte($_POST);
	//表示位置取得
	$type = filter_input(INPUT_POST, 'types');
	//セッションに記憶
	$_SESSION['setYear']=$setYear;
	$_SESSION['season']=$season;
	//
	//どこの送信ボタンか？
	$flags = filter_input(INPUT_POST, 'sender');
	switch($flags){
		//--main更新
		case "ImageList".$type."更新":
			maindbset($sqlSTRings);
			NumStorage();//編集番号
			$Edit['ImageList'][$type]=False;
			$_SESSION['edit']['ImageList'][$type]=False;
			reloadfunction("photoEdit");
			exit;
		break;
		case "ImageList".$type."の更新をやめる":
			NumStorage();
			$Edit['ImageList'][$type]=False;
			$_SESSION['edit']['ImageList'][$type]=False;
			reloadfunction("photoEdit");
			exit;
		break;
		//--新規画像
		case "新規写真投稿":
			maindbset($sqlSTRings);
			NumStorage();
			$Edit['ImageList'][0]=False;
			$_SESSION['edit']['ImageList'][0]=False;
			reloadfunction("photoEdit");
			exit;
		break;
		case "新規投稿をやめる":
			NumStorage();
			$Edit['ImageList'][0]=False;
			$_SESSION['edit']['ImageList'][0]=False;
			reloadfunction("photoEdit");
			exit;
		break;
		//--main画像削除
		case "この投稿を削除する":
            //ナンバーを受け取り削除
			deleteData($class);
			$Edit['ImageDelete'][$type]=False;
			$_SESSION['edit']['ImageDelete'][$type]=False;
			reloadfunction("photoEdit");
			exit;
		break;
		//--削除中止
		case "削除を止める":
            //削除中断
			NumStorage();
			$Edit['ImageDelete'][$type]=False;
			$_SESSION['edit']['ImageDelete'][$type]=False;
			reloadfunction("photoEdit");
			exit;
		break;
	}
}
?>
<?php
$title = 'My Site Top';
$description = 'Cover of the content';
include 'inc/head.php'; // head.php の読み込み
?>
<body>
	<!-- header.php の読み込み -->
	<?php
		//$top_menu_urlをメニューにセット
		include 'inc/header.php';
	?>
    <div class="logout">
		<p><?php echo $name;?>さんが編集中…
        <a href="./logout.php?token=<?=h(generate_token())?>">編集を終える</a></p>
    </div>
	<div class="main_box">
		<div class="content">
			<!-- side.php の読み込み -->
			<?php
				//$side_menu_urlをメニューにセット
				include 'inc/side.php';
			?>
			<!-- mainEdit.php の読込み -->
			<?php 
				//$imgSetsをメインにセット
				include 'inc/mainEdit.php';
			?>
		</div>
	</div>
	<?php 
		include 'inc/footer.php';
	?>
    <script>
        // 最初にtest1にターゲットをあてる
        var tmp_url = location.hash;
        if(!tmp_url) window.location.hash = "#test1";
    </script>
</body>
</html>