<?php
/* Convert XML returned from Lennox API into HTML */
function lennox_cat_main_xml_convert( $xml ) {

	if ( $xml ) {

		if ( $xml->Error ) {
			echo "ERROR: ".$xml->Error;
			exit();
		} ?>
		<?php ob_start(); ?>
		<div class="lennox-container">
			<div class="lennox-category-list">
				<?php
				foreach($xml->Category as $category) { ?>
					<div id="lennox-cat-<?php echo($category->attributes()->ID) ?>" class="lennox-category">
						<a target="blank" id="lennox-cat-<?php echo($category->attributes()->ID) ?>-vm" class="lennox-cat-vm-button" href="javascript:void(0)" lennox-category-id="<?=$category->attributes()->ID?>"><h3 class="lennox-product-cat-name"><?php echo($category->CategoryName) ?></h3></a>
						<?php if ($category->Products) { ?>
						<div class="lennox-cat-product-count"><?php echo($category->Products) ?> Products &nbsp; | &nbsp;
							<a id="lennox-cat-<?php echo($category->attributes()->ID) ?>-vm" class="lennox-cat-vm-button" href="javascript:void(0);" lennox-category-id="<?=$category->attributes()->ID?>">view Products</a>
						</div>
						<div class="lennox-cat-desc-wrapper">
							<?php if ($category->HighlightImage) { ?>
							<div class="lennox-cat-image">
								<img src="<?php echo($category->HighlightImage) ?>" alt="<?php echo($category->CategoryName) ?>">
							</div>
							<?php } //if HighlightImage ?>

							<div class="lennox-cat-details">
								<?php echo ($category->ShortDescription != '') ? '<p class="lennox-cat-desc lennox-cat-short-desc">'.$category->ShortDescription.'</p>' : '' ?>
							</div>
						</div>
						<?php } //if we have a Product Count ?>

						<?php /* if ($category->SubCategories != '') { ?>
						<div class="SubCats">
							<strong>Subcategories:
								<?php foreach($category->SubCategories->SubCategory as $subcat) { ?>
								<?php echo($subcat->SubCategoryName) ?>
								<?php } //foreach SubCat ?>
							</strong>
						</div><!--//end SubCats-->
						<?php } //if SubCat */ ?>
					</div><!--//end Category-->
				<?php } //foreach Category
			?></div>
		</div><?php
		return ob_get_clean();
	} else {
		echo "There has been an error retrieving the XML.";
		exit();
	}
}

function lennox_product_listing_xml_convert( $xml ) {	
	if ($xml) {

		if ($xml->Error) {
			echo "ERROR: ".$xml->Error;
			exit();
		}

		if ($xml->Category) { ?>
			<?php ob_start(); ?>
			<div class="lennox-container">
				<div class="lennox-breadcrumbs">
					<a href="<?=parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);?>">Products</a>
					<span><?=$xml->Category?></span>
				</div>
				<h2><?php echo $xml->Category ?></h2>

				<div class="lennox-single-category">
					<?php foreach ($xml->SubCategory as $subcat) { ?>

					<div class="lennox-cat-details">
						<h3><?php echo $subcat->SubCategoryName ?></h3>
						<div class="lennox-cat-desc lennox-cat-short-desc"><p><?php echo $subcat->ShortDescription ?></p></div>

						<?php /* if ($subcat->ContainsEnergyStar == "Yes") { ?>
							<p class="lennox-flex-container lennox-flexalign-center"><span class="lennox-energy-star"><img src="//lennox.com/res/skins/2007/images/icon_estar.gif" alt="ESTAR ICON" height="12" width="12"></span> ENERGY STAR<sup>&reg;</sup> Product</p>
						<?php } else {	?>
							Products
						<?php }	*/ ?>
					</div>
					<div class="lennox-products-container lennox-flex-container">
						<? foreach ($subcat->Product as $product) { ?>
						<div id="lennox-product-<?=$product->attributes()->ID?>" class="lennox-product <?php if ($product->attributes()->EnergyStar == "Y") { ?> lennox-es-product<?php } ?>">
							<h3 class="lennox-flex-container lennox-flexalign-center lennox-product-title">
								<a href="javascript:void(0)" lennox-product-id="<?=$product->attributes()->ID?>" class="lennox-product-vm"><?php echo $product->ModelName ?></a>
								<?php /* if ($product->attributes()->EnergyStar == "Y") { ?>
									<span class="lennox-energy-star"><img src="//lennox.com/res/skins/2007/images/icon_estar.gif" alt="ESTAR ICON" height="12" width="12"></span>
								<?php } */?>
								<? /*<span class="lennox-product-pricing"><?php echo ($product->PriceGuide) ? $product->PriceGuide : '&nbsp;' ?></span> */ ?>
							</h3>
							<span class="lennox-product-series"><?=$product->Series->Name?></span>
							<p class="lennox-product-description"><?=$product->OneLiner?></p>
							<div class="lennox-product-image">
								<img src="<? echo $product->SmallImage?>" />
							</div>
						</div>
						<?php } // End Foreach Product ?>
					</div>
				<?php } // End Subcat Foreach ?>
				</div>
			</div>
			<?php return ob_get_clean(); ?>

		<? } else {
			echo "There has been an error retrieving the XML.";
			exit();
		}
	}
}

