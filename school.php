<?php
class Calendar {  
     
    /**
     * Constructor
     */
    public function __construct(){     
        $this->naviHref = htmlentities($_SERVER['PHP_SELF']);
    }
     
    /********************* PROPERTY ********************/  
    private $dayLabels = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");
     
    private $currentYear=0;
     
    private $currentMonth=0;
     
    private $currentDay=0;
     
    private $currentDate=null;
     
    private $daysInMonth=0;
     
    private $naviHref= null;
     
    /********************* PUBLIC **********************/  
        
    /**
    * print out the calendar
    */
    public function show() {
        $year  = null;
         
        $month = null;
         
        if(null==$year&&isset($_GET['year'])){
 
            $year = $_GET['year'];
         
        }else if(null==$year){
 
            $year = date("Y",time());  
         
        }          
         
        if(null==$month&&isset($_GET['month'])){
 
            $month = $_GET['month'];
         
        }else if(null==$month){
 
            $month = date("m",time());
         
        }                  
         
        $this->currentYear=$year;
         
        $this->currentMonth=$month;
         
        $this->daysInMonth=$this->_daysInMonth($month,$year);  
         
        $content='<div id="calendar">'.
                        '<div class="box">'.
                        $this->_createNavi().
                        '</div>'.
                        '<div class="box-content">'.
                                '<ul class="label">'.$this->_createLabels().'</ul>';   
                                $content.='<div class="clear"></div>';     
                                $content.='<ul class="dates">';    
                                 
                                $weeksInMonth = $this->_weeksInMonth($month,$year);
                                // Create weeks in a month
                                for( $i=0; $i<$weeksInMonth; $i++ ){
                                     
                                    //Create days in a week
                                    for($j=1;$j<=7;$j++){
                                        $content.=$this->_showDay($i*7+$j);
                                    }
                                }
                                 
                                $content.='</ul>';
                                 
                                $content.='<div class="clear"></div>';     
             
                        $content.='</div>';
                 
        $content.='</div>';
        return $content;   
    }
     
    /********************* PRIVATE **********************/ 
    /**
    * create the li element for ul
    */
    private function _showDay($cellNumber){
         
        if($this->currentDay==0){
             
            $firstDayOfTheWeek = date('N',strtotime($this->currentYear.'-'.$this->currentMonth.'-01'));
                     
            if(intval($cellNumber) == intval($firstDayOfTheWeek)){
                 
                $this->currentDay=1;
                 
            }
        }
         
        if( ($this->currentDay!=0)&&($this->currentDay<=$this->daysInMonth) ){
             
            $this->currentDate = date('Y-m-d',strtotime($this->currentYear.'-'.$this->currentMonth.'-'.($this->currentDay)));
             
            $cellContent = $this->currentDay;
             
            $this->currentDay++;   
             
        }else{
             
            $this->currentDate =null;
 
            $cellContent=null;
        }
             
         
        return '<li id="li-'.$this->currentDate.'" class="'.($cellNumber%7==1?' start ':($cellNumber%7==0?' end ':' ')).
                ($cellContent==null?'mask':'').'">'.$cellContent.'</li>';
    }
     
    /**
    * create navigation
    */
    private function _createNavi(){
         
        $nextMonth = $this->currentMonth==12?1:intval($this->currentMonth)+1;
         
        $nextYear = $this->currentMonth==12?intval($this->currentYear)+1:$this->currentYear;
         
        $preMonth = $this->currentMonth==1?12:intval($this->currentMonth)-1;
         
        $preYear = $this->currentMonth==1?intval($this->currentYear)-1:$this->currentYear;
         
        return
            '<div class="header">'.
                '<a class="prev" href="'.$this->naviHref.'?month='.sprintf('%02d',$preMonth).'&year='.$preYear.'">Prev</a>'.
                    '<span class="title">'.date('Y M',strtotime($this->currentYear.'-'.$this->currentMonth.'-1')).'</span>'.
                '<a class="next" href="'.$this->naviHref.'?month='.sprintf("%02d", $nextMonth).'&year='.$nextYear.'">Next</a>'.
            '</div>';
    }
         
    /**
    * create calendar week labels
    */
    private function _createLabels(){  
                 
        $content='';
         
        foreach($this->dayLabels as $index=>$label){
             
            $content.='<li class="'.($label==6?'end title':'start title').' title">'.$label.'</li>';

        if($this->currentDate == date('Y-m-d'))
        {

        $finalDisplay.= ''.$cellContent.'';

         }
 
        }

         
        return $content;
    }
     
     
     
    /**
    * calculate number of weeks in a particular month
    */
    private function _weeksInMonth($month=null,$year=null){
         
        if( null==($year) ) {
            $year =  date("Y",time()); 
        }
         
        if(null==($month)) {
            $month = date("m",time());
        }
         
        // find number of days in this month
        $daysInMonths = $this->_daysInMonth($month,$year);
         
        $numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);
         
        $monthEndingDay= date('N',strtotime($year.'-'.$month.'-'.$daysInMonths));
         
        $monthStartDay = date('N',strtotime($year.'-'.$month.'-01'));
         
        if($monthEndingDay<$monthStartDay){
             
            $numOfweeks++;
         
        }
         
        return $numOfweeks;
    }
 
    /**
    * calculate number of days in a particular month
    */
    private function _daysInMonth($month=null,$year=null){
         
        if(null==($year))
            $year =  date("Y",time()); 
 
        if(null==($month))
            $month = date("m",time());
             
        return date('t',strtotime($year.'-'.$month.'-01'));
    }

    
     
}






?>

<!DOCTYPE html>
<html lang="en-US">
<head>
   <style type="text/css">
   	/*******************************Calendar Top Navigation*********************************/
div#calendar{
  margin:0px auto;
  padding:0px;
  width: 602px;
  font-family:Helvetica, "Times New Roman", Times, serif;
}
 
