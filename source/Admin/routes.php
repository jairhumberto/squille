<?php
// Routing per module.
return array(
    '/auth' => 'Admin\Controller\AuthController',
    '/categories' => 'Admin\Controller\CategoriesController',
    '/contents' => 'Admin\Controller\ContentsController',
    '/' => 'Admin\Controller\IndexController',
    '/links' => 'Admin\Controller\LinksController',
    '/menus' => 'Admin\Controller\MenusController',
    '/pages-categories' => 'Admin\Controller\PagesCategoriesController',
    '/pages-contents' => 'Admin\Controller\PagesContentsController',
    '/pages' => 'Admin\Controller\PagesController',
    '/pages-menus' => 'Admin\Controller\PagesMenusController',
    '/files' => 'Admin\Controller\FilesController',
    '/administrators' => 'Admin\Controller\AdministratorsController'
);
