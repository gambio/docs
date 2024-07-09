# Image List

An image list is a collection of images that can be referenced in several other parts of the shop software.


## Image List domain

The image list domain provides management functionality (create, read, update and delete), as well as the possibility
to filter all existing image lists. It's important to know that the image lists are referenced by the other domains
like *product options* or *product variants*, therefore, it's not possible to delete image list or image list values
that are used in these domains.


## Aggregate root and domain model

The aggregate root `Gambio\Admin\Modules\ImageList\Model\ImageList` encapsulates mainly a collection of images, but
also has a name. The contained images are defined by a relative path that is based on the
`images/product_images/original_images` directory. Furthermore, these images provide a sort order and language-dependent
titles (used for the `title` attribute of the `img` tag) and alternative titles (used for the `alt` attribute of the
`img` tag).

After creation, the aggregate root provides the possibility to change the attributes of the image list itself, as well
as, adding, updating or removing the contained images.


### Use cases using read service


#### Fetching all or a specific image list

```php
/** $readService \Gambio\Admin\Modules\ImageList\Services\ImageListReadService **/

$allImageLists     = $readService->getAllImageLists();
$specificImageList = $readService->getImageListById($imageListId = 1);
```


### Use cases using write service


#### Creating a new image list

```php
/** $writeService \Gambio\Admin\Modules\ImageList\Services\ImageListWriteService **/


$id = $writeService->createImageList($imageListName = 'my-image-list');
```


#### Creating multiple image lists at once

```php
/** $writeService \Gambio\Admin\Modules\ImageList\Services\ImageListWriteService **/

$imageListNames = [
    'my-first-image-list',
    'my-second-image-list',
];

$ids = $writeService->createMultipleImageLists(...$imageListNames);
```


#### Updating the image lists name
```php
/** $readService \Gambio\Admin\Modules\ImageList\Services\ImageListReadService **/
/** $writeService \Gambio\Admin\Modules\ImageList\Services\ImageListWriteService **/

$imagelist = $readService->getImageListById($imageListId = 1);
$imagelist->changeName($newName = 'my-new-image-list-name');

$writeService->storeImageLists($imagelist);
```


#### Adding an image to an image list
```php
/** $readService \Gambio\Admin\Modules\ImageList\Services\ImageListReadService **/
/** $writeService \Gambio\Admin\Modules\ImageList\Services\ImageListWriteService **/
/** $factory \Gambio\Admin\Modules\ImageList\Services\ImageListFactory **/

$localPath = $factory->createImagePath($relativePath = 'relative-path-to/image.jpg');
$titles    = $factory->createImageTitles(
    $factory->createImageTitle($languageCode1 = 'en', $title1 = 'titel - en'),
    $factory->createImageTitle($languageCode2 = 'de', $title2 = 'titel - de')
);
$altTitles = $factory->createImageAltTitles(
    $factory->createImageAltTitle($altLanguageCode1 = 'en', $altTitle1 = 'alt titel - en'),
    $factory->createImageAltTitle($altLanguageCode2 = 'de', $altTitle2 = 'alt titel - de')
);

$newImage = $factory->createNewImage($localPath, $titles, $altTitles, $sortOrder = 1);

$imagelist = $readService->getImageListById($imageListId = 1);
$imagelist->addNewImages($newImage); // It's also possible to add multiple images at once

$writeService->storeImageLists($imagelist);
```


#### Updating a (image list) value of an image list
```php
/** $readService \Gambio\Admin\Modules\ImageList\Services\ImageListReadService **/
/** $writeService \Gambio\Admin\Modules\ImageList\Services\ImageListWriteService **/
/** $factory \Gambio\Admin\Modules\ImageList\Services\ImageListFactory **/

$newTitles = $factory->createImageTitles(
    $factory->createImageTitle($languageCode1 = 'en', $title1 = 'new titel - en'),
    $factory->createImageTitle($languageCode2 = 'de', $title2 = 'new titel - de')
);

$imagelist    = $readService->getImageListById($imageListId = 1);
$image        = $imagelist->images()->getByLocalPath($relativePath = 'relative-path-to/image.jpg');
$updatedImage = $image->withSortOrder($newSortOrder = 1)->withTitles($newTitles);
$imagelist->changeImages($updatedImage); // It's also possible to change multiple images at once

$writeService->storeImage Lists($imagelist);
```


