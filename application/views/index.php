<!--
	修改日期:2017年5月2日
	界面责任人:XF
-->
<!DOCTYPE html>
<html>
	<head>
        <base href="<?php  echo base_url();?>"/>
		<meta charset="utf-8">
		<title>松原震害模拟系统</title>
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="format-detection" content="telephone=no">
		<link rel="stylesheet" href="public/plugins/layui/css/layui.css" media="all" />
		<link rel="stylesheet" href="public/css/global.css" media="all">
		<link rel="stylesheet" type="text/css" href="public/css/font-awesome.min.css">
		
		<script type="text/javascript"  src="http://api.map.baidu.com/api?v=2.0&ak=RHKX4sKEYnreDcwAx8pYxqARPOYxRbjR"></script>
		<!-- <script type="text/javascript"  src="http://api.map.baidu.com/api?v=2.0&ak=dAiSmSs6IHrw03DIrn0YTWWBTenyA9Iy"></script> -->
    	<script type="text/javascript" src="public/js/TextIconOverlay_min.js"></script>
    	<script type="text/javascript" src="public/js/LuShu_min.js"></script>
    	<script type="text/javascript" src="public/js/jquery-1.7.1.min.js"></script>
    	<script type="text/javascript" src="public/js/echarts.js"></script>
    	<link href="public/css/initmap.css" type="text/css" rel="stylesheet">
        <script type="text/javascript" src="public/js/jquery.min.js"></script>
        <?include 'public/phpE/PHPExcel.php';?>
	<!-- 截图 -->
     <script language="javascript" src="public/pi_js/html2canvas.js"></script>
     <script language="javascript" src="public/pi_js/canvg/canvg.js"></script>
     <script language="javascript" src="public/pi_js/canvg/rgbcolor.js"></script>
     <script language="javascript" src="public/pi_js/canvg/StackBlur.js"></script>
     <script language="javascript" src="public/pi_js/niuniucapture.js?v=20151108"></script>
     <script language="javascript" src="public/pi_js/capturewrapper.js?v=20151108"></script>
     <script language="javascript" src="public/pi_js/GeoUtils.js"></script>
     <script language="javascript" src="public/pi_js/MarkerForeast.js"></script>
     <script type="text/javascript" src="public/js/intensityShow.js"></script><!--长短轴-->
     <script language="javascript" src="public/pi_js/historyEarthquake.js"></script>
		<style type="text/css">
			.layui-form-item{
				margin-bottom: 0px;
			}
			.input-position{
				margin-top:14px;
			}
			.lineCheckBox{
				margin-top: 13px;
			}
			.image{
				float: left;
			}
			.historyChartCss{
				opacity:0.5
			}
		</style>
		<!-- color_picker -->
     <link href="public/css/color-picker.min.css" rel="stylesheet">
     <style>
     .color-box {
	      display:inline-block;
	      width:15px;
	      height:15px;
	      cursor:pointer;
	      margin-top: 4px;
     }

    </style>
	</head>
	<body>
		<div class="layui-layout layui-layout-admin">
			<div class="layui-layout layui-layout-admin">
			<div class="layui-header header header-demo">
				<div class="layui-main">
					<div class="admin-login-box">
						<a class="logo" style="left: 0;" href="#">
							<span style="font-size: 20px;">松原市震害预测系统</span>
						</a>
					</div>
					
					<ul class="layui-nav">
						<!-- <li>							
						<dd> <input type="file" id="upfile" name="upfile" placeholder=""/></dd>
						<dd><<button onclick="EdataAdd();">导入</button>输入</a></dd>
						</li> -->
						<li class="layui-nav-item"><a href="javascript:;">数据输入</a>
					  <dl class="layui-nav-child">
					  	  <dd><a href="javascript:;" onclick="InputData()">单条输入</a></dd>
							<dd><a href="javascript:;" onclick="excelImport()" >Excel导入</a></dd>
							<dd><a href="javascript:;" onclick="dataManage()">数据管理</a></dd>
					  	</dl></li>
					  <li class="layui-nav-item">
					    <a href="javascript:;">历史地震</a>
					    <dl class="layui-nav-child">
					      <dd><a href="javascript:;" onclick="histoEar('point')">地震分布</a></dd>
						  <dd><a href="javascript:;" onclick="histoEar('chart')">折线分析</a></dd>						  
					    </dl>
					  </li>
					  <li class="layui-nav-item">
					    <a href="javascript:;">圆形烈度图</a>
					    <dl class="layui-nav-child">
					      <dd><a href="javascript:;" onclick="paramaterSetting()">选择震源</a></dd>
						  <dd><a href="javascript:;" onclick="paramaterSetting1()">精确输入</a></dd>
						  <div id="close" style="display:none;"></div>
					    </dl>
					  </li>
					  <li class="layui-nav-item">
					    <a href="javascript:;">椭圆烈度图</a>
					    <dl class="layui-nav-child">
					      <dd><a href="javascript:;" onclick="drawIntensity()">选择震源</a></dd>
						  <dd><a href="javascript:;" onclick="drawIntensity1()">精确输入</a></dd>
					    </dl>
					  </li>
					  
					  <li class="layui-nav-item">
					    <a href="javascript:;">查询功能</a>
					    <dl class="layui-nav-child">
					      <dd><a href="javascript:;" onclick="exactsearch()" >精确查询</a></dd>
					      <dd><a href="javascript:;" onclick="fuzzysearch()" >模糊查询</a></dd>
					    </dl>
					  </li>
					    <li class="layui-nav-item"><a href="javascript:;" onclick="StartCapture('E')">截图</a></li>
					  <li class="layui-nav-item">
					  	<a href="javascript:;" >数据分析</a>
					  	<dl class="layui-nav-child">
					  	  <dd><a href="javascript:;" onclick="draw_chart1()">饼状图</a></dd>
					  	  <dd><a href="javascript:;" onclick="draw_initchart()" >柱状图</a></dd>
					  	</dl>
					  </li>
					  
					 
					  <li class="layui-nav-item">
							<a href="javascript:;" onclick="songyuanLocation()">定位松原</a>
						</li>

						<li class="layui-nav-item" style="display: inline-block;margin-left: 1px;"><a href="javascript:;">一键产出</a>
						<dl class="layui-nav-child">
					  	  <dd><a href="javascript:;" onclick="WordExport1('w')">导出word</a></dd>
					  	  <dd><a href="javascript:;" onclick="WordExport1('p')" >导出ppt</a></dd>
					  	</dl>
					  </li>

                            <li class="layui-nav-item">


                                    <a href="javascript:;" class="admin-header-user">
                                        <img src="public/images/0.jpg" />
                                        <span><?php echo $_SESSION['userName']?></span>
                                    </a>

                                <dl class="layui-nav-child">

									<?php if ($_SESSION['power']==1) {?>  
									<dd><a href="javascript:;" onclick="userManage()">用户管理</a></dd>
									<?php
									} ?>
									<dd><a href="javascript:;" onclick="imageManage()">图片管理</a></dd>
                                    <dd><a href="javascript:;" onclick="help()">帮助文档</a></dd>
									<dd><a href="javascript:;" onclick="ShowDownLoad()">下载牛牛截图</a></dd>
                                    <dd><a href="javascript:;" onclick="logout()">注销</a></dd>
                                </dl>
                            </li>
					</ul>  

				</div>
			</div>

			<div class="layui-side layui-bg-black" id="admin-side">
				<div class="layui-side-scroll" id="admin-navbar-side" lay-filter="side">
					<!--这里是添加左侧菜单栏-->
						<ul class="layui-nav layui-nav-tree" lay-filter="demo">
						<li class="layui-nav-item layui-nav-itemed">
						    <a href="javascript:;">数据管理</a>
						    <dl class="layui-nav-child">
