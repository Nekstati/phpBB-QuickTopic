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
	'QT_NEW_TOPIC'			=> 'Начать новую тему...',
	'QT_NEW_TOPIC_TITLE'	=> 'Заголовок новой темы...',
	'QT_NEW_TOPIC_TEXT'		=> 'Текст новой темы...',
	'FULL_EDITOR'			=> 'Полный ответ и предпросмотр',
	'QT_SUBMIT'				=> 'Опубликовать',
]);
