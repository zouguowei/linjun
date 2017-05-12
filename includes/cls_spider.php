<?php

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

class cls_spider
{
	var $site_name  = '';
    var $site_url_head  = '';
    var $site_url_foot  = '';
    var $list_head      = '';
    var $list_foot      = '';
    var $list_title     = '';
    var $list_title_img     = '';
    var $pagesize       = 10;
    var $title_head          = '';
    var $title_foot     = '';
    var $keywords_head  = '';
    var $keywords_foot  = '';
    var $description_head    = '';
    var $description_foot    = '';
    var $content_head   = '';
    var $content_foot   = '';
    var $title_replace     = '';
    var $keywords_replace     = '';
    var $description_replace     = '';
    var $content_replace     = '';
    var $cat_id     = '';
    var $image_name     = '';
    var $detail     = '';
    var $detail_img     = '';
    var $is_siteurl     = '';//是否指定网站域名
    var $is_siteurl_str     = '';

    function __construct(){
    	foreach ($_REQUEST as $rkey=>$rval){
    		$_REQUEST[$rkey] = str_replace("\\", "", $rval);
    	}
    	$this->site_name = $_REQUEST['site_name'];
        $this->site_url_head = $_REQUEST['site_url_head'];
        $this->site_url_foot = $_REQUEST['site_url_foot'];
        $this->list_head = $_REQUEST['list_head'];
        $this->list_foot = $_REQUEST['list_foot'];
        $this->list_title = $_REQUEST['list_title'];
        $this->list_title_img = $_REQUEST['list_title_img'];
        $this->pagesize = $_REQUEST['pagesize'] ? $_REQUEST['pagesize'] : $this->pagesize;
        $this->title_head    = $_REQUEST['title_head'];
        $this->keywords_head = $_REQUEST['keywords_head'];
        $this->description_head = $_REQUEST['description_head'];
        $this->title_foot    = $_REQUEST['title_foot'];
        $this->keywords_foot = $_REQUEST['keywords_foot'];
        $this->description_foot = $_REQUEST['description_foot'];
        $this->content_head = $_REQUEST['content_head'];
        $this->content_foot = $_REQUEST['content_foot'];
        $this->title_replace = $_REQUEST['title_replace'];
        $this->keywords_replace = $_REQUEST['keywords_replace'];
        $this->description_replace = $_REQUEST['description_replace'];
        $this->content_replace = $_REQUEST['content_replace'];
        $this->cat_id = $_REQUEST['cat_id'];
        $this->image_name = $_REQUEST['image_name'];
        $this->detail = $_REQUEST['detail'];
        $this->detail_img = $_REQUEST['detail_img'];
        $this->is_siteurl = $_REQUEST['is_siteurl'];
        $this->is_siteurl_str = $_REQUEST['is_siteurl_str'];
        $this->cur_site_url = "http://".$_SERVER['SERVER_NAME']."/";
    }

    function curl_list(){
        $site_url = "";
        $site_url_str = "";
        for($i=$this->pagesize;$i>0;$i--){
        	$site_url = $this->site_url_head.$i.$this->site_url_foot;
        	$site_list = file_get_contents($site_url);
        	$site_list_1 = explode($this->list_head, $site_list);
        	$site_list_2 = explode($this->list_foot, $site_list_1[1]);
        	$site_list_new = $site_list_2[0];
        	$site_url_str .= $site_list_new;
        }
        $result['list_title'] = $this->list_title;
        $result['list_title_img'] = $this->list_title_img;
        $result['title_head'] = $this->title_head;
        $result['title_foot'] = $this->title_foot;
        $result['title_replace'] = $this->title_replace;
        $result['keywords_head'] = $this->keywords_head;
        $result['keywords_foot'] = $this->keywords_foot;
        $result['keywords_replace'] = $this->keywords_replace;
        $result['description_head'] = $this->description_head;
        $result['description_foot'] = $this->description_foot;
        $result['description_replace'] = $this->description_replace;
        $result['content_head'] = $this->content_head;
        $result['content_foot'] = $this->content_foot;
        $result['content_replace'] = $this->content_replace;
        $result['cat_id'] = $this->cat_id;
        $result['image_name'] = $this->image_name;
        $result['is_siteurl'] = $this->is_siteurl;
        $result['is_siteurl_str'] = $this->is_siteurl_str;
        $result['site_url_str'] = $site_url_str;
        $site_name = $this->select($this->site_name);
        if($site_name[0]['site_name']){
        	$this->update($_POST, $this->site_name);
        }else{
        	$this->insert($_POST);
        }
        return $result;
    }