div#calendar div.box{
    position:relative;
    top:0px;
    left:0px;
    width:100%;
    height:40px;
    background-color:   #787878 ;      
}
 
div#calendar div.header{
    line-height:40px;  
    vertical-align:middle;
    position:absolute;
    left:11px;
    top:0px;
    width:582px;
    height:40px;   
    text-align:center;
}
 
div#calendar div.header a.prev,div#calendar div.header a.next{ 
    position:absolute;
    top:0px;   
    height: 17px;
    display:block;
    cursor:pointer;
    text-decoration:none;
    color:#FFF;
}
 
div#calendar div.header span.title{
    color:#FFF;
    font-size:18px;
}
 
 
div#calendar div.header a.prev{
    left:0px;
}
 
div#calendar div.header a.next{
    right:0px;
}
 
 
 
 
/*******************************Calendar Content Cells*********************************/
div#calendar div.box-content{
    border:1px solid #787878 ;
    border-top:none;
}
 
 
 
div#calendar ul.label{
    float:left;
    margin: 0px;
    padding: 0px;
    margin-top:5px;
    margin-left: 5px;
}
 
div#calendar ul.label li{
    margin:0px;
    padding:0px;
    margin-right:5px;  
    float:left;
    list-style-type:none;
    width:80px;
    height:40px;
    line-height:40px;
    vertical-align:middle;
    text-align:center;
    color:#000;
    font-size: 15px;
    background-color: transparent;
}
 
 
div#calendar ul.dates{
    float:left;
    margin: 0px;
    padding: 0px;
    margin-left: 5px;
    margin-bottom: 5px;
}
 
/** overall width = width+padding-right**/
div#calendar ul.dates li{
    margin:0px;
    padding:0px;
    margin-right:5px;
    margin-top: 5px;
    line-height:80px;
    vertical-align:middle;
    float:left;
    list-style-type:none;
    width:80px;
    height:52px;
    font-size:18px;
    background-color: #DDD;
    color:#000;
    text-align:center; 
}
 
:focus{
    outline:none;
}
 
div.clear{
    clear:both;
}     











   	
   </style>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>  
    
  <!-- Title Tag -->
  <title>Wow</title>
  
  
  <!-- Favicon -->
    <link rel="shortcut icon" href=""/>
  
  <!-- Main CSS -->
  <link rel="stylesheet" type="text/css" href="https://www.riaraschools.ac.ke/wp-content/themes/riara/style.css" />
  
    
  <!-- Google Webfont Files     -->
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic" type="text/css"/>
        
  <link rel='dns-prefetch' href='//fonts.googleapis.com' />
<link rel='dns-prefetch' href='//s.w.org' />
<link rel="alternate" type="application/rss+xml" title="Riara Group of Schools &raquo; Feed" href="" />
<link rel="alternate" type="application/rss+xml" title="Riara Group of Schools &raquo; Comments Feed" href="" />
<link rel="alternate" type="text/calendar" title="Riara Group of Schools &raquo; iCal Feed" href="" />
<link rel="alternate" type="application/rss+xml" title="Riara Group of Schools &raquo; Events Feed" href="" />
        <script type="text/javascript">
            window._wpemojiSettings = {"baseUrl":"https:\/\/s.w.org\/images\/core\/emoji\/11\/72x72\/","ext":".png","svgUrl":"https:\/\/s.w.org\/images\/core\/emoji\/11\/svg\/","svgExt":".svg","source":{"concatemoji":"https:\/\/www.riaraschools.ac.ke\/wp-includes\/js\/wp-emoji-release.min.js?ver=4.9.14"}};
            !function(a,b,c){function d(a,b){var c=String.fromCharCode;l.clearRect(0,0,k.width,k.height),l.fillText(c.apply(this,a),0,0);var d=k.toDataURL();l.clearRect(0,0,k.width,k.height),l.fillText(c.apply(this,b),0,0);var e=k.toDataURL();return d===e}function e(a){var b;if(!l||!l.fillText)return!1;switch(l.textBaseline="top",l.font="600 32px Arial",a){case"flag":return!(b=d([55356,56826,55356,56819],[55356,56826,8203,55356,56819]))&&(b=d([55356,57332,56128,56423,56128,56418,56128,56421,56128,56430,56128,56423,56128,56447],[55356,57332,8203,56128,56423,8203,56128,56418,8203,56128,56421,8203,56128,56430,8203,56128,56423,8203,56128,56447]),!b);case"emoji":return b=d([55358,56760,9792,65039],[55358,56760,8203,9792,65039]),!b}return!1}function f(a){var c=b.createElement("script");c.src=a,c.defer=c.type="text/javascript",b.getElementsByTagName("head")[0].appendChild(c)}var g,h,i,j,k=b.createElement("canvas"),l=k.getContext&&k.getContext("2d");for(j=Array("flag","emoji"),c.supports={everything:!0,everythingExceptFlag:!0},i=0;i<j.length;i++)c.supports[j[i]]=e(j[i]),c.supports.everything=c.supports.everything&&c.supports[j[i]],"flag"!==j[i]&&(c.supports.everythingExceptFlag=c.supports.everythingExceptFlag&&c.supports[j[i]]);c.supports.everythingExceptFlag=c.supports.everythingExceptFlag&&!c.supports.flag,c.DOMReady=!1,c.readyCallback=function(){c.DOMReady=!0},c.supports.everything||(h=function(){c.readyCallback()},b.addEventListener?(b.addEventListener("DOMContentLoaded",h,!1),a.addEventListener("load",h,!1)):(a.attachEvent("onload",h),b.attachEvent("onreadystatechange",function(){"complete"===b.readyState&&c.readyCallback()})),g=c.source||{},g.concatemoji?f(g.concatemoji):g.wpemoji&&g.twemoji&&(f(g.twemoji),f(g.wpemoji)))}(window,document,window._wpemojiSettings);
        </script>
        <style type="text/css">
