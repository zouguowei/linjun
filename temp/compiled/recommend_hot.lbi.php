<?php if ($this->_var['hot_goods']): ?>
<?php if ($this->_var['cat_rec_sign'] != 1): ?>
<div class="xm-box">
  <h4 class="title"><span>热卖商品</span> <a class="more" href="search.php?intro=hot"> </a></h4>
  <div class="indexw_content_4_top"></div>
  <div id="show_hot_area" class="clearfix"> 

    <?php $_from = $this->_var['hot_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_0_90053000_1483617169');if (count($_from)):
    foreach ($_from AS $this->_var['goods_0_90053000_1483617169']):
?>
    <div class="goodsItem"> <a href="<?php echo $this->_var['goods_0_90053000_1483617169']['url']; ?>"><img src="<?php echo $this->_var['goods_0_90053000_1483617169']['thumb']; ?>" alt="<?php echo htmlspecialchars($this->_var['goods_0_90053000_1483617169']['name']); ?>" class="goodsimg" /></a><br />
      <p class="f1"><a href="<?php echo $this->_var['goods_0_90053000_1483617169']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods_0_90053000_1483617169']['name']); ?>"><?php echo $this->_var['goods_0_90053000_1483617169']['short_style_name']; ?></a></p>
      <p>
      市场价：<font class="market"><?php echo $this->_var['goods_0_90053000_1483617169']['market_price']; ?></font> <br/>
      本店价：<font class="f1"> 
      <?php if ($this->_var['goods_0_90053000_1483617169']['promote_price'] != ""): ?> 
      <?php echo $this->_var['goods_0_90053000_1483617169']['promote_price']; ?> 
      <?php else: ?> 
      <?php echo $this->_var['goods_0_90053000_1483617169']['shop_price']; ?> 
      <?php endif; ?> 
      </font> 
      </p>
      </div>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
    
    
  </div>
</div>
<div class="blank"></div>
<?php endif; ?> 
<?php endif; ?> 
