{if $MENU != ''}
	<!-- Menu -->
	<div id="block_top_menu" class="sf-contener clearfix">
	<div class="row">
		<div class="cat-title"><i class="fa fa-bars"></i></div>
		<ul class="sf-menu clearfix menu-content">
			{$MENU}			
		</ul>
		{if $MENU_SEARCH}
			<div class="pull-right" id="search_block_top">
				<form id="searchbox" action="{$link->getPageLink('search')|escape:'html':'UTF-8'}" method="get">
					<div class="input-group search-top">
						<span class="input-group-btn">
							<button type="submit" name="submit_search" class="btn btn-outline-inverse">
							<span class="button-search fa fa-search"><span class="unvisible">{l s='Search' mod='blocksearch'}</span></span>
						</button></span>
							<input type="hidden" name="controller" value="search" />
							<input type="hidden" value="position" name="orderby"/>
							<input type="hidden" value="desc" name="orderway"/>
							<input type="text" class="search_query form-control" placeholder="{l s='Search'}" name="search_query" value="{if isset($smarty.get.search_query)}{$smarty.get.search_query|escape:'html':'UTF-8'}{/if}" />					
					</div>						
				</form>
			</div>
		{/if}
	</div>
	</div>
	<!--/ Menu -->
{/if}