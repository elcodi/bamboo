{*
 *  Leo Theme for Prestashop 1.6.x
 *
 * @author    http://www.leotheme.com
 * @copyright Copyright (C) October 2013 LeoThemes.com <@emai:leotheme@gmail.com>
 *               <info@leotheme.com>.All rights reserved.
 * @license   GNU General Public License version 2
*}

{if isset($products) && !empty($products)}
<div class="widget-products block">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<h4 class="title_block">
		{$widget_heading}
	</h4>
	{/if}
	<div class="block_content">
		
		{if isset($products) AND $products}
		<div class="product-block">
			{assign var='liHeight' value=140}
			{assign var='nbItemsPerLine' value=3}
			{assign var='nbLi' value=$limit}
			{math equation="nbLi/nbItemsPerLine" nbLi=$nbLi nbItemsPerLine=$nbItemsPerLine assign=nbLines}
			{math equation="nbLines*liHeight" nbLines=$nbLines|ceil liHeight=$liHeight assign=ulHeight}
			 

			{$mproducts=array_chunk($products,$limit)}
			 

 
			{foreach from=$products item=product name=homeFeaturedProducts}
				{math equation="(total%perLine)" total=$smarty.foreach.homeFeaturedProducts.total perLine=$nbItemsPerLine assign=totModulo}
				{if $totModulo == 0}{assign var='totModulo' value=$nbItemsPerLine}{/if}
			 
  
				<div class="product-container product-block" itemscope itemtype="https://schema.org/Product">
					<div class="left-block">
						<div class="product-image-container">
							<a class="product_img_link"	href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url">
								<img class="replace-2x img-responsive" src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" {if isset($homeSize)} width="{$homeSize.width}" height="{$homeSize.height}"{/if} itemprop="image" />
							</a>
							{if isset($quick_view) && $quick_view}
								<a class="quick-view" href="{$product.link|escape:'html':'UTF-8'}" rel="{$product.link|escape:'html':'UTF-8'}" title="{l s='Quick view' mod='leomanagewidgets'}" >
									<span>{l s='Quick view' mod='leomanagewidgets'}</span>
								</a>
							{/if}
							{if isset($product.new) && $product.new == 1}
								<span class="new-box">
									<span class="new-label product-label">{l s='New' mod='leomanagewidgets'}</span>
								</span>
							{/if}
							{if isset($product.on_sale) && $product.on_sale && isset($product.show_price) && $product.show_price && !$PS_CATALOG_MODE}
								<span class="sale-box">
									<span class="sale-label">{l s='Sale' mod='leomanagewidgets'}</span>
								</span>
							{/if}
						</div>
					</div>
					<div class="right-block">
						<h5 itemprop="name" class="name">
							{if isset($product.pack_quantity) && $product.pack_quantity}{$product.pack_quantity|intval|cat:' x '}{/if}
							<a class="product-name" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url" >
								{$product.name|truncate:45:'...'|escape:'html':'UTF-8'}
						</a>
						</h5>
						{if $page_name != "product"}
						{hook h='displayProductListReviews' product=$product}
						{/if}
						<p class="product-desc" itemprop="description">
							{$product.description_short|strip_tags:'UTF-8'|truncate:360:'...'}
						</p>
						{if (!$PS_CATALOG_MODE AND ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
						<div class="content_price">
							{if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}
	                           				 {hook h="displayProductPriceBlock" product=$product type='before_price'}
								<span class="price product-price">
									{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}
								</span>
								{if isset($product.specific_prices) && $product.specific_prices && isset($product.specific_prices.reduction) && $product.specific_prices.reduction > 0}
									{hook h="displayProductPriceBlock" product=$product type="old_price"}
									<span class="old-price product-price">
										{displayWtPrice p=$product.price_without_reduction}
									</span>
									{hook h="displayProductPriceBlock" id_product=$product.id_product type="old_price"}
									{if $product.specific_prices.reduction_type == 'percentage'}
										<span class="price-percent-reduction">-{$product.specific_prices.reduction * 100}%</span>
									{/if}
								{/if}
								{hook h="displayProductPriceBlock" product=$product type="price"}
								{hook h="displayProductPriceBlock" product=$product type="unit_price"}
	                           				{hook h="displayProductPriceBlock" product=$product type='after_price'}
							{/if}
						</div>
						{/if}
						<div class="button-container">
							{if ($product.id_product_attribute == 0 || (isset($add_prod_display) && ($add_prod_display == 1))) && $product.available_for_order && !isset($restricted_country_mode) && $product.customizable != 2 && !$PS_CATALOG_MODE}
								{if (!isset($product.customization_required) || !$product.customization_required) && ($product.allow_oosp || $product.quantity > 0)}
									{capture}add=1&amp;id_product={$product.id_product|intval}{if isset($static_token)}&amp;token={$static_token}{/if}{/capture}
									<a class="button ajax_add_to_cart_button btn btn-outline" href="{$link->getPageLink('cart', true, NULL, $smarty.capture.default, false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart'}" data-id-product="{$product.id_product|intval}" data-minimal_quantity="{if isset($product.product_attribute_minimal_quantity) && $product.product_attribute_minimal_quantity >= 1}{$product.product_attribute_minimal_quantity|intval}{else}{$product.minimal_quantity|intval}{/if}">
										<i class="fa fa-shopping-cart"></i>
										<span>{l s='Add to cart' mod='leomanagewidgets'}</span>
									</a>
								{else}
									<span class="button ajax_add_to_cart_button btn btn-outline disabled">
										<i class="fa fa-shopping-cart"></i>
										<span>{l s='Out of stock' mod='leomanagewidgets'}</span>
									</span>
								{/if}
							{/if}
							<a itemprop="url" class="button lnk_view btn btn-outline" href="{$product.link|escape:'html':'UTF-8'}" title="{l s='View' mod='leomanagewidgets'}">
								<span>{l s='More' mod='leomanagewidgets'}</span>
							</a>
						</div>
						{if isset($product.color_list)}
							<div class="color-list-container">{$product.color_list} </div>
						{/if}
				</div>
					<div class="functional-buttons clearfix">
						{hook h='displayProductListFunctionalButtons' product=$product}
				</div>
				</div>					
			{/foreach}
						
		 
		</div>
 
		{/if}


	</div>
</div>
{/if}