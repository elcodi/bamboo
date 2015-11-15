{if isset($left_column_size) && !empty($left_column_size)}
<!-- Left -->
<section id="left_column" class="column sidebar col-md-{$left_column_size|intval}" role="navigation">
		{$HOOK_LEFT_COLUMN}
</section>
{/if}
{if isset($left_column_size) && isset($right_column_size)}{assign var='cols' value=(12 - $left_column_size - $right_column_size)}{else}{assign var='cols' value=12}{/if}
<!-- Center -->
<section id="center_column" class="col-md-{$cols|intval}">
	{if $page_name !='index' && $page_name !='pagenotfound'}
		<div id="breadcrumb" class="clearfix">			
			{include file="$tpl_dir./breadcrumb.tpl"}			
		</div>
	{/if}

