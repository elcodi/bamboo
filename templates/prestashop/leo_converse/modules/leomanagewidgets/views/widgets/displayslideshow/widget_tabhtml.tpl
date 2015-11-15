{if isset($tabhtmls)}
<div id="tabhtml{$id}" class="widget-tab block nopadding">
    {if isset($widget_heading)&&!empty($widget_heading)}
      <h4 class="page-subheading">
        {$widget_heading}
      </h4>
    {/if}
    <div class="block_content"> 
        <div id="tabhtmls{$id}" class="panel-group">
            <ul class="nav nav-pills">
              {foreach $tabhtmls as $key => $ac}  
              <li class="{if $key==0}active{/if}"><a href="#tabhtml{$id}{$key}" >{$ac.title}</a></li>
              {/foreach}
            </ul>

            <div class="tab-content">
                {foreach $tabhtmls as $key => $ac}
                  <div class="tab-pane{if $key==0} active{/if} " id="tabhtml{$id}{$key}">{$ac.content}</div>
                {/foreach}
            </div>

    </div></div>
</div>
<script type="text/javascript">
$(document).ready(function() {

    $('#tabhtml{$id} .nav a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    })
});
</script>
{/if}





