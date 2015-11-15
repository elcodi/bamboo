{*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{include file="$tpl_dir./layout/setting.tpl"}
{if isset($products) && $products}
	{*define numbers of product per line in other page for desktop*}
        {if isset($class)}
            {*only display grid mode when include from other module*}
            {assign var="LISTING_GRIG_MODE" value="grid" scope="global"}
            {assign var='nbItemsPerLine' value=$LISTING_PRODUCT_COLUMN_MODULE}
            {if $LISTING_PRODUCT_COLUMN_MODULE=="5"}
                {assign var="colValue" value="col-xs-{12/$LISTING_PRODUCT_MOBILE} col-sm-{12/$LISTING_PRODUCT_TABLET} col-md-2-4 col-sp-12" scope="global"}
            {else}
                {assign var="colValue" value="col-sp-12 col-xs-{12/$LISTING_PRODUCT_MOBILE} col-sm-{12/$LISTING_PRODUCT_TABLET} col-md-{12/$LISTING_PRODUCT_COLUMN_MODULE}" scope="global"}
            {/if}
        {else}
            {assign var='nbItemsPerLine' value=$LISTING_PRODUCT_COLUMN}
	{/if}
        {assign var='nbItemsPerLineTablet' value=$LISTING_PRODUCT_TABLET}
        {assign var='nbItemsPerLineMobile' value=$LISTING_PRODUCT_MOBILE}
	{*define numbers of product per line in other page for tablet*}
	{assign var='nbLi' value=$products|@count}
	{math equation="nbLi/nbItemsPerLine" nbLi=$nbLi nbItemsPerLine=$nbItemsPerLine assign=nbLines}
	{math equation="nbLi/nbItemsPerLineTablet" nbLi=$nbLi nbItemsPerLineTablet=$nbItemsPerLineTablet assign=nbLinesTablet}
	<!-- Products list -->
	<div {if isset($id) && $id} id="{$id}"{/if} class="product_list {$LISTING_GRIG_MODE} row {if isset($class) && $class} {$class}{/if}">
	{foreach from=$products item=product name=products}
		{math equation="(total%perLine)" total=$smarty.foreach.products.total perLine=$nbItemsPerLine assign=totModulo}
		{math equation="(total%perLineT)" total=$smarty.foreach.products.total perLineT=$nbItemsPerLineTablet assign=totModuloTablet}
		{math equation="(total%perLineT)" total=$smarty.foreach.products.total perLineT=$nbItemsPerLineMobile assign=totModuloMobile}
		{if $totModulo == 0}{assign var='totModulo' value=$nbItemsPerLine}{/if}
		{if $totModuloTablet == 0}{assign var='totModuloTablet' value=$nbItemsPerLineTablet}{/if}
		{if $totModuloMobile == 0}{assign var='totModuloMobile' value=$nbItemsPerLineMobile}{/if}	
		<div class="ajax_block_product col-sp-12 {$colValue}{if $smarty.foreach.products.iteration%$nbItemsPerLine == 0} last-in-line
		{elseif $smarty.foreach.products.iteration%$nbItemsPerLine == 1} first-in-line{/if}
		{if $smarty.foreach.products.iteration > ($smarty.foreach.products.total - $totModulo)} last-line{/if}
		{if $smarty.foreach.products.iteration%$nbItemsPerLineTablet == 0} last-item-of-tablet-line
		{elseif $smarty.foreach.products.iteration%$nbItemsPerLineTablet == 1} first-item-of-tablet-line{/if}
		{if $smarty.foreach.products.iteration%$nbItemsPerLineMobile == 0} last-item-of-mobile-line
		{elseif $smarty.foreach.products.iteration%$nbItemsPerLineMobile == 1} first-item-of-mobile-line{/if}
		{if $smarty.foreach.products.iteration > ($smarty.foreach.products.total - $totModuloMobile)} last-mobile-line{/if}">
			{include file="$tpl_dir./product-item.tpl" callFromModule=isset($class)}
		</div>

	{/foreach}
	</div>
{addJsDefL name=min_item}{l s='Please select at least one product' js=1}{/addJsDefL}
{addJsDefL name=max_item}{l s='You cannot add more than %d product(s) to the product comparison' sprintf=$comparator_max_item js=1}{/addJsDefL}
{addJsDef comparator_max_item=$comparator_max_item}
{addJsDef comparedProductsIds=$compared_products}
{/if}