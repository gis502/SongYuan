


    var endX = new Array();
    var endY = new Array();
    //var endXY = new Array();
    var wayX = new Array();
    var wayY = new Array();
    var wayXY = new Array();
    var markerArr;//建筑物数据
    var num1;//更具传递值判断是哪一种截图方式
    var wayClickpoint,endClickPoint;
    var lushu;
    var markerClusterer;
    var warming_points = new Array();
    var w_points = new Array();
    var middle_w_points=[]
    var labels = new  Array();
    var I_label = new Array();



 //（精确查询建筑物）pipi                
    function return_exact_search_build_data(city,popeOrCounty,streetOrTown,ToOrHuOrviOrCo,building){

       //  map.refresh();
       if(markerArr!=""){
       	removeAllMarker();
       }
              $.ajax({  
                type:'post',   //方法  
                url:'index.php/Data/exact_search_C/',      //文件路径  
                dataType:'text',//用的是什么字符，json字符在js中相当有优势  
                data:{"city":city,"popeOrCounty":popeOrCounty,"streetOrTown":streetOrTown,"ToOrHuOrviOrCo":ToOrHuOrviOrCo,"buildingNumber":building,"buildingName":building},//data:"IntensityValue=" + params,//要传送的数据  
                  async: true,//是否同步或者异步  
                success:function(data){//查错
                     // alert(data);  
                    var data= eval("("+data+")");
                    if(!data || data.length==0){ //针对没数据和返回的空数组 
                      layer.alert("未查到任何数据！",{icon:5});
                    }else{
                      markerArr=data;
                      exact_addMarkerown("3",markerArr,"jqcx");//第一参数是查询类型 第二个参数是返回数据，第三个才是是图层属性
                      layer.alert("已精确查询到建筑并加载在地图上！",{icon:6});
                    }
                },  
                error: function (data) {  
                   layer.alert(data,{icon:0});
              }  
          }); 
       // if (document.getElementById("selectjietu").value==1) {
          //  StartCapture('B');//截图函数一定防灾函数的末尾
         // } 
        
    }
        function exactsearch(){   
          var select='<div style="margin-bottom:8px" class="layui-form-item"><label style="width: 111px" class="layui-form-label">辖区/县</label> <div class="layui-input-block" >'+'<select style="width:153px; height:40px;" name="city" lay-verify="required" id="sensor1" onchange=countryQuery()><option>请选择</option><option>宁江区</option><option>前郭县</option></select>'+'</div></div>'+'<div style="margin-bottom:8px"class="layui-form-item"><label style="width: 111px"class="layui-form-label">街道/乡镇/开发区</label> <div class="layui-input-block">'+'<select style="width:152px; height:40px;" name="street" lay-verify="required" id="streetOrTown3" onchange=streetQuery() ></select>'+'</div></div>'+'<div style="margin-bottom:8px" class="layui-form-item"><label style="width: 111px" class="layui-form-label">小区/村名/胡同</label><div class="layui-input-block">'+'<select name="poper" style="width:152px; height:40px;" lay-verify="required" id="ToOrHuOrviOrCo"  ></select>'+'</div></div>'+'<div class="layui-inline"><label style="width:111px" class="layui-form-label">建筑名称/编号:</label><div class="layui-input-inline"><input type="text" id="buildName" class="layui-input" style="width: 152px;border-color: #aaaaaa;"></div></div>'
              layer.open({
          title: '精确查询'
          ,content: select
          /*content: '辖区/县:</br><select id="county" style="width:174px"><option value ="volvo">Volvo</option><option value ="saab">Saab</option><option value="opel">Opel</option><option value="audi">Audi</option></select></br>街道/乡镇:</br><select id="town" style="width:174px"><option value ="volvo">Volvo</option><option value ="saab">Saab</option><option value="opel">Opel</option><option value="audi">Audi</option></select></br>小区/胡同/村名/单位名:</br><input id="village" type="text"/></br>楼号/建筑物名称:</br><input id="building" type="text"/>'*/
          ,btn:['确定']
          ,area: ['450px', '320px']
          ,yes: function(index, layero)
          {  
            var city="松原市";
            var popeOrCounty=document.getElementById('sensor1').value;//辖区、县
            var streetOrTown=document.getElementById('streetOrTown3').value;//街道、乡镇
            var ToOrHuOrviOrCo=document.getElementById('ToOrHuOrviOrCo').value;//小区/胡同/村名/单位名
            var building = document.getElementById('buildName').value;//建筑编号
            if(!popeOrCounty||!streetOrTown||!ToOrHuOrviOrCo||!building){
              layer.alert("填写完整数据",{icon:2});
            }else{
              return_exact_search_build_data(city,popeOrCounty,streetOrTown,ToOrHuOrviOrCo,building);//精确查询
              layer.close(index);
            }     
          }         
        });    
      }

         //根具区县和街道查询小区pipi    
function streetQuery(){
  var ToOrHuOrviOrCo;
var county= document.getElementById('sensor1').value;//区县
var street=document.getElementById('streetOrTown3').value;//街道乡镇
   if (county=="qgx") {
          county="前郭县";
      }
      if (county=="njq") {
        county="宁江区";
      }
        //alert(street);
          var url="index.php/Data/streetSearch_C";
             
              $.ajax({  
                type:'post',   //方法  
                url:url,      //文件路径  
                dataType:'text',//用的是什么字符，json字符在js中相当有优势  
                data:{"county":county,"street":street},//data:"IntensityValue=" + params,//要传送的数据  
                async: true,//是否同步或者异步  
                success:function(data){//查错  
                    var data= eval("("+data+")");
                       markerArr=data;
                      if(data==""){
                       layer.alert("查无此处",{icon:5});
                      }else{      
            ToOrHuOrviOrCo='<option >请选择</option>';
                        for (var i = 0; i < markerArr.length; i++) {
                          ToOrHuOrviOrCo+='<option>'+markerArr[i].ToOrHuOrviOrCo+'</option>';
                      }
                      $("#ToOrHuOrviOrCo").empty();//每次加载前清除缓存
                        $("#ToOrHuOrviOrCo").append(ToOrHuOrviOrCo);//在下拉菜单中加如何查询的数据 
                  
                  //alert("数据成功");
                   }
                   
                },  
                error: function (data) {     
                        layer.alert(data,{icon:0});
              }  
          });
      }
      


function o(){
 this.qljz=0,
 this.gyjz=0,
 this.myjz=0,
 this.ggjzw=0,
 this.gsxtjz=0,
 this.grxtjz=0,
 this.gdxtjz=0,
 this.bdzmc=0,
 this.trqjqz=0,
 this.trqmz=0,
 this.cszhy=0,
 this.xfjz=0,
 this.yhqgyz=0,
 this.txjz=0,
 this.sum=function(){
  return this.qljz+this.gyjz+this.myjz+this.ggjzw+this.gsxtjz+this.grxtjz
  +this.gdxtjz+this.bdzmc+this.trqjqz+this.trqmz+this.cszhy+this.xfjz+this.yhqgyz
  +this.txjz;
 }
}

     var distanceValue;//烈度值
    var sevenIntensity=0;//7度总数
    var eightIntensity=0;//8度总说
    var nineIntensity=0;//9度总数
    var tenIntensity=0;//10度总说
     var sixIntensity=0;//6度总说
     var UntouchNum=new o();
    var SlightNum=new o();
    var ModerateNum=new o();
    var SeriusNum=new o();
    var CollaPNum=new o();
        //创建marker 添加建筑物pipi
    var allOverlay;
    var points_sea=[]//存放分类点
    var  _constore=[]
    var sea_constore=[]
    function Foo(){
      this.pointCollection;
      this.class='';
    }
//圆形海量点添加
function addMarkerown(is,markerArr,type){
        // var intensity=intensity1//获取震级
        var markerClustererArr=[]
        var pa=[]
        var pb=[]
        var pc=[]
        var pd=[]
        var pe=[]
        var pf=[]
        var _dis0 = [];
        var _dis1 = [];
        var _dis2 = [];
        var _dis3 = [];
        var _dis4 = [];
        var _dis5 = [];
        _constore=[]
        untouchedIMG=getStationImage('untouched');//良好
        slightDamageIMG=getStationImage('slightDamage');//轻微破坏
        moderateDamageIMG=getStationImage('moderateDamage');//中等破坏
        seriousDamageIMG=getStationImage('seriousDamage');//严重破坏
        collapsedIMG=getStationImage('collapsed');//毁坏

        //读取建筑物图片
        var pictureList=[];
        $.ajax({
              url: "index.php/Data/readPicture/",
              type: "POST",
              async:false,//同步
              success: function(data) {
                if(data){
                   pictureList = data.split(",");
                }
              },
              error:function(e){

              }
        });
        for(var i=0;i<markerArr.length;i++){
            var json = markerArr[i];
            // alert(json.buildingName);
            var p0 = json.baidu_X;//经度
            var p1 = json.baidu_Y;//纬度
            var point = new BMap.Point(p0,p1);
            // map.centerAndZoom(point,16);//定位数据点
            marker_i=-1;
            for(ovals_i in find_ovals){
              if(BMapLib.GeoUtils.isPointInCircle(point,find_ovals[ovals_i])){
                  marker_i++;
                }else{
                  break;
                }
              }
              if(marker_i>-1){
                  if(marker_i==0){
                      var po=json.sixDegrEarthDam;
                  }else if(marker_i==1){
                      var po=json.sevenDegrEarthDam;
                  }else if(marker_i==2){
                      var po=json.eightDegrEarthDam;
                  }else if(marker_i==3){
                      var po=json.nineDegrEarthDam;
                  }else if(marker_i==4){
                      var po=json.tenDegrEarthDam;
                  }
                  distanceValue=marker_i+6;
                  
                  if(po=="良好"){
                    //var icon = new BMap.Icon("public/images/pipi/marker5.png", new BMap.Size(17,15),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
                    _dis0.push(point)
                    // distanceA.push(distanceValue)
                  }else if(po=="轻微破坏"){
                    //var icon = new BMap.Icon("public/images/pipi/marker4.png", new BMap.Size(17,15),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
                    var flag='slightDamage';
                    _dis1.push(point)
                    // distanceB.push(distanceValue)
                  }else if(po=="中等破坏"){
                    //var icon = new BMap.Icon("public/images/pipi/marker3.png", new BMap.Size(17,15),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
                    _dis2.push(point)
                    // distanceC.push(distanceValue)
                  }else if(po=="严重破坏"){
                    //var icon = new BMap.Icon("public/images/pipi/marker1.png", new BMap.Size(17,15),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
                    _dis3.push(point)
                    // distanceD.push(distanceValue)
                  }else if(po=="毁坏"){
                    //var icon = new BMap.Icon("public/images/pipi/marker1.png", new BMap.Size(17,15),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
                    _dis4.push(point)
                    // distanceE.push(distanceValue)
                  }
                 
              }else{
                // var icon = new BMap.Icon("public/images/pipi/marker.png", new BMap.Size(17,15),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
                distanceValue77='不在主要烈度内';
                _dis5.push(point)
                // distanceF.push(distanceValue)
              }
             
            var marker = new BMap.Marker(point);
            if(po=="中等破坏"){
              middle_w_points.push(marker)
            }
            if(po=="严重破坏"||po=="毁坏"){
                w_points.push(marker);
                warming_points.push(json);
              }
            setClassPercentage(markerArr,distanceValue,type,i);
            po="过渡";
            marker.class=type; //给建筑物覆盖物添加属性以便查找
            marker.flag="marker";
        }
        if(w_points.length==0){
          markerClustererArr=middle_w_points;
        }else{
          markerClustererArr=w_points;
        }
        pa.color='#00FFFF'
        pb.color='#3ea836'
        pc.color='#f86802'
        pd.color='#fb1b19'
        pe.color='#fb1b19'
        pf.color='#a1a193'

        pa.push(_dis0);
        pb.push(_dis1);
        pc.push(_dis2);
        pd.push(_dis3);
        pe.push(_dis4);
        pf.push(_dis5);

        points_sea=[]
        points_sea.push(pa)
        points_sea.push(pb)
        points_sea.push(pc)
        points_sea.push(pd)
        points_sea.push(pe)
        points_sea.push(pf)
        for(var i=0;i<sea_constore.length;i++){
          if(sea_constore[i]!=null)
            sea_constore[i].pointCollection.hide()
        }//清除所有海量点
        for(let i=0;i<points_sea.length;i++){
          var options = {
              size: BMAP_POINT_SIZE_NORMAL,
              shape: BMAP_POINT_SHAPE_RHOMBUS,
              color: points_sea[i]['color'],
          }
          pointCollections=new Foo();
          pointCollections.pointCollection=new BMap.PointCollection(points_sea[i][0], options);// 初始化PointCollection
          pointCollections.class=type;
          // pointCollection.__proto__.class=type;//给海量点赋予属性
          (function(n){
            pointCollections.pointCollection.addEventListener('click', function (e) {
              var loca = new BMap.Point( e.point.lng, e.point.lat);
			  			var data = {
			  				point : loca,
			  				type : n,
			  				value : markerArr
			  			};
                for(var j=0;j<markerArr.length;j++){
                  if(markerArr[j].baidu_X==e.point.lng&&markerArr[j].baidu_Y==e.point.lat)
                  break;
                }
              //  var  distance_data=points_sea[t][1][i];
                var _iw = createInfoWindow(markerArr,i,is,pictureList,type,data);
                map.openInfoWindow(_iw,loca);
                for(var j=0;j<$("img[name='buildingPictures']").length;j++){
                        $("img[name='buildingPictures']")[j].src = $("img[name='buildingPictures']")[j].src+'?'+Math.random()*10;
                      } 
                //给点图层创建信息窗口
                //var _marker = marker_sea[i];
                // e.addEventListener("click",function(){//给点图层添加点击事件
                //     this.openInfoWindow(_iw);
                //     //刷新显示图片
                //     for(var j=0;j<$("img[name='buildingPictures']").length;j++){
                //       $("img[name='buildingPictures']")[j].src = $("img[name='buildingPictures']")[j].src+'?'+Math.random()*10;
                //     } 
                // }); 
            });
        })(i);
        
          _constore.push(pointCollections)
          sea_constore.push(pointCollections)
          
      }
      for(var i=0;i<_constore.length;i++){
        map.addOverlay(_constore[i].pointCollection);//在地图上添加海量点  
      }
      for(var i=0;i<sea_constore.length;i++){
        if(sea_constore[i]!=null)
        sea_constore[i].pointCollection.show()
      }
     if(labels!= null){
      for(var i=0;i<labels.length;i++){
        map.removeOverlay(labels[i]);
      }
      window.labels=[];
    }
    
      if(markerClusterer!= null){
        markerClusterer.clearMarkers();
        
      }
        markerClusterer = new BMapLib.MarkerClusterer(map, {markers:markerClustererArr});
        var markerpoint=markerClusterer.tobackpoint();
        
        for(var i=0; i<markerpoint.length; i++){
            //加点
            var point = new BMap.Point(markerpoint[i].lng,markerpoint[i].lat);
            //字面量
            var opts = {
             position : point,    // 指定文本标注所在的地理位置
             offset   : new BMap.Size(10, -40)    //设置文本偏移量
            }
            //实例化label
            var label = new BMap.Label(i+1, opts);  // 创建文本标注对象
            //改变label样式
            label.setStyle({
            color : "#000088",
            backgroundColor:'transparent',//文本背景色
            borderColor:'transparent',//文本框边框色
            fontSize : "30px",
            height : "30px",
            lineHeight : "30px",
            fontFamily:"微软雅黑",
            fontWeight:'bolder'//加粗
            });
            labels.push(label);
        }
        map.addEventListener("zoomend",function(){
          if(map.getZoom()>=13){
            for(var i=0;i<labels.length;i++){
              map.addOverlay(labels[i]);
            }
          }else{
            for(var i=0;i<labels.length;i++){
              map.removeOverlay(labels[i]);
            }
          }

        });
        allOverlay = map.getOverlays();



        var opClose = $("#close").css("display");
                     if(opClose=='none'){
                      $("#legend").css("display","none");
                     }
                     else{
                      $("#legend").css("display","");
                     }

    }
