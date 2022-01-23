<?php
$title = 'My Site Top';
$description = 'Cover of the content';
$Edit = [];
$Edit['flag']=False;
$Edit['TOPMenu']=False;
$Edit['SIDEMenu']=False;
$EditPage="";
//表示年をセット
$setYear=2003;
//表示季節をセット
$season='spr';
$seasonArray=array("","spr","sum","aut","win");
$class="tyou";
$classArray=array("","tyou","kino","yacy","plan","dog","flow","tea","trav","fiel");
require_once __DIR__ . '/functions.php';
transion_source_edit();
//読込み画面表示
Loadwaite();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	//エラーになりそうなnullをはじく
	$_GET = delete_null_byte($_GET);
	//3～20まで
	$get_Year = filter_input(INPUT_GET, 'y', FILTER_VALIDATE_INT, [
	"options" => [
		"default" => 3,
		"max_range" => 20,
		"min_range" => 3
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
}
//db値をセット
require_once __DIR__ . '/dbset.php';
//ob_end_flush();
//データがあるかチェック、なければ一番古いデータの表示、問題なければ同じデータを反す
list($setYear,$season,$class) = dispChk($setYear,$season,$class);
include 'inc/head.php'; // head.php の読み込み
?>
<script>
	var element1 = document.getElementById('loadend'); 
	var element2 = document.getElementById('loadendbg'); 
	element1.remove();
	element2.remove();
</script>
<body>
	<!-- header.php の読み込み -->
	<?php
		//$top_menu_urlをメニューにセット
		include 'inc/header.php';
	?> 
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
        // 最初にtest1にターゲットをあてる
        var tmp_url = location.hash;
        if(!tmp_url) window.location.hash = "test1";
        if(!tmp_url) window.location.search = "y=3&s=1&c=1";
    </script>
</body>
</html>