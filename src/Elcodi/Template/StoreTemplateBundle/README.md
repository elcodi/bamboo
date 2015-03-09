# Custom templates for bamboo/elcodi
In order to make a template fully compatible with Bamboo engine (The elcodi e-commerce implementation) we have created a small standard. Customizing this bundle you can create themes for bamboo/elcodi. Please read this documentation carefully before edit anything.

## Requirements for all the templates in live mode
To use the templates in a real environment you need to install and setup locally [Bamboo/elcodi](https://github.com/elcodi/bamboo)

## Requirements to preview twig files as html
 
It's possible to compile the twig files as html to preview your templates without need to have all the real environment. All you need to do is follow this steps:

- Install [NodeJS](https://nodejs.org/)
- run "npm install" in the root directory of this template
- Install [Ruby & Sass](http://sass-lang.com/install)
- Run "Grunt" to compile or "Grunt Watch" to compile when you save any .twig or .scss file

## Folders

Let's take a look to all the folders of this bundle and what can we find inside.

### Fixtures
This folder contains json files with a simulation of the database and the vars you have available in each template.
This is a read-only folder, maybe could be useful for your information but you should don't change anything.

### Resources
This is the main folder of your template. Inside this folder you will find two subfolders; Public & Views.

#### Public
This directory is to host the all the public files your template will need (images, fonts, javascript...).The structure of this folder is up to you, default implementation is just a suggestion.

#### Views
Here you can find al the .html.twig files that will be required for the store template. Check the section Template files to get more information.

### SCSS
This default templates get SCSS code of this folder an compiles to "Resources/Public/css/". But this is just a suggestion, use Sass it's not mandatory and of course you can remove it and put your CSS directly in the public folder.

### Work-environment folders
There are some folders that you will have after install the node modules, sass and grunt. These folders should never be committed and are just for the work environment, remember to git ignore them if it's necessary.

## Template files, Context & Hooks
The twig templates are located at "Resources/views". In Bamboo we use [Twig](http://twig.sensiolabs.org/) for the templates. So you can extend, include and organize your templates as you want.
All the files are organized by type, because some templates are required and other are totally up to you, the initial organization is just a proposal.

### Global
The following context and hooks are available in all the twig files.

#### Global context
All twig files will have the following contexts available:

- **current_user_session_id** : Current user session id
- **current_user_session_sha1** : Current user session id with sha1 applied
- **current_route_name** : Current route name
- **store_tracker** : Store tracker value. Unique per store.

#### Global Hooks
All twig files will have the following contexts available:

- **store.head_bottom** : @todo add description
- **store.body_top** : @todo add description
- **store.body_bottom** : @todo add description

### Layout

#### _checkout.html.twig

This layout is used on the checkout process pages, but it's not mandatory because at the end is calling the main layout file and overwriting the block "content".

#### _email.html.twig

Layout used in the mails. The content of the emails are editable at the bamboo admin, this is just the container. @todo the template is empty

#### _static.html.twig

This layout is mandatory, and it's called by all the static pages and blog pages. The static content will be rendered inside the block "content".
 **Context**
 - **page** : @todo add description


#### _layout.html.twig

This is the the basic layout of your template, is mandatory and needs to start with{% extends '::_base.html.twig' %} and include the following blocks.

> ##### {% block head_style %}

> This blocks is in the head of the page, the idea is to include here all the css or stuff you need to define inside the <head>

> ##### {% block body %}

> This block starts and ends with the body... so here is where you need to add the html code to your template. The blocks defined inside this block are totally up to you.

> ##### {% block foot_script %}

> This block starts just after the body block and just before to close the body. So, the idea is to include here all the scripts of the template.


### Modules
All the files here are included inside others, so if you edit the include from the others you can organize this folder as you want. From our point of view, this organization makes sense but it's just our approximation.

### Pages
All the files of this folder are required. This are the main files called from the controllers, so if you delete or rename one of them the template will not work.

#### cart-view.html.twig
Page shown the user clicks on the checkout button.
 **Context**
 - **@todo add context**: @todo add description
 **Hooks**
 - **@todo add hook**: @todo add hook description

####  cart-checkout-fail.html.twig
 Page shown after something fails in the payment process.
> **Context**
> - **@todo add context**: @todo add description
> **Hooks**
> - **@todo add hook**: @todo add hook description


####  cart-view.html.twig
 List the products added to the cart.
> **Context**
> - **@todo add context**: @todo add description
> **Hooks**
> - **@todo add hook**: @todo add hook description


####  category-view.html.twig
 List the products inside a category.
> **Context**
> - **@todo add context**: @todo add description
> **Hooks**
> - **@todo add hook**: @todo add hook description


####  home-view.html.twig
 Homepage, list the products marked as shown in home.
> **Context**
> - **@todo add context**: @todo add description
> **Hooks**
> - **@todo add hook**: @todo add hook description


####  order-list.html.twig
 History list of orders done by the user.
> **Context**
> - **@todo add context**: @todo add description
> **Hooks**
> - **@todo add hook**: @todo add hook description


####  order-view.html.twig
 Details of one order.
> **Context**
> - **@todo add context**: @todo add description
> **Hooks**
> - **@todo add hook**: @todo add hook description


####  product-view-item.html.twig
 Detail of one product without variants.
> **Context**
> - **@todo add context**: @todo add description
> **Hooks**
> - **store.product_view_bottom**: @todo add hook description
> - **product**: @todo add hook description

####  product-view-variant.html.twig
 Detail of one product with variants. By default extends the product-view-item.html.twig and overwrites the block product_info_add_basket.
> **Context**
> - **@todo add context**: @todo add description
> **Hooks**
> - **store.product_view_bottom**: @todo add hook description
> - **product**: @todo add hook description

####  static.html.twig
 Layout for the static pages. The static content will be rendered inside the block "content".
> **Context**
> - **@todo add context**: @todo add description
> **Hooks**
> - **@todo add hook**: @todo add hook description

####  store-disable.html.twig
 Page shown when the store is not configured as enabled.
> **Context**
> - **@todo add context**: @todo add description
> **Hooks**
> - **@todo add hook**: @todo add hook description


####  store-under-construction.html.twig
 Page shown when the store is marked as under construction.
> **Context**
> - **@todo add context**: @todo add description
> **Hooks**
> - **@todo add hook**: @todo add hook description


####  user-edit.html.twig
 Page inside the user control panel to edit the personal data. Only available if the user is logged.
> **Context**
> - **@todo add context**: @todo add description
> **Hooks**
> - **@todo add hook**: @todo add hook description

####  user-home.html.twig
 Homepage for the user control panel. Only available if the user is logged.
> **Context**
> - **@todo add context**: @todo add description
> **Hooks**
> - **@todo add hook**: @todo add hook description

####  user-login.html.twig
 Page with the form to login the user.
> **Context**
> - **@todo add context**: @todo add description
> **Hooks**
> - **@todo add hook**: @todo add hook description

####  user-password-recover.html.twig
 Page with the form to recover the password.
> **Context**
> - **@todo add context**: @todo add description
> **Hooks**
> - **@todo add hook**: @todo add hook description

####  user-register.html.twig
 Page with the form to user's registration.
> **Context**
> - **@todo add context**: @todo add description
> **Hooks**
> - **@todo add hook**: @todo add hook description

####  address-edit.html.twig
 Page shown when the user adds or edits his addresses. This page includes the LocationSelectors JS from the Geo bundle to make the city selectors work.
> **Context**
> - **address**: The address being edited, if the id field is set you are editing an address if it’s empty it’s a new address. View address object documentation
> **Hooks**
> - **form**: The add address form. View “store_geo_form_type_address” documentation


####  blog-posts-list.html.twig
 Blog pagination. This page lists all available blog posts, including simple pagination. Number of posts is N
> **Context**
> - **blogPosts**: Array of blogPost elements to be shown
> - **currentPage**: Current page shown
> - **numberOfPages**: Number of pages
> **Hooks**
> - **store.blog_posts_list_bottom**
> -- blog_posts
> -- current_page
> -- number_of_pages

####  blog-posts-view.html.twig
 Blog post page.
> **Context**
> - **blogPosts**: Array of blogPost elements to be shown
> **Hooks**
> - **store.blog_posts_list_bottom**
> -- blog_posts

### Subpages
All the files of this folder are required. A Subpage is a Module included using the render method insted of include. Each subpage has a url to directly call them, but it makes no sense to go to this page, because are litte portions of the page. The reason to be Subpages instead of modules is just for performance and sustainability.

####  cart-nav.html.twig
 This subpage is a module to preview the content of the cart
> **Context**
> **Context**
> - **@todo add context**: @todo add description
> **Hooks**
> - **@todo add hook**: @todo add hook description

####  category-nav.html.twig
This subpage is a module to display all the categories and subcategories
> **Context**
> - **@todo add context**: @todo add description
> **Hooks**
> - **@todo add hook**: @todo add hook description


####  coupon-add.html.twig
This subpage is a module to add a little form to add coupons to the cart
> **Context**
> - **@todo add context**: @todo add description
> **Hooks**
> - **@todo add hook**: @todo add hook description

####  currency-nav.html.twig
This subpage is a module to display all the currencies enabled in the store
> **Context**
> - **@todo add context**: @todo add description
> **Hooks**
> - **@todo add hook**: @todo add hook description

####  user-nav.html.twig
This subpage is a module to display the nav options for the user
> **Context**
> - **@todo add context**: @todo add description
> **Hooks**
> - **@todo add hook**: @todo add hook description

## Objects data

These are all the objects detailed that you will get in the context. Check the templates context to see when they are available.

### Address

## Forms data

These are all the forms objects detailed that you will get in the context. Check the templates context to see when they are available.

### store_geo_form_type_address

## Questions?

If you have any questions, please feel free to ask on [Gitter](https://gitter.im/elcodi/elcodi) or email us to tech@elcodi.com

