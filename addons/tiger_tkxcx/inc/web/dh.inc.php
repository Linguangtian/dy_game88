<?php
global $_W;
        global $_GPC;
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/goodsapi.php"; 
        $fzlist=getclass($_W,$cfg['ptpid'],'');//全部分类
        //echo "<pre>";
        //print_r($fzlist);

        if ($operation == 'post'){
            $id = intval($_GPC['id']);
            if (!empty($id)){
                $item = pdo_fetch("SELECT * FROM " . tablename("tiger_newhu_xcxdh") . " WHERE id = :id" , array(':id' => $id));
                if (empty($item)){
                    message('抱歉，导航不存在或是已经删除！', '', 'error');
                }
            }
            if (checksubmit('submit')){
                if (empty($_GPC['title'])){
                    message('请输入名称！');
                }
                $data = array(
                    'weid' => $_W['uniacid'], 
                    'title' => $_GPC['title'], 
                    'ftitle' => $_GPC['ftitle'], 
                    'fztype' => $_GPC['fztype'], //1 首页  2 会员中心
                    'url' => $_GPC['url'], 
                    'pic' => $_GPC['pic'], 
                    'hd' => $_GPC['hd'], 
                    'fqcat' => $_GPC['fqcat'], //分类ID
                    'type' => $_GPC['type'], //1 H5链接  2APP分类                  
                    'createtime' => TIMESTAMP,);               
                if (!empty($id)){
                    pdo_update("tiger_newhu_xcxdh", $data, array('id' => $id));
                }else{
                    pdo_insert("tiger_newhu_xcxdh", $data);
                }
                message('图标更新成功！', $this -> createWebUrl('dh', array('op' => 'display')), 'success');
            }
        }else if ($operation == 'delete'){
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT id FROM " . tablename("tiger_newhu_xcxdh") . " WHERE id = :id", array(':id' => $id));
            if (empty($row)){
                message('抱歉，导航' . $id . '不存在或是已经被删除！');
            }
            pdo_delete("tiger_newhu_xcxdh", array('id' => $id));
            message('删除成功！', referer(), 'success');
        }else if ($operation == 'display'){
            $condition = '';
            $list = pdo_fetchall("SELECT * FROM " . tablename("tiger_newhu_xcxdh") . " WHERE weid = '{$_W['uniacid']}'  ORDER BY id desc");
           
        }
        include $this -> template('dh');