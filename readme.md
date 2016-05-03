# Modaal WordPress Plugin

Basic feature list:

 * Allows ease of implementing the [Humaan Modaal](www.humaan.com/modaal) in Wordpress.
 * Provides a shortcode to add image, image gallery, inline, and video modals
 * By default uses the inline configuration (data-modaal-*) attributes which can be added via shortcode using a comma delimited string where key and value are separated by a colon.  See example below.
 * Able to create the modaal markup without using the inline configuration attributes so it can be manipulated by your own javascript (Recommended if adding own javascript events)
 * Insert images between the shortcode tags using the media library and the shortcode will extract out the image src and produce the modaal markup to make an image gallery modal.
 * Future: May add filter hooks to manipulate markup even more

### Example 1 (Inline):
In a Wordpress Post:
```html
[modaal type="inline" button_text="Click Here" attribs="hide-close:true,background:#229933,before-open:modaalClose"]
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