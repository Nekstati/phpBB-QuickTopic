<?php

namespace nekstati\quicktopic\acp;

class settings
{
	public $page_title;
	public $tpl_name;
	public $u_action;

	/** @var \phpbb\config\config */
	protected $config;
	/** @var \phpbb\language\language */
	protected $language;
	/** @var \phpbb\request\request */
	protected $request;
	/** @var \phpbb\template\template */
	protected $template;
	/** @var \phpbb\user */
	protected $user;

	public function __construct($u_action, $errors = [])
	{
		global $phpbb_container;
		$this->config	= $phpbb_container->get('config');
		$this->language	= $phpbb_container->get('language');
		$this->request	= $phpbb_container->get('request');
		$this->template	= $phpbb_container->get('template');
		$this->user		= $phpbb_container->get('user');
		$this->db		= $phpbb_container->get('dbal.conn');

		$this->u_action = $u_action;
		$this->tpl_name = '@nekstati_quicktopic/common';
		$this->page_title = $this->language->lang('QUICKTOPIC_TITLE');
		// $this->language->add_lang('common', 'nekstati/quicktopic');

		// Language array keys are $config_model keys uppercased, e.g. $config_model['var'] relates to lang('VAR') and also to lang('VAR_EXP') as explanation (if latter exists).
		// Any string value starts a new block and defines block legend. It can be empty.
		// Any block, optionally, can have explanation section(s) above and below the config fields. If lang('BLOCK') contains block legend, use lang('BLOCK_PREP') and lang('BLOCK_APP') to display such sections.
		// String followed by string creates a separate textual block with no config fields; as above, use lang('BLOCK_PREP') for the text.
		// Last optional string in the end of $config_model detaches the submit buttons into a separate block. It can also be empty.
		$config_model = [
			'',
			'quicktopic_is_collapsed'		=> ['default' => 1,		'validate' => 'bool',		'type' => 'radio:yes_no'],
			'quicktopic_show_bbcode'		=> ['default' => 1,		'validate' => 'bool',		'type' => 'radio:yes_no'],
			'quicktopic_show_on_index'		=> ['default' => 1,		'validate' => 'bool',		'type' => 'radio:yes_no'],
			'quicktopic_default_forum_id'	=> ['default' => 0,		'validate' => 'int:0',		'type' => 'custom:gen_forum_select'],
			'quicktopic_text_height'		=> ['default' => 3,		'validate' => 'int:1:20',	'type' => 'number:1:20',	'append' => ' ' . $this->language->lang('QUICKTOPIC_LINES')],

			'ACP_SUBMIT_CHANGES',
		];

		$config_post = $this->request->variable('config', ['' => ''], true);
		$config_new = [];
		$options = [];

		foreach ($config_model as $key => &$val)
		{
			if (is_string($val)) continue;

			$config_new[$key] = $config_post[$key] ?? $this->config[$key] ?? $val['default'];

			$val['lang'] = strtoupper($key); // We set it here as it is required by validate_config_vars()
		}

		if ($this->request->is_set_post('submit'))
		{
			validate_config_vars($config_model, $config_new, $errors);

			if (empty($errors))
			{
				foreach ($config_new as $key => $value)
				{
					$this->config->set($key, $value);
				}

				meta_refresh(2, $this->u_action);
				trigger_error($this->language->lang('CONFIG_UPDATED') . adm_back_link($this->u_action));
			}
		}

		foreach ($config_model as $key => $value)
		{
			if (is_string($value))
			{
				$options[] = [
					'LEGEND'	=> $value ? ($this->language->lang($value) ?: ' ') : ' ',
					'PREPEND'	=> $value && $this->language->is_set($value . '_PREP') ? $this->language->lang($value . '_PREP') : '',
					'APPEND'	=> $value && $this->language->is_set($value . '_APP') ? $this->language->lang($value . '_APP') : '',
				];
				continue;
			}

			if ($value['type'] == 'none')
			{
				continue;
			}

			$type = explode(':', $value['type']);
			$lang_key = $value['lang'];

			$options[] = [
				'KEY'			=> $key,
				'VALUE'			=> $config_new[$key],
				'TITLE'			=> $this->language->lang($lang_key),
				'EXPLAIN'		=> $this->language->is_set($lang_key . '_EXP') ? $this->language->lang($lang_key . '_EXP') : '',
				'CONTENT'		=> ($value['prepend'] ?? '')
					. ($type[0] == 'custom' && !empty($type[1])
						? ($type[1] == 'html' ? '' : $this->{$type[1]}($key, $config_new))
						: build_cfg_template($type, $key, $config_new, $key, $value)),
			];
		}

		$this->template->assign_vars([
			'TITLE'			=> $this->language->lang('QUICKTOPIC_SETTINGS'),
			'ERROR_MSG'		=> !empty($errors) ? implode('<br />', $errors) : '',
			'URL_ACTION'	=> $this->u_action,
			'OPTIONS'		=> $options,
		]);
	}

	function gen_forum_select($config_name, $config_array)
	{
		$html = "<select id=\"$config_name\" name=\"config[$config_name]\" style=\"width: 250px\">";
		$html .= "<option value=\"0\">{$this->language->lang('QUICKTOPIC_DEFAULT_FORUM_NONE')}</option>";
		$html .= make_forum_select($config_array[$config_name], false, true, /**/ true);
		$html .= '</select>';
		return $html;
	}
}
