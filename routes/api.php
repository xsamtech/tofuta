<?php

/**
 * @author Xanders
 * @see https://team.xsamtech.com/xanderssamoth
 */

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Default API Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', 'localization'])->group(function () {
    Route::apiResource('category', 'App\Http\Controllers\API\CategoryController')->except(['search', 'findByGroup', 'allUsedInWorks', 'allUsedInWorksType']);
    Route::apiResource('file', 'App\Http\Controllers\API\FileController');
    Route::apiResource('cart', 'App\Http\Controllers\API\CartController');
    Route::apiResource('partner', 'App\Http\Controllers\API\PartnerController');
    Route::apiResource('activation_code', 'App\Http\Controllers\API\ActivationCodeController');
    Route::apiResource('role', 'App\Http\Controllers\API\RoleController')->except(['search']);
    Route::apiResource('user', 'App\Http\Controllers\API\UserController')->except(['store', 'show', 'login']);
    Route::apiResource('password_reset', 'App\Http\Controllers\API\PasswordResetController')->except(['searchByEmailOrPhone', 'searchByEmail', 'searchByPhone', 'checkToken']);
    Route::apiResource('personal_access_token', 'App\Http\Controllers\API\PersonalAccessTokenController');
    Route::apiResource('message', 'App\Http\Controllers\API\MessageController');
    Route::apiResource('notification', 'App\Http\Controllers\API\NotificationController');
    Route::apiResource('read_notification', 'App\Http\Controllers\API\ReadNotificationController');
    Route::apiResource('payment', 'App\Http\Controllers\API\PaymentController');
});

/*
|--------------------------------------------------------------------------
| Custom API resource
|--------------------------------------------------------------------------
 */
