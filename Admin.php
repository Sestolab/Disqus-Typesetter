<?php
namespace Addon\Disqus;

defined('is_running') or die('Not an entry point...');

class Admin{

	function __construct(){
		global $page, $addonRelativeCode, $langmessage, $gp_index, $config, $addonPathCode;
		$page->head_js[] = $addonRelativeCode.'/Disqus.js';
		$page->css_admin[] = $addonRelativeCode.'/Disqus.css';
		$lang = \gpFiles::Get($addonPathCode.'/languages/'.$config['language'].'.php', 'lang') ?: \gpFiles::Get($addonPathCode.'/languages/en.php', 'lang');

		$this->loadConfig();

		if(\common::GetCommand() == 'saveConfig')
				$this->saveConfig();

		echo '<p class="text-center"><img  src="'.$addonRelativeCode.'/img/disqus-logo-blue-white.svg'.'" /></p><br/>';
		echo '<div class="disqus_frame" align="center">';
		echo '<input type="radio" name="Disqus" id="Disqus_Site_Conf" '.($this->disqus_forum_url ? '' : 'checked').'/><label for="Disqus_Site_Conf">'.$lang['Site Configuration'].'</label>';
		echo '<input type="radio" name="Disqus" id="Disqus_show_comments" '.($this->disqus_forum_url ? 'checked' : 'disabled').'/><label for="Disqus_show_comments">'.$lang['Select Pages to show comments'].'</label>';
		echo '<input type="radio" name="Disqus" id="Disqus_Manage" '.($this->disqus_forum_url ? '' : 'disabled').'/><label for="Disqus_Manage">'.$lang['Manage Community'].'</label>';
		echo '<div>';
		echo '<form action="'.\common::GetUrl('Admin_Disqus').'" method="post">';
		echo '<label for="disqus_forum_url">'.$lang['Shortname'].'</label><input id="disqus_forum_url" name="disqus_forum_url" class="gpinput" required readonly value="'.$this->disqus_forum_url.'">';
		echo '<p>'.$lang['Your site\'s unique identifier'].' <a href="https://help.disqus.com/customer/portal/articles/466208" target="_blank">'.$lang['What is this?'].'</a></p>';
		echo '<p><a id="edit_shortname"><span class="fa fa-lock"></span> '.$lang['Click to make changes'].'</a></p>';
		if($this->disqus_forum_url == ''){
			echo '<p><a href="https://disqus.com/profile/signup/?next=https://disqus.com/admin/create/">'.$lang['Sign up to register your account and site with Disqus'].'</a></p>';
			echo '<p><a href="https://disqus.com/admin/create/">'.$lang['Create a new site on Disqus'].'</a></p>';
		}
		echo '</div>';
 		echo '<div><table class="comments_pages bordered"><col/><col/><tr><th>'.$lang['Pages'].'</th><th>'.$lang['Show comments?'].'</th></tr>';
		foreach($gp_index as $t=>$i){
			echo '<tr><td>'.\gp\tool::Link_Page($t).'</td><td class="comment_selector">';
			echo '<input id="'.$i.'" type="checkbox" name="pages_comments[]" '.(in_array($i, $this->pages_comments) ? 'checked' : '').' value="'.$i.'"/>';
			echo '</td></tr>';
		}
  		echo '</table></div><div>';

		echo '<div>
				<table class="full_width">
					<tbody>
						<tr>
							<td>
							<h1>'.$lang['Comments'].'</h1>
							</td>
							<td>
							<h1>'.$lang['Analytics'].'</h1>
							</td>
							<td>
							<h1>'.$lang['Settings'].'</h1>
							</td>
						</tr>
						<tr>
							<td><a href="https://'.$this->disqus_forum_url.'.disqus.com/admin/moderate/" target="_blank">'.$lang['Moderate'].'</a></td>
							<td><a href="https://'.$this->disqus_forum_url.'.disqus.com/admin/analytics/comments/" target="_blank">'.$lang['Engagement'].'</a></td>
							<td><a href="https://'.$this->disqus_forum_url.'.disqus.com/admin/settings/general/" target="_blank">'.$lang['General'].'</a></td>
						</tr>
						<tr>
							<td>'.$lang['Manage:'].' <a href="https://'.$this->disqus_forum_url.'.disqus.com/admin/access/banned/" target="_blank">'.$lang['Banned users'].'</a> | <a href="https://'.$this->disqus_forum_url.'.disqus.com/admin/settings/access/" target="_blank">'.$lang['Restricted words filter'].'</a> | <a href="https://'.$this->disqus_forum_url.'.disqus.com/admin/settings/moderators/" target="_blank">'.$lang['Site moderators'].'</a></td>
							<td><a href="https://'.$this->disqus_forum_url.'.disqus.com/admin/analytics/revenue/" target="_blank">'.$lang['Revenue'].'</a></td>
							<td><a href="https://'.$this->disqus_forum_url.'.disqus.com/admin/settings/community/" target="_blank">'.$lang['Community Rules'].'</a></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><a href="https://'.$this->disqus_forum_url.'.disqus.com/admin/analytics/content/" target="_blank">'.$lang['Popular Content'].'</a></td>
							<td><a href="https://'.$this->disqus_forum_url.'.disqus.com/admin/settings/advanced/" target="_blank">'.$lang['Advanced'].'</a></td>
						</tr>
					</tbody>
				</table>
				</div></div>';
		echo '<p>
				<input type="hidden" name="cmd" value="saveConfig" />
				<input type="submit" value="'.$langmessage['save_changes'].'" class="gpsubmit"/>
				<input type="button" onClick="location.href=\''.\common::GetUrl('Admin_Disqus').'\'" name="cmd" value="'.$langmessage['cancel'].'" class="gpcancel"/>
			</p></form></div>';

		echo '<div class="text-right">Made by <a href="https://sestolab.pp.ua" target="_blank">Sestolab</a></div>';
	}

	function saveConfig(){
		global $addonPathData, $langmessage;
		$config['disqus_forum_url'] = $_POST['disqus_forum_url'];
		$config['pages_comments'] = isset($_POST['pages_comments']) ? $_POST['pages_comments'] : array();

		$this->pages_comments = $config['pages_comments'];
		$this->disqus_forum_url	= $config['disqus_forum_url'];

		if(\gpFiles::SaveArray($addonPathData.'/config.php', 'config', $config))
			return message($langmessage['SAVED']);
		message($langmessage['OOPS']);
  	}

  	function loadConfig(){
		global $addonPathData;
		$config = \gpFiles::Get($addonPathData.'/config.php', 'config');
		$this->disqus_forum_url = isset($config['disqus_forum_url']) ? $config['disqus_forum_url'] : '';
		$this->pages_comments = isset($config['pages_comments']) ? $config['pages_comments'] : array();
  	}

}
