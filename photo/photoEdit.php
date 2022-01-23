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
$EditPage="photo";
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
	$_SESSION['setYear']=$setYear;
	$_SESSION['season']=$season;
	$_SESSION['class']=$class;
}
$setYear=isset($_SESSION['setYear'])?h($_SESSION['setYear']):$setYear;
$season=isset($_SESSION['season'])?h($_SESSION['season']):$season;
$class=isset($_SESSION['class'])?h($_SESSION['class']):$class;
//db値をセット
require_once __DIR__ . '/dbset.php';
//データがあるかチェック、なければ一番古いデータの表示、問題なければ同じデータを反す
list($setYear,$season,$class) = dispChk($setYear,$season,$class);
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
	'ImageList'=>[],
	'ImageDelete'=>[],
];
for($i=0;$i<=50;$i++){
	$Edit['linkList'][$i]=False;
}
for($i=0;$i<=200;$i++){
	$Edit['ImageList'][$i]=False;
}
for($i=0;$i<=200;$i++){
	$Edit['ImageDelete'][$i]=False;
}

//表示位置をずらすか？
$position_flag = "false";
$position_target = "";
if(isset($_SESSION['changedNumber'])){
	//変更のあった番号が記憶されていればずらす。
	$No = $_SESSION['changedNumber'];
	$position_flag = "true";
	$position_target = WhereWillChangbe($setYear, $season, $class, $No);
	$_SESSION['changedNumber']=null;
}
//編集フラグの同期
if(isset($_SESSION['edit'])){
	$Edit['flag']=$_SESSION['edit']['flag'];
	$Edit['SIDEMenu']=$_SESSION['edit']['SIDEMenu'];
	$Edit['topPage']=$_SESSION['edit']['topPage'];
	$Edit['infoPage']=$_SESSION['edit']['infoPage'];
	//リストは初期化
	$_SESSION['edit']['ImageList']=$Edit['ImageList'];
	$_SESSION['edit']['ImageDelete']=$Edit['ImageDelete'];
	$_SESSION['edit']['linkList']=$Edit['linkList'];
}
//編集フラグの処理
if($Edit['SIDEMenu']==False){
		$Edit['flag']=False;
		$_SESSION['edit']['flag']=False;
}

// POSTメソッドのときのみ実行
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	//エラーになりそうなnullをはじく
	$_POST = delete_null_byte($_POST);
	//表示位置取得
	$type = filter_input(INPUT_POST, 'types');
	$_SESSION['type'] = $type;
	//格納
	$_SESSION['setYear']=$setYear;
	$_SESSION['season']=$season;

	//reload flag
	$reloadFlag=0;

	//どこの送信ボタンか？
	$flags = filter_input(INPUT_POST, 'sender');
	switch($flags){
		case "SIDEMenu編集":
			//Edit flag
			$Edit['SIDEMenu']=True;
			$_SESSION['edit']['SIDEMenu']=True;
			$Edit['flag']=True;
			$_SESSION['edit']['flag']=True;
			$_SESSION['Return']="photoEdit";
			reloadfunction("writetop");
			exit;
		break;
		//--main_編集
		case "ImageList".$type."編集":
			$Edit['ImageList'][$type]=True;
			$_SESSION['edit']['ImageList'][$type]=True;
			$Edit['flag']=True;
			$_SESSION['edit']['flag']=True;
			$_SESSION['type'] = $type;
			reloadfunction("writephoto");
			exit;
		break;
		//--main_削除
		case "ImageList".$type."削除":
			$Edit['ImageDelete'][$type]=True;
			$_SESSION['edit']['ImageDelete'][$type]=True;
			//flagは削除だけ
			$_SESSION['type'] = $type;
			reloadfunction("writephoto");
			exit;
		break;
		//--新規画像
		case "写真の新規投稿":
			$Edit['ImageList'][0]=True;
			$_SESSION['edit']['ImageList'][0]=True;
			$Edit['flag']=True;
			$_SESSION['edit']['flag']=True;
			$_SESSION['type'] = $type;
			reloadfunction("writephoto");
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
			<!-- main.php の読込み -->
			<?php 
				//$imgSetsをメインにセット
				include 'inc/main.php';
			?>
		</div>
	</div>
	<?php 
		include 'inc/footer.php';
	?>
    <script>
        // 最初にphoto1にターゲットをあてる
        var tmp_url = location.hash;
        if(!tmp_url) window.location.hash = "#photo1";
    </script>
</body>
</html>
