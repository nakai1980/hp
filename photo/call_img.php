<?php
require_once __DIR__ . '/functions.php';
//メインコンテンツ用
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  //エラーになりそうな文字をはじく
  $get_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, [
    "options" => [
      "default" => null,
      "max_range" => 9999,
      "min_range" => 0
      ]
    ]);
  $className = [1=>"tyou",2=>"kino",3=>"yacy",4=>"plan",5=>"dog",6=>"flow",7=>"tea",8=>"trav",9=>"fiel"];
  $get_class = filter_input(INPUT_GET, 'cl', FILTER_VALIDATE_INT, [
    "options" => [
      "default" => null,
      "max_range" => 9,
      "min_range" => 1
      ]
    ]);
  if($get_id!=null){
    $sql = "SELECT `img` FROM `".$className[$get_class]."_img_data` WHERE `No` = :no;";
    $params = [':no'=>['value'=>$get_id,'param'=>'str']];
    $result = sqlPDOexe($sql, $params);
    $image = $result[0];
    header( "Content-Type: image/jpeg" );
    echo $image["img"];
  }
  //トップページ用
  $get_top = filter_input(INPUT_GET, 'top', FILTER_VALIDATE_INT, [
    "options" => [
      "default" => null,
      "max_range" => 12,
      "min_range" => 0
      ]
    ]);
  if($get_top!=null){
    $sql = "SELECT `img` FROM `top_image_data` WHERE `No` = :no;";
    $params = [':no'=>['value'=>$get_top,'param'=>'str']];
    $result = sqlPDOexe($sql, $params);
    $image = $result[0];
    header( "Content-Type: image/jpeg" );
    echo $image["img"];
  } 
  //link_img
  $get_link = filter_input(INPUT_GET, 'lnk', FILTER_VALIDATE_INT, [
    "options" => [
      "default" => null,
      "max_range" => 99,
      "min_range" => 0
      ]
    ]);
  if($get_link!=null){
    $sql = "SELECT `img` FROM `link_data` WHERE `No` = :no;";
    $params = [':no'=>['value'=>$get_link,'param'=>'str']];
    $result = sqlPDOexe($sql, $params);
    $image = $result[0];
    header( "Content-Type: image/jpeg" );
    echo $image["img"];
  }
  //info_img
  $get_info = filter_input(INPUT_GET, 'inf', FILTER_VALIDATE_INT, [
    "options" => [
      "default" => null,
      "max_range" => 9,
      "min_range" => 1
      ]
    ]);
  if($get_info!=null){
    $sql = "SELECT `img` FROM `top_info` WHERE `No` = :no;";
    $params = [':no'=>['value'=>$get_info,'param'=>'str']];
    $result = sqlPDOexe($sql, $params);
    $image = $result[0];
    header( "Content-Type: image/jpeg" );
    echo $image["img"];
  }
}
/**********
 * SQL POD execute
 * $sql="SELECT `img` FROM `image_data` WHERE `No` = :no";
 * $params=[keyString=>['value'=>setValue,'param'=>'srt'or'int'or'bool'or'null']]
***************/
function sqlPDOexe($sql, array $params){
  //一般的なパラメタ
  $prmStr=[
      "str" =>PDO::PARAM_STR,
      "int" =>PDO::PARAM_INT,
      "bool"=>PDO::PARAM_BOOL,
      "null"=>PDO::PARAM_NULL
  ];
  try{
      $pdo = new PDO(SQLSETTING, USERNAME, PASSWORD);
      //エラー表示
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stmt = $pdo->prepare($sql);
      foreach($params as $key => $param){
          $stmt->bindValue($key, $param['value'], $prmStr[$param['param']]);
      }
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $result;
  }catch(PDOException $e){
      echo 'error' .$e->getMesseage;
      die();
  }
}
?>