    function curl_detail(){
    	$detail_url = explode("###", $this->detail);
    	$detail_img_url = explode("###", $this->detail_img);
    	$res_title = array();
    	$image_name = $this->image_name;
    	foreach ($detail_url as $key => $val) {
    		$add_time = time();
    		if($this->is_siteurl){
    			$detailContent = file_get_contents($this->is_siteurl_str.$val);
    		}else{
    			$detailContent = file_get_contents($val);
    		}
    		$houzui = explode(".", $detail_img_url[$key]);
    		$houzui1_key = count($houzui)-1;
    		$houzui1 = $houzui[$houzui1_key];
    		if(strstr($houzui1, "?")){
    			$houzui2 = explode("?", $houzui1);
    			$houzui2_c = $houzui2[0];
    			if(!$houzui2[0]){
    				$houzui2_c = "jpg";
    			}
    			$houzui_new = $add_time.$key.".".$houzui2_c;
    		}else{
    			if(!$houzui1){
    				$houzui1 = "jpg";
    			}
    			$houzui_new = $add_time.$key.".".$houzui1;
    		}
    		if(!file_exists("data/images/$image_name")){
    			mkdir("data/images/$image_name");
    		}
    		if($detail_img_url[$key]){
    			file_put_contents("data/images/$image_name/$houzui_new", file_get_contents($detail_img_url[$key]));
    		}
    		$file_url = "data/images/$image_name/$houzui_new";
    		if(!file_exists($file_url)){
    			$file_url = $GLOBALS['_CFG']['no_picture'];
    		}
    		$title = explode($this->title_head, $detailContent);
    		$title1 = explode($this->title_foot, $title[1]);
    		$title2 = $title1[0];
    		$keywords = explode($this->keywords_head, $detailContent);
    		$keywords1 = explode($this->keywords_foot, $keywords[1]);
    		$keywords2 = $keywords1[0];
    		$keywords_new = str_replace("'", "", str_replace($this->keywords_replace, "", $keywords2));
    		$description = explode($this->description_head, $detailContent);
    		$description1 = explode($this->description_foot, $description[1]);
    		$description2 = $description1[0];
    		$description_new = str_replace("'", "", str_replace($this->description_replace, "", $description2));
    		$content = explode($this->content_head, $detailContent);
    		$content1 = explode($this->content_foot, $content[1]);
    		$content2 = $content1[0];
    		$content_new = str_replace($detail_img_url[$key],$this->cur_site_url."data/images/$image_name/$houzui_new",str_replace("'", "", str_replace($this->content_replace, "", $content2)));
    		$cat_id = $this->cat_id;
    		$title2 = $this->gbk2utf8($title2);
    		$content_new = $this->gbk2utf8($content_new);
    		$keywords_new = $this->gbk2utf8($keywords_new);
    		$description_new = $this->gbk2utf8($description_new);
    		$sql = "insert into zgw_article (cat_id,title,content,add_time,file_url,keywords,description,is_spider) values ($cat_id,'$title2','$content_new','$add_time','$file_url','$keywords_new','$description_new',1)";
			$result = $GLOBALS['db']->query($sql);
			if($result){
				$res_title[] = $title2."\n";
			}
    	}
    	echo json_encode($res_title);exit;
    }
    
