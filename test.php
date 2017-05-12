<?php
define('IN_ECS', true);
header("Content-type: text/html; charset=gbk");
require(dirname(__FILE__) . '/includes/init.php');

require_once '../includes/phpexcel/PHPExcel.php';     //修改为自己的目录

$data = format_excel2array('test.xlsx');
$time = time();
foreach ($data as $key=>$val){
	//处理分公司
	$depart = array();
	$control = array();
	$park = array();
	$building = array();
	$company = array();
	if($val['J']){
		$sql = "select * from chj_depart where name='".$val['J']."'";
		$depart = $GLOBALS['db']->getAll($sql);
		if(!count($depart)){
			$sql2 = "insert into chj_depart (name,add_time,update_time) values ('".$val['J']."','$time','$time')";
			$depart_res = $GLOBALS['db']->query($sql2);
		}
	}
	//处理管理处
	if(isset($depart[0]['id']) && $val['K']){
		$depart_id = $depart[0]['id'];
		$sql3 = "select * from chj_control where name='".$val['K']."' and depart_id=$depart_id";
		$control = $GLOBALS['db']->getAll($sql3);
		if(!count($control)){
			$sql4 = "insert into chj_control (name,depart_id,add_time,update_time) values ('".$val['K']."',$depart_id,'$time','$time')";
			$control_res = $GLOBALS['db']->query($sql4);
		}
	}
	//处理园区
	if(isset($control[0]['id']) && $val['D']){
		$control_id = $control[0]['id'];
		$sql5 = "select * from chj_park where park_name='".$val['D']."' and depart_id=$depart_id and control_id=$control_id";
		$park = $GLOBALS['db']->getAll($sql5);
		if(!count($park)){
			$sql6 = "insert into chj_park (park_name,depart_id,control_id,create_time,update_time) values ('".$val['D']."',$depart_id,$control_id,'$time','$time')";
			$park_res = $GLOBALS['db']->query($sql6);
		}
	}
	//处理楼宇
	if(isset($park[0]['park_id']) && $val['G']){
		$park_id = $park[0]['park_id'];
		$sql7 = "select * from chj_park_building where name='".$val['G']."' and depart_id=$depart_id and park_id=$park_id";
		$building = $GLOBALS['db']->getAll($sql7);
		if(!count($building)){
			$sql8 = "insert into chj_park_building (name,depart_id,park_id,add_time,update_time) values ('".$val['G']."',$depart_id,$park_id,'$time','$time')";
			$building_res = $GLOBALS['db']->query($sql8);
		}
	}
	//处理公司
	if(isset($building[0]['id']) && $val['A']){
		$building_id = $building[0]['id'];
		$sql9 = "select * from chj_enterprise where name='".$val['A']."' and depart_id=$depart_id and park_id=$park_id and building_id=$building_id and control_id=$control_id";
		$company = $GLOBALS['db']->getAll($sql9);
		if(!count($company)){
			$sql10 = "insert into chj_enterprise (name,road,doorplate,floor,room,depart_id,park_id,control_id,building_id,add_time,update_time) values ('".$val['A']."','".$val['E']."','".$val['F']."','".$val['H']."','".$val['I']."',$depart_id,$park_id,$control_id,$building_id,'$time','$time')";
			$company_res = $GLOBALS['db']->query($sql10);
		}
	}
}
exit;

function format_excel2array($filePath='',$sheet=0){
        if(empty($filePath) or !file_exists($filePath)){die('file not exists');}
        $PHPReader = new PHPExcel_Reader_Excel2007();        //建立reader对象
        if(!$PHPReader->canRead($filePath)){
                $PHPReader = new PHPExcel_Reader_Excel5();
                if(!$PHPReader->canRead($filePath)){
                        echo 'no Excel';
                        return ;
                }
        }
        $PHPExcel = $PHPReader->load($filePath);        //建立excel对象
        $currentSheet = $PHPExcel->getSheet($sheet);        //**读取excel文件中的指定工作表*/
        $allColumn = $currentSheet->getHighestColumn();        //**取得最大的列号*/
        $allRow = $currentSheet->getHighestRow();        //**取得一共有多少行*/
        $data = array();
        for($rowIndex=1;$rowIndex<=$allRow;$rowIndex++){        //循环读取每个单元格的内容。注意行从1开始，列从A开始
                for($colIndex='A';$colIndex<=$allColumn;$colIndex++){
                        $addr = $colIndex.$rowIndex;
                        $cell = $currentSheet->getCell($addr)->getValue();
                        if($cell instanceof PHPExcel_RichText){ //富文本转换字符串
                                $cell = $cell->__toString();
                        }
                        $data[$rowIndex][$colIndex] = $cell;
                }
        }
        unset($data[1]);
        $newdata = array_values($data);
        return $newdata;
}






/* 把商品删除关联 */
function drop_link_goods($goods_id, $article_id)
{
    $sql = "DELETE FROM " . $GLOBALS['ecs']->table('goods_article') .
            " WHERE goods_id = '$goods_id' AND article_id = '$article_id' LIMIT 1";
    $GLOBALS['db']->query($sql);
    create_result(true, '', $goods_id);
}

