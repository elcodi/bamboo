{*
 *  Leo Theme for Prestashop 1.6.x
 *
 * @author    http://www.leotheme.com
 * @copyright Copyright (C) October 2013 LeoThemes.com <@emai:leotheme@gmail.com>
 *               <info@leotheme.com>.All rights reserved.
 * @license   GNU General Public License version 2
*}

{$tabname="{$tab}"}
<div class="products_block exclusive leomanagerwidgets block">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<h4 class="page-subheading">
		{$widget_heading}
	</h4>
	{/if}
	<div class="block_content">	
		{if !empty($products)}
			{include file='./products.tpl'}
		{else}
   			<p class="alert alert-info">{l s='No products at this time.' mod='leomanagewidgets'}</p>	
		{/if}
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $('#{$tabname}').each(function(){
        $(this).carousel({
            pause: 'hover',
            interval: {$interval}
        });
    });
});
</script>