    function uploadimage($uploadimage,$id){
		$content = $GLOBALS['db']->getAll("select content from zgw_article where article_id=$id");
    	$uploadimage = explode("###", $uploadimage);
    	$image_name = date("Y-m",time());
    	$content_new = $content[0]['content'];
    	foreach ($uploadimage as $key=>$val){
	    	$houzui = explode(".", $val);
	    	$houzui1_key = count($houzui)-1;
	    	$houzui1 = $houzui[$houzui1_key];
    		if(strstr($houzui1, "?")){
    			$houzui2 = explode("?", $houzui1);
    			$houzui2_c = $houzui2[0];
    			if(!$houzui2[0]){
    				$houzui2_c = "jpg";
    			}
    			$houzui_new = $add_time.$key.".".$houzui2_c;
    		}else{
    			if(!$houzui1){
    				$houzui1 = "jpg";
    			}
    			$houzui_new = $add_time.$key.".".$houzui1;
    		}
	    	if(!file_exists("data/images/$image_name")){
	    		mkdir("data/images/$image_name");
	    	}
	    	echo $houzui_new;exit;
	    	if($val){
	    		file_put_contents("data/images/$image_name/$houzui_new", file_get_contents($val));
	    	}
	    	$file_url = "http://www.zouguowei.com/data/images/$image_name/$houzui_new";
	    	echo $file_url;exit;
	    	if(!file_exists($file_url)){
	    		$file_url = $GLOBALS['_CFG']['no_picture'];
	    	}
	    	$content_new = str_replace($val, $file_url, $content_new);
    	}
    	$updateres = $GLOBALS['db']->query("update zgw_article set content='$content_new' where article_id=$id");
    	if($updateres){
    		echo "1";exit;
    	}else{
    		echo "0";exit;
    	}
    }
    
    function change_image(){
    	$sql = "select content from zgw_article where article_id>=11162 limit 10";
		$result = $GLOBALS['db']->getAll($sql);
		return $result;
    }
    
	function select($ids=""){
		if($ids){
			$sql = "select * from zgw_spider where site_name='$ids'";
		}else{
			$sql = "select * from zgw_spider";
		}
        $result = $GLOBALS['db']->getAll($sql);
        return $result;
    }
    
    function update($options,$ids){
    	$data = array();
        foreach ($options as $key => $value) {
            $data[] = " `$key` = " . $this->escape($value);
        }
        $updateStr = implode(',', $data);
        $sql = "update zgw_spider set $updateStr where site_name='$ids'";
        $result = $GLOBALS['db']->query($sql);
		return $result;
    }
    
	function insert($options){
    	$data = array();
        $data['fields'] = array_keys($options);
        $data['values'] = $this->escape(array_values($options));
        $insertStr = " (`" . implode("`,`", $data['fields']) . "`) VALUES (" . implode(",", $data['values']) . ") ";
    	$sql = "insert into zgw_spider $insertStr";
		$result = $GLOBALS['db']->query($sql);
		return $result;
	}
    
	//数据过滤
    public function escape($value) {
        if (is_array($value)) {
            return array_map(array($this, 'escape'), $value);
        } else {
            if (get_magic_quotes_gpc()) {
                //$value = stripslashes($value);
            }
            //return "'" . mysql_real_escape_string($value) . "'";
            return "'" . $value . "'";
        }
    }
    
	function gbk2utf8($str){ 
	    $charset = mb_detect_encoding($str,array('UTF-8','GBK','GB2312')); 
	    $charset = strtolower($charset); 
	    if('cp936' == $charset){ 
	        $charset='GBK'; 
	    } 
	    if("utf-8" != $charset){ 
	        $str = iconv($charset,"UTF-8//IGNORE",$str); 
	    } 
	    return $str; 
	}
}

?>