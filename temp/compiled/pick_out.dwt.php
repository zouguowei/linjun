<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ECSHOP v3.0.0" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />

<title><?php echo $this->_var['page_title']; ?></title>

<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />


<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,lefttime.js')); ?>
<script type="text/javascript">
  <?php $_from = $this->_var['lang']['js_languages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
    var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</script>
</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>

  <?php echo $this->fetch('library/ur_here.lbi'); ?>

<div class="block clearfix">
  
  <div class="AreaL">
    
    <?php echo $this->fetch('library/categorys.lbi'); ?>
    
    <div class="box">
     <div class="box_1">
      <h3><span><?php echo $this->_var['lang']['your_choice']; ?></span></h3>
      <div class="boxCenterList clearfix">
        <ul>
        <?php $_from = $this->_var['picks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'pick');if (count($_from)):
    foreach ($_from AS $this->_var['pick']):
?>
        <li style="word-break:break-all;"><a href="<?php echo $this->_var['pick']['url']; ?>"><?php echo $this->_var['pick']['name']; ?></a></li>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
       </ul>
      </div>
     </div>
    </div>
    <div class="blank5"></div>
    
    
    
  </div>
  
  
  <div class="AreaR">
   <div class="box">
   <div class="box_1">
    <h3><span><?php echo $this->_var['lang']['pick_out']; ?></span></h3>
    <div class="boxCenterList">
      <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
      <?php $_from = $this->_var['condition']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'caption');if (count($_from)):
    foreach ($_from AS $this->_var['caption']):
?>
      <tr>
        <td bgcolor="#e5ecfb" style="border-bottom: 1px solid #DADADA">
          <img src="themes/ecmoban_zsxn/images/note.gif" alt="no alt" />&nbsp;&nbsp;<strong class="f_red"><?php echo $this->_var['caption']['name']; ?></strong></td>
      </tr>
      <?php $_from = $this->_var['caption']['cat']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');if (count($_from)):
    foreach ($_from AS $this->_var['cat']):
?>
      <tr>
        <td bgcolor="#ffffff">&nbsp;&nbsp;<strong><?php echo $this->_var['cat']['cat_name']; ?></strong></td>
      </tr>
      <tr>
        <td bgcolor="#ffffff">&nbsp;&nbsp;
          <?php $_from = $this->_var['cat']['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
          &nbsp;&nbsp;<a href="<?php echo $this->_var['list']['url']; ?>" class="f6"><?php echo $this->_var['list']['name']; ?></a>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </td>
      </tr>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
    </div>
   </div>
  </div>
   <div class="blank5"></div>
   <div class="box">
   <div class="box_1">
    <h3><span><?php echo $this->_var['lang']['search_result']; ?> (<?php echo $this->_var['count']; ?>)</span><div class="more f_r"  ><a href="<?php echo $this->_var['url']; ?>">更多</a></div></h3>
    <div class="boxCenterList clearfix">
     <?php $_from = $this->_var['pickout_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['goods']['iteration']++;
?>
     <div class="goodsItem clearfix" style=" height: auto; padding: 10px 2px 15px 0px;">
           <a href="<?php echo $this->_var['goods']['url']; ?>"><img src="<?php echo $this->_var['goods']['thumb']; ?>" alt="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>" class="goodsimg" /></a><br />
           <p><a href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>"><?php echo $this->_var['goods']['short_name']; ?></a></p>
				
           <font class="f1">
           <?php if ($this->_var['goods']['promote_price'] != ""): ?>
          <?php echo $this->_var['lang']['promote_price']; ?><?php echo $this->_var['goods']['promote_price']; ?>
          <?php else: ?>
          <?php echo $this->_var['lang']['shop_price']; ?><?php echo $this->_var['goods']['shop_price']; ?>
          <?php endif; ?>
           </font>
        </div>
     <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
     <?php if ($this->_var['count'] > 5): ?>
     
     <?php endif; ?>
    </div>
   </div>
  </div>

  </div>
  
</div>

<div class="blank"></div>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
<script type="text/javascript">
var gmt_end_time = "<?php echo empty($this->_var['group_buy']['gmt_end_date']) ? '0' : $this->_var['group_buy']['gmt_end_date']; ?>";
<?php $_from = $this->_var['lang']['goods_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

var btn_buy = "<?php echo $this->_var['lang']['btn_buy']; ?>";
var is_cancel = "<?php echo $this->_var['lang']['is_cancel']; ?>";
var select_spe = "<?php echo $this->_var['lang']['select_spe']; ?>";


onload = function()
{
  try
  {
    onload_leftTime();
  }
  catch (e)
  {}
}

</script>
</html>
