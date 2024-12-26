	var historyData;
	function histoEar(type){
		 var url="index.php/Data/historyCon";
	             
	              $.ajax({  
	                type:'post',   //方法  
	                url:url,      //文件路径  
	                dataType:'text',//用的是什么字符，json字符在js中相当有优势  
	                async: true,//是否同步或者异步  
	                success:function(data){//查错  
	                    var data= eval("("+data+")");
	                      markerArr=data[1];
	                      historyData=data[0];
	                      if(data==""){
	                       layer.alert("无数据",{icon:5});
	                      }else if(type=='point'){   
	                      	addHistoryPoint(markerArr);	                      
	                  	  }else{
	                  	  	histoEarChart();
	                  	  }
	                },  
	                error: function (data) {     
	                        layer.alert(data,{icon:0});
	              }  
	          });
	}
	function addHistoryPoint(markerArr){
		var myIcon = new BMap.Icon("public/images/historyMarker.png", new BMap.Size(20,20));
		for(var i=0;i<markerArr.length;i++){
		    var point = new BMap.Point(markerArr[i].baidu_X,markerArr[i].baidu_Y);
			var marker = new BMap.Marker(point,{icon:myIcon});
			marker.class='history'; //给建筑物覆盖物添加属性以便查找
			marker.flag="marker";
			var content='时间：'+markerArr[i].date+'<br/>'+'经度：'+markerArr[i].lng+'<br/>纬度：'+markerArr[i].lat+'<br/>'+'深度：'+markerArr[i].depth+'<br/>'+'震级：'+markerArr[i].magnitude+'<br/>'+'地点：'+markerArr[i].place;			
			if(i+1<markerArr.length){
				if(markerArr[i].lng==markerArr[i+1].lng&&markerArr[i].lat==markerArr[i+1].lat)
				    	var content='时间：'+markerArr[i].date+'<br/>'+'经度：'+markerArr[i].lng+'<br/>纬度：'+markerArr[i].lat+'<br/>'+'深度:'+markerArr[i].depth+'<br/>'+'震级:'+markerArr[i].magnitude+'<br/>'+'地点:'+markerArr[i].place+'<br/>'+'<br/>'+'<br/>'+
				         '时间:'+markerArr[i+1].date+'<br/>'+'经度：'+markerArr[i+1].lng+'<br/>纬度：'+markerArr[i+1].lat+'<br/>'+'深度:'+markerArr[i+1].depth+'<br/>'+'震级:'+markerArr[i+1].magnitude+'<br/>'+'地点:'+markerArr[i+1].place;			
				 }		          				
			addClickHandler(content,marker);
			map.addOverlay(marker); //添加点图层
			// //marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
			// map.centerAndZoom(new BMap.Point(124.81173189754,45.1794860515878), 9); 	       
	   	}
	}
	var opts = {
				width : 240,     // 信息窗口宽度
				height: 150,     // 信息窗口高度
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
	function histoEarChart(){
		layer.open({
				  title: false
				  ,id:'historyChartContainer'
				  ,offset: 'rb'
				  ,maxmin: true //开启最大化最小化按钮
				  ,content: '<div id="historyChart" style="width:650px;height:420px"></div>'
				  /*content: '辖区/县:</br><select id="county" style="width:174px"><option value ="volvo">Volvo</option><option value ="saab">Saab</option><option value="opel">Opel</option><option value="audi">Audi</option><lect></br>街道/乡镇:</br><select id="town" style="width:174px"><option value ="volvo">Volvo</option><option value ="saab">Saab</option><option value="opel">Opel</option><option value="audi">Audi</option><lect></br>小区/胡同/村名/单位名:</br><input id="village" type="text"/></br>楼号/建筑物名称:</br><input id="building" type="text"/>'*/
				,area: ['700px', '520px']
				//,shadeClose: true //开启遮罩关闭
				,shade: 0 //0.1透明度的白色背景
				,move: '#historyChartContainer'  //拖拽的元素
				,moveType:0
				,anim: 4
				,style: 'background-color:rgba(255,255,255,0.1)' 
				  ,yes: function(index, layero)
				  { 
				  	// if(viewtype==0){StartCapture('C');}
				  	// else{StartCapture('D');}	
				  	layer.close(index);			 
				  }
				  ,cancel: function()
				  {  				  
				  }			  
		}); 
		var myChartPIE = echarts.init(document.getElementById('historyChart'));
		option = {
	    title: {
	        text: ''
	    },
	    tooltip: {
	        trigger: 'axis'
	    },
	    legend: {
	        data:['震级','深度','','','']
	    },
	    grid: {
	        left: '6%',
	        right: '10%',
	        bottom: '3%',
	        containLabel: true
	    },
	    toolbox: {
	        feature: {
	          //  saveAsImage: {}
	        }
	    },
	    xAxis: {
	        type: 'category',
	        boundaryGap: false,
	        data: historyData.date
	    },
	    yAxis: {
	        type: 'value'
	    },
	    series: [
	        {
	            name:'震级',
	            type:'line',
	            stack: 'M',
	            data:historyData.magnitude
	        },
	         {
	            name:'深度',
	            type:'line',
	            stack: '',
	            data:historyData.depth
	        }
	        
	   		 ]
		};
		myChartPIE.setOption(option);
	}