<!-- 						      <dd>	
						      	<div class="layui-form-item" pane="">
							      <label class="layui-form-label">受灾预估</label>
							      <input type="checkbox" class="input-position" lay-skin="primary"  title="点添加" id="szyg" value="szyg" onClick="return_build_data(this.value)" >
							     
							      </div>
							  </dd> -->	
						      <dd>	
						      	<div class="layui-form-item" pane="">
							      <label class="layui-form-label">所有建筑</label><!-- return_build_data(this.value) -->
							      <input type="checkbox" class="input-position" lay-skin="primary"  title="点添加" id="syjzw" value="syjzw" onClick="checkAll()" >
							     
							      </div>
							  </dd>
						      <dd>	
						      	<div class="layui-form-item" pane="">
							      <label class="layui-form-label">桥梁建筑</label>
							      <input type="checkbox" class="input-position" lay-skin="primary"  title="点添加" id="qljz" value="qljz" name="choice" onClick="return_build_data(this.value)" >
							      </div>
							  </dd>						    	
						      <dd>	
						      	<div class="layui-form-item" pane="">
							      <label class="layui-form-label">工业建筑</label>
							      <input type="checkbox" class="input-position" lay-skin="primary"  title="点添加" id="gyjz" value="gyjz" name="choice" onClick="return_build_data(this.value)" >
							      </div>
							  </dd>
						      <dd>	
						      	<div class="layui-form-item" pane="">
							      <label class="layui-form-label">民用建筑</label>
							      <input type="checkbox" class="input-position" lay-skin="primary"   title="点添加" id="myjz" value="myjz" name="choice" onClick="return_build_data(this.value)"  >
							      </div>
							  </dd>
						      <dd>	
						      	<div class="layui-form-item" pane="">
							      <label class="layui-form-label">公共建筑物</label>
							      <input type="checkbox" class="input-position" lay-skin="primary"  title="点添加" id="ggjzw" value="ggjzw" name="choice" onClick="return_build_data(this.value)" >
							      </div>
							  </dd>
						      <dd>	
						      	<div class="layui-form-item" pane="">
							      <label class="layui-form-label">供水系统建筑</label>
							      <input type="checkbox" class="input-position" lay-skin="primary"  title="点添加" id="gsxtjz" value="gsxtjz" name="choice" onClick="return_build_data(this.value)" >
							      </div>
							  </dd>
						      <dd>	
						      	<div class="layui-form-item" pane="">
							      <label class="layui-form-label">供热系统建筑</label>
							      <input type="checkbox" class="input-position" lay-skin="primary"  title="点添加" id="grxtjz" value="grxtjz" name="choice" onClick="return_build_data(this.value)" >
							      </div>
							  </dd>
							   <dd>	
						      	<div class="layui-form-item" pane="">
							      <label class="layui-form-label">供电系统建筑</label>
							      <input type="checkbox"  class="input-position" lay-skin="primary"  title="点添加" id="gdxtjz" value="gdxtjz" name="choice" onClick="return_build_data(this.value)" >
							      </div>
							  </dd>
							   <dd>	
						      	<div class="layui-form-item" pane="">
							      <label class="layui-form-label">变电站名称</label>
							      <input type="checkbox" class="input-position" lay-skin="primary"  title="点添加" id="bdzmc" value="bdzmc" name="choice" onClick="return_build_data(this.value)" >
							      </div>
							  </dd>
							   <dd>	
						      	<div class="layui-form-item" pane="">
							      <label class="layui-form-label">天然气加气站</label>
							      <input type="checkbox" class="input-position" lay-skin="primary"  title="点添加" id="trqjqz" value="trqjqz" name="choice" onClick="return_build_data(this.value)" >
							      </div>
							  </dd>
							   <dd>	
						      	<div class="layui-form-item" pane="">
							      <label class="layui-form-label">天然气门站</label>
							      <input type="checkbox" class="input-position" lay-skin="primary"  title="点添加" id="trqmz" value="trqmz" name="choice" onClick="return_build_data(this.value)" >
							      </div>
							  </dd>
							   <dd>	
						      	<div class="layui-form-item" pane="">
							      <label class="layui-form-label">次生灾害源</label>
							      <input type="checkbox"  class="input-position" lay-skin="primary"  title="点添加" id="cszhy" value="cszhy" name="choice" onClick="return_build_data(this.value)" >
							      </div>
							  </dd>
							   <dd>	
						      	<div class="layui-form-item" pane="">
							      <label class="layui-form-label">消防建筑</label>
							      <input type="checkbox" class="input-position" lay-skin="primary"  title="点添加" id="xfjz" value="xfjz" name="choice" onClick="return_build_data(this.value)" >
							      </div>
							  </dd>
							   <dd>	
						      	<div class="layui-form-item" pane="">
							      <label class="layui-form-label">液化气供应站</label>
							      <input type="checkbox"  class="input-position" lay-skin="primary"  title="点添加" id="yhqgyz" value="yhqgyz" name="choice" onClick="return_build_data(this.value)" >
							      </div>
							  </dd>
							   <dd>	
						      	<div class="layui-form-item" pane="">
							      <label class="layui-form-label">通信基站</label>
							      <input type="checkbox" class="input-position" lay-skin="primary"  title="点添加" id="txjz" value="txjz" name="choice" onClick="return_build_data(this.value)" >
							      </div>
							  </dd>

						    </dl>
						  </li>
						  <li class="layui-nav-item">
						    <a href="javascript:;">生命线工程</a>
						    <dl class="layui-nav-child">
						      <dd>  
							     <div class="layui-form-item" pane="">
							      <div style="float:left;">
							      <label class="layui-form-label">t10kv:</label>
							      <!-- addLineColor()这个函数是让用户可以更改颜色  addmapline()不让用户更改颜色  根据不同需求更改onclick事件触发的方法  下面的也是一样-->
							      <input type="checkbox" lay-skin="primary" id="t10kv" class="lineCheckBox" title="点击" value="t10kv" onClick="addLineColor(this.value)">
							      </div>
							       <!-- 颜色选择器，用户如果不需要更改颜色可以注释掉  下面的也是一样-->
							       <div style="float:right; margin-right: 40px;margin-top: 8px;">
							          <input id="color1" class="color" value="#AA5566" type="color_text2" style="width=25px;height=20px;"> 
							        </div>
							      </div>
							  </dd>
						      <dd>	
						      	<div class="layui-form-item" pane="">
						      	<div style="float:left;">
							      <label class="layui-form-label">t66kv:</label>
							      <input type="checkbox" lay-skin="primary" id="t66kv" class="lineCheckBox" title="点击" value="t66kv" onClick="addLineColor(this.value)">
							    </div> 
							      <div style="float:right; margin-right: 40px;margin-top: 8px;">
							           <input id="color2" type="color_text2" value="#E6941A" class="color" style="width=25px;height=20px;"> 
							       </div>
							      </div>
							  </dd>
						      <dd>	
						      	<div class="layui-form-item" pane="">
						      	<div style="float:left;">	
							      <label class="layui-form-label">t220kv:</label>
							      <input type="checkbox" lay-skin="primary" id="t220kv" class="lineCheckBox" title="点击" value="t220kv" onClick="addLineColor(this.value)">
							    </div>  
							       <div style="float:right; margin-right: 40px;margin-top: 8px;">
							            <input id="color3" type="color_text2" value="#78439B" class="color" style="width=25px;height=20px;"> 
							       </div>
							      </div>
							  </dd>
						      <dd>	
						      	<div class="layui-form-item" pane="">
						      	<div style="float:left;">	
							      <label class="layui-form-label">燃气管线:</label>
							      <input type="checkbox" lay-skin="primary" id="rqgx" class="lineCheckBox" title="点击" value="rqgx" onClick="addLineColor(this.value)">
							    </div>   
							       <div style="float:right; margin-right: 40px;margin-top: 8px;">
							           <input id="color4" type="color_text2" value="#5E5EA2" class="color" style="width=25px;height=20px;"> 
							       </div>
							      </div>
							  </dd>
							   <dd>  
							      	<div class="layui-form-item" pane="">
							      <div style="float:left;">		
							      <label class="layui-form-label">输水管线:</label>
							      <input type="checkbox" lay-skin="primary" id="ssgx" class="lineCheckBox" title="点击" value="ssgx"  onClick="addLineColor(this.value)">
							      </div>  
							       <div style="float:right; margin-right: 40px;margin-top: 8px;">
							           <input id="color5" type="color_text2" value="#09F7F7" class="color" style="width=25px;height=20px;"> 
							       </div>
							      </div>
							  </dd>
						      <dd>	
						      	<div class="layui-form-item" pane="">
						      	<div style="float:left;">	
							      <label class="layui-form-label">污水管线:</label>
							      <input type="checkbox" lay-skin="primary" id="wsgx" class="lineCheckBox" title="点击" value="wsgx"  onClick="addLineColor(this.value)">
							    </div>
							       <div style="float:right; margin-right: 40px;margin-top: 8px;">
							            <input id="color6" type="color_text2" value="#A25E5E" class="color" style="width=25px;height=20px;"> 
							       </div>
							      </div>
							  </dd>
						      <dd>	
						      	<div class="layui-form-item" pane="">
						      	<div style="float:left;">	
							      <label class="layui-form-label">新建管线:</label>
							      <input type="checkbox" lay-skin="primary" id="xjgx" class="lineCheckBox" title="点击" value="xjgx"  onClick="addLineColor(this.value)">
							    </div>  
							       <div style="float:right; margin-right: 40px;margin-top: 8px;">
							            <input id="color7" type="color_text2" value="#0099FF" class="color" style="width=25px;height=20px;"> 
							       </div>
							      </div>
							  </dd>
						      <dd>	
						      	<div class="layui-form-item" pane="">
						      	<div style="float:left;">	
							      <label class="layui-form-label">雨水管线:</label>
							      <input type="checkbox" lay-skin="primary" id="ysgx" class="lineCheckBox" title="点击" value="ysgx"  onClick="addLineColor(this.value)">
							    </div>  
							       <div style="float:right; margin-right: 40px;margin-top: 8px;">
							            <input id="color8" type="color_text2" value="#1AE66B" class="color" style="width=25px;height=20px;"> 
							       </div>
							      </div>
							  </dd>
							   <dd>  
							      	<div class="layui-form-item" pane="">
							     <div style="float:left;"> 		
							      <label class="layui-form-label">防灾疏散通道</label>
							      <input type="checkbox" lay-skin="primary" id="fzsstd" class="lineCheckBox" title="点击" value="fzsstd"  onClick="addLineColor(this.value)">
							    </div> 
							       <div style="float:right; margin-right: 40px;margin-top: 8px;">
							           <input id="color9" type="color_text2" value="#F37150" class="color" style="width=25px;height=20px;">  
							       </div>
							      </div>
							  </dd>
						      <dd>	
						      	<div class="layui-form-item" pane="">
						      	<div style="float:left;">	
							      <label class="layui-form-label">现有通信线路:</label>
							      <input type="checkbox" lay-skin="primary" id="xytxxl" class="lineCheckBox" title="点击" value="xytxxl" onClick="addLineColor(this.value)">
							    </div> 
							      <div style="float:right; margin-right: 40px;margin-top: 8px;">
							           <input id="color10" type="color_text2"  value="#A3A89B" class="color" style="width=25px;height=20px;"> 
							       </div>
							      </div>
							  </dd>
						      <dd>	
						      	<div class="layui-form-item" pane="">
						      	<div style="float:left;">	
							      <label class="layui-form-label">供热现状管线:</label>
							      <input type="checkbox" lay-skin="primary" id="grxzgx" class="lineCheckBox" title="点击" value="grxzgx"  onClick="addLineColor(this.value)">
							    </div>   
							       <div style="float:right; margin-right: 40px;margin-top: 8px;">
							            <input id="color11" type="color_text2" value="#E76108" class="color" style="width=25px;height=20px;"> 
							       </div>
							      </div>
							  </dd>
							  <dd>	
						      	<div class="layui-form-item" pane="">
						      	<div style="float:left;">	
							      <label class="layui-form-label">主要道路:</label>
							      <input type="checkbox" lay-skin="primary" id="zydl" class="lineCheckBox" title="点击" value="zydl"  onClick="addLineColor(this.value)">
							    </div>   
							       <div style="float:right; margin-right: 40px;margin-top: 8px;">
							            <input id="color12" type="color_text2" value="#E76888" class="color" style="width=25px;height=20px;"> 
							       </div>
							      </div>
							  </dd>
							  <dd>	
						      	<div class="layui-form-item" pane="">
						      	<div style="float:left;">	
							      <label class="layui-form-label">断裂带:</label>
							      <input type="checkbox" lay-skin="primary" id="fault_zone_copy" class="lineCheckBox" title="点击" value="fault_zone_copy"  onClick="addLineColor(this.value)">
							    </div>   
							       <div style="float:right; margin-right: 40px;margin-top: 8px;">
							            <input id="color13" type="color_text2" value="#E52168" class="color" style="width=25px;height=20px;"> 
							       </div>
							      </div>
							  </dd>
						    </dl>
						  </li>
						  
						  <li class="layui-nav-item">
						    <a href="javascript:;">图层清理</a>
						    <dl class="layui-nav-child">
						      <dd><a onClick="removeAllPolyline()" href="javascript:;">清理线图层</a></dd>
						      <dd><a onClick="removeAllMarker()"  href="javascript:;">清理点图层</a></dd>
						      <dd><a onClick="removeOver()" href="javascript:;">清理面图层</a></dd>
						    </dl>
						  </li>
						</ul>
                </div>
			</div>
			<div class="layui-body" style="bottom: 0;border-left: solid 2px #1AA094;" id="admin-body">
					<div class="layui-tab-content" style="height:240px;min-height: 160px; padding: 2px 0 0 0;">
						<div class="layui-tab-item layui-show">				
						<div style="height: 150px;width: 150px;background: white;position: absolute;z-index: 1;display: none;" id="legend" >
							<center>
								<h2>破坏程度图示</h2>
							</center>
							<table width="100%" border="0" cellspacing="1" cellpadding="4" style="text-align: center;">
								<tr>
									<td><image src="public/images/pipi/marker5.png"></td>
									<td>良好</td>
								</tr>
								<tr>
									<td><image src="public/images/pipi/marker4.png"></td>
									<td>轻微破坏</td>
								</tr>
								<tr>
									<td><image src="public/images/pipi/marker3.png"></td>
									<td>中等破坏</td>
								</tr>
								<tr>
									<td><image src="public/images/pipi/marker1.png"></td>
									<td>严重破坏</td>
								</tr>
								<tr>
									<td><image src="public/images/pipi/marker1.png"></td>
									<td>毁坏</td>
								</tr>
								<tr>
									<td><image src="public/images/pipi/marker.png"></td>
									<td>不在主要烈度圈内</td>
								</tr>
							</table>
						</div>	 	
						    <div id="allmap" width="100%" style="width:100%;height:928px;margin-top:0px;overflow-y:hidden;border-width:1px;border-radius:8px;border-color: rgb(181, 207, 216);"></div>
						</div>
					</div>

			</div>
			<div class="site-tree-mobile layui-hide">
				<i class="layui-icon">&#xe602;</i>
			</div>
			<div class="site-mobile-shade"></div>
   <div id="moreparams" style="padding-left:118px;height:30px;" id="ctlDiv"> 
     <div id="posdetail" style="display:none;position: relative; float:left;padding-left:20px;">
     left:<input class="inputtext" type="input" id="xpos"  value="300"></input>&nbsp;
     top:<input class="inputtext" type="input" id="ypos"  value="250"></input>&nbsp;
     width:<input class="inputtext" type="input" id="width"  value="2052"></input>&nbsp;
     height:<input class="inputtext" type="input" id="height"  value="970"></input>
     </div>
    </div> 
    <iframe id="downCapture" style="display:none;"></iframe>

			<!--锁屏模板 start-->
			<!-- <script type="text/template" id="lock-temp">
			// 	<div class="admin-header-lock" id="lock-box">
			// 		<div class="admin-header-lock-img">
			// 			<img src="public/images/0.jpg"/>
			// 		</div>
			// 		<div class="admin-header-lock-name" id="lockUserName">Admin</div>
			// 		<input type="text" class="admin-header-lock-input" value="输入密码解锁.." name="lockPwd" id="lockPwd" />
			// 		<button class="layui-btn layui-btn-small" id="unlock">解锁</button>
			// 	</div>
			 </script>-->
			<!--锁屏模板 end -->

			<script type="text/javascript" src="public/plugins/layui/layui.js"></script>
			
			<script src="public/js/index.js"></script>
			<script type="text/javascript">
			$(document).ready(function(){
				var map=$("#allmap");
				map.css({
					"width":"100%"
				})
			})




			
			function checkAll() {
			var all=document.getElementById('syjzw');//获取到点击全选的那个复选框的id
			var one=document.getElementsByName('choice');//获取到复选框的名称
			//因为获得的是数组，所以要循环 为每一个checked赋值
			for(var i=0;i<one.length;i++){
				if(one[i].checked!=all.checked){
					one[i].checked=all.checked;
					return_build_data(one[i].value)
				}
			}
			}





			</script>
			<script>
			var intensity1=0;//初始震级
			var no;//前台获取的输入的楼号或建筑名称
            //这里是参数设置弹出框的布局圆形
            function paramaterSetting(){
				$("#close").css("display","block");
            	layer.open({
				  title: '参数设置'
				  ,content: '</br></br><div class="layui-form-item"><div class="layui-inline"><label class="layui-form-label">震&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp级:</label><div class="layui-input-inline"><input type="text" id="earthquakeMagnitude" class="layui-input"></div><div class="layui-form-mid layui-word-aux">MS</div></div></div>'
				,btn:['确定']
				,area: ['450px', '270px']
				  ,yes: function(index, layero){
                    map.clearOverlays();
                    $("[class='input-position']").removeAttr("checked");//取消全选
				    intensity1=document.getElementById('earthquakeMagnitude').value;
				    if(!intensity1){
                      layer.msg("数据为空！ ");
				    }else{
                         if(intensity1>8.0||intensity1<4.0){
                               layer.msg("请输入震级小于8.0级，大于等于4.5级！",{icon:5});
                         }else{
                         	 sign="circle";
                         	 getCirclePoint(sign);//设置震源
                         	 layer.close(index);
                         }
				    }
				   
				  }				  
				});     
            }
			//精确输入
			function paramaterSetting1(){
				$("#close").css("display","block");
        	layer.open({
			  	title: '参数设置',
			  	content: '<div class="layui-form-item"><div class="layui-inline"><label class="layui-form-label">经&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp度:</label><div class="layui-input-inline"><input type="text" id="earthquakeLongtitude" class="layui-input"></div></div><div class="layui-inline"><label class="layui-form-label">纬&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp度:</label><div class="layui-input-inline"><input type="text" id="earthquakeLatitude" class="layui-input"></div></div><div class="layui-inline"><label class="layui-form-label">震&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp级:</label><div class="layui-input-inline"><input type="text" id="earthquakeMagnitude" class="layui-input"></div><div class="layui-form-mid layui-word-aux">MS</div></div></div>',
			  	btn:['确定'],
			  	area: ['450px', '270px'],
			  	yes: function(index, layero){
                	map.clearOverlays();
                	$("[class='input-position']").removeAttr("checked");//取消全选
			    	intensity1=document.getElementById('earthquakeMagnitude').value;
			    	startX=document.getElementById('earthquakeLongtitude').value;
			    	startY=document.getElementById('earthquakeLatitude').value;
			    	if(!intensity1||!startX||!startY){
						layer.msg("数据为空！ ");
			    	}else{
                     	if(intensity1>8.0||intensity1<4.0){
							layer.msg("请输入震级小于8.0级，大于等于4.5级！",{icon:5});
                    	}else{
							sign="circle";
                     		var myIcon = new BMap.Icon("public/hui_images/circle.png", new BMap.Size(16,16));
                     		var startMarker = new BMap.Marker(new BMap.Point(startX,startY),{icon:myIcon});
	            			map.addOverlay(startMarker);
							drawCircle();//设置震源
							clearEchartCookie()
							setTimeout("StartCapture('A')",1000);
							var point = new BMap.Point(startX,startY);
                     		var gc = new BMap.Geocoder();
							var opts = {
	                          width : 200,     // 信息窗口宽度
							  height: 100,     // 信息窗口高度
							  title : "震中地址" , // 信息窗口标题
							  enableMessage:true,//设置允许信息窗发送短息
		                    }

		                    gc.getLocation(point, function(rs){
							   var addComp = rs.addressComponents;
							   var html=addComp.province + addComp.city + addComp.district + addComp.street;
							   var infoWindow = new BMap.InfoWindow("地址："+html+"<br>经度："+startX+"<br>纬度："+startY+"", opts);
							   map.openInfoWindow(infoWindow,point); //开启信息窗口
							   startMarker.addEventListener("click", function(){          
							   map.openInfoWindow(infoWindow,point); //开启信息窗口
							});
							});
							
							
                     		layer.close(index);
                     	}
			    	}
			   	}				  
			});
        }
            var H=0;//得到震源深度
            var D=0;//得到震中距
            var A=0;//得到偏转角度
            var R=0;//算出震源到目标区域的距离
            var M=0;//震级
            var capturearray=new Array();
            //这里是绘制烈度图函数
            var sign=null;//标记是哪一种绘制烈度
            function drawIntensity(){
                layer.open({
                    title: '参数设置'
                    ,content: '<div class="layui-form-item"><div class="layui-inline"><label class="layui-form-label">震&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp级:</label><div class="layui-input-inline"><input  lay-verify="required" type="text" id="intensity" class="layui-input"></div><div class="layui-form-mid layui-word-aux">MS</div></div><div class="layui-inline"><label class="layui-form-label">震源深度:</label><div class="layui-input-inline"><input  lay-verify="requiredtype="text" id="H" class="layui-input"></div><div class="layui-form-mid layui-word-aux">千米</div></div><div class="layui-inline"><label class="layui-form-label">震&nbsp&nbsp中&nbsp&nbsp距:</label><div class="layui-input-inline"><input type="text" id="D" class="layui-input"></div><div class="layui-form-mid layui-word-aux">千米</div></div><div class="layui-inline"><label class="layui-form-label">旋转角度:</label><div class="layui-input-inline"><input type="text" id="A" class="layui-input"></div><div class="layui-form-mid layui-word-aux">度</div></div></div>'
                    ,btn:['确定']
                    ,area: ['450px', '320px']
                    ,yes: function(index, layero){
                    	map.clearOverlays();
                        H =document.getElementById("H").value;//得到震源深度
                        D =document.getElementById("D").value;//得到震中距
                        A =document.getElementById("A").value;//得到偏转角度
                        R =Math.sqrt(Math.pow(H,2)+Math.pow(D,2));//算出震源到目标区域的距离
                        M =document.getElementById("intensity").value;//震级
                        if (!H||!D||!A||!R||!M) {
                            layer.alert("请填写数据",{icon:2});
                        }else if(M<6){
                        	layer.alert("只支持震级大于等于6级的显示！",{icon:5});
                        }
                        else{
                         sign="oval";//椭圆
                         getCirclePoint(sign);//设置震源
                         layer.close(index);
                        }
                       
                       
                    }
                });
			}
			//椭圆烈度图精确输入
			function drawIntensity1(){
                layer.open({
					title: '参数设置'
					
                    ,content: '<div class="layui-form-item"><div class="layui-inline"><label class="layui-form-label">经&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp度:</label><div class="layui-input-inline"><input lay-verify="required" type="text" id="e_lng" class="layui-input"></div></div><div class="layui-inline"><label class="layui-form-label">纬&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp度:</label><div class="layui-input-inline"><input lay-verify="required" type="text" id="e_lat" class="layui-input"></div></div><div class="layui-inline"><label class="layui-form-label">震&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp级:</label><div class="layui-input-inline"><input  lay-verify="required" type="text" id="intensity" class="layui-input"></div><div class="layui-form-mid layui-word-aux">MS</div></div><div class="layui-inline"><label class="layui-form-label">震源深度:</label><div class="layui-input-inline"><input  lay-verify="requiredtype="text" id="H" class="layui-input"></div><div class="layui-form-mid layui-word-aux">千米</div></div><div class="layui-inline"><label class="layui-form-label">震&nbsp&nbsp中&nbsp&nbsp距:</label><div class="layui-input-inline"><input type="text" id="D" class="layui-input"></div><div class="layui-form-mid layui-word-aux">千米</div></div><div class="layui-inline"><label class="layui-form-label">旋转角度:</label><div class="layui-input-inline"><input type="text" id="A" class="layui-input"></div><div class="layui-form-mid layui-word-aux">度</div></div></div>'
                    ,btn:['确定']
                    ,area: ['450px', '320px']
                    ,yes: function(index, layero){
                    	map.clearOverlays();
                        H =document.getElementById("H").value;//得到震源深度
                        D =document.getElementById("D").value;//得到震中距
                        A =document.getElementById("A").value;//得到偏转角度
                        R =Math.sqrt(Math.pow(H,2)+Math.pow(D,2));//算出震源到目标区域的距离
						M =document.getElementById("intensity").value;//震级
						startX=document.getElementById("e_lng").value;
						startY=document.getElementById("e_lat").value;
                        if (!H||!D||!A||!R||!M) {
                            layer.alert("请填写数据",{icon:2});
                        }else if(M<6){
                        	layer.alert("只支持震级大于等于6级的显示！",{icon:5});
                        }
                        else{
						 sign="oval";//椭圆
						 var myIcon = new BMap.Icon("public/hui_images/circle.png", new BMap.Size(16,16));
						 var startMarker = new BMap.Marker(new BMap.Point(startX,startY),{icon:myIcon});
						 startMarker.flag="marker";
						map.addOverlay(startMarker);
						if(sign=="oval"){
						drawOval(startX,startY);
						setTimeout("StartCapture('A')",1000);
						}else{
						drawCircle();
						setTimeout("StartCapture('A')",1000);
						}
						map.removeEventListener("click",endClickPoint);

                        var point = new BMap.Point(startX,startY);
                     		var gc = new BMap.Geocoder();
							var opts = {
	                          width : 200,     // 信息窗口宽度
							  height: 100,     // 信息窗口高度
							  title : "震中地址" , // 信息窗口标题
							  enableMessage:true,//设置允许信息窗发送短息
		                    }

		                    gc.getLocation(point, function(rs){
							   var addComp = rs.addressComponents;
							   var html=addComp.province + addComp.city + addComp.district + addComp.street;
							   var infoWindow = new BMap.InfoWindow("地址："+html+"<br>经度："+startX+"<br>纬度："+startY+"", opts);
							   map.openInfoWindow(infoWindow,point); //开启信息窗口
							   startMarker.addEventListener("click", function(){          
							   map.openInfoWindow(infoWindow,point); //开启信息窗口
							});
							});
                         layer.close(index);
                        }
                       
                       
                    }
                });
            }
            //这里是模糊查询弹出框的布局
            function  fuzzysearch(){
            	layer.open({
				  title: '模糊查询'
				  ,content: '</br></br><div class="layui-form-item"><div class="layui-inline"><label class="layui-form-label">建筑名:</label><div class="layui-input-inline"><input type="text" id="contents" class="layui-input"></div></div></div>'
				,btn:['确定']
				,area: ['380px', '270px']
				  ,yes: function(index, layero){
				    var buildingName=document.getElementById('contents').value;
				    if (!buildingName) {
				    	layer.alert("查询不能为空",{icon:2});
				    }else{
                     return_search_build_data(buildingName);
				    layer.close(index);
				    }   
				  }				  
				});    
            }
            //excel导入
            function  excelImport(){
				
            	layer.open({
				  title: 'Excel导入'
				  ,content: '</br></br><div class="layui-form-item"><div class="layui-inline"><label class="layui-form-label">文件:</label><div class="layui-input-inline"><label for="upfile"><input type="button" class="layui-btn"  value="点我上传" style="margin-right: 10px;"><span id="text" >未上传文件</span> <input type="file" id="upfile" style="position: absolute;left: 0;top: 0;opacity: 0;"></label></div></div></div>'
				,btn:['确定']
				,area: ['400px', '270px']
				  ,yes: function(index, layero){
				  	if($("#upfile").val()!=""){
				  		filename = $("#upfile").val();
				  		if(filename.indexOf("xlsx")<0&&filename.indexOf("xls")<0)
				        {
				          layer.msg("请选择格式为.xlsx或.xls的文件！");
				          return false;
				        }
				  		var index = layer.load(2,{offset: ['430px','690px']},{shade: false});//load时间太短反应不过来，加延迟
					  	setTimeout(() => {
								EdataAdd(index);
					    }, 10);  
				  	}else{
				  		layer.msg("请选择excel文件");
				  	}
					
				  },
				  success: function(layero, index){
					$("#upfile").change(function () {
						//console.log($("#upfile")[0].files.name)
        				$("#text").html($("#upfile")[0].files[0].name);
    				})
  				  }				  
				});    
            }
			//数据管理
			function dataManage(){
				window.open('index.php/Welcome/dataManage');
			}
      //根据区县查询街道pipi 
       var streetQuery2;//街道查询    
