![Stability PHP example code.](https://i.imgur.com/4AvgO09.png "Stability PHP example code.")

Stability PHP is a PHP API client offering developers an intuitive and efficient interface to interact seamlessly with the [Stability AI API](https://platform.stability.ai/docs/api-reference "Stability AI API").

## Table of Contents
- [ **Installation**](#installation)
- [**Usage**](#usage)
	- [User](#user)
		- [Account](#account)
		- [Balance](#balance)
	- [Engines](#engines)
		- [List](#list)
	- [Generations](#generations)
		- [Text to Image](#text-to-image)
		- [Image to Image](#image-to-image)
		- [Image to Image Upscale](#image-to-image-upscale)
		- [Image to Image Masking](#image-to-image-masking)
- [**License**](#license)

## Installation

You can install the package via composer:

```bash
composer require thehocinesaad/stability-php
```
After that, you can start using it:

```php
$client = Stability::client('YOUR_API_KEY');

$response = $client->generations()->textToImage('stable-diffusion-xl-1024-v1-0', [
    'text_prompts' => [
        [
            'text' => 'A lighthouse on a cliff',
            'weight' => 0.5
        ],
    ],
    'samples' => 1,
]);

dd($response['artifacts'][0]['base64']);
// "iVBORw0KGgoAAAANSUhEUgAABAAAAAQACAIAAADwf7zUAAM8MmNhQ..." - Image encoded in base64.
```
You can add additional HTTP headers (which the API supports) to requests:

```php
$client = Stability::client(YOUR_API_KEY')
    ->withAcceptHeader('image/png')
    ->withOrganizationHeader('org-123456')
    ->withStabilityClientIdHeader('my-great-plugin')
    ->withStabilityClientVersionHeader('1.2.1');
```

## Usage

### User

Manage your Stability.ai account, and view account/organization balances.

#### **`Account`**
Get information about the account associated with the provided API key.
* See: https://platform.stability.ai/docs/api-reference#tag/v1user/operation/userAccount

```php
$response = $client->user()->account();

$response['email']; // 'your@email.com'
$response['id']; // 'user-xxxxxxxxxxxxxxx'
// ...
```

------------

#### **`Balance`** 
Get the credit balance of the account/organization associated with the API key.
* See: https://platform.stability.ai/docs/api-reference#tag/v1user/operation/userBalance

```php
$response = $client->user()->balance();

$response['credits']; // 1000000 😍
```

### Engines

Enumerate available engines.

#### **`List`** 
List all engines available to your organization/user.
* See: https://platform.stability.ai/docs/api-reference#tag/v1engines/operation/listEngines

```php
$response = $client->engines()->list();
// Returns an array of available engines.

foreach ($response as $engine) {
    $engine['description']; // 'Stability-AI Stable Diffusion XL v1.0'
    $engine['id']; // 'stable-diffusion-xl-1024-v1-0'
    $engine['name']; // 'Stable Diffusion XL v1.0'
    $engine['type']; // 'PICTURE'
}
```

### Generations

Generate images from text, existing images, or both.

#### **`Text to Image`** 
Generate a new image from a text prompt.
* See: https://platform.stability.ai/docs/api-reference#tag/v1generation/operation/textToImage

```php
$response = $client->generations()->textToImage('stable-diffusion-xl-1024-v1-0', [
    'text_prompts' => [
        [
            'text' => 'A lighthouse on a cliff',
        ],
    ],
    'cfg_scale' => 7,
    'height' => 1024,
    'width' => 1024,
    'steps' => 30,
    'samples' => 2,
]);

foreach ($response['artifacts'] as $result) {
    $result['base64']; // 'iVBORw0KGgoAAAANSUhEUgAAAgAAAAIACAIAAA...'
    $result['seed']; // 6311659811
    $result['finishReason']; // 'SUCCESS'
}
```

------------

#### **`Image to Image`** 
Modify an image based on a text prompt.
* See: https://platform.stability.ai/docs/api-reference#tag/v1generation/operation/imageToImage

```php
$response = $client->generations()->imageToImage(stable-diffusion-xl-1024-v1-0', [
    'init_image' => 'init_image.png',
    'init_image_mode' => 'IMAGE_STRENGTH',
    'image_strength' => '0.35',
    'text_prompts' => [
        [
            'text' => 'A lighthouse on a cliff',
        ],
    ],
    'cfg_scale' => 7,
    'steps' => 10,
    'samples' => 2,
]);

foreach ($response['artifacts'] as $result) {
    $result['base64']; // 'iVBORw0KGgoAAAANSUhEUgAABAAAAAQACAIAAA...'
    $result['seed']; // 4285698893
    $result['finishReason']; // 'SUCCESS'
}
```

------------

#### **`Image to Image Upscale`** 
Create a higher resolution version of an input image.
* See: https://platform.stability.ai/docs/api-reference#tag/v1generation/operation/upscaleImage

```php
$response = $client->generations()->imageToImageUpscale('esrgan-v1-x2plus', [
    'image' => 'image.png',
    'width' => '1024',
]);

$response['artifacts'][0]['base64']; // 'iVBORw0KGgoAAAANSUhEUgAAAgAAAAIACAIAAAB7GkOtAAD...'
$response['artifacts'][0]['seed']; // 0
$response['artifacts'][0]['finishReason']; // 'SUCCESS'
```

------------

#### **`Image to Image Masking`** 
Selectively modify portions of an image using a mask.
* See: https://platform.stability.ai/docs/api-reference#tag/v1generation/operation/masking

```php
$response = $client->generations()->imageToImageMasking('stable-inpainting-512-v2-0', [
    'mask_source' => 'MASK_IMAGE_BLACK',
    'init_image' => 'init_image.png',
    'mask_image' => 'mask_image.png',
    'text_prompts' => [
        [
            'text' => 'A lighthouse on a cliff',
        ],
    ],
    'cfg_scale' => 7,
    'clip_guidance_preset' => 'FAST_BLUE',
    'steps' => 10,
    'samples' => 2,
]);

foreach ($response['artifacts'] as $result) {
    $result['base64']; // 'iVBORw0KGgoAAAANSUhEUgAABAAAAAQACAIAAADwf7...'
    $result['seed']; // 96898585
    $result['finishReason']; // 'SUCCESS'
}
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.