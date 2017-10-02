<?php
/**
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Action\HomePageAction::class, 'home');
 * $app->post('/album', App\Action\AlbumCreateAction::class, 'album.create');
 * $app->put('/album/:id', App\Action\AlbumUpdateAction::class, 'album.put');
 * $app->patch('/album/:id', App\Action\AlbumUpdateAction::class, 'album.patch');
 * $app->delete('/album/:id', App\Action\AlbumDeleteAction::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Action\ContactAction::class, ['GET', 'POST', ...], 'contact');
 *
 * Or handling all request methods:
 *
 * $app->route('/contact', App\Action\ContactAction::class)->setName('contact');
 *
 * or:
 *
 * $app->route(
 *     '/contact',
 *     App\Action\ContactAction::class,
 *     Zend\Expressive\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */

/** Страницы */
$app->route('/', App\Action\HomePageAction::class, ['GET'], 'home');
$app->route('/product/:slug', App\Action\HomeProductAction::class, ['GET'], 'product')->setOptions([
    'type' => \Zend\Router\Http\Segment::class,
]);
/** Корзина */
$app->route('/cart', App\Action\CartPageAction::class, ['GET', 'POST'], 'cart');
$app->route('/cart/add/:slug/:quantity', App\Action\CartPageAddAction::class, ['GET', 'POST'], 'cart.add');

/** Заказы */
$app->route('/order', [App\Middleware\SlimFlashMiddleware::class, App\Action\OrderPageAction::class], ['GET', 'POST'], 'order.index');
$app->post('/order/create', [App\Middleware\SlimFlashMiddleware::class, App\Action\OrderCreatePageAction::class], 'order.create');

/** token */
$app->get('/braintree/token', App\Action\BrainTreeAction::class, 'braintree.token');
$app->get('/show-order/:hash', App\Action\ShowOrderAction::class, 'show-order');