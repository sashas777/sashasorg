<?php
// expiriements
$route_index = new Zend_Controller_Router_Route_Regex(
		'([^\.]+)\.html',
		array(
				'controller' => 'index',
				'action' => 'article'),
		array(1 => 'articleId'),
		'%s.html'
);

$route_tag = new Zend_Controller_Router_Route_Regex(
		'tag-([^\.]+)\.html',
		array(
				'controller' => 'index',
				'action' => 'index'),
		array(1 => 'tag'),
		'tag-%s.html'
);


$route_pager_tag = new Zend_Controller_Router_Route_Regex(
		'page-([^\.]+)-([^\.]+)\.html',
		array(
				'controller' => 'index',
				'action' => 'page'),
		array(1 => 'page', 2=> 'tag'
		),
		'page-%s-%s.html'
);

$route_edit_article = new Zend_Controller_Router_Route_Regex(
		'edit-([^\.]+)\.html',
		array(
				'controller' => 'admin',
				'action' => 'addarticle'),
		array(1 => 'articleId'),
		'edit-%s.html'
);

// new routes
$router = new Zend_Controller_Router_Rewrite();

$router->addRoute('articles',$route_index);
$router->addRoute('tag',$route_tag);
// pages for tags and main
$router->addRoute('tagpages',$route_pager_tag);
$router->addRoute('article_edit',$route_edit_article);

//all tags
$router->addRoute('tags',
		new Zend_Controller_Router_Route_Static('all-tags.html', array('controller' => 'tag', 'action' => 'alltags'))
);
//lastfm
$router->addRoute('lastfm',
		new Zend_Controller_Router_Route_Static('lastfm.html', array('controller' => 'index', 'action' => 'lastfm'))
);

$router->addRoute('map',
		new Zend_Controller_Router_Route_Static('travel.html', array('controller' => 'map', 'action' => 'travel'))
);

$router->addRoute('auth_enter',
		new Zend_Controller_Router_Route_Static('user-login.html', array('controller' => 'user', 'action' => 'login'))
);

$router->addRoute('admin',
		new Zend_Controller_Router_Route_Static('administration.html', array('controller' => 'admin', 'action' => 'index'))
);

$router->addRoute('admin_add_article',
		new Zend_Controller_Router_Route_Static('add_article.html', array('controller' => 'admin', 'action' => 'addarticle'))
);

$router->addRoute('adm_add',
		new Zend_Controller_Router_Route_Static('addarticlepost.html', array('controller' => 'admin', 'action' => 'addarticlepost'))
);

$router->addRoute('logout',
		new Zend_Controller_Router_Route_Static('user-logout.html', array('controller' => 'user', 'action' => 'logout'))
);

 