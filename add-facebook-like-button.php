<?php
/*
Plugin Name: Facebook Like Button
Plugin URI:  http://www.onlinesite-marketing.com
Description: Plugin allow you to add facebook like/ Recommend button to your post/pages/archive or home page in few clicks
Version: 1.0.0
Author: cordell jenkins
Author URI: http://www.onlinesite-marketing.com
*/


add_filter('the_content', 'add_post_footer');
add_filter('the_excerpt', 'add_post_footer');

if(is_admin()){	
    add_action('admin_menu', 'likefb_options');
}
else
{
	if(get_option('fb_appid')!="")
	{
		add_action('wp_footer', 'facebook_footer');
	}
	add_action('wp_head','meta_add');
}

if(get_option('likefb_display_lang')=="") {
	update_option('likefb_display_lang',"en_US");
}

function add_post_footer($text)
{
	global $posts;
	
	$layout=get_option('likefb_layout');
	$showface="false";
	if(get_option('likefb_showfaces')==1)
	{
		$showface="true";
	}

	$showsend="false";
	if(get_option('likefb_showSend')==1)
	{
		$showsend="true";
	}

	$action=get_option('likefb_action');
	$font=get_option('likefb_font');
	$colorscheme=get_option('likefb_colorscheme');
	
	if(get_option('fb_width')!="")
	{
		$width=get_option('fb_width');
	}
	else
	{
		$width=130;
	}
	if(get_option('fb_height')!="")
	{
		$height=get_option('fb_height');
	}
	else
	{
		$height=130;
	}
	
	
	$appid=get_option('fb_appid');
	if($appid!= "")
	{
		if(get_option('likefb_display_lang')=="") {
			update_option('likefb_display_lang',"en_US");
		}
		
		$iframe='<div style="height:'.$height.'px"><fb:like href="'.urlencode(get_permalink($post->ID)).'" layout="standard" send="'.$showsend.'" show_faces="'.$showface.'" width="'.$width.'" action="'.$action.'" colorscheme="'.$colorscheme.'" /></div>';
	}
	else
	{
		$iframe='<iframe src="http://www.facebook.com/plugins/like.php?locale='.get_option('likefb_display_lang').'&href='.urlencode(get_permalink($post->ID)).'&amp;layout='.$layout.'&amp;show-faces='.$showface.'&amp;width='.$width.'&amp;action='.$action.'&amp;colorscheme='.$colorscheme.'" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:'.$width.'px; height:'.$height.'px"></iframe>';
		if(get_option('fb_placein')=='top')
		{
			$iframe=$iframe."<br/>";
		}
		else
		{
			$iframe="<br/>".$iframe;
		}
	}
	if(is_single() && get_option('likefb_display_single') == '1')
	{
		if(get_option('fb_placein')=='top')
		{
			$text=$iframe.$text;
		}
		else
		{
			$text=$text.$iframe;
		}
		
	}
	
	if(is_page() && get_option('likefb_display_page') == '1')
	{
		if(get_option('fb_placein')=='top')
		{
			$text=$iframe.$text;
		}
		else
		{
			$text=$text.$iframe;
		}
		
	}
	
	if(is_home() && get_option('likefb_display_front') == '1')
	{
		if(get_option('fb_placein')=='top')
		{
			$text=$iframe.$text;
		}
		else
		{
			$text=$text.$iframe;
		}
		
	}

	if(is_category() && get_option('likefb_display_category') == '1')
	{
		if(get_option('fb_placein')=='top')
		{
			$text=$iframe.$text;
		}
		else
		{
			$text=$text.$iframe;
		}
		
	}
	
	return $text;
}

function likefb_options()
{
		
	add_options_page('Facebook Like Setting', 'Facebook Like Setting', 'manage_options', basename(__FILE__), 'likefb_options_page');
}

