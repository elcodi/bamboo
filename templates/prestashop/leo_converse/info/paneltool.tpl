{if class_exists("LeoFrameworkHelper")}
{$skins=LeoFrameworkHelper::getSkins($LEO_THEMENAME)}
{$header_styles=LeoFrameworkHelper::getPanelConfigByTheme('header',$LEO_THEMENAME)}
{$sidebarmenu=LeoFrameworkHelper::getPanelConfigByTheme('sidebarmenu',$LEO_THEMENAME)}
{$theme_customizations=LeoFrameworkHelper::getLayoutSettingByTheme($LEO_THEMENAME)}
<div id="leo-paneltool" class="hidden-sm hidden-xs" data-cname="{$LEO_COOKIE_THEME}">
{if $skins || $header_styles || $theme_customizations || $sidebarmenu}
  <div class="paneltool themetool">
    <div class="panelbutton">
      <i class="fa fa-sliders"></i>
    </div>
    <div class="block-panelcontent">
        <div class="panelcontent">
            <div class="panelinner">
              <h4>{l s='Panel Tool'}</h4>
                          <!-- Theme layout mod section -->
              {if $theme_customizations && isset($theme_customizations.layout) && isset($theme_customizations.layout.layout_mode) && isset($theme_customizations.layout.layout_mode.option)}
                <div class="group-input clearfix layout">
                  <label class="col-sm-12 control-label"><i class="fa fa-desktop"></i>{l s='Layout Mod'}</label>
                  <div class="col-sm-12">
                    {foreach $theme_customizations.layout.layout_mode.option as $layout}
                      <span class="leo-dynamic-update-layout {if $LEO_LAYOUT_MODE == $layout.id}current-layout-mod{/if}" data-layout-mod="{$layout.id}">
                        {$layout.name}
                      </span>
                    {/foreach}
                  </div>
                </div>
              {/if}
              <!-- Theme skin section -->
              {if $skins}
              <div class="group-input clearfix">
                <label class="col-sm-12 control-label"><i class="fa fa-paint-brush"></i>{l s='Theme'}</label>
                <div class="col-sm-12">
                  <div data-theme-skin-id="default" class="skin-default leo-dynamic-theme-skin{if $LEO_DEFAULT_SKIN=='default'} current-theme-skin{/if}">
                      <label>{l s='Default'}</label>
                  </div>
                  {foreach $skins as $skin}
                  <div data-theme-skin-id="{$skin.id}" data-theme-skin-css="{$skin.css}" data-theme-skin-rtl="{$skin.rtl}" class="leo-dynamic-theme-skin{if isset($skin.icon) && $skin.icon} theme-skin-type-image{/if}{if $LEO_DEFAULT_SKIN==$skin.id} current-theme-skin{/if}">
                    {if isset($skin.icon) && $skin.icon}
                      <img src="{$skin.icon}" width="36" height="36" alt="{$skin.name}" />
                    {else}
                      <label class="{$skin.id}">{$skin.id}</label>
                    {/if}
                  </div>
                  {/foreach}
                </div>
              </div>
              {/if}
              <div class="group-input clearfix">
                <label class="col-sm-12 control-label"><i class="fa fa-credit-card"></i>{l s='Float Header'}</label>
                <div class="col-sm-12">
                  <div class="btn_enable_fheader">
                      <span class="enable_fheader btn_yes {if $USE_FHEADER}current{/if}" data-value="1">
                         <i>{l s='Yes'}</i>
                      </span>
                      <span class="enable_fheader btn_no {if !$USE_FHEADER}current{/if}" data-value="0">
                        <i>{l s='No'}</i>
                      </span>
                  </div>
                </div>
              </div>
              <!-- Theme header style section -->
              <!-- Theme slidebar menu section -->
              {if $sidebarmenu && isset($sidebarmenu.configs) && isset($sidebarmenu.configs.sidebarmenu) && isset($sidebarmenu.configs.sidebarmenu.option)}
              <div class="group-input clearfix">
                <label class="col-sm-12 control-label"><i class="fa fa-columns"></i>{l s='SideBar Menu'}</label>
                <div class="col-sm-12">
                  {foreach $sidebarmenu.configs.sidebarmenu.option as $sidebar_menu}
                    <span class="leo-dynamic-update-side {if $sidebar_menu.id==$LEO_SIDEBAR_MENU}current-sidebar{/if}" data-sidebar="{$sidebar_menu.id}">
                      {$sidebar_menu.name}
                    </span>
                  {/foreach}
                </div>
              </div>
              {/if}
              {if $header_styles && isset($header_styles.configs) && isset($header_styles.configs.header_style) && isset($header_styles.configs.header_style.option)}
              <div class="group-input clearfix">
                <label class="col-sm-12 control-label"><i class="fa fa-list-alt"></i>{l s='Header Style'}</label>
                <div class="col-sm-12">
                  {foreach $header_styles.configs.header_style.option as $header_style}
                    <span class="leo-dynamic-update-header {if $header_style.id==$LEO_HEADER_STYLE}current-header{/if}" data-header-style="{$header_style.id}">
                      {$header_style.name}
                    </span>
                  {/foreach}
                </div>
              </div>
              {/if}
            </div>
        </div>
    </div>
  </div>
{/if}

