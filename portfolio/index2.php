<?php

require_once __DIR__ . '/function.php';
$cssinclude = external_cssfiles("index.php"); 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cssinclude = external_cssfiles_name("index2.php");
    echo "CSSを{$cssinclude}に切り替えました。";
    exit();
}

?>
<!DOCTYPE html>
<html lang="ja" dir="ltr">
<head>
<meta charset="UTF-8">
<meta name="robots" content="noindex">
<?php echo $cssinclude; ?>
<title>サンプルページ</title>
</head>
<body>
    <header><h1>サンプルページ[PHPによるCSS生成] </h1></header>
    <nav>
        <ul>
            <li class="linkset"><a href="index.php">MySQL操作</a></li>
            <li class="linkset"><a href="index2.php">PHPによるCSS生成</a></li>
        </ul>
    </nav>
    <main id="mainbg">
        <form id="form"><input id="button" type="button" value="CSSを新たに生成" /></form><br/>
        <div id="result"></div>
    </main>
    <footer>&copy;Copyright Nakai.2022</footer>
    <script>
        window.addEventListener('load', function() {
            const cssUrl = document.getElementById("css").href;
            document.getElementById('result').textContent = "現在のCSSファイル : "+ cssUrl;
        });
        document.getElementById('button').addEventListener('click', function (e) {
            let data = new FormData(document.getElementById('form'));
            fetch('index2.php', {
                method: 'POST',
                body: data,
            })
                .then(function (response) {
                    return response.text();
                })
                .then(function (data) {
                    document.getElementById('result').textContent = data;
                    let tmp = data.split('"');
                    let csshref = tmp[1];
                    document.getElementById("css").href = csshref;
                })
                .catch(function (error) {
                    document.getElementById('result').textContent = error;
                })
        }, false)
    </script>
</body>
</html>
