<?php
$title = 'My Site Top';
$description = 'Cover of the content';
$Edit = [];
$Edit['flag']=False;
$Edit['TOPMenu']=False;
$Edit['SIDEMenu']=False;

require_once __DIR__ . '/functions.php';
transion_source_edit();
//読込み画面表示
//Loadwaite();
//編集ページのセット
$EditPage="top";
$menus_str=[0=>"top",1=>"info",2=>"link"];
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	//エラーになりそうなnullをはじく
	$_GET = delete_null_byte($_GET);
	//3～20まで
	$get_menu = filter_input(INPUT_GET, 'm', FILTER_VALIDATE_INT, [
		"options" => [
			"default" => 0,
			"max_range" => 2,
			"min_range" => 0
			]
	]);
	$EditPage=$menus_str[$get_menu];
}
//db値をセット
require_once __DIR__ . '/dbset.php';
include 'inc/head.php'; // head.php の読み込み
?>
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
        // 最初にmenuにターゲットをあてる
        var tmp_url = location.search;
        if(!tmp_url) window.location.search = "?m=0";
        tmp_url = location.hash;
        if(!tmp_url) window.location.hash = "#menu0";
    </script>
</body>
</html>