<?php

require __DIR__.'/vendor/autoload.php';

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Facade;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Client\Factory;

// Mock enough of Laravel to use Http facade standalone
$container = new Container();
$container->instance('events', new Dispatcher());
$container->instance('config', collect([]));
$container->instance('http', new Factory(new Dispatcher($container)));
Facade::setFacadeApplication($container);

$url = 'https://api.animu.com.br/';

$response = Http::withHeaders([
    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
])->get($url);

echo "Status: " . $response->status() . "\n";
echo "Body: " . $response->body() . "\n";
if ($response->successful()) {
    $data = $response->json();
    echo "Parsed Listeners: " . ($data['listeners'] ?? 'NOT FOUND') . "\n";
} else {
    echo "Request Failed\n";
}
