<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ECSHOP v3.0.0" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />
<?php if ($this->_var['auto_redirect']): ?>
<meta http-equiv="refresh" content="3;URL=<?php echo $this->_var['message']['href']; ?>" />
<?php endif; ?>

<title><?php echo $this->_var['page_title']; ?></title>

<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js')); ?>
</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>

  <?php echo $this->fetch('library/ur_here.lbi'); ?>
<div class="block">
  <div class="flowBox">
    <h6><span><?php echo $this->_var['lang']['print_quotation']; ?></span></h6>
    <form action="quotation.php" method="post" name="searchForm" target="_blank" class="quotation">
      
      <select name="cat_id" style="vertical-align:middle;"><option value="0"><?php echo $this->_var['lang']['all_category']; ?></option><?php echo $this->_var['cat_list']; ?></select>
      
      <select name="brand_id" style="vertical-align:middle;"><option value="0"><?php echo $this->_var['lang']['all_brand']; ?></option><?php echo $this->html_options(array('options'=>$this->_var['brand_list'])); ?></select>
      
      <?php echo $this->_var['lang']['keywords']; ?> <input type="text" name="keyword" class="inputBg" style="vertical-align:middle;"/>
      
      <input name="act" type="hidden" value="print_quotation" />
      <input type="submit" name="print_quotation" id="print_quotation" value="<?php echo $this->_var['lang']['print_quotation']; ?>" style="vertical-align:middle;" class="bnt_blue_1" />
    </form>
  </div>  
  
</div>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>
