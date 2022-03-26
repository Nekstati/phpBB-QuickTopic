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
	'QT_NEW_TOPIC'			=> 'Start a new topic here...',
	'QT_NEW_TOPIC_TITLE'	=> 'New topic title...',
	'QT_NEW_TOPIC_TEXT'		=> 'New topic text...',
	'FULL_EDITOR'			=> 'Full Editor &amp; Preview',
	'QT_SUBMIT'				=> 'Post new topic',
]);
