<?php

use MVC\Router;

use MVC\Controllers\BookController;
use MVC\Controllers\CartController;
use MVC\Controllers\CommentController;
use MVC\Controllers\UserController;
use MVC\ControllerS\RatingController;
use MVC\ControllerS\CodesaleController;
use MVC\ControllerS\BranchController;
use MVC\Controllers\GalleryImageController;
use MVC\ControllerS\TransactionController;
use MVC\ControllerS\CategoryController;
use MVC\ControllerS\ImportController;
use MVC\ControllerS\RouteController;



$router = new Router();

//PAGE OF USER ROUTES
$router->addRoute('/', BookController::class, 'home');
$router->addRoute('/category', BookController::class, 'category');
$router->addRoute('/filter', BookController::class, 'filter');
$router->addRoute('/view_cart', CartController::class, 'viewCart');
$router->addRoute('/check_out', CartController::class, 'checkOut');
$router->addRoute('/login', UserController::class, 'login');
$router->addRoute('/logout', UserController::class, 'logout');
$router->addRoute('/detail_product', BookController::class, 'detailProduct');
$router->addRoute('/profile', UserController::class, 'profile');
$router->addRoute('/codesale', CodesaleController::class, 'codesale');
$router->addRoute('/store_system', BranchController::class, 'branch');
$router->addRoute('/history', TransactionController::class, 'history');
$router->addRoute('/detail_transaction', TransactionController::class, 'detailTransaction');
$router->addRoute('/forgotPassword', UserController::class, 'forgotPassword');
$router->addRoute('/resetPassword', UserController::class, 'resetPassword');
$router->addRoute('/register', UserController::class, 'registerPage');




//PAGE OF MANAGEMENT ROUTES
$router->addRoute('/management/product', BookController::class, 'productManagement');
$router->addRoute('/management/pageAddProduct', BookController::class, 'pageAddProduct');
$router->addRoute('/management/pageEditProduct', BookController::class, 'pageEditProduct');
$router->addRoute('/management/galleryImage', GalleryImageController::class, 'galleryImage');
$router->addRoute('/management/hotItem', BookController::class, 'hotItem');
$router->addRoute('/management/category', CategoryController::class, 'categoryManagment');
$router->addRoute('/management/pageAddCategory', CategoryController::class, 'pageAddCategory');
$router->addRoute('/management/pageEditCategory', CategoryController::class, 'pageEditCategory');
$router->addRoute('/management/detailCategory', CategoryController::class, 'productOfCategoryManagement');
$router->addRoute('/management/codesale', CodesaleController::class, 'codesaleManagement');
$router->addRoute('/management/pageAddCodesale', CodesaleController::class, 'pageAddCodesale');
$router->addRoute('/management/pageEditCodesale', CodesaleController::class, 'pageEditCodesale');
$router->addRoute('/management/storeSystem', BranchController::class, 'branchManagement');
$router->addRoute('/management/pageAddBranch', BranchController::class, 'pageAddBranch');
$router->addRoute('/management/pageEditBranch', BranchController::class, 'pageEditBranch');
$router->addRoute('/management/detailBranch', BranchController::class, 'detailBranch');
$router->addRoute('/management/user', UserController::class, 'userManagement');
$router->addRoute('/management/transactionUser', TransactionController::class, 'transactionOfUserManagement');
$router->addRoute('/management/detailTransaction', TransactionController::class, 'detailTransactionOfUserManagement');
$router->addRoute('/management/revenue', TransactionController::class, 'revnenueManagement');
$router->addRoute('/management/inventory', ImportController::class, 'inventoryManagement');
$router->addRoute('/management/detailInventory', ImportController::class, 'detailInventoryManagement');
$router->addRoute('/management/transport', TransactionController::class, 'transportManangement');
$router->addRoute('/management/detailTransport', TransactionController::class, 'detailTransportManagement');




