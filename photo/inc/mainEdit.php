<?php
global $position;
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
<main id="main" class="main mainEdit" role="main">
    <div class="wrap" id="box">
    <div id="top_menu_sp"><br></div>
        <?php /* 編集フラグがwrite_edit(写真ページの編集)のページを表示 */?>
        <?php if($EditPage=="write_edit"):?>
            <!-- main css変更 -->
            <script>
                // a要素を取得
                var main="main";
                var main_element = document.getElementById(main);
                // クラス名をリムーブ
                main_element.classList.remove("mainEdit");
            </script>
            <nav><div id="navLablel"><span><?php echo $classes[$class]?>:<?php echo $imgSets[0]["Year"]?>年<?php echo $Seasons[$season]?></span>を表示中</div></nav>
            <?php /* アウトプット番号($type) 表示したい記事の添え字 */ ?>
            <?php if($outputNum!=0):?>
                <?php $i=$outputNum; $imgSet=$imgSets[$i-1]; ?>
                <?php /*編集フラグとイメージリスト番号のフラグを見て写真ボックスを編集表示*/ ?>
                <?php if($Edit['flag'] and $Edit['ImageList'][$i]):?>
                    <article class="content_li">
                        <form method="post" action="" enctype="multipart/form-data">
                            <input type="hidden" name="types" value="<?php echo $i; ?>" />
                            <input type="text"
                                class="img_title"
                                id="title<?php echo $i; ?>"
                                name="title<?php echo $i; ?>"
                                placeholder="タイトル"
                                value="<?php echo $imgSet["title"]?>">
                            <?php /*投稿前の写真を仮表示*/ ?>
                            <div class="changImg">
                            <output id="cover<?php echo $i; ?>"><img src="" style="display:none;"></output>
                            </div>
                            <img src="/photo/call_img.php?id=<?php echo $imgSet["No"]?>&cl=<?php echo $classes_No[$class]?>" id="img<?php echo $i; ?>">
                            <div class="attachment">
                                <label for="sendImage<?php echo $i; ?>">ファイルを選択する
                                    <input type="file" name="image" accept="image/jpeg" id="sendImage<?php echo $i; ?>">
                                </label><span class="filename" id="info_sub<?php echo $i; ?>">選択されていません</span>
                            </div>
                            <script>
                                /****************
                                * 投稿前の写真を表示
                                ****************/
                                function handleFileSelect<?php echo $i; ?>(evt) {
                                    var files = evt.target.files; // FileList object
                                    var f = files[0];
                                    // Only process image files.
                                    if (!f.type.match('image.*')) {
                                    return;
                                    }else{
                                        var reader = new FileReader();
                                        // Closure to capture the file information.
                                        reader.onload = (function(theFile) {
                                        return function(e) {
                                            // Render thumbnail.
                                            var node = document.getElementById('cover<?php echo $i; ?>').firstChild;
                                            var span = document.createElement('span');
                                            var infotxt = escape(theFile.name)+"が選択されました";
                                            span.innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
                                            document.getElementById('cover<?php echo $i; ?>').removeChild(node);
                                            document.getElementById('cover<?php echo $i; ?>').insertBefore(span, null);
                                            document.getElementById("img<?php echo $i; ?>").style.display ="none";
                                            document.getElementById("info_sub<?php echo $i; ?>").innerText =infotxt;
                                        };
                                        })(f);
                                        // Read in the image file as a data URL.
                                        reader.readAsDataURL(f);
                                    }
                                }
                                document.getElementById('sendImage<?php echo $i; ?>').addEventListener('change', handleFileSelect<?php echo $i; ?>, false);
                            </script>
                            <label for="year<?php echo $i; ?>" class="img_year">
                                <input type="text"
                                class="img_year"
                                id="year<?php echo $i; ?>"
                                name="year<?php echo $i; ?>"
                                placeholder="年"
                                value="<?php echo $imgSet['Year']?>"required>年</label>
                                <label for="seasonSelect<?php echo $i; ?>" class="img_season">
                                <span class="select-wrapper"><select id="seasonSelect<?php echo $i; ?>" name="seasonSelect<?php echo $i; ?>" required>
                                    <option value="">季節</option>
                                    <option value="spr">春</option>
                                    <option value="sum">夏</option>
                                    <option value="aut">秋</option>
                                    <option value="win">冬</option>
                                </select>季節</span>
                                に表示します</label>
                                <script>document.getElementById("seasonSelect<?php echo $i; ?>").options[<?php echo $SeasonNum[$imgSet["Seasons"]]; ?>].selected = true;</script>
                            <label for="date<?php echo $i; ?>" class="img_date">
                                <input type="text"
                                class="img_date"
                                id="date<?php echo $i; ?>"
                                name="date<?php echo $i; ?>"
                                placeholder="日時"
                                value="<?php echo date('Y_m_d_H', strtotime($imgSet['time']))?>">
                                <strong>年_月_日_番号</strong>の形式で、年月日と番号を入力します</label>
                            <label for="comment<?php echo $i; ?>" class="img_comment">
                                <textarea type="text"
                                class="img_comment"
                                id="comment<?php echo $i; ?>"
                                name="comment<?php echo $i; ?>"
                                placeholder="画像のコメント"><?php echo $imgSet["comment"]?></textarea>
                                <span>画像のコメントを<br>入力して下さい<span></label>
                            <input type="hidden" value="0,0" id="position<?php echo $i; ?>" name="position<?php echo $i; ?>"/>
                            <div class="submitRight">
                                <input type="submit" id="submit<?php echo $i; ?>" class="clickEvent" name="sender" value="ImageList<?php echo $i; ?>更新" />
                                <input type="submit" id="submit<?php echo $i; ?>" class="clickEvent" name="sender" value="ImageList<?php echo $i; ?>の更新をやめる" />
                            </div>
                        </form>
                    </article>
                <?php /*削除モード通常表示1件と削除キャンセルボタン*/?>
                <?php elseif($Edit['ImageDelete'][$i]):?>
                <article class="content_li">
                    <h1><?php echo $imgSet["title"]?></h1>
                    <img src="/photo/call_img.php?id=<?php echo $imgSet["No"]?>&cl=<?php echo $classes_No[$class]?>">
                    <p style="text-align:center;"><?php echo date('Y年m月d日', strtotime($imgSet["time"]))?></p>
                    <p><?php echo $imgSet["comment"]?></p>
                    <form method="post" action="" enctype="multipart/form-data">
                        <input type="hidden" name="types" value="<?php echo $i; ?>" />
                        <input type="hidden" name="No" value="<?php echo $imgSet["No"]?>" />
                        <input type="hidden" name="year<?php echo $i; ?>" value="<?php echo $imgSet['Year']?>" />
                        <input type="hidden" name="seasonSelect<?php echo $i; ?>" value="<?php echo $imgSet["Seasons"]?>" />
                        <input type="submit" id="submit" class="clickEvent" name="sender" value="この投稿を削除する"/>
                        <input type="submit" id="submit" class="clickEvent" name="sender" value="削除を止める"/>
                    </form>
                </article>
                <?php endif;?>
            <?php /** アウトプット番号及びイメージリスト0は新規投稿のフラグ **/ ?>
            <?php elseif($outputNum==0 and $Edit['ImageList'][0]):?>
                <?php /* 新規投稿を表示 */?>
                <article class="content_li">
                    <form method="post"id="form1" action="" enctype="multipart/form-data">
                        <input type="hidden" name="types" value="0" />
                        <input type="text"
                            class="img_title"
                            id="title0"
                            name="title0"
                            placeholder="タイトル"
                            value="">
                        <div class="changImg">
                        <output id="cover0"><img src="" style="display:none;"></output>
                        </div>
                        <div class="attachment">
                            <label for="sendImage0">ファイルを選択する
                                <input type="file" name="image" accept="image/jpeg" id="sendImage0">
                            </label><span class="filename" id="info_sub0">選択されていません</span>
                        </div>
                        <script>
                            /****************
                            * 投稿前の写真を表示
                            ****************/
                            function handleFileSelect0(evt) {
                                var files = evt.target.files; // FileList object
                                var f = files[0];
                                // Only process image files.
                                if (!f.type.match('image.*')) {
                                return;
                                }else{
                                    var reader = new FileReader();

                                    // Closure to capture the file information.
                                    reader.onload = (function(theFile) {
                                    return function(e) {
                                        // Render thumbnail.
                                        var node = document.getElementById('cover0').firstChild;
                                        var span = document.createElement('span');
                                        var infotxt = escape(theFile.name)+"が選択されました";
                                        span.innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
                                        document.getElementById('cover0').removeChild(node);
                                        document.getElementById('cover0').insertBefore(span, null);
                                        document.getElementById("info_sub0").innerText =infotxt;
                                    };
                                    })(f);

                                    // Read in the image file as a data URL.
                                    reader.readAsDataURL(f);
                                }
                            }
                            document.getElementById('sendImage0').addEventListener('change', handleFileSelect0, false);
                        </script>
                        <label for="year0" class="img_year">
                            <input type="text"
                            class="img_year"
                            id="year0"
                            name="year0"
                            placeholder="年"
                            value="" required>年</label>
                            <label for="seasonSelect0" class="img_season">
                            <span class="select-wrapper"><select id="seasonSelect0" name="seasonSelect0" required>
                                <option value="">季節</option>
                                <option value="spr">春</option>
                                <option value="sum">夏</option>
                                <option value="aut">秋</option>
                                <option value="win">冬</option>
                            </select>季節</span>
                            に表示します</label>
                        <label for="date0" class="img_date">
                            <input type="text"
                            class="img_date"
                            id="date0"
                            name="date0"
                            placeholder="日時"
                            value="0000_00_00_00">
                            <strong>年_月_日_番号</strong>の形式で、年月日と番号を入力します</label>
                        <label for="comment0" class="img_comment">
                            <textarea type="text"
                            class="img_comment"
                            id="comment0"
                            name="comment0"
                            placeholder="画像のコメント"></textarea><span>画像のコメントを<br>入力して下さい<span></label>
                        <input type="hidden" value="0,0" id="position0" name="position0"/>
                    </form>
                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="submitRight">
                            <input type="submit" id="submit" class="clickEvent" name="sender" form="form1" value="新規写真投稿" />
                            <input type="submit" id="submit" class="clickEvent" name="sender" value="新規投稿をやめる" />
                        </div>
                    </form>
                    <script>
                        /****************
                        * スクロールして指定した写真の位置へ
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
                            document.getElementById("position0").value = position["x"]+","+position["y"];
                        <?php for($num=0;$num<$rows;$num++): ?>
                            document.getElementById("position<?php echo $num; ?>").value = position["x"]+","+position["y"];
                        <?php endfor;?>
                        }
                        var hoge = document.getElementsByClassName('clickEvent');
                        for (var i = 0; i < hoge.length; i++) {
                        hoge[i].addEventListener("click", clickEvt, false);
                        }
                    </script>
                </article>
            <?php else:?>
                <div class="divSpace"></div>
            <?php endif;?>
        <?php /* 編集フラグがlink_edit(リンク編集)のページを表示 */?>
        <?php elseif($EditPage=="link_edit"):?>
            <article class="content_top">
                <div class="top_sp">　</div>
                <?php $i=1; foreach($links_list_txt as $link):?>
                    <?php /* 編集フラグがオン */?>
                    <?php if($Edit['flag'] and $Edit['linkList'][$i]):?>
                        <form method="post" action="" enctype="multipart/form-data">
                            <div class="links">
                                <div class="link_left">
                                    <?php /*投稿前の写真を仮表示*/ ?>
                                    <div class="changImg">
                                    <output id="cover<?php echo $i; ?>"><img src="" style="display:none;"></output>
                                    </div>
                                    <figure><img id="img<?php echo $i; ?>" src="./call_img.php?lnk=<?php echo $link["No"];?>"></figure>
                                    <div class="attachment">
                                        <label for="sendImage<?php echo $i; ?>">ファイルを選択する
                                            <input type="file" name="image" accept="image/jpeg" id="sendImage<?php echo $i; ?>">
                                        </label><br><span class="filename" id="info_sub<?php echo $i; ?>">選択されていません</span>
                                    </div>
                                    <script>
                                        /****************
                                         * 投稿前の写真を表示
                                         ****************/
                                        function handleFileSelect<?php echo $i; ?>(evt) {
                                            var files = evt.target.files; // FileList object
                                            var f = files[0];
                                            // Only process image files.
                                            if (!f.type.match('image.*')) {
                                            return;
                                            }else{
                                                var reader = new FileReader();
                                                // Closure to capture the file information.
                                                reader.onload = (function(theFile) {
                                                return function(e) {
                                                    // Render thumbnail.
                                                    var node = document.getElementById('cover<?php echo $i; ?>').firstChild;
                                                    var span = document.createElement('span');
                                                    var infotxt = escape(theFile.name)+"が選択されました";
                                                    span.innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
                                                    document.getElementById('cover<?php echo $i; ?>').removeChild(node);
                                                    document.getElementById('cover<?php echo $i; ?>').insertBefore(span, null);
                                                    document.getElementById("img<?php echo $i; ?>").style.display ="none";
                                                    document.getElementById("info_sub<?php echo $i; ?>").innerText =infotxt;
                                                };
                                                })(f);
                                                // Read in the image file as a data URL.
                                                reader.readAsDataURL(f);
                                            }
                                        }
                                        document.getElementById('sendImage<?php echo $i; ?>').addEventListener('change', handleFileSelect<?php echo $i; ?>, false);
                                    </script>
                                    <figcaption>
                                        <input id="HP_name<?php echo $i; ?>" name="HP_name<?php echo $i; ?>" type="text" value="<?php echo $link["HP_name"];?>">
                                        <textarea id="HP_url<?php echo $i; ?>" name="HP_url<?php echo $i; ?>"><?php echo $link["HP_url"];?></textarea>
                                    </figcaption>
                                </div>
                                <h2 class="link_name"><textarea id="friend_name<?php echo $i; ?>" name="friend_name<?php echo $i; ?>"><?php echo $link["friend_name"];?></textarea></h2>
                                <p class="link_text">
                                    <textarea id="comment<?php echo $i; ?>" name="comment<?php echo $i; ?>"><?php echo $link["comment"];?></textarea>
                                    <input type="hidden" name="types" value="<?php echo $i; ?>">
                                    <input type="submit" id="submit<?php echo $i; ?>" class="clickEvent" name="sender" value="この内容でリンクを更新する">
                                    <input type="submit" id="submit<?php echo $i; ?>" class="clickEvent" name="sender" value="このリンクの更新をやめる">
                                </p>
                            </div>
                        </form>
                    <?php endif;?>
                <?php $i++; $rows=$i;?>
                <?php endforeach;?>
            </article>
        <?php /* 編集フラグがinfo_edit(あいさつ編集)のページを表示 */?>
        <?php elseif($EditPage=="info_edit"):?>
            <article class="content_top">
                <form method="post" action="" enctype="multipart/form-data">
                    <p id="since">since <input type="text" id="since" name="since" value="<?php echo $top_info_txt[0]["since"]?>"></p>
                    <hr>
                    <div class="top_message">
                        <?php /*投稿前の写真を仮表示*/ ?>
                        <figure class="left">
                            <img id="img_info" src="/photo/call_img.php?inf=<?php echo $top_info_txt[0]["No"]?>">
                            <output id="cover_info"><img src="" style="display:none;"></output>
                        </figure>
                        <div class="right attachment">
                            <label for="sendImage_info">ファイルを選択する
                                <input type="file" name="image" accept="image/jpeg" id="sendImage_info">
                            </label><br><span class="filename" id="info_sub_info">選択されていません</span>
                            <p><input type="text" id="info1" name="info1" value="<?php echo $top_info_txt[0]["info1"]?>"></p>
                            <p><input type="text" id="info2" name="info2" value="<?php echo $top_info_txt[0]["info2"]?>"></p>
                        </div>
                        <script>
                            /****************
                             * 投稿前の写真を表示
                             ****************/
                            function handleFileSelect_info(evt) {
                                var files = evt.target.files; // FileList object
                                var f = files[0];
                                // Only process image files.
                                if (!f.type.match('image.*')) {
                                return;
                                }else{
                                    var reader = new FileReader();
                                    // Closure to capture the file information.
                                    reader.onload = (function(theFile) {
                                    return function(e) {
                                        // Render thumbnail.
                                        var node = document.getElementById('cover_info').firstChild;
                                        var span = document.createElement('span');
                                        var infotxt = escape(theFile.name)+"が選択されました";
                                        span.innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
                                        document.getElementById('cover_info').removeChild(node);
                                        document.getElementById('cover_info').insertBefore(span, null);
                                        document.getElementById("img_info").style.display ="none";
                                        document.getElementById("info_sub_info").innerText =infotxt;
                                    };
                                    })(f);
                                    // Read in the image file as a data URL.
                                    reader.readAsDataURL(f);
                                }
                            }
                            document.getElementById('sendImage_info').addEventListener('change', handleFileSelect_info, false);
                        </script>
                        <h2 class="toph2 mainEdit">ごあいさつ</h2>
                        <div class="bottom_box">
                            <p><input type="text" id="info3" name="info3" value="<?php echo $top_info_txt[0]["info3"]?>"></p>
                            <p><input type="text" id="info4" name="info4" value="<?php echo $top_info_txt[0]["info4"]?>"></p>
                            <p><span><input type="text" id="date" name="date" value="<?php echo $top_info_txt[0]["date"]?>"></span></p>
                        </div>
                        <div class="submitRight">
                            <input type="submit" id="submit" class="clickEvent" name="sender" value="このあいさつで更新する">
                            <input type="submit" id="submit" class="clickEvent" name="sender" value="あいさつの更新をやめる">
                        </div>
                    </div>
                </form>
            </article>
        <?php /* 編集フラグがtop_edit(トップページ編集モード)のトップページ表示 */?>
        <?php elseif($EditPage=="top_edit"):?>
            <article class="content_top">
                <form method="post" action="" enctype="multipart/form-data">
                    <p id="since">since 2003.July</p>
                    <hr>
                    <div class="top_message">
                        <figure class="left">
                            <div class="changImg">
                                <output id="cover_top"><img src="" style="display:none;"></output>
                            </div>
                            <img id="top_image" src="/photo/call_img.php?top=<?php echo $imgID;?>">
                        </figure>
                        <div class="right">
                            <h2 class="toph2">蝶とキノコ</h2>
                            <p><br>休日、野山で見つけた。<br> 蝶やキノコなどを 集めてみました。</p>
                            <p id="admin">管理者 ホオジロ<img src="img/gifu.gif" id="gifu"></p>
                        </div>
                        <div class="bottom_box">
                            <p class="bord_top">気まぐれ1枚 :</p>
                            <span class="select-wrapper"><select id="imgSelect" name="imgselect" required>
                                <option value="">選択してください</option>
                                <option value='<?php echo $topSets[1]["No"]; ?>'><?php echo $topSets[1]["imgName"]; ?></option>
                                <option value='<?php echo $topSets[2]["No"]; ?>'><?php echo $topSets[2]["imgName"]; ?></option>
                                <option value='<?php echo $topSets[3]["No"]; ?>'><?php echo $topSets[3]["imgName"]; ?></option>
                                <option value='<?php echo $topSets[4]["No"]; ?>'><?php echo $topSets[4]["imgName"]; ?></option>
                                <option value='<?php echo $topSets[5]["No"]; ?>'><?php echo $topSets[5]["imgName"]; ?></option>
                                <option value='<?php echo $topSets[6]["No"]; ?>'><?php echo $topSets[6]["imgName"]; ?></option>
                                <option value='<?php echo $topSets[7]["No"]; ?>'><?php echo $topSets[7]["imgName"]; ?></option>
                                <option value='<?php echo $topSets[8]["No"]; ?>'><?php echo $topSets[8]["imgName"]; ?></option>
                                <option value='<?php echo $topSets[9]["No"]; ?>'><?php echo $topSets[9]["imgName"]; ?></option>
                                <option value='<?php echo $topSets[10]["No"]; ?>'><?php echo $topSets[10]["imgName"]; ?></option>
                                <option value='<?php echo $topSets[11]["No"]; ?>'><?php echo $topSets[11]["imgName"]; ?></option>
                                <option value='<?php echo $topSets[12]["No"]; ?>'><?php echo $topSets[12]["imgName"]; ?></option>
                            </select>選択してください</span>
                            <p class="bord_top"><span id="chgMonth"></span>を編集します</p>
                            <div id="input_box">
                                <label for="">画像の名前 <input type="text" id="bord_name" name="imgName" value="<?php echo $imgName; ?>"></label>
                                <label for="">画像のコメント<input type="text" id="bord_comment" name="imgComment" value="<?php echo $imgComment; ?>"></label>
                            </div>
                            <div id="attachment_top">
                                <label for="sendImage_top">画像を変更する場合はファイルを選択してください
                                    <input type="file" name="image" accept="image/jpeg" id="sendImage_top">
                                </label><span class="filename" id="info_sub_top">まだ選択されていません</span>
                            </div>
                            <script>
                                /*********************
                                 * 画像ファイルの選択
                                 *********************/
                                function handleFileSelect_top(evt) {
                                    var files = evt.target.files; // FileList object
                                    var f = files[0];
                                    // Only process image files.
                                    if (!f.type.match('image.*')) {
                                    return;
                                    }else{
                                        var reader = new FileReader();
                                        // Closure to capture the file information.
                                        reader.onload = (function(theFile) {
                                        return function(e) {
                                            // Render thumbnail.
                                            var node = document.getElementById('cover_top').firstChild;
                                            var span = document.createElement('span');
                                            var infotxt = escape(theFile.name)+"が新しい画像として差し替えられます";
                                            span.innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
                                            document.getElementById('cover_top').removeChild(node);
                                            document.getElementById('cover_top').insertBefore(span, null);
                                            document.getElementById("top_image").style.display ="none";
                                            document.getElementById("info_sub_top").innerText =infotxt;
                                        };
                                        })(f);
                                        // Read in the image file as a data URL.
                                        reader.readAsDataURL(f);
                                    }
                                }
                                document.getElementById('sendImage_top').addEventListener('change', handleFileSelect_top, false);
                                /***********************
                                 *コメントの変更
                                ***********************/
                                var elem = document.getElementById('imgSelect');
                                var valText =[
                                    '<?php echo $topSets[1]["imgComment"]; ?>',
                                    '<?php echo $topSets[2]["imgComment"]; ?>',
                                    '<?php echo $topSets[3]["imgComment"]; ?>',
                                    '<?php echo $topSets[4]["imgComment"]; ?>',
                                    '<?php echo $topSets[5]["imgComment"]; ?>',
                                    '<?php echo $topSets[6]["imgComment"]; ?>',
                                    '<?php echo $topSets[7]["imgComment"]; ?>',
                                    '<?php echo $topSets[8]["imgComment"]; ?>',
                                    '<?php echo $topSets[9]["imgComment"]; ?>',
                                    '<?php echo $topSets[10]["imgComment"]; ?>',
                                    '<?php echo $topSets[11]["imgComment"]; ?>',
                                    '<?php echo $topSets[12]["imgComment"]; ?>'
                                ];
                                var valName =[
                                    '<?php echo $topSets[1]["imgName"]; ?>',
                                    '<?php echo $topSets[2]["imgName"]; ?>',
                                    '<?php echo $topSets[3]["imgName"]; ?>',
                                    '<?php echo $topSets[4]["imgName"]; ?>',
                                    '<?php echo $topSets[5]["imgName"]; ?>',
                                    '<?php echo $topSets[6]["imgName"]; ?>',
                                    '<?php echo $topSets[7]["imgName"]; ?>',
                                    '<?php echo $topSets[8]["imgName"]; ?>',
                                    '<?php echo $topSets[9]["imgName"]; ?>',
                                    '<?php echo $topSets[10]["imgName"]; ?>',
                                    '<?php echo $topSets[11]["imgName"]; ?>',
                                    '<?php echo $topSets[12]["imgName"]; ?>'
                                ];
                                function handleListChang(evt){
                                    var num = elem.selectedIndex;
                                    var num2 = elem.selectedIndex;
                                    if(num!=0) num2=num2-1;
                                    var tmp = "/photo/call_img.php?top="+num;
                                    document.getElementById("bord_name").value = valName[num2];
                                    document.getElementById("bord_comment").value = valText[num2];
                                    document.getElementById("top_image").src=tmp;
                                    document.getElementById("chgMonth").innerText=num+"月";
                                    if(num==0){
                                        document.getElementById("top_image").style.visibility ="hidden";
                                        document.getElementById("chgMonth").style.visibility ="hidden";
                                    }else{
                                        document.getElementById("top_image").style.visibility ="visible";
                                        document.getElementById("chgMonth").style.visibility ="visible";
                                    }
                                }
                                elem.addEventListener('change', handleListChang, false);
                                /****************
                                 * 現在の気まぐれ1枚(季節の画像)を選択した状態に
                                 ****************/
                                elem.options[<?php echo $month; ?>].selected = true;
                            </script>
                            <p><img src="http://www.hooziro.com/cgi-bin/g_counter.cgi" id="count"></p>
                            <div id="top_bottom_sp"><br></div>
                            <div class="update">
                                <label>更新日 : <input type="text" id="update" name="imgUpdate" value="<?php echo $imgUpdate; ?>"></label>
                                <input type="submit" id="submit" class="clickEvent" name="sender" value="この内容で更新する">
                                <input type="submit" id="submit" class="clickEvent" name="sender" value="TOPの更新をやめる">
                            </div>
                        </div>
                    </div>
                </form>
            </article>
        <?php endif; ?>
    </div>
</main>