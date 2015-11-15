{if isset($html)}
<div class="widget-html nopadding">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<h4>
		{$widget_heading}
	</h4>
	{/if}
	<div>
		{$html}
	</div>
</div>
{/if}