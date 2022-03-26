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
	'QT_NEW_TOPIC'			=> 'Rozpocznij nowy temat tutaj...',
	'QT_NEW_TOPIC_TITLE'	=> 'Tytuł nowego tematu...',
	'QT_NEW_TOPIC_TEXT'		=> 'Tekst nowego tematu...',
	'FULL_EDITOR'			=> 'Pełny edytor i podgląd',
	'QT_SUBMIT'				=> 'Opublikuj nowy temat',
]);
