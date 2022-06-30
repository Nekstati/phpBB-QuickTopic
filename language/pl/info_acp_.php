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
	'QUICKTOPIC_SETTINGS'				=> 'Quick topic box settings',

	'QUICKTOPIC_IS_COLLAPSED'			=> 'Box is collapsed',
	'QUICKTOPIC_IS_COLLAPSED_EXP'		=> 'If yes, quick topic box is collapsed/minimized by default and expands only when user clicks on it or on “New topic” button. If no, quick topic box is always expanded.',
	'QUICKTOPIC_SHOW_BBCODE'			=> 'Show BBcode buttons',
	'QUICKTOPIC_TEXT_HEIGHT'			=> 'Textarea height',
	'QUICKTOPIC_SHOW_ON_INDEX'			=> 'Show box on board index',
	'QUICKTOPIC_SHOW_ON_INDEX_EXP'		=> 'If no, quick topic box is shown in forums only.',
	'QUICKTOPIC_DEFAULT_FORUM_ID'		=> 'Default forum',
	'QUICKTOPIC_DEFAULT_FORUM_ID_EXP'	=> 'When user submits new topic from the board index page, he must select a target forum. Here you can cpecify a forum which will be selected by default.',
	'QUICKTOPIC_DEFAULT_FORUM_NONE'		=> '--- Not specified ---',
	'QUICKTOPIC_BUTTON_IN_TOPIC'		=> 'Add “New topic” button inside topics',
	'QUICKTOPIC_BUTTON_IN_TOPIC_EXP'	=> 'Add “New topic” button next to “Reply” button on the topic pages. <br />
		<b>NB:</b> some phpBB styles already have this button, but most of them don’t.',

	'QUICKTOPIC_LINES'					=> 'lines',
]);
