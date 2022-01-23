<?php
//db name pass
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/dbpass.php';

// db読み取り トップヘッダーメニュー
$Loadsql = calSQL_Execution(null, null, $sqlSTRings['load_Tmenu'],1);
//$top_menu_url = array_column($Loadsql, "name","url");
unset($Loadsql["output"]);
$top_menu_url=$Loadsql;

// db読み取り トップヘッダーメニュー2 年タブ取得
// class毎に生成、表示時はメニュー番号(for文の$n)で適応
$top_menu2_year=[];
$top_menu3_year=[];
//フラグを全部オフ
$seasonAry = ['spr', 'sum', 'aut', 'win'];
$classAry = ["tyou","kino","yacy","plan","dog","flow","tea","trav","fiel"];
foreach($seasonAry as $tmp2){
    foreach($classAry as $tmp1){
        for($i=2003;$i<2022;$i++){
            $top_menu3_year[$tmp1][$tmp2][$i]=false;
        }
    }
}
// 9sqlをロードして順番に1つの配列にぶち込んでいく
$Loadsql[1] = calSQL_Execution(null, null, $sqlSTRings['load_Tyears1'],1);
unset($Loadsql[1]["output"]);
$Loadsql[2] = calSQL_Execution(null, null, $sqlSTRings['load_Tyears2'],1);
unset($Loadsql[2]["output"]);
$Loadsql[3] = calSQL_Execution(null, null, $sqlSTRings['load_Tyears3'],1);
unset($Loadsql[3]["output"]);
$Loadsql[4] = calSQL_Execution(null, null, $sqlSTRings['load_Tyears4'],1);
unset($Loadsql[4]["output"]);
$Loadsql[5] = calSQL_Execution(null, null, $sqlSTRings['load_Tyears5'],1);
unset($Loadsql[5]["output"]);
$Loadsql[6] = calSQL_Execution(null, null, $sqlSTRings['load_Tyears6'],1);
unset($Loadsql[6]["output"]);
$Loadsql[7] = calSQL_Execution(null, null, $sqlSTRings['load_Tyears7'],1);
unset($Loadsql[7]["output"]);
$Loadsql[8] = calSQL_Execution(null, null, $sqlSTRings['load_Tyears8'],1);
unset($Loadsql[8]["output"]);
$Loadsql[9] = calSQL_Execution(null, null, $sqlSTRings['load_Tyears9'],1);
unset($Loadsql[9]["output"]);
//$top_menu_url = array_column($Loadsql, "name","url");

for($i=1;$i<10;$i++){
    foreach ($Loadsql[$i] as $key => $value) {
        $top_menu2_year[$i][$value["Seasons"]][$value["Year"]]=$value["Year"];
    }
}
//表示可能データをフラグ立て
$classArySTR = ["","tyou","kino","yacy","plan","dog","flow","tea","trav","fiel"];
for($j=1;$j<10;$j++){
    foreach ($Loadsql[$j] as $key => $value) {
        $tmp2=$value["Seasons"];
        $tmp3=$value["Year"];
        $top_menu3_year[ $classArySTR[$j] ][ $tmp2 ][ $tmp3 ]=true;
    }
}

// db読み取り トップヘッダーメニュー3 年タブ取得_class絞り込み使用不可
$Loadsql = calSQL_Execution($class, null, $sqlSTRings['load_Tyears_class'],1);
//$top_menu_url = array_column($Loadsql, "name","url");
unset($Loadsql["output"]);
$top_menu4_year=[];
//forで回して取得
for($i=0;$i<count($Loadsql);$i++){
    $top_menu4_year[$Loadsql[$i]["Seasons"]][$i]=$Loadsql[$i]["Year"];
}


// db読み取り メインヘッダーメニュー
$Loadsql = calSQL_Execution(null, null, $sqlSTRings['load_hmenu'],1);
//$header_menu_url = array_column($Loadsql, "name","url");
unset($Loadsql["output"]);
$header_menu_url=$Loadsql;

// db読み取り サイドドロップダウンメニュー1
$Loadsql = calSQL_Execution(null, null, $sqlSTRings['load_smenu1'],1);
unset($Loadsql["output"]);
$side_menu_url[1]=$Loadsql;

// db読み取り サイドドロップダウンメニュー2
$Loadsql = calSQL_Execution(null, null, $sqlSTRings['load_smenu2'],1);
unset($Loadsql["output"]);
$side_menu_url[2]=$Loadsql;

// db読み取り サイドドロップダウンメニュー3
$Loadsql = calSQL_Execution(null, null, $sqlSTRings['load_smenu3'],1);
unset($Loadsql["output"]);
$side_menu_url[3]=$Loadsql;

// db読み取り サイドドロップダウンメニュー4
$Loadsql = calSQL_Execution(null, null, $sqlSTRings['load_smenu4'],1);
unset($Loadsql["output"]);
$side_menu_url[4]=$Loadsql;

// db読み取り あいさつ
$Loadsql = calSQL_Execution(null, null, $sqlSTRings['load_info'],1);
unset($Loadsql["output"]);
$top_info_txt=$Loadsql;

// db読み取り リンクメニュー
$Loadsql = calSQL_Execution(null, null, $sqlSTRings['load_links'],1);
unset($Loadsql["output"]);
$links_list_txt=$Loadsql;

