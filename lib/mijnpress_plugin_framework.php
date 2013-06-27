<?php
/**
 * @author    Ramon Fincken http://www.mijnpress.nl
 * 
 * Feel free to use the framework file included in this plugin.
 * It is open source and free to use.
 * 
 * ------------------------------------------------------------------
 * 
 * Example class to create your own framework:
 * 
 * 
 * // @author Yourname http://yoururl
 * class my_framework extends mijnpress_plugin_framework
 * {
 * 
 * }
 * 
 * For more info visit http://www.mijnpress.nl/blog/plugin-framework/
 * ------------------------------------------------------------------
 * 
 * Version info
 * 1.0
 * First release
 * Submenu, credits, get plugin url, show main/sidebar
 * 
 * 
 * 1.3.1
 * Modified: addPluginSubMenu
 * Added: New plugins
 * 
 * 1.3.2
 * Added: New plugins
 * 
 * 1.3.3
 * Added: Plugin support url
 * 
 * 1.4
 * Changed: is_admin as this gives problems on multisite installs
 * 
 * 1.4.1
 * Added: New plugins
 * 
 * 1.5
 * Changed: credits
 * 
 * 1.5.1
 * Added: return functions
 * ------------------------------------------------------------------
 * 
 */

/**
* Base class for plugin framework usage, backend-/gui-based.
* @author     Ramon Fincken, http://www.mijnpress.nl
*/
class mijnpress_plugin_framework
{
    var $showcredits = true;
    var $showcredits_fordevelopers = true;
    var $all_plugins = array('Admin renamer extended','Find replace','Simple add pages or posts','Force apply terms and conditions','GTmetrix website performance','Antispam for all fields','Mass Delete Tags','Auto Prune Posts','Warm cache','See attachments','Automatic Comment Scheduler','Register plus redux export users','Subscribe2 widget','Define Constants','Mass Delete Unused Tags','Prevent core update','WPML flag in menu', 'WPsc MijnPress','Autoptimize admin bar fix');
    
    /**
     * Left menu display in Plugin menu
     * @author     Ramon Fincken
	 * 
	 * DEPRECATED, do not use
     */
    function addPluginSubMenu($title, $function, $file, $capability = 10, $where = "plugins.php")
    {
    	add_submenu_page($where, $title, $title, $capability, $file, $function);
    }

    /**
    * Extra info at plugin page
    * @author     Ramon Fincken
    */
    function addPluginContent($filename,$links, $file, $config_url = NULL)
    {
        if($file == $filename)    
        {
            if($config_url) $links[] = '<a href="'.$config_url.'">' . __('Settings') . '</a>';
            $links[] = '<a href="http://donate.ramonfincken.com">' . __('Donate') . '</a>';
            $links[] = '<a href="http://pluginsupport.mijnpress.nl">' . __('Support') . '</a>';
            $links[] = '<a href="http://www.mijnpress.nl">' . __('Custom WordPress coding nodig?') . '</a>';
        }
        return $links;
    }
    
    // To implement later
    function refresh_rewrite()
    {
    	if(isset($_GET['rwflush']))
		{
			global $wp_rewrite;
			$wp_rewrite->flush_rules();
		}    	
    }

    /**
     * Checks if user is admin
     */
	function is_admin()
	{
		require_once(ABSPATH . WPINC . '/pluggable.php');
		
		if(is_multisite())
		{
			return is_super_admin();
		}		
		else
		{
			return current_user_can('manage_options');
		}
	}	

    /**
     * Show default message as infobox
     * @author     Ramon Fincken
     * @param $msg
     * @return void
     */
    function show_message($msg)
    {
        echo '<div id="message" class="updated fade" style="margin: 10px 0; padding: 0 10px;">';
        echo $msg;
        echo '</div>';
    }

    /**
     * Start main div for plugin page
     * @author     Ramon Fincken
     * @return void
     */
    function content_start()
    {
        //echo '<div style="width:75%; float: left;">';
    }

