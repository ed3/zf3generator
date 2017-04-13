<?php
namespace Generator;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
return [
	'controllers' => [
		'factories' => [
		Controller\IndexController::class => InvokableFactory::class,
		],
	],
	'router' => [
	'routes' => [
	'generator' => [
		'type' => Segment::class,
		'options' => [
			'route' => '/generator[/:action][/:id]',
			'constraints' => [
				'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
				'id' => '[a-zA-Z][a-zA-Z0-9_-]*',
			],
			'defaults' => [
				'controller' => Controller\IndexController::class,
				'action' => 'index',
			],
		],
	],
	],
	],
	'view_manager' => [
		'template_path_stack' => [__NAMESPACE__ => __DIR__ . '/../view'],
	],
];