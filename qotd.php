<?php

/*
Plugin Name: Qotd
Plugin URI: http://www.rhyme.it/projects/
Description: Add a random quotes/riddles/rhymes into your site.
Author: Carlo Baliello
Version: 1.0.1
License: GPL
Author URI: http://www.rhyme.it
*/ 

/*
------------------------------------------------------
 ACKNOWLEDGEMENTS 
------------------------------------------------------
The RSS-Feed code is a part of WP-RSSImport by Frank Bueltge, http://bueltge.de
------------------------------------------------------
*/

define('MAGPIE_CACHE_AGE', '60*60'); // in sec, one hour
define('MAGPIE_FETCH_TIME_OUT', 10);
define('MAGPIE_CACHE_ON', false); // Cache off
//error_reporting(E_ERROR);

// For function fetch_rss
if(file_exists(ABSPATH . WPINC . '/rss-functions.php')) {
	@require_once (ABSPATH . WPINC . '/rss-functions.php');
	// It's Wordpress 1.5.2 or 2.x. since it has been loaded successfully
} elseif (file_exists(ABSPATH . WPINC . '/rss.php')) {
	@require_once (ABSPATH . WPINC . '/rss.php');
	// In Wordpress 2.1, a new file name is being used
} else {
	die (__('Error in file: ' . __FILE__ . ' on line: ' . __LINE__ . '.<br />The Wordpress file "rss-functions.php" or "rss.php" could not be included.'));
}

// cache and error report
//
define('QOTD_MIN',  60);
define('QOTD_HOUR', QOTD_MIN*60);
define('QOTD_DAY',  QOTD_HOUR*24);
define('QOTD_WEEK', QOTD_DAY*7);