img.wp-smiley,
img.emoji {
    display: inline !important;
    border: none !important;
    box-shadow: none !important;
    height: 1em !important;
    width: 1em !important;
    margin: 0 .07em !important;
    vertical-align: -0.1em !important;
    background: none !important;
    padding: 0 !important;
}
</style>
<link rel='stylesheet' id='ppm-accordion-plugin-style-css'  href='https://www.riaraschools.ac.ke/wp-content/plugins/ppm-accordion/css/style.css?ver=4.9.14' type='text/css' media='all' />
<link rel='stylesheet' id='ai1ec_style-css'  href='//www.riaraschools.ac.ke/wp-content/plugins/all-in-one-event-calendar/cache/47204bf2_ai1ec_parsed_css.css?ver=2.5.32' type='text/css' media='all' />
<link rel='stylesheet' id='tribe-accessibility-css-css'  href='https://www.riaraschools.ac.ke/wp-content/plugins/the-events-calendar/common/src/resources/css/accessibility.min.css?ver=4.7.22' type='text/css' media='all' />
<link rel='stylesheet' id='tribe-events-full-calendar-style-css'  href='https://www.riaraschools.ac.ke/wp-content/plugins/the-events-calendar/src/resources/css/tribe-events-full.min.css?ver=4.6.25' type='text/css' media='all' />
<link rel='stylesheet' id='tribe-events-custom-jquery-styles-css'  href='https://www.riaraschools.ac.ke/wp-content/plugins/the-events-calendar/vendor/jquery/smoothness/jquery-ui-1.8.23.custom.css?ver=4.6.25' type='text/css' media='all' />
<link rel='stylesheet' id='tribe-events-bootstrap-datepicker-css-css'  href='https://www.riaraschools.ac.ke/wp-content/plugins/the-events-calendar/vendor/bootstrap-datepicker/css/bootstrap-datepicker.standalone.min.css?ver=4.6.25' type='text/css' media='all' />
<link rel='stylesheet' id='tribe-events-calendar-style-css'  href='https://www.riaraschools.ac.ke/wp-content/plugins/the-events-calendar/src/resources/css/tribe-events-theme.min.css?ver=4.6.25' type='text/css' media='all' />
<link rel='stylesheet' id='tribe-events-calendar-full-mobile-style-css'  href='https://www.riaraschools.ac.ke/wp-content/plugins/the-events-calendar/src/resources/css/tribe-events-full-mobile.min.css?ver=4.6.25' type='text/css' media='only screen and (max-width: 768px)' />
<link rel='stylesheet' id='tribe-events-calendar-mobile-style-css'  href='https://www.riaraschools.ac.ke/wp-content/plugins/the-events-calendar/src/resources/css/tribe-events-theme-mobile.min.css?ver=4.6.25' type='text/css' media='only screen and (max-width: 768px)' />
<link rel='stylesheet' id='default-icon-styles-css'  href='https://www.riaraschools.ac.ke/wp-content/plugins/svg-vector-icon-plugin/public/../admin/css/wordpress-svg-icon-plugin-style.min.css?ver=4.9.14' type='text/css' media='all' />
<link rel='stylesheet' id='tt-easy-google-fonts-css'  href='https://fonts.googleapis.com/css?family=Roboto%3A300%2Cregular%2C500&#038;subset=latin%2Call&#038;ver=4.9.14' type='text/css' media='all' />
<link rel='stylesheet' id='ubermenu-basic-css'  href='https://www.riaraschools.ac.ke/wp-content/plugins/ubermenu/styles/basic.css?ver=2.0.1.0' type='text/css' media='all' />
<link rel='stylesheet' id='ubermenu-blue-silver-css'  href='https://www.riaraschools.ac.ke/wp-content/plugins/ubermenu/styles/skins/bluesilver.css?ver=2.0.1.0' type='text/css' media='all' />
<script type='text/javascript' src='https://www.riaraschools.ac.ke/wp-includes/js/jquery/jquery.js?ver=1.12.4'></script>
<script type='text/javascript' src='https://www.riaraschools.ac.ke/wp-includes/js/jquery/jquery-migrate.min.js?ver=1.4.1'></script>
<script type='text/javascript' src='https://www.riaraschools.ac.ke/wp-content/plugins/ppm-accordion/js/ppm-accordion-main.js?ver=4.9.14'></script>
<script type='text/javascript' src='https://www.riaraschools.ac.ke/wp-content/plugins/the-events-calendar/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js?ver=4.6.25'></script>
<script type='text/javascript' src='https://www.riaraschools.ac.ke/wp-content/plugins/the-events-calendar/vendor/jquery-resize/jquery.ba-resize.min.js?ver=4.6.25'></script>
<script type='text/javascript' src='https://www.riaraschools.ac.ke/wp-content/plugins/the-events-calendar/vendor/jquery-placeholder/jquery.placeholder.min.js?ver=4.6.25'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var tribe_js_config = {"permalink_settings":"","events_post_type":"tribe_events","events_base":"https:\/\/www.riaraschools.ac.ke?post_type=tribe_events","debug":""};
/* ]]> */
</script>
<script type='text/javascript' src='https://www.riaraschools.ac.ke/wp-content/plugins/the-events-calendar/src/resources/js/tribe-events.min.js?ver=4.6.25'></script>
<script type='text/javascript' src='https://www.riaraschools.ac.ke/wp-content/plugins/the-events-calendar/vendor/php-date-formatter/js/php-date-formatter.min.js?ver=4.6.25'></script>
<script type='text/javascript' src='https://www.riaraschools.ac.ke/wp-content/plugins/the-events-calendar/common/vendor/momentjs/moment.min.js?ver=4.7.22'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var tribe_dynamic_help_text = {"date_with_year":"F j, Y","date_no_year":"F j","datepicker_format":"Y-m-d","datepicker_format_index":"0","days":["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],"daysShort":["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],"months":["January","February","March","April","May","June","July","August","September","October","November","December"],"monthsShort":["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],"msgs":"[\"This event is from %%starttime%% to %%endtime%% on %%startdatewithyear%%.\",\"This event is at %%starttime%% on %%startdatewithyear%%.\",\"This event is all day on %%startdatewithyear%%.\",\"This event starts at %%starttime%% on %%startdatenoyear%% and ends at %%endtime%% on %%enddatewithyear%%\",\"This event starts at %%starttime%% on %%startdatenoyear%% and ends on %%enddatewithyear%%\",\"This event is all day starting on %%startdatenoyear%% and ending on %%enddatewithyear%%.\"]"};
/* ]]> */
</script>
<script type='text/javascript' src='https://www.riaraschools.ac.ke/wp-content/plugins/the-events-calendar/src/resources/js/events-dynamic.min.js?ver=4.6.25'></script>
<script type='text/javascript' src='https://www.riaraschools.ac.ke/wp-content/plugins/the-events-calendar/src/resources/js/tribe-events-bar.min.js?ver=4.6.25'></script>
<script type='text/javascript' src='https://www.riaraschools.ac.ke/wp-content/themes/riara/js/jquery.cycle.all.js?ver=4.9.14'></script>
<script type='text/javascript' src='https://www.riaraschools.ac.ke/wp-content/themes/riara/js/jquery.easing.1.3.js?ver=4.9.14'></script>
<script type='text/javascript' src='https://www.riaraschools.ac.ke/wp-content/themes/riara/js/jquery.flexslider-min.js?ver=4.9.14'></script>
<script type='text/javascript' src='https://www.riaraschools.ac.ke/wp-content/themes/riara/js/jquery.fitvids.js?ver=4.9.14'></script>
<script type='text/javascript' src='https://www.riaraschools.ac.ke/wp-content/themes/riara/js/jquery.fancybox.js?ver=4.9.14'></script>
<script type='text/javascript' src='https://www.riaraschools.ac.ke/wp-content/themes/riara/js/jquery.tools.tabs.min.js?ver=4.9.14'></script>
<script type='text/javascript' src='https://www.riaraschools.ac.ke/wp-content/themes/riara/js/tinynav.min.js?ver=4.9.14'></script>
<script type='text/javascript' src='https://www.riaraschools.ac.ke/wp-content/themes/riara/js/jquery.elastislide.js?ver=4.9.14'></script>
<script type='text/javascript' src='https://www.riaraschools.ac.ke/wp-content/themes/riara/js/jquery.tweet.js?ver=4.9.14'></script>
<script type='text/javascript' src='https://www.riaraschools.ac.ke/wp-content/themes/riara/js/jquery.gmap.min.js?ver=4.9.14'></script>
<script type='text/javascript' src='https://www.riaraschools.ac.ke/wp-content/themes/riara/js/functions.js?ver=4.9.14'></script>
<link rel='https://api.w.org/' href='https://www.riaraschools.ac.ke/index.php?rest_route=/' />
<link rel="EditURI" type="application/rsd+xml" title="RSD" href="https://www.riaraschools.ac.ke/xmlrpc.php?rsd" />
<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="https://www.riaraschools.ac.ke/wp-includes/wlwmanifest.xml" /> 
<meta name="generator" content="WordPress 4.9.14" />
<meta name="tec-api-version" content="v1"><meta name="tec-api-origin" content="https://www.riaraschools.ac.ke"><link rel="https://theeventscalendar.com/" href="https://www.riaraschools.ac.ke/index.php?rest_route=/tribe/events/v1/" /><!-- Custom CSS -->
<style type="text/css">
#footer-border {
    /* height: 93px; */
    /* background: url(../images/skins/background-oblique2.png) no-repeat center; */
    margin-top: -5.5%;
    position: relative;
    z-index: 80;
}
.rssfade {
    position: relative;
    display: block;
    height: 26px;
    width: 26px;
    background: url(images/social-icons/rss.png) 0 0 no-repeat;
    visibility: hidden;
}

    body { background-image: none;}
    

</style><meta name="generator" content="Powered by Visual Composer - drag and drop page builder for WordPress."/>
<!--[if lte IE 9]><link rel="stylesheet" type="text/css" href="https://www.riaraschools.ac.ke/wp-content/plugins/js_composer/assets/css/vc_lte_ie9.min.css" media="screen"><![endif]--><style type="text/css" media="all">
/* <![CDATA[ */
@import url("https://www.riaraschools.ac.ke/wp-content/plugins/wp-table-reloaded/css/plugin.css?ver=1.9.4");
@import url("https://www.riaraschools.ac.ke/wp-content/plugins/wp-table-reloaded/css/datatables.css?ver=1.9.4");
/* ]]> */
</style> <meta name="robots" content="noindex,follow" />

<!-- UberMenu CSS - Controlled through UberMenu Options Panel 
================================================================ -->
<style type="text/css" id="ubermenu-style-generator-css">
/* Custom Tweaks - UberMenu Style Configuration Settings */
#mainmenu ul li a span {
    font-family: 'Roboto', sans-serif;
}   
</style>
<!-- end UberMenu CSS -->
        
            <style id="tt-easy-google-font-styles" type="text/css">p { font-family: 'Roboto'; font-size: 14px; font-style: normal; font-weight: 300; }
