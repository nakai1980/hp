<?php
global $EditPage;
$class_Str = ["","tyou","kino","yacy","plan","dog","flow","tea","trav","fiel"];
?>
<aside class="side">
    <h2>MENU</h2>
    <nav class="note">
        <?php /* サイドメニューの通常表示 */ ?>
        <?php if($EditPage!="write_edit"):?>
            <div class="note_line">
                <?php $menus=$side_menu_url?>
                <?php $i=1; foreach($menus as $menu1): ?>
                    <div class="LeftMenu">
                        <?php if($menu1[0]["name"]=="title"): ?>
                            <label for="smenu<?php echo $i; ?>"><?php echo $menu1[0]["url"];?></label>
                        <?php endif;?>
                        <input type="checkbox" id="smenu<?php echo $i; ?>" class="menus">
                        <ul id="nav" class="dropdown<?php echo $i; ?>">
                            <?php $j=1; foreach($menu1 as $menu):?>
                                <?php if($menu["name"]=="title")continue;?>
                                <?php if($menu["url"]=="auto"):?>
                                    <?php $setUrl=TimeListOld($class_Str[$j]);?>
                                    <li><a href="<?php echo $setUrl?>"><?php echo $menu["name"]?></a></li>
                                <?php else:?>
                                    <?php if(false!==strpos($menu["url"],"http")):?>
                                        <li><a href="<?php echo $menu["url"]?>" target="_blank" rel="noopener noreferrer"><?php echo $menu["name"]?></a></li>
                                    <?php else:?>
                                        <li><a href="<?php echo $menu["url"]?>"><?php echo $menu["name"]?></a></li>
                                    <?php endif;?>
                                <?php endif;?>
                                <?php $j++; ?>
                            <?php endforeach; ?>
                            <div><br></div>
                        </ul>
                    </div>
                    <?php $i++;?>
                <?php endforeach; ?>
                <?php /* ドロップダウンの制御cssだと手動で閉じるのが面倒 */ ?>
                <script>
                    function handleMenuCheck(evt){
                        var id = evt.target.id;
                        if(id=='title1'){id = 'smenu1';}
                        if(id=='title2'){id = 'smenu2';}
                        if(id=='title3'){id = 'smenu3';}
                        if(id=='title4'){id = 'smenu4';}
                        document.getElementById('smenu1').checked=false;
                        document.getElementById('smenu2').checked=false;
                        document.getElementById('smenu3').checked=false;
                        document.getElementById('smenu4').checked=false;
                        document.getElementById(id).checked=true;
                    }
                    document.getElementById('smenu1').addEventListener('click', handleMenuCheck, false);
                    document.getElementById('smenu2').addEventListener('click', handleMenuCheck, false);
                    document.getElementById('smenu3').addEventListener('click', handleMenuCheck, false);
                    document.getElementById('smenu4').addEventListener('click', handleMenuCheck, false);
                </script>
                <?php /* サイドメニューの編集用ボタン表示 */ ?>
                <?php if($EditPage=="photo" or $EditPage=="top_edit"):?>
                    <form method="post" action="" enctype="multipart/form-data">
                        <input type="submit" id="submit" name="sender" value="SIDEMenu編集">
                    </form>
                <?php endif;?>
            </div>
        <?php endif;?>
    </nav>
</aside>