    /**
     * End main div for plugin page, show sidebar div with credits
     * @author     Ramon Fincken
     * @return void
     */
    function content_end()
    {
    	/*
        if($this->showcredits)
        {
        	echo '<br/><br/>Do you like this plugin? <a href="http://donate.ramonfincken.com/">PayPal Donations</a> (even as small as $1,- or &euro;1,)- are welcome!.';
        }
        echo '</div>';
		*/
        echo '<div style="width:22%; float: right; margin-right: 10px; margin-top: 10px;">';
        $this->showcredits();
        echo '</div>';
        
        echo '<div style="clear: both;"></div>';
    }

    function return_zero()
    {
    	return 0;
    }
    
    function return_false()
    {
    	return false;
    }
    
    function return_true()
    {
    	return true;
    }    
    
    /**
     * Shows credits or info for developers
     * @author     Ramon Fincken
     * @return void
     */
    function showcredits()
    {
        if($this->showcredits)
        {
            mijnpress_plugin_framework_showcredits($this->plugin_title,$this->all_plugins);
        }
        if($this->showcredits_fordevelopers)
        {
            mijnpress_plugin_framework_showcredits_framework();
        }
        
    }

    /**
     * Generating the url for current Plugin
     *
     * @param String $path
     * @return String
     */
    function get_plugin_url($path = '',$file = __FILE__) {
       global $wp_version;

       if (version_compare($wp_version, '2.8', '<')) { // Using WordPress 2.7
          $folder = dirname(plugin_basename($file));
          if ('.' != $folder)
         $path = path_join(ltrim($folder, '/'), $path);
          return plugins_url($path);
       }
       return plugins_url($path, $file);
    }
}




// Keep these functions below class because we use plain HTML in PHP, and it is ugly


function mijnpress_plugin_framework_showcredits_framework()
{
?>
    <div class="postbox">
        <h3 class="hndle" style="padding: 10px;"><span>Are you a developer?</span></h3>
        <div class="inside">
            Feel free to use the framework file included in this plugin.<br>
            It is open source and free to use.<br/>
            For more info visit <a href="http://www.mijnpress.nl/blog/plugin-framework/">MijnPress.nl/blog/plugin-framework</a>
        </div>
    </div>
<?php    
} // end mijnpress_plugin_framework_showcredits_framework()


function mijnpress_plugin_framework_showcredits($plugin_title,$all_plugins)
{
?>
    <div class="postbox">
        <h3 class="hndle" style="padding: 10px;"><span>About <?php echo $plugin_title; ?></span></h3>
        <div class="inside">
            This plugin was created by Ramon Fincken.<br><br/>
            
He likes to create WordPress websites and plugins (currently only Dutch customers) and he is co-admin at the <a href="http://www.linkedin.com/groups?about=&gid=1644947&trk=anet_ug_grppro">Dutch LinkedIn WordPress group</a>.<br/><br/>Visit his WordPress website at: <a href="http://www.mijnpress.nl">MijnPress.nl</a><br/>
If you are a coder, you might like to visit <a href="http://www.ramonfincken.com/tag/wordpress.html">his WordPress blogposts</a>.
<br/><br/>
			 <strong>
			 	Additional coding by
			 	<br/>
			 	<a href="http://khromov.wordpress.com/about/">Stanislav Khromov</a>
			 </strong>
			 <br/><br/>
	
			<a href="http://pluginsupport.mijnpress.nl">Is this plugin broken? Report it here</a>            
        </div>
    </div>
<?php 
if(is_array($all_plugins) && count($all_plugins) > 0)
{
?>

    <div class="postbox">
        <h3 class="hndle" style="padding: 10px;"><span>More Plugins</span></h3>
        <div class="inside">
            If you like this plugin, you may also like:<br/>
<ul>

<?php
sort($all_plugins);
foreach($all_plugins as $plugin)
{
    if($plugin != $plugin_title)
    {
        $url = 'http://wordpress.org/extend/plugins/'.str_replace(' ','-',$plugin);
        echo '<li><a href="'.strtolower($url).'/">'.$plugin.'</a></li>';
    }
}
?>
</ul>
        </div>
    </div>
<?php    
} // end if(is_array($all_plugins) && count($all_plugins) > 0)
} // end mijnpress_plugin_framework_showcredits($plugin_title,$all_plugins)
?>