/* 取得文章关联商品 */
function get_article_goods($article_id)
{
    $list = array();
    $sql  = 'SELECT g.goods_id, g.goods_name'.
            ' FROM ' . $GLOBALS['ecs']->table('goods_article') . ' AS ga'.
            ' LEFT JOIN ' . $GLOBALS['ecs']->table('goods') . ' AS g ON g.goods_id = ga.goods_id'.
            " WHERE ga.article_id = '$article_id'";
    $list = $GLOBALS['db']->getAll($sql);

    return $list;
}

/* 获得文章列表 */
function get_articleslist()
{
    $result = get_filter();
    if ($result === false)
    {
        $filter = array();
        $filter['keyword']    = empty($_REQUEST['keyword']) ? '' : trim($_REQUEST['keyword']);
        if (isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
        {
            $filter['keyword'] = json_str_iconv($filter['keyword']);
        }
        $filter['cat_id'] = empty($_REQUEST['cat_id']) ? 0 : intval($_REQUEST['cat_id']);
        $filter['sort_by']    = empty($_REQUEST['sort_by']) ? 'a.article_id' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

        $where = '';
        if (!empty($filter['keyword']))
        {
            $where = " AND a.title LIKE '%" . mysql_like_quote($filter['keyword']) . "%'";
        }
        if ($filter['cat_id'])
        {
            $where .= " AND a." . get_article_children($filter['cat_id']);
        }

        /* 文章总数 */
        $sql = 'SELECT COUNT(*) FROM ' .$GLOBALS['ecs']->table('article'). ' AS a '.
               'LEFT JOIN ' .$GLOBALS['ecs']->table('article_cat'). ' AS ac ON ac.cat_id = a.cat_id '.
               'WHERE 1 ' .$where;
        $filter['record_count'] = $GLOBALS['db']->getOne($sql);

        $filter = page_and_size($filter);

        /* 获取文章数据 */
        $sql = 'SELECT a.* , ac.cat_name '.
               'FROM ' .$GLOBALS['ecs']->table('article'). ' AS a '.
               'LEFT JOIN ' .$GLOBALS['ecs']->table('article_cat'). ' AS ac ON ac.cat_id = a.cat_id '.
               'WHERE 1 ' .$where. ' ORDER by '.$filter['sort_by'].' '.$filter['sort_order'];

        $filter['keyword'] = stripslashes($filter['keyword']);
        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }
    $arr = array();
    $res = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']);

    while ($rows = $GLOBALS['db']->fetchRow($res))
    {
        $rows['date'] = local_date($GLOBALS['_CFG']['time_format'], $rows['add_time']);

        $arr[] = $rows;
    }
    return array('arr' => $arr, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
}

/* 获得新闻列表 */
function get_articleslistnews()
{
	$filter = array();
	$filter['keyword']    = empty($_REQUEST['keyword']) ? '' : trim($_REQUEST['keyword']);
	if (isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
	{
		$filter['keyword'] = json_str_iconv($filter['keyword']);
	}
	$filter['cat_id'] = empty($_REQUEST['cat_id']) ? 0 : intval($_REQUEST['cat_id']);
	$filter['sort_by']    = empty($_REQUEST['sort_by']) ? 'a.sort' : trim($_REQUEST['sort_by']);
	$filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

	$where = '';
	if (!empty($filter['keyword']))
	{
		$where = " AND a.title LIKE '%" . mysql_like_quote($filter['keyword']) . "%'";
	}
	if ($filter['cat_id'])
	{
		$where .= " AND a." . get_article_children($filter['cat_id'],1);
	}

	/* 文章总数 */
	$sql = 'SELECT COUNT(*) FROM ' .$GLOBALS['ecs']->table('wechat_media'). ' AS a '.
		   'LEFT JOIN ' .$GLOBALS['ecs']->table('article_cat'). ' AS ac ON ac.cat_id = a.cat_id '.
		   'WHERE a.wechat_id=1 AND  a.is_delete=0 AND a.type=\'news\' ' .$where;
	$filter['record_count'] = $GLOBALS['db']->getOne($sql);

	$filter = page_and_size($filter);

	/* 获取文章数据 */
	$sql = 'SELECT a.* , ac.cat_name '.
		   'FROM ' .$GLOBALS['ecs']->table('wechat_media'). ' AS a '.
		   'LEFT JOIN ' .$GLOBALS['ecs']->table('article_cat'). ' AS ac ON ac.cat_id = a.cat_id '.
		   'WHERE a.wechat_id=1 AND  a.is_delete=0 AND a.type=\'news\'' .$where. ' ORDER by '.$filter['sort_by'].' '.$filter['sort_order'];

	$filter['keyword'] = stripslashes($filter['keyword']);

    $arr = array();
    $res = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']);

    while ($rows = $GLOBALS['db']->fetchRow($res))
    {
        $rows['date'] = local_date($GLOBALS['_CFG']['time_format'], $rows['add_time']);
		//$rows['date'] =date("Y-m-d H:i:s", $rows['add_time']);

        $arr[] = $rows;
    }
    return array('arr' => $arr, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
}

/* 上传文件 */
function upload_article_file($upload)
{
    if (!make_dir("../" . DATA_DIR . "/article"))
    {
        /* 创建目录失败 */
        return false;
    }

    $filename = cls_image::random_filename() . substr($upload['name'], strpos($upload['name'], '.'));
    $path     = ROOT_PATH. DATA_DIR . "/article/" . $filename;

    if (move_upload_file($upload['tmp_name'], $path))
    {
        return DATA_DIR . "/article/" . $filename;
    }
    else
    {
        return false;
    }
}

?>