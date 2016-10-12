<?php

namespace Nester\QrCode;
use Nester\QrCode\Renderer\RendererInterface;

/**
 * Class QrCode
 *
 * Basic class to render QR code.
 * Use QR Code renderers to perform rendering.
 *
 * @package Nester\QrCode
 */
class QrCode
{
    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * QrCode constructor.
     * @param RendererInterface $renderer
     */
    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * Renderers QR code and returns QR code image.
     *
     * @param string $text
     * @param int $width
     * @param int $height
     * @return string Base64 encoded image string
     */
    public function generate($text, $width, $height)
    {
        $imageData = $this->renderer->render($text, $width, $height);
        if ($imageData === null) {
            return null;
        }

        return 'data:' . $imageData['type'] . ';base64,' . base64_encode($imageData['data']);
    }
}