// //创建圆形烈度圈的图标
// function createIcon(intensity,Distance)
//     {
//         var i=eval("intensity*1+2*1");//震级+2就是烈度
//         if(i<6)
//         {//5级一下地震
//             var icon = new BMap.Icon("public/images/pipi/marker0.png", new BMap.Size(17,16),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
//             distanceValue=0;
//             return icon;
//         }else if(i==6)
//         {//6级一下地震
//             var icon = new BMap.Icon("public/images/pipi/marker0.png", new BMap.Size(17,16),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
//             distanceValue=6;
//             return icon;
//         }
//         else if(i==7){//5级地震
           
//             if(Distance<=40)
//             {
//                   var icon = new BMap.Icon("public/images/pipi/marker1.png", new BMap.Size(17,16),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
//             }else{
//                 var icon = new BMap.Icon("public/images/pipi/marker0.png", new BMap.Size(17,16),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
//             }
//             return icon;
//         }else if(i==8)
//         {//6级地震
//             if(Distance<=20){//八度

//                   var icon = new BMap.Icon("public/images/pipi/marker1.png", new BMap.Size(17,16),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
//                   distanceValue=8;
//             }else if(20<Distance && Distance<=60){//7度
                  
//                 var icon = new BMap.Icon("public/images/pipi/marker2.png", new BMap.Size(17,16),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
//                   distanceValue=7;
//             }else{
//                 var icon = new BMap.Icon("public/images/pipi/marker0.png", new BMap.Size(17,16),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
//                  distanceValue=6;
//             }
//             return icon;
//         }else if(i==9)
//         {//7级地震
//             if(Distance<=10){//9度
//                   var icon = new BMap.Icon("public/images/pipi/marker1.png", new BMap.Size(17,16),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
//              distanceValue=9;

//             }else if(10<Distance && Distance <=30){//8度
//                   var icon = new BMap.Icon("public/images/pipi/marker2.png", new BMap.Size(17,16),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
//                  distanceValue=8;
//             }else if(30<Distance && Distance<=70){//7度
//                   var icon = new BMap.Icon("public/images/pipi/marker3.png", new BMap.Size(17,16),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
//                  distanceValue=7;
//             }else{
//                 var icon = new BMap.Icon("public/images/pipi/marker0.png", new BMap.Size(17,16),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
//              distanceValue=6;
//             }
//       return icon;
//         }else if(i==10)
//         {//8级地震
//            if(Distance<=5){//10度
//                   var icon = new BMap.Icon("public/images/pipi/marker1.png", new BMap.Size(17,16),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
//              distanceValue=10;
//             }else if(Distance>5 && Distance<=15){//9度
//                   var icon = new BMap.Icon("public/images/pipi/marker2.png", new BMap.Size(17,16),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
//            distanceValue=9;
//             }else if(Distance>15 && Distance<35){//8度
//                   var icon = new BMap.Icon("public/images/pipi/marker3.png", new BMap.Size(17,16),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
//               distanceValue=8;
//             }else if(Distance>35 && Distance<=75){//7度
//                   var icon = new BMap.Icon("public/images/pipi/marker4.png", new BMap.Size(17,16),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
//             distanceValue=7;
//             }else{

//                 var icon = new BMap.Icon("public/images/pipi/marker0.png", new BMap.Size(17,16),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
//             distanceValue=6;
//             }
//             return icon; 
//         }else{//狂震级地震
//                 distanceValue=6;
//                 var icon = new BMap.Icon("public/images/pipi/marker0.png", new BMap.Size(17,16),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
//                 return icon;
//         }
//   }


     //获取圆心点
    var startX;//申请全局变量当点击就将坐标放入这个变量中
    var startY;
    // function getCirclePoint(){
    //     endClickPoint  = function(e){ //声明点击事件              //起始坐标
    //         var myIcon = new BMap.Icon("public/hui_images/circle.png", new BMap.Size(30,30));
    //         startX=e.point.lng;
    //         startY=e.point.lat;
    //         //for(var sub=0;sub<startX.length;sub++){
    //         var startMarker = new BMap.Marker(new BMap.Point(startX,startY),{icon:myIcon});
    //         startMarker.flag="marker";
    //         map.addOverlay(startMarker);
    //         //}
    //         map.removeEventListener("click",endClickPoint);
    //         drawCircle();
    //     }
    //     map.addEventListener("click",endClickPoint);//添加点击事件
    //    // window.endClickPoint = endClickPoint;
    //     //return [startX,startY];
    // }
     function getCirclePoint(msg){
      clearEchartCookie()
      sea_constore=[]//清空存储的海量点缓存
      var endClickPoint  = function(e){ //声明点击事件              //起始坐标
        var myIcon = new BMap.Icon("public/hui_images/circle.png", new BMap.Size(16,16));
        startX=e.point.lng;
        startY=e.point.lat;
        var point = new BMap.Point(startX,startY);
       
        var startMarker = new BMap.Marker(new BMap.Point(startX,startY),{icon:myIcon});
        map.addOverlay(startMarker);
        startMarker.flag="marker";
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
             detail_address=html;
             var infoWindow = new BMap.InfoWindow("地址："+html+"<br>经度："+startX+"<br>纬度："+startY+"", opts);
             map.openInfoWindow(infoWindow,point); //开启信息窗口
             startMarker.addEventListener("click", function(){          
             map.openInfoWindow(infoWindow,point); //开启信息窗口
          });
          });
        if(msg=="oval"){
          drawOval(startX,startY);
          setTimeout("StartCapture('A')",1000);
        }else{
          drawCircle();
          setTimeout("StartCapture('A')",1000);
        }

        map.removeEventListener("click",endClickPoint);

    }
    startX=null;
    startY=null;//苏苏改动，清空缓存点坐标
    capturearray=[0,0,0,0,0];
    map.addEventListener("click",endClickPoint);//添加点击事件

   // window.endClickPoint = endClickPoint;resolve(1);
    //return [startX,startY];

    }


    // //画圆
    // function drawCircle(){
    //   //  map.clearOverlays();
    //     var R = new Array();
    //     var point = new BMap.Point(startX,startY);
    //     //此处开始计算半径
    //     var M =intensity1;
    //       // alert("11"+M);
    //     var intensity = Number(M)  + Number(2);
    //     if(intensity <= 6){
    //         layer.alert("只支持6度以上的烈度显示",{icon:5});
    //         return;
    //     }else if(intensity >= 7 && intensity < 8){
    //         R = [40];
    //     }else if(intensity >= 8 && intensity < 9){
    //         R = [30,40];
    //     }else if(intensity >= 9 && intensity < 10){
    //         R = [20,30,40];
    //     }else if(intensity >= 10 && intensity < 11){
    //         R = [10,20,30,40];
    //     }

    //     var colorIntensity=['#9A0103','#E10700','#D03A00','#FFDD04','#82BF24','#AFFF80','#E6FFC8','FFFFCE','D4FFD3','A1E7EA'];
    //     //向图中加入圆形区域
    //     // (function(i){
          
    //     // })(i)
    //     find_ovals.splice(0,find_ovals.length);//清空变量
    //     for(var i=R.length-1;i>=0;i--){
    //         var circle = new BMap.Circle( point , R[i]*1000);
    //         circle.setStrokeColor(colorIntensity[i]);
    //         circle.setFillColor(colorIntensity[i]); //创建圆
    //         circle.setStrokeWeight(1);
    //         circle.setFillOpacity(0.3);
    //         circle.class="circle";
    //         map.addOverlay(circle);
    //         find_ovals.push(circle);
    //     }
    //     map.centerAndZoom(point,10);
    //     allOverlay = map.getOverlays();
    //     //自动截图 画烈度图1
    
    // }

    //针对松原4.5级地震
    function drawCircle(){
      //  map.clearOverlays();

        var R = new Array();
        var I = new Array();
        var point = new BMap.Point(startX,startY);
        window.M =window.intensity1;
        if(intensity1 < 4){
            layer.alert("只支持4级以上的震级显示！",{icon:5});
            return;
        }else if(intensity1>=4 && intensity1 < 4.7){
            R = [10];
            I = ['Ⅵ'];
        }else if(intensity1 >= 4.7 && intensity1 < 5.3){
            R = [5,15];
            I = ['Ⅵ','Ⅶ'];
        }else if(intensity1 >= 5.3 && intensity1 < 5.7){
            R = [10,30];
            I = ['Ⅵ','Ⅶ'];
            //在极震区可能会造成少量人员轻伤。对市区而言
            //一定数量的框架结构填充墙会出现裂缝，少量女儿墙和出屋面烟囱会歪斜或掉落。
        }else if(intensity1 >= 5.7 && intensity1 < 6.3){
            R = [10,20,40];
            I = ['Ⅵ','Ⅶ','Ⅷ'];
            //可能导致少量危房倒塌并造成百余人轻伤及少量重伤。
            //对市区可导致超过半数的框架房屋填充墙出现明显开裂，少量女儿墙、出屋面烟囱掉落。
            //部分砖混房屋底层窗间墙、墙角可能出现裂缝。
        }else if(intensity1 >= 6.3 && intensity1 < 6.7){
           R = [5,20,50,100];
           I = ['Ⅵ','Ⅶ','Ⅷ','Ⅸ'];
           //可能导致百余栋危房倒塌或严重破坏，有少量人员死亡，几十人重伤，几百人轻伤。
           //对市区可能导致少量老旧危房倒塌，近1/4框架、砖混及高层剪力墙结构出现明显墙体裂缝
           //较多的女儿墙、出屋面烟囱掉落
        }else if(intensity1 >= 6.7 && intensity1 < 7.2){
            R = [7.5,30,70,150];
            I = ['Ⅵ','Ⅶ','Ⅷ','Ⅸ'];
        }else if(intensity1 >= 7.2 && intensity1 <= 8.0){
          R = [5,15,30,70,150];
          I = ['Ⅵ','Ⅶ','Ⅷ','Ⅸ','X'];
        }else{
            layer.alert("只支持8.0级以下的震级表示！",{icon:5});
            return;
        }

        var colorIntensity=['#9A0103','#D03A00','#FFDD04','#82BF24','#AFFF80','#E6FFC8','FFFFCE','D4FFD3','A1E7EA'];

        find_ovals.splice(0,find_ovals.length);//清空变量

        for(var i=R.length-1;i>=0;i--){

          (function(num){
            var circle = new BMap.Circle( point , R[num]*1000);
            circle.setStrokeColor(colorIntensity[num]);
            circle.setFillColor(colorIntensity[num]); //创建圆
            circle.setStrokeWeight(1);
            circle.setFillOpacity(0.3);
            circle.class="circle";
            map.addOverlay(circle);
            find_ovals.push(circle);
          })(i)

        }
        for(var k=0 ; k<find_ovals.length ; k++){
          (function(num){
            if(num == find_ovals.length-1){
              var lat = (point.lat + find_ovals[num].ia[0].lat)/2;
              var lng = (point.lng + find_ovals[num].ia[0].lng)/2;
            }else{
              var lat = (find_ovals[num].ia[0].lat - find_ovals[num+1].ia[0].lat)/2 + find_ovals[num+1].ia[0].lat;
              var lng = (find_ovals[num].ia[0].lng - find_ovals[num+1].ia[0].lng)/2 + find_ovals[num+1].ia[0].lng;
            }
            var I_point = new BMap.Point(lng,lat);
            //标注震级
            var opts = {
             position : I_point,    // 指定文本标注所在的地理位置
             offset   : new BMap.Size( -10, -10)    //设置文本偏移量
            }
            //实例化label
            var label = new BMap.Label(I[num], opts);  // 创建文本标注对象
            //改变label样式
            label.setStyle({
              color : "#000088",
              backgroundColor:'transparent',//文本背景色
              borderColor:'transparent',//文本框边框色
              fontSize : "20px",
              height : "10px",
              lineHeight : "20px",
              fontFamily:"微软雅黑",
              fontWeight:'bolder'//加粗
            });
            I_label.push(label);
            map.addOverlay(I_label[k]);

          })(k)
        }
        map.centerAndZoom(point,13);
        allOverlay = map.getOverlays();
        //自动截图 画烈度图1
    
    }