#### Removing a (image list) value from an image list
```php
/** $readService \Gambio\Admin\Modules\ImageList\Services\ImageListReadService **/
/** $writeService \Gambio\Admin\Modules\ImageList\Services\ImageListWriteService **/
/** $factory \Gambio\Admin\Modules\ImageList\Services\ImageListFactory **/

$imagelist = $readService->getImageListById($imageListId = 1);
$imagelist->removeImage($factory->createImagePath($relativePath = 'relative-path-to/image.jpg'));

$writeService->storeImageLists($imagelist);
```


#### Deleting an image list
```php
/** $writeService \Gambio\Admin\Modules\ImageList\Services\ImageListWriteService **/

$imagelistIds = [1, 2];

$writeService->deleteImageLists(...$imagelistIds);
```


### Use cases using filter service


#### Filter all existing image lists including sorting and pagination

```php
/** $filterService \Gambio\Admin\Modules\ImageList\Services\ImageListFilterService **/

$filters = [
    'images.localPath' => '*.png', // Image lists that have at least one image that end with `.png`
];
$sorting = '-name'; // In descending order of name
$limit   = 25;
$offset  = 0;

$filteredImageLists             = $filterService->filterImageLists($filters, $sorting, $limit, $offset);
$totalCountOfFilteredImageLists = $filterService->getImageListsTotalCount($filters);
```


##### Filtering

The filter array that is given to the filter service maps the attributes of the image list and the filtering term.
The assigned string (e.g. `get|2020-01-01`) always contains the comparison value, but it also may contain an
operation (e.g. `gte` for greater than or equals to). Leaving the operation (e.g. `2020-01-01`) will be the same
as using *equals to* (`eq`).

The following table shows all attributes and the operations that can be used on them.

|   | like (`*`) | equals to (`eq`) | lower than (`lt`) | lower than or equals to (`lte`) | greater than (`gt`) | greater than or equals to (`gte`) |
|---|:---:|:---:|:---:|:---:|:---:|:---:|
| `id`                            |   | X | X | X | X | X |
| `name`                          | X | X |   |   |   |   |
| `images.localPath`              | X | X |   |   |   |   |
| `images.webPath`                | X | X |   |   |   |   |
| `images.sortOrder`              |   | X | X | X | X | X |
| `images.titles.languageCode`    | X | X |   |   |   |   |
| `images.titles.text`            | X | X |   |   |   |   |
| `images.altTitles.languageCode` | X | X |   |   |   |   |
| `images.altTitles.text`         | X | X |   |   |   |   |


##### Sorting

To change the sorting, you can provide a string that describes the sorting order. The string must contain the
attributes used for sorting. If there is a minus (`-`) in front of the attribute, it will be sorted in descending
order. You can use multiple attributes to change the sorting order by linking them with a comma (`,`).


## Business rules

- All local paths of images inside an image list must be uniq.


## Domain events

| Event | Description |
| ----- | ----------- |
| `Gambio\Admin\Modules\ImageList\Model\Events\ImageAdded`            | Will be raised if a new image has been added to an image list. |
| `Gambio\Admin\Modules\ImageList\Model\Events\ImageListCreated`      | Will be raised if a new image list has been created. |
| `Gambio\Admin\Modules\ImageList\Model\Events\ImageListDeleted`      | Will be raised if an image list has been deleted. |
| `Gambio\Admin\Modules\ImageList\Model\Events\ImageDeleted`          | Will be raised if an image has been removed from an image list. |
| `Gambio\Admin\Modules\ImageList\Model\Events\ImageUpdated`          | Will be raised if the image of an image list has been updated. |
| `Gambio\Admin\Modules\ImageList\Model\Events\ImageListsNameUpdated` | Will be raised if the name of an image list has been updated. |