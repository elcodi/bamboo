@workflow @product
Feature: Product engine
  In order to make the products engine work
  As an admin user
  I need to be able to manager products and see them in the shop

  @javascript
  Scenario: Create a product with variant
    Given In admin, I am logged as "admin@admin.com" - "1234"
    When I am on "/admin/product/new"
    And I fill in the following:
      | elcodi_admin_product_form_type_product_name_en_name               | Product x      |
      | elcodi_admin_product_form_type_product_description_en_description | Description x  |
      | elcodi_admin_product_form_type_product_principalCategory          | 1              |
      | elcodi_admin_product_form_type_product_manufacturer               | 1              |
      | elcodi_admin_product_form_type_product_price_amount               | 10             |
    And I check "elcodi_admin_product_form_type_product_showInHome"
    And I check "elcodi_admin_product_form_type_product_enabled"
    And I press "submit-save"
    And I am on "/admin/product/19/variant/new"
    And I wait "3" seconds
    And I select "1" from "select-Size"
    And I select "4" from "select-Color"
    And I fill in the following:
      | elcodi_admin_product_form_type_product_variant_price_amount | 12 |
    And I check "elcodi_admin_product_form_type_product_variant_enabled"
    And I press "submit-variant"
    And I press "submit-save"
    And I am on "/"
    And I am on "/product/whatever/19"
    And I am on "/product/product-x/19#variant-add-to-cart"