// db読み取り トップイメージ写真説明
$Loadsql = calSQL_Execution(null, null, $sqlSTRings['load_topImg'],1);
unset($Loadsql["output"]);
$topSets=$Loadsql;

// db読み取り 写真のテキストリスト作成
//("","tyou","kino","yacy","plan","dog","flow","tea","trav","fiel");
switch($class){
    case "tyou":
        $Loadsql = calSQL_Execution(null, null, $sqlSTRings['load_mainImg_tyou'],1);
        break;
    case "kino":
        $Loadsql = calSQL_Execution(null, null, $sqlSTRings['load_mainImg_kino'],1);
        break;
    case "yacy":
        $Loadsql = calSQL_Execution(null, null, $sqlSTRings['load_mainImg_yacy'],1);
        break;
    case "plan":
        $Loadsql = calSQL_Execution(null, null, $sqlSTRings['load_mainImg_plan'],1);
        break;
    case "dog":
        $Loadsql = calSQL_Execution(null, null, $sqlSTRings['load_mainImg_dog'],1);
        break;
    case "flow":
        $Loadsql = calSQL_Execution(null, null, $sqlSTRings['load_mainImg_flow'],1);
        break;
    case "tea":
        $Loadsql = calSQL_Execution(null, null, $sqlSTRings['load_mainImg_tea'],1);
        break;
    case "trav":
        $Loadsql = calSQL_Execution(null, null, $sqlSTRings['load_mainImg_trav'],1);
        break;
    case "fiel":
        $Loadsql = calSQL_Execution(null, null, $sqlSTRings['load_mainImg_fiel'],1);
        break;
}
unset($Loadsql["output"]);
// エラー対応、データがないなら入れとく
if($Loadsql){
    $imgSets=$Loadsql;
    //改行のセット
    foreach($imgSets as $key=>$imgSet){
        $imgSets[$key]["comment"]=sanitizeBR($imgSet["comment"]);
    }
}else{
    $imgSets[0]=[
        "No"=>1,
        "title"=>"No_data",
        "img_name"=>"No_data",
        "time"=>"2003-01-01 01:00",
        "comment"=>"No_data",
        "Year"=>"2003",
        "Seasons"=>"spr",
        "Class"=>"tyou"
    ];
}
/**
 *header db
 * ヘッダーメニューのデータベースセット(改定中)
 **/
function headerdbset($sqlSTRings){
    //no_update_hmenuの呼び出し
	$name1 = filter_input(INPUT_POST, 'name1');
	$name2 = filter_input(INPUT_POST, 'name2');
	$name3 = filter_input(INPUT_POST, 'name3');
	$name4 = filter_input(INPUT_POST, 'name4');
	$name5 = filter_input(INPUT_POST, 'name5');
	$url1 = filter_input(INPUT_POST, 'url1');
	$url2 = filter_input(INPUT_POST, 'url2');
	$url3 = filter_input(INPUT_POST, 'url3');
	$url4 = filter_input(INPUT_POST, 'url4');
	$url5 = filter_input(INPUT_POST, 'url5');
	$top_menu_url = array(
		array($url1, $name1),
		array($url2, $name2),
		array($url3, $name3),
		array($url4, $name4),
		array($url5, $name5)
	);
	$tmp=0;
	foreach($header_menu_url as $set){
		calSQL_Execution($tmp,$set, $sqlSTRings['no_update_hmenu'],0);
		$tmp++;
	}
}
/**
 *sider db
 * サイドメニューのデーターベースセット
 **/