function countryQuery(){
var county= document.getElementById('sensor1').value;
//alert(c);
  
      	//alert("触发2");
      	  var url="index.php/Data/countrySearch_C";
             
              $.ajax({  
                type:'post',   //方法  
                url:url,      //文件路径  
                dataType:'text',//用的是什么字符，json字符在js中相当有优势  
                data:{"county":county},//data:"IntensityValue=" + params,//要传送的数据  
                async: true,//是否同步或者异步  
                success:function(data){//查错  
                    var data= eval("("+data+")");
                       markerArr=data;

                      if(data==""){
                       layer.alert("查无此处",{icon:5});
                      }else{    	
	                streetQuery2='<option>请选择</option>';
                      	for (var i = 0; i < markerArr.length; i++) {
                      		streetQuery2+='<option>'+markerArr[i].streetOrTown+'</option>';
                      }
                  		$("#streetOrTown3").empty();//每次加载前清除缓存
                  	    $("#streetOrTown3").append(streetQuery2);//在下拉菜单中加如何查询的数据 
                 x
                  }
                },  
                error: function (data) {     
                        layer.alert(data,{icon:0});
              }  
          });
 
      }



//绘制chart弹出框的布局
//绘制chart弹出框的布局
			function  initChartView(UntouchNum,SlightNum,ModerateNum,SeriusNum,CollaPNum,viewtype){
				 //计算总和
			      var sumNum=UntouchNum.sum()+SlightNum.sum()+ModerateNum.sum()+SeriusNum.sum()+CollaPNum.sum();
			      //样本总和
			      var sumSam=sumNum;
			      //抽样调查
			      var UntouchSam=UntouchNum.sum();
			      var SlightSam=SlightNum.sum();
			      var ModerateSam=ModerateNum.sum();
			      var SeriusSam=SeriusNum.sum();
			      var CollapSam=CollaPNum.sum();
			      //计算比例
			      var UntouchRat=UntouchNum.sum()/sumNum*100;//良好
			      var SlightRat=SlightNum.sum()/sumNum*100;//轻微
			      var ModerateRat=ModerateNum.sum()/sumNum*100;//中度
			      var SeriusRat=SeriusNum.sum()/sumNum*100;//严重
			      var CollapRat=CollaPNum.sum()/sumNum*100;//毁坏
			      var SumRat=UntouchRat+SlightRat+ModerateRat+SeriusRat+CollapRat;
			      //四舍五入并保留两位小数
			      UntouchRat=UntouchRat.toFixed(2);
			      UntouchRat=(UntouchRat=='NaN')?0:UntouchRat;
			      SlightRat=SlightRat.toFixed(2);
			      SlightRat=(SlightRat=='NaN')?0:SlightRat;
			      ModerateRat=ModerateRat.toFixed(2);
			      ModerateRat=(ModerateRat=='NaN')?0:ModerateRat;
			      SeriusRat=SeriusRat.toFixed(2);
			      SeriusRat=(SeriusRat=='NaN')?0:SeriusRat;
			      CollapRat=CollapRat.toFixed(2);
			      CollapRat=(CollapRat=='NaN')?0:CollapRat;
				  SumRat=(UntouchRat=='NaN'&&SlightRat=='NaN'&&ModerateRat=='NaN'&&SeriusRat=='NaN'&&CollapRat=='NaN')?0:SumRat;
				  
				  if(isNaN(SumRat)){
					SumRat=0;
				  }
				  SumRat=Math.round(SumRat);
				  if(SumRat>0){
					SumRat=100;
				  }
            	layer.open({
				  title: '数据分析'
				  ,content: '<div id="chart" style="width:950px;height:420px"></div><div class="layui-form"><h1 style="float:right;margin-top:-428px;margin-right:378px;font-size:23px;"><strong>震区房屋破坏情况<br>(根据调查点计算)</h1><table class="layui-table" style="width:400px;height:283px;float:right;margin-top:-345px;margin-right:40px;><colgroup><col width="30%"><col width="33.3%"></colgroup><tbody><tr><th style="text-align:center;">破坏情况</th><th style="text-align:center;">房屋数(栋)</th><th style="text-align:center;">百分比(%)</th></tr></tbody><tbody><tr><th style="text-align:center;">良好</th><th style="text-align:center;">'+UntouchSam+'</th><th style="text-align:center;">'+UntouchRat+'</th></tr></tbody><tbody><tr><th style="text-align:center;">轻微破坏</th><th style="text-align:center;">'+SlightSam+'</th><th style="text-align:center;">'+SlightRat+'</th></tr></tbody><tbody><tr><th style="text-align:center;">中等破坏</th><th style="text-align:center;">'+ModerateSam+'</th><th style="text-align:center;">'+ModerateRat+'</th></tr></tbody><tbody><tr><th style="text-align:center;">严重破坏</th><th style="text-align:center;">'+SeriusSam+'</th><th style="text-align:center;">'+SeriusRat+'</th></tr></tbody><tbody><tr><th style="text-align:center;">毁坏</th><th style="text-align:center;">'+CollapSam+'</th><th style="text-align:center;">'+CollapRat+'</th></tr></tbody><tbody><tr><th style="text-align:center;">总和</th><th style="text-align:center;">'+sumSam+'</th><th style="text-align:center;">'+SumRat+'</th></tr></tbody></table>'
				  /*content: '辖区/县:</br><select id="county" style="width:174px"><option value ="volvo">Volvo</option><option value ="saab">Saab</option><option value="opel">Opel</option><option value="audi">Audi</option><lect></br>街道/乡镇:</br><select id="town" style="width:174px"><option value ="volvo">Volvo</option><option value ="saab">Saab</option><option value="opel">Opel</option><option value="audi">Audi</option><lect></br>小区/胡同/村名/单位名:</br><input id="village" type="text"/></br>楼号/建筑物名称:</br><input id="building" type="text"/>'*/
				,btn:['确定']
				,area: ['1000px', '600px']
				  ,yes: function(index, layero)
				  { 
				  	if(viewtype==0){StartCapture('C');}
				  	else{StartCapture('D');}
				  	layer.close(index);					 
				  }
				  ,cancel: function()
				  {  				  
				  }			  
				});       
            }

          //这里是模糊查询统计结果弹出框的布局
            function  statisticalResult(buildinginfo){
            	var stingTable='<table class="layui-table" lay-skin="line"><colgroup><col width="50"><col width="150"></colgroup><thead><tr><th>序号</th> <th>地点</th></tr></thead><tbody>';
            	for(i=1;i<=buildinginfo.length;i++){
                 stingTable=stingTable+'<tr title="'+buildinginfo[i-1].baidu_X+','+buildinginfo[i-1].baidu_Y+'"onClick="locationPoint(this)" ><td>'+i+'</td><td>'+buildinginfo[i-1].buildingName+'-'+buildinginfo[i-1].admiPosition+'</td></tr>';	 
            	}
                stingTable=stingTable+'</tbody></table>';
            	layer.open({
				  title: '统计结果'
				  ,content: stingTable
				  ,btn:['关闭']
				  ,offset: 'rb'
				  ,shade: false
				  /*content: '辖区/县:</br><select id="county" style="width:174px"><option value ="volvo">Volvo</option><option value ="saab">Saab</option><option value="opel">Opel</option><option value="audi">Audi</option></select></br>街道/乡镇:</br><select id="town" style="width:174px"><option value ="volvo">Volvo</option><option value ="saab">Saab</option><option value="opel">Opel</option><option value="audi">Audi</option></select></br>小区/胡同/村名/单位名:</br><input id="village" type="text"/></br>楼号/建筑物名称:</br><input id="building" type="text"/>'*/
				 
				,area: ['220px', '500px']
				,yes: function(index, layero){
					layer.close(index);
				}
				  ,cancel: function()
				  {  
				  }				  
				}); 
			   lastPoint = 1 ;//全局变量，记录上次的点
               countPoint = 0;	    
            }

            //建筑信息绘制表格弹出框的布局
            function chartInfo(i){

            	layer.open({
				  title: '图表信息'
				  ,content:'<table class="layui-table" lay-even="" lay-skin="row"><colgroup><col width="150"><col width="150"><col width="200"><col></colgroup><thead><tr><th>属性</th><th>信息</th></tr> </thead><tbody><tr><td>建筑物编号</td><td>'+markerArr[i].buildingNumber+'</td></tr><tr><td>经度</td><td>'+markerArr[i].baidu_X+'</td></tr><tr><td>纬度</td><td>'+markerArr[i].baidu_Y+'</td></tr><tr><td>建筑类别</td><td>'+markerArr[i].propertyType+'</td></tr><tr><td>建筑物名称</td></tr><tr><td>户主姓名</td><td>'+markerArr[i].nameOfHous+'</td></tr><tr><td>行政位置</td><td>'+markerArr[i].admiPosition+'</td></tr><tr><td>高度</td><td>'+markerArr[i].height+'</td></tr><tr><td>层数</td><td>'+markerArr[i].floor+'</td></tr><tr><td>建筑面积</td><td>'+markerArr[i].floorArea+'</td></tr><tr><td>建造年代</td><td>'+markerArr[i].constructionAge+'</td></tr><tr><td>结构类型1</td><td>'+markerArr[i].structureTypeOne+'</td></tr><tr><td>结构类型2</td><td>'+markerArr[i].structureTypeTwo+'</td></tr><tr><td>抗震设防烈</td><td>'+markerArr[i].earthquakeFortification+'</td></tr><tr><td>场地类别</td><td>'+markerArr[i].siteType+'</td></tr><tr><td>地基类型</td><td>'+markerArr[i].foundationType+'</td></tr><tr><td>基础类型</td><td>'+markerArr[i].baseType+'</td></tr><tr><td>外观及内部</td><td>'+markerArr[i].exteriorAndInterior+'</td></tr><tr><td>底层不利因</td><td>'+markerArr[i].underDisadvantage+'</td></tr><tr><td>散而不整</td><td>'+markerArr[i].scatAndNotWhole+'</td></tr><tr><td>脆而不延</td><td>'+markerArr[i].britWithoutDelay+'</td></tr><tr><td>偏而不匀</td><td>'+markerArr[i].partAndUneven+'</td></tr><tr><td>单而不冗</td><td>'+markerArr[i].simpButNotRedu+'</td></tr><tr><td>备注</td><td>'+markerArr[i].remarks+'</td></tr><tr><td>鉴定意见</td><td>'+markerArr[i].statusEvaluation+'</td></tr><tr><td>6度</td><td>'+markerArr[i].sixDegrEarthDam+'</td></tr><tr><td>7度</td><td>'+markerArr[i].sevenDegrEarthDam+'</td></tr><tr><td>8度</td><td>'+markerArr[i].eightDegrEarthDam+'</td></tr><tr><td>9度</td><td>'+markerArr[i].nineDegrEarthDam+'</td></tr><tr><td>10度</td><td>'+markerArr[i].tenDegrEarthDam+'</td></tr></tbody></table>'
				,area: ['600px', '400px']
				  ,yes: function(index, layero)
				  { 
				  	layer.close(index);
				  }
				  ,cancel: function()
				  {  
				  }			  
				});    
            }









