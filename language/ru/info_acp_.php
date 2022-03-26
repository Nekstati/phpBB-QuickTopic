<?php

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'QUICKTOPIC_TITLE'					=> 'Quick topic box',
	'QUICKTOPIC_SETTINGS'				=> 'Quick topic box — настройка',

	'QUICKTOPIC_IS_COLLAPSED'			=> 'Свернуть блок',
	'QUICKTOPIC_IS_COLLAPSED_EXP'		=> 'Если да, блок свёрнут по умолчанию и разворачивается, когда пользователь нажмёт на поле ввода или на кнопку «Новая тема». Если нет, блок всегда развёрнут.',
	'QUICKTOPIC_SHOW_BBCODE'			=> 'Показывать кнопки ББкодов',
	'QUICKTOPIC_TEXT_HEIGHT'			=> 'Высота текстового поля',
	'QUICKTOPIC_SHOW_ON_INDEX'			=> 'Показывать блок на главной странице',
	'QUICKTOPIC_SHOW_ON_INDEX_EXP'		=> 'Если нет, блок будет показан только в форумах (списках тем).',
	'QUICKTOPIC_DEFAULT_FORUM_ID'		=> 'Форум по умолчанию',
	'QUICKTOPIC_DEFAULT_FORUM_ID_EXP'	=> 'Если пользователь создаёт новую тему, находясь на главной странице, он должен выбрать форум, в котором будет размещена тема. Здесь вы можете задать форум, который будет выбран по умолчанию.',
	'QUICKTOPIC_DEFAULT_FORUM_NONE'		=> '--- Не выбран ---',

	'QUICKTOPIC_LINES'					=> 'строк',
]);
