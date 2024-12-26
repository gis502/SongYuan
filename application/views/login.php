<!doctype html>
<html lang="zh">

<head>
<base href="<?php  echo base_url();?>"/>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="renderer" content="webkit"> 
    <title>松原市震害预测系统</title>
    <link href="public/css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="public/js/jquery.min.js"></script>   
    <script src="public/js/cloud.js" type="text/javascript"></script>
    <script language="javascript">
	    $(function() {
	        $('.loginbox').css({
	            'position': 'absolute',
	            'left': ($(window).width() - 692) / 2
	        });
	        $(window).resize(function() {
	            $('.loginbox').css({
	                'position': 'absolute',
	                'left': ($(window).width() - 692) / 2
	            });
	        });
	        var isNO = $(".val").val();
	        if(isNO==='no'){
	            $("#login-tip").css("display","inline");
	        }
	    });
    </script>
</head>

<body style="background-color:rgb(13, 115, 177); background-image:url(IMG/light.png); background-repeat:no-repeat; background-position:center top; overflow:hidden;">
    <div id="mainBody">
        <div id="cloud1" class="cloud"></div>
        <div id="cloud2" class="cloud"></div>
    </div>
    <!-- <div class="logintop">    
    <span>欢迎登录后台管理界面平台</span>    
    <ul>
    <li><a href="#">回首页</a></li>
    <li><a href="#">帮助</a></li>
    <li><a href="#">关于</a></li>
    </ul>    
    </div> -->
    <div class="loginbody">
        <span class="systemlogo"><div align="center" style="font-size: 40px;color: white;font-weight: normal;display: block;width: 105%;position: absolute;letter-spacing:2px">松原市震害预测系统</div></span>
        <form action="index.php/Welcome/intentMainPage" method="post">
            <div class="loginbox">
                <ul>
                    <li>
                        <input name="userName" type="text" class="loginuser" placeholder="请输入用户名" onclick="JavaScript:this.value=''" />
                    </li>
                    <li>
                        <input name="passWord" type="password" class="loginpwd" placeholder="请输入密码" onclick="JavaScript:this.value=''" />
                    </li>
                    <li> 
                         <input name="loginCheckCode" type="" id="code_input" class="loginCheckCode" style="border:1.5px solid #c1d0d9" placeholder="请输入验证码" onclick="JavaScript:this.value=''" />
                        <div id="v_container" style="width: 130px;height: 50px;float:right"></div>
                    </li>
                    <li>
                       <label id="login-tip" style="color:red;display:none;float: left;;margin-top:-20px;">账户或密码错误，请重新输入</label> <label style="float:right;margin-top:-20px;color:red" id="showError"></label>
                    </li>
                    <li>
                        <input name="" type="submit" class="loginbtn" value="登录" onclick="checkIE()" id="my_button" />
                        <label>
                            <input name="" type="checkbox" value="" checked="checked" />记住密码</label>
                        <label><a href="#">忘记密码？</a></label>
                    </li>
                    <p id="login-tishi" style="color:black;margin-top:-20px;">建议使用Google浏览器、360浏览器8.1以上版本</p>
                    
                </ul>

            </div>
        </form>
    </div>
    <div class="loginbm" style="font-size:14px;letter-spacing:3px;font-family:Verdana,Geneva,sans-serif;top:88%">防灾科技学院信息工程学院 提供技术支持
        <br/>
        <br/> 技术支持电话：<a>13700349482</a>
    </div>
    <input type="hidden" class= "val" value = "<?php echo $e;?>" />
</body>

 <script language="JavaScript" src="public/pi_js/gVerify.js"></script>
<!-- 浏览器版本过低问题，IE8及其以下版本将不建议使用 -->
    <script >

