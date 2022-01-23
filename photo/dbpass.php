<?php
//db_set
//db name pass
require_once __DIR__ . '/functions.php';
//SQL文格納配列
$sqlSTRings =[
  'id_load_hash'=> "SELECT * FROM `users` WHERE id = :id;",
  'load_Tmenu'  => "SELECT `name`, `url` FROM `top_header_menu`;",
  'load_hmenu'  => "SELECT `name`, `url` FROM `header_menu`;",
  'load_smenu1' => "SELECT `name`, `url` FROM `side_menu1`;",
  'load_smenu2' => "SELECT `name`, `url` FROM `side_menu2`;",
  'load_smenu3' => "SELECT `name`, `url` FROM `side_menu3`;",
  'load_smenu4' => "SELECT `name`, `url` FROM `side_menu4`;",
  'load_topImg'=> "SELECT `No`, `imgName`, `imgComment`, `imgUpdate` FROM `top_image_data`;",
  'load_links'=> "SELECT `No`, `HP_name`, `HP_url`, `friend_name`, `comment` FROM `link_data`;",
  'load_info'=> "SELECT `No`,`since`, `info1`, `info2`, `info3`, `info4`, `date` FROM `top_info`;",
  'load_mainImg_tyou'=> "SELECT `No`, `title`, `img_name`, `time`, `comment`, `Year`, `Seasons`, `Class`, `link_name`, `link_url` FROM `tyou_img_data` WHERE Year = :y and Seasons = :s;",
  'load_mainImg_kino'=> "SELECT `No`, `title`, `img_name`, `time`, `comment`, `Year`, `Seasons`, `Class`, `link_name`, `link_url` FROM `kino_img_data` WHERE Year = :y and Seasons = :s;",
  'load_mainImg_yacy'=> "SELECT `No`, `title`, `img_name`, `time`, `comment`, `Year`, `Seasons`, `Class`, `link_name`, `link_url` FROM `yacy_img_data` WHERE Year = :y and Seasons = :s;",
  'load_mainImg_plan'=> "SELECT `No`, `title`, `img_name`, `time`, `comment`, `Year`, `Seasons`, `Class`, `link_name`, `link_url` FROM `plan_img_data` WHERE Year = :y and Seasons = :s;",
  'load_mainImg_dog' => "SELECT `No`, `title`, `img_name`, `time`, `comment`, `Year`, `Seasons`, `Class`, `link_name`, `link_url` FROM `dog_img_data`  WHERE Year = :y and Seasons = :s;",
  'load_mainImg_flow'=> "SELECT `No`, `title`, `img_name`, `time`, `comment`, `Year`, `Seasons`, `Class`, `link_name`, `link_url` FROM `flow_img_data` WHERE Year = :y and Seasons = :s;",
  'load_mainImg_tea' => "SELECT `No`, `title`, `img_name`, `time`, `comment`, `Year`, `Seasons`, `Class`, `link_name`, `link_url` FROM `tea_img_data`  WHERE Year = :y and Seasons = :s;",
  'load_mainImg_trav'=> "SELECT `No`, `title`, `img_name`, `time`, `comment`, `Year`, `Seasons`, `Class`, `link_name`, `link_url` FROM `trav_img_data` WHERE Year = :y and Seasons = :s;",
  'load_mainImg_fiel'=> "SELECT `No`, `title`, `img_name`, `time`, `comment`, `Year`, `Seasons`, `Class`, `link_name`, `link_url` FROM `fiel_img_data` WHERE Year = :y and Seasons = :s;",
  'load_Tyears1'=> "SELECT DISTINCT `Seasons`,`Year` FROM `tyou_img_data` ORDER BY `Seasons`;",
  'load_Tyears2'=> "SELECT DISTINCT `Seasons`,`Year` FROM `kino_img_data` ORDER BY `Seasons`;",
  'load_Tyears3'=> "SELECT DISTINCT `Seasons`,`Year` FROM `yacy_img_data` ORDER BY `Seasons`;",
  'load_Tyears4'=> "SELECT DISTINCT `Seasons`,`Year` FROM `plan_img_data` ORDER BY `Seasons`;",
  'load_Tyears5'=> "SELECT DISTINCT `Seasons`,`Year` FROM `dog_img_data`  ORDER BY `Seasons`;",
  'load_Tyears6'=> "SELECT DISTINCT `Seasons`,`Year` FROM `flow_img_data` ORDER BY `Seasons`;",
  'load_Tyears7'=> "SELECT DISTINCT `Seasons`,`Year` FROM `tea_img_data`  ORDER BY `Seasons`;",
  'load_Tyears8'=> "SELECT DISTINCT `Seasons`,`Year` FROM `trav_img_data` ORDER BY `Seasons`;",
  'load_Tyears9'=> "SELECT DISTINCT `Seasons`,`Year` FROM `fiel_img_data` ORDER BY `Seasons`;",
  'load_Tyears_class'=> "SELECT DISTINCT `Seasons`,`Year`,`Class` FROM `image_data` WHERE `Class` = :c ORDER BY `Seasons`;",
  'load_Tmenu2'=> "SELECT DISTINCT Year FROM `image_data` WHERE Seasons = :season;",
  'id_update_time' => "UPDATE users SET last_login_time = :tm WHERE id = :id;",
  'no_update_link'=>"UPDATE `link_data` SET `HP_name`=:name,`HP_url`=:url,`friend_name`=:frie,`comment`=:comm WHERE `No`=:no;",
  'no_update_top' => "UPDATE top_image_data SET imgName = :name, imgComment = :comm WHERE No = :no;",
  'no_update_time' => "UPDATE top_image_data SET imgUpdate = :time WHERE No = 0;",
  'no_update_info' => "UPDATE `top_info` SET `since`=:since,`info1`=:in1,`info2`=:in2,`info3`=:in3,`info4`=:in4,`date`=:date WHERE `No`=1;",
  'no_update_hmenu' => "UPDATE header_menu SET name = :name, url = :url WHERE No = :no;",
  'no_update_smenu1' => "UPDATE side_menu1 SET name = :name, url = :url WHERE No = :no;",
  'no_update_smenu2' => "UPDATE side_menu2 SET name = :name, url = :url WHERE No = :no;",
  'no_update_smenu3' => "UPDATE side_menu3 SET name = :name, url = :url WHERE No = :no;",
  'no_update_img' => "UPDATE image_data SET title = :title, img = :img, comment = :comment WHERE No = :no;"
];
//db_load
// -----呼び出しSQL_実行( key(検索キー), 書き込みデータset(set1,set2), SQL文格納配列, 戻り値flag：1アリ0ナシ)  
function calSQL_Execution($key, $set, $sqlSnt,$rFlag){
  global $sqlSTRings;
  global $setYear;
  global $season;
  global $class;
  $setYear=is_null($setYear)?2003:$setYear;
  $season=is_null($season)?"spr":$season;
  $class=is_null( $class)?"tyou": $class;

  //return SQLSETTING;
  $output=array();
  $output['output']="";
  try{
    //文字エンコーディングを必ず指定する(5.6対応)
    $dbh = new PDO(SQLSETTING, USERNAME, PASSWORD,
          array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
                PDO::ATTR_EMULATE_PREPARES => false));
    //var_dump($dbh->errorInfo());
    $stmt = $dbh->prepare($sqlSnt);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    // SQL文に値を代入
    switch($sqlSnt){
      case $sqlSTRings['id_load_hash']:
        $a = $key;
        $stmt->bindValue(':id', $a, PDO::PARAM_STR);
        break;

      case $sqlSTRings['load_hmenu']:
        // 代入なし
        break;

      case $sqlSTRings['load_Tmenu']:
        // 代入なし
        break;

      case $sqlSTRings['load_smenu1']:
        // 代入なし
        break;

      case $sqlSTRings['load_smenu2']:
        // 代入なし
        break;

      case $sqlSTRings['load_smenu3']:
        // 代入なし
        break;

      case $sqlSTRings['load_smenu4']:
        // 代入なし
        break;

        case $sqlSTRings['load_topImg']:
          // 代入なし
          break;
  
      case $sqlSTRings['load_Tyears1']:
      case $sqlSTRings['load_Tyears2']:
      case $sqlSTRings['load_Tyears3']:
      case $sqlSTRings['load_Tyears4']:
      case $sqlSTRings['load_Tyears5']:
      case $sqlSTRings['load_Tyears6']:
      case $sqlSTRings['load_Tyears7']:
      case $sqlSTRings['load_Tyears8']:
      case $sqlSTRings['load_Tyears9']:
        // 代入なし
        break;

      case $sqlSTRings['load_links']:
      // 代入なし
      break;

      case $sqlSTRings['load_info']:
      // 代入なし
      break;

      case $sqlSTRings['no_update_info']:
      // 代入info
      $a = $set[0];
      $stmt->bindValue(':since', $a, PDO::PARAM_STR);
      $b = $set[1];
      $stmt->bindValue(':in1', $b, PDO::PARAM_STR);
      $c = $set[2];
      $stmt->bindValue(':in2', $c, PDO::PARAM_STR);
      $d = $set[3];
      $stmt->bindValue(':in3', $d, PDO::PARAM_STR);
      $e = $set[4];
      $stmt->bindValue(':in4', $e, PDO::PARAM_STR);
      $f = $set[5];
      $stmt->bindValue(':date', $f, PDO::PARAM_STR);
      break;

      case $sqlSTRings['load_Tyears_class']:
      // 代入class
      $a = $key;
      $stmt->bindValue(':c', $a, PDO::PARAM_STR);      
      break;

      case $sqlSTRings['no_update_link']:
      // 代入link
      $a = $key;
      $stmt->bindValue(':no', $a, PDO::PARAM_STR);
      $b = $set[0];
      $stmt->bindValue(':name', $b, PDO::PARAM_STR);
      $c = $set[1];
      $stmt->bindValue(':url', $c, PDO::PARAM_STR);
      $d = $set[2];
      $stmt->bindValue(':frie', $d, PDO::PARAM_STR);
      $e = $set[3];
      $stmt->bindValue(':comm', $e, PDO::PARAM_STR);
      break;

      case $sqlSTRings['load_Tmenu2']:
      // 代入season
      $a = $key;
      $stmt->bindValue(':season', $a, PDO::PARAM_STR);      
      break;

      case $sqlSTRings['load_mainImg_tyou']:
      // 代入	photo.php $setYear,	$season
      $a = $setYear;
      $stmt->bindValue(':y', $a, PDO::PARAM_STR);
      $b = $season;
      $stmt->bindValue(':s', $b, PDO::PARAM_STR);
      break;

      case $sqlSTRings['load_mainImg_kino']:
      // 代入	photo.php $setYear,	$season
      $a = $setYear;
      $stmt->bindValue(':y', $a, PDO::PARAM_STR);
      $b = $season;
      $stmt->bindValue(':s', $b, PDO::PARAM_STR);
      break;

      case $sqlSTRings['load_mainImg_yacy']:
        // 代入	photo.php $setYear,	$season
        $a = $setYear;
        $stmt->bindValue(':y', $a, PDO::PARAM_STR);
        $b = $season;
        $stmt->bindValue(':s', $b, PDO::PARAM_STR);
      break;

      case $sqlSTRings['load_mainImg_plan']:
        // 代入	photo.php $setYear,	$season
        $a = $setYear;
        $stmt->bindValue(':y', $a, PDO::PARAM_STR);
        $b = $season;
        $stmt->bindValue(':s', $b, PDO::PARAM_STR);
      break;

      case $sqlSTRings['load_mainImg_dog']:
        // 代入	photo.php $setYear,	$season
        $a = $setYear;
        $stmt->bindValue(':y', $a, PDO::PARAM_STR);
        $b = $season;
        $stmt->bindValue(':s', $b, PDO::PARAM_STR);
      break;

      case $sqlSTRings['load_mainImg_flow']:
        // 代入	photo.php $setYear,	$season
        $a = $setYear;
        $stmt->bindValue(':y', $a, PDO::PARAM_STR);
        $b = $season;
        $stmt->bindValue(':s', $b, PDO::PARAM_STR);
      break;

      case $sqlSTRings['load_mainImg_tea']:
        // 代入	photo.php $setYear,	$season
        $a = $setYear;
        $stmt->bindValue(':y', $a, PDO::PARAM_STR);
        $b = $season;
        $stmt->bindValue(':s', $b, PDO::PARAM_STR);
      break;

      case $sqlSTRings['load_mainImg_trav']:
        // 代入	photo.php $setYear,	$season
        $a = $setYear;
        $stmt->bindValue(':y', $a, PDO::PARAM_STR);
        $b = $season;
        $stmt->bindValue(':s', $b, PDO::PARAM_STR);
      break;

      case $sqlSTRings['load_mainImg_fiel']:
        // 代入	photo.php $setYear,	$season
        $a = $setYear;
        $stmt->bindValue(':y', $a, PDO::PARAM_STR);
        $b = $season;
        $stmt->bindValue(':s', $b, PDO::PARAM_STR);
      break;

      case $sqlSTRings['id_update_time']:
        $a = $key;
        $stmt->bindValue(':id', $a, PDO::PARAM_STR);
        $b = $set[0];
        $stmt->bindValue(':tm', $b, PDO::PARAM_STR);
        break;

      case $sqlSTRings['no_update_hmenu']:
        $a = $key;
        $stmt->bindValue(':no', $a, PDO::PARAM_STR);
        $b = $set[1];
        $stmt->bindValue(':name', $b, PDO::PARAM_STR);
        $c = $set[0];
        $stmt->bindValue(':url', $c, PDO::PARAM_STR);
        break;

      case $sqlSTRings['no_update_smenu1']:
        $a = $key;
        $stmt->bindValue(':no', $a, PDO::PARAM_STR);
        $b = $set[0];
        $stmt->bindValue(':name', $b, PDO::PARAM_STR);
        $c = $set[1];
        $stmt->bindValue(':url', $c, PDO::PARAM_STR);
        break;

      case $sqlSTRings['no_update_smenu2']:
        $a = $key;
        $stmt->bindValue(':no', $a, PDO::PARAM_STR);
        $b = $set[0];
        $stmt->bindValue(':name', $b, PDO::PARAM_STR);
        $c = $set[1];
        $stmt->bindValue(':url', $c, PDO::PARAM_STR);
        break;
            
      case $sqlSTRings['no_update_smenu3']:
        $a = $key;
        $stmt->bindValue(':no', $a, PDO::PARAM_STR);
        $b = $set[0];
        $stmt->bindValue(':name', $b, PDO::PARAM_STR);
        $c = $set[1];
        $stmt->bindValue(':url', $c, PDO::PARAM_STR);
        break;

      case $sqlSTRings['no_update_top']:
        $a = $key;
        $stmt->bindValue(':no', $a, PDO::PARAM_STR);
        $b = $set[0];
        $stmt->bindValue(':name', $b, PDO::PARAM_STR);
        $c = $set[1];
        $stmt->bindValue(':comm', $c, PDO::PARAM_STR);
        break;

      case $sqlSTRings['no_update_time']:
        $b = $set[0];
        $stmt->bindValue(':time', $b, PDO::PARAM_STR);
        break;
  
      default:
        break;
    }
    //SQL実行
    $stmt->execute();
    //err
    //var_dump($stmt->errorInfo());
    //フラグが1なら出力処理
    $output_row=[];
    if($rFlag==1){
      $sum=0;
      while ($row = $stmt->fetch()) {
        foreach($row as $key=>$tmp){
          $output_row[$sum][$key]=$tmp;
        }
        $sum++;
      }
      $output=array_merge_recursive($output, $output_row);
      if(count($output)==1){
        $output['output'] .= "エラーです";
      }
    }
    $dbh = null;
  } catch(PDOException $e){
    $output['output'] .= $e->getMessage();
  }finally{
    $output['output'] .= "func_end";
  }
  return $output;
}
?>
