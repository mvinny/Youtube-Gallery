<?php
/**
 *
 * @author _Vinny_ (http://www.suportephpbb.com.br/) vinnykun@hotmail.com
 * @version $Id$
 * @copyright (c) 2013
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

/**
 * @ignore
 */
define('UMIL_AUTO', true);
define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);

include($phpbb_root_path . 'common.' . $phpEx);
$user->session_begin();
$auth->acl($user->data);
$user->setup();


if (!file_exists($phpbb_root_path . 'umil/umil_auto.' . $phpEx))
{
	trigger_error('Please download the latest UMIL (Unified MOD Install Library) from: <a href="http://www.phpbb.com/mods/umil/">phpBB.com/mods/umil</a>', E_USER_ERROR);
}

// The name of the mod to be displayed during installation.
$mod_name = 'VIDEO_INDEX';

/*
* The name of the config variable which will hold the currently installed version
* UMIL will handle checking, setting, and updating the version itself.
*/
$version_config_name = 'video_version';


// The language file which will be included when installing
$language_file = 'mods/info_acp_video';

/*
* The array of versions and actions within each.
* You do not need to order it a specific way (it will be sorted automatically), however, you must enter every version, even if no actions are done for it.
*
* You must use correct version numbering.  Unless you know exactly what you can use, only use X.X.X (replacing X with an integer).
* The version numbering must otherwise be compatible with the version_compare function - http://php.net/manual/en/function.version-compare.php
*/
$versions = array(
	'1.0.0' => array(

      'config_add' => array(
		 array('video_width', '640'),
		 array('video_height', '390'),
      ),

		// Alright, now lets add some modules to the ACP
		'module_add' => array(
			// First, lets add a new category named ACP_CAT_TEST_MOD to ACP_CAT_DOT_MODS
			array('acp', 'ACP_CAT_DOT_MODS', 'ACP_VIDEO'),

			// Now we will add the settings and features modes from the acp_board module to the ACP_CAT_TEST_MOD category using the "automatic" method.
			array('acp', 'ACP_VIDEO', array(
					'module_basename'		=> 'video',
					'modes'					=> array('cat', 'settings'),
				),
			),
		),

		// Now add the table
		'table_add' => array(
			array('phpbb_video', array(
				'COLUMNS' => array(
					'video_id'		=> array('UINT:11', NULL, 'auto_increment'),
					'video_url'		=> array('VCHAR:255', ''),
					'video_title'	=> array('VCHAR:255', ''),
					'video_cat_id'	=> array('UINT', 0),
					'username'		=> array('VCHAR:255', ''),
					'user_id'		=> array('VCHAR:255', ''),
					'youtube_id'	=> array('VCHAR:255', ''),
					'create_time'	=> array('TIMESTAMP', 0),
				),
				'PRIMARY_KEY'	=> 'video_id',
			)),
			array('phpbb_video_cat', array(
				'COLUMNS' => array(
					'video_cat_id'		=> array('UINT:11', NULL, 'auto_increment'),
					'video_cat_title'	=> array('VCHAR:255', ''),
				),
				'PRIMARY_KEY'	=> 'video_cat_id',
			)),
		),

		'table_insert'	=> array(
			array('phpbb_video_cat', array(
				array(
					'video_cat_id'		=> 1,
					'video_cat_title'	=> 'Uncategorized',
					),
				)),
		),

	),
);

// Include the UMIL Auto file, it handles the rest
include($phpbb_root_path . 'umil/umil_auto.' . $phpEx);

?>