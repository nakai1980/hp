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
        <?php if($EditPage=="top" or $EditPage=="top_edit" or $EditPage=="info" or $EditPage=="info_edit" or $EditPage=="link" or $EditPage=="link_edit"):?>
            <div id="left"><h1><span>蝶</span><img src="img/tyou.png">と<br>キノコ</h1></div>
            <div id="right"><ul id="nav">
                <?php $i=1; foreach($top_menu_url as $menu): ?>
                    <li><sub>◎</sub>
                        <a href="<?php echo $menu["url"]; ?>"><?php echo $menu["name"]; ?></a>
                        <?php $i++;?>
                    </li>
                <?php endforeach; ?>
                <div id="menu0" class="photo0 photo">
                    <?php if(($EditPage=="top_edit")or($EditPage=="link_edit")or($EditPage=="info_edit")):?>
                        <a id="spr2003" href="topEdit.php?m=0#menu0" class="spr">トップ</a>
                        <a id="spr2004" href="topEdit.php?m=1#menu0" class="spr">あいさつ</a>
                        <a id="spr2005" href="topEdit.php?m=2#menu0" class="spr">リンク</a>
                    <?php elseif($EditPage=="top" or $EditPage=="info" or $EditPage=="link"):?>
                        <a id="spr2003" href="index.php?m=0#menu0" class="spr">トップ</a>
                        <a id="spr2004" href="index.php?m=1#menu0" class="spr">あいさつ</a>
                        <a id="spr2005" href="index.php?m=2#menu0" class="spr">リンク</a>
                    <?php endif;?>
                </div>
                <div id="menu1" class="photo2 photo">
                    <a id="sum2003" href="#menu11" class="spr tyou">春</a>
                    <a id="sum2004" href="#menu12" class="sum tyou">夏</a>
                    <a id="sum2005" href="#menu13" class="aut tyou">秋</a>
                    <a id="sum2006" href="#menu14" class="win tyou">冬</a>
                </div>
                <div id="menu2" class="photo2 photo">
                    <a id="sum2003" href="#menu21" class="spr">春</a>
                    <a id="sum2004" href="#menu22" class="sum">夏</a>
                    <a id="sum2005" href="#menu23" class="aut">秋</a>
                    <a id="sum2006" href="#menu24" class="win">冬</a>
                </div>
                <div id="menu3" class="photo3 photo">
                    <a id="aut2003" href="#menu31" class="spr">春</a>
                    <a id="aut2004" href="#menu32" class="sum">夏</a>
                    <a id="aut2005" href="#menu33" class="aut">秋</a>
                    <a id="aut2006" href="#menu34" class="win">冬</a>
                </div>
                <div id="menu4" class="photo4 photo">
                    <a id="win2003" href="#menu41" class="spr">春</a>
                    <a id="win2004" href="#menu42" class="sum">夏</a>
                    <a id="win2005" href="#menu43" class="aut">秋</a>
                    <a id="win2006" href="#menu44" class="win">冬</a>
                </div>
                <div id="menu5" class="photo5 photo">
                    <a id="win2003" href="#menu51" class="spr">春</a>
                    <a id="win2004" href="#menu52" class="sum">夏</a>
                    <a id="win2005" href="#menu53" class="aut">秋</a>
                    <a id="win2006" href="#menu54" class="win">冬</a>
                </div>
                <div id="menu6" class="photo6 photo">
                    <a id="win2003" href="#menu61" class="spr">春</a>
                    <a id="win2004" href="#menu62" class="sum">夏</a>
                    <a id="win2005" href="#menu63" class="aut">秋</a>
                    <a id="win2006" href="#menu64" class="win">冬</a>
                </div>
                <div id="menu7" class="photo7 photo">
                    <a id="win2003" href="#menu71" class="spr">春</a>
                    <a id="win2004" href="#menu72" class="sum">夏</a>
                    <a id="win2005" href="#menu73" class="aut">秋</a>
                    <a id="win2006" href="#menu74" class="win">冬</a>
                </div>
                <div id="menu8" class="photo8 photo">
                    <a id="win2003" href="#menu81" class="spr">春</a>
                    <a id="win2004" href="#menu82" class="sum">夏</a>
                    <a id="win2005" href="#menu83" class="aut">秋</a>
                    <a id="win2006" href="#menu84" class="win">冬</a>
                </div>
                <div id="menu9" class="photo9 photo">
                    <a id="win2003" href="#menu91" class="spr">春</a>
                    <a id="win2004" href="#menu92" class="sum">夏</a>
                    <a id="win2005" href="#menu93" class="aut">秋</a>
                    <a id="win2006" href="#menu94" class="win">冬</a>
                </div>
                <?php /* 年表読み取り */ ?>
                <?php for($n=1;$n<10;$n++):?>
                    <?php for($i=0;$i<4;$i++):?>
                        <?php $j=$i+1;?>
                        <div id="menu<?php echo $n?><?php echo $j?>" class="photo<?php echo $n?> photo">
                            <?php /*季節が空は表示しない*/?>
                            <?php if(isset($top_menu2_year[$n][$season_str[$i]])): ?>
                                <?php $tmp=$top_menu2_year[$n][$season_str[$i]]; ?>
                                <?php foreach($tmp as $year): ?>
                                    <?php
                                        $strs= intval(substr($year,2,2));
                                        $outstr = $season_str[$i].$year;
                                    ?>
                                    <?php /* $top_menu3_yearは表示フラグ */?>
                                    <?php if($top_menu3_year[$class_Str[$n]][$season_str[$i]][$year]):?>
                                        <a id="<?php echo $outstr; ?>" href="photo.php?y=<?php echo $strs; ?>&s=<?php echo $j; ?>&c=<?php echo $n; ?>#photo<?php echo $j; ?>" class="<?php echo $season_str[$i]; ?>"><?php echo $year; ?></a>
                                    <?php endif;?>
                                <?php endforeach?>
                            <?php else: ?>
                                <?php /*季節が空*/?>
                                <p>de-tanasi</p>
                            <?php endif;?>
                        </div>
                    <?php endfor;?>
                <?php endfor;?>
                <?php /* 表示年を反転 */ ?>
                <?php
                    // $EditPageで分岐
                    global $tmp1;
                    $tmp1 ="spr2003";
                    if($EditPage=='top'or $EditPage=='top_edit'){
                        $setYear = isset($setYear)? $setYear: 2003;
                        $season = isset($season)? $season: 'spr';
                        $tmp1 = $season.$setYear;
                    }elseif($EditPage=='info' or $EditPage=='info_edit'){
                        $tmp1 = "spr2004";
                    }elseif($EditPage=='link' or $EditPage=='link_edit'){
                        $tmp1 = "spr2005";
                    }

                ?>
                <script>
                    // a要素を取得
                    var a="<?php echo $tmp1?>";
                    var a_element = document.getElementById(a);
                    var d_element = document.getElementById("photo1");
                    // クラス名を追加
                    a_element.classList.add("photoNo1");
                </script>
            </ul></div>
            <div id="setbg"><div id="setbd"><br></div></div>
        <?php elseif($EditPage==""):?>
            <div id="left"><h1><span>蝶</span><img src="img/tyou.png">と<br>キノコ</h1></div>
            <div id="right"><ul id="nav">
                <?php $i=1; foreach($header_menu_url as $menu): ?>
                    <li><sub>◎</sub>
                        <a href="photo.php?y=<?php echo $Yno;?>&s=<?php echo $i;?>&c=<?php echo $Cno;?><?php echo $menu["url"]; ?>"><?php echo $menu["name"]; ?></a>
                        <?php $i++;?>
                    </li>
                <?php endforeach; ?>
                <?php for($i=0;$i<4;$i++):?>
                    <?php $j=$i+1;?>
                    <div id="photo<?php echo $j?>" class="photo<?php echo $j?> photo">
                    <?php /* 空季節の読み飛ばし */ ?>
                    <?php if(isset($top_menu2_year[$class_num[$class]][$season_str[$i]])):?>
                        <?php $tmp=$top_menu2_year[$class_num[$class]][$season_str[$i]]; ?>
                        <?php foreach($tmp as $year): ?>
                            <?php
                                $strs= intval(substr($year,2,2));
                                $outstr = $season_str[$i].$year;
                            ?>
                            <?php /* $top_menu3_yearは表示フラグ */?>
                            <?php if($top_menu3_year[$class][$season_str[$i]][$year]):?>
                                <a id="<?php echo $outstr; ?>" href="photo.php?y=<?php echo $strs; ?>&s=<?php echo $j; ?>&c=<?php echo $Cno; ?>#photo<?php echo $j; ?>" class="<?php echo $season_str[$i]; ?>"><?php echo $year; ?></a>
                            <?php endif;?>
                        <?php endforeach?>
                    <?php else:?>
                        <?php /* 空季節の表示 */?>
                    <?php endif?>
                    </div>
                <?php endfor;?>
                <?php
                    $setYear = isset($setYear)? $setYear: 2003;
                    $season = isset($season)? $season: 'spr';
                    $tmp1 = $season.$setYear;
                ?>
                <script>
                    // a要素を取得
                    var a="<?php echo $tmp1?>";
                    var a_element = document.getElementById(a);
                    // クラス名を追加
                    a_element.classList.add("photoNo1");
                </script>
            </ul></div>
            <div id="setbg"><div id="setbd"><br></div></div>
        <?php elseif($EditPage=="photo") :?>
            <div id="left"><h1><span>蝶</span><img src="img/tyou.png">と<br>キノコ</h1></div>
            <div id="right"><form method="post" action="">
                <ul id="nav">
                    <?php if($Edit['flag'] and $Edit['TOPMenu']):?>
                        <?php $tmp=1; foreach($header_menu_url as $menu): ?>
                            <li>
                                <label for="name<?php echo $tmp; ?>">
                                <input type="text" id="name<?php echo $tmp; ?>" name="name<?php echo $tmp; ?>"  placeholder="メニュー名" value="<?php echo $menu["name"]; ?>">
                                </label>
                                <label for="url<?php echo $tmp; ?>">
                                <input type="text" id="url<?php echo $tmp; ?>" name="url<?php echo $tmp; ?>" placeholder="アドレス" value="<?php echo $menu["url"]; ?>">
                                </label>
                            </li>
                            <?php $tmp++; ?>
                        <?php endforeach; ?>
                        <li>
                            <div><label for="submit">----</label></div>
                            <input type="submit" id="submit" name="sender" value="TOPMenu更新">
                        </li>
                    <?php else :?>
                        <?php $i=1; foreach($header_menu_url as $menu): ?>
                            <li><sub>◎</sub>
                                <a href="photoEdit.php?y=<?php echo $Yno;?>&s=<?php echo $i;?>&c=<?php echo $Cno;?><?php echo $menu["url"]; ?>"><?php echo $menu["name"]; ?></a>
                                <?php $i++;?>
                            </li>
                        <?php endforeach; ?>
                    <?php endif;?>
                    <?php for($i=0;$i<4;$i++):?>
                        <?php $j=$i+1;?>
                        <div id="photo<?php echo $j?>" class="photo<?php echo $j?> photo">
                        <?php /* 空季節の読み飛ばし */ ?>
                        <?php if(isset($top_menu2_year[$class_num[$class]][$season_str[$i]])):?>
                            <?php $tmp=$top_menu2_year[$class_num[$class]][$season_str[$i]]; ?>
                            <?php foreach($tmp as $year): ?>
                                <?php
                                    $strs= intval(substr($year,2,2));
                                    $outstr = $season_str[$i].$year;
                                ?>
                                <?php /* $top_menu3_yearは表示フラグ */?>
                                <?php if($top_menu3_year[$class][$season_str[$i]][$year]):?>
                                    <a id="<?php echo $outstr; ?>" href="photo.php?y=<?php echo $strs; ?>&s=<?php echo $j; ?>&c=<?php echo $Cno; ?>#photo<?php echo $j; ?>" class="<?php echo $season_str[$i]; ?>"><?php echo $year; ?></a>
                                <?php endif;?>
                            <?php endforeach; ?>
                        </div>
                        <?php else:?>
                            <?php /* 空季節の表示 */?>
                        <?php endif?>
                    <?php endfor;?>
                    <?php
                        $setYear = isset($setYear)? $setYear: 2003;
                        $season = isset($season)? $season: 'spr';
                        $tmp1 = $season.$setYear;
                    ?>
                    <script>
                        // a要素を取得
                        var a="<?php echo $tmp1?>";
                        var a_element = document.getElementById(a);
                        // クラス名を追加
                        a_element.classList.add("photoNo1");
                    </script>
                </ul>
            </form></div>
            <div id="setbg"><div id="setbd"><br></div></div>
        <?php elseif($EditPage=="write_edit") :?>
            <div id="left"><h1><span>蝶</span><img src="img/tyou.png">と<br>キノコ</h1></div>
            <div id="right"><ul id="nav">
            </ul></div>
            <div id="setbg"><div id="setbd"><br></div></div>
            </div>
        <?php endif?>
    </div>
</header>