h1 { font-family: 'Roboto'; font-size: 15px; font-style: normal; font-weight: 300; }
h2 { font-family: 'Roboto'; font-style: normal; font-weight: 300; }
h3 { font-family: 'Roboto'; font-size: 19px; font-style: normal; font-weight: 400; }
h4 { font-family: 'Roboto'; font-style: normal; font-weight: 500; }
h5 { font-family: 'Roboto'; font-style: normal; font-weight: 300; }
h6 { font-family: 'Roboto'; font-style: normal; font-weight: 300; }
</style><noscript><style type="text/css"> .wpb_animate_when_almost_visible { opacity: 1; }</style></noscript>  
  </head>
<body class="archive post-type-archive post-type-archive-tribe_events tribe-no-js tribe-filter-live wpb-js-composer js-comp-ver-5.0.1 vc_responsive events-gridview events-archive tribe-events-style-full tribe-events-style-theme tribe-theme-riara page-template-fullwidth-php singular">
<div id="main-wrapper">

    <!-- begin of header area -->
    <div id="header-wrapper">
    
        <!-- begin of logo area -->
        <div id="logo">
                    <a href=""><img src="" alt="Logo"/></a>
        </div>
        <!-- end of logo area -->
        
        <!-- begin of mainmenu area -->
        <div id="mainmenu">
            <div id="megaMenu" class="megaMenuContainer megaMenu-nojs megaFullWidth wpmega-preset-blue-silver megaMenuHorizontal megaMenuOnHover wpmega-withjs wpmega-noconflict"><ul id="megaUber" class="megaMenu"><li id="menu-item-27" class="menu-item menu-item-type-custom menu-item-object-custom ss-nav-menu-item-0 ss-nav-menu-item-depth-0 ss-nav-menu-reg"><a href=""><span class="wpmega-link-title">HOME</span></a></li>