////////////////
            //用户管理弹窗
            function userManage(){
                var contentStr;
                var str='<br/>';
                contentStr= '<div class="layui-form" ><button class="layui-btn" onclick="addUser()">添加用户</button><table class="layui-table"><colgroup><col width="20%"><col width="40%"><col width="40%"><col width="20%"><col></colgroup><thead><tr><th>序号 </th><th>用户名</th><th>密码</th><th>删除</th></tr> </thead><tbody>';
                var userMessage = new Array();
                userMessage=<?php echo json_encode($user);?>;
                var arr = new Array();
                arr= <?php echo json_encode($All);?>;
                for(var i=0;i<arr.length;i++){
                    str=str+'<tr><td>'+arr[i]['userID']+'</td><td>'+arr[i]['userName']+'</td><td>'+arr[i]['userPassword']+'</td><td><a href="index.php/Welcome/delUser/'+arr[i]['userID']+'/'+userMessage[0]['userID']+'"><button class="layui-btn layui-btn-small" ><i class="layui-icon"></i></button></a></td></tr>';
                }
                var $end='</tbody></table><center></center></div>';
                contentStr=contentStr+str+$end;
            	// onloadPage();
            	layer.open({
				    title: '用户管理'
                    ,content:contentStr
				    ,btn:['关闭窗口']
				    ,area: ['800px', '600px']
				    ,yes: function(index, layero)
				  { 
				  	
				  	layer.close(index);
				  }
				  ,cancel: function()
				  {  
				  }			  
				});          	
            }

            //添加用户页面
            function addUser(){
                layer.open({
                    title: '添加用户'
                    ,content: '<div class="layui-form-item"></br><div class="layui-inline"><label style="width:80px" class="layui-form-label" >用户名:</label><div class="layui-input-inline"><input type="text" id="userName" class="layui-input"  ></div></div><div class="layui-inline"><label style="width:80px" class="layui-form-label">密码:</label><div class="layui-input-inline"><input type="text" id="password" class="layui-input"></div></div></div>'
                    ,btn:['确定']
                    ,area: ['400px', '270px']
                    ,yes: function(index, layero)
                    {
                        userName =document.getElementById("userName").value;
                        password =document.getElementById("password").value;
						if(checkNull(userName) == false){
							layer.tips('用户名不能为空！','#userName');
						}else if(checkNull(password) == false){
							layer.tips('密码不能为空！','#password');
						}else{
							var url='index.php/Welcome/addUser/'+userName+'/'+password;//url
							$.ajax({
								type:"POST",   //方法
								url: url,      //文件路径
								dataType:"text",//用的是什么字符，json字符在js中相当有优势
								async: false,//是否同步或者异步
								success:function(data){//查错
									layer.msg('用户添加成功!');
									window.location.reload();
								},
								error: function (data) {
								}
							});
							layer.close(index);
						}
                        
                    }
                });
            }

           //为用户管理添加页码
        //    function onloadPage(){
	    //        layui.use(['laypage', 'layer'], function(){
		// 		  var laypage = layui.laypage
		// 		       ,layer = layui.layer;
		//            laypage({
		// 			  cont: $('#page'), //容器。值支持id名、原生dom对象，jquery对象,
		// 			  pages: 100, //总页数
		// 			  skip: true, //是否开启跳页
		// 			  skin: '#009688',
		// 			  groups: 3 //连续显示分页数
		// 			});
		//        });
        //   }




             //定位点
         var lastPoint = 1 ;//全局变量，记录上次的点
         var countPoint = 0;
