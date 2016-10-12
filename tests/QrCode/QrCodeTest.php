<?php

namespace Tests\QrCode;

use Nester\QrCode\QrCode;
use Nester\QrCode\Renderer\RendererInterface;

class QrCodeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider imageDataProvider
     */
    public function testRender($imageData)
    {
        $text = 'Some Text';
        $width = 50;
        $height = 50;
        $rendererMock = $this->createMock(RendererInterface::class);
        $rendererMock->expects(static::once())
            ->method('render')
            ->with($text, $width, $height)
            ->willReturn($imageData);

        $qrCode = new QrCode($rendererMock);
        $qr = $qrCode->generate($text, $width, $height);

        static::assertEquals('data:' . $imageData['type'] . ';base64,' . base64_encode($imageData['data']), $qr);
    }

    public function testRenderIfError()
    {
        $text = 'Some Text';
        $width = 50;
        $height = 50;
        $rendererMock = $this->createMock(RendererInterface::class);
        $rendererMock->expects(static::once())
            ->method('render')
            ->with($text, $width, $height)
            ->willReturn(null);

        $qrCode = new QrCode($rendererMock);
        $qr = $qrCode->generate($text, $width, $height);

        static::assertNull($qr);
    }

    public function imageDataProvider()
    {
        return [
            [['data' => 'some data', 'type' => 'image/png']],
            [['data' => 'some data2', 'type' => 'image/jpg']]
        ];
    }
}
