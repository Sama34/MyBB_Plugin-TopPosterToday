<?php
/* 
* MyBB: Top Posters Today 
* 
* File: tpt.php 
* 
* Authors: GiboneKPL & Vintagedaddyo 
* 
* MyBB Version: 1.8 
* 
* Plugin Version: 1.0.1
* 
*/

// Access

if(!defined('IN_MYBB'))
	die('This file cannot be accessed directly.');

// Add hooks

$plugins->add_hook("index_end", "tpt_show");

$plugins->add_hook("portal_end", "tpt_show"); 

// Plugin information

function tpt_info()
{
	
    global $lang, $db, $mybb;
    
// Localization  
  
	$lang->load("tpt");
	
$lang->desc = '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="float:right;">' .
        '<input type="hidden" name="cmd" value="_s-xclick">' . 
        '<input type="hidden" name="hosted_button_id" value="AZE6ZNZPBPVUL">' .
        '<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">' .
        '<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">' .
        '</form>' . $lang->desc;
        	
	return array(
		"name"		=> $lang->name,
		"description"		=> $lang->desc,
		"website"		=> "http://www.mybboad.pl",
		"author"		=> "GiboneKPL & Vintagedaddyo",
		"authorsite"		=> "http://www.rashownia.pl",
		"version"		=> "1.0.1",
		"guid" 			=> "*",
		"compatibility"	=> "18*"
		);
}

// Installation

