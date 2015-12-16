@admin @pack
Feature: Admin pack
  In order to manage my packs
  As an admin
  I need to be able to see all packs views

  Scenario: See pack list in admin with new pack element
    Given In admin, I am logged as "admin@admin.com" - "1234"
    When I go to "/admin/product/packs"
    Then the response should contain a "purchasable-pack-23" test attribute
    And the response should contain a "new-purchasable-pack" test attribute

  Scenario: Add a new pack
    Given In admin, I am logged as "admin@admin.com" - "1234"
    When I go to "/admin/product/pack/new"
    And I fill in the following:
      | elcodi_admin_product_form_type_purchasable_pack_name_en_name               | New test pack   |
      | elcodi_admin_product_form_type_purchasable_pack_slug_en_slug               | new_test_pack   |
      | elcodi_admin_product_form_type_purchasable_pack_description_en_description | New description |
      | elcodi_admin_product_form_type_purchasable_pack_principalCategory          | 1               |
      | elcodi_admin_product_form_type_purchasable_pack_manufacturer               | 1               |
      | elcodi_admin_product_form_type_purchasable_pack_purchasables               | 1               |
      | elcodi_admin_product_form_type_purchasable_pack_stockType                  | 1               |
      | elcodi_admin_product_form_type_purchasable_pack_stock                      | 10              |
      | elcodi_admin_product_form_type_purchasable_pack_price_amount               | 6.66            |
      | elcodi_admin_product_form_type_purchasable_pack_price_currency             | EUR             |
      | elcodi_admin_product_form_type_purchasable_pack_reducedPrice_amount        | 0               |
      | elcodi_admin_product_form_type_purchasable_pack_reducedPrice_currency      | EUR             |
      | elcodi_admin_product_form_type_purchasable_pack_sku                        | 4678364278      |
      | elcodi_admin_product_form_type_purchasable_pack_weight                     | 12              |
      | elcodi_admin_product_form_type_purchasable_pack_width                      | 23              |
      | elcodi_admin_product_form_type_purchasable_pack_height                     | 1               |
      | elcodi_admin_product_form_type_purchasable_pack_depth                      | 33              |
      | elcodi_admin_product_form_type_purchasable_pack_showInHome                 | 1               |
      | elcodi_admin_product_form_type_purchasable_pack_enabled                    | 1               |
    And I press "submit-save"
    And save last response
    Then I should be on "/admin/product/packs"
    And the response should contain a "purchasable-pack-24" test attribute