function fetch_qotd()
{
	$feedurl = get_option('qotd_provider');
	if ($feedurl == "")
		$feedurl = 	"http://www.quotedb.com/quote/quote.php?action=random_quote_rss&=&=&";		
	
	$truncatetitle = get_option('qotd_showTitle') == false;	
	 
	$display=99;
	$displaydescriptions=true;
	
	// read in file for search charset
	ini_set('default_socket_timeout', 120);
	$a = file_get_contents($feedurl);	
	
	$rss = fetch_rss($feedurl);		 
	
	$qotds = array();	

	if ($rss && !$rss->ERROR && is_array($rss->items)) 
	{
		// the follow print_r list all items in array
		//print_r($rss);		
		foreach ($rss->items as $item) 
		{
			$content = "";
			
			if ($display == 0) 
			{
				break;
			}
			
			$title   = $item['title'];
			$href    = $item['link'];
			// view date
			$pubDate = $item['pubdate'];
			$pubDate = substr($pubDate, 0, 25);			
			
			// Edit here:
			// For import with pure text
			$desc    = $item['description'];
						
			// For import with HTML
			//$desc    = $item['content']['encoded'];						
			
			if (eregi('encoding="ISO-8859-', $a)) 
			{
				isodec($title);
				isodec($desc);
			} else {
				utf8dec($title);
				utf8dec($desc);
			}
			$umlaute  = array('„','“','–',' \&#34;','&#8211;','&#8212;','&#8216;','&#8217;','&#8220;','&#8221;','&#8222;','&#8226;','&#8230;' ,'�'     ,'�'      ,'�'     ,'�'      ,'�'       ,'�'       ,'�'       ,'�'     ,'�'       ,'�'       ,'�'       ,'�'      ,'�'       ,'�'      ,'�'      ,'�'      ,'�'      ,'�'     ,'�'      ,'�'      ,'�'      ,'�'      ,'�'       ,'�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�',utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),utf8_encode('�'),chr(128),chr(129),chr(130),chr(131),chr(132),chr(133),chr(134),chr(135),chr(136),chr(137),chr(138),chr(139),chr(140),chr(141),chr(142),chr(143),chr(144),chr(145),chr(146),chr(147),chr(148),chr(149),chr(150),chr(151),chr(152),chr(153),chr(154),chr(155),chr(156),chr(157),chr(158),chr(159),chr(160),chr(161),chr(162),chr(163),chr(164),chr(165),chr(166),chr(167),chr(168),chr(169),chr(170),chr(171),chr(172),chr(173),chr(174),chr(175),chr(176),chr(177),chr(178),chr(179),chr(180),chr(181),chr(182),chr(183),chr(184),chr(185),chr(186),chr(187),chr(188),chr(189),chr(190),chr(191),chr(192),chr(193),chr(194),chr(195),chr(196),chr(197),chr(198),chr(199),chr(200),chr(201),chr(202),chr(203),chr(204),chr(205),chr(206),chr(207),chr(208),chr(209),chr(210),chr(211),chr(212),chr(213),chr(214),chr(215),chr(216),chr(217),chr(218),chr(219),chr(220),chr(221),chr(222),chr(223),chr(224),chr(225),chr(226),chr(227),chr(228),chr(229),chr(230),chr(231),chr(232),chr(233),chr(234),chr(235),chr(236),chr(237),chr(238),chr(239),chr(240),chr(241),chr(242),chr(243),chr(244),chr(245),chr(246),chr(247),chr(248),chr(249),chr(250),chr(251),chr(252),chr(253),chr(254),chr(255),chr(256));
			$htmlcode = array('&bdquo;','&ldquo;','&ndash;',' &#34;','&ndash;','&mdash;','&lsquo;','&rsquo;','&ldquo;','&rdquo;','&bdquo;','&bull;' ,'&hellip;','&euro;','&sbquo;','&fnof;','&bdquo;','&hellip;','&dagger;','&Dagger;','&circ;','&permil;','&Scaron;','&lsaquo;','&OElig;','&#x017D;','&lsquo;','&rsquo;','&ldquo;','&rdquo;','&bull;','&ndash;','&mdash;','&tilde;','&trade;','&scaron;','&rsaquo;','&oelig;','&#x017E;','&Yuml;','&iexcl;','&cent;','&pound;','&curren;','&yen;','&brvbar;','&sect;','&uml;','&copy;','&ordf;','&laquo;','&not;','&reg;','&macr;','&deg;','&plusmn;','&sup2;','&sup3;','&acute;','&micro;','&para;','&middot;','&cedil;','&supl;','&ordm;','&raquo;','&frac14;','&frac12;','&frac34;','&iquest;','&Agrave;','&Aacute;','&Acirc;','&Atilde;','&Auml;','&Aring;','&AElig;','&Ccedil;','&Egrave;','&Eacute;','&Ecirc;','&Euml;','&Igrave;','&Iacute;','&Icirc;','&Iuml;','&ETH;','&Ntilde;','&Ograve;','&Oacute;','&Ocirc;','&Otilde;','&Ouml;','&times;','&Oslash;','&Ugrave;','&Uacute;','&Ucirc;','&Uuml;','&Yacute;','&THORN;','&szlig;','&agrave;','&aacute;','&acirc;','&atilde;','&auml;','&aring;','&aelig;','&ccedil;','&egrave;','&eacute;','&ecirc;','&euml;','&igrave;','&iacute;','&icirc;','&iuml;','&eth;','&ntilde;','&ograve;','&oacute;','&ocirc;','&otilde;','&ouml;','&divide;','&oslash;','&ugrave;','&uacute;','&ucirc;','&uuml;','&yacute;','&thorn;','&yuml;','&euro;','&sbquo;','&fnof;','&bdquo;','&hellip;','&dagger;','&Dagger;','&circ;','&permil;','&Scaron;','&lsaquo;','&OElig;','&#x017D;','&lsquo;','&rsquo;','&ldquo;','&rdquo;','&bull;','&ndash;','&mdash;','&tilde;','&trade;','&scaron;','&rsaquo;','&oelig;','&#x017E;','&Yuml;','&iexcl;','&cent;','&pound;','&curren;','&yen;','&brvbar;','&sect;','&uml;','&copy;','&ordf;','&laquo;','&not;','&reg;','&macr;','&deg;','&plusmn;','&sup2;','&sup3;','&acute;','&micro;','&para;','&middot;','&cedil;','&supl;','&ordm;','&raquo;','&frac14;','&frac12;','&frac34;','&iquest;','&Agrave;','&Aacute;','&Acirc;','&Atilde;','&Auml;','&Aring;','&AElig;','&Ccedil;','&Egrave;','&Eacute;','&Ecirc;','&Euml;','&Igrave;','&Iacute;','&Icirc;','&Iuml;','&ETH;','&Ntilde;','&Ograve;','&Oacute;','&Ocirc;','&Otilde;','&Ouml;','&times;','&Oslash;','&Ugrave;','&Uacute;','&Ucirc;','&Uuml;','&Yacute;','&THORN;','&szlig;','&agrave;','&aacute;','&acirc;','&atilde;','&auml;','&aring;','&aelig;','&ccedil;','&egrave;','&eacute;','&ecirc;','&euml;','&igrave;','&iacute;','&icirc;','&iuml;','&eth;','&ntilde;','&ograve;','&oacute;','&ocirc;','&otilde;','&ouml;','&divide;','&oslash;','&ugrave;','&uacute;','&ucirc;','&uuml;','&yacute;','&thorn;','&yuml;','&euro;','','&sbquo;','&fnof;','&bdquo;','&hellip;','&dagger;','&Dagger;','&circ;','&permil;','&Scaron;','&lsaquo;','&OElig;','','&#x017D;','','','&lsquo;','&rsquo;','&ldquo;','&rdquo;','&bull;','&ndash;','&mdash;','&tilde;','&trade;','&scaron;','&rsaquo;','&oelig;','','&#x017E;','&Yuml;','&nbsp;','&iexcl;','&iexcl;','&iexcl;','&iexcl;','&yen;','&brvbar;','&sect;','&uml;','&copy;','&ordf;','&laquo;','&not;','�&shy;','&reg;','&macr;','&deg;','&plusmn;','&sup2;','&sup3;','&acute;','&micro;','&para;','&middot;','&cedil;','&supl;','&ordm;','&raquo;','&frac14;','&frac12;','&frac34;','&iquest;','&Agrave;','&Aacute;','&Acirc;','&Atilde;','&Auml;','&Aring;','&AElig;','&Ccedil;','&Egrave;','&Eacute;','&Ecirc;','&Euml;','&Igrave;','&Iacute;','&Icirc;','&Iuml;','&ETH;','&Ntilde;','&Ograve;','&Oacute;','&Ocirc;','&Otilde;','&Ouml;','&times;','&Oslash;','&Ugrave;','&Uacute;','&Ucirc;','&Uuml;','&Yacute;','&THORN;','&szlig;','&agrave;','&aacute;','&acirc;','&atilde;','&auml;','&aring;','&aelig;','&ccedil;','&egrave;','&eacute;','&ecirc;','&euml;','&igrave;','&iacute;','&icirc;','&iuml;','&eth;','&ntilde;','&ograve;','&oacute;','&ocirc;','&otilde;','&ouml;','&divide;','&oslash;','&ugrave;','&uacute;','&ucirc;','&uuml;','&yacute;','&thorn;','&yuml;');
			$title = str_replace($umlaute, $htmlcode, $title);
			$desc  = str_replace($umlaute, $htmlcode, $desc);
			
			if (!$truncatetitle) 
			{
				$content .= wptexturize('<a href="' . $href . '" title="'. ereg_replace("[^A-Za-z0-9 ]", "", $item['title']) . '">' . $title . '</a>');
			}					
			
			if ($displaydescriptions && $desc <> "") 			
			{ 
				$content .= wptexturize('<br />' . $desc );
			}
			$display--;	
			array_push($qotds, $content);		
		}
		
		$ran = rand(0, sizeof($qotds)-1);
		
		/// and the winner is...
		$content = $qotds[$ran];				
	} 
	else 
	{
		echo '<p>' . __('Error: Feed has a error or is not valid') . $rss->ERROR . '</p>';
		$content = "";
	}		
	
	return $content;	
}