function sidedbset($sqlSTRings){
    //no_update_smenuの呼び出し
    $title = array("","title1","title2","title3");
    $title[1] = filter_input(INPUT_POST, "title1");
	$name11 = filter_input(INPUT_POST, 'name11');
	$name12 = filter_input(INPUT_POST, 'name12');
	$name13 = filter_input(INPUT_POST, 'name13');
	$name14 = filter_input(INPUT_POST, 'name14');
	$name15 = filter_input(INPUT_POST, 'name15');
	$url11 = filter_input(INPUT_POST, 'url11');
	$url12 = filter_input(INPUT_POST, 'url12');
	$url13 = filter_input(INPUT_POST, 'url13');
	$url14 = filter_input(INPUT_POST, 'url14');
	$url15 = filter_input(INPUT_POST, 'url15');
    $side1_menu0_url =array("title",$title[1] );
    $side1_menu1_url =array($name11,$url11 );
    $side1_menu2_url =array($name12,$url12 );
    $side1_menu3_url =array($name13,$url13 );
    $side1_menu4_url =array($name14,$url14 );
    $side1_menu5_url =array($name15,$url15 );
    $side1_menu_url =array(
        $side1_menu0_url,
        $side1_menu1_url,
        $side1_menu2_url,
        $side1_menu3_url, 
        $side1_menu4_url,
        $side1_menu5_url
    );
    $title[2] = filter_input(INPUT_POST, "title2");
	$name21 = filter_input(INPUT_POST, 'name21');
	$name22 = filter_input(INPUT_POST, 'name22');
	$name23 = filter_input(INPUT_POST, 'name23');
	$name24 = filter_input(INPUT_POST, 'name24');
	$name25 = filter_input(INPUT_POST, 'name25');
	$name26 = filter_input(INPUT_POST, 'name26');
	$name27 = filter_input(INPUT_POST, 'name27');
	$name28 = filter_input(INPUT_POST, 'name28');
	$name29 = filter_input(INPUT_POST, 'name29');
	$url21 = filter_input(INPUT_POST, 'url21');
	$url22 = filter_input(INPUT_POST, 'url22');
	$url23 = filter_input(INPUT_POST, 'url23');
	$url24 = filter_input(INPUT_POST, 'url24');
	$url25 = filter_input(INPUT_POST, 'url25');
	$url26 = filter_input(INPUT_POST, 'url26');
	$url27 = filter_input(INPUT_POST, 'url27');
	$url28 = filter_input(INPUT_POST, 'url28');
	$url29 = filter_input(INPUT_POST, 'url29');
    $side2_menu0_url =array("title",$title[2] );
    $side2_menu1_url =array($name21,$url21);
    $side2_menu2_url =array($name22,$url22);
    $side2_menu3_url =array($name23,$url23);
    $side2_menu4_url =array($name24,$url24);
    $side2_menu5_url =array($name25,$url25);
    $side2_menu6_url =array($name26,$url26);
    $side2_menu7_url =array($name27,$url27);
    $side2_menu8_url =array($name28,$url28);
    $side2_menu9_url =array($name29,$url29);
    $side2_menu_url =array(
        $side2_menu0_url,
        $side2_menu1_url,
        $side2_menu2_url,
        $side2_menu3_url, 
        $side2_menu4_url,
        $side2_menu5_url,
        $side2_menu6_url,
        $side2_menu7_url,
        $side2_menu8_url,
        $side2_menu9_url
    );
    $title[3] = filter_input(INPUT_POST, "title3");
	$name31 = filter_input(INPUT_POST, 'name31');
	$name32 = filter_input(INPUT_POST, 'name32');
	$name33 = filter_input(INPUT_POST, 'name33');
	$name34 = filter_input(INPUT_POST, 'name34');
	$name35 = filter_input(INPUT_POST, 'name35');
	$url31 = filter_input(INPUT_POST, 'url31');
	$url32 = filter_input(INPUT_POST, 'url32');
	$url33 = filter_input(INPUT_POST, 'url33');
	$url34 = filter_input(INPUT_POST, 'url34');
	$url35 = filter_input(INPUT_POST, 'url35');
    $side3_menu0_url =array("title",$title[3] );
    $side3_menu1_url =array($name31,$url31);
    $side3_menu2_url =array($name32,$url32);
    $side3_menu3_url =array($name33,$url33);
    $side3_menu4_url =array($name34,$url34);
    $side3_menu5_url =array($name35,$url35);
    $side3_menu_url =array(
        $side3_menu0_url,
        $side3_menu1_url,
        $side3_menu2_url,
        $side3_menu3_url, 
        $side3_menu4_url,
        $side3_menu5_url
    );
    $side_menu_url =array(
        $side1_menu_url,
        $side2_menu_url,
        $side3_menu_url
    );
    //dbsetting
	$tmp1=0;
    foreach($side_menu_url[0] as $set){
        calSQL_Execution($tmp1, $set, $sqlSTRings['no_update_smenu1'],0);
        $tmp1++;
    }
	$tmp1=0;
    foreach($side_menu_url[1] as $set){
        calSQL_Execution($tmp1, $set, $sqlSTRings['no_update_smenu2'],0);
        $tmp1++;
    }
	$tmp1=0;
    foreach($side_menu_url[2] as $set){
        calSQL_Execution($tmp1, $set, $sqlSTRings['no_update_smenu3'],0);
        $tmp1++;
    }
}
/**
 * info db  
 *  あいさつのデータベースセット 
 * `top_info` `since`,`info1`,`info2`,`info3`,`info4`,`date`,`No`,`img`
 **/
function infodbset($sqlSTRings){
    //post 画像データを配列で受け取り
    $filedata = inPOST_Files();
    //画像$filedataに情報が入ってる(投稿がない場合もある)
    $file = (is_array($filedata) && empty($filedata))? null :$filedata[0];
    //リンクの表示位置番号
    $No = 1;
    //since
    $since = filter_input(INPUT_POST, 'since');
    //info
    $info1 = filter_input(INPUT_POST, 'info1');
    $info2 = filter_input(INPUT_POST, 'info2');
    $info3 = filter_input(INPUT_POST, 'info3');
    $info4 = filter_input(INPUT_POST, 'info4');
    //date
    $date = filter_input(INPUT_POST, 'date');
    //2回に分けて保存、1)テキストデータのみ、2)画像データがあれば
    //1)テキストデータ
    $set = array($since, $info1, $info2, $info3, $info4, $date);
    calSQL_Execution($No, $set, $sqlSTRings['no_update_info'],0);
    //2)画像データ
    if(is_null($file)){
            //ここで終了
            return;
    }else{
        $file_name=$file["tmp_name"];
        $file_type = mime_content_type($file_name);
        $img;
        $img_str="";
        // 画像タイプで出力
        switch($file_type){
            case "image/gif":
            $img=imagecreatefromgif($file_name);
            $img_str="./img/tmp.gif";
            chmod($img_str, 0666);
            imagegif($img, $img_str);
            break;
            case "image/jpeg":
            $img=imagecreatefromjpeg($file_name);
            $img_str="./img/tmp.jpg";
            chmod($img_str, 0666);
            imagejpeg($img, $img_str);
            break;
            case "image/png":
            $img=imagecreatefrompng($file_name);
            $img_str="./img/tmp.png";
            chmod($img_str, 0666);
            imagepng($img, $img_str);
            break;
            default;
        }
        $fp = fopen($img_str, "rb");
        $tmpdate = fread($fp, filesize($img_str));
        fclose($fp);
        //imgが空じゃなければ
        if(isset($img)){
            //データベースに格納
            $sql = "UPDATE `top_info` SET `img` = :img WHERE `link_data`.`No` = 1;";
            $params=[
                ':img'=>['value'=>$image_binary, 'param'=>'lob']
            ];
            $stmt=sqlPDOexe($sql, $params);
        }
        //イメージデータの削除
        imagedestroy($img);
        return $stmt;
    }
}
/**
 * link db $links_list_txt $type 
 * リンクリストのデータベースセット 
 * `No``img``HP_name``HP_url``friend_name``comment`
 **/
