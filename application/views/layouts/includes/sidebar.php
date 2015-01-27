<?php if($this->session->userdata('previllege') == 'admin') :?>

  <div class="panel panel-default panel-list"><!-- Products -->
    <div class="panel-heading panel-heading-dark">
      <h3 class="panel-title">Products</h3>
    </div>
    <ul class="list-group">
      <li class="list-group-item"><a href="<?php echo base_url(); ?>admin/all_products">All Products</a></li>
      <li class="list-group-item"><a href="<?php echo base_url(); ?>admin/products_by_category">Product by Category</a></li>
      <li class="list-group-item"><a href="<?php echo base_url(); ?>admin/categories">Categories</a></li>
    </ul>
  </div><!--/Products -->

  <div class="panel panel-default panel-list"><!-- Order Report -->
    <div class="panel-heading panel-heading-dark">
      <h3 class="panel-title">Order Reports</h3>
    </div>
    <ul class="list-group">
      <li class="list-group-item"><a href="<?php echo base_url(); ?>admin/all_orders">All Order Items</a></li>
      <li class="list-group-item"><a href="<?php echo base_url(); ?>admin/orders_by_status/pending">Pending Orders</a></li>
    </ul>
  </div><!--/Order Report -->

<?php else : ?>

  <div class="cart-block"><!-- Cart block in left sidebar -->
    <form action="cart/update" method="post">
      <table cellpadding="6" cellspacing="1" style="width:100%" border="0">
        <tr>
          <th>QTY</th>
          <th>Description</th>
          <th style="text-align:right">Price</th>
        </tr>
        <?php $i  = 1; ?>
        <?php foreach ($this->cart->contents() as $items): ?>
            <input type="hidden" name="<?php echo $i.'[rowid]'; ?>" value="<?php echo $items['rowid']; ?>" />
            <tr>
              <td><input type="text" name="<?php echo $i.'[qty]'; ?>" value="<?php echo $items['qty']; ?>" maxlength="2" class="sidebar-cart-qty" /></td>
              <td class="right"><?php echo $items['name']; ?></td>
              <td class="right" style="text-align:right">Rs.<?php echo $this->cart->format_number($items['price']); ?></td>
            </tr>
          <?php $i++; ?>
        <?php endforeach; ?>
        <tr>
          <td></td>
          <td class="right"><strong>Total</strong></td>
          <td style="text-align:right"><?php echo $this->cart->format_number($this->cart->total()); ?></td>
        </tr>
      </table>
      <br />
      <p>
        <button class="btn btn-default" type="submit">Update Cart</button>
        <a class="btn btn-default" href="cart">Go To Cart</a>
      </p>
    </form>
  </div><!-- /Cart block -->

  <div class="panel panel-default panel-list"><!-- Categories panel -->
    <div class="panel-heading panel-heading-dark">
      <h3 class="panel-title">Categories</h3>
    </div>
    <ul class="list-group">
      <?php foreach(get_categories_h() as $category) : ?>
        <li class="list-group-item"><a href="<?php echo base_url(); ?>products/category/<?php echo $category->id; ?>"><?php echo $category->name; ?></a></li>
      <?php endforeach; ?>
    </ul>
  </div><!--/Categories panel -->

  <div class="panel panel-default panel-list"><!-- Most Popular panel -->
    <div class="panel-heading panel-heading-dark">
      <h3 class="panel-title">Most Popular</h3>
    </div>
    <ul class="list-group">
      <?php foreach(get_popular_h() as $popular) : ?>
        <li class="list-group-item"><a href="<?php echo base_url(); ?>products/details/<?php echo $popular->id; ?>"><?php echo $popular->title; ?></a></li>
      <?php endforeach; ?>
    </ul>
  </div><!--/Most Popular panel -->
<?php endif; ?>