function lennox_product_detail_xml_convert( $xml ) {	
	if ($xml) {

		if ($xml->Error) {
			echo "ERROR: ".$xml->Error;
			exit();
		}
		$product = $xml->Product;
		if ($product) {
			ob_start(); ?>
			<div class="lennox-container lennox-single-product">
				<div class="lennox-breadcrumbs">
					<a href="<?=parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);?>">Products</a>
					<a href="<?=parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);?>?cat=<?=$product->Category->attributes()->ID?>"><?=$product->Category?></a>
					<span><?=$product->ShortName?></span>
				</div>
				<div class="lennox-product-heading lennox-flex-container lennox-flexalign-center">
					<h3 class="lennox-product-title"><?=$product->ModelName?></h3>
					<?php echo ( $product->Series ) ? '<span class="lennox-product-series">'.$product->Series.'</span>' : '' ?>
					<span class="lennox-product-pricing"><?=$product->PriceGuide?></span>
				</div>
				<div class="lennox-product-details">
					<div class="lennox-product-details-main lennox-flex-container">
						<div class="lennox-product-image">
							<img src="<?php echo $product->Images->LargeImage ?>" alt="<?php echo $product->ModelName ?>" />
						</div>
						<div class="lennox-product-highlights">
							<p><?=$product->OneLiner?></p>
							<p><?=$product->ProductHighlight?></p>
							<!-- Product Hightlights -->
							<?php if($product->Highlights != '') : ?>
							<h3>Highlights</h3>
							<ul>
								<?=$product->Highlights?>
							</ul>
							<?php endif ?>
						</div>
					</div>
					<!-- Certifications -->
					<div class="lennox-cert-logo-row lennox-flex-container lennox-flexalign-center">
					<?php foreach ($product->Certifications->Certification as $cert) { ?>
						<div class="lennox-cert-logo">
							<img class="" src="http://www.lennox.com/res/images/logo_<?php echo strtolower($cert->attributes()->Code) ?>.jpg" alt="<? echo $cert ?>" />
						</div>
					<?php } ?>
					</div>
					<div id="lennox-product-tabs" class="lennox-product-features">
						<ul>
							<li><a href="#lennox-product-tabs-1">Features</a></li>
							<? if($product->Ratings): ?><li><a href="#lennox-product-tabs-2">Energy Ratings</a></li><? endif; ?>							
							<li><a href="#lennox-product-tabs-3">Warranty Info</a></li>
							<li><a href="#lennox-product-tabs-4">Publications</a></li>
						</ul>
						<div id="lennox-product-tabs-1">
							<!-- Product Features -->
							<?php foreach($product->Features->Feature as $feature) { ?>
								<h4><?=$feature->Title?></h4>
								<p><?=$feature->Body?></p>
							<?php } ?>
						</div>
						<? if($product->Ratings): ?>
						<div id="lennox-product-tabs-2">
							<!-- Energy Ratings -->
							<?php if($product->Ratings != '') : ?>
							<ul>
								<?php foreach($product->Ratings->Rating as $rating) { ?>
								<li><strong><?=$rating->attributes()->Type?></strong>: <?=$rating?></li>
								<?php } ?>
							</ul>
							<?php endif ?>
						</div>
						<? endif; ?>
						<div id="lennox-product-tabs-3">
							<!-- Warranty Information -->
							<?php if($product->Warranty != '') : ?>
							<ul>
								<?=$product->Warranty?>
							</ul>
							<?php endif ?>
						</div>
						<div id="lennox-product-tabs-4">
							<!-- Product Documents -->
							<?php if($product->Publications) : ?>
								<ul>
								<?php foreach ($product->Publications->Publication as $publication ) { ?>
									<li class="lennox-product-publications" ><a target="blank" href="<?=$publication->URL?>"><?=$publication->Name?></a></li>
								<?php } ?>
								</ul>
							<?php endif; ?>
						</div>
					</div>
					<script>
						jQuery(function(){
							$('#lennox-product-tabs').tabs();
						});
					</script>
					<?php if($product->Disclaimer != '') : ?>
					<h3>Disclaimer</h3>
					<p class="lennox-product-disclaimer"><?=$product->Disclaimer?></p>
					<?php endif ?>
				</div>


				<script type="text/javascript">

					function basePopup(uri,width,height,winName,winArgs) {
							/* close existing popUp window */
						if (typeof(popUp) == "object") {
							if (typeof(popUp.window) == "object") popUp.close();
						}
						popUp = window.open(uri, winName, 'width=' + width + ',height=' + height + winArgs);
							/* attempt to focus the new window */
						if (typeof(popUp) == "object") {
							try {
								popUp.focus();
							} catch(err) {
								return false;
							}
						}
						return false;
					}

					// A general-purpose popup window function
					function popupWindow(uri, width, height) {
						var windowName = 'popup';
						if(arguments.length > 3) {
							windowName = arguments[3];
						}
						return basePopup(uri,width,height,windowName,',scrollbars=no,resizable=yes,menubar=no,toolbar=no,location=no,directories=no,status=no,menubars=no');
					}

					// A general-purpose popup window function with full chrome
					function popupScrollOnly(uri,width,height,windowName) {
						return basePopup(uri,width,height,windowName,',scrollbars=yes,resizable=yes,menubar=no,toolbar=no,location=no');
					}

					function EnlargePhoto(filename) {
						return popupScrollOnly('image-popup.php?filename=' + filename,610,570,'photo');
					}
				</script>
			</div>
			<? return ob_get_clean();
		} else {
			echo "There has been an error retrieving the XML.";
			exit();
		}
	}
}

?>