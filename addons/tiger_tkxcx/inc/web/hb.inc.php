<?php
 global $_W;
        global $_GPC;
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        if ($operation == 'post'){
            $id = intval($_GPC['id']);
            if (!empty($id)){
                $item = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_hb") . " WHERE id = :id" , array(':id' => $id));
                if (empty($item)){
                    message('抱歉，海报不存在或是已经删除！', '', 'error');
                }
            }
            if (checksubmit('submit')){
                if (empty($_GPC['pic'])){
                    message('背景图片必须上传！');
                }
                $data = array(
                    'weid' => $_W['weid'], 
                    'pic' => $_GPC['pic'], 
                    'createtime' => TIMESTAMP,);               
                if (!empty($id)){
                    pdo_update($this->modulename."_hb", $data, array('id' => $id));
                }else{
                    pdo_insert($this->modulename."_hb", $data);
                }
                message('海报更新成功！', $this -> createWebUrl('hb', array('op' => 'display')), 'success');
            }
        }else if ($operation == 'delete'){
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT id FROM " . tablename($this->modulename."_hb") . " WHERE id = :id", array(':id' => $id));
            if (empty($row)){
                message('抱歉，海报' . $id . '不存在或是已经被删除！');
            }
            pdo_delete($this->modulename."_hb", array('id' => $id));
            message('删除成功！', referer(), 'success');
        }else if ($operation == 'display'){
            $condition = '';
            $list = pdo_fetchall("SELECT * FROM " . tablename($this->modulename."_hb") . " WHERE weid = '{$_W['uniacid']}'  ORDER BY id desc");
           
        }
        include $this -> template('hb');
?>