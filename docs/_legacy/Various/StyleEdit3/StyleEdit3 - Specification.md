# StyleEdit3 - Specification

This document describes the requirements a template must fulfill in order to be StyleEdit3 compatible. 

## 1. Dynamic CSS Compilation 

The template must compile it's CSS code dynamically in order to be able to include the StyleEdit values inside 
its final stylesheets. A compilation library of popular CSS preprocessor like SASS and LESS will fit just fine 
for this task. StyleEdit3 handling mostly variable values but can also accept custom CSS rules that can be later 
included in the final CSS file of the template file. 

It would be important to define a cache mechanism for the dynamic CSS stylesheets because their generation is 
time consuming and shouldn't be repeated with every template load.
 
## 2. StyleEdit3 Configuration 

StyleEdit works with style configuration files (referred as styles from now on), which are JSON formatted and have a  
specific structure that contain the information of the template modifications. Make sure that you check the  
"Configuration JSON Schema.json" file and other samples. 

Before being able to create your own styles StyleEdit expects some boilerplate styles to be present. They will be
used for the creation of the newer styles and variations. The advantage of the boilerplate mechanism is that you can 
actually update the boilerplates along with the template and introduce newer variables to StyleEdit. 

After having some boilerplate files you can actually define the first active style for the template. This will need
to be present at the beginning as the initial "active" style. Later on StyleEdit will be able to create new styles 
and change the active one upon request. 

## 3. API Support 

During the StyleEdit operation there are some requirements the template must support in order to work well with 
the app. The following list describes them briefly: 

- **The main template CSS `<link>` tag must have the `main-css` id.** This is done because StyleEdit will have 
to refresh its "href" property many times. 
- **The CSS generation script must be able to be called with the `style_name=My%20Style%20Name` Get parameter**. When 
this is the case it must return the CSS that corresponds to the provided style name. Note that the names will be always
URL encoded. 
- **The generation script must be able to be called with the `renew_cache=1` GET parameter.** This must renew the 
cached CSS file. This parameter will be used mostly to display changes or after a style is saved.  
