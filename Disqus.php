<?php

defined('is_running') or die('Not an entry point...');


class Disqus{

	function __construct(){
		global $page, $addonPathData;

		if(file_exists($addonPathData.'/config.php'))
			include_once $addonPathData.'/config.php';

		if (!isset($config) || !in_array($page->gp_index, $config['pages_comments']))
			return;

		echo '<div id="disqus_thread"></div>';
		echo '<script>
				var disqus_config = function () {
					this.page.title = "'.$page->label.'";
					this.page.url = "'.\gp\tool::AbsoluteUrl($page->requested).'";
					this.page.identifier = "'.$page->gp_index.'";
				};
				(function() {
					var d = document, s = d.createElement(\'script\');
					s.src = \'https://'.$config['disqus_forum_url'].'.disqus.com/embed.js\';
					s.setAttribute(\'data-timestamp\', +new Date());
					(d.head || d.body).appendChild(s);
				})();
			</script>';
		echo '<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>';
	}
}
?>
