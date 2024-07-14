Navigation: Getting started/Usage with Postman
sortOrder: 190

# Usage with Postman

[Postman](https://www.getpostman.com/) is a third party graphical user interface to easily communicate with RESTful APIs.

It enables you to directly import the swagger-defined GX3 API specification, which you can 
download <a href="/swagger.json" download target="_blank">here</a>.

Importing the specification into Postman automatically provides you with all API-Endpoints available and
additionally, most variables are already declared, allowing you to quickly explore the GX3 RESTful API.

## Defining your API location

Once you downloaded the swagger.json, it is advised to manually re-define your API's location according to your hosting.

To do so, open the previously downloaded `swagger.json` with a text-editor of your choice, and you will see a JSON document 
defining all of the API's available communication. 

To quickly customize the specification to your needs, change the following values at the beginning of the document:
```
{
	//...
	"host": "gambio-shop.de",
	"basePath": "shop1/api.php/v2"
	//...
}
```
by replacing the strings `gambio-shop.de`, and if necessary `shop1/api.php/v2`, according to your setup.

## Importing into Postman

Once the above stated changes were manually applied, you may proceed to open Postman. 

Navigate to `File` -> `Import...` in Postman's top menu bar.

<br>

<div class="text-center">
	<img src="/img/postman_file_import.png" />
</div>

<br>

Once clicked, a dialog will open asking you to specify what to import.

Either drag the edited `swagger.json` into the dialog, or click the `Choose Files` button and point Postman to the document.

<br>

<div class="text-center">
	<img src="/img/postman_import_choose_files.png" />
</div>

<br>

Once the API's `swagger.json` was imported into postman, you will have a Postman collection called Gambio GX3 API available, 
allowing you to quickly dive into the Gambio GX3 RESTful API.

<br>

<div class="text-center">
	<img src="/img/postman_collection_imported.png" />
</div>

<br>


## Setting up the environment variables

Postman enables you to define variables for most of the specified path parameters of the GX3 API.
We have already composed a basic Postman environment which you can import, thus saving you of writing boilerplate configuration.

You can find the Postman environment <a id="postman_env_download">here</a>.

After downloading, you may again choose `File` -> `Import...` in Postman's user interface and this time, 
import the above downloaded environment JSON document (`Gambio_GX3_api.postman_environment.json`).

<br>

<div class="text-center">
	<img src="/img/postman_import_choose_files.png" />
</div>

<br>

When imported, proceed to pick `Gambio GX3 Api` from the top-right drop-down menu in Postman's UI, and the environment variables are now all declared.

<br>

<div class="text-center">
	<img src="/img/postman_pick_environment.png" />
</div>

<br>

## Changing the environment variables

With the `Gambio_GX3_api.postman_environment.json` postman environment file imported and selected, 
you can click the small cog-wheel icon in the top right corner of postman's user interface.

<br>

<div class="text-center">
	<img src="/img/postman_click_cog_wheel.png" />
</div>

<br>

Once clicked, a modal will open showing you a list of available postman environments.

As we have just imported the postman environment for the Gambio GX3 API, you may click the entry to edit the environment variables.

<br>

<div class="text-center">
	<img src="/img/postman_manage_environment.png" />
</div>

<br>

In the environment editing mode, you may assign new values to dynamic variables, which will be handed over to your API requests.

<br>

<div class="text-center">
	<img src="/img/postman_edit_environment.png" />
</div>

<br>

## Authorizing requests

In order to communicate with your API, you will need to prove that you have enough permissions.
In the Gambio GX3 API this is done using the `HTTP Basic Auth` header, which is a base64 encrypted string
holding the username and password in your requests.

An example header would look as follows:
```
Authorization: Basic YWRtaW5Ac2hvcC5kZToxMjM0NQ==
```

Making use of postman's features, including authorization becomes less a hurdle.
Once you have selected an API Endpoint (example: `https://www.example.org/api.php/address_formats`) 
Postman allows you to pick the authorization type.

To gain communication-access to your API, you may choose the authorization type `Basic Auth`.

<br>

<div class="text-center">
	<img src="/img/postman_pick_basic_auth.png" />
</div>

<br>

You will be greeted with `Username` and `Password` input fields.
There you may enter your Shop's login credentials and start communicating with your API.

## Note about request bodies

Due to how Postman interprets the API's `swagger.json`, 
many request bodies falsely have the endpoint's description field and not the appropriate example field set.

When encountering this problem, you can navigate to an endpoint description using this documentation website's navigation section, 
and simply copy and paste the example request body into the `Body` field in Postman's User Interface.
