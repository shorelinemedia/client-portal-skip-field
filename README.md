# Client Portal Skip Field

This plugin adds a hidden input field `<input type="hidden" name="is_skip" id="is_skip" value="true">` to Wordpress forms that aren't true conversions, to skip sending lead data to the client portal.

It works out of the box with Wordpress' native search form, WooCommerce's single product add to cart form, WooCommerce's Cart 'Proceed to Checkout' form, GEO My WP's location search form, and Store locator location search form.

# Customization
In your theme, if you would like to insert the field through a hook that is available to you (we do this to add the field to parts of WooCommerce layout), use the function `sl9_client_portal_insert_hidden_skip_field` on any action.

### Filters

In some cases, your form HTML might be manipulated with a filter, like the native Wordpress search form. If you have another plugin or theme function that relies on a filter to render the form HTML, you can use the function `sl9_client_portal_filter_hidden_skip_field` to filter your form HTML.

If you need to target additional HTML to replace with the hidden skip field, you can customize the matching pattern to match particular form HTML with the filter `sl9_skip_field_pattern`.

If you need to update the hidden field markup (only use at your own risk), use filter `sl9_skip_field_input`. Use the <a href="https://github.com/afragen/github-updater" target="_blank">Github Updater</a> plugin to update this plugin in the future.

### Templates

Some HTML forms do not expose a filter or action to be able to manipulate form HTML on-the-fly. We use custom templates for some of these cases, like the WooCommerce 'orderby' filter dropdown.

If you have a custom template being used in your theme or plugin and you don't want us to serve our WooCommerce templates, in your theme simply use:

``
remove_filter( 'woocommerce_locate_template',  'sl9_client_portal_woocommerce_locate_template', 10, 3 );
``

If you would like to move our filter to a higher or lower priority, simply remove the filter as above and then use `add_filter` to reinstate the filter with your own priority.
