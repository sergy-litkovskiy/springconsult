<link rel="stylesheet" href="<?php echo base_url();?>css/style-old.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url();?>js/jquery-ui-1.8.2/css/ui-lightness/jquery-ui-1.8.2.css" />

<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta name="description" content="<?php echo $meta_description;?>"/>
<meta name="keywords" content="<?php echo $meta_keywords;?>"/>
<link rel="icon" href="<?php echo base_url();?>favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="<?php echo base_url();?>favicon.ico" type="image/x-icon">

<meta name="robots" content="INDEX, FOLLOW"/>
<meta content="document" name="resource-type"/>
<meta content="no-cache" http-equiv="Pragma"/>
<meta content="no-cache" http-equiv="Cache-Control"/>
<meta property="og:title" content="<?php echo @$titleFB;?>"/>
<meta property="og:image" content="<?php echo base_url()."img/upload_img/".@$imgFB;?>"/>

<meta name="interkassa-verification" content="ff9961ee5360677d66c3c06bb4f244bf" />

<title><?php echo $title;?></title>

<script  type="text/javascript" src="<?php echo base_url();?>js/jquery/jquery-1.8.3-min.js"></script>
<script  type="text/javascript" src="<?php echo base_url();?>js/jquery-ui-1.8.2/js/jquery-ui-1.8.2.js"></script>
<script  type="text/javascript" src="<?php echo base_url();?>js/jquery/jquery.tools.min.js"></script>
<script  type="text/javascript" src="<?php echo base_url();?>js/jquery/jquery.loadmask.js"></script>
<script  type="text/javascript" src="<?php echo base_url();?>js/jquery/jquery.cross-slide.js"></script>
<script  type="text/javascript" src="<?php echo base_url();?>js/jquery/jquery.validate.js"></script>
<script  type="text/javascript" src="<?php echo base_url();?>js/jquery.watermark-3.1.3/jquery.watermark.min.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>js/init.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/spring/core.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/spring/core.extensions.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/spring/sandbox.js"></script> 

<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-26859672-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<script>
    // Load the SDK Asynchronously
    (function(d){
        var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement('script'); js.id = id; js.async = true;
        js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1&appId=124735281036290";
        ref.parentNode.insertBefore(js, ref);
    }(document));
</script>

<script>
	!function(d,s,id){
	var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){
		js=d.createElement(s);
		js.id=id;
		js.src="//platform.twitter.com/widgets.js";
		fjs.parentNode.insertBefore(js,fjs);
	}
	}(document,"script","twitter-wjs");
</script>
<link href="http://stg.odnoklassniki.ru/share/odkl_share.css" rel="stylesheet">
<script src="http://stg.odnoklassniki.ru/share/odkl_share.js" type="text/javascript" ></script>
<script type="text/javascript" src="http://userapi.com/js/api/openapi.js?49"></script>
<script type="text/javascript">
  VK.init({apiId: 2889450, onlyWidgets: true});
</script>