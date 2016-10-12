<?php

namespace Tests\QrCode\Renderer;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use Nester\QrCode\Renderer\GoogleChartsRenderer;

class GoogleChartsRendererTest extends \PHPUnit_Framework_TestCase
{
    public function testRender()
    {
        $text = 'Test';
        $width = 50;
        $height = 50;

        $content = 'image Content';
        $type = 'image/png';

        $mock = new MockHandler([
            new Response(200, ['Content-Type' => $type], $content),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $googleChartsRenderer = new GoogleChartsRenderer($client);
        $imageData = $googleChartsRenderer->render($text, $width, $height);

        static::assertEquals(['data' => $content, 'type' => $type], $imageData);
    }

    public function testRenderIfError()
    {
        $text = 'Test';
        $width = 50;
        $height = 50;


        $mock = new MockHandler([
            new Response(500),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $googleChartsRenderer = new GoogleChartsRenderer($client);
        $imageData = $googleChartsRenderer->render($text, $width, $height);

        static::assertNull($imageData);
    }
}