function likefb_options_page()
{
if(isset($_POST))
{
	if(isset($_POST['Submit']))
	{
		
		if(isset($_POST['likefb_display_page'])) {
		update_option('likefb_display_page',filter_var($_POST['likefb_display_page'],FILTER_VALIDATE_INT));
		}
		if(isset($_POST['likefb_display_front'])) {
		update_option('likefb_display_front',filter_var($_POST['likefb_display_front'],FILTER_VALIDATE_INT));
		}
		if(isset($_POST['likefb_display_single'])) {
		update_option('likefb_display_single',filter_var($_POST['likefb_display_single'],FILTER_VALIDATE_INT));
		}
		if(isset($_POST['likefb_display_category'])) {
		update_option('likefb_display_category',filter_var($_POST['likefb_display_category'],FILTER_VALIDATE_INT));
		}
		
		
		update_option('fb_appid',filter_var($_POST['fb_appid'],FILTER_SANITIZE_STRING));
		
		update_option('fb_app_id',filter_var($_POST['fb_app_id'],FILTER_SANITIZE_STRING));
		
		update_option('fb_width',filter_var($_POST['fb_width'],FILTER_VALIDATE_INT));
		
		update_option('fb_height',filter_var($_POST['fb_height'],FILTER_VALIDATE_INT));
		
		update_option('fb_placein',filter_var($_POST['placein'],FILTER_SANITIZE_STRING));
		
		update_option('likefb_layout',filter_var($_POST['layout'],FILTER_SANITIZE_STRING));
	
		update_option('likefb_showSend',filter_var($_POST['likefb_showSend'],FILTER_VALIDATE_INT));
		
		update_option('likefb_showfaces',filter_var($_POST['likefb_showfaces'],FILTER_VALIDATE_INT));
		
		update_option('likefb_action',filter_var($_POST['action'],FILTER_SANITIZE_STRING));
		
		update_option('likefb_font',filter_var($_POST['font'],FILTER_SANITIZE_STRING));
	
		update_option('likefb_colorscheme',filter_var($_POST['colorscheme'],FILTER_SANITIZE_STRING));
		
		update_option('likefb_display_lang',filter_var($_POST['likefb_display_lang'],FILTER_SANITIZE_STRING));
		
	}
}
?>

 <div class="wrap" style="font-size:13px;">

			<div class="icon32" id="icon-options-general"><br/></div><h2>Settings for Facebook Like</h2>
			<form method="post" action="options-general.php?page=add-facebook-like-button.php">
			<table class="form-table">
			<tr>
				<td>
				<strong>Display</strong>
				</td>
				<td>
					<p>
	
	                <input type="checkbox" value="1" <?php if (get_option('likefb_display_page') == '1') echo 'checked="checked"'; ?> name="likefb_display_page" id="likefb_display_page" group="likefb_display"/>
	
	                <label for="likefb_display_page">Display the button on pages</label>
	
	            </p>
	
	            <p>
	
	                <input type="checkbox" value="1" <?php if (get_option('likefb_display_front') == '1') echo 'checked="checked"'; ?> name="likefb_display_front" id="likefb_display_front" group="likefb_display"/>
	
	                <label for="likefb_display_front">Display the button on the front page (home)</label>
	
	            </p>
	
	            <p>
	
	                <input type="checkbox" value="1" <?php if (get_option('likefb_display_single') == '1') echo 'checked="checked"'; ?> name="likefb_display_single" id="likefb_display_single" group="likefb_display"/>
	                
	                                <label for="likefb_display_single">Display the button on the Single post page </label>
	
	            </p>
			<p>
	
	                <input type="checkbox" value="1" <?php if (get_option('likefb_display_category') == '1') echo 'checked="checked"'; ?> name="likefb_display_category" id="likefb_display_category" group="likefb_display"/>
	                
	                                <label for="likefb_display_category">Display the button on the Category pages </label>
	
	            </p>
				</td>
			</tr>
			<tr>
				<td>
					<strong>Place in content</strong>
				</td>
				<td>
					<p>
						<select name="placein">
							<option value="bottom">Bottom</option>
							<option value="top" <?php if(get_option('fb_placein')=='top') echo "selected" ?>>Top</option>
						</select>
					</p>
				</td>
			</tr>
			<tr>
				<td>
					<strong>Language</strong>
				</td>
				<td>
					<p>
						<input type="text" name="likefb_display_lang" id="likefb_display_lang" value="<?php echo get_option('likefb_display_lang'); ?>">
						<label for="likefb_display_lang">Enter locale code. Example: en_US,fr_FR</label>
					</p>
				</td>
			</tr>
			<tr>
				<td>
					<strong>Facebook Application ID</strong> (<a href="http://www.facebook.com/developers/apps.php" target="_blank">Info</a>)
				</td>
				<td>
					<p>
						<input type="text" value="<?php echo get_option('fb_appid'); ?>" name="fb_appid" id="fb_appid" group="likefb_appid"/>
						<label for="likefb_appid">(If you want to use XFBML , add app id) </label>
						               
					</p>
				</td>
			</tr>
			<tr>
				<td>
					<strong>Facebook Application ID For meta</strong> (<a href="http://www.facebook.com/developers/apps.php" target="_blank">Info</a>)
				</td>
				<td>
					<p>
						<input type="text" value="<?php echo get_option('fb_app_id'); ?>" name="fb_app_id" id="fb_app_id" group="likefb_app_id"/>
						<label for="likefb_app_id">(For Meta Data) </label>
						               
					</p>
				</td>
			</tr>
			<tr>
				<td>
					<strong>Size</strong>
				</td>
				<td>
					<p>
						<?php
						if(get_option('fb_width')!="")
						{
							$width=get_option('fb_width');
						}
						else
						{
							$width=450;
						}
						?>
						<input type="text" value="<?php echo $width ?>" name="fb_width" id="fb_width" group="likefb_size"/>
						<label for="fb_width">Width (px)</label>
						               
					</p>
					<p>
						<?php
						if(get_option('fb_height')!="")
						{
							$height=get_option('fb_height');
						}
						else
						{
							$height=130;
						}
						?>
						<input type="text" value="<?php echo $height ?>" name="fb_height" id="fb_height" group="likefb_size"/>
						<label for="fb_height">Height (px)</label>
						               
					</p>
				</td>
			</tr>
			<tr>
				<td><strong>Design</strong></td>
				<td>
				<p>
					Layout<br/>
					<select id="layout" name="layout">
					<option value="standard" <?php if (get_option('likefb_layout') == 'standard') echo "selected" ?> >standard</option>
					<option value="button_count" <?php if (get_option('likefb_layout') == 'button_count') echo "selected" ?> >button count</option>
					<option value="box_count" <?php if (get_option('likefb_layout') == 'box_count') echo "selected" ?> >box count</option>
					</select>
				</p>
				<p>
					<input type="checkbox" value="1" <?php if (get_option('likefb_showfaces') == '1') echo 'checked="checked"'; ?> name="likefb_showfaces" id="likefb_showfaces" group="likefb_design"/>
					
				<label for="likefb_showfaces">Show Faces (only work with standard mode)</label>
				</p>
				<p>
					<input type="checkbox" value="1" <?php if (get_option('likefb_showSend') == '1') echo 'checked="checked"'; ?> name="likefb_showSend" id="likefb_showSend" group="likefb_design"/>
					
				<label for="likefb_showSend">Show Send Button (only work with XFBML and standard mode)</label>
				</p>
				<p>
					Verb to display<br/>
					<select id="param_action" name="action">
					<option selected="1" <?php if (get_option('likefb_action') == '1') echo "selected" ?> value="like">like</option>
					<option value="recommend" <?php if (get_option('likefb_action') == 'recommend') echo "selected" ?>>recommend</option>
					</select>
				</p>
				<p>
					Font<br/>
					<select id="param_font" name="font">
						<option selected="1" <?php if (get_option('likefb_font') == '1') echo "selected" ?>></option>
						<option value="arial" <?php if (get_option('likefb_font') == 'arial') echo "selected" ?>>arial</option>
						<option value="lucida grande" <?php if (get_option('likefb_font') == 'lucida grande') echo "selected" ?>>lucida grande</option>
						<option value="segoe ui" <?php if (get_option('likefb_font') == 'segoe ui') echo "selected" ?>>segoe ui</option>
						<option value="tahoma" <?php if (get_option('likefb_font') == 'tahoma') echo "selected" ?>>tahoma</option>
						<option value="trebuchet ms" <?php if (get_option('likefb_font') == 'trebuchet ms') echo "selected" ?>>trebuchet ms</option>
						<option value="verdana" <?php if (get_option('likefb_font') == 'verdana') echo "selected" ?>>verdana</option>
						</select>
				</p>
				<p>
					Color<br/>
					<select id="param_colorscheme" name="colorscheme">
						<option value="light" <?php if (get_option('likefb_colorscheme') == 'light' OR get_option('likefb_font') =='' ) echo "selected" ?>>light</option>
						<option value="dark" <?php if (get_option('likefb_colorscheme') == 'dark') echo "selected" ?>>dark</option>
					</select>
				</td>
			</tr>
			<tr>
				<td><strong>Preview (can't display for XFBML).</strong></td>
				<td>
					<?php
					$layout=get_option('likefb_layout');
					$showface="false";
					if(get_option('likefb_showfaces')==1)
					{
						$showface="true";
					}
					$showsend="false";
					if(get_option('likefb_showSend')==1)
					{
						$showsend="true";
					}
					$action=get_option('likefb_action');
					$font=get_option('likefb_font');
					$colorscheme=get_option('likefb_colorscheme');
					
					if(get_option('fb_width')!="")
					{
						$width=get_option('fb_width');
					}
					else
					{
						$width=130;
					}
					if(get_option('fb_height')!="")
					{
						$height=get_option('fb_height');
					}
					else
					{
						$height=130;
					}
					
					
					$appid=get_option('fb_appid');
					if($appid!= "")
					{
						$iframe='<div style="height:'.$height.'px"><fb:like href="'.urlencode(get_bloginfo('url')).'" layout="standard" send="'.$showsend.'" show_faces="'.$showface.'" width="'.$width.'" action="'.$action.'" colorscheme="'.$colorscheme.'" /></div>';
					}
					else
					{
						$iframe='<br/><iframe src="http://www.facebook.com/plugins/like.php?locale='.get_option('likefb_display_lang').'&href='.urlencode(get_bloginfo('url')).'&amp;layout='.$layout.'&amp;show-faces='.$showface.'&amp;width='.$width.'&amp;action='.$action.'&amp;colorscheme='.$colorscheme.'" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:'.$width.'px; height:'.$height.'px"></iframe>';
					}
					
					echo $iframe;
					?>
				</td>
			</tr>
			</table>
			
			<p class="submit">
			
			            <input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
			
			        </p>
			</form>
</div>
<?php
}

function meta_add(){
global $post;
setup_postdata($post);
$des=$post->post_excerpt;
if($post->post_excerpt=="")
{
 $des=substr($post->post_content,0,100);

}
$des=htmlentities($des,ENT_COMPAT,"UTF-8");
?>
<script>
jQuery(document).ready(function(){
jQuery("html").attr("xmlns:og","http://opengraphprotocol.org/schema/");
<?php
if(get_option('fb_appid')!=""):
?>
jQuery("html").attr("xmlns:fb","http://ogp.me/ns/fb#");
<?php
endif;
?>
});
</script>
	<?php
	if(is_single())
	{
	?>
		<meta property="og:type" content="article" />
		<meta property="og:title" content="<?php echo $post->post_title ?>" />
		<meta property="og:site_name" content="<?php bloginfo('name') ?>" />
		<meta property='og:url' content="<?php echo get_permalink($post->ID) ?>" />
		<meta name="og:author" content="<?php echo get_the_author(); ?>" />
		<?php if(get_option('fb_app_id')!=""): ?>
		<meta name="fb:app_id" content="<?php echo get_option('fb_app_id') ?>" />
		<?php endif; ?>
	<?php
	}
	else
	{
	?>
		<meta property="og:type" content="blog" />
		<meta property="og:site_name" content="<?php bloginfo('name') ?>" />
		<meta property='og:url' content="<?php bloginfo('url') ?>" />
		<?php if(get_option('fb_app_id')!=""): ?>
		<meta name="fb:app_id" content="<?php echo get_option('fb_app_id') ?>" />
		<?php endif; ?>
	<?php
	}
}
	function facebook_footer() {
	
		if(get_option('likefb_display_lang')=="") {
			update_option('likefb_display_lang',"en_US");
		}
		
		if(get_option('fb_appid')!=""):
	?>
	 <div id="fb-root"></div>
	<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=<?php echo get_option('fb_appid') ?>";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
	<?php
		endif;
	}
?>