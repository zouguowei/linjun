<?php

/**
 * 站点抓取
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require(dirname(__FILE__) . '/includes/cls_spider.php');

$spider = new cls_spider();
if($_REQUEST['site_name']){
	//header("Content-type: text/html; charset=gb2312");
	$curl_list = $spider->curl_list();
	$smarty->assign("list_title", $curl_list['list_title']);
	$smarty->assign("list_title_img", $curl_list['list_title_img']);
	$smarty->assign("title_head", $curl_list['title_head']);
	$smarty->assign("title_foot", $curl_list['title_foot']);
	$smarty->assign("title_replace", $curl_list['title_replace']);
	$smarty->assign("keywords_head", $curl_list['keywords_head']);
	$smarty->assign("keywords_foot", $curl_list['keywords_foot']);
	$smarty->assign("keywords_replace", $curl_list['keywords_replace']);
	$smarty->assign("description_head", $curl_list['description_head']);
	$smarty->assign("description_foot", $curl_list['description_foot']);
	$smarty->assign("description_replace", $curl_list['description_replace']);
	$smarty->assign("content_head", $curl_list['content_head']);
	$smarty->assign("content_foot", $curl_list['content_foot']);
	$smarty->assign("content_replace", $curl_list['content_replace']);
	$smarty->assign("cat_id", $curl_list['cat_id']);
	$smarty->assign("image_name", $curl_list['image_name']);
	$smarty->assign("curl_list", $curl_list['site_url_str']);
	$smarty->assign("is_siteurl", $curl_list['is_siteurl']);
	$smarty->assign("is_siteurl_str", $curl_list['is_siteurl_str']);
	$smarty->display('spider_list.dwt');
}elseif($_REQUEST['detail']){
	$curl_detail = $spider->curl_detail();
}elseif($_REQUEST['image']){
	exit;
	$change_image = $spider->change_image();
	$curdate = date("Y-m-d",time());
	if(!file_exists("data/images/$curdate")){
    	mkdir("data/images/$curdate");
    }
	foreach ($change_image as $key=>$val){
		preg_match_all('/<img.*?src=[\"|\']?(.*?)[\"|\']?\s.*?>/i',$val['content'],$imgsrc);
		foreach ($imgsrc[1] as $ikey=>$ival){
			$add_time = time();
			$houzui = explode(".", $ival);
    		$houzui1_key = count($houzui)-1;
    		$houzui1 = $houzui[$houzui1_key];
    		if(strstr($houzui1, "?")){
    			$houzui2 = explode("?", $houzui1);
    			$houzui_new = $add_time.$ikey.".".$houzui2[0];
    		}else{
    			$houzui_new = $add_time.$ikey.".".$houzui1;
    		}
			if(file_exists($ival)){
				file_put_contents("data/images/$curdate/$houzui_new", file_get_contents($ival));
			}else{
				if(file_exists("http://img.kuqin.com".$ival)){
					
				}
			}
			$content_new = str_replace($ival,"http://www.zouguowei.com/data/images/$curdate/$houzui_new",$val);
		}
	}
}elseif($_REQUEST['uploadimage']){
	$updateres = $spider->uploadimage($_REQUEST['uploadimage'],$_REQUEST['id']);
}else{
	if(isset($_REQUEST['id'])){
		$formdata = $spider->select($_REQUEST['id']);
		echo json_encode($formdata);exit;
	}else{
		$formdata = $spider->select();
		$smarty->assign("formdata", $formdata);
		$smarty->display('spider.dwt');
	}
}
?>