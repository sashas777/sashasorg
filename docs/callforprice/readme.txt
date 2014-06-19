Sashas Call for Price magento extension installation instructions with custom theme:

1.	Open file 
/app/design/frontend/{your_package}/{your_theme}/templates/catalog/product/list.phtml

Find two rows containing (first row for list view, second for grid view): 

<?php echo $this->getPriceHtml($_product, true) ?>

Replace each of  it with:

 <?php //echo $this->getPriceHtml($_product, true) ?>
 	<?php  /* Sashas_Callfor_Price */
     	     echo $this->getLayout()->createBlock('callforprice/listprice')->setProduct($_product)->setPrefix('')->toHtml();
    	    /* Sashas_Callfor_Price */
?>

Next    find two rows containing  (first row for list view, second for grid view):

<p><button type="button" title="<?php echo $this->__('Add to Cart') ?>" class="button btn-cart" onclick="setLocation('<?php echo $this->getAddToCartUrl($_product) ?>')"><span><span><?php echo $this->__('Add to Cart') ?></span></span></button></p>

Replace each of  it with:

<?php /* Sashas_Callfor_Price */
      echo $this->getLayout()->createBlock('callforprice/listcart')->setProduct($_product)->setAddUrl($this->getAddToCartUrl($_product))->toHtml();
     /* Sashas_Callfor_Price */
 ?>
 <!-- <p><button type="button" title="<?php echo $this->__('Add to Cart') ?>" class="button btn-cart" onclick="setLocation('<?php echo $this->getAddToCartUrl($_product) ?>')"><span><span><?php echo $this->__('Add to Cart') ?></span></span></button></p> -->



2.	Open file 
/app/design/frontend/{your_package}/{your_theme}/templates/catalog/product/view.phtml

Find row containing:

<?php echo $this->getChildHtml('product_type_data') ?>

Add after  it:

<?php  /* Sashas_Callfor_Price */
            	echo $this->getLayout()->createBlock('callforprice/callforprice')->toHtml();  
            	/* Sashas_Callfor_Price */
?>

	Next find row containing: 

	<?php  //echo $this->getChildHtml('addtocart') ?>

	Replace it with:

	<?php
         /* Sashas_Callfor_Price */
			echo $this->getLayout()->createBlock('callforprice/productaddto')->toHtml();          
           /* Sashas_Callfor_Price */
                    	?>

                    
3.	Open File

/app/design/frontend/{your_package}/{your_theme}/templates/catalog/product/view/options/wrapper/bottom.phtml

Replace:

<?php // echo $this->getChildHtml('', true, true);?>

With: 

<!-- Call for price addto cart button -->
    <?php // echo $this->getChildHtml('', true, true);?>
    <?php      
    echo $this->getLayout()->createBlock('callforprice/productaddto')->toHtml();    
    echo $this->getChildHtml('product.info.addto', true, true);
    ?>
   <!-- Call for price addto cart button -->

4. Please edit file /app/design/frontend/{your_package}/{your_theme}/templates/catalog/product/new.phtml according to original:
	http://sashas.org/docs/callforprice/new.txt
   Find row containing:
     <?php //echo $this->getPriceHtml($_product, true, '-new') ?>

    Replace with:
          <?php //echo $this->getPriceHtml($_product, true, '-new') ?>
          <?php  /* Sashas_Callfor_Price */                
                		echo $this->getLayout()->createBlock('callforprice/listprice')->setProduct($_product)->setPrefix('-new')->toHtml();             
                 /* Sashas_Callfor_Price */
           ?>

 Find row containing:
<button type="button" title="<?php echo $this->__('Add to Cart') ?>" class="button btn-cart" onclick="setLocation('<?php echo $this->getAddToCartUrl($_product) ?>')"><span><span><?php echo $this->__('Add to Cart') ?></span></span></button>

Replace with:

     <?php  /* Sashas_Callfor_Price */                         	
		echo $this->getLayout()->createBlock('callforprice/listcart')->setProduct($_product)->setAddUrl($this->getAddToCartUrl($_product))->toHtml();
		 /* Sashas_Callfor_Price */ 					?>                   
        <!-- <button type="button" title="<?php echo $this->__('Add to Cart') ?>" class="button btn-cart" onclick="setLocation('<?php echo $this->getAddToCartUrl($_product) ?>')"><span><span><?php echo $this->__('Add to Cart') ?></span></span></button> -->
          
