# Client Portal Skip Field

This plugin adds a hidden input field `<input type="hidden" name="is_skip" value="is_skip">` to Wordpress forms that aren't true conversions, to skip sending lead data to the client portal.

It works out of the box with Wordpress' native search form, Wordpress' native comment form, WooCommerce's single product add to cart form, WooCommerce's Cart 'Proceed to Checkout' form, GEO My WP's location search form, and Store locator location search form.

The comments form works for non-logged in users out of the box.  If you are using a theme where they use their own comment form function or you have many logged in commenters, you may have to wire up an action or filter in your theme based on how we do it in our plugin.

# Installation
If it's not already installed, you must install the <a href="https://github.com/afragen/github-updater" target="_blank">Github Updater</a> plugin to allow our plugin to be installed from a github.com code repo.  

<a href="https://github.com/afragen/github-updater/archive/master.zip">Download the ZIP file</a> and uploading the ZIP file to your Wordpress site.  Navigate to Plugins > Add New and click the green "Upload Plugin" button on the top of the page to upload the ZIP file.  Once ZIP is uploaded, you must *activate* the Github Updater plugin.

To install this plugin, navigate to Settings > Github Updater and go to the "Install Plugin" tab.  Paste in our Github URL of `https://github.com/shorelinemedia/client-portal-skip-field` and install the plugin.  *Activate* the Client Portal Skip Field plugin on the plugins page.

# Customization
In your theme, if you would like to insert the field through a hook that is available to you (we do this to add the field to parts of WooCommerce layout), use the function `sl9_client_portal_insert_hidden_skip_field` on any action.

Here's an example:

```php
add_action( 'woocommerce_after_add_to_cart_button', 'sl9_client_portal_insert_hidden_skip_field' );
```

### Manually add field to template/PHP

Sometimes your form HTML does not include an action or filter for you to hook into to manipulate your form HTML, in those cases, it's best to insert the hidden form field directly inside your `<form>` element using our `do_action` method.

```php
<form class="my-form">
  <?php do_action( 'sl9_client_portal_skip_field' ); ?>
</form>
```

-- OR --

You can use our function directly after checking for the function's existence:

```php
?>
<form class="my-form">
  <?php if ( function_exists( 'sl9_client_portal_insert_hidden_skip_field' ) ) {
    sl9_client_portal_insert_hidden_skip_field();
  } ?>
</form>
```


### Filters

In some cases, your form HTML might be manipulated with a filter, like the native Wordpress search form. If you have another plugin or theme function that relies on a filter to render the form HTML, you can use the function `sl9_client_portal_filter_hidden_skip_field` to filter your form HTML.

If you need to target additional HTML to replace with the hidden skip field, you can customize the matching pattern to match particular form HTML with the filter `sl9_skip_field_pattern`.

If you need to update the hidden field markup (only use at your own risk), use filter `sl9_skip_field_input`.

### Templates

Some HTML forms do not expose a filter or action to be able to manipulate form HTML on-the-fly. We use custom templates for some of these cases, like the WooCommerce 'orderby' filter dropdown.

If you have a custom template being used in your theme or plugin and you don't want us to serve our WooCommerce templates, in your theme simply use:

```
remove_filter( 'woocommerce_locate_template',  'sl9_client_portal_woocommerce_locate_template', 10, 3 );
```

If you would like to move our filter to a higher or lower priority, simply remove the filter as above and then use `add_filter` to reinstate the filter with your own priority.


[repo]: https://github.com/shorelinemedia/client-portal-skip-field
