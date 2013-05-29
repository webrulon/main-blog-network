<?php
/**
 * DSS Statistics
 * 
 * @package    WordPress
 * @subpackage DSS Statistics
 */


/**
 * DSS Statistics
 * 
 * @copyright Copyright (c), Metronet
 * @license http://www.gnu.org/licenses/gpl.html GPL
 * @author Ryan Hellyer <ryan@metronet.no>
 * @since 1.0
 */
class DSS_Statistics {

	/**
	 * Class constructor
	 * 
	 * Adds methods to appropriate hooks
	 * 
	 * @author Ryan Hellyer <ryan@metronet.no>
	 * @since 1.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'init',               array( $this, 'add_tracking_codes' ) );
	}

	/**
	 * Add tracking codes to pages
	 *
	 * @author Ryan Hellyer <ryan@metronet.no>
	 * @since 1.0
	 * @access public
	 */
	public function add_tracking_codes() {
		// Load tracking codes for non logged-in users
		if ( !is_user_logged_in() ) {
			add_action( 'wp_footer',          array( $this, 'webtrends' ) );

			add_action( 'wp_footer',          array( $this, 'pingdom' ) );
			add_action( 'admin_footer',       array( $this, 'pingdom' ) );
		}

		add_action( 'wp_footer',          array( $this, 'google_analytics' ) );
		add_action( 'admin_footer',       array( $this, 'google_analytics' ) );

	}

	/**
	 * Print Google Analytics script to page
	 *
	 * @author Ryan Hellyer <ryan@metronet.no>
	 * @since 1.0
	 * @access public
	 */
	public function google_analytics() {
		$script = "
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-10674541-3', 'regjeringen.no');
ga('set', 'anonymizeIp', true);
ga('send', 'pageview');
</script>\n";
		echo $script;
	}

	/**
	 * Print Pingdom script to page
	 *
	 * @author Ryan Hellyer <ryan@metronet.no>
	 * @since 1.0
	 * @access public
	 */
	public function pingdom() {
		$script = "
<script>
var _prum = [['id', '51875747abe53d065f000000'],
['mark', 'firstbyte', (new Date()).getTime()]];
(function() {
var s = document.getElementsByTagName('script')[0]
, p = document.createElement('script');
p.async = 'async';
p.src = '//rum-static.pingdom.net/prum.min.js';
s.parentNode.insertBefore(p, s);
})();
</script>\n";
		echo $script;
	}

	/**
	 * Print Webtrends scripts to page
	 *
	 * @author Ryan Hellyer <ryan@metronet.no>
	 * @since 1.0
	 * @access public
	 */
	public function webtrends() {
		$webtrends = '<script>
// WebTrends SmartSource Data Collector Tag v10.2.10
// Copyright (c) 2012 Webtrends Inc.  All rights reserved.
// Created: 120607 - support at arena dot no
window.webtrendsAsyncInit=function(){
    var dcs=new Webtrends.dcs().init({
        dcsid:"dcsxsbgdj1000047wsugprn0p_9h5v",
        domain:"sdc.arena.no",
        fpcdom:"",
        onsitedoms:"",
        timezone:1,
        adimpressions:true,
        adsparam:"WT.ac",
        paidsearchparams:"gclid",
        trimoffsiteparams:false,
        fpc:"WT_FPC",
        i18n:false,
        offsite:true,
        anchor:true,
        javascript:true,
        download:true,
        rightclick:true,
	downloadtypes:"xls,doc,pdf,txt,csv,zip,ini,exe,pps,ppt,bat,mov,avi,wma,wmv,mp3,dot,docx,xlsx,ppsx,pptx,sdv,jpg,rar,gzip",
        enabled:true
        }).track();
};
(function(){
    var s=document.createElement("script"); s.async=true; s.src="' . DSSSTATS_URL . '/js/webtrends-120601.js";    
    var s2=document.getElementsByTagName("script")[0]; s2.parentNode.insertBefore(s,s2);
}());
</script>';

		echo $webtrends;
	}

}
