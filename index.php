<?php 
session_start();
require_once("vendor/autoload.php");

use \Slim\Slim;
use \Hcode\Page;
use Hcode\PageAdimin;
use Hcode\Model\User;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {
   
	$page = new Page();

	$page->setTpl("index");

});

$app->get('/admin', function() {
   
	User::verifyLogin();

	$page = new PageAdimin();

	$page->setTpl("index");

});

$app->get('/admin/login', function() {
   
	$page = new PageAdimin([
		"header" => false,
		"footer" => false
	]);

	$page->setTpl("login");

});

$app->post('/admin/login', function(){
	User::login($_POST["login"], $_POST["password"]);

	header("Location: /admin");
	exit;
});

$app->get('/admin/logout', function(){
	User::logout();

	header("Location: /admin/login");
	exit;
});

$app->get('/admin/users', function(){
	
	User::verifyLogin();

	$users = User::listAll();

	$page = new PageAdimin();

	$page->setTpl("users", array(
		"users"=>$users
	));
});

$app->get('/admin/users/create', function(){
	
	User::verifyLogin();

	$page = new PageAdimin();

	$page->setTpl("users-create");

});

$app->get("/admin/users/:iduser/delete", function($iduser){

	User::verifyLogin();
	
});

$app->get("/admin/users/:iduser", function($iduser){
	
	User::verifyLogin();

	$page = new PageAdimin();

	$page->setTpl("users-update");
});

$app->post("/admin/users/create", function(){

	User::verifyLogin();

	$user = new User();

	$_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;

	$user->setData($_POST);

	$user->save();
  
	header("Location: /admin/users");
	exit;

});

$app->post("/admin/users/:iduser", function($iduser){

	User::verifyLogin();
	
});


$app->run();

 ?>