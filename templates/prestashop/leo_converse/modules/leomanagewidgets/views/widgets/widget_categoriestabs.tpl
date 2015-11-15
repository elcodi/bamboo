{*
 *  Leo Theme for Prestashop 1.6.x
 *
 * @author    http://www.leotheme.com
 * @copyright Copyright (C) October 2013 LeoThemes.com <@emai:leotheme@gmail.com>
 *               <info@leotheme.com>.All rights reserved.
 * @license   GNU General Public License version 2
*}

<!-- MODULE Block specials -->
<div id="{$myTab}" class="products_block exclusive  block">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<h4 class="page-subheading">
		{$widget_heading}
	</h4>
	{/if}
	<div class="block_content">	
		{if !empty($leocategories )}
			<ul class="nav nav-pills">
			  {foreach $leocategories as $category}
				<li><a href="#{$myTab}{$category.id}" data-toggle="tab">{$category.name}</a></li>
			  {/foreach}
			</ul>
			<div class="tab-content">
			 {foreach $leocategories as $category}
				<div class="tab-pane" id="{$myTab}{$category.id}">
					{$products=$category.products}  
					{assign var="tabname" value="{$myTab}_{$category.id}"} 
					{include file='./products.tpl'}
				</div>
			{/foreach}
			</div>
		{/if}
	</div>
</div>
<!-- /MODULE Block specials -->
<script type="text/javascript">

$(document).ready(function() {
    $('#{$myTab} .carousel').each(function(){
        $(this).carousel({
            pause: true,
            interval: false
        });
    });
    
    $("#{$myTab} .nav-pills li", this).first().addClass("active");
    $("#{$myTab} .tab-content .tab-pane", this).first().addClass("active");
});

</script>
 