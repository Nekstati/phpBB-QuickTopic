<?php

namespace nekstati\quicktopic\acp;

class a_info
{
	public function module()
	{
		return [
			'filename'	=> '\nekstati\quicktopic\acp\a_module',
			'title'		=> 'QUICKTOPIC_TITLE',
			'modes'		=> [
				'settings'	=> [
					'title'		=> 'QUICKTOPIC_SETTINGS',
					'auth'		=> 'ext_nekstati/quicktopic && acl_a_board',
					'cat'		=> ['QUICKTOPIC_TITLE'],
				],
			],
		];
	}
}