<div class="paneltool editortool">
  <div class="panelbutton">
    <i class="fa fa-sun-o"></i>
  </div>
  <div class="panelcontent editortool">
    <div class="panelinner">
      <h4>Live Theme Editor</h4>
            {$xmlselectors = LeoFrameworkHelper::renderEdtiorThemeForm($LEO_THEMENAME)}
            {$patterns = LeoFrameworkHelper::getPattern($LEO_THEMENAME)}
            <div class="clearfix" id="customize-body">
              <ul class="nav nav-tabs" id="panelTab">
                {foreach $xmlselectors as $for => $output}
                <li><a href="#tab-{$for}">{$for}</a></li>
                {/foreach}
              </ul>
            <div class="tab-content" >
            {foreach $xmlselectors as $for => $items}
            <div class="tab-pane" id="tab-{$for}">
            {if !empty($items)}
              <div class="accordion"  id="accordion-{$for}">
              {foreach $items as $group}
                 <div class="accordion-group panel panel-default">
                    <div class="accordion-headingt panel-heading">
                      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-{$for}" href="#collapse{$group.match}">
                          {$group.header}
                      </a>
                    </div>
                    <div id="collapse{$group.match}" class="accordion-body  {if $group@iteration == 1} in{/if} collapse">
                      <div class="accordion-inner panel-body clearfix">
                      {foreach $group.selector as $item}
                        {if isset($item.type)&&$item.type=="image"}
                        <div class="form-group background-images cleafix">
                          <label>{$item.label}</label>
                          <input value="" type="hidden" name="customize[{$group.match}][]" data-match="{$group.match}" class="input-setting" data-selector="{$item.selector}" data-attrs="background-image">
                          <a class="clear-bg label label-success" href="#">{l s='Clear'}</a>

                          <div class="clearfix"></div>
                           <p><em style="font-size:10px">{l s='Those Images in folder YOURTHEME/img/patterns/'}</em></p>
                          <div class="bi-wrapper clearfix">
                          {foreach $patterns as $pattern}
                            <div style="background:url('{$content_dir}themes/{$LEO_THEMENAME}/img/patterns/{$pattern}') no-repeat center center;" class="pull-left" data-image="{$content_dir}themes/{$LEO_THEMENAME}/img/patterns/{$pattern}" data-val="../../img/patterns/{$pattern}">

                            </div>
                          {/foreach}
                          </div>

                           <ul class="bg-config">
                                            <li>
                                                <div>{l s='Attachment'}</div>
                                                <select class="form-control" data-attrs="background-attachment" name="customize[body][]" data-selector="{$item.selector}" data-match="{$group.match}">
                                                    <option value="">{l s='Not set'}</option>
                                                    {foreach $BACKGROUNDVALUE.attachment as $attachment}
                                                        <option value="{$attachment}">{$attachment}</option>
                                                    {/foreach}
                                                </select>
                                            </li>
                                            <li>
                                                <div>{l s='Position'}</div>
                                                <select class="form-control" data-attrs="background-position" name="customize[body][]" data-selector="{$item.selector}" data-match="{$group.match}">
                                                    <option value="">{l s='Not set'}</option>
                                                    {foreach $BACKGROUNDVALUE.position as $position}
                                                        <option value="{$position}">{$position}</option>
                                                    {/foreach}
                                                </select>
                                            </li>
                                            <li>
                                                <div>{l s='Repeat'}</div>
                                                <select class="form-control" data-attrs="background-repeat" name="customize[body][]" data-selector="{$item.selector}" data-match="{$group.match}">
                                                    <option value="">{l s='Not set'}</option>
                                                    {foreach $BACKGROUNDVALUE.repeat as $repeat}
                                                        <option value="{$repeat}">{$repeat}</option>
                                                    {/foreach}
                                                </select>
                                            </li>
                                        </ul>
                        </div>
                        {elseif $item.type=="fontsize"}
                         <div class="form-group cleafix">
                          <label>{$item.label}</label>
                            <select class="form-control input-setting" name="customize[{$group.match}][]" data-match="{$group.match}"  data-selector="{$item.selector}" data-attrs="{$item.attrs}">
                              <option value="">Inherit</option>
                              {for $i=9 to 16}
                              <option value="{$i}">{$i}</option>
                              {/for}
                            </select>
                            <a href="#" class="clear-bg label label-success">{l s='Clear'}</a>
                        </div>
                        {else}
                        <div class="form-group cleafix">
                          <label>{$item.label}</label>
                          <input value="" size="10" name="customize[{$group.match}][]" data-match="{$group.match}" type="text" class="input-setting" data-selector="{$item.selector}" data-attrs="{$item.attrs}"><a href="#" class="clear-bg label label-success">{l s='Clear'}</a>
                        </div>
                        {/if}
                        {/foreach}
                      </div>
                    </div>
                  </div>
                 {/foreach}
               </div>
              {/if}
            </div>
          {/foreach}
          </div>
        </div>
      </div>
    </div>
  <div class="panelbutton label-customize"></div>
  </div>
</div>
{/if}