function qotd_frequency()
{		
	$frequency = get_option('qotd_frequency');		
	
	if ($frequency == "")
	{
		$frequency = QOTD_DAY;    // Default daily				
	}
	
	return $frequency;
}

function qotd_expired($qotdTime)
{		
	$frequency = qotd_frequency();				
	
	return (time() - $qotdTime > $frequency);		
}

function Qotd() 
{			
	$qotd = "";
	$toFetch = true;		
				
	do
	{
		/// Fetch on save settings
		if (get_option('qotd_invalidate') == true)
		{			
			update_option('qotd_invalidate', false);
			break;
		}					
		
		$content = get_option('qotd_qotd');
		
		if ($content == "")
		{
			break;
		}
		
		$content = explode("\n", $content);
		
		if (count($content) < 2)
		{
			//echo 'Error on content!';
			break;
		}
			
		$qotdTime = $content[0];
		
		if (qotd_expired($qotdTime))
		{
			break;
		}
		
		$qotd = $content[1];
		
		$toFetch = false;		
		
	} while(false);
	
	if ($toFetch)
	{
		$qotd = fetch_qotd();
		
		/// Going to save for cache...
		if ($qotd != "")
		{						
			//echo "Caching ";			
			update_option('qotd_qotd', time()."\n".$qotd);
		}
	}			
	
	/// Enjoy :)
	echo '<div class="textwidget">' . $qotd . '</div><!--textwidget-->';
}

