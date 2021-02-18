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
Route::group(['middleware' => ['auth:web']], function () {
    Route::get('rate/{order_id}/{user_id}', ['uses' => 'OrderController@getRate']);
    Route::post('rate/{order_id}/{user_id}', ['uses' => 'OrderController@postRate']);
    Route::get('orders', ['uses' => 'OrderController@index']);
    Route::post('order', ['uses' => 'OrderController@store']);
    Route::get('orderComplate', ['uses' => 'OrderController@AddPayOrder']);
    Route::get('null', ['uses' => 'OrderController@AddPayOrder']);

    Route::get('orders/{id}', ['uses' => 'OrderController@show']);
    Route::get('orders/invoice/{id}', ['uses' => 'OrderController@showInvoice']);
    Route::get('favorite/{id}', ['as' => 'favorite.add', 'uses' => 'FavoriteController@addFav']);
    Route::get('unfavorite/{id}', ['as' => 'favorite.add', 'uses' => 'FavoriteController@getUnFav']);
    Route::get('favorites', ['as' => 'favorite.index', 'uses' => 'FavoriteController@getIndex']);

    Route::get('cart', ['as' => 'cart.view', 'uses' => 'CartController@getIndex']);
    Route::post('cart/pay', ['as' => 'cart.pay', 'uses' => 'CartController@postPay']);
    Route::post('cart/shipping', ['as' => 'cart.shipping', 'uses' => 'CartController@postShipping']);
    Route::post('city', ['as' => 'cart.shipping', 'uses' => 'CartController@postShippingCity']);
    Route::get('cart/pdf', ['as' => 'product.pdf', 'uses' => 'CartController@getPdf']);
    Route::post('cart/{id}', ['as' => 'cart.add', 'uses' => 'CartController@postAdd']);

    Route::post('urgent', ['as' => 'cart.urgent', 'uses' => 'CartController@urgent']);
    Route::get('cart/remove', ['as' => 'cart.remove', 'uses' => 'CartController@remove']);
    Route::get('coupone-add/{id}', ['as' => 'coupone-add', 'uses' => 'CouponsController@CheckCoupon']);
    Route::get('coupone-remove', ['as' => 'coupone-remove', 'uses' => 'CouponsController@RemoveCoupon']);


    Route::get('profile', ['as' => 'profile', 'uses' => 'UsersController@showProfile']);
    Route::post('profile', ['uses' => 'UsersController@postProfile']);
    Route::post('shopping', ['uses' => 'UsersController@postShopping']);

    Route::get('special', ['as' => 'special', 'uses' => 'UsersController@getSpecial']);
    Route::post('special', ['uses' => 'UsersController@postSpecial']);
    Route::get('logout', ['as' => 'frontend.login.logout', 'uses' => 'UsersController@doLogout']);
});
Route::group(['middleware' => ['web']], function () {
    Route::post('saveOrder', ['as' => 'cart.saveOrder', 'uses' => 'OrderController@SavePayOrder']);

    Route::get('/', ['as' => 'homepage.view', 'uses' => 'HomepageController@getIndex']);
    //------------ pages-----------------
    Route::get('page/{id}/{title}', ['as' => 'page.view', 'uses' => 'PageController@getPage']);
    Route::get('about', ['as' => 'page.view', 'uses' => 'PageController@getPage']);
    Route::get('privacy-policy', ['as' => 'page.view', 'uses' => 'PageController@getPage']);
    Route::get('term-condtion', ['as' => 'page.view', 'uses' => 'PageController@getPage']);
    Route::get('return', ['as' => 'page.view', 'uses' => 'PageController@getPage']);
    Route::get('blogs', ['as' => 'news.category', 'uses' => 'NewsController@getIndex']);
    Route::get('blogs/{id}', ['as' => 'news.details', 'uses' => 'NewsController@getNews']);

    //--------------------------------- Start products section--------------------//

    Route::get('product/{id}', ['as' => 'product.view', 'uses' => 'ProductsController@getIndex']);
    Route::get('category/{id}', ['as' => 'categories.view', 'uses' => 'CategoriesController@getIndex']);
    Route::get('offers', ['as' => 'categories.offers', 'uses' => 'CategoriesController@getOffers']);
    Route::get('subcategory/{id}', ['as' => 'subcategories.view', 'uses' => 'CategoriesController@getsubcategoryIndex']);
    Route::post('search', ['as' => 'product.view', 'uses' => 'CategoriesController@getSearchIndex']);
    Route::get('contact', ['as' => 'contact.view', 'uses' => 'ContactController@getIndex']);
    Route::post('contact', ['as' => 'contact.view', 'uses' => 'ContactController@postContact']);
    //--------------------------------- End products section--------------------//
    //Route::get('signup', ['as' => 'frontend.signup.view', 'uses' => 'UsersController@getIndex']);
    Route::post('signup', ['as' => 'frontend.signup.view', 'uses' => 'UsersController@postSignIndex']);
    Route::get('signup/verification/{username}', ['as' => 'frontend.signup.verification', 'uses' => 'UsersController@getVerification']);
    Route::post('signup/code/send', ['as' => 'frontend.signup.code.send', 'uses' => 'UsersController@postSendVerificationCode']);
    Route::post('signup/verification', ['as' => 'frontend.signup.verification', 'uses' => 'UsersController@postVerification']);
    Route::get('redirect', 'SocialAuthGoogleController@redirect');
    Route::get('callback', 'SocialAuthGoogleController@callback');
    //////////////////////////////////////
    Route::get('login', ['as' => 'frontend.login.view', 'uses' => 'UsersController@getIndex']);
    Route::post('login', ['as' => 'frontend.login.view', 'uses' => 'UsersController@doLogin']);
    Route::get('login/forgotPassword', ['as' => 'frontend.login.forgotPassword', 'uses' => 'UsersController@getForgotPassword']);
    Route::post('login/forgotPassword', ['as' => 'frontend.login.forgotPassword', 'uses' => 'UsersController@postForgotPassword']);
    Route::get('login/resetPassword/{email}/{token}', ['as' => 'frontend.login.reset.password', 'uses' => 'UsersController@getResetPassword']);
    Route::post('login/resetPassword/{email}/{token}', ['as' => 'frontend.login.resetPassword', 'uses' => 'UsersController@postResetPassword']);
    Route::get('user/verify/{token}', 'UsersController@verifyUser');
    Route::get('mail/{type}/{id}', ['uses' => 'UsersController@send_mail']);
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////
// route to open admin page
Route::get('/admin', function () {
    return redirect('admin/dashboard');
});
// Login Route
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['web', 'guest:admin']], function () {
    Route::get('login', ['as' => 'app.login', 'uses' => 'LoginController@getIndex']);
    Route::post('login', ['as' => 'app.login', 'uses' => 'LoginController@postIndex']);
});
Route::group(['prefix' => 'filemanager', 'middleware' => ['web', 'auth:admin']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});


Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['web', 'auth:admin']], function () {

    // Route
    Route::get('dashboard', ['as' => 'dashboard.view', 'uses' => 'DashboardController@getIndex']);
    Route::get('profile', ['as' => 'dashboard.profile', 'uses' => 'DashboardController@getProfile']);
    //   Route::get('password', ['as' => 'dashboard.password', 'uses' => 'DashboardController@getPassword']);
    Route::post('password', ['as' => 'dashboard.password', 'uses' => 'DashboardController@postPassword']);

    //Users Route
    Route::get('users', ['as' => 'users.view', 'middleware' => ['permission:admin.users.view|admin.users.add|admin.users.edit|admin.users.delete|admin.users.status|admin.users.password'], 'uses' => 'UsersController@getIndex']);
    Route::get('users/list', ['as' => 'users.list', 'middleware' => ['permission:admin.users.view|admin.users.add|admin.users.edit|admin.users.delete|admin.users.status|admin.users.password'], 'uses' => 'UsersController@getList']);
    Route::get('users/add', ['as' => 'users.add', 'middleware' => ['permission:admin.users.add'], 'uses' => 'UsersController@getAdd']);
    Route::post('users/add', ['as' => 'users.add', 'middleware' => ['permission:admin.users.add'], 'uses' => 'UsersController@postAdd']);
    Route::get('users/edit/{id}', ['as' => 'users.edit', 'middleware' => ['permission:admin.users.edit'], 'uses' => 'UsersController@getEdit']);
    Route::post('users/edit/{id}', ['as' => 'users.edit', 'middleware' => ['permission:admin.users.edit'], 'uses' => 'UsersController@postEdit']);
      Route::get('users/password/{id}', ['as' => 'users.password', 'middleware' => ['permission:admin.users.password'], 'uses' => 'UsersController@getPassword']);
    Route::post('users/password/{id}', ['as' => 'users.password', 'middleware' => ['permission:admin.users.password'], 'uses' => 'UsersController@postPassword']);
    Route::post('users/delete', ['as' => 'users.delete', 'middleware' => ['permission:admin.users.delete'], 'uses' => 'UsersController@postDelete']);
    Route::post('users/status', ['as' => 'users.status', 'middleware' => ['permission:admin.users.status'], 'uses' => 'UsersController@postStatus']);
    Route::post('users/avatar', ['as' => 'users.avatar', 'middleware' => ['permission:admin.users.avatar'], 'uses' => 'UsersController@postAvatar']);

    //Roles Route
    Route::get('roles', ['as' => 'roles.view', 'middleware' => ['permission:admin.roles.view|admin.roles.add|admin.roles.edit|admin.roles.delete|admin.roles.status|admin.roles.permissions'], 'uses' => 'RolesController@getIndex']);
    Route::get('roles/list', ['as' => 'roles.list', 'middleware' => ['permission:admin.roles.view|admin.roles.add|admin.roles.edit|admin.roles.delete|admin.roles.status|admin.roles.permissions'], 'uses' => 'RolesController@getList']);
    Route::get('roles/add', ['as' => 'roles.add', 'middleware' => ['permission:admin.roles.add'], 'uses' => 'RolesController@getAdd']);
    Route::post('roles/add', ['as' => 'roles.add', 'middleware' => ['permission:admin.roles.add'], 'uses' => 'RolesController@postAdd']);
    Route::get('roles/edit/{id}', ['as' => 'roles.edit', 'middleware' => ['permission:admin.roles.edit'], 'uses' => 'RolesController@getEdit']);
    Route::post('roles/edit/{id}', ['as' => 'roles.edit', 'middleware' => ['permission:admin.roles.edit'], 'uses' => 'RolesController@postEdit']);
    Route::post('roles/delete', ['as' => 'roles.delete', 'middleware' => ['permission:admin.roles.delete'], 'uses' => 'RolesController@postDelete']);
    Route::post('roles/status', ['as' => 'roles.status', 'middleware' => ['permission:admin.roles.status'], 'uses' => 'RolesController@postStatus']);
    Route::get('roles/permissions/{id}', ['as' => 'roles.permissions', 'middleware' => ['permission:admin.roles.permissions'], 'uses' => 'RolesController@getPermissions']);
    Route::post('roles/permissions/{id}', ['as' => 'roles.permissions', 'middleware' => ['permission:admin.roles.permissions'], 'uses' => 'RolesController@postPermissions']);

    //Static Page Route
    Route::get('pages', ['as' => 'pages.view', 'uses' => 'PagesController@getIndex']);
    Route::get('pages/list', ['as' => 'pages.list', 'uses' => 'PagesController@getList']);
    Route::get('pages/edit/{id}', ['as' => 'pages.edit', 'uses' => 'PagesController@getEdit']);
    Route::post('pages/edit/{id}', ['as' => 'pages.edit', 'uses' => 'PagesController@postEdit']);
    Route::post('pages/status', ['as' => 'pages.status', 'uses' => 'PagesController@postStatus']);

    //News Route
    Route::get('news', ['as' => 'news.view', 'middleware' => ['permission:admin.news.view|admin.news.add|admin.news.edit|admin.news.delete|admin.news.status'], 'uses' => 'NewsController@getIndex']);
    Route::get('news/list', ['as' => 'news.list', 'middleware' => ['permission:admin.news.view|admin.news.add|admin.news.edit|admin.news.delete|admin.news.status'], 'uses' => 'NewsController@getList']);
    Route::get('news/add', ['as' => 'news.add', 'middleware' => ['permission:admin.news.add'], 'uses' => 'NewsController@getAdd']);
    Route::post('news/add', ['as' => 'news.add', 'middleware' => ['permission:admin.news.add'], 'uses' => 'NewsController@postAdd']);
    Route::get('news/edit/{id}', ['as' => 'news.edit', 'middleware' => ['permission:admin.news.edit'], 'uses' => 'NewsController@getEdit']);
    Route::post('news/edit/{id}', ['as' => 'news.edit', 'middleware' => ['permission:admin.news.edit'], 'uses' => 'NewsController@postEdit']);
    Route::post('news/delete', ['as' => 'news.delete', 'middleware' => ['permission:admin.news.delete'], 'uses' => 'NewsController@postDelete']);
    Route::post('news/publish', ['as' => 'news.publish', 'middleware' => ['permission:admin.news.publish'], 'uses' => 'NewsController@postPublish']);
    Route::post('news/sidebar', ['as' => 'news.sidebar', 'middleware' => ['permission:admin.news.publish'], 'uses' => 'NewsController@postSidebar']);
    Route::get('news/cleaAllCache', ['as' => 'news.cleaAllCache', 'middleware' => ['permission:admin.news.publish'], 'uses' => 'NewsController@cleaAllCache']);
    Route::post('upload_image', ['as' => 'news.upload', 'uses' => 'NewsController@getImage']);

//Contacts Route
    Route::get('contacts', ['as' => 'contacts.view', 'middleware' => ['permission:admin.contact.view|admin.contact.delete|admin.contact.status|admin.contact.reply'], 'uses' => 'ContactsController@getIndex']);
    Route::get('contacts/list', ['as' => 'contacts.list', 'middleware' => ['permission:admin.contact.view|admin.contact.delete|admin.contact.status|admin.contact.reply'], 'uses' => 'ContactsController@getList']);
    Route::get('contacts/reply/{id}', ['as' => 'contacts.reply', 'middleware' => ['permission:admin.contact.reply'], 'uses' => 'ContactsController@getReply']);
    Route::post('contacts/delete', ['as' => 'contacts.delete', 'middleware' => ['permission:admin.contact.delete'], 'uses' => 'ContactsController@postDelete']);
    Route::post('contacts/status', ['as' => 'contacts.status', 'middleware' => ['permission:admin.contact.status'], 'uses' => 'ContactsController@postStatus']);

    //Social Route
    Route::get('socials', ['as' => 'socials.view', 'middleware' => ['permission:admin.social.view'], 'uses' => 'SocialsController@getIndex']);
    Route::post('socials', ['as' => 'socials.list', 'middleware' => ['permission:admin.social.view'], 'uses' => 'SocialsController@postIndex']);

    //Settings Route
    Route::get('settings', ['as' => 'settings.view', 'middleware' => ['permission:admin.settings.view'], 'uses' => 'SettingsController@getIndex']);
    Route::post('settings', ['as' => 'settings.list', 'middleware' => ['permission:admin.settings.view'], 'uses' => 'SettingsController@postIndex']);

    //Categories Route
    Route::get('categories', ['as' => 'categories.view', 'middleware' => ['permission:admin.categories.view|admin.categories.add|admin.categories.edit|admin.categories.delete|admin.categories.status'], 'uses' => 'CategoriesController@getIndex']);
    Route::get('categories/list', ['as' => 'categories.list', 'middleware' => ['permission:admin.categories.view|admin.categories.add|admin.categories.edit|admin.categories.delete|admin.categories.status'], 'uses' => 'CategoriesController@getList']);
    Route::get('categories/add', ['as' => 'categories.add', 'middleware' => ['permission:admin.categories.add'], 'uses' => 'CategoriesController@getAdd']);
    Route::post('categories/add', ['as' => 'categories.add', 'middleware' => ['permission:admin.categories.add'], 'uses' => 'CategoriesController@postAdd']);
    Route::get('categories/edit/{id}', ['as' => 'categories.edit', 'middleware' => ['permission:admin.categories.edit'], 'uses' => 'CategoriesController@getEdit']);
    Route::post('categories/edit/{id}', ['as' => 'categories.edit', 'middleware' => ['permission:admin.categories.edit'], 'uses' => 'CategoriesController@postEdit']);
    Route::post('categories/delete', ['as' => 'categories.delete', 'middleware' => ['permission:admin.categories.delete'], 'uses' => 'CategoriesController@postDelete']);
    Route::post('categories/status', ['as' => 'categories.status', 'middleware' => ['permission:admin.categories.status'], 'uses' => 'CategoriesController@postStatus']);

    //Categories Route
    Route::get('subcategories', ['as' => 'subcategories.view', 'middleware' => ['permission:admin.subcategories.view|admin.subcategories.add|admin.subcategories.edit|admin.subcategories.delete|admin.subcategories.status'], 'uses' => 'SubCategoriesController@getIndex']);
    Route::get('subcategories/list', ['as' => 'subcategories.list', 'middleware' => ['permission:admin.subcategories.view|admin.subcategories.add|admin.subcategories.edit|admin.subcategories.delete|admin.subcategories.status'], 'uses' => 'SubCategoriesController@getList']);
    Route::get('subcategories/add', ['as' => 'subcategories.add', 'middleware' => ['permission:admin.subcategories.add'], 'uses' => 'SubCategoriesController@getAdd']);
    Route::post('subcategories/add', ['as' => 'subcategories.add', 'middleware' => ['permission:admin.subcategories.add'], 'uses' => 'SubCategoriesController@postAdd']);
    Route::get('subcategories/edit/{id}', ['as' => 'subcategories.edit', 'middleware' => ['permission:admin.subcategories.edit'], 'uses' => 'SubCategoriesController@getEdit']);
    Route::post('subcategories/edit/{id}', ['as' => 'subcategories.edit', 'middleware' => ['permission:admin.subcategories.edit'], 'uses' => 'SubCategoriesController@postEdit']);
    Route::post('subcategories/delete', ['as' => 'subcategories.delete', 'middleware' => ['permission:admin.subcategories.delete'], 'uses' => 'SubCategoriesController@postDelete']);
    Route::post('subcategories/status', ['as' => 'subcategories.status', 'middleware' => ['permission:admin.subcategories.status'], 'uses' => 'SubCategoriesController@postStatus']);
    Route::get('subcategories/subcat/{id}', ['as' => 'subcategories.subcat', 'middleware' => ['permission:admin.subcategories.subcat'], 'uses' => 'SubCategoriesController@getPrductSpec']);
    Route::post('subcategories/subcat/{id}', ['as' => 'subcategories.subcat', 'middleware' => ['permission:admin.subcategories.subcat'], 'uses' => 'SubCategoriesController@postPrductSpec']);


    //Comments Route
    Route::get('files', ['as' => 'files.view', 'middleware' => ['permission:admin.files.view|admin.files.add|admin.files.edit|admin.files.delete|admin.files.status'], 'uses' => 'FilesController@getIndex']);
    Route::get('files/list', ['as' => 'files.list', 'middleware' => ['permission:admin.files.view|admin.files.add|admin.files.edit|admin.files.delete|admin.files.status'], 'uses' => 'FilesController@getList']);
    Route::get('files/add', ['as' => 'files.add', 'middleware' => ['permission:admin.files.add'], 'uses' => 'FilesController@getAdd']);
    Route::post('files/add', ['as' => 'files.add', 'middleware' => ['permission:admin.files.add'], 'uses' => 'FilesController@postAdd']);
    Route::get('files/edit/{id}', ['as' => 'files.edit', 'middleware' => ['permission:admin.files.edit'], 'uses' => 'FilesController@getEdit']);
    Route::post('files/edit/{id}', ['as' => 'files.edit', 'middleware' => ['permission:admin.files.edit'], 'uses' => 'FilesController@postEdit']);
    Route::post('files/delete', ['as' => 'files.delete', 'middleware' => ['permission:admin.files.delete'], 'uses' => 'FilesController@postDelete']);
    Route::post('files/status', ['as' => 'files.status', 'middleware' => ['permission:admin.files.status'], 'uses' => 'FilesController@postStatus']);



    //orders Route
    Route::get('orders', ['as' => 'orders.view', 'middleware' => ['permission:admin.orders.view|admin.orders.add|admin.orders.edit|admin.orders.delete|admin.orders.status'], 'uses' => 'OrdersController@getIndex']);
    Route::get('orders/list', ['as' => 'orders.list', 'middleware' => ['permission:admin.orders.view|admin.orders.add|admin.orders.edit|admin.orders.delete|admin.orders.status'], 'uses' => 'OrdersController@getList']);
    Route::get('orders/add', ['as' => 'orders.add', 'middleware' => ['permission:admin.orders.add'], 'uses' => 'OrdersController@getAdd']);
    Route::post('orders/add', ['as' => 'orders.add', 'middleware' => ['permission:admin.orders.add'], 'uses' => 'OrdersController@postAdd']);
    Route::get('orders/invoice/{id}', ['as' => 'orders.invoice', 'middleware' => ['permission:admin.orders.invoice'], 'uses' => 'OrdersController@getInvoice']);
    Route::get('orders/edit/{id}', ['as' => 'orders.edit', 'middleware' => ['permission:admin.orders.edit'], 'uses' => 'OrdersController@getEdit']);
    Route::post('orders/edit/{id}', ['as' => 'orders.edit', 'middleware' => ['permission:admin.orders.edit'], 'uses' => 'OrdersController@postEdit']);
    Route::post('orders/delete', ['as' => 'orders.delete', 'middleware' => ['permission:admin.orders.delete'], 'uses' => 'OrdersController@postDelete']);
    Route::post('orders/status', ['as' => 'orders.status', 'middleware' => ['permission:admin.orders.status'], 'uses' => 'OrdersController@postStatus']);

    //customers Route
    Route::get('customers', ['as' => 'customers.view', 'middleware' => ['permission:admin.customers.view|admin.customers.add|admin.customers.edit|admin.customers.delete|admin.customers.status'], 'uses' => 'CustomersController@getIndex']);
    Route::get('customers/list', ['as' => 'customers.list', 'middleware' => ['permission:admin.customers.view|admin.customers.add|admin.customers.edit|admin.customers.delete|admin.customers.status'], 'uses' => 'CustomersController@getList']);
    //  Route::get('customers/add', ['as' => 'customers.add', 'middleware' => ['permission:admin.customers.add'], 'uses' => 'CustomersController@getAdd']);
    //  Route::post('customers/add', ['as' => 'customers.add', 'middleware' => ['permission:admin.customers.add'], 'uses' => 'CustomersController@postAdd']);
    //  Route::get('customers/invoice/{id}', ['as' => 'customers.invoice', 'middleware' => ['permission:admin.customers.invoice'], 'uses' => 'CustomersController@getInvoice']);
    Route::get('customers/view/{id}', ['as' => 'customers.viewdetails', 'middleware' => ['permission:admin.customers.viewdetails'], 'uses' => 'CustomersController@getEdit']);
    Route::post('customers/view/{id}', ['as' => 'customers.viewdetails', 'middleware' => ['permission:admin.customers.viewdetails'], 'uses' => 'CustomersController@postEdit']);
    //Route::post('customers/delete', ['as' => 'customers.delete', 'middleware' => ['permission:admin.customers.delete'], 'uses' => 'CustomersController@postDelete']);
    //Route::post('customers/status', ['as' => 'customers.status', 'middleware' => ['permission:admin.customers.status'], 'uses' => 'CustomersController@postStatus']);
    //accounts Route
    Route::get('accounts', ['as' => 'accounts.view', 'middleware' => ['permission:admin.accounts.view|admin.accounts.add|admin.accounts.edit|admin.accounts.delete|admin.accounts.status'], 'uses' => 'AccountsController@getIndex']);
    Route::get('accounts/list', ['as' => 'accounts.list', 'middleware' => ['permission:admin.accounts.view|admin.accounts.add|admin.accounts.edit|admin.accounts.delete|admin.customers.status'], 'uses' => 'AccountsController@getList']);
    //stocks Route
    Route::get('stocks', ['as' => 'stocks.view', 'middleware' => ['permission:admin.stocks.view|admin.stocks.edit'], 'uses' => 'StocksController@getIndex']);
    Route::get('stocks/list', ['as' => 'stocks.list', 'middleware' => ['permission:admin.stocks.view|admin.stocks.edit'], 'uses' => 'StocksController@getList']);
    Route::get('stocks/edit/{id}', ['as' => 'stocks.edit', 'middleware' => ['permission:admin.stocks.edit'], 'uses' => 'StocksController@getEdit']);
    Route::post('stocks/edit/{id}', ['as' => 'stocks.edit', 'middleware' => ['permission:admin.stocks.edit'], 'uses' => 'StocksController@postEdit']);

//coupon Route
    Route::get('coupons', ['as' => 'coupons.view', 'middleware' => ['permission:admin.coupons.view|admin.coupons.add|admin.coupons.edit|admin.coupons.delete|admin.coupons.status'], 'uses' => 'CouponsController@getIndex']);
    Route::get('coupons/list', ['as' => 'coupons.list', 'middleware' => ['permission:admin.coupons.view|admin.coupons.add|admin.coupons.edit|admin.coupons.delete|admin.coupons.status'], 'uses' => 'CouponsController@getList']);
    Route::get('coupons/add', ['as' => 'coupons.add', 'middleware' => ['permission:admin.coupons.add'], 'uses' => 'CouponsController@getAdd']);
    Route::post('coupons/add', ['as' => 'coupons.add', 'middleware' => ['permission:admin.coupons.add'], 'uses' => 'CouponsController@postAdd']);
    Route::get('coupons/edit/{id}', ['as' => 'coupons.edit', 'middleware' => ['permission:admin.coupons.edit'], 'uses' => 'CouponsController@getEdit']);
    Route::post('coupons/edit/{id}', ['as' => 'coupons.edit', 'middleware' => ['permission:admin.coupons.edit'], 'uses' => 'CouponsController@postEdit']);
    Route::post('coupons/delete', ['as' => 'coupons.delete', 'middleware' => ['permission:admin.coupons.delete'], 'uses' => 'CouponsController@postDelete']);
    Route::post('coupons/status', ['as' => 'coupons.status', 'middleware' => ['permission:admin.coupons.status'], 'uses' => 'CouponsController@postStatus']);
    Route::get('coupons/uses/{id}', ['as' => 'coupons.uses', 'middleware' => ['permission:admin.coupons.uses'], 'uses' => 'CouponsController@getUses']);
    Route::post('coupons/uses/{id}', ['as' => 'coupons.uses', 'middleware' => ['permission:admin.coupons.uses'], 'uses' => 'CouponsController@postUses']);
    Route::post('select-ajax', ['as' => 'select-ajax', 'uses' => 'CouponsController@selectAjaxCategories']);


    //tasks Route
    Route::get('tasks', ['as' => 'tasks.view', 'middleware' => ['permission:admin.tasks.view|admin.tasks.add|admin.tasks.edit|admin.tasks.delete|admin.tasks.status'], 'uses' => 'TasksController@getIndex']);
    Route::get('tasks/list', ['as' => 'tasks.list', 'middleware' => ['permission:admin.tasks.view|admin.tasks.add|admin.tasks.edit|admin.tasks.delete|admin.tasks.status'], 'uses' => 'TasksController@getList']);
    Route::get('tasks/add', ['as' => 'tasks.add', 'middleware' => ['permission:admin.tasks.add'], 'uses' => 'TasksController@getAdd']);
    Route::post('tasks/add', ['as' => 'tasks.add', 'middleware' => ['permission:admin.tasks.add'], 'uses' => 'TasksController@postAdd']);
    Route::get('tasks/invoice/{id}', ['as' => 'tasks.invoice', 'middleware' => ['permission:admin.tasks.invoice'], 'uses' => 'TasksController@getInvoice']);
    Route::get('tasks/edit/{id}', ['as' => 'tasks.edit', 'middleware' => ['permission:admin.tasks.edit'], 'uses' => 'TasksController@getEdit']);
    Route::post('tasks/edit/{id}', ['as' => 'tasks.edit', 'middleware' => ['permission:admin.tasks.edit'], 'uses' => 'TasksController@postEdit']);
    Route::post('tasks/delete', ['as' => 'tasks.delete', 'middleware' => ['permission:admin.tasks.delete'], 'uses' => 'TasksController@postDelete']);
    Route::post('tasks/status', ['as' => 'tasks.status', 'middleware' => ['permission:admin.tasks.status'], 'uses' => 'TasksController@postStatus']);
    Route::get('tasks/reopen/{id}', ['as' => 'tasks.reopen', 'middleware' => ['permission:admin.tasks.status'], 'uses' => 'TasksController@postReopen']);
    Route::get('tasks/transfer/{id}', ['as' => 'tasks.transfer', 'middleware' => ['permission:admin.tasks.status'], 'uses' => 'TasksController@postTransfer']);

//Sliders

    Route::get('slider', ['as' => 'slider.view', 'uses' => 'SliderController@getIndex']);
    Route::get('slider/list', ['as' => 'slider.list', 'uses' => 'SliderController@getList']);
    Route::get('slider/add', ['as' => 'slider.add' , 'uses' => 'SliderController@getAdd']);
    Route::post('slider/add', ['as' => 'slider.add', 'uses' => 'SliderController@postAdd']);
    Route::get('slider/edit/{id}', ['as' => 'slider.edit', 'uses' => 'SliderController@getEdit']);
    Route::post('slider/edit/{id}', ['as' => 'slider.edit', 'uses' => 'SliderController@postEdit']);
    Route::post('slider/delete', ['as' => 'slider.delete', 'uses' => 'SliderController@postDelete']);


//make a push notification.
    Route::get('push', 'PushController@push')->name('push');
//store a push subscriber.
    Route::post('push', 'PushController@store');
    Route::get('logout', ['as' => 'app.logout', 'uses' => 'LoginController@getLogout']);
});
