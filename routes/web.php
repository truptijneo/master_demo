<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    //return view('welcome');
    return view('user.index');
});*/

Route::get('/', 'WelcomeController@index')->name('index');

Auth::routes();

// Admin End
Route::group( [ 'prefix' => 'admin', 'middleware' => 'auth'], function()
{
Route::get('/', 'HomeController@index')->name('adminhome');    
Route::get('/home', 'HomeController@index')->name('adminhome');

Route::get('/roles', 'HomeController@roles')->name('roles');
Route::get('/create-role', 'HomeController@createRole')->name('createRole');
Route::post('/add-role', 'HomeController@addRole')->name('addRole');
Route::get('/edit-role/{id}', 'HomeController@editRole')->name('editRole');
Route::patch('/update-role/{id}', 'HomeController@updateRole')->name('updateRole');
Route::get('/delete-role/{id}', 'HomeController@deleteRole')->name('deleteRole');

Route::get('/users', 'HomeController@users')->name('users');
Route::get('/users-list', 'HomeController@userView')->name('usersList');
Route::get('/edit-user/{id}', 'HomeController@editUser')->name('editUser');
Route::post('/update-user/{id}', 'HomeController@updateUser')->name('updateUser');
Route::get('/delete-user/{id}', 'HomeController@deleteUser')->name('deleteUser');

Route::get('/categories', 'CategoryController@index')->name('categories'); 
Route::get('/create-category', 'CategoryController@createCategory')->name('createCategory');
Route::post('/add-category', 'CategoryController@addCategory')->name('addCategory');
Route::get('/edit-category/{id}', 'CategoryController@editCategory')->name('editCategory');
Route::post('/update-category/{id}', 'CategoryController@updateCategory')->name('updateCategory');
Route::get('/delete-category/{id}', 'CategoryController@deleteCategory')->name('deleteCategory');

Route::get('/products', 'ProductController@index')->name('products'); 
Route::get('/create-product', 'ProductController@createProduct')->name('createProduct');
Route::post('/add-product', 'ProductController@addProduct')->name('addProduct');
Route::get('/edit-product/{id}', 'ProductController@editProduct')->name('editProduct');
Route::post('/update-product/{id}', 'ProductController@updateProduct')->name('updateProduct');
Route::get('/delete-product/{id}', 'ProductController@deleteProduct')->name('deleteProduct');
Route::get('/products-out-of-stock', 'ProductController@productsOutOfStock')->name('productsOutOfStock'); 

Route::post('/import-csv', 'ProductController@importCSV')->name('importCSV');
Route::post('/import-user-csv', 'HomeController@importUserCSV')->name('importUserCSV');
Route::get('/export-users/{type}', 'HomeController@exportUsers');

Route::get('/total-orders', 'OrderController@getAllOrders')->name('getAllOrders');
Route::get('/get-order/{id}', 'OrderController@getOrder')->name('getOrder');
Route::post('/change-order-status', 'OrderController@changeOrderStatus');
Route::get('/delete-order/{id}', 'OrderController@deleteOrder')->name('deleteOrder');

Route::get('/users-report', 'ReportController@usersReport')->name('usersReport');
Route::get('/products-report', 'ReportController@productsReport')->name('productsReport');
Route::get('/total-orders-report', 'ReportController@totalOrdersReport')->name('totalOrdersReport');
Route::get('/todays-orders-report', 'ReportController@todaysOrdersReport')->name('todaysOrdersReport');
Route::get('/pending-orders-report', 'ReportController@pendingOrdersReport')->name('pendingOrdersReport');
Route::get('/dispatched-orders-report', 'ReportController@dispatchedOrdersReport')->name('dispatchedOrdersReport');
Route::get('/inprogress-orders-report', 'ReportController@inprogressOrdersReport')->name('inprogressOrdersReport');
Route::get('/completed-orders-report', 'ReportController@completedOrdersReport')->name('completedOrdersReport');
Route::get('/delivered-orders-report', 'ReportController@deliveredOrdersReport')->name('deliveredOrdersReport');
Route::get('/deleted-orders-report', 'ReportController@deletedOrdersReport')->name('deletedOrdersReport');
});


// User End
Route::group(['prefix' => 'user', 'middleware' => 'auth'], function()
{
// Route::get('/', 'HomeController@userIndex')->name('userhome');
Route::get('/home', 'HomeController@userIndex')->name('userhome');

Route::get('/checkout', 'CartController@checkout')->name('checkout');
Route::post('/place-order', 'OrderController@placeOrder')->name('placeOrder');
Route::get('/thankyou', 'OrderController@thankyou')->name('thankyou');
Route::get('/orders', 'OrderController@orders')->name('orders');
Route::get('/order/{id}', 'OrderController@order')->name('order');
});


Route::get('/show-product/{id}', 'ProductController@showProduct')->name('showProduct');
Route::any('/search', 'WelcomeController@search')->name('search');
Route::get('/cart', 'CartController@index')->name('cart');
Route::post('/store', 'CartController@store')->name('addToCart');
Route::get('/update', 'CartController@update');
Route::get('/remove/{id}', 'CartController@destroy')->name('remove');

Route::get('/send/email', 'OrderController@mail');

