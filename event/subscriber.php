<?php

namespace nekstati\quicktopic\event;

class subscriber implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{
	public static function getSubscribedEvents()
	{
		if (defined('ADMIN_START'))
		{
			return [];
		}

		return [
			'core.user_setup'						=> 'user_setup',
			'core.index_modify_page_title'			=> 'show_quick_topic_box',
			'core.viewforum_generate_page_after'	=> 'show_quick_topic_box',
			'core.viewtopic_modify_page_title'		=> 'viewtopic_show_new_topic_button',
		];
	}

	/* @var \phpbb\auth\auth */
	protected $auth;

	/* @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/* @var \phpbb\language\language */
	protected $language;

	/* @var \phpbb\controller\helper */
	protected $helper;

	/* @var \phpbb\request\request */
	protected $request;

	/* @var \phpbb\template\template */
	protected $template;

	/* @var \phpbb\user */
	protected $user;

	/** @var string */
	protected $root_path;

	/** @var string */
	protected $table_prefix;

	public function __construct(
		\phpbb\auth\auth $auth,
		\phpbb\config\config $config,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\language\language $language,
		\phpbb\controller\helper $helper,
		\phpbb\request\request $request,
		\phpbb\template\template $template,
		\phpbb\user $user,
		$root_path,
		$table_prefix
	)
	{
		$this->auth			= $auth;
		$this->config		= $config;
		$this->db			= $db;
		$this->language 	= $language;
		$this->helper   	= $helper;
		$this->request  	= $request;
		$this->template 	= $template;
		$this->user 		= $user;
		$this->root_path  	= $root_path;
		$this->table_prefix	= $table_prefix;
	}

	public function user_setup($event)
	{
		$event['lang_set_ext'] = array_merge($event['lang_set_ext'], [[
			'ext_name'		=> 'nekstati/quicktopic',
			'lang_set'		=> 'common',
		]]);
	}

	public function show_quick_topic_box($event)
	{
		$forum_id = $event['forum_data']['forum_id'] ?? 0;

		if (!$this->user->data['is_registered'])
			return;
		if ($forum_id && ($event['forum_data']['forum_status'] == ITEM_LOCKED || !$this->auth->acl_get('f_reply', $forum_id)))
			return;

		add_form_key('posting');
		$this->language->add_lang(['posting']); // For BBcode buttons

		$s_attach_sig	= $this->config['allow_sig'] && $this->user->optionget('attachsig') && $this->auth->acl_get('u_sig') && (!$forum_id || $this->auth->acl_get('f_sigs', $forum_id));
		$s_smilies		= $this->config['allow_smilies'] && $this->user->optionget('smilies') && (!$forum_id || $this->auth->acl_get('f_smilies', $forum_id));
		$s_bbcode		= $this->config['allow_bbcode'] && $this->user->optionget('bbcode') && (!$forum_id || $this->auth->acl_get('f_bbcode', $forum_id));
		$s_notify		= $this->config['allow_topic_notify'] && $this->user->data['user_notify'];

		$qt_hidden_fields = [];

		// Originally we use checkboxes and check with isset(), so we only provide them if they would be checked
		(!$s_bbcode)							? $qt_hidden_fields['disable_bbcode'] = 1		: true;
		(!$s_smilies)							? $qt_hidden_fields['disable_smilies'] = 1		: true;
		(!$this->config['allow_post_links'])	? $qt_hidden_fields['disable_magic_url'] = 1	: true;
		($s_attach_sig)							? $qt_hidden_fields['attach_sig'] = 1			: true;
		($s_notify)								? $qt_hidden_fields['notify'] = 1				: true;

		$this->template->assign_vars([
			'S_BBCODE_ALLOWED'	=> $s_bbcode && $this->config['quicktopic_show_bbcode'],
			'S_BBCODE_IMG'		=> 1,
			'S_LINKS_ALLOWED'	=> $this->config['allow_post_links'],
			'U_QT_ACTION'		=> append_sid("{$this->root_path}posting.php", ['mode' => 'post'] + ($forum_id ? ['f' => $forum_id] : [])),
			'QT_HIDDEN_FIELDS'	=> build_hidden_fields($qt_hidden_fields),
			'QT_FORUM_ID'		=> $forum_id,
			'QT_IS_COLLAPSED'	=> $this->config['quicktopic_is_collapsed'],
			'QT_TEXT_HEIGHT'	=> $this->config['quicktopic_text_height'],
			'QT_SHOW_ON_INDEX'	=> $this->config['quicktopic_show_on_index'],
		]);

		if ($this->config['quicktopic_show_bbcode'] && !$this->template->retrieve_block_vars('custom_tags', []))
			display_custom_bbcodes();

		if (!$forum_id)
			make_jumpbox(append_sid("{$this->root_path}viewforum.php"), $this->config['quicktopic_default_forum_id'], false, 'f_post', true);
	}

	public function viewtopic_show_new_topic_button($event)
	{
		$this->template->assign_var('QT_SHOW_BUTTON_IN_TOPIC', $this->config['quicktopic_button_in_topic']);
	}
}
