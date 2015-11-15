{*
 *  Leo Theme for Prestashop 1.6.x
 *
 * @author    http://www.leotheme.com
 * @copyright Copyright (C) October 2013 LeoThemes.com <@emai:leotheme@gmail.com>
 *               <info@leotheme.com>.All rights reserved.
 * @license   GNU General Public License version 2
*}
 
{if $manufacturers}
 <div id="{$tab}" class="widget-manufacture block">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<h4 class="page-subheading">
		{$widget_heading}
	</h4>
	{/if}
	<div class="block_content">
		<div class="carousel slide" id="manucarousel_{$tab}">
			{if count($manufacturers)>$itemsperpage}	 
				<a class="carousel-control left" href="#manucarousel_{$tab}" data-slide="prev">&lsaquo;</a>
				<a class="carousel-control right" href="#manucarousel_{$tab}" data-slide="next">&rsaquo;</a>
			{/if}
			<div class="carousel-inner">
				{$mmanufacturers=array_chunk($manufacturers,$itemsperpage)}
				{foreach from=$mmanufacturers item=manufacturers name=mypLoop}
					<div class="item {if $smarty.foreach.mypLoop.first}active{/if}">
						{foreach from=$manufacturers item=manufacturer name=manufacturers}
							{if $manufacturer@iteration%$columnspage==1&&$columnspage>1}
								<div class="row">
							{/if}
							<div class="logo-manu {if $columnspage == 5}col-md-2-4 col-lg-2-4{else}col-md-{$scolumn}{/if} col-sm-2 col-xs-4 col-sp-12">
								<a href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'htmlall':'UTF-8'}" title="{l s='view products' mod='leomanagewidgets'}">
								<img src="{$manufacturer.image|escape:'htmlall':'UTF-8'}" alt="" class="img-responsive"/> </a>
							</div>
							{if ($manufacturer@iteration%$columnspage==0||$smarty.foreach.manufacturers.last)&&$columnspage>1}
								</div>
							{/if}
						{/foreach}
					</div>
				{/foreach}
			</div>
		</div>
	</div>
</div>
{/if}

<script type="text/javascript">
$(document).ready(function() {
	$('#{$tab}').carousel({
		pause: 'hover',
		interval: {$interval}
	});
});
</script>