function utf8dec($s_String) {
	$s_String = html_entity_decode(htmlentities($s_String." ", ENT_COMPAT, 'UTF-8'));
	return substr($s_String, 0, strlen($s_String)-1);
}

function isodec($s_String) {
	$s_String = html_entity_decode(htmlentities($s_String." ", ENT_COMPAT, 'ISO-8859-1'));
	return substr($s_String, 0, strlen($s_String)-1);
}

function widget_qotd_init() {
	if (!function_exists('register_sidebar_widget')) return;

	function widget_qotd($args) 
	{
		extract($args);

		$options = get_option('widget_qotd');
		$title = $options['title'];
		
		echo $before_widget . $before_title . $title . $after_title;
		Qotd();
		echo $after_widget;
	}

	function widget_qotd_control() 
	{
		$options = get_option('widget_qotd');
		if ( !is_array($options) )
			$options = array('title'=>'');
		if ( $_POST['qotd-submit'] ) {
			$options['title'] = strip_tags(stripslashes($_POST['qotd-title']));
			update_option('widget_qotd', $options);
		}

		$title = htmlspecialchars($options['title'], ENT_QUOTES);
		
		echo '<p style="text-align:right;"><label for="qotd-title">Title: <input style="width: 200px;" id="gsearch-title" name="qotd-title" type="text" value="'.$title.'" /></label></p>';
		echo '<input type="hidden" id="qotd-submit" name="qotd-submit" value="1" />';
	}

	register_sidebar_widget('Qotd', 'widget_qotd');	
	register_widget_control('Qotd', 'widget_qotd_control', 300, 100);
}

