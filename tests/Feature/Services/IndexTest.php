<?php

declare(strict_types=1);

use App\Http\Controllers\Services\IndexController;
use App\Models\Service;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

test('an unauthorized users gets the correct status code', function (){
    getJson(
        uri: action(IndexController::class)
    )->assertStatus( Response::HTTP_INTERNAL_SERVER_ERROR);
});
test('an authorized users gets the correct status code', function (){
    actingAs(User::factory()->create())->getJson(
        uri: action(IndexController::class),
    )->assertStatus(Response::HTTP_OK);
});


test('an authorized user can only see their own services', function (){
    $user = User::factory()->create();
    Service::factory()->for($user)->count(2)->create();
    Service::factory()->count(10)->create();

    expect(Service::query()->count())->toEqual(12);

    actingAs($user)->getJson(
        uri: action(IndexController::class)
    )->assertStatus(Response::HTTP_OK)->assertJson(
        fn(AssertableJson $json) => $json->count(key: 'data', length: 2)->etc()
    );
});


test('the response comes in a standard format', function () {

    $user = User::factory()->create();
    Service::factory()->for($user)->count(2)->create();

    actingAs($user)->getJson(
        uri: action(IndexController::class)
    )->assertStatus(Response::HTTP_OK)->assertJsonStructure([
        'data',
        'links',
        'meta'
    ]);
});


//test('the response can be paginated', function () {
//
//    $user = User::factory()->create();
//    Service::factory()->for($user)->count(2)->create();
//
//    actingAs($user)->getJson(
//        uri: action(IndexController::class)
//    )->assertStatus(Response::HTTP_OK)->assertJson(
//        fn(AssertableJson $json) => $json
//    );
//
//});


todo('a user can include additional relationships');
todo('a user can filter their request to get specific data');
todo('a user can sort the results to the order they require');
