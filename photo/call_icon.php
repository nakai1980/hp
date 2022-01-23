<?php
require_once __DIR__ . '/functions.php';
//メインコンテンツ用
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  //エラーになりそうな文字をはじく
  //menu_icon
    $get_icon = filter_input(INPUT_GET, 'icon', FILTER_VALIDATE_INT, [
    "options" => [
        "default" => 1,
        "max_range" => 9,
        "min_range" => 1
    ]
    ]);
    if($get_icon!=null){
        $pdo = new PDO(SQLSETTING, USERNAME, PASSWORD);
        $sql = "SELECT `img` FROM `top_header_menu` WHERE `No` = :no;";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':no', $get_icon, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //var_dump($stmt->errorInfo());
        //var_dump($result);
        $image = $result[0];
        header( "Content-Type: image/png" );
        echo $image["img"];
    }
}
?>