<?php

require_once __DIR__ . '/../vendor/autoload.php';
use Symfony\Component\HttpFoundation\Request;
use Nester\QrCode\QrCode;
use Nester\QrCode\Renderer\GoogleChartsRenderer;
use GuzzleHttp\Client;

$loader = new Twig_Loader_Filesystem(__DIR__ . '/../resources/templates');
$twig = new Twig_Environment($loader, array(
    'cache' => __DIR__ . '/../cache'
));

$app = new Silex\Application();
$app['debug'] = true;

$app->get('/', function() use ($twig) {
    $template = $twig->loadTemplate('index.twig');
    return $template->render([]);
});

$app->post('/generate', function(Request $request) use($twig) {
    $qrCode = new QrCode(new GoogleChartsRenderer(new Client()));
    $text = $request->get('text');
    $width = $request->get('width');
    $height = $request->get('height');

    $template = $twig->loadTemplate('qr.twig');

    if (!is_numeric($width) || !is_numeric($height) || empty($text)) {
        return $template->render(['error' => 'Please provide valid text, width and height']);
    }

    $qr = $qrCode->generate($text, $width, $height);
    return $template->render(['qrCode' => $qr, 'width' => $width, 'height' => $height]);
});

$app->run();
