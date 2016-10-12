<?php

namespace Nester\QrCode\Renderer;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Class GoogleChartsRenderer
 *
 * Renderer for QR code which will use Google Chart Service.
 *
 * @package Nester\QrCode\Renderer
 */
class GoogleChartsRenderer implements RendererInterface
{

    const ENDPOINT = 'https://chart.googleapis.com/chart';

    /**
     * HTTP client to create HTTP requests.
     *
     * @var Client
     */
    private $http;

    /**
     * GoogleChartsRenderer constructor.
     * @param Client $http
     */
    public function __construct(Client $http)
    {
        $this->http = $http;
    }

    /**
     * @inheritdoc
     */
    public function render($text, $width, $height)
    {
        try {
            $response = $this->http->get(static::ENDPOINT . '?cht=qr&chs='.$width.'x'.$height.'&chl='.$text );
        } catch (RequestException $e) {
            return null;
        }

        return [
            'data' => $response->getBody()->getContents(),
            'type' => $response->getHeaderLine('Content-Type')
        ];
    }
}
