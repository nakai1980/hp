<?php
global $position;
global $position_target;
global $position_flag;
global $EditPage;
global $topSets;
global $Edit;
global $class;
global $outputNum;
//表示用
$rows=0;
$timestamp = time();
//月0ナシ
$month = date("n", $timestamp);
$imgID = $topSets[$month]["No"];
$imgName = $topSets[$month]["imgName"];
$imgComment = $topSets[$month]["imgComment"];
$Seasons=["spr"=>"春","sum"=>"夏","aut"=>"秋","win"=>"冬"];
$SeasonNum=["spr"=>1,"sum"=>2,"aut"=>3,"win"=>4];
$imgUpdate=$topSets[0]["imgUpdate"];
$classes=["tyou"=>"蝶","kino"=>"キノコ","yacy"=>"鳥","plan"=>"植物等","dog"=>"愛犬","flow"=>"お花","tea"=>"お茶","trav"=>"旅","fiel"=>"畑"];
$classes_No=["tyou"=>1,"kino"=>2,"yacy"=>3,"plan"=>4,"dog"=>5,"flow"=>6,"tea"=>7,"trav"=>8,"fiel"=>9];
?>
<main class="main" role="main">
    <div class="wrap" id="box">
    <div id="top_menu_sp"><br></div>
        <?php /* 編集フラグがlink_edit(編集)のページを表示 */?>
        <?php if($EditPage=="link_edit"):?>
            <article class="content_top">
                <div class="top_sp">　</div>
                <?php $i=1; foreach($links_list_txt as $link):?>
                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="links">
                            <div class="link_left">
                                <figure><img src="./call_img.php?lnk=<?php echo $link["No"];?>"></figure>
                                <figcaption><a href="<?php echo $link["HP_url"];?>"><?php echo $link["HP_name"];?></a></figcaption>
                            </div>
                            <h2 class="link_name"><?php echo $link["friend_name"];?></h2>
                            <p class="link_text"><?php echo $link["comment"];?></p>
                            <input type="hidden" name="types" value="<?php echo $i; ?>" />
                            <input type="hidden" value="0,0" id="position<?php echo $i; ?>" name="position<?php echo $i; ?>"/>
                            <input type="submit" id="submit<?php echo $i; ?>" class="clickEvent" name="sender" value="このリンクを編集する">
                        </div>
                    </form>
                <?php $i++; $rows=$i;?>
                <?php endforeach;?>
            </article>
            <script>
                /****************
                 * 表示位置の変更
                 ****************/
                window.onload = function (){ window.scrollTo(<?php echo $position; ?>); }
                function clickEvt(){
                    var getWindowScrollPosition = function() {
                        return {
                            x : (typeof window.scrollX !== 'undefined') ? window.scrollX : ((typeof document.documentElement.scrollLeft !== "undefined") ? document.documentElement.scrollLeft : document.body.scrollLeft),
                            y : (typeof window.scrollY !== 'undefined') ? window.scrollY : ((typeof document.documentElement.scrollTop  !== "undefined") ? document.documentElement.scrollTop  : document.body.scrollTop)
                        };
                    };
                    var position = getWindowScrollPosition();
                    //console.log(position);
                    //document.getElementById("position0").value = position["x"]+","+position["y"];
                <?php for($num=1;$num<$rows;$num++): ?>
                    document.getElementById("position<?php echo $num; ?>").value = position["x"]+","+position["y"];
                <?php endfor;?>
                }
                var hoge = document.getElementsByClassName('clickEvent');
                for (var i = 0; i < hoge.length; i++) {
                hoge[i].addEventListener("click", clickEvt, false);
                //console.log('#1');
                }
                window.onbeforeunload =clickEvt;
                
            </script>
        <?php /* 編集フラグがlink(通常)のページを表示 */?>
        <?php elseif($EditPage=="link"):?>
            <article class="content_top">
                <div class="top_sp">　</div>
                <?php foreach($links_list_txt as $link):?>
                    <div class="links">
                        <div class="link_left">
                            <figure><img src="./call_img.php?lnk=<?php echo $link["No"];?>"></figure>
                            <a href="<?php echo $link["HP_url"];?>"></a>
                            <figcaption><?php echo $link["HP_name"];?></figcaption>
                        </div>
                        <h2 class="link_name"><?php echo $link["friend_name"];?></h2>
                        <p class="link_text"><?php echo $link["comment"];?></p>
                    </div>
                <?php endforeach;?>
            </article>  
        <?php /* 編集フラグがinfo_edit(編集)のページを表示 */?>
        <?php elseif($EditPage=="info_edit"):?>
            <article class="content_top">
                <p id="since">since <?php echo $top_info_txt[0]["since"]?></p>
                <hr>
                <div class="top_message">
                    <figure class="left"><img src="/photo/call_img.php?inf=<?php echo $top_info_txt[0]["No"]?>"></figure>
                    <div class="right">
                        <p>　</p>
                        <p>　</p>
                        <p><?php echo $top_info_txt[0]["info1"]?></p>
                        <p><?php echo $top_info_txt[0]["info2"]?></p>
                    </div>
                    <h2 class="toph2">ごあいさつ</h2>
                    <div class="bottom_box">
                        <p><?php echo $top_info_txt[0]["info3"]?></p>
                        <p><?php echo $top_info_txt[0]["info4"]?></p>
                        <p><span><?php echo date('Y年m月d日', strtotime($top_info_txt[0]["date"]))?></span></p>
                    </div>
                </div>
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="submitRight">
                        <input type="submit" id="submit" class="clickEvent" name="sender" value="あいさつを編集する" />
                    </div>
                </form>
            </article>
        <?php /* 編集フラグがinfo(通常)のページを表示 */?>
        <?php elseif($EditPage=="info"):?>
            <article class="content_top">
                <p id="since">since <?php echo $top_info_txt[0]["since"]?></p>
                <hr>
                <div class="top_message">
                    <figure class="left"><img src="/photo/call_img.php?inf=<?php echo $top_info_txt[0]["No"]?>"></figure>
                    <div class="right">
                        <p>　</p>
                        <p>　</p>
                        <p><?php echo $top_info_txt[0]["info1"]?></p>
                        <p><?php echo $top_info_txt[0]["info2"]?></p>
                    </div>
                    <h2 class="toph2">ごあいさつ</h2>
                    <div class="bottom_box">
                        <p><?php echo $top_info_txt[0]["info3"]?></p>
                        <p><?php echo $top_info_txt[0]["info4"]?></p>
                        <p><span><?php echo date('Y年m月d日', strtotime($top_info_txt[0]["date"]))?></span></p>
                    </div>
                </div>
            </article>
        <?php /* 編集フラグがtop(通常)のページを表示 */?>
        <?php elseif($EditPage=="top"):?>
            <article class="content_top">
                <p id="since">since 2003.July</p>
                <hr>
                <div class="top_message">
                    <figure class="left"><img src="/photo/call_img.php?top=<?php echo $imgID;?>"></figure>
                    <div class="right">
                        <h2 class="toph2">蝶とキノコ</h2>
                        <p><br>休日、野山で見つけた。<br> 蝶やキノコなどを 集めてみました。</p>
                        <p id="admin">管理者 ほおじろ<img src="img/gifu.gif" id="gifu"></p>
                    </div>
                    <div class="bottom_box">
                    <p id="bord_top">気まぐれ1枚 : <?php echo $imgName; ?></p>
                    <p id="bord_comment"><?php echo $imgComment; ?></p>
                    <div id="top_bottom_sp"><br></div>
                    <p><img src="http://www.hooziro.com/cgi-bin/g_counter.cgi" id="count"></p>
                    </div>
                </div>
                <div class="update">
                    <p>更新日 : <span><?php echo $imgUpdate; ?></span></p>
                </div>
            </article>
        <?php /* 編集フラグがtop_edit(編集モード)のトップページ表示 */?>
        <?php elseif($EditPage=="top_edit"):?>
            <article class="content_top">
                <p id="since">since 2003.July</p>
                <hr>
                <div class="top_message">
                    <figure class="left"><img src="/photo/call_img.php?top=<?php echo $imgID;?>"></figure>
                    <div class="right">
                        <h2 class="toph2">蝶とキノコ</h2>
                        <p><br>休日、野山で見つけた。<br> 蝶やキノコなどを 集めてみました。</p>
                        <p id="admin">管理者 ほおじろ<img src="img/gifu.gif" id="gifu"></p>
                    </div>
                    <div class="bottom_box">
                    <p id="bord_top">気まぐれ1枚 : <?php echo $imgName; ?></p>
                    <p id="bord_comment"><?php echo $imgComment; ?></p>
                    <div id="top_bottom_sp"><br></div>
                    <p><img src="http://www.hooziro.com/cgi-bin/g_counter.cgi" id="count"></p>
                    </div>
                </div>
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="update">
                        <p>更新日 : <span><?php echo $imgUpdate; ?></span></p>
                        <input type="submit" id="submit" class="clickEvent" name="sender" value="トップページを編集する">
                    </div>
                </form>
            </article>
        <?php /* 編集フラグが空(通常)のメインコンテンツ表示 */?>
        <?php elseif($EditPage==""):?>
            <nav><div id="navLablel"><span><?php echo $classes[$class]?>:<?php echo $imgSets[0]["Year"]?>.<?php echo $Seasons[$season]?></span>を表示中</div></nav>
            <?php $i=1; foreach($imgSets as $imgSet):?>
            <article class="content_li">
                <h1><?php echo $imgSet["title"]?></h1>
                <img src="" data-lazy="/photo/call_img.php?id=<?php echo $imgSet["No"]?>&cl=<?php echo $classes_No[$class]?>" class="lazy_loading">
                <p style="text-align:center;"><?php echo date('Y年m月d日', strtotime($imgSet["time"]))?></p>
                <p><?php echo $imgSet["comment"]?></p>
            </article>
            <?php $i++; $rows=$i;?>
            <?php endforeach;?>
            <script>
                /*****************
                 * 画像の遅延読込み
                *****************/
                const doObserve = (element) => {
                    const targets = document.querySelectorAll(element);
                    const options = {
                    root: null,
                    rootMargin: '50px 0px 100px 0px',
                    threshold: 0
                }
                const observer = new IntersectionObserver((items) => {
                    items.forEach((item, index) => {
                    if (item.isIntersecting) {
                        if (item.target.classList.contains('lazy_loading') && !item.target.getAttribute('src')) {
                        const srcUrl = item.target.getAttribute('data-lazy');
                        item.target.setAttribute('src', srcUrl);
                        }
                    }
                    });
                }, options);
                Array.from(targets).forEach((target) => {
                    observer.observe(target);
                });
                }
                doObserve('.lazy_loading');
            </script>
        <?php /* 編集フラグがphoto(編集)のメインコンテンツ表示 */?>
        <?php elseif($EditPage=="photo"): ?>
            <nav><div id="navLablel"><span><?php echo $classes[$class]?>:<?php echo $imgSets[0]["Year"]?>年<?php echo $Seasons[$season]?></span>を表示中</div></nav>
            <?php $i=1; foreach($imgSets as $imgSet):?>
            <?php /* 写真ボックスを編集前表示 */?>
                <article class="content_li" id="content<?php echo $i; ?>">
                    <form method="post" action="" enctype="multipart/form-data">
                        <input type="hidden" name="types" value="<?php echo $i; ?>" />
                        <h1><?php echo $imgSet["title"]?></h1>
                        <img src="/photo/call_img.php?id=<?php echo $imgSet["No"]?>&cl=<?php echo $classes_No[$class]?>">
                        <p style="text-align:center;"><?php echo date('Y年m月d日', strtotime($imgSet["time"]))?></p>
                        <p><?php echo $imgSet["comment"]?></p>
                        <?php if($imgSet["title"]!="No_data"):?>
                            <input type="submit" id="submit" class="clickEvent" name="sender" value="ImageList<?php echo $i; ?>編集"/>
                            <input type="submit" id="submit" class="clickEvent" name="sender" value="ImageList<?php echo $i; ?>削除"/>
                        <?php endif;?>
                    </form>
                </article>
            <?php $i++; $rows=$i;?>
            <?php endforeach;?>
            <article class="content_li">
                <h1>新しい写真の投稿はこちら</h1>
                <p>
                    今、表示している季節と年を確認してください。<br>
                    次に、写真を表示したい季節と年をメモしてください。<br>
                    上記の準備をしてから写真の投稿をお願いします。
                </p>
                <div class="page_info">
                    <form method="post" action="" enctype="multipart/form-data"><label>
                        <input type="submit" id="submit" class="clickEvent" name="sender" value="写真の新規投稿">
                        新規投稿はこちらから
                    </label></form>
                </div>
            </article>
            <article class="content_li">
                <h1>投稿した写真が表示されないときは…</h1>
                <p>
                    今、表示している季節と年を確認してください。<br>
                    次に、他の年と季節のページの一番下に、投稿した写真がないかを確認してください。<br>
                    それでも写真がない場合、上手くデータが読み込めていない場合があります。<br>
                    下のボタンで画面を更新した後、もう一度他のページに投稿した写真がないかを確認してください。
                </p>
                <div class="page_info">
                    <label>
                        こちらのボタンで画面を更新してください。
                        <input type="button" onclick="location.reload(true);" value="画面を更新">
                    </label>
                </div>
            </article>
            <script>
                /****************
                * 表示位置の変更photo
                ****************/
                window.addEventListener('load', function() {
                    //表示位置変更
                    const flag = <?php echo $position_flag; ?>;
                    if(flag){
                        const targetId = "<?php echo $position_target; ?>";
                        const targetElement = document.querySelector('#' + targetId);//idのエレメント
                        const targetOffsetTop = window.pageYOffset + targetElement.getBoundingClientRect().top;//距離を取得
                        window.scrollTo({
                            top: targetOffsetTop,
                            behavior: "smooth"
                        });
                    }
                });
                /*****************
                 * 画像の遅延読込み
                *****************/
                const doObserve = (element) => {
                    const targets = document.querySelectorAll(element);
                    const options = {
                    root: null,
                    rootMargin: '50px 0px 100px 0px',
                    threshold: 0
                }
                const observer = new IntersectionObserver((items) => {
                    items.forEach((item, index) => {
                    if (item.isIntersecting) {
                        if (item.target.classList.contains('lazy_loading') && !item.target.getAttribute('src')) {
                        const srcUrl = item.target.getAttribute('data-lazy');
                        item.target.setAttribute('src', srcUrl);
                        }
                    }
                    });
                }, options);
                Array.from(targets).forEach((target) => {
                    observer.observe(target);
                });
                }
                doObserve('.lazy_loading');
            </script>
        <?php endif; ?>
    </div>
</main>