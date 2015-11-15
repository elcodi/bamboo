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

{capture name=path}
    <a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}">
        {l s='My account'}
    </a>
    <span class="navigation-pipe">
        {$navigationPipe}
    </span>
    <span class="navigation_page">
        {l s='Your personal information'}
    </span>
{/capture}
<div class="box">
    <h1 class="page-subheading">
        {l s='Your personal information'}
    </h1>

    {include file="$tpl_dir./errors.tpl"}

    {if isset($confirmation) && $confirmation}
        <p class="alert alert-success">
            {l s='Your personal information has been successfully updated.'}
            {if isset($pwd_changed)}<br />{l s='Your password has been sent to your email:'} {$email}{/if}
        </p>
    {else}
        <p class="info-title">
            {l s='Please be sure to update your personal information if it has changed.'}
        </p>
        <p class="required">
            <sup>*</sup>{l s='Required field'}
        </p>
        <form action="{$link->getPageLink('identity', true)|escape:'html':'UTF-8'}" method="post" class="std form-horizontal">
            <fieldset>
                <div class="clearfix form-group">
                    <label class="control-label col-sm-4">{l s='Social title'}</label>
                    <div class="col-sm-6">
                    {foreach from=$genders key=k item=gender}
                        <div class="radio-inline">
                            <label for="id_gender{$gender->id}" class="top">
                            <input type="radio" name="id_gender" id="id_gender{$gender->id}" value="{$gender->id|intval}" {if isset($smarty.post.id_gender) && $smarty.post.id_gender == $gender->id}checked="checked"{/if} />
                            {$gender->name}</label>
                        </div>
                    {/foreach}
                </div>
                </div>
                <div class="required form-group">
                    <label for="firstname" class="required control-label col-sm-4">
                        {l s='First name'}
                    </label>
                    <div class="col-sm-6">
                    <input class="is_required validate form-control" data-validate="isName" type="text" id="firstname" name="firstname" value="{$smarty.post.firstname}" />
					</div>
                </div>
                <div class="required form-group">
                    <label for="lastname" class="required control-label col-sm-4">
                        {l s='Last name'}
                    </label>
                    <div class="col-sm-6">
                    <input class="is_required validate form-control" data-validate="isName" type="text" name="lastname" id="lastname" value="{$smarty.post.lastname}" />
					</div>
                </div>
                <div class="required form-group">
                    <label for="email" class="required control-label col-sm-4">
                        {l s='E-mail address'}
                    </label>
                    <div class="col-sm-6">
                    <input class="is_required validate form-control" data-validate="isEmail" type="email" name="email" id="email" value="{$smarty.post.email}" />
					</div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">
                        {l s='Date of Birth'}
                    </label>
					<div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-3 col-xs-3">
                            <select name="days" id="days" class="form-control">
                                <option value="">-</option>
                                {foreach from=$days item=v}
                                    <option value="{$v}" {if ($sl_day == $v)}selected="selected"{/if}>{$v}&nbsp;&nbsp;</option>
                                {/foreach}
                            </select>
                        </div>
							<div class="col-sm-6 col-xs-6">
							{*
								{l s='January'}
								{l s='February'}
								{l s='March'}
								{l s='April'}
								{l s='May'}
								{l s='June'}
								{l s='July'}
								{l s='August'}
								{l s='September'}
								{l s='October'}
								{l s='November'}
								{l s='December'}
							*}
                            <select id="months" name="months" class="form-control">
                                <option value="">-</option>
                                {foreach from=$months key=k item=v}
                                    <option value="{$k}" {if ($sl_month == $k)}selected="selected"{/if}>{l s=$v}&nbsp;</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="col-sm-3 col-xs-3">
                            <select id="years" name="years" class="form-control">
                                <option value="">-</option>
                                {foreach from=$years item=v}
                                    <option value="{$v}" {if ($sl_year == $v)}selected="selected"{/if}>{$v}&nbsp;&nbsp;</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                </div>
                </div>
                <div class="required form-group">
                    <label for="old_passwd" class="required control-label col-sm-4">
                        {l s='Current Password'}
                    </label>
					<div class="col-sm-6">
                    <input class="is_required validate form-control" type="password" data-validate="isPasswd" name="old_passwd" id="old_passwd" />
					</div>
                </div>
                <div class="password form-group">
                    <label class="control-label col-sm-4" for="passwd">
                        {l s='New Password'}
                    </label>
					<div class="col-sm-6">
                    <input class="is_required validate form-control" type="password" data-validate="isPasswd" name="passwd" id="passwd" />
					</div>
                </div>
                <div class="password form-group">
                    <label class="control-label col-sm-4" for="confirmation">
                        {l s='Confirmation'}
                    </label>
					<div class="col-sm-6">
                    <input class="is_required validate form-control" type="password" data-validate="isPasswd" name="confirmation" id="confirmation" />
					</div>
                </div>
                {if isset($newsletter) && $newsletter}
                    <div class="form-group">
						<div class="col-sm-offset-4 col-sm-8">
                    <div class="checkbox">
                        <label for="newsletter">
                            <input type="checkbox" id="newsletter" name="newsletter" value="1" {if isset($smarty.post.newsletter) && $smarty.post.newsletter == 1} checked="checked"{/if}/>
                            {l s='Sign up for our newsletter!'}
                            {if isset($required_fields) && array_key_exists('newsletter', $field_required)}
                              <sup> *</sup>
                            {/if}
                        </label>
                    </div>
						</div>
					</div>
		{/if}
                {if isset($optin) && $optin}
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-8">
                    <div class="checkbox">
                        <label for="optin">
                            <input type="checkbox" name="optin" id="optin" value="1" {if isset($smarty.post.optin) && $smarty.post.optin == 1} checked="checked"{/if}/>
                            {l s='Receive special offers from our partners!'}
                            {if isset($required_fields) && array_key_exists('optin', $field_required)}
                              <sup> *</sup>
                            {/if}
                        </label>
							</div>
						</div>
                    </div>
                {/if}
			{if $b2b_enable}
				<h1 class="page-subheading">
					{l s='Your company information'}
				</h1>
				<div class="form-group">
					<label class="control-label col-sm-4" for="">{l s='Company'}</label>
					<div class="col-sm-6">
					<input type="text" class="form-control" id="company" name="company" value="{if isset($smarty.post.company)}{$smarty.post.company}{/if}" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-4" for="siret">{l s='SIRET'}</label>
					<div class="col-sm-6">
					<input type="text" class="form-control" id="siret" name="siret" value="{if isset($smarty.post.siret)}{$smarty.post.siret}{/if}" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-4" for="ape">{l s='APE'}</label>
					<div class="col-sm-6">
					<input type="text" class="form-control" id="ape" name="ape" value="{if isset($smarty.post.ape)}{$smarty.post.ape}{/if}" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-4" for="website">{l s='Website'}</label>
					<div class="col-sm-6">
					<input type="text" class="form-control" id="website" name="website" value="{if isset($smarty.post.website)}{$smarty.post.website}{/if}" />
					</div>
				</div>
			{/if}
                {if isset($HOOK_CUSTOMER_IDENTITY_FORM)}
			{$HOOK_CUSTOMER_IDENTITY_FORM}
		{/if}
                <div class="form-group">
					<div class="col-sm-offset-4 col-sm-8">
                    <button type="submit" name="submitIdentity" class="btn btn-outline button button-medium">
                        <span>{l s='Save'}</span>
                    </button>
                </div>
				</div>
            </fieldset>
        </form> <!-- .std -->
    {/if}
</div>
<ul class="footer_links clearfix">
	<li class="pull-left">
        <a class="btn btn-outline button button-small btn-sm" href="{$link->getPageLink('my-account', true)}">
            <span>
                <i class="fa fa-user"></i>{l s='Back to your account'}
            </span>
        </a>
    </li>
	<li class="pull-right">
        <a class="btn btn-outline button button-small btn-sm" href="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}">
            <span>
                <i class="fa fa-home"></i>{l s='Home'}
            </span>
        </a>
    </li>
</ul>
