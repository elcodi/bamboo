Feature: admin
  In order to admin my products
  As an admin
  I need to be able to see all product views

  @admin @product
  Scenario: See product list in admin with new product element
    Given In admin, I am logged as "admin@admin.com" - "1234"
    And I am on "/admin/products"
    Then I should see "Ibiza 4 Ever Spanish"
    And I should see "New product"

  @admin @product
  Scenario: Add product
    Given In admin, I am logged as "admin@admin.com" - "1234"
    And I am on "/admin/product/new"
    When I fill in the following:
      | elcodi_admin_product_form_type_product_name_es_name               | New test product |
      | elcodi_admin_product_form_type_product_slug_es_slug               | new-test-product |
      | elcodi_admin_product_form_type_product_description_es_description | New description  |
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
      | elcodi_admin_product_form_type_product[showInHome]                | 1                |
      | elcodi_admin_product_form_type_product[enabled]                   | 1                |
    And I press "submit-save"
    Then I should be on "/admin/products"
    And I should see "New test product"
    And I should see "/new-test-product"
    And I should see "6,66 €"
