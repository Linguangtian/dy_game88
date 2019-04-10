<?php defined('IN_IA') or exit('Access Denied');?><div style="width:100%;height:80px;"></div>
<div class="footer_box" style="background:#ffffff">
    <div class=" footer_in">
        <div class="item_cell_boxs">
            <?php  if(empty($footer)) { ?>
            <div class="footer_item" style="width:50%">
                <a href="<?php  echo $this->createMobileUrl('index');?>" class="footer_button click_button" style="background:#fff;">
                    <img class="footer_item_img" src="<?php  echo toimage($cfg['face']['app_index'])?>">
                    <div class="footer_item_name"><?php  echo $cfg['font']['app_index'];?></div>
                </a>
            </div>
            <div class="footer_item" style="width:50%">
                <a href="<?php  echo $this->createMobileUrl('my');?>" class="footer_button click_button" style="background:#fff;">
                    <img class="footer_item_img" src="<?php  echo toimage($cfg['face']['fmy'])?>">
                    <div class="footer_item_name"><?php  echo $cfg['font']['fmy'];?></div>
                </a>
            </div>
            <?php  } else { ?>
            <?php  if(is_array($footer)) { foreach($footer as $f) { ?>
            <div class="footer_item" style="width:<?php  echo $footerWith;?>%">
                <a href="<?php  echo $f['url'];?>" class="footer_button click_button" style="background:#fff;">
                    <img class="footer_item_img" src="<?php  echo toimage($f['img'])?>">
                    <div class="footer_item_name"><?php  echo $f['title'];?></div>
                </a>
            </div>
            <?php  } } ?>
            <?php  } ?>
        </div>
    </div>
</div>