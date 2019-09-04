<?php

$app->get('/', 'HomeController:index')->setname('home');
$app->get('/auth/signup', 'AuthController:getSingUp')->setName('auth.signup');
$app->post('/auth/signup', 'AuthController:postSignUp');
