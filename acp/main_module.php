<?php
/**
 *
 * Group Switches extension for the phpBB Forum Software package
 *
 * @copyright (c) 2021, Kailey Snay, https://www.layer-3.org/
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace kaileysnay\groupswitches\acp;

/**
 * Group Switches ACP module
 */
class main_module
{
	public $page_title;
	public $tpl_name;
	public $u_action;

	/**
	 * Main ACP module
	 */
	public function main($id, $mode)
	{
		global $db, $template;
		global $phpbb_container;

		/** @var \phpbb\language\language $language */
		$language = $phpbb_container->get('language');

		/** @var \phpbb\group\helper $group_helper */
		$group_helper = $phpbb_container->get('group_helper');

		// Load a template from adm/style for our ACP page
		$this->tpl_name = 'acp_groupswitches_body';

		// Set the page title for our ACP page
		$this->page_title = $language->lang('GROUP_SWITCHES');

		// Grab all the groups
		$groups_table = $phpbb_container->getParameter('tables.groups');

		$sql = 'SELECT group_name, group_id
			FROM ' . $groups_table . '
			ORDER BY group_name';
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$group_name = $group_helper->get_name($row['group_name']);

			$template->assign_block_vars('groups', [
				'GROUP_NAME'	=> $group_name,
				'GROUP_ID'		=> $row['group_id'],
			]);
		}
		$db->sql_freeresult($result);
	}
}
