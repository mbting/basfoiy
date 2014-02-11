        <footer>
	        <p id="basquote" class="dv"><?php echo $text; ?></p>
            <div class="fb-like" data-href="https://www.facebook.com/basfoiymv" data-layout="button_count" data-action="recommend" data-show-faces="true" data-share="false"></div>
	        <p id="basdev">
	        	<a id="inm" href="http://www.google.com/+IbrahimNaeem" target="_blank">Ibrahim Naeem</a>
	        	<a id="exz" href="http://www.google.com/+AbdhullaShaheed/" target="_blank">Abdulla Shaheed</a>
	        <p>
            <p id="copy">&copy; <?php echo date('Y'); ?> Basfoiy.mv</p>
        </footer>
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId=<?php echo $this->config["apiKeys"]["fbAppId"]; ?>";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
        <script src="assets/js/jtk-4.2.1.pack.js"></script>
        <script type="text/javascript">var recaptchaKey = "<?php echo $this->config["apiKeys"]["recaptcha"]["public"]; ?>";</script>
        <script src="assets/js/basfoiy.js"></script>
        <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', '<?php echo $this->config["apiKeys"]["analytics"]["account"]; ?>', '<?php echo $this->config["apiKeys"]["analytics"]["domain"]; ?>');
        ga('send', 'pageview');

        </script>
    </body>
</html>
