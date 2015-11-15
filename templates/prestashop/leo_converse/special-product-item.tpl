{*
	************************
		Creat by leo themes
	*************************
*}
	{include file="$tpl_dir./layout/setting.tpl"}
	<div class="product-container product-block" itemscope itemtype="http://schema.org/Product">
		
		<div class="left-block">
			<h5 itemprop="name" class="name">
				{if isset($product.pack_quantity) && $product.pack_quantity}{$product.pack_quantity|intval|cat:' x '}{/if}
				<a class="product-name" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url" >
					{$product.name|truncate:45:'...'|escape:'html':'UTF-8'}
				</a>
			</h5>
			<div class="product-image-container image">
				{if (!$PS_CATALOG_MODE AND ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
					{if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}
						{if isset($product.specific_prices) && $product.specific_prices && isset($product.specific_prices.reduction) && $product.specific_prices.reduction}
							{if $product.specific_prices.reduction_type == 'percentage'}
								<span class="sale-percent-box product-label">{l s='Save'}<br /><b>-{$product.specific_prices.reduction * 100}<sup>%</sup></b></span>
							{/if}
						{/if}
					{/if}
				{/if}
				<a class="product_img_link"	href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url">
					<img class="replace-2x img-responsive" src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" itemprop="image" />
				</a>	
				<span class="sale-box product-box">
					{if isset($product.on_sale) && $product.on_sale && isset($product.show_price) && $product.show_price && !$PS_CATALOG_MODE}
						<span class="sale-label product-label">{l s='Sale!'}</span>
					{/if}
				</span>
				<div class="leo-more-info" data-idproduct="{$product.id_product}"></div>
			</div>	
		</div>
		<div class="right-block">
			<div class="product-meta">
				<div class="product_price">
					{if (!$PS_CATALOG_MODE AND ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
						<div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="content_price price_fix">
							{if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}
								<span itemprop="price" class="price product-price">
									{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}
								</span>
								{if isset($product.specific_prices) && $product.specific_prices && isset($product.specific_prices.reduction) && $product.specific_prices.reduction}
									<span class="old-price product-price">
										{displayWtPrice p=$product.price_without_reduction}
									</span>
								{/if}
								<meta itemprop="priceCurrency" content="{$priceDisplay}" />
							{/if}
						</div>
					{/if}		
					{hook h='displayProductListReviews' product=$product}
				</div>
				<div class="product-detail">
					<p class="product-desc" itemprop="description">
						{$product.description_short|strip_tags:'UTF-8'|truncate:360:'...'}
					</p>
					<div class="leo-more-cdown" rel="{$product.id_product}"></div>
				</div>
				
				<div class="functional-buttons clearfix">
					{if ($product.id_product_attribute == 0 || (isset($add_prod_display) && ($add_prod_display == 1))) && $product.available_for_order && !isset($restricted_country_mode) && $product.minimal_quantity <= 1 && $product.customizable != 2 && !$PS_CATALOG_MODE}
						{if ($product.allow_oosp || $product.quantity > 0)}
							{if isset($static_token)}
								<a class="button ajax_add_to_cart_button btn btn-outline" href="{$link->getPageLink('cart',false, NULL, "add=1&amp;id_product={$product.id_product|intval}&amp;token={$static_token}", false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart'}" data-id-product="{$product.id_product|intval}">
									<span>{l s='Add to cart'}</span>
									<i class="fa fa-plus-circle"></i>
								</a>
							{else}
								<a class="button ajax_add_to_cart_button btn btn-outline" href="{$link->getPageLink('cart',false, NULL, 'add=1&amp;id_product={$product.id_product|intval}', false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart'}" data-id-product="{$product.id_product|intval}">
									<span>{l s='Add to cart'}</span>
									<i class="fa fa-plus-circle"></i>
								</a>
							{/if}
						{else}
							<span class="button ajax_add_to_cart_button btn disabled btn-outline">
								<span>{l s='Add to cart'}</span>
							</span>
						{/if}
					{/if}
					<div class="box-button">
						{if $ENABLE_WISHLIST}
							{hook h='displayProductListFunctionalButtons' product=$product}
						{/if}
						<a itemprop="url" class="btn-tooltip lnk_view" href="{$product.link|escape:'html':'UTF-8'}" title="{l s='View'}">
							<i class="fa fa-info"></i>
						</a>
						{if isset($quick_view) && $quick_view}
							<a class="btn-tooltip quick-view" href="{$product.link|escape:'html':'UTF-8'}" rel="{$product.link|escape:'html':'UTF-8'}">
								<i class="fa fa-eye"></i>
							</a>
						{/if}
					</div>
				</div>
			</div>	
		</div>		
	</div><!-- .product-container> -->