<li id="menu-item-196" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children ss-nav-menu-item-1 ss-nav-menu-item-depth-0 ss-nav-menu-reg"><a href=""><span class="wpmega-link-title">ABOUT</span></a>
<ul class="sub-menu sub-menu-1">
    <li id="menu-item-1433" class="menu-item menu-item-type-post_type menu-item-object-page ss-nav-menu-item-depth-1"><a href=""><span class="wpmega-link-title">ABOUT US</span></a></li>
    <li id="menu-item-197" class="menu-item menu-item-type-post_type menu-item-object-page ss-nav-menu-item-depth-1"><a href=""><span class="wpmega-link-title">TRANSPORT</span></a></li>
    <li id="menu-item-1168" class="menu-item menu-item-type-post_type menu-item-object-page ss-nav-menu-item-depth-1"><a href=""><span class="wpmega-link-title">SERVICES AND FACILITIES</span></a></li>
</ul>
</li>
<li id="menu-item-1242" class="menu-item menu-item-type-custom menu-item-object-custom ss-nav-menu-item-2 ss-nav-menu-item-depth-0 ss-nav-menu-reg"><a href=""><span class="wpmega-link-title">CALENDAR</span></a></li>
<li id="menu-item-29" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children ss-nav-menu-item-3 ss-nav-menu-item-depth-0 ss-nav-menu-reg"><a href="#"><span class="wpmega-link-title">SELECT LEVEL</span></a>
<ul class="sub-menu sub-menu-1">
    <li id="menu-item-30" class="menu-item menu-item-type-custom menu-item-object-custom ss-nav-menu-item-depth-1"><a href=""><span class="wpmega-link-title">KINDERGARTEN</span></a></li>
    <li id="menu-item-31" class="menu-item menu-item-type-custom menu-item-object-custom ss-nav-menu-item-depth-1"><a href=""><span class="wpmega-link-title">PRIMARY SCHOOL</span></a></li>
    <li id="menu-item-32" class="menu-item menu-item-type-custom menu-item-object-custom ss-nav-menu-item-depth-1"><a href=""><span class="wpmega-link-title">HIGH SCHOOL</span></a></li>
    <li id="menu-item-1165" class="menu-item menu-item-type-custom menu-item-object-custom ss-nav-menu-item-depth-1"><a href=""><span class="wpmega-link-title">INTERNATIONAL SCHOOL</span></a></li>
</ul>
</li>
<li id="menu-item-1205" class="menu-item menu-item-type-post_type menu-item-object-page ss-nav-menu-item-4 ss-nav-menu-item-depth-0 ss-nav-menu-reg"><a href=""><span class="wpmega-link-title">FEES</span></a></li>
<li id="menu-item-601" class="menu-item menu-item-type-post_type menu-item-object-page ss-nav-menu-item-5 ss-nav-menu-item-depth-0 ss-nav-menu-reg"><a href=""><span class="wpmega-link-title">DOWNLOADS</span></a></li>
<li id="menu-item-7597" class="menu-item menu-item-type-custom menu-item-object-custom ss-nav-menu-item-6 ss-nav-menu-item-depth-0 ss-nav-menu-reg"><a href=""><span class="wpmega-link-title">NEWS</span></a></li>
<li id="menu-item-394" class="menu-item menu-item-type-post_type menu-item-object-page ss-nav-menu-item-7 ss-nav-menu-item-depth-0 ss-nav-menu-reg"><a href=""><span class="wpmega-link-title">CAREERS</span></a></li>
<li id="menu-item-7595" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children ss-nav-menu-item-8 ss-nav-menu-item-depth-0 ss-nav-menu-reg"><a href="#"><span class="wpmega-link-title">CONTACTS</span></a>
<ul class="sub-menu sub-menu-1">
    <li id="menu-item-419" class="menu-item menu-item-type-post_type menu-item-object-page ss-nav-menu-item-depth-1"><a href=""><span class="wpmega-link-title">CONTACTS</span></a></li>
    <li id="menu-item-2430" class="menu-item menu-item-type-post_type menu-item-object-page ss-nav-menu-item-depth-1"><a href=""><span class="wpmega-link-title">ENQUIRY</span></a></li>
