1. Open /app/design/frontend/{your_package}/{your_theme}/templates/catalog/product/list.phtml

Find two  Rows (50 and 95):

<a href="<?php echo $_product->getProductUrl() ?>" title="<?php echo $this->stripTags($this->getImageLabel($_product, 'small_image'), null, true) ?>" class="product-image"><img src="<?php echo $this->helper('catalog/image')->init($_product, 'small_image')->resize(135); ?>" width="135" height="135" alt="<?php echo $this->stripTags($this->getImageLabel($_product, 'small_image'), null, true) ?>" /></a>

And add after each of them:
                <?php  /* Sashas_Special_Product */   
                echo $this->getLayout()->createBlock('specialproduct/productimagelist')->setData('product',$_product)->toHtml(); 
                /* Sashas_Special_Product */
                ?>
 


2. Open /app/design/frontend/{your_package}/{your_theme}/templates/catalog/product/view/media.phtml

Find row 41-42 

        echo $_helper->productAttribute($_product, $_img, 'image');
    ?>

And add after it:

    <?php /* Sashas_Special_Product */   
          echo $this->getLayout()->createBlock('specialproduct/productimageview')->setData('product',$_product)->toHtml(); 
          /* Sashas_Special_Product */
   ?>

Find row 63-64:

        echo $_helper->productAttribute($_product, $_img, 'image');
    ?>

Add after them: 

        <?php /* Sashas_Special_Product */   
          echo $this->getLayout()->createBlock('specialproduct/productimageview')->setData('product',$_product)->toHtml(); 
          /* Sashas_Special_Product */
   ?>

After that you can use special product images.