function linkdbset($sqlSTRings){
    //post 画像データを配列で受け取り
    $filedata = inPOST_Files();
    //画像$filedataに情報が入ってる(投稿がない場合もある)
    $file = (is_array($filedata) && empty($filedata))? null :$filedata[0];
    //リンクの表示位置番号
    $No = filter_input(INPUT_POST, 'types');
    //HPの名前
    $HP_name = filter_input(INPUT_POST, 'HP_name'.$No);
    //HPのurl
    $HP_url = filter_input(INPUT_POST, 'HP_url'.$No);
    //友人の名前
    $friend_name = filter_input(INPUT_POST, 'friend_name'.$No);
    //リンクのコメント
    $comment = filter_input(INPUT_POST, 'comment'.$No);
    //2回に分けて保存、1)テキストデータのみ、2)画像データがあれば
    //1)テキストデータ
    $set = array($HP_name, $HP_url, $friend_name, $comment);
    calSQL_Execution($No, $set, $sqlSTRings['no_update_link'],0);
    //2)画像データ
    if(is_null($file)){
            //ここで終了
            return;
    }else{
        $file_name=$file["tmp_name"];
        $file_type = mime_content_type($file_name);
        $img;
        $img_str="";
        // 画像タイプで出力
        switch($file_type){
            case "image/gif":
            $img=imagecreatefromgif($file_name);
            $img_str="./img/tmp.gif";
            chmod($img_str, 0666);
            imagegif($img, $img_str);
            break;
            case "image/jpeg":
            $img=imagecreatefromjpeg($file_name);
            $img_str="./img/tmp.jpg";
            chmod($img_str, 0666);
            imagejpeg($img, $img_str);
            break;
            case "image/png":
            $img=imagecreatefrompng($file_name);
            $img_str="./img/tmp.png";
            chmod($img_str, 0666);
            imagepng($img, $img_str);
            break;
            default;
        }
        $fp = fopen($img_str, "rb");
        $tmpdate = fread($fp, filesize($img_str));
        fclose($fp);
        //imgが空じゃなければ
        if(isset($img)){
            //データベースに格納
            $sql = "UPDATE `link_data` SET `img` = :img WHERE `link_data`.`No` = :no;";
            $params=[
                ':no'  =>['value'=>$No, 'param'=>'int'],
                ':img' =>['value'=>$image_binary, 'param'=>'lob']
            ];
            $stmt = sqlPDOexe($sql, $params);
        }
        //イメージデータの削除
        imagedestroy($img);
        return $stmt;
    }
}
/**
 *top img db
 * トップイメージのデータベースセット
 **/
function topdbset($sqlSTRings){
    //post 画像データを配列で受け取り
    $filedata = inPOST_Files();
    //日時保管
    $timestamp = time();
    //月0ナシ
    $month = date("n", $timestamp);
    global $topSets;
    //セレクトボックスimgselect
    $imgselect = filter_input(INPUT_POST, 'imgselect');
    //画像の名前imgName
    $imgName = filter_input(INPUT_POST, 'imgName');
    //画像のコメントimgComment
    $imgComment = filter_input(INPUT_POST, 'imgComment');
    //画像$filedataに情報が入ってる(投稿がない場合もある)
    $file = (is_array($filedata) && empty($filedata))? null :$filedata[0];
    //更新日imgUpdate(これは必ずNo.0に格納)
    $imgUpdate = filter_input(INPUT_POST, 'imgUpdate');
    //３回に分けて保存、1)テキストデータのみ、2)更新日時、3)画像データがあれば
    //1)テキストデータ
    $no = $imgselect;
    $set = array($imgName, $imgComment);
    calSQL_Execution($no, $set, $sqlSTRings['no_update_top'],0);
    //2)更新日時
    $no = 0;
    $time = strtotime($imgUpdate);
    $strtime =date("Y-m-d",$time);
    $set = array($strtime);
    calSQL_Execution($no, $set, $sqlSTRings['no_update_time'],0);
    //3)画像データ
    $no = $imgselect;
    if(is_null($file)){
            //ここで終了
            return;
    }else{
        $file_name=$file["tmp_name"];
        $file_type = mime_content_type($file_name);
        // 画像をリサイズして出力
        $img = ResizeImage($file_name);
        if(isset($img)){
            ob_start();
            imagepng($img, null, 9); //バッファを作る為
            $image_binary = ob_get_clean();
            //データベースに格納
            $sql = "UPDATE `top_image_data` SET `img` = :img WHERE `top_image_data`.`No` = :no;";
            $params=[
                ':no'  =>['value'=>$no, 'param'=>'int'],
                ':img' =>['value'=>$image_binary, 'param'=>'lob']
            ];
            $stmt=sqlPDOexe($sql, $params);
        }
        //イメージデータの削除
        imagedestroy($img);
        return $stmt;
    }
}
/**
 *main img db
 * メインコンテンツの写真データセット
 **/