</ul>
</li>
</ul></div>        </div>
        <!-- end of header area -->
        
        <!-- begin of top social area -->
        <div id="top-social">
            <ul>
                              <li><a class="rssfade" href="#"><span>&nbsp;</span></a></li>
                                                            </ul>
        </div>
        <!-- end of top social area -->
        
    </div>
    <div id="bg-oblique"></div>
    <!-- end of header area -->    
    <!-- begin of pagetitle area -->
    <div id="pagetitle-container">
        <div class="row">
            <div class="grid_8">
                  <h2></h2>
                                  </div>
        
    <div class="grid_4">
                        <div id="search-box">
                <form id="search" action="" method="get" >
                    <fieldset class="search-fieldset">
                    <input type="text" id="s"  name="s" value="search here..." onBlur="if (this.value == ''){this.value = 'search here...'; }" onFocus="if (this.value == 'search here...') {this.value = ''; }"  />&nbsp;
                    <!-- <input type="image" alt="s-icon" class="go" src="https://www.riaraschools.ac.ke/wp-content/themes/riara/images/search-icon.gif" /> -->
                    </fieldset>                         
                </form>
              </div>    


        </div>
       </div>    
    </div>
    <div id="breadcumb">
        <div class="row">
          <div class="grid_12">
              <a href=""><img src="https://www.riaraschools.ac.ke/wp-content/themes/riara/images/home-icon.gif" alt="" class="bread-img" /></a> &raquo; <span class="bread-txt">Page</span>          </div>
        </div>
    </div>
    <!-- end of pagetitle area -->   
      
    <!-- begin of content area -->
    <div id="maincontent">
      <div class="row">
                          <div id="tribe-events" class="tribe-no-js" data-live_ajax="1" data-datepicker_format="0" data-category="" data-featured=""><div class="tribe-events-before-html"></div><span class="tribe-events-ajax-loading"><img class="tribe-events-spinner-medium" src="https://www.riaraschools.ac.ke/wp-content/plugins/the-events-calendar/src/resources/images/tribe-loading.gif" alt="Loading Events" /></span><div id="tribe-events-content-wrapper" class="tribe-clearfix"><input type="hidden" id="tribe-events-list-hash" value="">
<div class="tribe-events-title-bar">

    <!-- Month Title -->
        <h1 class="tribe-events-page-title">Events for  2020</h1>
    
</div>


<div id="tribe-events-bar">

    <h2 class="tribe-events-visuallyhidden">Events Search and Views Navigation</h2>

    <form id="tribe-bar-form" class="tribe-clearfix" name="tribe-bar-form" method="post" action="">

        <!-- Mobile Filters Toggle -->

        <div id="tribe-bar-collapse-toggle" >
            Find Events<span class="tribe-bar-toggle-arrow"></span>
        </div>

        <!-- Views -->
                    <div id="tribe-bar-views">
                <div class="tribe-bar-views-inner tribe-clearfix">
                    <h3 class="tribe-events-visuallyhidden">Event Views Navigation</h3>
                    <label>View As</label>
                    <select
                        class="tribe-bar-views-select tribe-no-param"
                        name="tribe-bar-view"
                        aria-label="View Events As"
                    >
                                                    <option
                                tribe-inactive                              value="https://www.riaraschools.ac.ke?post_type=tribe_events&amp;tribe_event_display=list"
                                data-view="list"
                            >
                                List                            </option>
                                                    <option
                                selected                                value="https://www.riaraschools.ac.ke?post_type=tribe_events&amp;tribe_event_display=month"
                                data-view="month"
                            >
                                Month                           </option>
                                                    <option
                                tribe-inactive                              value="https://www.riaraschools.ac.ke?post_type=tribe_events&amp;tribe_event_display=day"
                                data-view="day"
                            >
                                Day                         </option>
                                            </select>
                </div>
                <!-- .tribe-bar-views-inner -->
            </div><!-- .tribe-bar-views -->
        
                    <div class="tribe-bar-filters">
                <div class="tribe-bar-filters-inner tribe-clearfix">
                    <h3 class="tribe-events-visuallyhidden">Events Search</h3>
                                            <div class="tribe-bar-date-filter">
                            <label class="label-tribe-bar-date" for="tribe-bar-date">Events In</label>
                            <input type="text" name="tribe-bar-date" style="position: relative;" id="tribe-bar-date" aria-label="Search for Events by month. Please use the format 4 digit year hyphen 2 digit month." value="" placeholder="Date"><input type="hidden" name="tribe-bar-date-day" id="tribe-bar-date-day" class="tribe-no-param" value="">                      </div>
                                            <div class="tribe-bar-search-filter">
                            <label class="label-tribe-bar-search" for="tribe-bar-search">Search</label>
                            <input type="text" name="tribe-bar-search" id="tribe-bar-search" aria-label="Search for Events by Keyword." value="" placeholder="Keyword">                     </div>
                                        <div class="tribe-bar-submit">
                        <input
                            class="tribe-events-button tribe-no-param"
                            type="submit"
                            name="submit-bar"
                            aria-label="Submit Events search"
                            value="Find Events"
                        />
                    </div>
                    <!-- .tribe-bar-submit -->
                </div>
                <!-- .tribe-bar-filters-inner -->
            </div><!-- .tribe-bar-filters -->
        
    </form>
    <!-- #tribe-bar-form -->

</div><!-- #tribe-events-bar -->

<div id="tribe-events-content" class="tribe-events-month">

    <!-- Notices -->
    <div class="tribe-events-notices"><ul><li>There were no results found.</li></ul></div>
    <!-- Month Header -->
        <div id="tribe-events-header"  data-title="Events for May 2020 &#8211; Riara Group of Schools" data-viewtitle="Events for May 2020" data-view="month" data-date="2020-05" data-baseurl="">

        <!-- Header Navigation -->
        

