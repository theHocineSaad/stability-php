<?php

declare(strict_types=1);

namespace Stability\Resources;

use Stability\Services\HttpService;

class Generations
{
    private HttpService $httpService;

    public function __construct(private array $parameters)
    {
        $this->httpService = $this->parameters['httpService'];
    }

    /**
     * Generate a new image from a text prompt.
     *
     * @see https://platform.stability.ai/docs/api-reference#tag/v1generation/operation/
     *
     * @param string $engineId
     * @param array $payload
     *
     */
    public function textToImage(string $engineId, array $payload): array
    {
        $response = $this->httpService->sendRequest('POST', "v1/generation/{$engineId}/text-to-image", $this->parameters['headers'], $payload);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Modify an image based on a text prompt.
     *
     * @see https://platform.stability.ai/docs/api-reference#tag/v1generation/operation/imageToImage
     *
     * @param string $engineId
     * @param array $payload
     *
     */
    public function imageToImage(string $engineId, array $payload): array
    {
        $multipartPayload = [
            [
                'name' => 'init_image',
                'contents' => fopen($payload['init_image'], 'r'),
            ],
        ];

        unset($payload['init_image']);

        foreach ($payload as $key => $value) {
            if ($key === 'text_prompts') {
                foreach ($value as $key => $textPrompt) {
                    $multipartPayload[] = [
                        'name' => "text_prompts[$key][text]",
                        'contents' => $textPrompt['text'],
                    ];

                    if (isset($textPrompt['weight'])) {
                        $multipartPayload[] = [
                            'name' => "text_prompts[$key][weight]",
                            'contents' => $textPrompt['weight'],
                        ];
                    }
                }
            } else {
                $multipartPayload[] = [
                    'name' => "$key",
                    'contents' => $value,
                ];
            }
        }

        $response = $this->httpService->sendRequest('POST', "v1/generation/{$engineId}/image-to-image", $this->parameters['headers'], $multipartPayload, 'multipart');

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Create a higher resolution version of an input image.
     *
     * @see https://platform.stability.ai/docs/api-reference#tag/v1generation/operation/upscaleImage
     *
     * @param string $engineId
     * @param array $payload
     *
     */
    public function imageToImageUpscale(string $engineId, array $payload): array
    {
        $multipartPayload = [
            [
                'name' => 'image',
                'contents' => fopen($payload['image'], 'r'),
            ],
        ];

        unset($payload['image']);

        foreach ($payload as $key => $value) {
            if ($key === 'text_prompts') {
                foreach ($value as $key => $textPrompt) {
                    $multipartPayload[] = [
                        'name' => "text_prompts[$key][text]",
                        'contents' => $textPrompt['text'],
                    ];

                    if (isset($textPrompt['weight'])) {
                        $multipartPayload[] = [
                            'name' => "text_prompts[$key][weight]",
                            'contents' => $textPrompt['weight'],
                        ];
                    }
                }
            } else {
                $multipartPayload[] = [
                    'name' => "$key",
                    'contents' => $value,
                ];
            }
        }

        $response = $this->httpService->sendRequest('POST', "v1/generation/{$engineId}/image-to-image/upscale", $this->parameters['headers'], $multipartPayload, 'multipart');

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Selectively modify portions of an image using a mask
     *
     * @see https://platform.stability.ai/docs/api-reference#tag/v1generation/operation/masking
     *
     *
     * @param string $engineId
     * @param array $payload
     *
     */
    public function imageToImageMasking(string $engineId, array $payload): array
    {
        $multipartPayload = [
            [
                'name' => 'init_image',
                'contents' => fopen($payload['init_image'], 'r'),
            ],

        ];

        if ($payload['mask_image']) {
            $multipartPayload[] = [
                'name' => 'mask_image',
                'contents' => fopen($payload['mask_image'], 'r'),
            ];
        }

        unset($payload['init_image'], $payload['mask_image']);

        foreach ($payload as $key => $value) {
            if ($key === 'text_prompts') {
                foreach ($value as $key => $textPrompt) {
                    $multipartPayload[] = [
                        'name' => "text_prompts[$key][text]",
                        'contents' => $textPrompt['text'],
                    ];

                    if (isset($textPrompt['weight'])) {
                        $multipartPayload[] = [
                            'name' => "text_prompts[$key][weight]",
                            'contents' => $textPrompt['weight'],
                        ];
                    }
                }
            } else {
                $multipartPayload[] = [
                    'name' => "$key",
                    'contents' => $value,
                ];
            }
        }

        $response = $this->httpService->sendRequest('POST', "v1/generation/{$engineId}/image-to-image/masking", $this->parameters['headers'], $multipartPayload, 'multipart');

        return json_decode($response->getBody()->getContents(), true);
    }
}