function addmapline(value){
      if($('#'+value).is(':checked')) {
       var url='index.php/AddLineCon/MapLinePoints/'+value;//url
       // alert(url);
       var color=null;
        $.ajax({  
              type:"POST",   //方法  
              url: url,      //文件路径  
              dataType:"json",//用的是什么字符，json字符在js中相当有优势  
              success:function(res){//查错  
                var linePoint = res;
                //alert(linePoint);
               
                   if (value=="t10kv") {
                    
                    color="#AA5566";
                     
                   }
                   else if(value=="t66kv"){
                      color="#E6941A";
                   }
                   else if(value=="t220kv"){
                      color="#78439B";
                   }
                    else if(value=="rqgx"){
                    color="#5E5EA2";
                   }
                    else if(value=="ssgx"){
                    color="#09F7F7";
                   }
                   else if(value=="wsgx"){
                      color="#A25E5E";
                   }
                    else if(value=="xjgx"){
                      color="#0099FF";
                   }
                   else if(value=="ysgx"){
                      color="#1AE66B";
                   }
                    else if(value=="fzsstd"){
                    color="#F37150";
                   }
                    else if(value=="xytxxl"){
                        color="#A3A89B";
                   }
                   else if(value=="grxzgx"){
                    color="#E76108";
                   }
                 else{
                  color="blue";
                 }
                     

              addRoodLine(value,linePoint,color); // 1.添加的线名称 2.数据库查询的所有点 3.线颜色
              },  
              error: function (data) {  
                //alert(msg);
                //document.write(msg); 
                layer.alert("ajax有错！",{icon:5});  
            }  
          }); 
        }
        else{
          //移除图层
          var remove_overlay='polyline_'+value;
            var allOverlay = map.getOverlays();
            for (var i = 0; i < allOverlay.length; i++) {
              if(allOverlay[i].name==remove_overlay){

                map.removeOverlay(allOverlay[i]);
              }
                   
            }
                  
        }
    }
   /*
     **
     **这个方法是在onclick事件触发后，根据获取box的value，也是box的颜色，来给相应的线赋值各自的颜色，
       用户可以能更改box的颜色来更改在地图上添加的线的颜色。
     **
     */
  function addLineColor(value){
       if($('#'+value).is(':checked')) {
       var url='index.php/AddLineCon/MapLinePoints/'+value;//url
       // alert(url);
       var color=null;
        $.ajax({  
              type:"POST",   //方法  
              url: url,      //文件路径  
              dataType:"json",//用的是什么字符，json字符在js中相当有优势
              success:function(res){//查错  
                var linePoint = res;
                 if(sign === 'circle' || sign === 'oval') {
                  color = 'NOTCOLOR';
                 }else {
                  if (value=="t10kv") {
                    color=document.getElementById('color-box0').value;
                   }
                   else if(value=="t66kv"){
                    color=document.getElementById('color-box1').value;
                   }
                   else if(value=="t220kv"){
                    color=document.getElementById('color-box2').value;
                   }
                    else if(value=="rqgx"){
                    color=document.getElementById('color-box3').value;
                   }
                    else if(value=="ssgx"){
                    color=document.getElementById('color-box4').value;
                   }
                    else if(value=="wsgx"){
                    color=document.getElementById('color-box5').value;
                   }
                    else if(value=="xjgx"){
                    color=document.getElementById('color-box6').value;
                   }
                    else if(value=="ysgx"){
                    color=document.getElementById('color-box7').value;
                   }
                    else if(value=="fzsstd"){
                    color=document.getElementById('color-box8').value;
                   }
                    else if(value=="xytxxl"){
                    color=document.getElementById('color-box9').value;
                   }
                    else if(value=="grxzgx"){
                    color=document.getElementById('color-box10').value;
                   }
                   else if(value=="zydl"){
                    color=document.getElementById('color-box11').value;
                   }
                   else if(value=="fault_zone_copy"){
                    color=document.getElementById('color-box12').value;
                   }
                  else{
                    color="blue";
                  }
                 }
            addRoodLine(value,linePoint,color);// 1.添加的线名称 2.数据库查询的所有点 3.线颜色
            },  
            error: function (data) {  
              //alert(msg);
              //document.write(msg); 
              layer.alert("ajax有错！",{icon:5});  
          }  
        }); 
       }
        else{
          //移除图层
          var remove_overlay='polyline_'+value;
            var allOverlay = map.getOverlays();
            for (var i = 0; i < allOverlay.length; i++) {
              
              if(allOverlay[i].name==remove_overlay){

                map.removeOverlay(allOverlay[i]);
              }
                   
            }
                  
        }

    }
   /*
   **
   **这个方法是通过获取线的类型，所有点的经纬度，和颜色，来绘制地图上的线
   **
   */
    function addRoodLine(value,linePoint,color){
       if(color === 'NOTCOLOR') {
          var optionnc = nameAndClass(value),
          DIS = togroup(linePoint.linePoints),
          color = ["#000000","#83cc2b","#e4f149","#ffc800","#ff5e00","#f90600"];
          addLine({
            _class: optionnc._class,
            _name: optionnc._name,
            color: color,
            DIS: DIS
          });
       }else {
        //把把从数据库获得的经纬度放在piont数组里面
        for (var i = 0; i <= linePoint.linesID.length - 1; i++) {
          var pointnum = 0;
          var points = new Array();
          for (var j = 0; j <= linePoint.linePoints.length - 1; j++) {//linePoint.linesID[i].line
             if (linePoint.linesID[i].line==linePoint.linePoints[j].line) {

               var lat=linePoint.linePoints[j].baidu_X;
               var lng=linePoint.linePoints[j].baidu_Y;
              points[pointnum]=new BMap.Point(lat,lng); //把经纬度放在points数组里面
              pointnum++;
               }
         }
         //blue
         if(color=='#'){
           color=blue;
         }
        if (value=="t10kv") {
          //把点画成线加在地图上
          var polyline_t10kv= new BMap.Polyline(points,
                       {strokeColor:color, strokeWeight:2, strokeOpacity:0.5});   //创建折线   
          polyline_t10kv.name="polyline_t10kv";
          polyline_t10kv.class="polyline";
          map.addOverlay(polyline_t10kv);      
          }
        else if(value=="t66kv"){
          var polyline_t66kv= new BMap.Polyline(points,
                       {strokeColor:color, strokeWeight:3, strokeOpacity:0.5});   //创建折线   
          polyline_t66kv.name="polyline_t66kv";
          polyline_t66kv.class="polyline";
          map.addOverlay(polyline_t66kv);

          }
        else if(value=="t220kv"){
          var polyline_t220kv= new BMap.Polyline(points,
                       {strokeColor:color, strokeWeight:4, strokeOpacity:0.5});   //创建折线   
          polyline_t220kv.name="polyline_t220kv";
          polyline_t220kv.class="polyline";
          map.addOverlay(polyline_t220kv);
          }
        else if(value=="rqgx"){
           var polyline_rqgx= new BMap.Polyline(points,
                         {strokeColor:color, strokeWeight:2, strokeOpacity:0.5});   //创建折线   
           polyline_rqgx.name="polyline_rqgx";
           polyline_rqgx.class="polyline";
           map.addOverlay(polyline_rqgx);
          }
        else if(value=="ssgx"){
          var polyline_ssgx= new BMap.Polyline(points,
                             {strokeColor:color, strokeWeight:3, strokeOpacity:0.5});   //创建折线   
           polyline_ssgx.name="polyline_ssgx";
           polyline_ssgx.class="polyline";
           map.addOverlay(polyline_ssgx);
          }
        else if(value=="wsgx"){
            var polyline_wsgx= new BMap.Polyline(points,
            {strokeColor:color, strokeWeight:2, strokeOpacity:0.5});   //创建折线   
            polyline_wsgx.name="polyline_wsgx";
            polyline_wsgx.class="polyline";
            map.addOverlay(polyline_wsgx);
                 }
        else if(value=="xjgx"){
           var polyline_xjgx= new BMap.Polyline(points,
                             {strokeColor:color, strokeWeight:2, strokeOpacity:0.5});   //创建折线   
           polyline_xjgx.name="polyline_xjgx";
           polyline_xjgx.class="polyline";
           map.addOverlay(polyline_xjgx);
           }
        else if(value=="ysgx"){
           var polyline_ysgx= new BMap.Polyline(points,
                             {strokeColor:color, strokeWeight:2, strokeOpacity:0.5});   //创建折线   
           polyline_ysgx.name="polyline_ysgx";
           polyline_ysgx.class="polyline";
           map.addOverlay(polyline_ysgx);
           }
        else if(value=="fzsstd"){
           var polyline_fzsstd= new BMap.Polyline(points,
                             {strokeColor:color, strokeWeight:2, strokeOpacity:0.5});   //创建折线   
           polyline_fzsstd.name="polyline_fzsstd";
           polyline_fzsstd.class="polyline";
           map.addOverlay(polyline_fzsstd);
                 }
        else if(value=="xytxxl"){
           var polyline_xytxxl= new BMap.Polyline(points,
                             {strokeColor:color, strokeWeight:2, strokeOpacity:0.5});   //创建折线   
           polyline_xytxxl.name="polyline_xytxxl";
           polyline_xytxxl.class="polyline";
           map.addOverlay(polyline_xytxxl);
           }
        else if(value=="grxzgx"){
           var polyline_grxzgx= new BMap.Polyline(points,
                             {strokeColor:color, strokeWeight:2, strokeOpacity:0.5});   //创建折线   
           polyline_grxzgx.name="polyline_grxzgx";
           polyline_grxzgx.class="polyline";
           map.addOverlay(polyline_grxzgx);
            }
        else if(value=="zydl"){
           var polyline_zydl= new BMap.Polyline(points,
                             {strokeColor:color, strokeWeight:2, strokeOpacity:0.5});   //创建折线   
           polyline_zydl.name="polyline_zydl";
           polyline_zydl.class="polyline";
           map.addOverlay(polyline_zydl);
            }
        else if(value=="fault_zone_copy"){
           var polyline_fault_zone_copy= new BMap.Polyline(points,
                             {strokeColor:color, strokeWeight:2, strokeOpacity:0.5});   //创建折线   
           polyline_fault_zone_copy.name="polyline_fault_zone_copy";
           polyline_fault_zone_copy.class="polyline";
           map.addOverlay(polyline_fault_zone_copy);
            }
        else{
            var polyline = new BMap.Polyline(points,
                               {strokeColor:color, strokeWeight:2, strokeOpacity:0.5});   //创建折线   
             map.addOverlay(polyline);
            }
        }
       }
    }
    // 点分类
    function togroup (linePoints) {
        var line = linePoints;
        var _len = linePoints.length;

        var DIS = [];//返回数据
        var _points = []; //中间存放点的数组
        var lin_num = line[0].line;//记录点所属ＩＤ
        var dis = toDistory(line[0]); //记录点的受灾状态

        var dis0 = [];
        var dis1 = [];
        var dis2 = [];
        var dis3 = [];
        var dis4 = [];
        var dis5 = [];

        for(var i = 0; i < _len ; i++){
          var point = line[i];
          var result = toDistory(point);

          if(point.line == lin_num){
            if(dis == result){
              _points.push(point);
            }else{
              _points.push(point);
              if(dis == "不在震区"){
                  dis0.push(_points);
                }else if(dis == "良好"){
                  dis1.push(_points);
                }else if(dis == "轻微破坏"){
                  dis2.push(_points);
                }else if(dis == "中等破坏"){
                  dis3.push(_points);
                }else if(dis == "严重破坏"){
                  dis4.push(_points);
                }else if(dis == "毁坏"){
                  dis5.push(_points);
                }
              delete _points;
              var _points = []
              _points.push(point);
            }
          }else{
            if(dis == "不在震区"){
                dis0.push(_points);
              }else if(dis == "良好"){
                dis1.push(_points);
              }else if(dis == "轻微破坏"){
                dis2.push(_points);
              }else if(dis == "中等破坏"){
                dis3.push(_points);
              }else if(dis == "严重破坏"){
                dis4.push(_points);
              }else if(dis == "毁坏"){
                dis5.push(_points);
              }
              delete _points;
            var _points = [];
            _points.push(point);
          }
          dis = result;
          lin_num = point.line;
        }
        if(dis == "不在震区"){
          dis0.push(_points);
        }else if(dis == "良好"){
          dis1.push(_points);
        }else if(dis == "轻微破坏"){
          dis2.push(_points);
        }else if(dis == "中等破坏"){
          dis3.push(_points);
        }else if(dis == "严重破坏"){
          dis4.push(_points);
        }else if(dis == "毁坏"){
          dis5.push(_points);
        }
        DIS.push( dis0 );
        DIS.push( dis1 );
        DIS.push( dis2 );
        DIS.push( dis3 );
        DIS.push( dis4 );
        DIS.push( dis5 );

        return DIS;
    }

    function toDistory (data) {


      var _poly = find_ovals;
      var _len = _poly.length;
      var d = data;
      var p = new BMap.Point( d.baidu_X, d.baidu_Y);
      var c = -1;
      var t = "";
      for(var j = 0; j < _len; j++){
          if(BMapLib.GeoUtils.isPointInCircle( p, _poly[j])){
              c++;
          }else{
              break;
          }
      }
        if(c == -1){
          return "不在震区";
        }else if(c == 0){
          return d.sixDegrEarthDam;
        }else if(c == 1){
          return d.sevenDegrEarthDam;
        }else if(c == 2){
          return d.eightDegrEarthDam;
        }else if(c == 3){
          return d.nineDegrEarthDam;
        }else if(c >= 4){
          return d.tenDegrEarthDam;
        }
    }
    // 得到线的name和class
    function nameAndClass (value) {
      var _name = '',
      _class = '';
      if (value=="t10kv") {
          _name="polyline_t10kv";
          _class="polyline";  
          }
        else if(value=="t66kv"){
          _name="polyline_t66kv";
          _class="polyline";
          }
        else if(value=="t220kv"){
          _name="polyline_t220kv";
          _class="polyline";
          }
        else if(value=="rqgx"){ 
           _name="polyline_rqgx";
           _class="polyline";
          }
        else if(value=="ssgx"){  
           _name="polyline_ssgx";
           _class="polyline";
          }
        else if(value=="wsgx"){ 
            _name="polyline_wsgx";
            _class="polyline";
                 }
        else if(value=="xjgx"){ 
           _name="polyline_xjgx";
           _class="polyline";
           }
        else if(value=="ysgx"){  
           _name="polyline_ysgx";
           _class="polyline";
           }
        else if(value=="fzsstd"){ 
           _name="polyline_fzsstd";
           _class="polyline";
                 }
        else if(value=="xytxxl"){
           _name="polyline_xytxxl";
           _class="polyline";
           }
        else if(value=="grxzgx"){
           _name="polyline_grxzgx";
           _class="polyline";
            }
        else if(value=="zydl"){
           _name="polyline_zydl";
           _class="polyline";
            }
        else if(value=="fault_zone_copy"){  
           _name="polyline_fault_zone_copy";
           _class="polyline";
            }
        return {
          _class: _class,
          _name: _name
        };
    }
    function addLine (msg) {
      var _class = msg._class;
      var _name = msg._name;
      var color = msg.color;
        var data = msg.DIS;
        var _len = data.length;
        var _store = [];
        var _store_line = [];
        for (var i = 0; i < _len; i++){
          l_col = color[i];
          var _line = data[i];
          for (var j = 0; j < _line.length; j++)
          {
            for (var k = 0; k < _line[j].length; k++){
              var p = _line[j][k];
              var point = new BMap.Point(p.baidu_X ,p.baidu_Y);
              _store.push(point);
            }
            var _polyline = new BMap.Polyline(_store,{strokeColor:l_col, strokeWeight:3, strokeOpacity:1});
            _polyline.name = _name;
            _polyline.class = _class;
            _store = [];
            _store_line.push(_polyline);
          }
        }
        for (_degree in _store_line){
          map.addOverlay(_store_line[_degree]);
        }
    }
    //清除面图层
    function removeOver(){
      $("#close").css("display","none");
      sign = null; //清除烈度图
      var allOverlay = map.getOverlays();
        for(var i=0;i<allOverlay.length;i++){
            if(allOverlay[i].class=="circle" ||allOverlay[i].class=="oval")
             map.removeOverlay(allOverlay[i]); 
        }
        if(I_label!= null){
          for(var i=0;i < I_label.length;i++){
            map.removeOverlay(I_label[i]);
          }
          window.I_label=[];
        }
        find_ovals=[];
    }
    // xsh 清除建筑物
    function removeBuilding(){
        markerClusterer.removeMarkers(warming_points);//清除残留的聚合点数组  
        for(var i=0;i<allOverlay.length;i++){
            if(allOverlay[i].class=="building")
             map.removeOverlay(allOverlay[i]); 
        }
    }
    //清理线图层
    function removeAllPolyline(){
      $("[class='lineCheckBox']").removeAttr("checked");//取消全选
      var allPolyline = map.getOverlays();
        for (var i = 0; i < allPolyline.length; i++) {
          if(allPolyline[i].class=="polyline")
            map.removeOverlay(allPolyline[i]); 
           }
  }
  //清除海量点
  function removeMassivePoint(value){
    if(value!=""){
            for(var i=0;i<sea_constore.length;i++){
              if(sea_constore[i]!=null){
                if(typeof (sea_constore[i].pointCollection.__proto__.PQ) != "undefined" && typeof (sea_constore[i].class) != "undefined"){
                  
                 
                  var pointCollection_name= sea_constore[i].pointCollection.__proto__.PQ;
                  var pointCollection_class=sea_constore[i].class
                  if (pointCollection_name === "PointCollection" && pointCollection_class === value) {
                    if(sea_constore[i]!=null)
                      map.removeOverlay(sea_constore[i].pointCollection);
                  }
                }
              }
            }

              for(var i=0;i<sea_constore.length;i++){
                if(sea_constore[i]!=null){
                  if(sea_constore[i].class==value){
                    sea_constore[i]=null
                  } 
              }
            } 
          
      }else{
        for(var i=0;i<sea_constore.length;i++){
          if(sea_constore[i]!=null)
            map.removeOverlay(sea_constore[i].pointCollection);
        } 
        sea_constore=[]
      }
    }
  //清除echart缓存数据
  function clearEchartCookie(){
     //清除缓存数据
     UntouchNum=new o();
     SlightNum=new o();
     ModerateNum=new o();
     SeriusNum=new o();
     CollaPNum=new o();
  }
  //清理点图层
  function removeAllMarker(){
   $("[class='input-position']").removeAttr("checked");//取消全选
   //$('#ggjzw').removeAttr("checked");//取消全选
    var allOverlay = map.getOverlays();
    $('#legend').css("display","none");
    if(markerClusterer!= null){
      markerClusterer.removeMarkers(w_points.length==0?middle_w_points:w_points);//清除残留的聚合点数组
      w_points=[];  
      middle_w_points=[]
    }
    removeMassivePoint("")
    if(labels!= null){
      for(var i=0;i<labels.length;i++){
        map.removeOverlay(labels[i]);
      }
      window.labels=[];
    }
    clearEchartCookie()

    // if(document.getElementById('legend')==""){
    //   var k = document.getElementById('legend');
    //   k.display = none;
    // }

    for(var i=0;i<allOverlay.length;i++){
            if(allOverlay[i].flag=="marker")
             map.removeOverlay(allOverlay[i]); 
        }
  }

  //添加所有建筑物pipi
    function return_build_data(value){
      //判断是否被选中
     if ($('#'+value).is(':checked')) {
              $.ajax({  
                type:'post',   //方法  
                url:'index.php/Data/addBuildPoint_C/',      //文件路径  
                dataType:'text',//用的是什么字符，json字符在js中相当有优势 
                data:{"type":value},//data:"IntensityValue=" + params,//要传送的数据  
              //  async: true,//是否同步或者异步  
                success:function(data){
                      var data= eval("("+data+")");
                      markerArr=data;
                      if(sign=="oval"){//椭圆
                      addMarkerOval("1",markerArr,value);
                      setTimeout("StartCapture('B')",4000);//截图函数一定放在函数的末尾
                      }else{//圆形
                      addMarkerown("1",markerArr,value);
                      setTimeout("StartCapture('B')",4000);//截图函数一定放在函数的末尾
                      }    
                },  
                error: function (data) {  
                    $("#legend").css("display","none");
                    layer.alert(data,{icon:0});
              }  
          });  
            }else{
              console.log(12312)
              $('#'+value).attr("checked",false);
               UntouchNum[value]=0;
               SlightNum[value]=0;
               ModerateNum[value]=0;
               SeriusNum[value]=0;
               CollaPNum[value]=0;
              $("#legend").css("display","none");
              removeMassivePoint(value)
            }
              //自动截图 添加建筑物   
    }
    //判断是哪一种截图 pipi
    function check(){
      var num1=document.getElementById("selectjietu").value
      var target=document.getElementById("showornone");
      if (num1=="1"){
        target.style.display="none";
      }else{
        target.style.display="block";
      }
    }
   


    //截图
    $().ready(function(){ 
    $('#moreparams').hide();
    
    $('#captureselectSize').click( function(){
      var autoFlag = $("#captureselectSize").attr("checked")=="checked" ? 1 : 0;
      if(autoFlag == 1){
        $('#moreparams').show();
      }
      else{
        $('#moreparams').hide();
      }
    });
    $('#getimagefromclipboard').click( function(){
      $('#posdetail').hide();
    });
    $('#showprewindow').click( function(){
      $('#posdetail').hide();
    });
    $('#fullscreen').click( function(){
      $('#posdetail').hide();
    });
    $('#specificarea').click( function(){
      $('#posdetail').show();
    });
    $('#showprewindow').click();
    $('#autoupload').click();
    $('#btnUpload').hide();   
    Init();
  })  



        
    //查询添加建筑物PIPI
    function return_search_build_data(buildingName){
         //var buildingName=document.getElementById("search_a").value;
         if(markerArr!=""){
          removeAllMarker();
         }
         var url="index.php/Data/search_C";

              $.ajax({  
                type:'post',   //方法  
                url:url,      //文件路径  
                dataType:'text',//用的是什么字符，json字符在js中相当有优势  
                data:{"name":buildingName},//data:"IntensityValue=" + params,//要传送的数据  
                async: false,//是否同步或者异步  
                success:function(data){//查错
                     // alert(data);  
                    var data= eval("("+data+")");
                       markerArr=data;
                      //addMarker("0",markerArr);
                      if(data==""){
                       layer.alert("查询不到相关信息",{icon:5});//需要重写
                      }else{
                       addMarkerown("2",markerArr,"mocx");
                       statisticalResult(markerArr);
                   }
                

                },  
                error: function (data) {  
                   
                        layer.alert(data,{icon:0});
              }  
          });  
       // StartCapture('B');//截图函数一定防灾函数的末尾
    }
    
    //两点计算机距离震源坐标startX,startY，建筑物坐标x,y
    function getDistance(startX,startY,x,y){
     var point1 = new BMap.Point(startX,startY);  
     var point2 = new BMap.Point(x,y);  
        distance = map.getDistance(point1,point2);
       //  alert("11 "+distance);
     var kilometr=distance/1000;//转换公里
     //alert("22 "+kilometr);
     return kilometr;

    }
      var untouchedIMG="";//良好
      var slightDamageIMG="";//轻微破坏
      var moderateDamageIMG="";//中等破坏
      var seriousDamageIMG="";//严重破坏
      var collapsedIMG="";//毁坏
    function getStationImage(info){
       var url= 'index.php/Data/getImages/'+info;
       var imageData='';
       $.ajax({  
                type:'post',   //方法  
                url:url,      //文件路径  
                dataType:'text',//用的是什么字符，json字符在js中相当有优势  
                // data:{"type":value},//data:"IntensityValue=" + params,//要传送的数据  
                async: false,//是否同步或者异步   
                success:function(data){//查错
                    // alert(data);
                       imageData= eval("("+data+")");
                     
                },  
                error: function (data) {  
                        layer.alert("网络出错了",{icon:5});
              }  
          }); 
       // alert("111");
       // alert(imageData);
         return imageData;
    }
    function setClassPercentage(markerArr,distanceValue,value,i){
      var info;//建筑破坏情况
      if (distanceValue==6) {
       info=markerArr[i].sixDegrEarthDam;
       //imagePath="public/images/sixIntensity.png";
        // sixIntensity++;
        // UntouchNum[value]++;
      }else if (distanceValue==7) {
       info=markerArr[i].sevenDegrEarthDam;
       // imagePath="public/images/sevenIntensity.png";
        // sevenIntensity++;
        // SlightNum[value]++;
      }else if (distanceValue==8) {
        info=markerArr[i].eightDegrEarthDam;
       // imagePath="public/images/eightIntensity.png";
        // eightIntensity++;
        // ModerateNum[value]++;
      }else if (distanceValue==9) {
          // nineIntensity++;
          //alert(eightIntensity);
          info=markerArr[i].nineDegrEarthDam;
          //imagePath="public/images/nineIntensity.png";
          // SeriusNum[value]++;
      }else if (distanceValue==10) {
          //  tenIntensity++;
           //alert(tenIntensity);
          info=markerArr[i].tenDegrEarthDam;
          //imagePath="public/images/tenIntensity.png";
          // CollaPNum[value]++;
      }else{
        info="房屋没有损坏安全"; 
       // imagePath="public/images/noneIntensity.png";
      }  
      if (info=="良好") {
        UntouchNum[value]++;
        }
        else if (info=="轻微破坏") {
        
          SlightNum[value]++;
        }
        else if (info=="中等破坏") {
          ModerateNum[value]++;
        }
        else if (info=="严重破坏") {
          SeriusNum[value]++;
        }
        else if (info=="毁坏") {
          CollaPNum[value]++;
        }
    }
          //创建InfoWindow 添加建筑物pipi
    function createInfoWindow(markerArr,i,is,pictureList,value,data){
        var lat = data.point.lat;
        var lng = data.point.lng;
        var p_len = markerArr.length;
        for (var i = 0; i < p_len ; i++){
          var p = markerArr[i];
          if(lat == p.baidu_Y || lng == p.baidu_X)
          {
            break;
          }
        }
        var json=p
        var point = new BMap.Point(lng,lat);
        marker_i=-1;
        for(ovals_i in find_ovals){
          if(BMapLib.GeoUtils.isPointInCircle(point,find_ovals[ovals_i])){
              marker_i++;
            }else{
              break;
            }
          }
          if(marker_i>-1){
              if(marker_i==0){
                  var po=json.sixDegrEarthDam;
              }else if(marker_i==1){
                  var po=json.sevenDegrEarthDam;
              }else if(marker_i==2){
                  var po=json.eightDegrEarthDam;
              }else if(marker_i==3){
                  var po=json.nineDegrEarthDam;
              }else if(marker_i==4){
                  var po=json.tenDegrEarthDam;
              }
              distanceValue=marker_i+6;
            }else{
              distanceValue='不在主要烈度内';
            }
      //  console.log(SlightNum);
       var info;//建筑破坏情况
       var imagePath;//点图片的路径
       if (distanceValue==6) {
        info=markerArr[i].sixDegrEarthDam;
        //imagePath="public/images/sixIntensity.png";
         sixIntensity++;
       }else if (distanceValue==7) {
        info=markerArr[i].sevenDegrEarthDam;
        // imagePath="public/images/sevenIntensity.png";
         sevenIntensity++;
       }else if (distanceValue==8) {
         info=markerArr[i].eightDegrEarthDam;
        // imagePath="public/images/eightIntensity.png";
         eightIntensity++;
       }else if (distanceValue==9) {
           nineIntensity++;
           //alert(eightIntensity);
           info=markerArr[i].nineDegrEarthDam;
           //imagePath="public/images/nineIntensity.png";
       }else if (distanceValue==10) {
            tenIntensity++;
            //alert(tenIntensity);
           info=markerArr[i].tenDegrEarthDam;
           //imagePath="public/images/tenIntensity.png";
       }else{
         info="房屋没有损坏安全"; 
        // imagePath="public/images/noneIntensity.png";
       }  

       if (info=="良好") {
         var ranNum=parseInt(Math.random()*(untouchedIMG.length) ); //生成0——n的随机数整数
         imagePath=untouchedIMG[ranNum];//良好
        //  UntouchNum[value]++;
         //imagePath="public/images/situationPicture/untouched_0"+ranNum+".jpg";
         }
         else if (info=="轻微破坏") {
           var ranNum=parseInt(Math.random()*(slightDamageIMG.length) ); //生成0——n的随机数整数
           imagePath=slightDamageIMG[ranNum];//轻微破坏
          //  SlightNum[value]++;
           //imagePath="public/images/situationPicture/slightDamage_0"+ranNum+".jpg";
         }
         else if (info=="中等破坏") {
           var ranNum=parseInt(Math.random()*(moderateDamageIMG.length) ); //生成0——n的随机数整数
           imagePath=moderateDamageIMG[ranNum];//中等破坏
          //  ModerateNum[value]++;
           //imagePath="public/images/situationPicture/moderateDamage_0"+ranNum+".jpg";
         }
         else if (info=="严重破坏") {
           var ranNum=parseInt(Math.random()*(seriousDamageIMG.length) ); //生成0——n的随机数整数
           imagePath=seriousDamageIMG[ranNum];//严重破坏
          //  SeriusNum[value]++;
           //imagePath="public/images/situationPicture/seriousDamage_0"+ranNum+".jpg";
         }
         else if (info=="毁坏") {
           var ranNum=parseInt(Math.random()*(collapsedIMG.length) ); //生成0——n的随机数整数
           imagePath=collapsedIMG[ranNum];//毁坏
          //  CollaPNum[value]++;
           //imagePath="public/images/situationPicture/collapsed_0"+ranNum+".jpg";
         }
         else {
            (function(i){
              for(var j=0;j< pictureList.length;j++){
                var fileName = pictureList[j].substring(0,pictureList[j].indexOf(".")); 
                if(markerArr[i].buildingNumber!="" && markerArr[i].buildingNumber ==  fileName){
                  imagePath = "public/images/situationPicture/buildingPictures/"+ pictureList[j];
                  break;
                }
              }
              if(j==pictureList.length){//没有对应的建筑物
                 var ranNum=parseInt(Math.random()*(untouchedIMG.length) ); //生成0——n的随机数整数
                 imagePath=untouchedIMG[ranNum];//良好
                 //imagePath="public/images/situationPicture/untouched_0"+ranNum+".jpg";
              }
            })(i);
        }
         //建筑物名字或者楼号
         //如果后台返回楼号为空则从用户输入值为准
        var bulidInfo=markerArr[i].ToOrHuOrviOrCo+no+'号';
          
        
         
      //震前表单 
      var sContent='<table class="layui-table" lay-even="" lay-skin="row"><colgroup><col width="150"><col width="150"></colgroup><thead><tr><th colspan=2>建筑属性<a style="margin-left: 10px;color:rgb(61,109,204);font-size:7px;" onclick="chartInfo('+i+')">详情</a></th></tr></thead><tbody><tr style="width:100%"><td>名称：'+markerArr[i].buildingName+'</td><td rowspan=3><img src='+imagePath+' width="139" height="150"></td></tr><tr><td>类型：'+markerArr[i].propertyType+'</td></tr><tr><td>抗震：'+markerArr[i].earthquakeFortification+'度</td></tr></tbody></table>';     //震后表单 
      var sContentTwo='<table class="layui-table" lay-even="" lay-skin="row"><colgroup><col width="150"><col width="150"></colgroup><thead><tr><th colspan=2>建筑属性<a style="margin-left: 10px;color:rgb(61,109,204);font-size:7px;" onclick="chartInfo('+i+')">详情</a></th></tr></thead><tbody><tr style="width:100%"><td>名称：'+markerArr[i].buildingName+'</td><td rowspan=3><img id='+markerArr[i].buildingNumber+' name="buildingPictures" src='+(imagePath+'?'+Math.floor(Math.random()*9))+' width="139" height="150" title="点击图片可实现图片更新!" onclick="addpicture()"><input name="simpleImage" type="file" id="uploadPicture" class="btn btn-info" onchange="javascript:uploadPicture('+i+')" style="display:none" /></td></tr><tr><td>类型：'+markerArr[i].propertyType+'</td></tr><tr><td>'+distanceValue+'度'+info+'</td></tr></tbody></table>';
      //精确查询表单震后
      var sContentThree='<table class="layui-table" lay-even="" lay-skin="row"><colgroup><col width="150"><col width="150"></colgroup><thead><tr><th colspan=2>建筑属性<a style="margin-left: 10px;color:rgb(61,109,204);font-size:7px;" onclick="chartInfo('+i+')">详情</a></th></tr></thead><tbody><tr style="width:100%"><td>名称：'+markerArr[i].buildingName+'</td><td rowspan=3><img src='+imagePath+' width="139" height="150"></td></tr><tr><td>类型：'+markerArr[i].propertyType+'</td></tr><tr><td>'+distanceValue+'度'+info+'</td></tr></tbody></table>';
      //精确查询表单震前
      var sContentFour='<table class="layui-table" lay-even="" lay-skin="row"><colgroup><col width="150"><col width="150"></colgroup><thead><tr><th colspan=2>建筑属性<a style="margin-left: 10px;color:rgb(61,109,204);font-size:7px;" onclick="chartInfo('+i+')">详情</a></th></tr></thead><tbody><tr style="width:100%"><td>名称：'+markerArr[i].buildingName+'</td><td rowspan=3><img src='+imagePath+' width="139" height="150"></td></tr><tr><td>类型：'+markerArr[i].propertyType+'</td></tr><tr><td>抗震：'+markerArr[i].earthquakeFortification+'度</td></tr></tbody></table>';     //震后表单 

     if(is=="3"){
            //精确查询
            if (intensity1==0) {//震前查询
                    var iw = new BMap.InfoWindow(sContentFour);
            }else{//震后查询
                    var iw = new BMap.InfoWindow(sContentThree);
            }
      }else if(is=="2"){
            //模糊查询
            if (intensity1==0) {//震前查询
                    var iw = new BMap.InfoWindow(sContentFour);
            }else{//震后查询
                    var iw = new BMap.InfoWindow(sContentThree);
            }
      }else{//震后
           var iw = new BMap.InfoWindow(sContentTwo);
      }
        return iw;
    }

    function addpicture(){
       document.getElementById("uploadPicture").click();
    }
    function uploadPicture(i){
        var filename=document.getElementById("uploadPicture").value;
        if(filename.indexOf("jpg")<0&&filename.indexOf("png")<0)
        {
          layer.msg("请选择格式为.jpg或.png的文件！");
          return false;
        }
        var type=filename.substr(filename.indexOf("."));
        var buildingNumber=markerArr[i].buildingNumber;
            var fd = new FormData();
            fd.append("uploadPicture", 1);
            fd.append("uploadPicture", $("#uploadPicture").get(0).files[0]);//$("#upfile").get(0).files[0]
            $.ajax({
              url: "index.php/Data/ajaxSavePicture/"+buildingNumber,
              type: "POST",
              processData: false,
              contentType: false,
              data: fd,
              success: function(d) {
                if (d=='Failed') {
                  layer.msg("网络出错了",{icon:5});
                }else{
                  document.getElementById(buildingNumber).src="public/images/situationPicture/buildingPictures/"+buildingNumber+type+'?'+Math.random();
                  layer.msg("上传成功");
                }
              
              }
            });
    }



     function draw_chart1(){
    if(!markerArr){
    layer.alert("建筑数据为空不能绘制",{icon:2});
    }else{
   draw_chart(UntouchNum,SlightNum,ModerateNum,SeriusNum,CollaPNum);
    }
    }
    function draw_initchart(){
    if(!markerArr){
    layer.alert("建筑数据为空不能绘制",{icon:2});
    }else{
   draw_chart_init(UntouchNum,SlightNum,ModerateNum,SeriusNum,CollaPNum);
    }
    }
   //zdx_传入5参数，绘制饼状图
    //wz修改
    //sixIntensity,sevenIntensity,eightIntensity,nineIntensity,tenIntensity
    function draw_chart(UntouchNum,SlightNum,ModerateNum,SeriusNum,CollaPNum){
      initChartView(UntouchNum,SlightNum,ModerateNum,SeriusNum,CollaPNum,0);
      
      
      var myChartPIE = echarts.init(document.getElementById('chart'));
        //指定饼状图的配置项和数据显示图标
        var optionPIE ={
            
            color: ['#5EF36C','#2BF3F3', '#FFFF0B', '#FF941B','#F30404'],
            tooltip:{
                trigger:'item',
                formatter:"{a} <br/>{b} : {c} ({d}%)"
            },
            legend:{
                orient:'vertical',
                left:'left',
                data:['良好','轻微破坏','中等破坏','严重破坏','毁坏']
            },
            series:[
                {
                    name:'破坏情况',
                    type:'pie',
                    radius:'55%',
                    center:['25%','55%'],
                    data:[                                               
                        {value:UntouchNum.sum(), name:'良好'},
                        {value:SlightNum.sum(), name:'轻微破坏'},
                        {value:ModerateNum.sum(), name:'中等破坏'},
                        {value:SeriusNum.sum(), name:'严重破坏'},
                        {value:CollaPNum.sum(), name:'毁坏'}
                    ],
                    itemStyle:{
                        emphasis:{
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }
            ]

        };
        myChartPIE.setOption(optionPIE);
        //startXif (document.getElementById("selectjietu").value==1) {
           //StartCapture('C');  //截图函数一定防灾函数的末尾
        //}
       
    }
function draw_chart_init(UntouchNum,SlightNum,ModerateNum,SeriusNum,CollaPNum){
      initChartView(UntouchNum,SlightNum,ModerateNum,SeriusNum,CollaPNum,1);
      var myChart = echarts.init(document.getElementById('chart'));
    myChart.title = '坐标轴刻度与标签对齐';

option = {
    color: ['#3398DB'],
    //color: ['#2f4554', '#61a0a8', '#d48265', '#91c7ae','#749f83'],
    legend:{
                orient:'vertical',
                left:'left',
                data:['良好','轻微破坏','中等破坏','严重破坏','毁坏']
            },
    tooltip : {
        trigger: 'axis',
        axisPointer : {            // 坐标轴指示器，坐标轴触发有效'#3398DB'
            type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
        }
    },
    grid: {
        left: '3%',
        right: '45%',
        top: '20%',
        bottom: '3%',
        containLabel: true
    },
    xAxis : [
        {
            type : 'category',
            data : ['良好', '轻微破坏', '中等破坏', '严重破坏', '毁坏'],
            axisTick: {
                alignWithLabel: true
            }
        }
    ],
    yAxis : [
        {
            type : 'value'
        }
    ],
    textStyle:{
              //color:'black',
              fontSize:15
            },
    series : [
        {
            legendHoverLink:true,
            name:'影响建筑',
            type:'bar',
            label:{
              normal:{
                show:true,
                position:'top',
                //formatter:'{b}\n影响建筑:{c}'
              }
            },
            barWidth: '30%',
            data:[                                               
                        {value:UntouchNum.sum(), name:'良好'},
                        {value:SlightNum.sum(), name:'轻微破坏'},
                        {value:ModerateNum.sum(), name:'中等破坏'},
                        {value:SeriusNum.sum(), name:'严重破坏'},
                        {value:CollaPNum.sum(), name:'毁坏'}
                    ],
            itemStyle: {
                normal: {
                    color: function(params) {
                        // build a color map as your need.
                        var colorList = [
                          '#5EF36C','#2BF3F3', '#FFFF0B', '#FF941B','#F30404'
                        ];
                        return colorList[params.dataIndex]
                    }
                }
            }
        }
    ]
};

myChart.setOption(option);
    }
    //创建一个Icon 小图标 ，intensity 震级,Distance 到震源距离 ，pipi


function WordExport1(item){
  if(!startX){
     layer.alert("操作有误，无数据，请先绘制烈度图",{icon:2});
  }else{
    WordExport(startX,startY,item);
  }
}
    //zdx_y ajax传入两参数，中心点坐标
    function WordExport(startX,startY,item){
        //var M =document.getElementById('earthquakeMagnitude').value;
        //计算总和
        var describe_flag=0;
        var sumNum=UntouchNum.sum()+SlightNum.sum()+ModerateNum.sum()+SeriusNum.sum()+CollaPNum.sum();
        //样本总和
        var sumSam=sumNum;
        //抽样调查
        console.log(UntouchNum);
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
        var sum_three=UntouchRat+SlightRat;
        //第一种：点的集合为0;无可能情况，0
        //第二种，良好+轻微+中度95%-100,1
        //第三种，良好+轻微+中度>90%-95,2
        //第四种，良好+轻微+中度85-90,3
        //第五种，良好+轻微+中度75-85,4
        //第六种，良好+轻微+中度65-75,5
        //第七种，良好+轻微+中度55,6
        // if(sumNum==0){
        //   describe_flag=0;
        // }else if(sum_three>95){
        //   describe_flag=1;
        // }else if(sum_three<=95&&sum_three>90){
        //   describe_flag=2;
        // }else if(sum_three<=90&&sum_three>85){
        //   describe_flag=3;
        // }else if(sum_three<=85&&sum_three>75){
        //   describe_flag=4;
        // }else if(sum_three<=75&&sum_three>65){
        //   describe_flag
        //   =5;
        // }else{
        //   describe_flag=6;
        // }
        
        if(sum_three<10){
          describe_flag=6;
        }else if(sum_three>=10&&sum_three<20){
          describe_flag=5;
        }else if(sum_three>=20&&sum_three<30){
          describe_flag=4;
        }else if(sum_three>=30&&sum_three<40){
          describe_flag=3;
        }else if(sum_three>=40&&sum_three<50){
          describe_flag=2;
        }else{
          describe_flag=1;
        }
        //var url="<?php echo site_url('WordExport/index'); ?>";
        var url = 'index.php/WordExport/index';
        //var url_ppt="<?php echo site_url('PowerPointExport/index'); ?>";
        var url_ppt = 'index.php/PowerPointExport/index';
        startX;
        startY;
        M;
        // console.log(startX);
        var detail_address='';
        var point = new BMap.Point(startX,startY);
        // console.log(point);
        var gc = new BMap.Geocoder();
        var FailureType='';
        gc.getLocation(point, function(rs){
          var addComp = rs.addressComponents;
          var html=addComp.province + addComp.city + addComp.district + addComp.street;
          detail_address=html;
          FailureType=w_points.length==0?"中等破坏":"严重破坏和毁坏";
          if((w_points.length==0?middle_w_points:w_points)!=null){ 
            markerClusterer = new BMapLib.MarkerClusterer(map, {markers:w_points.length==0?middle_w_points:w_points});
            var markerpoint=markerClusterer.tobackpoint();
          }else{
            var markerpoint=[];
          }
          if(item==='w')
          {
            
            $.ajax({
              url:url,
              type:"POST",
              dataType:"text", 
              data:{"FailureType":FailureType,"detail_address":detail_address,"describe_flag":describe_flag,"startX":startX,"startY":startY,"intensity":M,"capturearray":capturearray,"markerpoint":JSON.stringify(markerpoint),"warming_points":JSON.stringify(warming_points)},
              success : function(data){
                                //var lohref = "<?php echo site_url('WordExport/sefile') ?>"+"?zdx="+data+"" +"";
                                  var lohref = "index.php/WordExport/sefile"+"?zdx="+data;
                                  location.href = lohref;
                          },
              error : function(){  
                      layer.alert('出错了，请检查网络设置！！！',{icon:5});  
                  }
            });
          }
          else{
            $.ajax({
              url:url_ppt,
              type:"POST",
              dataType:"text", 
              data:{"detail_address":detail_address,"describe_flag":describe_flag,"startX":startX,"startY":startY,"intensity":M,"capturearray":capturearray,"markerpoint":JSON.stringify(markerpoint),"warming_points":JSON.stringify(warming_points)},
              async:true,
              success: function(data){
                                    //var lohrefl = "<?php echo site_url('PowerPointExport/sefile') ?>"+"?zdx="+data+"" +"";
                                    var lohrefl = "index.php/PowerPointExport/sefile"+"?zdx="+data;
                                    location.href = lohrefl;
                              },
                              error: function(e){  
                                console.log(e)
                          layer.alert('出错了，请检查网络设置！！！',{icon:5}); 
                      },
              });
          }
      });
      } 
      //椭圆加点 is 是操作类型 ，markerArr 是点数据 type 房屋类型
 // function addMarkerOval(is,markerArr,type){
     
 //      //  var intensity=intensity1//获取震级
 //      //  alert(markerArr);
 //        untouchedIMG=getStationImage('untouched');
 //        slightDamageIMG=getStationImage('slightDamage');
 //        moderateDamageIMG=getStationImage('moderateDamage');
 //        seriousDamageIMG=getStationImage('seriousDamage');
 //        collapsedIMG=getStationImage('collapsed');
 //        for(var i=0;i<markerArr.length;i++){
 //              var json = markerArr[i];
 //            // alert(json.buildingName);
 //            var p0 = json.baidu_X;//经度
 //            var p1 = json.baidu_Y;//纬度
 //             var Distance=getDistanceOval(arrjiaodian,p0,p1);//返回长轴烈度
 //            // alert("33 "+i+"点"+Distance);
 //            var point = new BMap.Point(p0,p1);

 //            var myIcon =createIconOval(Distance);//返回图标类型
 //            var marker = new BMap.Marker(point,{icon:myIcon});
 //               marker.class=type; //给建筑物覆盖物添加属性以便查找
 //               marker.flag="marker";
 //              map.addOverlay(marker); //添加点图层
 //              (function(){
                 
 //                   var _iw = createInfoWindowOval(markerArr,i,is,Distance);
              
 //                //给点图层创建信息窗口
 //                var _marker = marker;
 //                _marker.addEventListener("click",function(){//给点图层添加点击事件
 //                    this.openInfoWindow(_iw);
 //                });
 //            })();
 //        }
 //        //alert(eightIntensity);
 //          distanceValue=0;//赋值为零是清除赋值
 //          allOverlay = map.getOverlays();
 //      // StartCapture('B');  //截图函数一定防灾函数的末尾
 //          // StartCapture();//
 //    }



// //susu重写
// function addMarkerOval(is,markerArr,type){
     
//       //  var intensity=intensity1//获取震级
//       //  alert(markerArr);
//         untouchedIMG=getStationImage('untouched');
//         slightDamageIMG=getStationImage('slightDamage');
//         moderateDamageIMG=getStationImage('moderateDamage');
//         seriousDamageIMG=getStationImage('seriousDamage');
//         collapsedIMG=getStationImage('collapsed');
//         var locationdate=new Date;
//         var locationyear=locationdate.getFullYear();                          
//         for(var i=0;i<markerArr.length;i++){
//               var json = markerArr[i];    
//               var p0 = json.baidu_X;//经度
//               var p1 = json.baidu_Y;//纬度
//               var point = new BMap.Point(p0,p1);

//               var marker_i=-1;
//               for(ovals_i in find_ovals){
//                if(BMapLib.GeoUtils.isPointInPolygon(point,find_ovals[ovals_i])){
//                   marker_i++;
//                   continue;
//                   }else{
//                     break;
//                   }
//               }
//               if(marker_i>-1){
//                   var longinten=intexy[marker_i][0];//长轴烈度
//                   var shortinten=intexy[marker_i][1];//短轴烈度
//                   if(longinten*1>=shortinten*1)
//                   {
//                     chuangzhou=longinten;
//                   }else
//                   {
//                     chuangzhou=shortinten;
//                   }
//               }else{
//                 chuangzhou=4;
//               }

//               var myIcon =createIconOval(chuangzhou,json,locationyear);//返回图标类型
//               var marker = new BMap.Marker(point,{icon:myIcon});
//               marker.class=type; //给建筑物覆盖物添加属性以便查找
//               marker.flag="marker";
//               map.addOverlay(marker); //添加点图层
//               (function(){
                 
//                    var _iw = createInfoWindowOval(markerArr,i,is);
              
//                 //给点图层创建信息窗口
//                 var _marker = marker;
//                 _marker.addEventListener("click",function(){//给点图层添加点击事件
//                     this.openInfoWindow(_iw);
//                 });
//             })();
//         }

//         distanceValue=0;//赋值为零是清除赋值
//         allOverlay = map.getOverlays();
//     }


//椭圆普通加点转海量加点方式
function addMarkerOval(is,markerArr,type){
      //  var intensity=intensity1//获取震级
      //  alert(markerArr);
        var pa=[]
        var pb=[]
        var pc=[]
        var pd=[]
        var pe=[]
        var pf=[]
        var _dis0 = [];
        var _dis1 = [];
        var _dis2 = [];
        var _dis3 = [];
        var _dis4 = [];
        var _dis5 = [];
        var _constore =[]//海量点存储
        untouchedIMG=getStationImage('untouched');
        slightDamageIMG=getStationImage('slightDamage');
        moderateDamageIMG=getStationImage('moderateDamage');
        seriousDamageIMG=getStationImage('seriousDamage');
        collapsedIMG=getStationImage('collapsed');
        var marker_i;
        warming_points.splice(0,warming_points.length);
        w_points.splice(0,w_points.length);                  
        for(var i=0;i<markerArr.length;i++){
              var json = markerArr[i];    
              var p0 = json.baidu_X;//经度
              var p1 = json.baidu_Y;//纬度
              var point = new BMap.Point(p0,p1);

              marker_i=-1;
              for(ovals_i in find_ovals){
               if(BMapLib.GeoUtils.isPointInPolygon(point,find_ovals[ovals_i])){
                  marker_i++;
                  }else{
                    break;
                  }
              }
              if(marker_i>-1){
                  var longinten=intexy[marker_i][0];//长轴烈度
                  var shortinten=intexy[marker_i][1];//短轴烈度
                  if(longinten*1>=shortinten*1)
                  {
                    chuangzhou=longinten;
                  }else
                  {
                    chuangzhou=shortinten;
                  }
                  if(chuangzhou>=6 && chuangzhou<6.8){
                      var po=json.sixDegrEarthDam;
                  }else if(chuangzhou>6.8 && chuangzhou<7.8){
                      var po=json.sevenDegrEarthDam;
                  }else if(chuangzhou>7.8 && chuangzhou<8.5){
                      var po=json.eightDegrEarthDam;
                  }else if(chuangzhou>=8.5 && chuangzhou<9.2){
                      var po=json.nineDegrEarthDam;
                  }else if(chuangzhou>=9.2 && chuangzhou<=10){
                      var po=json.tenDegrEarthDam;
                  }
                  if(po=="良好"){
                    _dis0.push(point)
                    // var icon = new BMap.Icon("public/images/pipi/marker5.png", new BMap.Size(17,15),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
                  }else if(po=="轻微破坏"){
                    _dis1.push(point)
                    // var icon = new BMap.Icon("public/images/pipi/marker4.png", new BMap.Size(17,15),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
                  }else if(po=="中等破坏"){
                    _dis2.push(point)
                    // var icon = new BMap.Icon("public/images/pipi/marker3.png", new BMap.Size(17,15),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
                  }else if(po=="严重破坏"){
                    _dis3.push(point)
                    // var icon = new BMap.Icon("public/images/pipi/marker1.png", new BMap.Size(17,15),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
                  }else if(po=="毁坏"){
                    _dis4.push(point)
                    // var icon = new BMap.Icon("public/images/pipi/marker1.png", new BMap.Size(17,15),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
                  }
                  distanceValue=chuangzhou.toFixed(1);
              }else{
                // var icon = new BMap.Icon("public/images/pipi/marker.png", new BMap.Size(17,15),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
                distanceValue='不在主要烈度内';
                _dis5.push(point)
              }

              var marker = new BMap.Marker(point);
              if(po=="严重破坏"||po=="毁坏"){
                w_points.push(marker);
                warming_points.push(json);
              }
              marker.class=type; //给建筑物覆盖物添加属性以便查找
              marker.flag="marker";
              setClassPercentageOval(markerArr,distanceValue,i,type)
              // map.addOverlay(marker); //添加点图层
              //   (function(){
                   
              //        var _iw = createInfoWindowOval(markerArr,i,is,type);
                
              //     //给点图层创建信息窗口
              //     var _marker = marker;
              //     _marker.addEventListener("click",function(){//给点图层添加点击事件
              //         _marker.openInfoWindow(_iw);
              //     });
              // })();
        }
        pa.color='#00FFFF'
        pb.color='#3ea836'
        pc.color='#f86802'
        pd.color='#fb1b19'
        pe.color='#fb1b19'
        pf.color='#a1a193'

        pa.push(_dis0);
        pb.push(_dis1);
        pc.push(_dis2);
        pd.push(_dis3);
        pe.push(_dis4);
        pf.push(_dis5);
        points_sea=[]
        points_sea.push(pa)
        points_sea.push(pb)
        points_sea.push(pc)
        points_sea.push(pd)
        points_sea.push(pe)
        points_sea.push(pf)
        for(var i=0;i<sea_constore.length;i++){
          if(sea_constore[i]!=null)
            sea_constore[i].pointCollection.hide()
        }//隐藏所有海量点
        for(let i=0;i<points_sea.length;i++){
          var options = {
              size: BMAP_POINT_SIZE_NORMAL,
              shape: BMAP_POINT_SHAPE_RHOMBUS,
              color: points_sea[i]['color'],
          }
          pointCollections=new Foo();
          pointCollections.class=type;
          pointCollections.pointCollection=new BMap.PointCollection(points_sea[i][0], options);  // 初始化PointCollection、
          (function(n){
            pointCollections.pointCollection.addEventListener('click', function (e) {
              var loca = new BMap.Point( e.point.lng, e.point.lat);
			  			var data = {
			  				point : loca,
			  				type : n,
			  				value : markerArr
			  			};
                for(var j=0;j<markerArr.length;j++){
                  if(markerArr[j].baidu_X==e.point.lng&&markerArr[j].baidu_Y==e.point.lat)
                  break;
                }
                var _iw = createInfoWindowOval(markerArr,i,is,type,data);
                map.openInfoWindow(_iw,loca);
                //给点图层创建信息窗口
                //var _marker = marker_sea[i];
                // e.addEventListener("click",function(){//给点图层添加点击事件
                //     this.openInfoWindow(_iw);
                //     //刷新显示图片
                //     for(var j=0;j<$("img[name='buildingPictures']").length;j++){
                //       $("img[name='buildingPictures']")[j].src = $("img[name='buildingPictures']")[j].src+'?'+Math.random()*10;
                //     } 
                // }); 
            });
        })(i);
          _constore.push(pointCollections)
          sea_constore.push(pointCollections)
      }
      for(var i=0;i<_constore.length;i++){
        map.addOverlay(_constore[i].pointCollection);//在地图上添加海量点  
      }
      for(var i=0;i<sea_constore.length;i++){
        if(sea_constore[i]!=null)
        sea_constore[i].pointCollection.show()
      }
          distanceValue=0;//赋值为零是清除赋值
          allOverlay = map.getOverlays();

    }







    function setClassPercentageOval(markerArr,distanceValue,i,value){
            var info;//建筑破坏情况
            if (distanceValue>6&&distanceValue<6.8) {
              info=markerArr[i].sixDegrEarthDam;
            }else if (distanceValue>6.8&&distanceValue<7.8) {
              info=markerArr[i].sevenDegrEarthDam;
            }else if (distanceValue>7.8&&distanceValue<8.5) {
              info=markerArr[i].eightDegrEarthDam;
            }else if (distanceValue>8.5&&distanceValue<9.2) {
              info=markerArr[i].nineDegrEarthDam;    
            }else if (distanceValue>9.2&&distanceValue<10) {
              info=markerArr[i].tenDegrEarthDam; 
            }else{
              info="房屋没有损坏——安全";    
            }
            if (info=="良好") {
                UntouchNum[value]++;
                }
            else if (info=="轻微破坏") {
              SlightNum[value]++;
            }
            else if (info=="中等破坏") {
              ModerateNum[value]++;
            }
            else if (info=="严重破坏") {
              SeriusNum[value]++;
            }
            else if (info=="毁坏") {
              CollaPNum[value]++;
            }
    }
    function setDistanceValue(markerArr,i){
      var json = markerArr[i];    
      var p0 = json.baidu_X;//经度
      var p1 = json.baidu_Y;//纬度
      var point = new BMap.Point(p0,p1);

      marker_i=-1;
      for(ovals_i in find_ovals){
       if(BMapLib.GeoUtils.isPointInPolygon(point,find_ovals[ovals_i])){
          marker_i++;
          }else{
            break;
          }
      }
      if(marker_i>-1){
          var longinten=intexy[marker_i][0];//长轴烈度
          var shortinten=intexy[marker_i][1];//短轴烈度
          if(longinten*1>=shortinten*1)
          {
            chuangzhou=longinten;
          }else
          {
            chuangzhou=shortinten;
          }
          distanceValue=chuangzhou.toFixed(1);
        }else{
          distanceValue="不在主要烈度内"
        }
        return distanceValue;
    }
         //椭圆创建InfoWindow 添加建筑物pipi
    function createInfoWindowOval(markerArr,i,is,value,data){
        var lat = data.point.lat;
        var lng = data.point.lng;
        var p_len = markerArr.length;
        for (var i = 0; i < p_len ; i++){
          var p = markerArr[i];
          if(lat == p.baidu_Y || lng == p.baidu_X)
          {
            break;
          }
        }
       // var json = markerArr[i];
      distanceValue=setDistanceValue(markerArr,i)
       var info;//建筑破坏情况
       var imagePath;//点图片的路径
       if (distanceValue>6&&distanceValue<6.8) {
        info=markerArr[i].sixDegrEarthDam;
      
         sixIntensity++;
       }else if (distanceValue>6.8&&distanceValue<7.8) {
        info=markerArr[i].sevenDegrEarthDam;
         
         sevenIntensity++;
       }else if (distanceValue>7.8&&distanceValue<8.5) {
         info=markerArr[i].eightDegrEarthDam;
     
         eightIntensity++;
     }else if (distanceValue>8.5&&distanceValue<9.2) {
         nineIntensity++;
         //alert(eightIntensity);
         info=markerArr[i].nineDegrEarthDam;
        
     }else if (distanceValue>9.2&&distanceValue<10) {
          tenIntensity++;
          //alert(tenIntensity);
         info=markerArr[i].tenDegrEarthDam;
       
     }else{
       info="房屋没有损坏——安全"; 
      
     }
     if (info=="良好") {
        var ranNum=parseInt(Math.random()*(untouchedIMG.length) ); //生成0——n的随机数整数
        imagePath=untouchedIMG[ranNum];//良好
        UntouchNum[value]++;
        //imagePath="public/images/situationPicture/untouched_0"+ranNum+".jpg";
        }
          else if (info=="轻微破坏") {
            var ranNum=parseInt(Math.random()*(slightDamageIMG.length) ); //生成0——n的随机数整数
            imagePath=slightDamageIMG[ranNum];//轻微破坏
            SlightNum[value]++;
            //imagePath="public/images/situationPicture/slightDamage_0"+ranNum+".jpg";
          }
          else if (info=="中等破坏") {
            var ranNum=parseInt(Math.random()*(moderateDamageIMG.length) ); //生成0——n的随机数整数
            imagePath=moderateDamageIMG[ranNum];//中等破坏
            ModerateNum[value]++;
            //imagePath="public/images/situationPicture/moderateDamage_0"+ranNum+".jpg";
          }
          else if (info=="严重破坏") {
            var ranNum=parseInt(Math.random()*(seriousDamageIMG.length) ); //生成0——n的随机数整数
            imagePath=seriousDamageIMG[ranNum];//严重破坏
            SeriusNum[value]++;
            //imagePath="public/images/situationPicture/seriousDamage_0"+ranNum+".jpg";
          }
          else if (info=="毁坏") {
            var ranNum=parseInt(Math.random()*(collapsedIMG.length) ); //生成0——n的随机数整数
            imagePath=collapsedIMG[ranNum];//毁坏
            CollaPNum[value]++;
            //imagePath="public/images/situationPicture/collapsed_0"+ranNum+".jpg";
          }
          else {
            var ranNum=parseInt(Math.random()*(untouchedIMG.length) ); //生成0——n的随机数整数
            imagePath=untouchedIMG[ranNum];//良好
            //imagePath="public/images/situationPicture/untouched_0"+ranNum+".jpg";
          }


             var bulidInfo=markerArr[i].ToOrHuOrviOrCo+no+'号';//建筑物名字或者楼号
         
         
      //震前表单  
      var sContent='<table class="layui-table" lay-even="" lay-skin="row"><colgroup><col width="150"><col width="150"></colgroup><thead><tr><th colspan=2>建筑属性<a style="margin-left: 10px;color:rgb(61,109,204);font-size:7px;" onclick="chartInfo('+i+')">详情>></a></th></tr></thead><tbody><tr><td>名称：'+markerArr[i].buildingName+'</td><td rowspan=3><img src='+imagePath+' width="139" height="150"></td></tr><tr><td>类型：'+markerArr[i].propertyType+'</td></tr><tr><td>抗震：'+markerArr[i].earthquakeFortification+'度</td></tr></tbody></table>';     //震后表单 
      var sContentTwo='<table class="layui-table" lay-even="" lay-skin="row"><colgroup><col width="150"><col width="150"></colgroup><thead><tr><th colspan=2>建筑属性<a style="margin-left: 10px;color:rgb(61,109,204);font-size:7px;" onclick="chartInfo('+i+')">详情</a></th></tr></thead><tbody><tr><td>名称：'+markerArr[i].buildingName+'</td><td rowspan=3><img id='+markerArr[i].buildingNumber+' name="buildingPictures" src='+(imagePath+'?'+Math.floor(Math.random()*9))+' width="139" height="150" title="点击图片可实现图片更新!" onclick="addpicture()"><input name="simpleImage" type="file" id="uploadPicture" class="btn btn-info" onchange="javascript:uploadPicture('+i+')" style="display:none" /></td></tr><tr><td>类型：'+markerArr[i].propertyType+'</td></tr><tr><td>'+distanceValue+'度'+info+'</td></tr></tbody></table>';
   //精确查询表单震后
      var sContentThree='<table class="layui-table" lay-even="" lay-skin="row"><colgroup><col width="150"><col width="150"></colgroup><thead><tr><th colspan=2>建筑属性<a style="margin-left: 10px;color:rgb(61,109,204);font-size:7px;" onclick="chartInfo('+i+')">详情>></a></th></tr></thead><tbody><tr><td>名称：'+bulidInfo+'</td><td rowspan=3><img src='+imagePath+' width="139" height="150"></td></tr><tr><td>类型：'+markerArr[i].propertyType+'</td></tr><tr><td>'+distanceValue+'度'+info+'</td></tr></tbody></table>';
    //精确查询表单震前
      var sContentFour='<table class="layui-table" lay-even="" lay-skin="row"><colgroup><col width="150"><col width="150"></colgroup><thead><tr><th colspan=2>建筑属性<a style="margin-left: 10px;color:rgb(61,109,204);font-size:7px;" onclick="chartInfo('+i+')">详情>></a></th></tr></thead><tbody><tr><td>名称：'+bulidInfo+'</td><td rowspan=3><img src='+imagePath+' width="139" height="150"></td></tr><tr><td>类型：'+markerArr[i].propertyType+'</td></tr><tr><td>抗震：'+markerArr[i].earthquakeFortification+'度</td></tr></tbody></table>';     //震后表单 

       

        if(is=="3"){
            //精确查询
            if (distanceValue<=4) {//震前查询
                    var iw = new BMap.InfoWindow(sContentFour);
            }else{//震后查询
                    var iw = new BMap.InfoWindow(sContentThree);
            }
         
           map.centerAndZoom(new BMap.Point(124.81173189754,45.1794860515878), 13);   // 初始化地图,设置中心点坐标和地图级别
        }else if(distanceValue==0){//震前显示
           
            // var iw = new BMap.InfoWindow("<b class='iw_poi_title' >" +markerArr[i].buildingName+ "</br><img style='float:right;margin:4px' src='"+imagePath+"' width='139' height='104'>"+"</b><div style='margin:0;line-height:1.5;font-size:13px;' class='iw_poi_content'></br>"+info+"</div><button onclick='chartInfo("+i+")'>详细</button>");
            var iw = new BMap.InfoWindow(sContent);
        }else{//震后
           var iw = new BMap.InfoWindow(sContentTwo);
          // map.centerAndZoom(new BMap.Point(124.81173189754,45.1794860515878), 13);   // 初始化地图,设置中心点坐标和地图级别
        }
        return iw;
    }

    function getClient(){

      var url= "http://wthrcdn.etouch.cn/weather_mini?citykey=101010100";
     $.ajax({  
              type:"GET",   //方法  
              url: url,      //文件路径  
              dataType:"text",//用的是什么字符，json字符在js中相当有优势  
              async: false,//是否同步或者异步  
              success:function(data){//查错  
                var linePoint = eval("("+data+")");
          },  
            error: function (data) {  
              //alert(msg);
              //document.write(msg); 
              layer.alert("ajax有错！",{icon:5});  
          }  
        }); 

       }
         //这里是精确查询弹出框的布局
            

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
                  }
                },  
                error: function (data) {     
                        layer.alert(data,{icon:0});
              }  
          });
 
      }
      //-----------精确查询将建筑物定位-----------------
      function exact_addMarkerown(is,markerArr,type){
        var intensity=intensity1//获取震级
        untouchedIMG=getStationImage('untouched');
        slightDamageIMG=getStationImage('slightDamage');
        moderateDamageIMG=getStationImage('moderateDamage');
        seriousDamageIMG=getStationImage('seriousDamage');
        collapsedIMG=getStationImage('collapsed');

        //读取建筑物图片
        var pictureList=[];
        $.ajax({
              url: "index.php/Data/readPicture/",
              type: "POST",
              async:false,//同步
              success: function(data) {
                if(data){
                   pictureList = data.split(",");
                }
              },
              error:function(e){

              }
        });
        for(var i=0;i<markerArr.length;i++){
              var json = markerArr[i];
            var p0 = json.baidu_X;//经度
            var p1 = json.baidu_Y;//纬度
            var point = new BMap.Point(p0,p1);
            map.centerAndZoom(point,16);//定位数据点
            marker_i=-1;
            for(ovals_i in find_ovals){
              if(BMapLib.GeoUtils.isPointInCircle(point,find_ovals[ovals_i])){
                  marker_i++;
                }else{
                  break;
                }
              }
              if(marker_i>-1){
                  if(marker_i==0){
                      var po=json.sixDegrEarthDam;
                  }else if(marker_i==1){
                      var po=json.sevenDegrEarthDam;
                  }else if(marker_i==2){
                      var po=json.eightDegrEarthDam;
                  }else if(marker_i==3){
                      var po=json.nineDegrEarthDam;
                  }else if(marker_i==4){
                      var po=json.tenDegrEarthDam;
                  }
                  if(po=="良好"){
                    var icon = new BMap.Icon("public/images/pipi/marker5.png", new BMap.Size(17,15),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
                  }else if(po=="轻微破坏"){
                    var icon = new BMap.Icon("public/images/pipi/marker4.png", new BMap.Size(17,15),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
                  }else if(po=="中等破坏"){
                    var icon = new BMap.Icon("public/images/pipi/marker3.png", new BMap.Size(17,15),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
                  }else if(po=="严重破坏"){
                    var icon = new BMap.Icon("public/images/pipi/marker1.png", new BMap.Size(17,15),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
                  }else if(po=="毁坏"){
                    var icon = new BMap.Icon("public/images/pipi/marker1.png", new BMap.Size(17,15),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
                  }
                  distanceValue=marker_i+6;
              }else{
                var icon = new BMap.Icon("public/images/pipi/marker.png", new BMap.Size(17,15),{imageOffset: new BMap.Size(0,0),infoWindowOffset:new BMap.Size(0,0),offset:new BMap.Size(0,0)});
                distanceValue='不在主要烈度内';
              }
            var marker = new BMap.Marker(point,{icon:icon});
            if(po=="严重破坏"||po=="毁坏"){
                w_points.push(marker);
                warming_points.push(json);
              }

            po="过渡";
            marker.class=type; //给建筑物覆盖物添加属性以便查找
            marker.flag="marker";
            map.addOverlay(marker); //添加点图层
              (function(){
                 
                   var _iw = createInfoWindow(markerArr,i,is,pictureList,type);
              
                //给点图层创建信息窗口
                var _marker = marker;
                _marker.addEventListener("click",function(){//给点图层添加点击事件
                    this.openInfoWindow(_iw);
                    //刷新显示图片
                    for(var j=0;j<$("img[name='buildingPictures']").length;j++){
                      $("img[name='buildingPictures']")[j].src = $("img[name='buildingPictures']")[j].src+'?'+Math.random()*10;
                    } 
                });
            })();
        }     
        for(var i=0; i<markerpoint.length; i++){
            //加点
            var point = new BMap.Point(markerpoint[i].lng,markerpoint[i].lat);
            //字面量
            var opts = {
             position : point,    // 指定文本标注所在的地理位置
             offset   : new BMap.Size(10, -40)    //设置文本偏移量
            }
            //实例化label
            var label = new BMap.Label(i+1, opts);  // 创建文本标注对象
            //改变label样式
            label.setStyle({
            color : "#000088",
            backgroundColor:'transparent',//文本背景色
            borderColor:'transparent',//文本框边框色
            fontSize : "30px",
            height : "30px",
            lineHeight : "30px",
            fontFamily:"微软雅黑",
            fontWeight:'bolder'//加粗
            });
            labels.push(label);
        }
        map.addEventListener("zoomend",function(){
          if(map.getZoom()>=13){
            for(var i=0;i<labels.length;i++){
              map.addOverlay(labels[i]);
            }
          }else{
            for(var i=0;i<labels.length;i++){
              map.removeOverlay(labels[i]);
            }
          }

        });
        allOverlay = map.getOverlays();
        $("#legend").css("display","");
      }