<nav class="tribe-events-nav-pagination" aria-label="Calendar Month Navigation">
    <ul class="tribe-events-sub-nav">
        <li class="tribe-events-nav-previous">
            <a data-month="2020-04" href="" rel="prev"><span>&laquo;</span> April </a>       </li>
        <!-- .tribe-events-nav-previous -->
        <li class="tribe-events-nav-next">
                    </li>
        <!-- .tribe-events-nav-next -->
    </ul><!-- .tribe-events-sub-nav -->
</nav>

    </div>
    <!-- #tribe-events-header -->
    
    <!-- Month Grid -->
    


    <h2 class="tribe-events-visuallyhidden">Calendar of Events</h2>

    <table class="tribe-events-calendar">
       <?php
//include 'calendar.php';
 
$calendar = new Calendar();

 
echo $calendar->show();
?>

    <!-- Month Footer -->
        <div id="tribe-events-footer">

        <!-- Footer Navigation -->
                

<nav class="tribe-events-nav-pagination" aria-label="Calendar Month Navigation">
    <ul class="tribe-events-sub-nav">
        <li class="tribe-events-nav-previous">
            <a data-month="2020-04" href="https://www.riaraschools.ac.ke?post_type=tribe_events&#038;tribe_event_display=month&#038;eventDate=2020-04" rel="prev"><span>&laquo;</span> April </a>       </li>
        <!-- .tribe-events-nav-previous -->
        <li class="tribe-events-nav-next">
                    </li>
        <!-- .tribe-events-nav-next -->
    </ul><!-- .tribe-events-sub-nav -->
</nav>
        
    </div>
    <!-- #tribe-events-footer -->
    
    
<script type="text/html" id="tribe_tmpl_month_mobile_day_header">
    <div class="tribe-mobile-day" data-day="[[=date]]">[[ if(has_events) { ]]
        <h3 class="tribe-mobile-day-heading">[[=i18n.for_date]] <span>[[=raw date_name]]<\/span><\/h3>[[ } ]]
    <\/div>
</script>

<script type="text/html" id="tribe_tmpl_month_mobile">
    <div class="frhhhhhhhr tribe-events-mobile tribe-clearfix tribe-events-mobile-event-[[=eventId]][[ if(categoryClasses.length) { ]] [[= categoryClasses]][[ } ]]">
        <h4 class="summary">
            <a class="url" href="[[=permalink]]" title="[[=title]]" rel="bookmark">[[=raw title]]<\/a>
        <\/h4>

        <div class="tribe-events-event-body">
            <div class="tribe-events-event-schedule-details">
                <span class="tribe-event-date-start">[[=dateDisplay]] <\/span>
            <\/div>
            [[ if(imageSrc.length) { ]]
            <div class="tribe-events-event-image">
                <a href="[[=permalink]]" title="[[=title]]">
                    <img src="[[=imageSrc]]" alt="[[=title]]" title="[[=title]]">
                <\/a>
            <\/div>
            [[ } ]]
            [[ if(excerpt.length) { ]]
            <div class="tribe-event-description"> [[=raw excerpt]] <\/div>
            [[ } ]]
            <a href="[[=permalink]]" class="tribe-events-read-more" rel="bookmark">[[=i18n.find_out_more]]<\/a>
        <\/div>
    <\/div>
</script>
    
<script type="text/html" id="tribe_tmpl_tooltip">
    <div id="tribe-events-tooltip-[[=eventId]]" class="tribe-events-tooltip">
        <h3 class="entry-title summary">[[=raw title]]<\/h3>

        <div class="tribe-events-event-body">
            <div class="tribe-event-duration">
                <abbr class="tribe-events-abbr tribe-event-date-start">[[=dateDisplay]] <\/abbr>
            <\/div>
            [[ if(imageTooltipSrc.length) { ]]

            <div class="tribe-events-event-thumb">
                <img src="[[=imageTooltipSrc]]" alt="[[=title]]" \/>
            <\/div>
            [[ } ]]
            [[ if(excerpt.length) { ]]
            <div class="tribe-event-description">[[=raw excerpt]]<\/div>
            [[ } ]]
            <span class="tribe-events-arrow"><\/span>
        <\/div>
    <\/div>
</script>

<script type="text/html" id="tribe_tmpl_tooltip_featured">
    <div id="tribe-events-tooltip-[[=eventId]]" class="tribe-events-tooltip tribe-event-featured">
        [[ if(imageTooltipSrc.length) { ]]
            <div class="tribe-events-event-thumb">
                <img src="[[=imageTooltipSrc]]" alt="[[=title]]" \/>
            <\/div>
        [[ } ]]

        <h3 class="entry-title summary">[[=raw title]]<\/h3>

        <div class="tribe-events-event-body">
            <div class="tribe-event-duration">
                <abbr class="tribe-events-abbr tribe-event-date-start">[[=dateDisplay]] <\/abbr>
            <\/div>

            [[ if(excerpt.length) { ]]
            <div class="tribe-event-description">[[=raw excerpt]]<\/div>
            [[ } ]]
            <span class="tribe-events-arrow"><\/span>
        <\/div>
    <\/div>
</script>

</div><!-- #tribe-events-content -->
</div> <!-- #tribe-events-content-wrapper --><div class="tribe-events-after-html"></div></div><!-- #tribe-events -->
<!--
This calendar is powered by The Events Calendar.
http://m.tri.be/18wn
-->
                      </div>  
    </div>
    <!-- end of content area -->
    
    <!-- begin of bottom box area -->
    <div id="bottom-box">
        <div class="row">
            <div class="grid_12">            
                    
                <!-- Begin of Twitter Box -->
                
                <!-- End of Twitter Box -->
                
            </div>
        </div>
    </div>
    <!-- end of bottom box area -->
    
            <!-- begin of footer area -->
    <div id="footer-border"></div>
    <div id="footer-content">
        <div class="row">
            <div class="grid_3_custom_footer">
                            <h4>School Profile</h4>
                <p>To date Riara has succeeded in building a name as a reputable institution offering quality and holistic education; meeting the needs and requirements of her. <br>
                <a href="http://riaraschools.ac.ke/?page_id=1029" class="button small black">Download our pdf</a>
                         </div>
            <div class="grid_3_custom_footer">
                            <h4>Be part of The Riara Family</h4>
                <p>The origins of The Riara Group of Schools go back to the Balmoral Kindergarten which existed on Riara Road and was owned.<br><a href="http://riaraschools.ac.ke/?page_id=51">Read more</a><br>
