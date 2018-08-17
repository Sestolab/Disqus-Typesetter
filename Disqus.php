<?php

defined('is_running') or die('Not an entry point...');


class Disqus{
	
	function __construct(){
			global $page,$addonPathData;
			$configFile = $addonPathData.'/config.php';
		
			if(file_exists($configFile)){
				include_once $configFile;
			}else {
			$this->disqus_forum_url ='';
			$this->pages_comments=array();
			}		
		
			if (isset($config)){
				$this->disqus_forum_url = $config['disqus_forum_url'];
				$this->pages_comments = $config['pages_comments'];
			}
		 
			if (in_array($page->gp_index, $this->pages_comments)){
				$this->ShowDisqus($page->gp_index,$page->title);
			}
		
		}

function ShowDisqus($index,$title){
			echo '<div id="disqus_thread"></div>';
			echo '<script>
				var disqus_config = function () {
				this.page.title = "'.$title.'";
				this.page.url = "'.$this->getUrl().'";
				this.page.identifier = "'.$index.'"; 
				};

				(function() { 
				var d = document, s = d.createElement(\'script\');
				s.src = \'https://'.$this->disqus_forum_url.'.disqus.com/embed.js\';
				s.setAttribute(\'data-timestamp\', +new Date());
				(d.head || d.body).appendChild(s);
				})();
		</script>
	<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>';
		}
	
	function getUrl() {
		$url  = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
		$url .= ( $_SERVER["SERVER_PORT"] != 80 ) ? ":".$_SERVER["SERVER_PORT"] : "";
		$url .= $_SERVER["REQUEST_URI"];
		return $url;
	}
}
?>