Route::group(['middleware' => ['api', 'localization']], function () {
    Route::resource('category', 'App\Http\Controllers\API\CategoryController');
    Route::resource('role', 'App\Http\Controllers\API\RoleController');
    Route::resource('user', 'App\Http\Controllers\API\UserController');
    Route::resource('password_reset', 'App\Http\Controllers\API\PasswordResetController');

    // Category
    Route::get('category/search/{locale}/{data}', 'App\Http\Controllers\API\CategoryController@search')->name('category.api.search');
    Route::get('category/find_by_group/{group_name}', 'App\Http\Controllers\API\CategoryController@findByGroup')->name('category.api.find_by_group');
    Route::get('category/all_used_in_works', 'App\Http\Controllers\API\CategoryController@allUsedInWorks')->name('category.api.all_used_in_works');
    Route::get('category/all_used_in_works_type/{type_id}', 'App\Http\Controllers\API\CategoryController@allUsedInWorksType')->name('category.api.all_used_in_works_type');
    // Role
    Route::get('role/search/{data}', 'App\Http\Controllers\API\RoleController@search')->name('role.api.search');
    // User
    Route::post('user', 'App\Http\Controllers\API\UserController@store')->name('user.api.store');
    Route::get('user/{id}', 'App\Http\Controllers\API\UserController@show')->name('user.api.show');
    Route::post('user/login', 'App\Http\Controllers\API\UserController@login')->name('user.api.login');
    // PasswordReset
    Route::get('password_reset/search_by_email_or_phone/{data}', 'App\Http\Controllers\API\PasswordResetController@searchByEmailOrPhone')->name('password_reset.api.search_by_email_or_phone');
    Route::get('password_reset/search_by_email/{data}', 'App\Http\Controllers\API\PasswordResetController@searchByEmail')->name('password_reset.api.search_by_email');
    Route::get('password_reset/search_by_phone/{data}', 'App\Http\Controllers\API\PasswordResetController@searchByPhone')->name('password_reset.api.search_by_phone');
    Route::post('password_reset/check_token/{entity}', 'App\Http\Controllers\API\PasswordResetController@checkToken')->name('password_reset.api.check_token');
});
Route::group(['middleware' => ['auth:sanctum', 'api', 'localization']], function () {
    Route::resource('partner', 'App\Http\Controllers\API\PartnerController');
    Route::resource('activation_code', 'App\Http\Controllers\API\ActivationCodeController');
    Route::resource('cart', 'App\Http\Controllers\API\CartController');
    Route::resource('user', 'App\Http\Controllers\API\UserController')->except(['store', 'show', 'login']);
    Route::resource('message', 'App\Http\Controllers\API\MessageController');
    Route::resource('notification', 'App\Http\Controllers\API\NotificationController');
    Route::resource('read_notification', 'App\Http\Controllers\API\ReadNotificationController');

    // Partner
    Route::get('partner/search/{data}', 'App\Http\Controllers\API\PartnerController@search')->name('partner.api.search');
    Route::get('partner/partnerships_by_status/{locale}/{status_name}', 'App\Http\Controllers\API\PartnerController@partnershipsByStatus')->name('partner.api.partnerships_by_status');
    Route::get('partner/partners_with_activation_code/{locale}/{status_name}', 'App\Http\Controllers\API\PartnerController@partnersWithActivationCode')->name('partner.api.partners_with_activation_code');
    Route::get('partner/users_with_promo_code/{partner_id}', 'App\Http\Controllers\API\PartnerController@usersWithPromoCode')->name('partner.api.users_with_promo_code');
    Route::put('partner/withdraw_some_categories/{partner_id}', 'App\Http\Controllers\API\PartnerController@withdrawSomeCategories')->name('partner.api.withdraw_some_categories');
    Route::put('partner/withdraw_all_categories/{partner_id}', 'App\Http\Controllers\API\PartnerController@withdrawSomeCategories')->name('partner.api.withdraw_all_categories');
    Route::put('partner/terminate_partnership/{partner_id}', 'App\Http\Controllers\API\PartnerController@terminatePartnership')->name('partner.api.terminate_partnership');
    // ActivationCode
    Route::get('activation_code/find_users_by_partner/{partner_id}', 'App\Http\Controllers\API\ActivationCodeController@findUsersByPartner')->name('activation_code.api.find_users_by_partner');
    Route::put('activation_code/activate_subscription/{user_id}/{code}/{partner_id}', 'App\Http\Controllers\API\ActivationCodeController@activateSubscription')->name('activation_code.api.activate_subscription');
    Route::put('activation_code/disable_subscription/{user_id}', 'App\Http\Controllers\API\ActivationCodeController@disableSubscription')->name('activation_code.api.disable_subscription');
    // Cart
    Route::put('cart/remove_from_cart/{cart_id}', 'App\Http\Controllers\API\CartController@removeFromCart')->name('cart.api.remove_from_cart');
    Route::post('cart/add_to_cart/{entity}', 'App\Http\Controllers\API\CartController@addToCart')->name('cart.api.add_to_cart');
    Route::post('cart/purchase/{user_id}', 'App\Http\Controllers\API\CartController@purchase')->name('cart.api.purchase');
    // User
    Route::get('user/find_by_role/{role_name}', 'App\Http\Controllers\API\UserController@findByRole')->name('user.api.find_by_role');
    Route::get('user/find_by_not_role/{role_name}', 'App\Http\Controllers\API\UserController@findByNotRole')->name('user.api.find_by_not_role');
    Route::get('user/works_subscribers/{user_id}', 'App\Http\Controllers\API\UserController@worksSubscribers')->name('user.api.works_subscribers');
    Route::get('user/organization_members/{organization_id}/{role_name}', 'App\Http\Controllers\API\UserController@organizationMembers')->name('user.api.organization_members');
    Route::get('user/group_members/{entity}/{entity_id}', 'App\Http\Controllers\API\UserController@groupMembers')->name('user.api.group_members');
    Route::get('user/member_groups/{entity}/{user_id}/{status_id}', 'App\Http\Controllers\API\UserController@memberGroups')->name('user.api.member_groups');
    Route::get('user/is_main_member/{entity}/{entity_id}/{user_id}', 'App\Http\Controllers\API\UserController@isMainMember')->name('user.api.is_main_member');
    Route::get('user/is_partner/{user_id}', 'App\Http\Controllers\API\UserController@isPartner')->name('user.api.is_partner');
    Route::get('user/find_by_status/{status_id}', 'App\Http\Controllers\API\UserController@findByStatus')->name('user.api.find_by_status');
    Route::put('user/switch_status/{id}/{status_id}', 'App\Http\Controllers\API\UserController@switchStatus')->name('user.api.switch_status');
    Route::put('user/update_role/{action}/{id}', 'App\Http\Controllers\API\UserController@updateRole')->name('user.api.update_role');
    Route::put('user/update_user_membership/{entity}/{entity_id}/{action}/{id}', 'App\Http\Controllers\API\UserController@updateUserMembership')->name('user.api.update_user_membership');
    Route::put('user/update_password/{id}', 'App\Http\Controllers\API\UserController@updatePassword')->name('user.api.update_password');
    Route::put('user/subscribe_to_group/{user_id}/{addressee_id}', 'App\Http\Controllers\API\UserController@subscribeToGroup')->name('user.api.subscribe_to_group');
    Route::put('user/unsubscribe_to_group/{user_id}/{addressee_id}', 'App\Http\Controllers\API\UserController@unsubscribeToGroup')->name('user.api.unsubscribe_to_group');
    Route::put('user/update_avatar_picture/{id}', 'App\Http\Controllers\API\UserController@updateAvatarPicture')->name('user.api.update_avatar_picture');
    Route::post('user/search', 'App\Http\Controllers\API\UserController@search')->name('user.api.search');
    // Message
    Route::get('message/search_in_chat/{locale}/{type_name}/{data}/{sender_id}/{addressee_id}', 'App\Http\Controllers\API\MessageController@searchInChat')->name('message.api.search_in_chat');
    Route::get('message/search_in_group/{entity}/{entity_id}/{member_id}/{data}', 'App\Http\Controllers\API\MessageController@searchInGroup')->name('message.api.search_in_group');
    Route::get('message/find_by_group/{entity}/{entity_id}', 'App\Http\Controllers\API\MessageController@findByGroup')->name('message.api.find_by_group');
    Route::get('message/user_chats_list/{locale}/{type_name}/{user_id}', 'App\Http\Controllers\API\MessageController@userChatsList')->name('message.api.user_chats_list');
    Route::get('message/selected_chat/{locale}/{type_name}/{user_id}/{entity}/{entity_id}', 'App\Http\Controllers\API\MessageController@selectedChat')->name('message.api.selected_chat');
    Route::get('message/members_with_message_status/{locale}/{status_name}/{message_id}', 'App\Http\Controllers\API\MessageController@membersWithMessageStatus')->name('message.api.members_with_message_status');
    Route::put('message/switch_like/{message_id}/{user_id}', 'App\Http\Controllers\API\MessageController@switchLike')->name('message.api.switch_like');
    Route::put('message/switch_report/{message_id}/{user_id}', 'App\Http\Controllers\API\MessageController@switchReport')->name('message.api.switch_report');
    Route::put('message/delete_for_myself/{user_id}/{message_id}', 'App\Http\Controllers\API\MessageController@deleteForMyself')->name('message.api.delete_for_myself');
    Route::put('message/delete_for_everybody/{message_id}', 'App\Http\Controllers\API\MessageController@deleteForEverybody')->name('message.api.delete_for_everybody');
    Route::put('message/mark_all_read_user/{locale}/{type_name}/{sender_id}/{addressee_user_id}', 'App\Http\Controllers\API\MessageController@markAllReadUser')->name('message.api.mark_all_read_user');
    Route::put('message/mark_all_read_group/{user_id}/{entity}/{entity_id}', 'App\Http\Controllers\API\MessageController@markAllReadGroup')->name('message.api.mark_all_read_group');
    // Notification
    Route::get('notification/select_by_user/{user_id}', 'App\Http\Controllers\API\NotificationController@selectByUser')->name('notification.api.select_by_user');
    Route::get('notification/select_by_status_user/{status_id}/{user_id}', 'App\Http\Controllers\API\NotificationController@selectByStatusUser')->name('notification.api.select_by_status_user');
    Route::put('notification/switch_status/{ids}/{status_id}', 'App\Http\Controllers\API\NotificationController@switchStatus')->name('notification.api.switch_status');
    Route::put('notification/mark_all_read/{user_id}', 'App\Http\Controllers\API\NotificationController@markAllRead')->name('notification.api.mark_all_read');
    // ReadNotification
    Route::get('read_notification/select_by_user/{user_id}', 'App\Http\Controllers\API\ReadNotificationController@selectByUser')->name('read_notification.api.select_by_user');
});
