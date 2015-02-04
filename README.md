# Create your custom Bamboo template
Customizing this bundle you can create themes for bamboo/elcodi. Please read this documentation carefully before edit anything.

## Folders

> ### Fixtures
> This folder contains json files with a simulation of the database and the vars you have available in each template.
> This is a read-only folder, maybe could be useful for your information but you should don't change anything.

> ### Resources
> This is the main folder of your template. Inside this folder you will find two subfolders; Public & Views.

>> #### Public
>> This directory is to host the all the public files your template will need (images, fonts, javascript...).The structure of this folder is up to you, default implementation is just a suggestion.

>> #### Views
>> Here you can find al the .html.twig files that will be required for the store template. Check the section Template files to get more information.

> ### SCSS
> This default templates get SCSS code of this folder an compiles to "Resources/Public/css/". But this is just a suggestion, use Sass it's not mandatory and of course you can remove it and put your CSS directly in the public folder.

> ### Work-environment folders
> There are some folders that you will have after install the node modules, sass and grunt. These folders should never be commited and are just for the work environment, remember to git ignore them if it's necessary.

## Template files
The twig templates are located at "Resources/views". In Bamboo we use [Twig](http://twig.sensiolabs.org/) for the templates. So you can extend, include and organize your templates as you want.
All the files are organized by type, because some templates are required and other are totally up to you, the initial organization is just a proposal.

### Email
Here you can find the emails sent by the store, so you are able to personalize them as you want. All templates inside this folder are required.

### Layout
This files is called from other templates, so if you change the call from the other templates you can modify this as you want... except with one thing. You Layout must start {% extends '::_base.html.twig' %} and include the following blocks.

> #### {% block head_style %}
> This blocks is in the head of the page, the idea is to include here all the css or stuff you need to define inside the <head>

> #### {% block body %}
> This block starts and ends with the <body>... so here is where you need to add the html code to your template. The blocks defined inside this block are totally up to you.

> #### {% block foot_script %}
> This block starts just after the body block and just before to close the </body>. So, the idea is to include here all the scripts of the template.

### Modules
All the files here are included inside others, so if you edit the include from the others you can organizte this folder as you want. From our point of view, this organization makes sense but it's just our approximation.

### Pages
All the files of this folder are required. This are the main files called from the controllers, so if you delete or rename one of them the template will not work.

> #### cart-checkout.html.twig
> Page shown the user clicks on the checkout button.

> #### cart-checkout-fail.html.twig
> Page shown after something fails in the payment process.

> #### cart-view.html.twig
> List the products added to the cart.

> #### category-view.html.twig
> List the products inside a category.

> #### home-view.html.twig
> Homepage, list the products marked as shown in home.

> #### order-list.html.twig
> History list of orders done by the user.

> #### order-view.html.twig
> Details of one order.

> #### product-view-item.html.twig
> Detail of one product without variants.

> #### product-view-variant.html.twig
> Detail of one product with variants. By default extends the product-view-item.html.twig and overwrites the block product_info_add_basket.

> #### static.html.twig
> Layout for the static pages. The static content will be rendered inside the block "content".

> #### store-disable.html.twig
> Page shown when the store is not configured as enabled.

> #### store-under-construction.html.twig
> Page shown when the store is marked as under construction.

> #### user-edit.html.twig
> Page inside the user control panel to edit the personal data. Only available if the user is logged.

> #### user-home.html.twig
> Homepage for the user control panel. Only available if the user is logged.

> #### user-login.html.twig
> Page with the form to login the user.

> #### user-password-recover.html.twig
> Page with the form to recover the password.

> #### user-register.html.twig
> Page with the form to user's registration.

### Subpages
All the files of this folder are required. A Subpage is a Module included using the render method insted of include. Each subpage has a url to directly call them, but it makes no sense to go to this page, because are litte portions of the page. The reason to be Subpages instead of modules is just for performance and sustainability.

> #### cart-nav.html.twig
> This subpage is a module to preview the content of the cart
 
> #### category-list.html.twig
> This subpage is a module to display all the categories and subcategories

> #### coupon-add.html.twig
> This subpage is a module to add a little form to add coupons to the cart

> #### currency-list.html.twig
> This subpage is a module to display all the currencies enabled in the store

> #### user-nav.html.twig
> This subpage is a module to display the nav options for the user
 