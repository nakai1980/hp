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
//編集ページのセット
$EditPage="top_edit";
//db値をセット=GETで表示変動がない為
require_once __DIR__ . '/dbset.php';

//name set
$name = h($_SESSION['username']);
//表示位置の初期化、linkListは50枚まで
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

// 表示位置
$position =h($_SESSION['position']);
$_SESSION['position']="0,0";

if(isset($_SESSION['edit'])){ $Edit = $_SESSION['edit'];}
//編集フラグの処理
$linkFlag=FALSE;
foreach($Edit['linkList'] as $key=>$val){
	if($val){
		$linkFlag=TRUE;
	}
}
if($Edit['SIDEMenu']==False && $Edit['topPage']==False 
&& $Edit['infoPage']==False && $linkFlag==FALSE){
		$Edit['flag']=False;
		$_SESSION['edit']['flag']=False;
}

//編集ページのセット
$EditPage="top";

//GETメソッド
$menus_str=[0=>"top_edit",1=>"info_edit",2=>"link_edit"];
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	//エラーになりそうなnullをはじく
	$_GET = delete_null_byte($_GET);
	//0～2まで
	$get_menu = filter_input(INPUT_GET, 'm', FILTER_VALIDATE_INT, [
		"options" => [
		"default" => 0,
		"max_range" => 2,
		"min_range" => 0
		]
	]);
	$EditPage=$menus_str[$get_menu];
}

// POSTメソッドのときのみ実行
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	//エラーになりそうなnullをはじく
	$_POST = delete_null_byte($_POST);

	//表示位置取得
	$type = filter_input(INPUT_POST, 'types');
	$position_name = "position".$type ;
	$position = is_null(filter_input(INPUT_POST, $position_name))? $position:filter_input(INPUT_POST, $position_name);
	$_SESSION['position']=$position;
	$_SESSION['setYear']=$setYear;
	$_SESSION['season']=$season;

	//どこの送信ボタンか？
	$flags = filter_input(INPUT_POST, 'sender');
	switch($flags){
		case "SIDEMenu編集":
			//Edit flag
			$Edit['SIDEMenu']=True;
			$_SESSION['edit']['SIDEMenu']=True;
			$Edit['flag']=True;
			$_SESSION['edit']['flag']=True;
			reloadfunction("writetop");
			exit;
		break;
		//--main_編集
		case "トップページを編集する":
			$Edit['topPage']=True;
			$_SESSION['edit']['topPage']=True;
			$Edit['flag']=True;
			$_SESSION['edit']['flag']=True;
			reloadfunction("writetop");
			exit;
		break;
		//--link編集
		case "このリンクを編集する":
			$_SESSION['type']=$type;
			$Edit['linkList'][$type]=True;
			$_SESSION['edit']['linkList'][$type]=True;
			$Edit['flag']=True;
			$_SESSION['edit']['flag']=True;
			reloadfunction("writetop");
			exit;
		break;
		//--インフォ編集
		case "あいさつを編集する":
			$Edit['infoPage']=True;
			$_SESSION['edit']['infoPage']=True;
			$Edit['flag']=True;
			$_SESSION['edit']['flag']=True;
			reloadfunction("writetop");
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
        // 最初にmenuにターゲットをあてる
        //var tmp_url = location.hash;
        //if(!tmp_url) window.location.hash = "#menu0";
    </script>
</body>
</html>