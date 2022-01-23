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
	$_SESSION['setYear']=$setYear;
	$_SESSION['season']=$season;
	$_SESSION['class']=$class;
}
$setYear=isset($_SESSION['setYear'])?h($_SESSION['setYear']):$setYear;
$season=isset($_SESSION['season'])?h($_SESSION['season']):$season;
$class=isset($_SESSION['class'])?h($_SESSION['class']):$class;
//db値をセット
require_once __DIR__ . '/dbset.php';
//データのイメージセットcommentの表示からタグを省いておく
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
$type= isset($_SESSION['type'])? $_SESSION['type']: 1;
//トップページフラグがあれば$EditPage変更
if($Edit['topPage']==True){
	$EditPage="top_edit";
}elseif($Edit['linkList'][$type]==True){
	$EditPage="link_edit";
}elseif($Edit['infoPage']==True){
	$EditPage="info_edit";
}
// POSTメソッドのときのみ実行
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	//エラーになりそうなnullをはじく
	$_POST = delete_null_byte($_POST);
	//表示位置取得
	$type = filter_input(INPUT_POST, 'types');
	$_SESSION['setYear']=$setYear;
	$_SESSION['season']=$season;

	//どこの送信ボタンか？
	$flags = filter_input(INPUT_POST, 'sender');
	switch($flags){
		case "SIDEMenu更新":
			//no_update_smenuの呼び出し
			sidedbset($sqlSTRings);
			$Edit['SIDEMenu']=False;
			$_SESSION['edit']['SIDEMenu']=False;
			$tmp= isset($_SESSION['Return'])? $_SESSION['Return']: "topEdit";
			if(isset($_SESSION['Return']))$_SESSION['Return']=null;
			reloadfunction($tmp);
			exit;
		break;
		case "SIDEMenuの更新をやめる":
			$Edit['SIDEMenu']=False;
			$_SESSION['edit']['SIDEMenu']=False;
			$tmp= isset($_SESSION['Return'])? $_SESSION['Return']: "topEdit";
			if(isset($_SESSION['Return']))$_SESSION['Return']=null;
			reloadfunction($tmp);
			exit;
		break;
		//--link更新
		case "この内容でリンクを更新する":
			//更新
			linkdbset($sqlSTRings);
			$Edit['linkList'][$type]=False;
			$_SESSION['edit']['linkList'][$type]=False;
			//$reloadFlag=1;
			reloadfunction("topEdit");
			exit;
		break;
		//--link更新中止
		case "このリンクの更新をやめる":
			//中止
			$Edit['linkList'][$type]=False;
			$_SESSION['edit']['linkList'][$type]=False;
			//$reloadFlag=1;
			reloadfunction("topEdit");
			exit;
		break;
		//--インフォ編集
		case "このあいさつで更新する":
			infodbset($sqlSTRings);
			$Edit['infoPage']=False;
			$_SESSION['edit']['infoPage']=False;
			//$reloadFlag=1;
			reloadfunction("topEdit");
			exit;
		break;
		case "あいさつの更新をやめる":
			$Edit['infoPage']=False;
			$_SESSION['edit']['infoPage']=False;
			//$reloadFlag=1;
			reloadfunction("topEdit");
			exit;
		break;
		//--top更新
		case "この内容で更新する":
            //top画像の更新
			topdbset($sqlSTRings);
			$Edit['topPage']=False;
			$_SESSION['edit']['topPage']=False;
			//$reloadFlag=1;
			reloadfunction("topEdit");
			exit;
		break;
		case "TOPの更新をやめる":
            //top画像の更新
			$Edit['topPage']=False;
			$_SESSION['edit']['topPage']=False;
			//$reloadFlag=1;
			reloadfunction("topEdit");
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
	<!-- headerEdit.php の読み込み -->
	<?php
		//$top_menu_urlをメニューにセット
		include 'inc/headerEdit.php';
	?>
    <div class="logout mainEdit">
		<p><?php echo $name;?>さんが編集中…
        <a href="./logout.php?token=<?=h(generate_token())?>">編集を終える</a></p>
    </div>
	<div class="main_box">
		<div class="content">
			<!-- sideEdit.php の読み込み -->
			<?php
				//$side_menu_urlをメニューにセット
				include 'inc/sideEdit.php';
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