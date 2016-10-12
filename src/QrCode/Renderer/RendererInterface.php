<?php

namespace Nester\QrCode\Renderer;

/**
 * Interface RendererInterface
 *
 * Interface representing QR code renderer.
 *
 * @package Nester\QrCode\Renderer
 */
interface RendererInterface
{
    /**
     * Performs actual QR code rendering.
     *
     * @param string $text
     * @param int $width
     * @param int $height
     * @return array Array with image data and image type.
     */
    public function render($text, $width, $height);
}
