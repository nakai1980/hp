<?php
global $imgSets;
global $EditPage;
global $class;
$season = is_null($imgSets[0]["Seasons"])? 'spr': $imgSets[0]["Seasons"];
$setyear = is_null($imgSets[0]["Year"])? 2003: $imgSets[0]["Year"];
$seasons_num = ['spr'=>1, 'sum'=>2, 'aut'=>3, 'win'=>4];
$season_str = ['spr', 'sum', 'aut', 'win'];
$class_num = [""=>0,"tyou"=>1,"kino"=>2,"yacy"=>3,"plan"=>4,"dog"=>5,"flow"=>6,"tea"=>7,"trav"=>8,"fiel"=>9];
$class_Str = ["","tyou","kino","yacy","plan","dog","flow","tea","trav","fiel"];
$Sno = $seasons_num[$season];
$Yno = $setyear - 2000;
$Cno = $class_num[$class];
?>
<header>
    <div class="TopMenu">
        <?php if($EditPage=="write_edit" or $EditPage=="top_edit" or $EditPage=="link_edit" or $EditPage=="info_edit"):?>
            <div id="left" class="sidEdit"><h1><span>蝶</span><img src="img/tyou.png">と<br>キノコ</h1></div>
            <div id="right" class="mainEdit"><ul id="nav" class="mainEdit"></ul></div>
            <div id="setbg" class="mainEdit"><div id="setbd" class="mainEdit"><br></div></div>
            </div>
        <?php endif?>
    </div>
</header>