5.	Please Open  File
/app/design/frontend/{your_package}/{your_theme}/templates/catalog/product/widget/new/content/new_grid.phtml

Find Row:
<?php echo $this->getPriceHtml($_product, true, '-widget-new-grid') ?>

Replace it with:

<?php //echo $this->getPriceHtml($_product, true, '-widget-new-grid') ?>
<?php  /* Sashas_Callfor_Price */                        
echo $this->getLayout()->createBlock('callforprice/listprice')->setProduct($_product)->setPrefix('-new')->toHtml();
/* Sashas_Callfor_Price */
?>

Find Row:

<button type="button" title="<?php echo $this->__('Add to Cart') ?>" class="button btn-cart" onclick="setLocation('<?php echo $this->getAddToCartUrl($_product) ?>')"><span><span><?php echo $this->__('Add to Cart') ?></span></span></button>
	
Replace it with:
<?php  /* Sashas_Callfor_Price */                         	
    echo $this->getLayout()->createBlock('callforprice/listcart')->setProduct($_product)->setAddUrl($this->getAddToCartUrl($_product))->toHtml();
  /* Sashas_Callfor_Price */
?>    				                    

<!--     <button type="button" title="<?php echo $this->__('Add to Cart') ?>" class="button btn-cart" onclick="setLocation('<?php echo $this->getAddToCartUrl($_product) ?>')"><span><span><?php echo $this->__('Add to Cart') ?></span></span></button> -->

6.	Please open file 
/app/design/frontend/{your_package}/{your_theme}/templates/catalog/product/widget/new/content/new_list.phtml
Repeat the same as for new_grid.phtml (5)

7.	Please open file 
/app/design/frontend/{your_package}/{your_theme}/templates/wishlist/sidebar.phtml

Find Row:

<?php echo $this->getPriceHtml($product, false, '-wishlist') ?>

Replace it with:

<?php //echo $this->getPriceHtml($product, false, '-wishlist') ?>
<?php  /* Sashas_Callfor_Price */                        
echo $this->getLayout()->createBlock('callforprice/wishlistprice')->setProduct($product)->setPrefix('-wishlist')->toHtml();
/* Sashas_Callfor_Price */
?>

Find Row:

<a href="<?php echo $this->getItemAddToCartUrl($_item) ?>" class="link-cart"><?php echo $this->__('Add to Cart') ?></a>

Replace it with:
<?php  /* Sashas_Callfor_Price */                         	
  echo $this->getLayout()->createBlock('callforprice/wishlistcart')->setProduct($product)->setAddUrl($this->getItemAddToCartUrl($_item))->setSidebar(1)->toHtml();
/* Sashas_Callfor_Price */
?>                   
<!-- <a href="<?php echo $this->getItemAddToCartUrl($_item) ?>" class="link-cart"><?php echo $this->__('Add to Cart') ?></a> -->

8.	Please open file 
/app/design/frontend/{your_package}/{your_theme}/templates/wishlist/view.phtml




Find Row:

<?php echo $this->getPriceHtml($product) ?>

Replace it with:

<?php // echo $this->getPriceHtml($product) ?>
<?php  /* Sashas_Callfor_Price */                        
echo $this->getLayout()->createBlock('callforprice/listprice')->setProduct($product)->setPrefix('')->toHtml();
 /* Sashas_Callfor_Price */
?>

Find Row:

<button type="button" title="<?php echo $this->__('Add to Cart') ?>" onclick="addWItemToCart(<?php echo $item->getId(); ?>)" class="button btn-cart"><span><span><?php echo $this->__('Add to Cart') ?></span></span></button>

Replace it with:

<?php  /* Sashas_Callfor_Price */                         	
echo $this->getLayout()->createBlock('callforprice/listcart')->setProduct($product)->setAddUrl($item->getId())->setWishlist(1)->toHtml();
      /* Sashas_Callfor_Price */
?>                          
<!-- <button type="button" title="<?php echo $this->__('Add to Cart') ?>" onclick="addWItemToCart(<?php echo $item->getId(); ?>)" class="button btn-cart"><span><span><?php echo $this->__('Add to Cart') ?></span></span></button> -->
		  