function qotd_subpanel() 
{	                 
    
     if (isset($_POST['update_qotd'])) 
     {              
       update_option('qotd_frequency', $_POST['frequency']);       
       update_option('qotd_byU', $_POST['qotd_byU']);
       $showTitle = true;       
       if ($_POST['provider'] == "provide_by_you")
       {       	      
       	 $_POST['provider'] = $_POST['qotd_byU'];
       }
       else
       {
       	 $showTitle = $_POST['provider'][0] == '1';
       	 $_POST['provider'] = substr($_POST['provider'], 1);
       }
       update_option('qotd_provider', $_POST['provider']);
       update_option('qotd_showTitle', $showTitle);
       update_option('qotd_invalidate', true);       
       ?> <div class="updated"><p>Options changes saved.</p></div> <?php
     }               
     if (get_option('qotd_frequency') == "") update_option('qotd_frequency', 86400);          
	?>	

	<div class="wrap">
		<h2>Qotd Options</h2>
		<form method="post">
		
		<fieldset class="options">
		<table>				          
         <tr>
         <th scope="row" style="text-align: left; vertical-align: top;"><strong>Change quotations every:</strong></th>          
          <td>
          <select name="frequency" id="frequency">
        	  <!--<option <?php if(get_option('qotd_frequency') == 1) { echo 'selected'; } ?> value="1">second</option>-->
		      <option <?php if(get_option('qotd_frequency') == 60) { echo 'selected'; } ?> value="60">minute</option>
		      <option <?php if(get_option('qotd_frequency') == (60*60)) { echo 'selected'; } ?> value="3600">hour</option>
		      <option <?php if(get_option('qotd_frequency') == (60*60*24)) { echo 'selected'; } ?> value="86400">day</option>
		      <option <?php if(get_option('qotd_frequency') == (60*60*24*7)) { echo 'selected'; } ?> value="604800">week</option>		      
		  </select> 
		  <br/>
		  <em>Note: More frequency means more latency to load your site</em>       	
           </td> 
         </tr>         
         <tr> 
         <th scope="row" style="text-align: left; vertical-align: top;"><strong>Select the Provider:</strong></th>         
          <td>
          <ul style="list-style-type: none; padding-left: 0px; margin-left: 0px;">
          <?php
          $filename = get_option('siteurl').'/wp-content/plugins/qotd/provider.txt';
          $providers = file($filename);
          $oneSelected = false;
          foreach($providers as $provider)
          {
          	$provider = unserialize($provider);
          	$sayChecked = "";
          	if(get_option('qotd_provider') == $provider[rss]) 
          	{ 
          		$sayChecked = 'checked';
          		$oneSelected = true;	
          	}
          	echo "<li><input name=\"provider\" id=\"provider\" value=\"$provider[showTitle]$provider[rss]\" type=\"radio\" $sayChecked>\n";          	
          	echo "<label for=\"$provider[name]\">$provider[site]</label> <em>($provider[lang])</em> <em>(~ $provider[randomness])</em></li>\n";
          }
          $sayChecked = "";
          if (get_option('qotd_byU') != "" && !$oneSelected)
          {
          	$sayChecked = 'checked';                  	                  
          }          
          ?>
          <li><input name="provider" id="provider" value="provide_by_you" type="radio" <?php echo $sayChecked; ?>>		  
		  <input name="qotd_byU" id="qotd_byU" type="text" value="<?php echo get_option('qotd_byU'); ?>" size="30" />
		  <em>(custom)</em></li>		  	         		    
		  </ul>
		  <em>Note: The numeric value suggests the number of random quotes available per day.</em>		    		          	 	
           </td> 
         </tr>       
         </table>
        </fieldset>
		<p><div class="submit"><input type="submit" name="update_qotd" value="<?php _e('Update Options', 'update_qotd') ?>"  style="font-weight:bold;" /></div></p>
        </form>    
        If you want to add more providers to the above list, please <a href="mailto:carlo@rhyme.it">let me know</a>.   
    </div>

<?php } // end qotd_subpanel()

function qotd_admin_menu() 
{
   if (function_exists('add_options_page')) 
   {
        add_options_page('qotd Options Page', 'Qotd', 8, basename(__FILE__), 'qotd_subpanel');
   }
}

add_action('admin_menu', 'qotd_admin_menu'); 
add_action('plugins_loaded', 'widget_qotd_init');
?>
