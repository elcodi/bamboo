<div class="widget-map block footer-block">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<h4 class="title_block">
		{$widget_heading}
	</h4>
	{/if}
	<div class="toggle-footer">
		{if $page_name !='stores' && $page_name !='sitemap'}
		<div id="map-canvas" style="width:{$width}; height:{$height};"></div>
		<script type="text/javascript">
		$(document).ready(function(){
		{literal} 
			var latitude = {/literal}{$latitude}{literal};
			var longitude = {/literal}{$longitude}{literal};
			var zoom = {/literal}{$zoom}{literal}
			map = new google.maps.Map(document.getElementById('map-canvas'), {
				center: new google.maps.LatLng(latitude,longitude),
				zoom: zoom,
				mapTypeId: 'roadmap'
			});
		});
		{/literal} 
		</script>
		{/if}
	</div>
</div>

