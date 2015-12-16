@admin @product
Feature: Admin product
  In order to manage my products
  As an admin
  I need to be able to see all product views

  Scenario: See product list in admin with new product element
    Given In admin, I am logged as "admin@admin.com" - "1234"
    When I go to "/admin/products"
    Then the response should contain a "product-1" test attribute
    And the response should contain a "product-18" test attribute
    And the response should contain a "new-product" test attribute

  Scenario: Add a new product
    Given In admin, I am logged as "admin@admin.com" - "1234"
    When I go to "/admin/product/new"
    And I fill in the following:
      | elcodi_admin_product_form_type_product_name_en_name               | New test product |
      | elcodi_admin_product_form_type_product_slug_en_slug               | new-test-product |
      | elcodi_admin_product_form_type_product_description_en_description | New description  |
      | elcodi_admin_product_form_type_product_principalCategory          | 1                |
      | elcodi_admin_product_form_type_product_manufacturer               | 1                |
      | elcodi_admin_product_form_type_product_price_amount               | 6.66             |
      | elcodi_admin_product_form_type_product_price_currency             | EUR              |
      | elcodi_admin_product_form_type_product_reducedPrice_amount        | 0                |
      | elcodi_admin_product_form_type_product_reducedPrice_currency      | EUR              |
      | elcodi_admin_product_form_type_product_weight                     | 12               |
      | elcodi_admin_product_form_type_product_width                      | 23               |
      | elcodi_admin_product_form_type_product_height                     | 1                |
      | elcodi_admin_product_form_type_product_depth                      | 33               |
      | elcodi_admin_product_form_type_product_showInHome                 | 1                |
      | elcodi_admin_product_form_type_product_enabled                    | 1                |
    And I press "submit-save"
    Then I should be on "/admin/products"
    And the response should contain a "product-19" test attribute
