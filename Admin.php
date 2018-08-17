<?php
namespace Addon\Disqus;

defined('is_running') or die('Not an entry point...');

class Admin{

	function __construct(){
		global $page, $addonRelativeCode, $langmessage, $gp_index, $gp_titles;
		$page->head_js[] = $addonRelativeCode.'/Disqus.js';
		$page->css_admin[] = $addonRelativeCode.'/Disqus.css';
		$this->loadConfig();
		$cmd = \common::GetCommand();

		switch($cmd){
			case 'saveConfig':
			$this->saveConfig();
			break;
		}
		$this->get_lang_ext();
		
		echo '<p style="text-align: center;"><img  src="'.$addonRelativeCode.'/img/disqus-logo-blue-white.svg'.'" /></p><br/><br/>';
		echo '<div class="disqus_frame" align="center";>'; 
		echo '<input type="radio" name="Disqus" checked="checked" id="Disqus_Site_Conf"/><label for="Disqus_Site_Conf">'.$this->lang_dict['Site Configuration'].'</label>';
		echo '<input type="radio" name="Disqus" id="Disqus_show_comments"/><label for="Disqus_show_comments">'.$this->lang_dict['Select Pages to show comments'].'</label>';
		echo '<input type="radio" name="Disqus" id="Disqus_Manage"/><label for="Disqus_Manage">'.$this->lang_dict['Manage Community'].'</label>';
		
		echo '<div><br/><br/>';
		
		echo '<form action="'.\common::GetUrl('Admin_Disqus').'" method="post">';
			if ($this->disqus_forum_url ==''){
					echo '<label for="disqus_forum_url">'.$this->lang_dict['Shortname'].'<span style="color: red;"> *  </span></label><input id="disqus_forum_url" name="disqus_forum_url" class="gpinput" required value="'.$this->disqus_forum_url.'" type="text"><p class="description">'.$this->lang_dict['Your site\'s unique identifier '].'<a href="https://help.disqus.com/customer/portal/articles/466208" target="_blank">'.$this->lang_dict['What is this?'].'</a></p>
					<p><a href="https://disqus.com/profile/signup/?next=https%3A%2F%2Fdisqus.com%2Fadmin%2Fcreate%2F">'.$this->lang_dict['Sign up to register your account and site with Disqus'].'</a></p>
					<p><a href="https://disqus.com/admin/create/">'.$this->lang_dict['Create a new site on Disqus'].'</a></p>
						';
			}else{
				echo '<br/><label for="disqus_forum_url">'.$this->lang_dict['Shortname'].'<span style="color: red;"> *  </span></label>
						<input id="disqus_forum_url" name="disqus_forum_url" class="gpinput" required value="'.$this->disqus_forum_url.'" type="text">
						<p class="description">'.$this->lang_dict['Your site\'s unique identifier '].'<a href="https://help.disqus.com/customer/portal/articles/466208" target="_blank">
						'.$this->lang_dict['What is this?'].'</a></p>';
			
				echo '</div><div><br/><br/>';

		
	
 echo '<table class="comments_pages">
		<col style="width:50%"/><col style="width:25%"/><col style="width:25%"/>
			<tr style="font-weight:bold"><td>'.$this->lang_dict['Pages'].'</td><td>'.$this->lang_dict['Show comments?'].'</td><td></td></tr>';

foreach ($gp_index as $t=>$i) {
	$url=\common::GetUrl($t);
	
	echo '<tr>
			<td ><a href="'.$url.'" title="'.$url.'" target="_blank">'.\common::GetLabel($t).'</a></td><td class="comment_selector">';
	if (in_array($i, $this->pages_comments)){
		echo '<input id="'.$i.'" type="checkbox" checked name="pages_comments[]" value="'.$i.'" />';
	} else {
		echo '<input id="'.$i.'" type="checkbox" name="pages_comments[]" value="no" />';
	}
			
	echo '</td><td></td></tr>';
}
  
  echo '</table>';
			echo '</div>';				
	echo '<div><br/><br/>';
			echo '
			<div class="manage-panel-content">
				<table border="0" style="width:100%;">
					<tbody>
						<tr>
							<td>
							<h1>'.$this->lang_dict['Comments'].'</h1>
							</td>
							<td>
							<h1>'.$this->lang_dict['Analytics'].'</h1>
							</td>
							<td>
							<h1>'.$this->lang_dict['Settings'].'</h1>
							</td>
						</tr>
						<tr>
							<td><a href="https://'.$this->disqus_forum_url.'.disqus.com/admin/moderate/" target="_blank">'.$this->lang_dict['Moderate'].'</a></td>
							<td><a href="https://'.$this->disqus_forum_url.'.disqus.com/admin/analytics/comments/" target="_blank">'.$this->lang_dict['Engagement'].'</a></td>
							<td><a href="https://'.$this->disqus_forum_url.'.disqus.com/admin/settings/general/" target="_blank">'.$this->lang_dict['General'].'</a></td>
						</tr>
						<tr>
							<td>'.$this->lang_dict['Manage: '].'<a href="https://'.$this->disqus_forum_url.'.disqus.com/admin/access/banned/" target="_blank">'.$this->lang_dict['Banned users'].'</a> | <a href="https://'.$this->disqus_forum_url.'.disqus.com/admin/settings/access/" target="_blank">'.$this->lang_dict['Restricted words filter'].'</a> | <a href="https://'.$this->disqus_forum_url.'.disqus.com/admin/settings/moderators/" target="_blank">'.$this->lang_dict['Site moderators'].'</a></td>
							<td><a href="https://'.$this->disqus_forum_url.'.disqus.com/admin/analytics/revenue/" target="_blank">'.$this->lang_dict['Revenue'].'</a></td>
							<td><a href="https://'.$this->disqus_forum_url.'.disqus.com/admin/settings/community/" target="_blank">'.$this->lang_dict['Community Rules'].'</a></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><a href="https://'.$this->disqus_forum_url.'.disqus.com/admin/analytics/content/" target="_blank">'.$this->lang_dict['Popular Content'].'</a></td>
							<td><a href="https://'.$this->disqus_forum_url.'.disqus.com/admin/settings/advanced/" target="_blank">'.$this->lang_dict['Advanced'].'</a></td>
						</tr>
					</tbody>
				</table>

		</div></div>';
				}
		echo '<br/><br/>
					<input type="hidden" name="cmd" value="saveConfig" />
					<input type="submit" value="'.$langmessage['save_changes'].'" class="gpsubmit"/>
					<input type="button" onClick="location.href=\'' . \common::GetUrl('Admin_Disqus') . '\'" name="cmd" 
					value="'.$langmessage['cancel'].'" class="admin_box_close gpcancel" /></form>'; 
	}
	
	function saveConfig(){
		global $addonPathData, $langmessage;

		$configFile = $addonPathData.'/config.php';
		$config     = array();
		$config['disqus_forum_url'] = $_POST['disqus_forum_url'];
	
		if($_POST){
			$config['pages_comments'] = $_POST["pages_comments"];	
		}
	
		$this->pages_comments = $config['pages_comments'];
		$this->disqus_forum_url	= $config['disqus_forum_url'];
	
	
		if( !\gpFiles::SaveArray($configFile,'config',$config) ){
			message($langmessage['OOPS']);
			return false;
		}

		message($langmessage['SAVED']);
		return true;
  }

  function loadConfig(){
		global $addonPathData;
		
		$configFile = $addonPathData.'/config.php';
    
		if(file_exists($configFile)){
			include_once $configFile;
		}else{
			$this->disqus_forum_url ='';
			$this->pages_comments=array();		
		}		
		

		if (isset($config)) {
			$this->disqus_forum_url = $config['disqus_forum_url'];
			$this->pages_comments = $config['pages_comments']; 
		}
  } 
  
	function get_lang_ext(){
		global $config;
		$langfile = '/languages/'.$config['language'].'.php';
	
		if(file_exists(dirname(__FILE__).$langfile)){
			include dirname(__FILE__).$langfile;
			}else{$langfile = '/languages/en.php';
			include dirname(__FILE__).$langfile;
			}
			$this->lang_dict = $lang_dict;
	}  
	
}