function locationPoint(this_tab){
	          	var point_XY = this_tab.title;
	          	var coordinate=point_XY.split(",");
	          	//设置点击点为中心
	          	map.centerAndZoom(new BMap.Point(coordinate[0],coordinate[1]), 16);   // 重新设置中心点坐标和地图级别
	            var allOverlay = map.getOverlays();//获取所有覆盖物
	            // var lastPoint = 1 ;
	            for (var i = 1; i < allOverlay.length; i++) {

	             if(allOverlay[i].point!==undefined){

		        	if(allOverlay[i].point.lat==coordinate[1]&&allOverlay[i].point.lng==coordinate[0])
		        	  { 
		        	  	//把上次点击点设置为默认
		        	  	countPoint++;
		        	   if (countPoint==1&&i>1) { lastPoint=i; }
		               var myIconF = new BMap.Icon("public/images/pipi/marker.png", new BMap.Size(22,16),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
		               allOverlay[lastPoint].setIcon(myIconF);
		               lastPoint=i;//记录这次点击点
		               // var point = new BMap.Point(coordinate[0],coordinate[1]);
		               var myIconS = new BMap.Icon("public/hui_images/fullmarker.png", new BMap.Size(48,48),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
		               
		               //把这次点击点的图标marker1
		                allOverlay[i].setIcon(myIconS);
		              }
		           }

	             }
        }




//////////////////////
            //定位松原
            function songyuanLocation(){
            	map.centerAndZoom(new BMap.Point(124.81173189754,45.1794860515878), 11);   // 重新设置中心点坐标和地图级别
            }
///////////////////
			//数据导入
			function EdataAdd(_index){
				var formData = new FormData();
					var name = $("#upfile").val();
					formData.append("file",$("#upfile")[0].files[0]);
					formData.append("name",name);
					$.ajax({
						url : 'index.php/Data/EdataAdd',
						type : 'POST',
						async : true,
						data : formData,
						// 告诉jQuery不要去处理发送的数据
						processData : false,
						// 告诉jQuery不要去设置Content-Type请求头
						contentType : false,
						beforeSend:function(){
							console.log("正在进行，请稍候");
						},
						success : function(responseStr) {
							var data= eval("("+responseStr+")");
							layer.close(_index);
							if(data.status==true){
								layer.msg("导入成功！");
								setTimeout("window.open('index.php/Welcome/dataManage')",1000)
								// if(data.url!=null){
								// 	location.href=data.url;
								// }
							}else{		
								layer.msg("请完善数据！");
							}
						},
						error:function(data){
							console.log(data);
						}
					});
			}






///////////////////
         
            //图片管理 wz修改
            var secUntouchedIMG="";
            var secSlightDamageIMG="";
            var secModerateDamageIMG="";
            var secSeriousDamageIMG="";
            var secCollapsedIMG="";
            var buildingPictures="";
            function imageManage(){
            	secUntouchedIMG=getStationImage('untouched');
                secSlightDamageIMG=getStationImage('slightDamage');
		        secModerateDamageIMG=getStationImage('moderateDamage');
		        secSeriousDamageIMG=getStationImage('seriousDamage');
		        secCollapsedIMG=getStationImage('collapsed');
		        buildingPictures=getStationImage('buildingPictures');
            	 var contents='<div id="deleteclose" class="layui-form-item"><label class="layui-form-label">选择类型:</label><div class="layui-input-inline"><select class="quiz2" style="margin:5px 0 0 0;height:33px;width:200px;" id="imageSelecter" onchange="imageChange()" name="quiz2"><option value="select">选择类型</option><option value="buildingPictures">建筑物图片</option><option value="untouched">良好</option><option value="slightDamage" >轻微破坏</option><option value="moderateDamage">中等破坏</option><option value="seriousDamage">严重破坏</option><option value="collapsed">毁坏</option></select></div></div><div class="layui-form-item"><div style="float:left">';

            	 //良好
            	 	for (var i = 0; i < secUntouchedIMG.length; i++) {
                 	
                 	contents=contents+'<div style="margin-top:20px;padding:0 0 0 28px;width:150px;height:150px;" class="image" id="untouched" ><input style="position:relative;left:28px;top:40px;" type="checkbox" id="untouched'+i+'" value="'+secUntouchedIMG[i]+'" ><img  id="untouched" style="margin-top:20px;padding:0 0 0 28px;width:150px;height:150px;" src="'+secUntouchedIMG[i]+'"></div>'
                 	//alert(secUntouchedIMG[i]);
                 	}
            	 // 轻微破坏
                 	for (var i = 0; i < secSlightDamageIMG.length; i++) {
                 	
                 	contents=contents+'<div style="margin-top:20px;padding:0 0 0 28px;width:150px;height:150px;" class="image" id="slightDamage"><input style="position:relative;left:28px;top:40px;"  type="checkbox" id="slightDamage'+i+'" value="'+secSlightDamageIMG[i]+'" ><img  id="slightDamage" style="margin-top:20px;padding:0 0 0 28px;width:150px;height:150px;" src="'+secSlightDamageIMG[i]+'"></div>'
                 	}
                 // 中等破坏
                 	for (var i = 0; i < secModerateDamageIMG.length; i++) {
                 	
                 	contents=contents+'<div style="margin-top:20px;padding:0 0 0 28px;width:150px;height:150px;" class="image" id="moderateDamage" ><input style="position:relative;left:28px;top:40px;"  type="checkbox" id="moderateDamage'+i+'" value="'+secModerateDamageIMG[i]+'" ><img  id="moderateDamage" style="margin-top:20px;padding:0 0 0 28px;width:150px;height:150px;" src="'+secModerateDamageIMG[i]+'"></div>'
                 	}
                 // 严重破坏
                 	for (var i = 0; i < secSeriousDamageIMG.length; i++) {
                 	
                 	contents=contents+'<div style="margin-top:20px;padding:0 0 0 28px;width:150px;height:150px;" class="image" id="seriousDamage"><input style="position:relative;left:28px;top:40px;"  type="checkbox" id="seriousDamage'+i+'" value="'+secSeriousDamageIMG[i]+'" ><img id="seriousDamage" style="margin-top:20px;padding:0 0 0 28px;width:150px;height:150px;" src="'+secSeriousDamageIMG[i]+'"></div>'
                 	}
                 // 毁坏
                 	for (var i = 0; i < secCollapsedIMG.length; i++) {
                 	
                 	contents=contents+'<div style="margin-top:20px;padding:0 0 0 28px;width:150px;height:150px;" class="image" id="collapsed"><input style="position:relative;left:28px;top:40px;"  type="checkbox" id="collapsed'+i+'" value="'+secCollapsedIMG[i]+'" ><img  id="collapsed" style="margin-top:20px;padding:0 0 0 28px;width:150px;height:150px;" src="'+secCollapsedIMG[i]+'"></div>'
                 	}
                 	// 建筑物图片
                 	for (var i = 0; i < buildingPictures.length; i++) {
                 	
                 	contents=contents+'<div style="margin-top:20px;padding:0 0 0 28px;width:150px;height:150px;" class="image" id="buildingPictures"><input style="position:relative;left:28px;top:40px;"  type="checkbox" id="buildingPictures'+i+'" value="'+buildingPictures[i]+'" ><img  id="buildingPictures" style="margin-top:20px;padding:0 0 0 28px;width:150px;height:150px;" src="'+buildingPictures[i]+'"></div>'
                 	}
                 

                 contents=contents+'<div id="localImag" style="display:none"><img src="" id="preview" style="margin-top:20px;padding:0 0 0 28px;width:150px;height:150px;" /></div></div></div><div style="margin-top:50px" class="layui-form-item"><div class="layui-input-block" style="text-align:center;"><center><button class="layui-btn" lay-submit onclick="submitImage()" lay-filter="formDemo">添加图片</button><input name="simpleImage" type="file" id="upload" class="btn btn-info" onchange="javascript:setImagePreview()" style="display:none" />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<button class="layui-btn" lay-submit onclick="javascript:saveIMG()" lay-filter="formDemo">删除图片</button></center></div></div>';
                 
            	// contents= '<div class="layui-form-item"><label class="layui-form-label">选择类型:</label><div class="layui-input-inline"><select style="margin:5px 0 0 0;height:33px;width:200px;" id="imageSelecter" onchange="imageChange()" name="quiz2"><option value="select">选择类型</option><option value="untouched">良好</option><option value="slightDamage" >轻微破坏</option><option value="moderateDamage">中等破坏</option><option value="seriousDamage">严重破坏</option><option value="collapsed">毁坏</option></select></div></div><div class="layui-form-item"><div style="float:left"><img style="margin-top:20px;width:150px;height:150px;padding:0 0 0 28px" src="public/images/situationPicture/collapsed/03.jpg"><img style="margin-top:20px;padding:0 0 0 28px;width:150px;height:150px;" src="public/images/situationPicture/collapsed/01.jpg" ><img style="margin-top:20px;padding:0 0 0 28px;width:150px;height:150px;" src="public/images/situationPicture/collapsed/02.jpg"><img style="margin-top:20px;padding:0 0 0 28px;width:150px;height:150px;" src="public/images/situationPicture/collapsed/02.jpg"><img style="margin-top:20px;padding:0 0 0 28px;width:150px;height:150px;" src="public/images/situationPicture/collapsed/02.jpg"><img style="margin-top:20px;padding:0 0 0 28px;width:150px;height:150px;" src="public/images/situationPicture/collapsed/02.jpg"><img style="margin-top:20px;padding:0 0 0 28px;width:150px;height:150px;" src="public/images/situationPicture/collapsed/02.jpg"><img style="margin-top:20px;padding:0 0 0 28px;width:150px;height:150px;" src="public/images/situationPicture/collapsed/02.jpg"><div id="localImag" style="display:none"><img src="" id="preview" style="margin-top:20px;padding:0 0 0 28px;width:150px;height:150px;" /></div></div></div><div style="margin-top:50px" class="layui-form-item"><div class="layui-input-block" style="text-align:center;"><button class="layui-btn" lay-submit onclick="submitImage()" lay-filter="formDemo">添加图片</button><input name="simpleImage" type="file" id="upload" class="btn btn-info" onchange="javascript:setImagePreview()" style="display:none" /></div></div>';
            	layer.open({
				  title: '图片管理'
				  ,content: contents
				,btn:['保存']
				,area: ['840px', '570px']
				,yes: function(index, layero)
				  {
				    layer.close(index);

				  }			  
				});    
            }

            //处理上传图片
            function submitImage(){
            	document.getElementById('upload').click();
            }
           
           function imageChange(){

             var selecter = document.getElementById("imageSelecter");
             var imagevalue = selecter.options[selecter.selectedIndex].value;
             var imageID = selecter.options[selecter.selectedIndex].id;
             //selecter.options[selecter.selectedIndex].style="";
             // alert(imagevalue);
             var images =document.querySelectorAll(".image");
             // alert(images);
             for (var i = 0; i < images.length; i++) {
	                   images[i].style="margin-top:20px;padding:0 0 0 28px;width:150px;height:150px;";     
              }
             if (imagevalue!=='select') {
	             for (var i = 0; i < images.length; i++) {
	             	if(images[i].id!==imagevalue){
	                   images[i].style.display='none';
	             	}
	             }
             }

             // selecterIMG=getStationImage(imagevalue);
             // for (var i = 0; i < selecterIMG.length; i++) {
             	
             // }
             //  alert(selecterIMG);
           }
            //用来添加面板上的临时图片
            //wz修改
        function setImagePreview() {
	        var docObj=document.getElementById("upload");
	   			document.getElementById("localImag").style.display = 'block';
	        var imgObjPreview=document.getElementById("preview");
	                if(docObj.files && docObj.files[0]){
	                        //火狐下，直接设img属性
	                        imgObjPreview.style.display = 'block';
	                        imgObjPreview.style.width = '150px';
	                        imgObjPreview.style.height = '150px';
	                        imgObjPreview.style.padding = '64px 0 0 56px';
	                        //imgObjPreview.src = docObj.files[0].getAsDataURL();
	      //火狐7以上版本不能用上面的getAsDataURL()方式获取，需要一下方式
	      imgObjPreview.src = window.URL.createObjectURL(docObj.files[0]);
	                }else{
	                        //IE下，使用滤镜
	                        docObj.select();
	                        var imgSrc = document.selection.createRange().text;
	                        var localImagId = document.getElementById("localImag");
	                        //必须设置初始大小
	                        localImagId.style.width = "150px";
	                        localImagId.style.height = "150px";
	                        //图片异常的捕捉，防止用户修改后缀来伪造图片
						try{
	                            localImagId.style.filter="progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)";
	                            localImagId.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = imgSrc;
	                        }catch(e){
	                                layer.alert("您上传的图片格式不正确，请重新选择!",{icon:5});
	                                return false;
	                        }
	                        imgObjPreview.style.display = 'none';
	                        document.selection.empty();
	                }
	                /*
                     bin
	                */
	                var selecter = document.getElementById("imageSelecter");
	                var imagevalue = selecter.options[selecter.selectedIndex].value;
	                var fd = new FormData();
	                fd.append("upload", 1);
				    fd.append("upfile", $("#upload").get(0).files[0]);//$("#upfile").get(0).files[0]
				    $.ajax({
				      url: "index.php/Data/ajaxSaveIMG/"+imagevalue,
				      type: "POST",
				      processData: false,
				      contentType: false,
				      data: fd,
				      success: function(d) {
				      	if (d=='Failed') {
                           layer.alert("网络出错了",{icon:5});
				      	}
				        console.log(d);
				        layer.alert("上传成功",{icon:1});
				      }
				    });
	                return true;
        }
        //wz
        //删除图片
        function saveIMG(){
        	uN=getStationImage('untouched');
            sLD=getStationImage('slightDamage');
		    mOD=getStationImage('moderateDamage');
		    sED=getStationImage('seriousDamage');
		    cO=getStationImage('collapsed');
		    buildingPic=getStationImage('buildingPictures');
        	var fd=new Array();
        	for (var i = 0; i < uN.length; i++) {
        		if($("#untouched"+i).is(':checked')){
        			fd[i]=$("#untouched"+i).val();
        		}
        		else{
        			fd[i]="";
        		}
        	}
            for (var i = uN.length,j=0; i < uN.length+sLD.length; i++,j++) {
            	if($("#slightDamage"+j).is(':checked')){
        			fd[i]=$("#slightDamage"+j).val();
        		}
        		else{
        			fd[i]="";
        		}
            }
            for (var i = uN.length+sLD.length,j=0; i < uN.length+sLD.length+mOD.length; i++,j++) {
            	if($("#moderateDamage"+j).is(':checked')){
        			fd[i]=$("#moderateDamage"+j).val();
        		}
        		else{
        			fd[i]="";
        		}
            }
            for (var i = uN.length+sLD.length+mOD.length,j=0,arrayi=0; i < uN.length+sLD.length+mOD.length+sED.length; i++,j++) {
            	if($("#seriousDamage"+j).is(':checked')){
        			fd[i]=$("#seriousDamage"+j).val();
        		}
        		else{
        			fd[i]="";
        		}
            }
            for (var i = uN.length+sLD.length+mOD.length+sED.length,j=0,arrayi=0; i < uN.length+sLD.length+mOD.length+sED.length+cO.length; i++,j++) {
            	if($("#collapsed"+j).is(':checked')){
        			fd[i]=$("#collapsed"+j).val();
        		}
        		else{
        			fd[i]="";
        		}
            }
            for (var i = uN.length+sLD.length+mOD.length+sED.length+cO.length,j=0; i < uN.length+sLD.length+mOD.length+sED.length+cO.length+buildingPic.length; i++,j++) {
        		if($("#buildingPictures"+j).is(':checked')){
        			fd[i]=$("#buildingPictures"+j).val();
        		}
        		else{
        			fd[i]="";
        		}
        	}
        	$.ajax({
        		url: 'index.php/Data/saveIMG/',
        		type: 'POST',
        		data: {"param1": fd},
        		success:function(msg){
        			if(msg=="Success"){
        				layer.msg("删除成功",{icon:1});
        			}
        			
        			//layer.close(index);
        		}
        	});
        	
        }
            //获取帮助文档
            function help(){
            	window.location.href="public/help/松原震害预测系统帮助文档.docx";
            }

            //注销用户
            function logout(){
            	window.location.href="index.php/Welcome/index";
            }

			</script>
						<!--这里是窗体自适应-->
            <script>

		         var h = window.screen.height ;
		         var w = window.screen.width ;
		         if(h>1000){
		             $("#allmap").css("height",h*0.827);
		             $("#allmap").css("width",w*0.86);
		         }else if (h<=1000&&h>=900) {
		             $("#allmap").css("height",h*0.802);
		             $("#allmap").css("width",w*0.86);
		         }else if(h<900&&h>=800){
		             $("#allmap").css("height",h*0.79);
					 $("#allmap").css("width",w*0.86);
		         }else if(h<800&&h>=700){
		             $("#allmap").css("height",h*0.78);
		             $("#allmap").css("width",w*0.85);
		         }else{
		             $("#allmap").css("height",h*0.86);
		             $("#allmap").css("width",w*0.86);
		         }

		         //chart弹窗自适应
		         if(h>1000){
		             $("#chart").css("height",h*0.86);
		             $("#chart").css("width",w*0.86);
		         }else if (h<=1000&&h>=900) {
		             $("#chart").css("width",w*0.86);
		         }else if(h<900&&h>=800){
		             $("#chart").css("height",h*0.79);
					 $("#chart").css("width",w*0.86);
		         }else if(h<800&&h>=700){
		             $("#chart").css("height",h*0.78);
		             $("#chart").css("width",w*0.85);
		         }else{
		             $("#chart").css("height",h*0.86);
		             $("#chart").css("width",w*0.86);
		         }

		         //截图自适应
		         if(h>1000){
		             document.getElementById("xpos").value = document.getElementById("xpos").value * 0.8;
		             document.getElementById("ypos").value = document.getElementById("ypos").value * 0.8;
		             document.getElementById("width").value = document.getElementById("width").value * 0.8;
		             document.getElementById("height").value = document.getElementById("height").value * 0.8;
		         }else if (h<=1000&&h>=900) {
		             document.getElementById("xpos").value = document.getElementById("xpos").value * 0.84;
		             document.getElementById("ypos").value = document.getElementById("ypos").value * 0.84;
		             document.getElementById("width").value = document.getElementById("width").value * 0.84;
		             document.getElementById("height").value = document.getElementById("height").value * 0.84;
		         }else if(h<900&&h>=800){
		             document.getElementById("xpos").value = document.getElementById("xpos").value * 0.89;
		             document.getElementById("ypos").value = document.getElementById("ypos").value * 0.89;
		             document.getElementById("width").value = document.getElementById("width").value * 0.89;
		             document.getElementById("height").value = document.getElementById("height").value * 0.89;
		         }else if(h<800&&h>=700){
		             document.getElementById("xpos").value = document.getElementById("xpos").value * 1;
		             document.getElementById("ypos").value = document.getElementById("ypos").value * 1;
		             document.getElementById("width").value = document.getElementById("width").value * 1;
		             document.getElementById("height").value = document.getElementById("height").value * 1;
		         }else{
		             document.getElementById("xpos").value = document.getElementById("xpos").value * 0.86;
		             document.getElementById("ypos").value = document.getElementById("ypos").value * 0.86;
		             document.getElementById("width").value = document.getElementById("width").value * 0.86;
		             document.getElementById("height").value = document.getElementById("height").value * 0.86;
		         }
            </script>

		</div>
	</body>
<script language="javascript" src="public/pi_js/query.js"></script>
    
	<script type="text/javascript">
    //var startXY = new Array();
    var map;
    var source = {
    	lat : "",
    	lng : ""
    };
    function initMap() {
        createMap();												// 百度地图API功能

    }
    function createMap(){
        map = new BMap.Map("allmap");    						// 创建Map实例
        map.centerAndZoom(new BMap.Point(124.81173189754,45.1794860515878), 13);   // 初始化地图,设置中心点坐标和地图级别
        map.addControl(new BMap.MapTypeControl());   				// 添加地图类型控件
        map.setCurrentCity("松原");          						// 设置地图显示的城市 此项是必须设置的
        map.enableScrollWheelZoom(true);     						// 开启鼠标滚轮缩放
        window.map = map;
        map.addEventListener('mousemove',function(e){
				var c = e.point;
				if (!source.point) {
					var b = c.lng + "°E," + c.lat + "°N";
					var d = new BMap.Label(b, {
					    position: b,
					    offset: new BMap.Size(13, 20),
					    enableMassClear: false
					});
					d.setStyle({
					    background: "#fff",
					    border: "#999 solid 1px",
					    zIndex: 10000000
					});
					map.addOverlay(d);
					source.point = d;
	        	}else{
	        		var b = c.lng + "°E," + c.lat + "°N";
	        		var d = source.point;
	        		d.setPosition(c);
	        		d.setContent(b);
	        		source.point = d;
	        	}
			});
    }


   
    initMap();
     // LYBJS开始 
     /*
     **
     **这个方法是在onclick事件触发后，直接给要添加的线添加默认颜色，不能更改颜色，
     **
     */
  
   
 
</script>
<!-- 这里是color picker -颜色取色器 -->
<script src="public/js/color-picker.min.js"></script>
    <script>
    //把input转为box然后实现取色
        var input =document.querySelectorAll(".color");
     //var input = document.querySelectorAll('input');
    for (var i = 0, len = input.length; i < len; ++i) {
        //var input = document.querySelector('input'),
        box = document.createElement('div');

        box.className ='color-box';
        box.id='color-box'+i
        box.style.backgroundColor = input.value;
        box.setAttribute('data-color', input[i].value);
        input[i].parentNode.insertBefore(box, input[i]);
        input[i].type = 'hidden';

        var picker = new CP(box);

        picker.on("change", function(color) {
            input.value = '#' + color;
            this.target.value='#' + color;
            this.target.style.backgroundColor = '#' + color;
            this.target.style.float = 'left';
        });
    }

      //LYBJS结束

</script>
<!-- ljl写的输入数据-->
<script language="javascript" src="public/pi_js/query.js"></script>
<script type="text/javascript">
	function InputData(){
            layer.open({
            title: '输入数据'
            ,content:'<div class="layui-form-item"><div class="layui-inline"><label style="width:80px" class="layui-form-label" >建筑物编号:</label><div class="layui-input-inline"><input type="text" id="buildingNumber" class="layui-input" style="border-color:#807979"></div><div style="display:inline;color:red;font-size:22px;">*</div></div><div class="layui-inline"><label style="width:80px" class="layui-form-label">经度:</label><div class="layui-input-inline"><input type="text" id="X" class="layui-input" style="border-color:#807979"></div><div style="display:inline;color:red;font-size:22px;">*</div></div><div class="layui-inline"><label style="width:80px" class="layui-form-label">纬度:</label><div class="layui-input-inline"><input type="text" id="Y" class="layui-input" style="border-color:#807979"></div><div style="display:inline;color:red;font-size:22px;">*</div></div><div class="layui-inline"><label style="width:80px" class="layui-form-label">6度:</label><div class="layui-input-inline"><input type="text" id="6" class="layui-input" style="border-color:#807979"></div><div style="display:inline;color:red;font-size:22px;">*</div></div><div class="layui-inline"><label style="width:80px" class="layui-form-label">7度:</label><div class="layui-input-inline"><input type="text" id="7" class="layui-input" style="border-color:#807979"></div><div style="display:inline;color:red;font-size:22px;">*</div></div><div class="layui-inline"><label style="width:80px" class="layui-form-label">8度:</label><div class="layui-input-inline"><input type="text" id="8" class="layui-input" style="border-color:#807979"></div><div style="display:inline;color:red;font-size:22px;">*</div></div><div class="layui-inline"><label style="width:80px" class="layui-form-label">9度:</label><div class="layui-input-inline"><input type="text" id="9" class="layui-input" style="border-color:#807979"></div><div style="display:inline;color:red;font-size:22px;">*</div></div><div class="layui-inline"><label style="width:80px" class="layui-form-label">10度:</label><div class="layui-input-inline"><input type="text" id="10" class="layui-input" style="border-color:#807979"></div><div style="display:inline;color:red;font-size:22px;">*</div></div><div class="layui-inline"><label style="width:80px" class="layui-form-label">街道或乡镇:</label><div class="layui-input-inline"><input type="text" id="streetOrTown" class="layui-input" style="border-color:#807979"></div><div style="display:inline;color:red;font-size:22px;">* </div></div><div class="layui-inline"><label style="width:80px" class="layui-form-label">城市:</label><div class="layui-input-inline"><input type="text" id="city" class="layui-input" style="border-color:#807979"></div><div style="display:inline;color:red;font-size:22px;">*</div></div><div class="layui-inline"><label style="width:80px" class="layui-form-label">辖区或者县:</label><div class="layui-input-inline"><input type="text" id="popeOrCounty" class="layui-input" style="border-color:#807979"></div><div style="display:inline;color:red;font-size:22px;">*</div></div><div class="layui-inline"><label style="width:80px" class="layui-form-label">百度地图X:</label><div class="layui-input-inline"><input type="text" id="baidu_X" class="layui-input" style="border-color:#807979"></div></div><div class="layui-inline"><label style="width:80px" class="layui-form-label">百度地图Y:</label><div class="layui-input-inline"><input type="text" id="baidu_Y"  class="layui-input" style="border-color:#807979"></div>&nbsp;&nbsp;</div><div class="layui-inline"><label style="width:80px" class="layui-form-label">建筑类别:</label><div class="layui-input-inline"><input type="text" id="propertyType" class="layui-input" style="border-color:#807979"></div>&nbsp;&nbsp;</div><div class="layui-inline"><label style="width:80px" class="layui-form-label">建筑物名称:</label><div class="layui-input-inline"><input type="text" id="buildingName" class="layui-input" style="border-color:#807979"></div></div><div class="layui-inline"><label style="width:80px" class="layui-form-label">户主姓名:</label><div class="layui-input-inline"><input type="text" id="nameOfHous" class="layui-input" style="border-color:#807979"></div>&nbsp;&nbsp;</div><div class="layui-inline"><label style="width:80px" class="layui-form-label">行政位置:</label><div class="layui-input-inline"><input type="text" id="admiPosition" class="layui-input" style="border-color:#807979"></div>&nbsp;&nbsp;</div><div class="layui-inline"><label style="width:80px" class="layui-form-label">高度:</label><div class="layui-input-inline"><input type="text" id="height" class="layui-input" style="border-color:#807979"></div></div><div class="layui-inline"><label style="width:80px" class="layui-form-label">层数:</label><div class="layui-input-inline"><input type="text" id="floor" class="layui-input" style="border-color:#807979"></div>&nbsp;&nbsp;</div><div class="layui-inline"><label style="width:80px" class="layui-form-label">建筑面积:</label><div class="layui-input-inline"><input type="text" id="floorArea" class="layui-input" style="border-color:#807979"></div>&nbsp;&nbsp;</div><div class="layui-inline"><label style="width:80px" class="layui-form-label">建造年代:</label><div class="layui-input-inline"><input type="text" id="constructionAge" class="layui-input" style="border-color:#807979"></div></div><div class="layui-inline"><label style="width:80px" class="layui-form-label">结构类型1:</label><div class="layui-input-inline"><input type="text" id="structureTypeOne" class="layui-input" style="border-color:#807979"></div>&nbsp;&nbsp;</div><div class="layui-inline"><label style="width:80px" class="layui-form-label">结构类型2:</label><div class="layui-input-inline"><input type="text" id="structureTypeTwo" class="layui-input" style="border-color:#807979"></div>&nbsp;&nbsp;</div><div class="layui-inline"><label style="width:80px" class="layui-form-label">抗震设防烈:</label><div class="layui-input-inline"><input type="text" id="earthquakeFortification" class="layui-input" style="border-color:#807979"></div></div><div class="layui-inline"><label style="width:80px" class="layui-form-label">场地类别:</label><div class="layui-input-inline"><input type="text" id="siteType" class="layui-input" style="border-color:#807979"></div>&nbsp;&nbsp;</div><div class="layui-inline"><label style="width:80px" class="layui-form-label">场基类型:</label><div class="layui-input-inline"><input type="text" id="foundationType" class="layui-input" style="border-color:#807979"></div>&nbsp;&nbsp;</div><div class="layui-inline"><label style="width:80px" class="layui-form-label">基础类型:</label><div class="layui-input-inline"><input type="text" id="baseType" class="layui-input" style="border-color:#807979"></div></div><div class="layui-inline"><label style="width:80px" class="layui-form-label">外观及内部:</label><div class="layui-input-inline"><input type="text" id="exteriorAndInterior" class="layui-input" style="border-color:#807979"></div>&nbsp;&nbsp;</div><div class="layui-inline"><label style="width:80px" class="layui-form-label">底层不利因:</label><div class="layui-input-inline"><input type="text" id="underDisadvantage" class="layui-input" style="border-color:#807979"></div>&nbsp;&nbsp;</div><div class="layui-inline"><label style="width:80px" class="layui-form-label">散而不整:</label><div class="layui-input-inline"><input type="text" id="scatAndNotWhole" class="layui-input" style="border-color:#807979"></div></div><div class="layui-inline"><label style="width:80px" class="layui-form-label">脆而不延:</label><div class="layui-input-inline"><input type="text" id="britWithoutDelay" class="layui-input" style="border-color:#807979"></div>&nbsp;&nbsp;</div><div class="layui-inline"><label style="width:80px" class="layui-form-label">偏而不匀:</label><div class="layui-input-inline"><input type="text" id="partAndUneven" class="layui-input" style="border-color:#807979"></div>&nbsp;&nbsp;</div><div class="layui-inline"><label style="width:80px" class="layui-form-label">单而不冗:</label><div class="layui-input-inline"><input type="text" id="simpButNotRedu" class="layui-input" style="border-color:#807979"></div></div><div class="layui-inline"><label style="width:80px" class="layui-form-label">备注:</label><div class="layui-input-inline"><input type="text" id="remarks" class="layui-input" style="border-color:#807979"></div>&nbsp;&nbsp;</div><div class="layui-inline"><label style="width:80px" class="layui-form-label">鉴定意见:</label><div class="layui-input-inline"><input type="text" id="statusEvaluation" class="layui-input" style="border-color:#807979"></div>&nbsp;&nbsp;</div><div class="layui-inline"><label style="width:80px" class="layui-form-label">预测结果:</label><div class="layui-input-inline"><input type="text" id="predictOutcomes" class="layui-input" style="border-color:#807979"></div></div><div class="layui-inline"><label style="width:80px" class="layui-form-label">楼号:</label><div class="layui-input-inline"><input type="text" id="no" class="layui-input" style="border-color:#807979"></div>&nbsp;&nbsp;</div><div class="layui-inline"><label style="width:80px" class="layui-form-label">小区或单位:</label><div class="layui-input-inline"><input type="text" id="ToOrHuOrviOrCo" class="layui-input" style="border-color:#807979"></div></div><br><br><div style="margin-left:40px">注意：<div style="display:inline;color:red;font-size:22px;">* </div>为必填项</div></div>'
            ,btn:['确定']
            ,area: ['1050px', '720px']
            ,yes: function(index, layero)
            {
				buildingNumber=$('#buildingNumber').val();
				X=$('#X').val();
				Y=$('#Y').val();
				baidu_X=$('#baidu_X').val();
				baidu_Y=$('#baidu_Y').val();
				propertyType=$('#propertyType').val();
				buildingName=$('#buildingName').val();
				nameOfHous=$('#nameOfHous').val();
				admiPosition=$('#admiPosition').val();
				height=$('#height').val();
				floor=$('#floor').val();
				floorArea=$('#floorArea').val();
				constructionAge=$('#constructionAge').val();
				structureTypeOne=$('#structureTypeOne').val();
				structureTypeTwo=$('#structureTypeTwo').val();
				earthquakeFortification=$('#earthquakeFortification').val();
				siteType=$('#siteType').val();
				foundationType=$('#foundationType').val();
				baseType=$('#baseType').val();
				exteriorAndInterior=$('#exteriorAndInterior').val();
				underDisadvantage=$('#underDisadvantage').val();
				scatAndNotWhole=$('#scatAndNotWhole').val();
				britWithoutDelay=$('#britWithoutDelay').val();
				partAndUneven=$('#partAndUneven').val();
				simpButNotRedu=$('#simpButNotRedu').val();
				remarks=$('#remarks').val();
				statusEvaluation=$('#statusEvaluation').val();
				sixDegrEarthDam=$('#6').val();
				sevenDegrEarthDam=$('#7').val();
				eightDegrEarthDam=$('#8').val();
				nineDegrEarthDam=$('#9').val();
				tenDegrEarthDam=$('#10').val();
				predictOutcomes=$('#predictOutcomes').val();
				no=$('#no').val();
				ToOrHuOrviOrCo=$('#ToOrHuOrviOrCo').val();
				streetOrTown=$('#streetOrTown').val();
				city=$('#city').val();
				popeOrCounty=$('#popeOrCounty').val();
				//检验-------------------------------------------
				if(checkNull(buildingNumber) == false){
					layer.tips('建筑物编号不能为空！', '#buildingNumber');
				}else if(checkD(X) == false){
					layer.tips('请输入正确的经度值！', '#X');
				}else if(checkD(Y) == false){
					layer.tips('请输入正确的纬度值！', '#Y');
				}else if(checkNull(baidu_X)==true && checkD(baidu_X) == false){//百度XY可为空，但若填写，必为浮点型
					layer.tips('请输入正确的百度坐标X值！', '#baidu_X');
				}else if(checkNull(baidu_Y)==true && checkD(baidu_Y) == false){
					layer.tips('请输入正确的百度坐标Y值！', '#baidu_Y');
				}else if(checkNull(sixDegrEarthDam) == false){
					layer.tips('6度不能为空！', '#6');
				}else if(checkNull(sevenDegrEarthDam) == false){
					layer.tips('7度不能为空！', '#7');
				}else if(checkNull(eightDegrEarthDam) == false){
					layer.tips('8度不能为空！', '#8');
				}else if(checkNull(nineDegrEarthDam) == false){
					layer.tips('9度不能为空！', '#9');
				}else if(checkNull(tenDegrEarthDam) == false){
					layer.tips('10度不能为空！', '#10');
				}else if(checkNull(streetOrTown) == false){
					layer.tips('街道和乡镇不能为空！', '#streetOrTown');
				}else if(checkNull(city) == false){
					layer.tips('城市不能为空！', '#city');
				}else if(checkNull(popeOrCounty) == false){
					layer.tips('辖区或者县不能为空！', '#popeOrCounty');
				}else if(checkNull(propertyType) == false){
					layer.tips('建筑类型不能为空');
				}else{
					//建筑类别检测,防止中文乱码
					switch (propertyType) {
						case '桥梁建筑': propertyType="qljz";  break;
						case '工业建筑': propertyType="gyjz";  break;
						case '民用建筑': propertyType="myjz";  break;
						case '公共建筑': propertyType="ggjzw";  break;
						case '供水系统': propertyType="gsxtjz";  break;
						case '供热系统': propertyType="grxtjz";  break;
						case '供电系统': propertyType="gdxtjz";  break;
						case '变电站名称': propertyType="bdzmc";  break;
						case '天然气加气站': propertyType="trqjqz";  break;
						case '天然气门站': propertyType="trqmz";  break;
						case '次生灾害源': propertyType="cszhy";  break;
						case '消防建筑': propertyType="xfjz";  break;
						case '液化气供应站': propertyType="yhqgyz";  break;
						case '通信基站': propertyType="txjz";  break;
						default: propertyType=propertyType;  break;
					}
					var url='index.php/Welcome/InputData';
					$.ajax({
						type:"POST",   //方法
						url: url,      //文件路径
						data:{
							"buildingNumber":buildingNumber,
							"X":X,
							"Y":Y,
							"baidu_X":baidu_X,
							"baidu_Y":baidu_Y,
							"propertyType":propertyType,
							"buildingName":buildingName,
							"nameOfHous":nameOfHous,
							"admiPosition" :admiPosition,
							"height":height,
							"floor":floor,
							"floorArea":floorArea,
							"constructionAge":constructionAge,
							"structureTypeOne":structureTypeOne,
							"structureTypeTwo":structureTypeTwo,
							"earthquakeFortification":earthquakeFortification,
							"siteType":siteType,
							"foundationType":foundationType,
							"baseType" :baseType,
							"exteriorAndInterior":exteriorAndInterior,
							"underDisadvantage":underDisadvantage,
							"scatAndNotWhole":scatAndNotWhole,
							"britWithoutDelay":britWithoutDelay,
							"partAndUneven":partAndUneven,
							"simpButNotRedu" :simpButNotRedu,
							"remarks" :remarks,
							"statusEvaluation" :statusEvaluation,
							"sixDegrEarthDam" :sixDegrEarthDam,
							"sevenDegrEarthDam":sevenDegrEarthDam,
							"eightDegrEarthDam" :eightDegrEarthDam,
							"nineDegrEarthDam":nineDegrEarthDam,
							"tenDegrEarthDam":tenDegrEarthDam,
							"predictOutcomes" :predictOutcomes,
							"no":no,
							"ToOrHuOrviOrCo":ToOrHuOrviOrCo,
							"streetOrTown" :streetOrTown,
							"city" :city,
							"popeOrCounty":popeOrCounty
						},
						dataType:"text",//用的是什么字符，json字符在js中相当有优势
						async: false,//是否同步或者异步
						success:function(data){//查错
							layer.msg('插入数据成功！！');
						},
						error: function (data) {
						}
					});
					layer.close(index);
				}  
            }
        });
    }
	//检验函数检验输入的数值是否为double类型
	function checkD(X){
        var reg = /-[0-9]+(.[0-9]+)?|[0-9]+(.[0-9]+)?/;
		if (!reg.test(X)){
			return false;             
        }else{  
            return true;
        }
	}
	//函数检验输入的数值不能为空
	function checkNull(X){
		if (!X){
			return false;             
        }else{  
            return true;
        }
	}
</script>
</html>