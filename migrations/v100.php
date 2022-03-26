<?php

namespace nekstati\quicktopic\migrations;

class v100 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return ['\phpbb\db\migration\data\v320\dev'];
	}

	public function update_data()
	{
		return [
			['config.add', ['quicktopic_is_collapsed', 1]],
			['config.add', ['quicktopic_show_bbcode', 1]],
			['config.add', ['quicktopic_text_height', 3]],
			['config.add', ['quicktopic_show_on_index', 1]],
			['config.add', ['quicktopic_default_forum_id', 0]],
			['module.add', ['acp', 'ACP_CAT_DOT_MODS', 'QUICKTOPIC_TITLE']],
			['module.add', ['acp', 'QUICKTOPIC_TITLE', [
				'module_basename'	=> '\nekstati\quicktopic\acp\a_module',
				'module_langname'	=> 'QUICKTOPIC_SETTINGS',
				'module_mode'		=> 'settings',
				'module_auth'		=> 'ext_nekstati/quicktopic && acl_a_board',
			]]],
		];
	}
}
