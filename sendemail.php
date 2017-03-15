<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Thai Hotels Send Emails</title>

        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Favicon -->
        <link rel="shortcut icon" href="favicon.ico">

        <!-- Web Fonts -->
        <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600&amp;subset=cyrillic,latin">

        <!-- CSS Global Compulsory -->
        <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/style.css">

        <!-- CSS Header and Footer -->
        <link rel="stylesheet" href="assets/css/headers/header-v6.css">
        <link rel="stylesheet" href="assets/css/footers/footer-v1.css">

        <!-- CSS Implementing Plugins -->
        <link rel="stylesheet" href="assets/plugins/animate.css">
        <link rel="stylesheet" href="assets/plugins/line-icons/line-icons.css">
        <link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome.min.css">

        <!-- CSS Theme -->
        <link rel="stylesheet" href="assets/css/theme-colors/default.css" id="style_color">
        <link rel="stylesheet" href="assets/css/theme-skins/dark.css">

        <!-- CSS Customization -->
        <link rel="stylesheet" href="assets/css/custom.css">
        <link href="assets/plugins/king-ui/css/king-ui.css" rel="stylesheet">
        <link href="assets/plugins/king-ui/css/animate.css" rel="stylesheet">
        <link href="assets/plugins/king-ui/css/owl.carousel.css" rel="stylesheet">
        <link href="assets/plugins/king-ui/css/owl.theme.css" rel="stylesheet">
        <!-- fonts -->
        <!--<link href='https://fonts.googleapis.com/css?family=Lato:300,400,400italic,700' rel='stylesheet' type='text/css'>-->
        <link href="assets/king-ui/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href='assets/king-ui/fonts/FontAwesome.otf' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="assets/king-ui/css/linear-icons.css">
        
        <!-- JS Global Compulsory -->
	<script type="text/javascript" src="assets/plugins/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="assets/plugins/jquery/jquery-migrate.min.js"></script>
	<script type="text/javascript" src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<!-- JS Implementing Plugins -->
	<script type="text/javascript" src="assets/plugins/back-to-top.js"></script>
	<script type="text/javascript" src="assets/plugins/smoothScroll.js"></script>
	<script type="text/javascript" src="assets/plugins/jquery.parallax.js"></script>
	<script type="text/javascript" src="assets/plugins/fancybox/source/jquery.fancybox.pack.js"></script>
	<script type="text/javascript" src="assets/plugins/owl-carousel/owl-carousel/owl.carousel.js"></script>
	<script type="text/javascript" src="assets/plugins/revolution-slider/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
	<script type="text/javascript" src="assets/plugins/revolution-slider/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
	<!-- JS Customization -->
	<script type="text/javascript" src="assets/js/custom.js"></script>
	<!-- JS Page Level -->
	<script type="text/javascript" src="assets/js/app.js"></script>
	<script type="text/javascript" src="assets/js/plugins/fancy-box.js"></script>
	<script type="text/javascript" src="assets/js/plugins/owl-carousel.js"></script>
	<script type="text/javascript" src="assets/js/plugins/revolution-slider.js"></script>
	<script type="text/javascript" src="assets/js/plugins/style-switcher.js"></script>
        <script type="text/javascript" charset="utf-8">
            jQuery(document).ready(function() {
                //alert('aaaa');
                $("#btnEmail").click(sendEmail);
                hideLoader();
                getGroup();
            });
            function showLoader() {
                $("#loading").show();
              }
            function hideLoader() {
                //alert('bbbbb');
                $("#loading").hide();
            }
            function getGroup(){
                showLoader();
                var toAppend="";
                //alert('bbbbb ');
                $.ajax({ 
                    type: 'GET', url: 'getGroup.php', contentType: "application/json", dataType: 'text', data: { get_param: 'value' }, 
                    success: function (data) {
                        //alert('rrrrrrr '+data);
                        var json_obj = $.parseJSON(data);
                        //alert('bbbbb '+json_obj.length);
                        //$("#divView").append(json_obj);
                        toAppend += '<option data-tokens="ketchup mustard" value="'-'">'-'</option>';
                        for (var i in json_obj)
                        {
                            if(json_obj[i].group1==null) {
                                //alert('ddddd ');
                            }
                            //toAppend = '<option data-tokens="ketchup mustard">'+json_obj[i].prov_name+'</option>';
                            toAppend += '<option data-tokens="ketchup mustard" value="'+json_obj[i].group1+'">'+json_obj[i].group1+'</option>';
                            
                            //
                        }
                        $("#smGroup").append(toAppend);
                            $("#smGroup").selectpicker('refresh');
                        hideLoader();
                    }
                });
            }
            function sendEmail(){
                $.ajax({
                    type: 'GET', url: 'gmail.php', contentType: "application/json", dataType: 'text', data: { 'smFileName': $("#smFileName").val()
                        ,'smGroup': $("#smGroup").val(),'smEmailAddress': $("#smEmailAddress").val()
                        ,'smSubject': $("#smSubject").val(),'smAttachFile1': $("#smAttachFile1").val()
                        ,'smAttachFile2': $("#smAttachFile2").val(),'smAttachFile3': $("#smAttachFile3").val()}, 
                    success: function (data) {
                        alert('bbbbb '.data);
                        $("#divView").append(data);
                    }
                });
                
                //$("#divView").load("gmail.php", {smFileName : $("#smFileName").val()
                //    ,smEmailAddress : $("#smEmailAddress").val()
                //    ,smSubject : $("#smSubject").val()
                //    ,smGroup : $("#smGroup").val()
                //    ,smAttachFile1 : $("#smAttachFile1").val()
                //    ,smAttachFile2 : $("#smAttachFile2").val()
                //    ,smAttachFile3 : $("#smAttachFile3").val()}, function() {});
            }
            
        </script>
    </head>
    <body>
        <?php
        // put your code here
        ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-10"><h2>ส่ง Emails</h2><div id="loading"><img src="assets/img/ajax-loader.gif" name="loader" id="loader" alt=""/></div></div>
                <div class="col-lg-2"></div>
            </div>
        </div>
        
        
        
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
              <!-- contact form 2 -->
              <div id="contact-form-2">
                <form id="contactForm" class="contact-form-2" data-toggle="validator">
                  <div class="form-group">
                    <label class="label label-pill label-success-filled">Group </label>
                        <select class="selectpicker form-control" data-live-search="true" id="smGroup">
                        </select>
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                      <label class="label label-pill label-success-filled">email</label>
                    <input type="email" class="form-control" id="smEmailAddress" placeholder="Email" required>
                    <div class="help-block with-errors"></div>
                  </div>
                    <div class="form-group">
                        <label class="label label-pill label-success-filled">Subject</label>
                        <input type="email" class="form-control" id="smSubject" placeholder="Subject" required>
                        <div class="help-block with-errors"></div>
                    </div>
                  <div class="form-group">
                      <label class="label label-pill label-success-filled">File Name email template</label>
                    <input type="text" class="form-control" id="smFileName" placeholder="File Name email template" required data-error="*Please fill out this field">
                    <div class="help-block with-errors"></div>
                  </div>
                <div class="form-group">
                    <label class="label label-pill label-default-filled">Attach File Name1</label>
                    <input type="text" class="form-control" id="smAttachFile1" placeholder="Attach File Name1" required data-error="*Please fill out this field">
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <label class="label label-pill label-default-filled">Attach File Name2</label>
                    <input type="text" class="form-control" id="smAttachFile2" placeholder="Attach File Name2" required data-error="*Please fill out this field">
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <label class="label label-pill label-default-filled">Attach File Name3</label>
                    <input type="text" class="form-control" id="smAttachFile3" placeholder="Attach File Name3" required data-error="*Please fill out this field">
                    <div class="help-block with-errors"></div>
                </div>
                <button type="button" id="btnEmail" class="btn btn-md btn-primary-filled btn-form-submit">Send Message</button>
                <div id="msgSubmit" class="h3 text-center hidden"></div>
                <div class="clearfix"></div>
                </form>
              </div><!-- / contact form 2 -->
            </div><!-- / col-sm-6 -->
        </div><!-- / row -->
    </div>
    <div id="divView"></div>
    
    </body>
</html>
