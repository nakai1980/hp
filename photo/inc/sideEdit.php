<?php
global $EditPage;
$class_Str = ["","tyou","kino","yacy","plan","dog","flow","tea","trav","fiel"];
?>
<aside class="side sidEdit">
    <h2>MENU</h2>
    <nav class="note sidEdit">
        <?php /* サイドメニューの編集表示 */ ?>
        <?php if($EditPage=="write_edit" and $Edit['SIDEMenu']):?>
        <div class="note_line sidEdit">
            <form method="post" action="" enctype="multipart/form-data">
                <?php $i=1; foreach($side_menu_url as $menu1): ?>
                    <div class="LeftMenu sidEdit">
                        <?php if($menu1[0]["name"]=="title"):?>
                            <label for="title<?php echo $i; ?>">
                                <input type="text" 
                                    id="title<?php echo $i; ?>" 
                                    name="title<?php echo $i; ?>" 
                                    placeholder="メニュー名" 
                                    value="<?php echo $menu1[0]["url"];?>">
                            </label>
                        <?php endif;?>
                        <input type="checkbox" id="smenu<?php echo $i; ?>" class="menus">
                        <ul id="nav" class="dropdown<?php echo $i; ?> sidEdit">
                            <?php $j=1; foreach($menu1 as $menu):?>
                                <?php if($menu["name"]=="title")continue;?>
                                <li>
                                    <input type="text"
                                        id="name<?php echo $i; ?><?php echo $j; ?>"
                                        name="name<?php echo $i; ?><?php echo $j; ?>"
                                        placeholder="メニュー名"
                                        value="<?php echo $menu["name"]; ?>">
                                    <textarea type="text"
                                        id="url<?php echo $i; ?><?php echo $j; ?>"
                                        name="url<?php echo $i; ?><?php echo $j; ?>"
                                        placeholder="アドレス"><?php echo $menu["url"]; ?></textarea>
                                </li>
                                <?php $j++; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php $i++; ?>
                <?php endforeach; ?>
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
                    document.getElementById('title1').addEventListener('focus', handleMenuCheck, false);
                    document.getElementById('title2').addEventListener('focus', handleMenuCheck, false);
                    document.getElementById('title3').addEventListener('focus', handleMenuCheck, false);
                    document.getElementById('title4').addEventListener('focus', handleMenuCheck, false);
                </script>
                <input type="submit" id="submit" name="sender" value="SIDEMenu更新">
                <input type="submit" id="submit" name="sender" value="SIDEMenuの更新をやめる">
            </form>
        </div>
        <?php endif;?>
    </nav>
</aside>