//CART ROUTES
$router->addRoute('/cart/addtocart', CartController::class, 'inCart');
$router->addRoute('/cart/saveCart', CartController::class, 'saveCart');
$router->addRoute('/cart/deleteCart', CartController::class, 'deleteCart');
$router->addRoute('/cart/clearCart', CartController::class, 'clearCart');
$router->addRoute('/cart/applyCoupon', CartController::class, 'applyCoupon');
$router->addRoute('/cart/confirmCheckOut', CartController::class, 'confirmCheckOut');

//COMMENT ROUTES
$router->addRoute('/comment/addComment', CommentController::class, 'comment');
$router->addRoute('/comment/replyComment', CommentController::class, 'replyComment');


//RATING ROUTES 
$router->addRoute('/rating/addRating', RatingController::class, 'rating');


//BOOK ROUTES
$router->addRoute('/book/getInfinity', BookController::class, 'getMoreInfinityData');


//USER ROUTES
$router->addRoute('/user/editProfile', UserController::class, 'editProfile');
$router->addRoute('/user/changePassword', UserController::class, 'changePassword');
$router->addRoute('/user/uploadImage', UserController::class, 'uploadImage');
$router->addRoute('/user/activateUser', UserController::class, 'activateUser');
$router->addRoute('/user/sendMail', UserController::class, 'sendEmailForResetPassword');
$router->addRoute('/user/register', UserController::class, 'register');



//BOOK ROUTES
$router->addRoute('/product/addProduct', BookController::class, 'addProduct');
$router->addRoute('/product/editProduct', BookController::class, 'editProduct');
$router->addRoute('/product/deleteProduct', BookController::class, 'deleteProduct');
$router->addRoute('/product/addProductByFile', BookController::class, 'addProductByFile');
$router->addRoute('/product/exportListProduct', BookController::class, 'exportListAllOfProduct');
$router->addRoute('/product/exportListHotItems', BookController::class, 'exportListAllOfHotItems');


//CATEGORY ROUTES
$router->addRoute('/category/addCategory', CategoryController::class, 'addCategory');
$router->addRoute('/category/deleteCategory', CategoryController::class, 'deleteCategory');
$router->addRoute('/category/editCategory', CategoryController::class, 'editCategory');
$router->addRoute('/category/addCategoryByFile', CategoryController::class, 'addCategoryByFile');


//BRANCH ROUTES
$router->addRoute('/branch/selectWareHouse', BranchController::class, 'selectWareHouse');
$router->addRoute('/branch/actionStock', BranchController::class, 'actionStock');
$router->addRoute('/branch/addBranch', BranchController::class, 'addBranch');
$router->addRoute('/branch/deleteBranch', BranchController::class, 'deleteBranch');
$router->addRoute('/branch/editBranch', BranchController::class, 'editBranch');


//GALLERY IMAGE ROUTES
$router->addRoute('/gallery/defaultGalleryImage', GalleryImageController::class, 'defaultGalleryImage');
$router->addRoute('/gallery/addGalleryImage', GalleryImageController::class, 'addGalleryImage');
$router->addRoute('/gallery/deleteGalleryImage', GalleryImageController::class, 'deleteGalleryImage');


//CODESALE ROUTES
$router->addRoute('/codesale/activate', CodesaleController::class, 'activateCode');
$router->addRoute('/codesale/addCodesale', CodesaleController::class, 'addNewCodesale');
$router->addRoute('/codesale/editCodesale', CodesaleController::class, 'editCodesale');


//IMPORT ROUTES
$router->addRoute('/import/addInventory', ImportController::class, 'addNewInventory');
$router->addRoute('/import/deleteInventory', ImportController::class, 'deleteInventory');
$router->addRoute('/import/updateQuantity', ImportController::class, 'updateQuantityInventory');
$router->addRoute('/import/confirmImport', ImportController::class, 'confirmImport');
$router->addRoute('/import/importFile', ImportController::class, 'importFile');
$router->addRoute('/import/exportFile', ImportController::class, 'exportFile');

//ROUTE ROUTES
$router->addRoute('/route/updateRoute', RouteController::class,'updateRoute');

return $router;