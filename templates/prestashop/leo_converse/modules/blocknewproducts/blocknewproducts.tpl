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
<!-- MODULE Block new products -->
<div id="new-products_block_right" class="block products_block nopadding">
	<h4 class="title_block">
    	<a href="{$link->getPageLink('new-products')|escape:'html'}" title="{l s='New products' mod='blocknewproducts'}">{l s='New products' mod='blocknewproducts'}</a>
    </h4>
    <div class="block_content products-block">
        {if $new_products !== false}
            {include file="$tpl_dir./sub/product/sidebar.tpl" products=$new_products mod='blocknewproducts'}           
            <div class="lnk">
                <a href="{$link->getPageLink('new-products')|escape:'html'}" title="{l s='All new products' mod='blocknewproducts'}" class="btn btn-outline button button-small btn-sm"><span>{l s='All new products' mod='blocknewproducts'}</span></a>
            </div>
        {else}
        	<p>&raquo; {l s='Do not allow new products at this time.' mod='blocknewproducts'}</p>
        {/if}
    </div>
</div>
<!-- /MODULE Block new products -->