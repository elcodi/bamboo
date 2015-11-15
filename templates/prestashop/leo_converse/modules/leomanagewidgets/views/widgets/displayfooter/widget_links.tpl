{if isset($links)}
<div class="widget-links block block nopadding footer-block">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<h4 class="title_block">
		{$widget_heading}
	</h4>
	{/if}
	<div class="block_content toggle-footer">	
		<div id="tabs{$id}" class="panel-group">
			<ul class="nav-links" >
			  {foreach $links as $key => $ac}  
			  <li ><a href="{$ac.link}" >{$ac.text}</a></li>
			  {/foreach}
			</ul>


	</div></div>
</div>
{/if}


