{*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<!-- Block payment logo module -->
<div id="paiement_logo_block_left" class="block paiement_logo_block col-xs-12 col-sm-6 col-md-3">
	<h4 class="title_block">{l s='We accept' mod='blockpaymentlogo'}</h4>
	<div class="toggle-footer">
		<a href="{$link->getCMSLink($cms_payement_logo)|escape:'html'}">
			<img src="{$img_dir}logo_paiement_visa.jpg" alt="visa" width="33" height="21" />
			<img src="{$img_dir}logo_paiement_mastercard.jpg" alt="mastercard" width="32" height="21" />
			<img src="{$img_dir}logo_paiement_paypal.jpg" alt="paypal" width="61" height="21" />
		</a>
	</div>
</div>
<!-- /Block payment logo module -->