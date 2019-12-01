<?php
defined('is_running') or die('Not an entry point...');

function Install_Check(){
	global $config;
	if(!empty($config['addons']))
		foreach($config['addons'] as $key => $info)
			if(isset($info['id']) && $info['id'] == 340)
				if (version_compare($config['addons'][$key]['version'], '1.0', '<')){
					$folder = \gp\tool\Plugins::GetAddonConfig($key);
					$lfolder = $folder['code_folder_full'].'/languages/';
					if(file_exists($folder['data_folder_full'].'/config.php')){
						$msg = \gpFiles::Get($lfolder.$config['language'].'.php', 'lang')['noscriptmsg'] ?: \gpFiles::Get($lfolder.'en.php', 'lang')['noscriptmsg'];
						$cfg = \gpFiles::Get($folder['data_folder_full'].'/config.php', 'config');
						$cfg['noscriptmsg'] = $msg;
						\gpFiles::SaveArray($folder['data_folder_full'].'/config.php', 'config', $cfg);
					}
				}
	return true;
}