<h4>Social Media Pages:</h4>
<div style=''float:left;">
<a href="" target="_blank"><img src="http://www.riaraschools.ac.ke/wp-content/uploads/2017/07/facebook_02.png"  width="50" height="50" style="float:left;"  alt="Riara Group Facebook page" title="Riara Group Facebook page"/></a>
<a href="" target="_blank"><img src="http://www.riaraschools.ac.ke/wp-content/uploads/2017/07/twitter1.png"  width="50" height="50" style="float:left;"  alt="Riara Group Twitter page" title="Riara Group Twitter page"/></a>
</div>
</p>

             
                                
            </div>
            <div class="grid_2_custom_footer">
                            <h4>Contact Us</h4>
                <ul>
                                                        <li class="address-icon">Riara Group of Schools,
Riara Road
P.O. Box 21389, 00505 Nairobi</li>
                                                        <li class="phone-icon">Phone : 0703 038 100 0703 038 200</li>
                                     
                    <li class="email-icon">Email :info@riaraschools.ac.ke</li>
                                  </ul>
                         </div>
            <div class="grid_2_custom_footer">
                            <h4>Resources</h4>
                <ul>
                           <li><a href="">About</a></li>
                  <li><a href="">Facilities</a></li>
                  <li><a href="">Calendar</a></li>
                  <li><a href="">Contact us</a></li>
                      </ul>
                          </div>
        </div>
    </div>
    <!-- end of footer area -->
     
</div>
<!-- bgin of copyright area -->
  <div id="copyright-content">
      <div class="row">          
        <p>&copy; 2017 Riara Group of Schools  All right reserved&nbsp;&nbsp;  | &nbsp;&nbsp; <a href="">Developed by Calvin and Ron</p>          
      </div>
  </div>
<!-- end of copyright area -->
  
    <script type="text/javascript">
    jQuery(document).ready(function($) {
      $("#twitter").tweet({
        join_text: "auto",
        username: "",
        avatar_size: 0,
        count: 1,
        auto_join_text_default: "",
        auto_join_text_ed: "",
        auto_join_text_ing: "",
        auto_join_text_reply: "",
        auto_join_text_url: "",
        loading_text: "loading tweets..."
      }); 
    });
  </script>
    
        <script>
        ( function ( body ) {
            'use strict';
            body.className = body.className.replace( /\btribe-no-js\b/, 'tribe-js' );
        } )( document.body );
        </script>
        <script> /* <![CDATA[ */var tribe_l10n_datatables = {"aria":{"sort_ascending":": activate to sort column ascending","sort_descending":": activate to sort column descending"},"length_menu":"Show _MENU_ entries","empty_table":"No data available in table","info":"Showing _START_ to _END_ of _TOTAL_ entries","info_empty":"Showing 0 to 0 of 0 entries","info_filtered":"(filtered from _MAX_ total entries)","zero_records":"No matching records found","search":"Search:","all_selected_text":"All items on this page were selected. ","select_all_link":"Select all pages","clear_selection":"Clear Selection.","pagination":{"all":"All","next":"Next","previous":"Previous"},"select":{"rows":{"0":"","_":": Selected %d rows","1":": Selected 1 row"}},"datepicker":{"dayNames":["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],"dayNamesShort":["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],"dayNamesMin":["S","M","T","W","T","F","S"],"monthNames":["January","February","March","April","May","June","July","August","September","October","November","December"],"monthNamesShort":["January","February","March","April","May","June","July","August","September","October","November","December"],"nextText":"Next","prevText":"Prev","currentText":"Today","closeText":"Done"}};var tribe_system_info = {"sysinfo_optin_nonce":"1d326da748","clipboard_btn_text":"Copy to clipboard","clipboard_copied_text":"System info copied","clipboard_fail_text":"Press \"Cmd + C\" to copy"};/* ]]> */ </script><script type='text/javascript' src='https://www.riaraschools.ac.ke/wp-content/plugins/ppm-accordion/js/ppm-accordion-active.js?ver=1.0'></script>
<script type='text/javascript' src='https://www.riaraschools.ac.ke/wp-content/plugins/ubermenu/js/hoverIntent.js?ver=4.9.14'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var uberMenuSettings = {"speed":"300","trigger":"hoverIntent","orientation":"horizontal","transition":"slide","hoverInterval":"20","hoverTimeout":"400","removeConflicts":"on","autoAlign":"off","noconflict":"off","fullWidthSubs":"off","androidClick":"off","loadGoogleMaps":"off"};
/* ]]> */
</script>
<script type='text/javascript' src='https://www.riaraschools.ac.ke/wp-content/plugins/ubermenu/js/ubermenu.min.js?ver=4.9.14'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var TribeCalendar = {"ajaxurl":"https:\/\/www.riaraschools.ac.ke\/wp-admin\/admin-ajax.php","post_type":"tribe_events"};
/* ]]> */
</script>
<script type='text/javascript' src='https://www.riaraschools.ac.ke/wp-content/plugins/the-events-calendar/src/resources/js/tribe-events-ajax-calendar.min.js?ver=4.6.25'></script>
<script type='text/javascript' src='https://www.riaraschools.ac.ke/wp-includes/js/wp-embed.min.js?ver=4.9.14'></script>
  <p id="back-top">
        <a href="#top"><span></span></a>
    </p>
</body>
</html>