function maindbset($sqlSTRings){
    $output="";
    //post 画像データを配列で受け取り
    $filedata = inPOST_Files();
    global $imgSets;
    global $setYear;
    global $season;
    global $class;
    //どこで呼ばれたか
    $flags = filter_input(INPUT_POST, 'sender');
    $type = filter_input(INPUT_POST, 'types');
    $No;
    if($type!=0){
        $num = $type - 1;
        $No = $imgSets[$num]["No"];
    }
    switch($flags){
		case "ImageList".$type."更新":
            $file = $filedata ? $filedata :null;
			$title = filter_input(INPUT_POST, 'title'.$type);
            $img_name = $filedata ? $filedata[0]["name"] :null;
            $time= filter_input(INPUT_POST, 'date'.$type);
            $comment = filter_input(INPUT_POST, 'comment'.$type);
            $setYearstr= filter_input(INPUT_POST, 'year'.$type);
            $setYearstr= is_null($setYearstr)? $_SESSION['setYear']: $setYearstr;
            $seasonSelect=filter_input(INPUT_POST, 'seasonSelect'.$type);
            $output = setJpgtmp($No,$file,$title,$img_name,$time,$comment,$setYearstr,$seasonSelect,$class);
	    	break;

		case "新規写真投稿":
            $file = $filedata ? $filedata :null;
			$title = h(filter_input(INPUT_POST, 'title0'));
            $img_name = $filedata ? $filedata[0]["name"] :null;
            $time= filter_input(INPUT_POST, 'date0');
            $comment = h(filter_input(INPUT_POST, 'comment0'));
            $setYear= filter_input(INPUT_POST, 'year0');
            $setYear= is_null($setYear)? $_SESSION['setYear']: $setYear;
            $seasonSelect=filter_input(INPUT_POST, 'seasonSelect0');
            $output = setJpgtmp(null,$file,$title,$img_name,$time,$comment,$setYear,$seasonSelect,$class);
	    	break;
    }
}
/**
 * ファイルフォーマットをjpgにしてdbに保存
 **/
function setJpgtmp($No,$file,$title,$img_name,$time,$comment,$yearstr,$season,$class){
    // 空ファイル？
    $flags = $file ? true : false;
    if(!$flags){
        //空なら文字列のみの更新
        $timeArr=[];
        $tmpArr=[];
        $time=mb_convert_kana($time,"as");
        $time=str_replace("-","_",$time);
        $time=str_replace(" ","",$time);
        if(strpos($time,"_")){
            $tmpArr=explode("_",$time);
        }
        $timeArr["Y"]=$tmpArr[0];
        $timeArr["m"]=$tmpArr[1];
        $timeArr["d"]=$tmpArr[2];
        if(count($tmpArr)==4){
            $timeArr["H"]=$tmpArr[3];
        }else{
            $timeArr["H"]="00";
        }
        $time=$timeArr["Y"]."-".$timeArr["m"]."-".$timeArr["d"]." ".$timeArr["H"].":00";
        $time = date( "Y-m-d H:i:s" , strtotime($time) );
        //データベース選択
        $sql = "INSERT INTO `".$class."_img_data`(`No`, `title`, `time`, `comment`, `Year`, `Seasons`, `Class`) VALUES(:No, :title, :time, :comment,
        :year, :season, :class) ON DUPLICATE KEY UPDATE `No` = VALUES(`No`),`title` = VALUES(`title`), `time` = VALUES(`time`),
        `comment` = VALUES(`comment`), `Year` = VALUES(`Year`), `Seasons` = VALUES(`Seasons`), `Class` = VALUES(`Class`);";
        $params=[
            ':No'     =>['value'=>$No,     'param'=>'int'],
            ':title'  =>['value'=>$title,  'param'=>'str'],
            ':time'   =>['value'=>$time,   'param'=>'str'],
            ':comment'=>['value'=>$comment,'param'=>'str'],
            ':year'   =>['value'=>$yearstr,'param'=>'int'],
            ':season' =>['value'=>$season, 'param'=>'str'],
            ':class'  =>['value'=>$class,  'param'=>'str']
        ];
        sqlPDOexe($sql, $params);
    }else{
        //ファイルのフォーマットを取得
        $file=$file[0];
        $file_name=$file["tmp_name"];
        $file_type = mime_content_type($file_name);
        $mime = 'image/jpeg';
        $img;
    
        //画像がjpgなら撮影日時を取得、取れないならfilemtime
        if($time =="0000_00_00_00"){
            if($file_type=='image/jpeg'){
                $exifdata = exif_read_data($file_name, 0, true);
                if(is_array($exifdata)){
                    $time = isset($exifdata["EXIF"]['DateTimeOriginal']) ? $exifdata["EXIF"]['DateTimeOriginal'] : "";
                }
            }
            if($time ==""){
                $time = filemtime($file_name);
            }
        }else{
            $timeArr=[];
            $tmpArr=[];
            $time=mb_convert_kana($time,"as");
            $time=str_replace("-","_",$time);
            $time=str_replace(" ","",$time);
            if(strpos($time,"_")){
                $tmpArr=explode("_",$time);
            }
            $timeArr["Y"]=$tmpArr[0];
            $timeArr["m"]=$tmpArr[1];
            $timeArr["d"]=$tmpArr[2];
            if(count($tmpArr)==4){
                $timeArr["H"]=$tmpArr[3];
            }else{
                $timeArr["H"]="00";
            }
            $time=$timeArr["Y"]."-".$timeArr["m"]."-".$timeArr["d"]." ".$timeArr["H"].":00:00";
        }
        $time = date( "Y-m-d H:i:s" , strtotime($time) );

        // 画像をリサイズして再出力
        $img = ResizeImage($file_name);
        if(isset($img)){
            ob_start();
            imagepng($img, null, 9); //バッファを作る為
            $image_binary = ob_get_clean();
            //データベースに格納
            if(is_null($No)){
                //ナンバーがないならROW+1で作成する
                $No = tableRows($class);
                $No = (int)$No[0] +1;
                $No = (string)$No;
            }
            $sql = "INSERT INTO `".$class."_img_data`(`No`,`title`, `img`, `mimetype`, `img_name`, `time`, `comment`, `Year`, `Seasons`, `Class`)
            VALUES(:No, :title, :img, :mime, :name, :time, :comment, :year, :season, :class) ON DUPLICATE KEY UPDATE 
            `title` = VALUES(`title`), `img` = VALUES(`img`), `time` = VALUES(`time`),
            `comment` = VALUES(`comment`), `Year` = VALUES(`Year`), `Seasons` = VALUES(`Seasons`), `Class` = VALUES(`Class`);";
            $params=[
                ':No'     =>['value'=>$No,      'param'=>'int'],
                ':title'  =>['value'=>$title,   'param'=>'str'],
                ':img'    =>['value'=>$image_binary, 'param'=>'lob'],
                ':mime'   =>['value'=>$mime,    'param'=>'str'],
                ':name'   =>['value'=>$img_name,'param'=>'str'],
                ':time'   =>['value'=>$time,    'param'=>'str'],
                ':comment'=>['value'=>$comment, 'param'=>'str'],
                ':year'   =>['value'=>$yearstr, 'param'=>'int'],
                ':season' =>['value'=>$season,  'param'=>'str'],
                ':class'  =>['value'=>$class,   'param'=>'str']
            ];
            $stmt=sqlPDOexe($sql, $params);
        }
        //イメージデータの削除
        imagedestroy($img);
        return $stmt;
    }
}
/**
 * post画像受け取り マルチデータは止める
 * formは enctype="multipart/form-data" method="POST"
 * type="file" name="image[]"配列送信
 */
