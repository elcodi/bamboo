{*
 *  Leo Theme for Prestashop 1.6.x
 *
 * @author    http://www.leotheme.com
 * @copyright Copyright (C) October 2013 LeoThemes.com <@emai:leotheme@gmail.com>
 *               <info@leotheme.com>.All rights reserved.
 * @license   GNU General Public License version 2
*}

{if !empty($products)}
<div class="carousel slide" id="{$tabname}">
	{if count($products)>$itemsperpage}	 
	 	<a class="carousel-control left" href="#{$tabname}"   data-slide="prev">&lsaquo;</a>
		<a class="carousel-control right" href="#{$tabname}"  data-slide="next">&rsaquo;</a>
	{/if}

	<div class="carousel-inner">
		{$mproducts=array_chunk($products,$itemsperpage)}
		{foreach from=$mproducts item=products name=mypLoop}
			<div class="item {if $smarty.foreach.mypLoop.first}active{/if}">
				<div class="product_list grid">
					{foreach from=$products item=product name=products}
					{if $product@iteration%$columnspage==1&&$columnspage>1}
						<div class="row">
					{/if}
						<div class=" ajax_block_product product_block {if $columnspage == 5}col-md-2-4 col-lg-2-4{else}col-md-{$scolumn}{/if} col-xs-6 col-sp-12 {if $smarty.foreach.products.first}first_item{elseif $smarty.foreach.products.last}last_item{/if}">
							{include file="$tpl_dir./product-item.tpl"}
						</div>		
					{if ($product@iteration%$columnspage==0||$smarty.foreach.products.last)&&$columnspage>1}
						</div>
					{/if}	
					{/foreach}
				</div>
		</div>		
	{/foreach}
	</div>
</div>
{addJsDefL name=min_item}{l s='Please select at least one product' mod='leomanagewidgets' js=1}{/addJsDefL}
{addJsDefL name=max_item}{l s='You cannot add more than %d product(s) to the product comparison' mod='leomanagewidgets' sprintf=$comparator_max_item js=1}{/addJsDefL}
{addJsDef comparator_max_item=$comparator_max_item}
{addJsDef comparedProductsIds=$compared_products}
{/if}