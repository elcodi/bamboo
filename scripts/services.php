#!/usr/bin/env php
<?php

require_once(__DIR__ . '/../vendor/autoload.php');

$serviceReplacements = [
    "admin.geo.form_type.address"                                          => "elcodi_admin.form_type.address",
    "admin.user.form_type.admin_user"                                      => "elcodi_admin.form_type.admin_user",
    "admin.user.form_type.customer"                                        => "elcodi_admin.form_type.customer",
    "admin.user.form_type.login"                                           => "elcodi_admin.form_type.login",
    "admin.user.form_type.password_recover"                                => "elcodi_admin.form_type.password_recover",
    "admin.user.form_type.password_remember"                               => "elcodi_admin.form_type.password_remember",
    "admin.user.form_type.profile"                                         => "elcodi_admin.form_type.profile",
    "admin.user.form_type.register"                                        => "elcodi_admin.form_type.register",
    "admin.user.security.one_time_login_authenticator"                     => "elcodi_admin.security.one_time_login_authenticator",
    "elcodi.admin.attribute.form_type.attribute"                           => "elcodi_admin.form_type.attribute",
    "elcodi.admin.banner.form_type.banner"                                 => "elcodi_admin.form_type.banner",
    "elcodi.admin.banner.form_type.banner_zone"                            => "elcodi_admin.form_type.banner_zone",
    "elcodi.admin.currency.form_type.currency"                             => "elcodi_admin.form_type.currency",
    "elcodi.admin.currency.form_type.money"                                => "elcodi_admin.form_type.money",
    "elcodi.admin.geo.form.location_selector_builder"                      => "elcodi_admin.form.location_selector_builder",
    "elcodi.admin.media.form_type.image"                                   => "elcodi_admin.form_type.image",
    "elcodi.admin.menu_builder.cart"                                       => "elcodi_admin.menu_builder.cart",
    "elcodi.admin.menu_builder.core"                                       => "elcodi_admin.menu_builder.core",
    "elcodi.admin.menu_builder.currency"                                   => "elcodi_admin.menu_builder.currency",
    "elcodi.admin.menu_builder.language"                                   => "elcodi_admin.menu_builder.language",
    "elcodi.admin.menu_builder.payment"                                    => "elcodi_admin.menu_builder.payment",
    "elcodi.admin.menu_builder.plugin_list"                                => "elcodi_admin.menu_builder.plugin_list",
    "elcodi.admin.menu_builder.plugins"                                    => "elcodi_admin.menu_builder.plugins",
    "elcodi.admin.menu_builder.product"                                    => "elcodi_admin.menu_builder.product",
    "elcodi.admin.menu_builder.shipping"                                   => "elcodi_admin.menu_builder.shipping",
    "elcodi.admin.menu_builder.store"                                      => "elcodi_admin.menu_builder.store",
    "elcodi.admin.menu_builder.template"                                   => "elcodi_admin.menu_builder.template",
    "elcodi.admin.newsletter.form_type.newsletter_subscription"            => "elcodi_admin.form_type.newsletter_subscription",
    "elcodi.admin.page.form_event_listener.permanent_page"                 => "elcodi_admin.form_event_listener.permanent_page",
    "elcodi.admin.page.form_type.blog_post"                                => "elcodi_admin.form_type.blog_post",
    "elcodi.admin.page.form_type.email"                                    => "elcodi_admin.form_type.email",
    "elcodi.admin.page.form_type.page"                                     => "elcodi_admin.form_type.page",
    "elcodi.admin.product.form_type.category"                              => "elcodi_admin.form_type.category",
    "elcodi.admin.product.form_type.coupon"                                => "elcodi_admin.form_type.coupon",
    "elcodi.admin.product.form_type.manufacturer"                          => "elcodi_admin.form_type.manufacturer",
    "elcodi.admin.product.form_type.product"                               => "elcodi_admin.form_type.product",
    "elcodi.admin.product.form_type.product_variant"                       => "elcodi_admin.form_type.product_variant",
    "elcodi.admin.product.services.category_sorter"                        => "elcodi_admin.category_sorter",
    "elcodi.admin.store.form_type.store_address"                           => "elcodi_admin.form_type.store_address",
    "elcodi.admin.store.form_type.store_corporate"                         => "elcodi_admin.form_type.store_corporate",
    "elcodi.admin.store.form_type.store_settings"                          => "elcodi_admin.form_type.language",
    "elcodi.admin.twig_extension.language"                                 => "elcodi_admin.twig_extension.store_settings",
    "elcodi.metric_intervals_resolver"                                     => "elcodi_admin.metric_intervals_resolver",
    "elcodi.product.category.event_listener.new_category_position"         => "elcodi_admin.event_listener.category_position",
    "elcodi.product.category.event_listener.product_has_only_one_category" => "elcodi_admin.event_listener.product_has_only_one_category",
    "elcodi.twig_extension.metric_intervals"                               => "elcodi_admin.twig_extension.metric_intervals",
    "elcodi.validator.minimum_money"                                       => "elcodi_admin.validator.minimum_money",
    "store.plugin.event_listener.order_count_in_menu"                      => "elcodi_admin.event_listener.order_count_in_menu",


    "elcodi.sitemap_transformer.category"                                  => "elcodi_store.sitemap_transformer.category",
    "elcodi.sitemap_transformer.product"                                   => "elcodi_store.sitemap_transformer.product",
    "elcodi.store.geo.form.location_selector_builder"                      => "elcodi_store.form.location_selector_builder",
    "elcodi.twig_extension.encrypt"                                        => "elcodi_store.twig_extension.encrypt",
    "elcodi.twig_extension.referrer"                                       => "elcodi_store.twig_extension.referrer",
    "store.cart.event_listener.shipping_appliance"                         => "elcodi_store.event_listener.shipping_appliance",
    "store.cart.form_type.cart"                                            => "elcodi_store.form_type.cart",
    "store.cart.form_type.cart_line"                                       => "elcodi_store.form_type.cart_line",
    "store.cart_coupon.event_listener.just_one_manual"                     => "elcodi_store.event_listener.just_one_manual",
    "store.cart_coupon.form_type.coupon_apply"                             => "elcodi_store.form_type.coupon_apply",
    "store.connect.factory.authorization"                                  => "elcodi_store.factory.authorization",
    "store.connect.service.oauth_provider"                                 => "elcodi_store.provider.oauth",
    "store.core.event_listener.store_disabled"                             => "elcodi_store.event_listener.store_disabled",
    "store.core.services.template_locator"                                 => "elcodi_store.template_locator.core",
    "store.event_listener.add_order_completed_metric"                      => "elcodi_store.event_listener.add_order_completed_metric",
    "store.event_listener.password_remember_credentials"                   => "elcodi_store.event_listener.password_remember_credentials",
    "store.event_listener.send_customer_registration_email"                => "elcodi_store.event_listener.send_customer_registration_email",
    "store.event_listener.send_order_confirmation_email"                   => "elcodi_store.event_listener.send_order_confirmation_email",
    "store.event_listener.send_order_shipped_email"                        => "elcodi_store.event_listener.send_order_shipped_email",
    "store.event_listener.send_password_recover_email"                     => "elcodi_store.event_listener.send_password_recover_email",
    "store.event_listener.send_password_remember_email"                    => "elcodi_store.event_listener.send_password_remember_email",
    "store.form_type.login"                                                => "elcodi_store.form_type.login",
    "store.form_type.password_recover"                                     => "elcodi_store.form_type.password_recover",
    "store.form_type.password_remember"                                    => "elcodi_store.form_type.password_remember",
    "store.form_type.profile"                                              => "elcodi_store.form_type.profile",
    "store.form_type.register"                                             => "elcodi_store.form_type.register",
    "store.geo.form_type.address"                                          => "elcodi_store.form_type.address",
    "store.page.services.template_locator"                                 => "elcodi_store.template_locator.page",
    "store.product.event_listener.categories_order_change"                 => "elcodi_store.event_listener.categories_order_change",
    "store.product.service.product_collection_provider"                    => "elcodi_store.provider.product_collection",
    "store.product.service.store_category_tree"                            => "elcodi_store.store_category_tree",
    "store.twig_extension.store_page"                                      => "elcodi_store.twig_extension.store_page",
    "store.fixtures_booster.command.load_fixtures"                         => "elcodi_store.command.load_boosted_fixtures",
    "store.connect.director.authorization"                                 => "elcodi_store.director.authorization",
    "store.event_listener.autologin_on_register"                           => "elcodi_store.event_listener.autologin_on_register",

    "elcodi.admin.shipping.form_type.carrier"                              => "elcodi_plugin.custom_shipping.form_type.carrier",
    "elcodi.admin.shipping.form_type.shipping_range"                       => "elcodi_plugin.custom_shipping.form_type.shipping_range",
    "elcodi.factory.carrier"                                               => "elcodi_plugin.custom_shipping.factory.carrier",
    "elcodi.factory.shipping_range"                                        => "elcodi_plugin.custom_shipping.factory.shipping_range",

    "elcodi.firewall.listener.store_area"                                  => "elcodi_common.event_listener.firewall",
    "bamboo.page.renderer.template_renderer"                               => "elcodi_common.renderer.template_renderer",

    "store.payment.event_listener.cart_paid"                               => "elcodi_bridge.payment_suite.event_listener.cart_paid",
    "store.payment.event_listener.order_to_paid"                           => "elcodi_bridge.payment_suite.event_listener.order_to_paid",
];

$finder = new \Symfony\Component\Finder\Finder();
$finder
    ->in([
        __DIR__ . '/../src/',
        __DIR__ . '/../app/',
    ])
    ->name('*.php')
    ->name('*.yml')
    ->name('*.json')
    ->name('*.xml');

foreach ($finder as $file) {

    /**
     * @var \SplFileInfo $file
     */
    $filePath = $file->getPath();
    $fileName = $file->getFilename();
    $fileAbsolutePath = realpath($filePath . '/' . $fileName);
    $content = file_get_contents($fileAbsolutePath);
    $changedContent = str_replace(
        array_keys($serviceReplacements),
        array_values($serviceReplacements),
        $content
    );
    file_put_contents($fileAbsolutePath, $changedContent);
}