function tpt_install()
{
	
	global $mybb, $db, $lang;

// Localization  
	
	$lang->load("tpt");

	// Setting group
	
	$settinggroups = array(
		'name' 			=> 'tpt', 
		'title' 		=> $db->escape_string($lang->name),
		'description' 	=> $db->escape_string($lang->settings_desc),
		'disporder' 	=> '100', 
		'isdefault' 	=> '0'
	);
	
	$gid = $db->insert_query("settinggroups", $settinggroups);
	
	$disporder = '0';

// Setting 1

	$setting = array(
		"sid"					=> "0",
		"name"			=> "tptlimit",
		"title"			=> $db->escape_string($lang->settings_limit),
		"description"	=> $db->escape_string($lang->settings_limit_desc),
		"optionscode"	=> "text",
		"value"			=> '9',
		"disporder"		=> $disporder++,
		"gid"					=> $gid
	);
	
	$db->insert_query("settings", $setting);

// Setting 2
	
	$setting = array(
		"sid"					=> "0",
		"name"			=> "tptignoregid",
		"title"			=> $db->escape_string($lang->settings_ignore_gid),
		"description"	=> $db->escape_string($lang->settings_ignore_gid_desc),
		"optionscode"	=> "text",
		"value"			=> '5,7',
		"disporder"		=> $disporder++,
		"gid"					=> $gid
	);
	
	$db->insert_query("settings", $setting);

// Setting 3
	
	$setting = array(
		"sid"					=> "0",
		"name"			=> "tptignorefid",
		"title"			=> $db->escape_string($lang->settings_ignore_fid),
		"description"	=> $db->escape_string($lang->settings_ignore_fid_desc),
		"optionscode"	=> "text",
		"value"			=> '',
		"disporder"		=> $disporder++,
		"gid"					=> $gid
	);
	
	$db->insert_query("settings", $setting);

// Setting 4
	
	$setting = array(
		"sid"					=> "0",
		"name"			=> "tptcoll",
		"title"			=> $db->escape_string($lang->settings_collapse),
		"description"	=> $db->escape_string($lang->settings_collapse_desc),
		"optionscode"	=> "yesno",
		"value"			=> '1',
		"disporder"		=> $disporder++,
		"gid"			=> $gid
	);
	
	$db->insert_query("settings", $setting);

// Setting 5
	
	$setting = array(
		"sid"					=> "0",
		"name"			=> "tptenable",
		"title"			=> $db->escape_string($lang->settings_enable),
		"description"	=> $db->escape_string($lang->settings_enable_desc),
		"optionscode"	=> "yesno",
		"value"			=> '1',
		"disporder"		=> $disporder++,
		"gid"			=> $gid
	);
	
	$db->insert_query("settings", $setting);


// Setting 6
	
	$setting = array(
		"sid"					=> "0",
		"name"			=> "tptindex",
		"title"			=> $db->escape_string($lang->settings_index),
		"description"	=> $db->escape_string($lang->settings_index_desc),
		"optionscode"	=> "yesno",
		"value"			=> '1',
		"disporder"		=> $disporder++,
		"gid"			=> $gid
	);
	
	$db->insert_query("settings", $setting);

// Setting 7
	
	$setting = array(
		"sid"					=> "0",
		"name"			=> "tptportal",
		"title"			=> $db->escape_string($lang->settings_portal),
		"description"	=> $db->escape_string($lang->settings_portal_desc),
		"optionscode"	=> "yesno",
		"value"			=> '1',
		"disporder"		=> $disporder++,
		"gid"			=> $gid
	);
	
	$db->insert_query("settings", $setting);
			
	// Rebuild
	
	rebuild_settings(); 

// Template 1 A

	$template = array(
		"tid" 			=> "0",
		"title" 		=> "tptindex",
		"template"		=> $db->escape_string('<style type="text/css">
		#top_posters li {
text-align: center;
padding: 8px 0 0 0;
margin: 5px 0 0 0;
min-width: 80px;
height: 80px;
float: left;
font-size: 0.80em;
}

.list_content {
word-wrap: break-word;
}

.avatar{
margin-left:8px;
margin-top:1px;
margin-bottom:1px;
float:left;
}
</style>

		<table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder" style="clear: both; border-bottom-width: 1px;">
<tr>
<td class="thead" colspan="1">
{$collapse}
<strong>{$lang->name}</strong>
</td>

</tr>
<tr>
<tbody style="{$expdisplay}" id="post-today_e">
<td class="trow1">
<ol id="top_posters" style="list-style: none; padding: 0; margin: 0;">
{$tpt_row}
</ol>
</td>
</tr>
</tbody></table><br />'),
		"sid" 			=> "-1", 
		);
	    $db->insert_query("templates", $template);

// Template 1 B

	$template = array(
		"tid" 			=> "0",
		"title" 		=> "tptportal",
		"template"		=> $db->escape_string('<style type="text/css">
		#top_posters li {
text-align: center;
padding: 8px 0 0 0;
margin: 5px 0 0 0;
min-width: 80px;
height: 80px;
float: left;
font-size: 0.80em;
}

.list_content {
word-wrap: break-word;
}

.avatar{
margin-left:8px;
margin-top:1px;
margin-bottom:1px;
float:left;
}
</style>

		<table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder" style="clear: both; border-bottom-width: 1px;">
<tr>
<td class="thead" colspan="1">
{$collapse}
<strong>{$lang->name}</strong>
</td>

</tr>
<tr>
<tbody style="{$expdisplay}" id="post-today_e">
<td class="trow1">
<ol id="top_posters" style="list-style: none; padding: 0; margin: 0;">
{$tpt_row}
</ol>
</td>
</tr>
</tbody></table><br />'),
		"sid" 			=> "-1", 
		);
	    $db->insert_query("templates", $template);

// Template 2

	$template = array(
		"tid" 			=> "0",
		"title" 		=> "tpt_row",
		"template"		=> $db->escape_string('<li>
<img src="{$tpt[\'avatar\']}" class ="avatar" width="50px" height="50px"/><br />
<span class="name">{$tpt[\'profilelink\']} ({$posts})</span>
</li>'),
        "sid" 			=> "-1", 
		);
	    $db->insert_query("templates", $template);

// Template 3

	$template = array(
		"tid" 			=> "0",
		"title" 		=> "tpt_none",
		"template"		=> $db->escape_string('<span style="text-align: center;">
{$lang->none}
</span>'),
        "sid" 			=> "-1", 
		);
	    $db->insert_query("templates", $template);
	    
            // Template inserts insert

            include MYBB_ROOT . "/inc/adminfunctions_templates.php";
            
            find_replace_templatesets("portal", "#" . preg_quote("{\$latestthreads}") . "#i", "{\$latestthreads}\r\n{\$tptportal}");

            find_replace_templatesets("index", "#" . preg_quote("{\$boardstats}") . "#i", "{\$tptindex}\r\n{\$boardstats}");
	    
}

// Is installed

function tpt_is_installed()
{
	
    global $db, $lang, $mybb;

// Localization  

	$lang->load("tpt");
	
	$q = $db->simple_select('settinggroups', '*', 'name=\'tpt\'');
	$group = $db->fetch_array($q);
	if($group === 0 || empty($group))
	return false;
	return true;
	
}

// Uninstallation

function tpt_uninstall()
{
	
	global $mybb, $db, $lang;

// Localization  

	$lang->load("tpt");
		$db->delete_query("settinggroups", "name = 'tpt'");
		
	$db->delete_query('settings', 'name LIKE \'%tpt%\'');
	
	$db->delete_query('templates', 'title LIKE (\'%tpt%\')');

	$db->delete_query('templates', 'title LIKE (\'%tptindex%\')');

	$db->delete_query('templates', 'title LIKE (\'%tptportal%\')');
		
        // Template inserts remove

        include MYBB_ROOT . "/inc/adminfunctions_templates.php";
  
        find_replace_templatesets("portal", "#" . preg_quote("\r\n{\$tptportal}") . "#i", "", 0);
        
        find_replace_templatesets("index", "#" . preg_quote("{\$tptindex}\r\n") . "#i", "", 0);  
              
        
} 

// Display

function tpt_show()
{
	
	global $db, $mybb, $page, $tptindex, $tptportal, $theme, $templates, $lang;

// Localization  

    $lang->load("tpt");
 
if($mybb->settings['tptenable'] == '1')
{        	      
    	
	$ignore_groups = $mybb->settings['tptignoregid'];
    if($ignore_groups == '')
    {
    	
            $ignore_groups = '9999999';
            
    }
    
	$ignore_forums = $mybb->settings['tptignorefid'];
	
    if($ignore_forums == '')
    {
    	
            $ignore_forums = '9999999';
            
    }
	
	    $todaytime = TIME_NOW - 86400;
	
        $query = $db->query("
			SELECT u.uid,u.username,u.displaygroup,u.usergroup,u.avatar, COUNT(*) AS ptoday 
			FROM ".TABLE_PREFIX."posts p 
			LEFT JOIN ".TABLE_PREFIX."users u ON (p.uid=u.uid) 
			WHERE p.dateline > $todaytime AND usergroup NOT IN(".$ignore_groups.") AND fid NOT IN(".$ignore_forums.")
			GROUP BY p.uid 
			ORDER BY ptoday 
			DESC LIMIT 0, ".$mybb->settings['tptlimit']."");
				
	    if($db->num_rows($query) == 0) 
		{
			
	     eval("\$tpt_row.= \"".$templates->get("tpt_none")."\";");
	     
	    }
		
        while($row = $db->fetch_array($query))
        {
        	
            $posts = $row['ptoday'];
            
            $tpt['avatar'] = $row['avatar'];
         if(strlen($row['username']) > 6)
         {
         	
            $row['username'] = substr($row['username'], 0, 6)."...";
            
         }
         
         else
         {
         	
            $row['username']  = $row['username'];
            
         }
         
            $tpt['username'] = format_name($row['username'], $row['usergroup'], $row['displaygroup']);
            
            $tpt['profilelink'] = build_profile_link($tpt['username'], $row['uid']);
            
			
            eval('$tpt_row .= "'.$templates->get("tpt_row").'";');
            
        } 
        
		// Collapse table
		
		if($mybb->settings['tptcoll'] == '1')
		{
			
		$collapse = '<div class="expcolimage"><img src="'.$theme['imgdir'].'/collapse.png" id="post-today_img" class="expander" alt="{$expaltext}" title="{$expaltext}" /></div>';
		
  } 

if($mybb->settings['tptindex'] == '1')
		{        	     
	eval('$tptindex = "'.$templates->get('tptindex').'";');
	 }	 
	 	 
if($mybb->settings['tptportal'] == '1')
		{        	     
	eval('$tptportal = "'.$templates->get('tptportal').'";');
	 }	 
	 
}
	 	 
}

?>