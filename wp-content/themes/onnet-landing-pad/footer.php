
</div> <!-- End of .siteContainerInner -->

<?php  

$tracking = of_get_option('tracking_codes_enabled');
$tracking_code = of_get_option('tracking_analytics_tracking_code');
$tracking_code = (!empty($tracking_code)) ? $tracking_code : '';
$tracking_url = of_get_option('tracking_analytics_tracking_url');
$tracking_url = (!empty($tracking_url)) ? $tracking_url : 'auto';

?>

</div> <!-- End of .siteContainer -->

<!-- Cxense script begin -->
<script type="text/javascript">
    var cX = cX || {}; cX.callQueue = cX.callQueue || [];
    cX.callQueue.push(['setSiteId', '1144060430323782688']);
    cX.callQueue.push(['sendPageViewEvent']);
</script>
<script type="text/javascript">
    (function(d,s,e,t){e=d.createElement(s);e.type='text/java'+s;e.async='async';
        e.src='http'+('https:'===location.protocol?'s://s':'://')+'cdn.cxense.com/cx.js';
        t=d.getElementsByTagName(s)[0];t.parentNode.insertBefore(e,t);})(document,'script');
</script>
<!-- Cxense script end -->
<!-- Effective measure - start -->
<script type='text/javascript'>
    (function(){
        var em = document.createElement('script'); em.type = 'text/javascript'; em.async = true;
        em.src = ('https:' == document.location.protocol ? 'https://za-ssl' : 'http://za-cdn') + '.effectivemeasure.net/em.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(em, s);
    })();
</script>

<noscript>
    <img src="//za.effectivemeasure.net/em_image" alt="" style="position:absolute;left:-5px;" />
</noscript>
<!-- Effective measure - end -->

<?php if ($tracking == '1') { ?>

	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', '<?php echo $tracking_code; ?>', '<?php echo $tracking_url; ?>');
		ga('send', 'pageview');

	</script>

<?php } ?>

<?php wp_footer(); ?>

</body>
</html>

