<?php

declare(strict_types=1);

use Beacon\PennantDriver\BeaconDriver;
use Illuminate\Support\Facades\Http;
use Tests\Fixtures\CustomScope;

it('sets for all scopes', function () {
    $api = app()->make(BeaconDriver::class, [
        'client' => Http::createPendingRequest(),
        'featureStateResolvers' => [],
    ]);

    $api->set('test', new CustomScope(['email' => 'davey@php.net']), true);
    $api->set('test', new CustomScope(['email' => 'taylor@laravel.com']), true);

    $api->setForAllScopes('test', false);

    expect($this->prop($api, 'resolvedFeatureStates'))
        ->toBe(['test' => [
            '{"email":"davey@php.net"}' => false,
            '{"email":"taylor@laravel.com"}' => false,
        ]]);
});
