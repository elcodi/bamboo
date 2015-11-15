<div class="content_sortPagiBar clearfix">
	<div class="sortPagiBar clearfix row">					
			<div class="col-md-10 col-sm-8 col-xs-6">				
				<div class="sort">
				{include file="$tpl_dir./product-sort.tpl"}
				{include file="$tpl_dir./nbr-product-page.tpl"}									
				</div>
			</div>
			<div class="product-compare col-md-2 col-sm-4 col-xs-6">
				{include file="$tpl_dir./product-compare.tpl"}
			</div>
    </div>
</div>

{include file="$tpl_dir./product-list.tpl" products=$products}

<div class="content_sortPagiBar">
	<div class="bottom-pagination-content clearfix row">
		<div class="col-md-10 col-sm-8 col-xs-12">
			{include file="$tpl_dir./pagination.tpl" no_follow=1 paginationId='bottom'}
		</div>
		<div class="product-compare hidden-xs col-md-2 col-sm-4">
			{include file="$tpl_dir./product-compare.tpl" paginationId='bottom'}
		</div>
	</div>
</div>