function inPOST_Files(){
    $files1 = $_FILES;
    $files2 = [];
    $files3 = [];
    foreach ($files1 as $inpType => $infoArr) {
        $fileSet = [];
        foreach($infoArr as $key=>$valueS){
            //ファイルが複数？
            if(is_array($valueS)){
                foreach($valueS as $i=>$value){
                    $fileSet[$i][$key] = $value;
                }
            }else{
                $fileSet[] = $infoArr;
                break;
            }
        }
        //配列型に固定
        $files2 = array_merge($files2, $fileSet);
    }
    //ERRチェック
    foreach($files2 as $file){
        if (!$file['error']){
            $files3[] = $file;
        }
    }
    
    return $files3;
}
/**
 * テーブルのデータ数を取得
 * テーブルのデータ数が膨大なので重い…
 */
function tableRows($class_str){
    $table_name = $class_str."_img_data";
    $row=[];
    //画像データ数
    $pdo = new PDO(SQLSETTING, USERNAME, PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT MAX(`No`) as `No` FROM ".$table_name.";";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();;
    while($buff = $stmt->fetch(PDO::FETCH_ASSOC)){
        $row[] = $buff['No'];
    }
    return $row;
}
/**
 * 画像のリサイズを行い出力
 * リサイズサイズは関数内に
 * ファイル出力は重いのでペンディング
 * イメージデータで返す
 */
function ResizeImage($tmp_name){
    //画像のデータを取得
    $data = @getimagesize($tmp_name);
    //画像処理に使う関数名を決定する
    $create = str_replace('/', 'createfrom', $data['mime']);
    $output = str_replace('/', '', $data['mime']);
    //元画像リソースを生成する
    $src = @$create($tmp_name);
    //画像の縦横,拡張子を取得
    $w = $data[0];
    $h = $data[1];
    $type = image_type_to_extension($data[2]);
    //保存する画像のサイズ
    $dst_w = 800;
    $dst_h = 520;
    //初期化
    $sttX = 0;
    $sttY = 0;
    $src_w = $w;
    $src_h = $h;
    //保存する画像に対する元画像の比率
    $per_w = $w/$dst_w;
    $per_h = $h/$dst_h;
    $per_dif = $per_w - $per_h;
    if($w <= $dst_w && $h <= $dst_h){ //　どちらも規定以下ならそのまま保存
        $dst_w = $w;
        $dst_h = $h;
    }elseif($per_w === $per_h) { // 縦横比が規定と等しければそのまま縮小
    //何もしない
    }else{
        //縦横どちらも大きければいったん縮小して保存
        if ($per_w > 1 && $per_h > 1) {
            if ($per_dif > 0) { 
                //縦に合わせて縮小
                $src_w = $w / $per_h;
                $src_h = $dst_h;
            } else {
                //横に合わせて縮小
                $src_w = $dst_w;
                $src_h = $h / $per_w;
            }
            //リサンプリング先画像リソースを生成する
            $dst = imagecreatetruecolor($src_w, $src_h);
            //getimagesize関数で得られた情報も利用してリサンプリングを行う
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $src_w, $src_h, $w, $h);
            //一旦tmpとして保存
            chmod("./img/temp".$type, 0666);
            $output($dst,'./img/temp'.$type);
            // tempを元画像としてリソースを再生成
            $src = @$create('./img/temp'.$type);
        }
        //横が$dst_wより大きければ中心点から始点を計算
        if($src_w > $dst_w) {
            $sttX = ($src_w - $dst_w)/2;
            $src_w = $dst_w;
        }else{
            $dst_w = $src_w;
        }
        //縦が$dst_hより大きければ中心点から始点を計算
        if($src_h > $dst_h) {
            $sttY = ($src_h - $dst_h)/2;
            $src_h = $dst_h;
        }else{
            $dst_h = $src_h;
        }
    }
    //リサンプリング先画像リソースを生成する
    $dst = imagecreatetruecolor($dst_w, $dst_h);
    //getimagesize関数で得られた情報も利用してリサンプリングを行う
    imagecopyresampled($dst, $src, 0, 0, $sttX, $sttY, $dst_w, $dst_h, $src_w, $src_h);
    //ファイル名を設定して保存-->後で使うかも
    //$fname = "tmp2";
    //$photo = $fname.$type;
    //chmod("./img/tmp2".$type, 0666);
    //$output($dst,'./img/'.$photo);
    return $dst;
    // リソースを解放
    if (isset($src) && is_resource($src)) {
        imagedestroy($src);
    }
    if (isset($dst) && is_resource($dst)) {
        imagedestroy($dst);
    }
}
/*********** 
 * $flags = filter_input(INPUT_POST, 'sender');
 * sender で再読み込みするデータを読み取り
***********/
function reloadData($flags, $type, $class, $sqlSTRings){
    //共通の処理としてヘッダーメニューの更新
    //項目の変動や表示区域の変更など
    // db読み取り トップヘッダーメニュー2 年タブ取得
    // class毎に生成、表示時はメニュー番号(for文の$n)で適応
    $top_menu2_year=[];
    $top_menu3_year=[];
    //フラグを全部オフ
    $seasonAry = ['spr', 'sum', 'aut', 'win'];
    $classAry = ["tyou","kino","yacy","plan","dog","flow","tea","trav","fiel"];
    foreach($seasonAry as $tmp2){
        foreach($classAry as $tmp1){
            for($i=2003;$i<2022;$i++){
                $top_menu3_year[$tmp1][$tmp2][$i]=false;
            }
        }
    }
    // 9sqlをロードして順番に1つの配列にぶち込んでいく
    $Loadsql[1] = calSQL_Execution(null, null, $sqlSTRings['load_Tyears1'],1);
    unset($Loadsql[1]["output"]);
    $Loadsql[2] = calSQL_Execution(null, null, $sqlSTRings['load_Tyears2'],1);
    unset($Loadsql[2]["output"]);
    $Loadsql[3] = calSQL_Execution(null, null, $sqlSTRings['load_Tyears3'],1);
    unset($Loadsql[3]["output"]);
    $Loadsql[4] = calSQL_Execution(null, null, $sqlSTRings['load_Tyears4'],1);
    unset($Loadsql[4]["output"]);
    $Loadsql[5] = calSQL_Execution(null, null, $sqlSTRings['load_Tyears5'],1);
    unset($Loadsql[5]["output"]);
    $Loadsql[6] = calSQL_Execution(null, null, $sqlSTRings['load_Tyears6'],1);
    unset($Loadsql[6]["output"]);
    $Loadsql[7] = calSQL_Execution(null, null, $sqlSTRings['load_Tyears7'],1);
    unset($Loadsql[7]["output"]);
    $Loadsql[8] = calSQL_Execution(null, null, $sqlSTRings['load_Tyears8'],1);
    unset($Loadsql[8]["output"]);
    $Loadsql[9] = calSQL_Execution(null, null, $sqlSTRings['load_Tyears9'],1);
    unset($Loadsql[9]["output"]);
    for($i=1;$i<10;$i++){
        foreach ($Loadsql[$i] as $key => $value) {
            $top_menu2_year[$i][$value["Seasons"]][$value["Year"]]=$value["Year"];
        }
    }
    //表示可能データをフラグ立て
    $classArySTR = ["","tyou","kino","yacy","plan","dog","flow","tea","trav","fiel"];
    for($j=1;$j<10;$j++){
        foreach ($Loadsql[$j] as $key => $value) {
            $tmp2=$value["Seasons"];
            $tmp3=$value["Year"];
            $top_menu3_year[ $classArySTR[$j] ][ $tmp2 ][ $tmp3 ]=true;
        }
    }
    //フラグによる読み分け
    switch($flags){
		//no_update_smenuの呼び出し
		case "SIDEMenu更新":
			// db読み取り サイドドロップダウンメニュー1
            $Loadsql = calSQL_Execution(null, null, $sqlSTRings['load_smenu1'],1);
            unset($Loadsql["output"]);
            $side_menu_url[1]=$Loadsql;
            // db読み取り サイドドロップダウンメニュー2
            $Loadsql = calSQL_Execution(null, null, $sqlSTRings['load_smenu2'],1);
            unset($Loadsql["output"]);
            $side_menu_url[2]=$Loadsql;
            // db読み取り サイドドロップダウンメニュー3
            $Loadsql = calSQL_Execution(null, null, $sqlSTRings['load_smenu3'],1);
            unset($Loadsql["output"]);
            $side_menu_url[3]=$Loadsql;
            // db読み取り サイドドロップダウンメニュー4
            $Loadsql = calSQL_Execution(null, null, $sqlSTRings['load_smenu4'],1);
            unset($Loadsql["output"]);
            $side_menu_url[4]=$Loadsql;
		break;
		//--main更新
		case "ImageList".$type."更新":
		case "新規写真投稿":
            // db読み取り 写真のテキストリスト作成
            //("","tyou","kino","yacy","plan","dog","flow","tea","trav","fiel");
            $Loadsql = calSQL_Execution(null, null, $sqlSTRings['load_mainImg_'.$class],1);
            unset($Loadsql["output"]);
            // エラー対応、データがないなら入れとく
            if($Loadsql){
                $imgSets=$Loadsql;
            }else{
                $imgSets[0]=[
                    "No"=>1,
                    "title"=>"No_data",
                    "img_name"=>"No_data",
                    "time"=>"2003-01-01 01:00",
                    "comment"=>"No_data",
                    "Year"=>"2003",
                    "Seasons"=>"spr",
                    "Class"=>"tyou"
                ];
            }
		break;
		//--TOP更新
		case "この内容で更新する":
            // db読み取り トップイメージ写真説明
            $Loadsql = calSQL_Execution(null, null, $sqlSTRings['load_topImg'],1);
            unset($Loadsql["output"]);
            $topSets=$Loadsql;
		break;
        //--link更新
        case "この内容でリンクを更新する":
            // db読み取り リンクメニュー
            $Loadsql = calSQL_Execution(null, null, $sqlSTRings['load_links'],1);
            unset($Loadsql["output"]);
            $links_list_txt=$Loadsql;
        break;
		//--インフォ編集
		case "このあいさつで更新する":
            // db読み取り あいさつ
            $Loadsql = calSQL_Execution(null, null, $sqlSTRings['load_info'],1);
            unset($Loadsql["output"]);
            $top_info_txt=$Loadsql;
		break;
    }
}
/**********
 * SQL POD execute
 * $sql="SELECT `img` FROM `image_data` WHERE `No` = :no";
 * $params=[keyString=>['value'=>setValue,'param'=>'srt'or'int'or'bool'or'null'or'lob']]
***************/
function sqlPDOexe($sql, array $params){
    //一般的なパラメタ,date無かったのでSTRで、boolはキャストしないといけないかも
    $prmStr=[
        "str" =>PDO::PARAM_STR,
        "int" =>PDO::PARAM_INT,
        "bool"=>PDO::PARAM_BOOL,
        "null"=>PDO::PARAM_NULL,
        "date"=>PDO::PARAM_STR,
        "lob" =>PDO::PARAM_LOB
    ];
    try{
        $pdo = new PDO(SQLSETTING, USERNAME, PASSWORD);
        //エラー表示
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare($sql);
        foreach($params as $key => $param){
            $stmt->bindValue($key, $param['value'], $prmStr[$param['param']]);
            // $stmt->bindValue($key, $param['value']);
        }
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }catch(PDOException $e){
        echo 'error:' .$e;
        die();
    }
}
/************* 
 * 移動した写真が何番目に表示されるか？
 * スクロールするIDの決定
 * select rank from(
 * select *,(
 * select count(*)+1 from `kino_img_data` where Year=t1.Year and Seasons=t1.Seasons and No<t1.No
 * ) as rank from `kino_img_data` as t1 where Year=2004 and Seasons='sum'
 * ) as t2 where No=12
 * $Y$S は変わった先の年季節、$Cは変更なし表示クラス、$Noはデータの番号
*************/
function WhereWillChangbe($Y, $S, $C, $No){
    $sql="select rank from(
        select *,(
        select count(*)+1 from `".$C."_img_data` where Year=t1.Year and Seasons=t1.Seasons and No<t1.No
        ) as rank from `".$C."_img_data` as t1 where Year=:year and Seasons=:seas
        ) as t2 where No=:no;";
    $params=[
        ':year'=>['value'=>$Y,'param'=>'int'],
        ':seas'=>['value'=>$S,'param'=>'int'],
        ':no'  =>['value'=>$No,'param'=>'int']
    ];
    $stmt=sqlPDOexe($sql, $params);
    $setInt=$stmt[0]["rank"];
    $setInt=(int)$setInt;
    $setPoint= "content".$setInt;
    return $setPoint;
}
/**
 * データの削除
 * DELETE FROM `flow_img_data` WHERE `flow_img_data`.`No` = 
 ***/
function deleteData($C){
    $No= filter_input(INPUT_POST, 'No');
    $sql= "DELETE FROM `".$C."_img_data` WHERE `".$C."_img_data`.`No` = :no";
    $params=[
        ':no'  =>['value'=>$No,'param'=>'int']
    ];
    $stmt= sqlPDOexe($sql, $params);
    return $stmt;
}
?>