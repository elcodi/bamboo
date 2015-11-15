<ul class="products products-block">
    {foreach from=$products item=product name=myLoop}
        <li class="clearfix media">
            
            <div class="product-block">

            <div class="product-container media" itemscope itemtype="https://schema.org/Product">
                 <a class="products-block-image img pull-left" href="{$product.link|escape:'html'}" title="{$product.legend|escape:html:'UTF-8'}"><img class="replace-2x img-responsive" src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'small_default')|escape:'html'}" alt="{$product.name|escape:html:'UTF-8'}" />
                 </a>

                <div class="media-body">
                      <div class="product-content">
                      {if $page_name != "product"}
                        {hook h='displayProductListReviews' product=$product}
                        {/if}
                        <h5 class="name media-heading">
                            <a class="product-name" href="{$product.link|escape:'html'}" title="{$product.name|escape:html:'UTF-8'}">
            {$product.name|strip_tags|escape:html:'UTF-8'|truncate:25:'...'}</a>
                        </h5>
                         {if (!$PS_CATALOG_MODE AND ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
                        <div class="content_price price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                            {if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}
                                {if isset($product.specific_prices) && $product.specific_prices && isset($product.specific_prices.reduction) && $product.specific_prices.reduction > 0}
                                    <span class="old-price product-price">
                                        {displayWtPrice p=$product.price_without_reduction}
                                    </span>
                                {/if}
                                <span itemprop="price" class="product-price">
                                    {if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}
                                </span>
                                <meta itemprop="priceCurrency" content="{$priceDisplay}" />
                            {/if}
                        </div>
                    {/if}
                        {*<p class="product-description description">{$product.description_short|strip_tags:'UTF-8'|truncate:75:'...'}</p>*}
                    </div>
                </div>
            </div>

              
            </div>    
        </li>
    {/foreach}
</ul>