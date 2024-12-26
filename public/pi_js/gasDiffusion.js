//毒气模拟
	var Marker;
      var GasStartX = new Array(); 
	  var GasStartY = new Array();
	  var radius=1;  //圆的半径
	var x=0.002,y=0.002; //正北坐标变量
	var m=0.002,n=0.002; //正南坐标变量
	var q=0.002,w=0.002; //正西坐标变量
	var e=0.002,r=0.002; //正东坐标变量
	var t=0.002,p=0.002; //西北坐标变量
	var f=0.002,g=0.002; //东北坐标变量
	var h=0.002,j=0.002; //西南坐标变量
	var k=0.002,l=0.002; //东南坐标变量  后期变量命名必须规范
      function firstClickPoint(){ //先从地图上设置一个点			
		GasEndClickPoint  = function(epoint){	//声明点击事件	
				window.clickLng=epoint.point.lng;
				window.clickLat=epoint.point.lat;		
				GasStartX.push(epoint.point.lng);
				GasStartY.push(epoint.point.lat);
				map.removeOverlay(Marker);//在添加一个新Marker前清除掉之前的Marker			
				Marker = new BMap.Marker(new BMap.Point(clickLng,clickLat));
				Marker.flag="marker";
				map.addOverlay(Marker);	
			 if(GasStartX.length>1){//每次添加毒气时，圆的半径长度、椭圆长轴长度初始化
				radius=1;
				x=0.002;  y=0.002;
				m=0.002;  n=0.002;
				q=0.002;  w=0.002;
				e=0.002;  r=0.002;
				t=0.002;  p=0.002;
				f=0.002;  g=0.002;
				h=0.002;  j=0.002;
				k=0.002;  l=0.002;
			}	
		}
		map.addEventListener("click",GasEndClickPoint);//添加点击事件
		window.GasEndClickPoint = GasEndClickPoint;
	}
    function setGasParameter(){
    	var select='<div style="margin-bottom:8px" class="layui-form-item"><label style="width: 111px" class="layui-form-label">危险程度</label> <div class="layui-input-block" >'+'<select style="width:153px; height:40px;"  lay-verify="required" id="dangerLevel" ><option>请选择</option><option>一级</option><option>二级</option><option>三级</option></select>'+'</div></div>'
    	+'<div style="margin-bottom:8px" class="layui-form-item"><label style="width: 111px" class="layui-form-label">选择风向</label> <div class="layui-input-block" >'+'<select style="width:153px; height:40px;"  lay-verify="required" id="windArea" ><option>请选择</option><option>正北</option><option>正南</option><option>正西</option><option>正东</option><option>无风</option><option>西北</option><option>东北</option><option>西南</option><option>东南</option></select>'+'</div></div>'
    	+'<div style="margin-bottom:8px" class="layui-form-item"><label style="width: 111px" class="layui-form-label">选择风速</label> <div class="layui-input-block" >'+'<select style="width:153px; height:40px;"  lay-verify="required" id="windSpeed" ><option>请选择</option><option>1级软风</option><option>2级轻风</option><option>3级微风</option><option>4级和风</option><option>5级轻风</option><option>6级强风</option><option>7级劲风</option><option>8级大风</option><option>9级烈风</option><option>10级狂风</option><option>11级暴风</option><option>12级台风</option></select>'+'</div></div>';
    	//+'<div style="margin-bottom:8px"class="layui-form-item"><label style="width: 111px"class="layui-form-label">选择风向</label> <div class="layui-input-block">'+'<select style="width:152px; height:40px;" lay-verify="required" id=""  ></select>'+'</div></div>'+'<div style="margin-bottom:8px" class="layui-form-item"><label style="width: 111px" class="layui-form-label">选择风速</label><div class="layui-input-block">'+'<select  style="width:152px; height:40px;" lay-verify="required" id=""  ></select>'+'</div></div>'+'<div class="layui-inline"></div></div>'
              layer.open({
          title: '精确查询'
          ,content: select
          /*content: '辖区/县:</br><select id="county" style="width:174px"><option value ="volvo">Volvo</option><option value ="saab">Saab</option><option value="opel">Opel</option><option value="audi">Audi</option></select></br>街道/乡镇:</br><select id="town" style="width:174px"><option value ="volvo">Volvo</option><option value ="saab">Saab</option><option value="opel">Opel</option><option value="audi">Audi</option></select></br>小区/胡同/村名/单位名:</br><input id="village" type="text"/></br>楼号/建筑物名称:</br><input id="building" type="text"/>'*/
        ,btn:['确定']
        ,area: ['450px', '320px']
          ,yes: function(index, layero)
          { 
           	var option=document.getElementById("windArea").value;
			var level=document.getElementById("dangerLevel").value; //  fillOpacity 颜色填充透明度
			window.windSpeed=document.getElementById("windSpeed").value;
			switch(level){
				case "三级":
					level=0.7;
					break;
				case "二级":
					level=0.5;
					break;
				default:
					level=0.3;
					break;
			}
			switch(windSpeed){
				case "1级软风":windSpeed=2000;break;
				case "2级轻风":windSpeed=1800;break;
				case "3级微风":windSpeed=1600;break;
				case "4级和风":windSpeed=1500;break;
				case "5级轻风":windSpeed=1300;break;
				case "6级强风":windSpeed=1200;break;
				case "7级劲风":windSpeed=1000;break;
				case "8级大风":windSpeed=800;break;
				case "9级烈风":windSpeed=700;break;
				case "10级狂风":windSpeed=500;break;
				case "11级暴风":windSpeed=300;break;
				case "12级台风":windSpeed=200;break;
				default:windSpeed=1500;break;
			}
			window.level=level;			
		            
             if(!option||!level||!windSpeed){
               layer.alert("填写完整数据",{icon:2});
             }else{
               startClickGetMapPoint(option,level,windSpeed);
               layer.close(index);
             }     
          }         
        });    
	}
	function startClickGetMapPoint(option,level,windSpeed){								//起始坐标		
		//var clickHandle=function(a){
			// for(sub;sub<GasStartX.length;sub++){
			// 	var startMarker = new BMap.Marker(new BMap.Point(GasStartX[sub],GasStartY[sub]),{icon:myIcon});
			// 	map.addOverlay(startMarker);
			// }			
			// var option=document.getElementById("area").value;
			// var level=document.getElementById("level").value; //  fillOpacity 颜色填充透明度
			// window.level=level;			
			// window.windSpeed=document.getElementById("windSpeed").value;
	     	// if(radius>=500||!(x<0.004&&y<0.006)||!(m<0.004&&n<0.006)||!(q<0.007&&w<0.004)||!(e<0.007&&r<0.004)
	     	// 	||!(t<0.004&&p<0.006)||!(f<0.004&&g<0.006)||!(h<0.004&&j<0.006)||!(k<0.004&&l<0.006)){
	     	// 	clickLng=undefined; clickLat=undefined;
	     	// }												//确保一个点只能有一个毒气效果(风向)	
			switch(option){
				case "无风": circle(); 	break;
				case "正北": rightNorth(); break;
				case "正南": rightSouth(); break;
				case "正西": rightWest(); break;
				case "正东": rightEast(); break;

				case "西北": northWest(); break;
				case "东北": northEast(); break;
				case "西南": southWest(); break;
				case "东南": southEast(); break;
				default:break;
			}	
			map.centerAndZoom(new BMap.Point(clickLng,clickLat), 15); 	
		//}
		//map.addEventListener("click",clickHandle);	
		//window.clickHandle=clickHandle;  
		return [GasStartX,GasStartY];
	} 
	var opts = {
				width : 300,     // 信息窗口宽度
				height: 100,     // 信息窗口高度
				title : "信息窗口" , // 信息窗口标题
				enableMessage:true//设置允许信息窗发送短息
			   };

    function addClickHandler(content,oval){//点击覆盖物显示信息窗口
		oval.addEventListener("click",function(z){
			window.z=z;
			openInfo(content,z)}
		);
	}
	function openInfo(content,z){
		//alert(z);
		var pp = z.target;
		var point = new BMap.Point(z.point.lng, z.point.lat);
		var infoWindow = new BMap.InfoWindow(content,opts);  // 创建信息窗口对象 
		map.openInfoWindow(infoWindow,point); //开启信息窗口
	}

	function circle(){//无风
			var mPoint = new BMap.Point(clickLng,clickLat);
			var oval = new BMap.Circle(mPoint,radius,{fillColor:"red", strokeWeight: 1 ,fillOpacity: level, strokeOpacity: 0.1});
			map.addOverlay(oval);	
			oval.class="oval";
			var content="毒气蔓延中心位置位于：经度"+clickLng+"纬度"+clickLat+"半径大小为："+radius+"米";
			window.content=content;
			addClickHandler(content,oval);
			if(radius<500){
				radius=radius+50;
				setTimeout("circle()",500);//每隔0.5秒变化一次
			}						
	}
	function add_oval(centre,x,y){ //画椭圆函数 x为经度 y为纬度
		var assemble=new Array();
		var angle;
		var dot;
		var tangent=x/y;
		for(i=0;i<36;i++)
		{
			angle = (2* Math.PI / 36) * i;
			dot = new BMap.Point(centre.lng+Math.sin(angle)*y*tangent, centre.lat+Math.cos(angle)*y);
			assemble.push(dot);
		}
		return assemble;
	}  
	function rightNorth(){//正北方向
		var mPoint = new BMap.Point(clickLng,clickLat);
		var oval = new BMap.Polygon(add_oval(mPoint,x,y), {fillColor:"red", strokeWeight: 1 ,fillOpacity: level, strokeOpacity: 0.1});
		map.addOverlay(oval);
		oval.class="oval";
		var content="毒气蔓延中心位置位于：经度"+clickLng+"纬度"+clickLat+"当前风向为：正北";
		//addClickHandler(content,oval);		
        if(x<0.004&&y<0.006){ //控制变化最终位置
        	x=x+0.0005; //椭圆横向经度变化
        	y=y+0.001; 	//椭圆纵向纬度变化
        	clickLat=clickLat-0.0008;	//椭圆圆心纬度变化
        	setTimeout("rightNorth()",windSpeed);//每隔windSpeed段时间变化一次
        }
	}	
	function rightSouth(){//正南方向
		var mPoint = new BMap.Point(clickLng,clickLat);
		var oval = new BMap.Polygon(add_oval(mPoint,m,n), {fillColor:"red", strokeWeight: 1 ,fillOpacity: level, strokeOpacity: 0.1});
		map.addOverlay(oval);
		oval.class="oval";
		var content="毒气蔓延中心位置位于：经度"+clickLng+"纬度"+clickLat+"当前风向为：正南";
		addClickHandler(content,oval);				
        if(m<0.004&&n<0.006){
        	m=m+0.0005;
        	n=n+0.001;
        	clickLat=clickLat+0.0008;
        	setTimeout("rightSouth()",windSpeed);
        }
	}	
	function rightWest(){//正西方向
		var mPoint = new BMap.Point(clickLng,clickLat);
		var oval = new BMap.Polygon(add_oval(mPoint,q,w), {fillColor:"red", strokeWeight: 1 ,fillOpacity: level, strokeOpacity: 0.1});
		map.addOverlay(oval);
		oval.class="oval";
		var content="毒气蔓延中心位置位于：经度"+clickLng+"纬度"+clickLat+"当前风向为：正西";
		addClickHandler(content,oval);				
        if(q<0.007&&w<0.004){
        	q=q+0.001;
        	w=w+0.0003;
        	clickLng=clickLng+0.0008;
        	setTimeout("rightWest()",windSpeed);
        }
	}	
	function rightEast(){//正东方向
		var mPoint = new BMap.Point(clickLng,clickLat);
		var oval = new BMap.Polygon(add_oval(mPoint,e,r), {fillColor:"red", strokeWeight: 1 ,fillOpacity: level, strokeOpacity: 0.1});
		map.addOverlay(oval);
		oval.class="oval";
		var content="毒气蔓延中心位置位于：经度"+clickLng+"纬度"+clickLat+"当前风向为：正东";
		addClickHandler(content,oval);				
        if(e<0.007&&r<0.004){
        	e=e+0.001;
        	r=r+0.0003;
        	clickLng=clickLng-0.0008;
        	setTimeout("rightEast()",windSpeed);
        }
	}  
	function northWest(){//西北方向
		var mPoint = new BMap.Point(clickLng,clickLat);
		var oval = new BMap.Polygon(add_oval(mPoint,t,p), {fillColor:"red", strokeWeight: 1 ,fillOpacity: level, strokeOpacity: 0.1});
		map.addOverlay(oval);	
		oval.class="oval";
		var content="毒气蔓延中心位置位于：经度"+clickLng+"纬度"+clickLat+"当前风向为：正西";
		addClickHandler(content,oval);			
        if(t<0.004&&p<0.006){
        	t=t+0.0005;
        	p=p+0.0006;
        	clickLng=clickLng+0.0007;
        	clickLat=clickLat-0.0009;
        	setTimeout("northWest()",windSpeed);
        }
	}	
	function northEast(){//东北方向
		var mPoint = new BMap.Point(clickLng,clickLat);
		var oval = new BMap.Polygon(add_oval(mPoint,f,g), {fillColor:"red", strokeWeight: 1 ,fillOpacity: level, strokeOpacity: 0.1});
		map.addOverlay(oval);	
		oval.class="oval";
		var content="毒气蔓延中心位置位于：经度"+clickLng+"纬度"+clickLat+"当前风向为：北偏东";
		addClickHandler(content,oval);			
        if(f<0.004&&g<0.006){
        	f=f+0.0005;
        	g=g+0.0006;
        	clickLng=clickLng-0.0007;
        	clickLat=clickLat-0.0009;
        	setTimeout("northEast()",windSpeed);
        }
	}       
	function southWest(){//西南方向
		var mPoint = new BMap.Point(clickLng,clickLat);
		var oval = new BMap.Polygon(add_oval(mPoint,h,j), {fillColor:"red", strokeWeight: 1 ,fillOpacity: level, strokeOpacity: 0.1});
		map.addOverlay(oval);
		oval.class="oval";
		var content="毒气蔓延中心位置位于：经度"+clickLng+"纬度"+clickLat+"当前风向为：南偏西";
		addClickHandler(content,oval);				
        if(h<0.004&&j<0.006){
        	h=h+0.0005;
        	j=j+0.0006;
        	clickLng=clickLng+0.0007;
        	clickLat=clickLat+0.0009;
        	setTimeout("southWest()",windSpeed);
        }
	}	
	function southEast(){//东南方向
		var mPoint = new BMap.Point(clickLng,clickLat);
		var oval = new BMap.Polygon(add_oval(mPoint,k,l), {fillColor:"red", strokeWeight: 1 ,fillOpacity: level, strokeOpacity: 0.1});
		map.addOverlay(oval);
		var content="毒气蔓延中心位置位于：经度"+clickLng+"纬度"+clickLat+"当前风向为：南偏东";
		addClickHandler(content,oval);				
        if(k<0.004&&l<0.006){
        	k=k+0.0005;
        	l=l+0.0006;
        	clickLng=clickLng-0.0007;
        	clickLat=clickLat+0.0009;
        	setTimeout("southEast()",windSpeed);
        }
	}