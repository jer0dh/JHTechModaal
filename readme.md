# Modaal WordPress Plugin

Basic feature list:

 * Allows ease of implementing the [Humaan Modaal](http://humaan.com/modaal) in WordPress.
 * Provides a shortcode to add image, image gallery, inline, and video modals
 * By default uses the inline configuration (`data-modaal-*`) attributes which can be added via shortcode using a comma delimited string where key and value are separated by a colon.  See example below.
 * Able to create the modaal markup without using the inline configuration attributes so it can be manipulated by your own javascript (Recommended if adding own javascript events)
 * Insert images between the shortcode tags using the media library and the shortcode will extract out the image src and produce the modaal markup to make an image gallery modal.
 * Added 2 Filter hooks to allow one to 
   1. provide default values for the inline configuration attributes (`data-modaal-*`)
   2. override values for the inline configuration attributes (`data-modaal-*`)
 * modaal.js is enqueued only if shortcode is used on page or post.
 * create a link to modal using image or html by nested shortcode `[modaal_link]` 

## Shortcode Syntax
```html
[modaal ATTRIBUTES] CONTENT [/modaal]
```
where ATTRIBUTES can be:
 * `type` : 'inline', 'image', 'video', or 'iframe'.  Default: 'inline'
 * `button_class` : adds this value to class attribute on `<a>` tag.
 * `button_text` : becomes the link to click on to show the modal.
 * `attribs` : a comma delimited string where key and value are separated by a colon. The keys are the same configuration options found on [Modaal's github documentation](https://github.com/humaan/Modaal).  Remember replace the underscores with hyphens. This will produce the `data-modaal-` attributes in the markup. NOTE: Events do not work here
 * `inline_config` : `true` or `false` - If `false`, must call `$().modaal` manually with the config (`attribs` will not work), especially used if needing to call js functions for any modaal events.  Default: `true`
 * `id` : adds an `id` attribute to the `<a>` tag.  Could be used to target this modal when `inline_config` is `false`.
 * `width` : used only if `type` is `iframe`.  Default `400`
 * `height` : used ony if `type` is `iframe`. Default `300`
 
where CONTENT can be:
* any html/text to be shown if `type` is `inline`.  This content will be wrapped in a `<div>` with an inline style of `display:none;`
* A single or multiple `<img>` tags if `type` is `image`
* A URL to a YouTube or Vimeo video if `type` is `video`.  See above Humaan link regarding recommended video URL syntax.  Since WordPress converts these URLs to an iframe before the shortcode gets called, you can also put in an iframe here and it will extract the `src`.  It will not copy any of the iframe's attributes.
* An iframe if `type` is `iframe`.  Due to Modaal's markup, it doesn't copy or use the iframe's attributes.  Like a `video` it extracts the `src` URL.


### Example 1 (Inline):
In a WordPress Post:
```html
[modaal type="inline" button_text="Click Here" attribs="hide-close:true,background:#229933"]
<p> This is a test </p>
<img src="https://staging3.jhtechservices.com/wp-content/uploads/coffee638x344-300x1611-150x150.jpg" alt="coffee638x344-300x161" width="150" height="150" class="alignnone" />
[/modaal]
```
Would produce the following markup.
```html
<a href="#inline-modaal-0" class="modaal " data-modaal-hide-close="true" data-modaal-background="#229933" data-modaal-type="inline">Click Here</a>

<div id="inline-modaal-0" style="display:none;">
<p> This is a test </p>
<p><img src="https://jhtechservices.com/wp-content/uploads/coffee638x344-300x1611-150x150.jpg" alt="coffee638x344-300x161" class="alignnone" height="150" width="150"></p>
</div>
```
### Example 2 (Image gallery):
In a WordPress Post:
```html
[modaal type="image" button_text="Click"]

<img src="https://staging3.jhtechservices.com/wp-content/uploads/wpcircuitry-285x300.jpg" alt="wpcircuitry" width="285" height="300" class="alignnone size-medium wp-image-913" />

<img src="https://staging3.jhtechservices.com/wp-content/uploads/GitHub-Mark-64px.png" alt="GitHub-Mark-64px" width="64" height="64" class="alignnone size-full wp-image-910" />

<img src="https://staging3.jhtechservices.com/wp-content/uploads/jscircuitry-300x242.jpg" alt="jscircuitry" width="300" height="242" class="alignnone size-medium wp-image-912" />

<img src="https://staging3.jhtechservices.com/wp-content/uploads/HTML5_css3_circuitry-300x144.jpg" alt="HTML5_css3_circuitry" width="300" height="144" class="alignnone size-medium wp-image-911" />

[/modaal]
```
Would produce the following markup:
```html
<a href="https://jhtechservices.com/wp-content/uploads/wpcircuitry-285x300.jpg" class="modaal " rel="gallery-0" data-modaal-type="image">Click</a>

<a href="https://jhtechservices.com/wp-content/uploads/GitHub-Mark-64px.png" class="modaal " rel="gallery-0" data-modaal-type="image"></a>

<a href="https://jhtechservices.com/wp-content/uploads/jscircuitry-300x242.jpg" class="modaal " rel="gallery-0" data-modaal-type="image"></a>

<a href="https://staging3.jhtechservices.com/wp-content/uploads/HTML5_css3_circuitry-300x144.jpg" class="modaal " rel="gallery-0" data-modaal-type="image"></a>
```

### Example 3 (video):
In a WordPress Post:
```html
[modaal type="video" button_text="Video" id="testing3"]
https://www.youtube.com/watch?v=y685gVGRQ98
[/modaal]
```
Would produce the following markup:
```html
<a id="testing3" href="https://www.youtube.com/embed/y685gVGRQ98?feature=oembed" class="modaal " data-modaal-type="video">Video</a>
```
## Optional nested shortcode to add image or html links
```html
[modaal ATTRIBUTES] [modaal_link] HTML-CONTENT [/modaal_link] CONTENT [/modaal]
```
where HTML-CONTENT can be html that will be surrounded by the `<a>` tags so it will be clickable and open the modal.  (NOTE: do not add any `<a>` tags in this HTML)

### Example of [modaal_link]
In a WordPress post
```html
[modaal type="image" button_text="Click" id="testing"]
[modaal_link]<img src="https://jhtechservices.com/wp-content/uploads/GitHub-Mark-64px.png" alt="GitHub-Mark-64px" width="64" height="64" class="alignnone size-full wp-image-910" />[/modaal_link]
<img src="https://jhtechservices.com/wp-content/uploads/wpcircuitry-285x300.jpg" alt="wpcircuitry" width="285" height="300" class="alignnone size-medium wp-image-913" />
<img src="https://jhtechservices.com/wp-content/uploads/GitHub-Mark-64px.png" alt="GitHub-Mark-64px" width="64" height="64" class="alignnone size-full wp-image-910" />
[/modaal]
```
Would produce the following markup:
```html
<a id="testing" href="https://jhtechservices.com/wp-content/uploads/wpcircuitry-285x300.jpg" class="modaal " rel="gallery-2" data-modaal-type="image">
   <img src="https://jhtechservices.com/wp-content/uploads/GitHub-Mark-64px.png" alt="GitHub-Mark-64px" class="alignnone size-full wp-image-910" height="64" width="64">
</a>
<a href="https://jhtechservices.com/wp-content/uploads/GitHub-Mark-64px.png" class="modaal " rel="gallery-2" data-modaal-type="image"></a>
```

## Filter Hooks
Both hooks available allow you to alter the Humaan Modaal inline configuration options found on [Modaal's github documentation](https://github.com/humaan/Modaal). They both pass in an associative array where the key is the option name (remember to make underscores into hyphens).

There are two filters hooks.
  1. `jhtech_modaal_default_attribs` - add any default options and values you want all shortcodes to use.  Any key/value pair in the shortcodes `attribs` attribute will override these default values.
  2. `jhtech_modaal_override_attribs` - used to override any `attribs` key/value pairs. 

### Example (Filter Hook):
This example will change the background color of the modal overlay to purple for all [modaal] shortcodes used.  If the shortcode specifies a background color, the shortcode's color will be used instead of purple.  This code is in the theme's `functions.php`:
```php

add_filter( 'jhtech_modaal_default_attribs', 'jhtech_modaal_add_default' );

function jhtech_modaal_add_default($attribs) {
	$attribs['background'] = '#770088';
	return $attribs;
}
```

## Installation
  1. Copy the jhtechmodaal folder into your WordPress's `\wp-content\plugins` folder.
  2. Go to your Plugins in the WordPress dashboard and Activate this plugin.
  3. Add your `[modaal]` shortcode in your pages and posts where you want the link to open the modal.