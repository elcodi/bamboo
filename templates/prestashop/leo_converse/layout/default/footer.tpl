		{if $HOOK_CONTENTBOTTOM && in_array($page_name,array('index')) }
			<div id="contentbottom" class="no-border clearfix block">
				{$HOOK_CONTENTBOTTOM}
			</div>
		{/if}
</section>
{if isset($right_column_size) && !empty($right_column_size)}
<!-- Right -->
<section id="right_column" class="column sidebar col-md-{$right_column_size|intval}">
		{$HOOK_RIGHT_COLUMN}
</section>
{/if}

