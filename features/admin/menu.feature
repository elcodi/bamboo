@admin @menu
Feature: Admin menus
  In order to be able to move around the admin site
  As an admin
  I need to be able to see all the menus entries

  Scenario: See all menus in the website
    Given In admin, I am logged as "admin@admin.com" - "1234"
    And I go to "/admin/"
    Then the page contains a "admin.dashboard.single" test attribute
    And the page contains a "admin.order.plural" test attribute
    And the page contains a "admin.customer.plural" test attribute
    And the page contains a "admin.categorization.single" test attribute
    And the page contains a "admin.product.plural" test attribute
    And the page contains a "admin.purchasable_pack.plural" test attribute
    And the page contains a "admin.attribute.plural" test attribute
    And the page contains a "admin.manufacturer.plural" test attribute
    And the page contains a "admin.category.plural" test attribute
    And the page contains a "admin.communication.single" test attribute
    And the page contains a "admin.coupon.plural" test attribute
    And the page contains a "admin.page.plural" test attribute
    And the page contains a "admin.mailing.plural" test attribute
    And the page contains a "admin.blog.single" test attribute
    And the page contains a "admin.plugin.plural" test attribute
    And the page contains a "admin.template.plural" test attribute
    And the page contains a "admin.settings.section.store.title" test attribute
    And the page contains a "admin.settings.section.address.title" test attribute
    And the page contains a "admin.settings.section.corporate.title" test attribute
    And the page contains a "admin.currency.plural" test attribute
    And the page contains a "admin.language.plural" test attribute
    And the page contains a "admin.menu.custom_shipping" test attribute
    And the page contains a "menu-profile" test attribute
    And the page contains a "menu-logout" test attribute