function checkIE(){
	var browser=Browser();
	function Browser(){

   	var browser = function () {   
    var agent = navigator.userAgent.toLowerCase(),  
    opera = window.opera,  
    browser = {  
        //检测当前浏览器是否为IE  
        ie: /(msie\s|trident.*rv:)([\w.]+)/.test(agent), 
        //检测当前浏览器是否为Opera  
        opera: (!!opera && opera.version), 
        //检测当前浏览器是否是webkit内核的浏览器  
        webkit: (agent.indexOf(' applewebkit/') > -1), 
        //检测当前浏览器是否是运行在mac平台下  
        mac: (agent.indexOf('macintosh') > -1), 
        //检测当前浏览器是否处于“怪异模式”下  
        quirks: (document.compatMode == 'BackCompat')  
    }; 
    //检测当前浏览器内核是否是gecko内核  
    browser.gecko = (navigator.product == 'Gecko' && !browser.webkit && !browser.opera && !browser.ie); 
    var version = 0; 
    // Internet Explorer 6.0+  
    if (browser.ie) {  
        var v1 = agent.match(/(?:msie\s([\w.]+))/);  
        var v2 = agent.match(/(?:trident.*rv:([\w.]+))/);  
        if (v1 && v2 && v1[1] && v2[1]) {  
            version = Math.max(v1[1] * 1, v2[1] * 1);  
        } else if (v1 && v1[1]) {  
            version = v1[1] * 1;  
        } else if (v2 && v2[1]) {  
            version = v2[1] * 1;  
        } else {  
            version = 0;  
        } 
        //检测浏览器模式是否为 IE11 兼容模式  
        browser.ie11Compat = document.documentMode == 11; 
        //检测浏览器模式是否为 IE9 兼容模式  
        browser.ie9Compat = document.documentMode == 9; 
        //检测浏览器模式是否为 IE10 兼容模式  
        browser.ie10Compat = document.documentMode == 10; 
        //检测浏览器是否是IE8浏览器  
        browser.ie8 = !!document.documentMode; 
        //检测浏览器模式是否为 IE8 兼容模式  
        browser.ie8Compat = document.documentMode == 8; 
        //检测浏览器模式是否为 IE7 兼容模式  
        browser.ie7Compat = ((version == 7 && !document.documentMode) || document.documentMode == 7); 
        //检测浏览器模式是否为 IE6 模式 或者怪异模式  
        browser.ie6Compat = (version < 7 || browser.quirks); 
        browser.ie9above = version > 8; 
        browser.ie9below = version < 9;  
    } 
    // Gecko.  
    if (browser.gecko) {  
        var geckoRelease = agent.match(/rv:([\d\.]+)/);  
        if (geckoRelease) {  
            geckoRelease = geckoRelease[1].split('.');  
            version = geckoRelease[0] * 10000 + (geckoRelease[1] || 0) * 100 + (geckoRelease[2] || 0) * 1;  
        }
    } 
    //检测当前浏览器是否为Chrome, 如果是，则返回Chrome的大版本号  
    if (/chrome\/(\d+\.\d)/i.test(agent)) {  
        browser.chrome = +RegExp['\x241']; 
    } 
    //检测当前浏览器是否为Safari, 如果是，则返回Safari的大版本号  
    if (/(\d+\.\d)?(?:\.\d)?\s+safari\/?(\d+\.\d+)?/i.test(agent) && !/chrome/i.test(agent)) {  
        browser.safari = +(RegExp['\x241'] || RegExp['\x242']); 
    } 
    // Opera 9.50+  
    if (browser.opera)  {
        version = parseFloat(opera.version()); 
    }
        
    // WebKit 522+ (Safari 3+)  
    if (browser.webkit)  {
         version = parseFloat(agent.match(/ applewebkit\/(\d+)/)[1]); 
    }
    //检测当前浏览器版本号  
    browser.version = version; 
    return browser;  
}();
if(browser.chrome>0){
   
    var nowbrowser= ["chrome",browser.chrome,browser.version];
}//chrome:52 gecko:false ie:false mac:false opera:false quirks:false version:537 webkit:true
if(browser.gecko>0){
 
   var nowbrowser= ["gecko",browser.gecko,browser.version];
}
if(browser.ie>0){

 var nowbrowser= ["ie",browser.ie,browser.version];
}
if(browser.mac>0){
  
   var nowbrowser= ["mac",browser.mac,browser.version];
}
if(browser.opera>0){
     
    var nowbrowser= ["opera",browser.opera,browser.version];
}
if(browser.quirks>0){
 
    var nowbrowser=["quirks",browser.quirks,browser.version];
}
//console.log(nowbrowser);
//return nowbrowser;
if(nowbrowser[0]=="ie"&&nowbrowser[2]<11)
    alert("您当前浏览器内核版本为IE"+nowbrowser[2]+","+"建议使用IE9以上版本或尝试将浏览器设置为极速模式");
    window.location.href="index.php/Welcome/intentMainPage";
}

}

        var verifyCode = new GVerify("v_container");

        document.getElementById("my_button").onclick = function(){
            if(document.getElementById("code_input").value==""){
                document.getElementById('showError').innerHTML="请输入验证码";
                return false;
            }else{
                var res = verifyCode.validate(document.getElementById("code_input").value);
                if(res){
                    //alert("验证正确");
                }else{
                    //alert("验证码错误");
                    document.getElementById('showError').innerHTML="验证码错误";
                    return false;
                } 
            }
           
        }

</script> 



</html>
