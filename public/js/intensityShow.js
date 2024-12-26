var length1=new Array();//储存长轴
var find_ovals=new Array();//储存椭圆
var intexy=new Array();




//根据烈度返回距离
function drawOval(startX,startY){
    $("[class='input-position']").removeAttr("checked");//取消全选
    var longAxis  = 2.033+2.010*M-(0.923+0.151*M)*Math.log(R+27.035);//长轴的烈度值
    var shortAxis = 0.064+1.949*M-(0.433+0.169*M)*Math.log(R+13.073);//短轴的烈度值
    var point = new BMap.Point(startX,startY);
    var longintenArray =new Array();//长轴烈度
    var shortintenArray =new Array();//短轴烈度
    var longAxisArray = new Array();//长轴长
    var shortAxisArray = new Array();//短轴长
    for(var i = 6;i <= Math.floor(longAxis); i++){//计算烈度衰减圈的每一圈距离
        longintenArray.push(i);//长轴烈度
        R=Math.exp((2.033+2.010*M-i)/(0.923+0.151*M))-27.035;
        longAxisArray.push(R);
    }
    for(var j = 6;j <= Math.floor(shortAxis);j++ ){//计算烈度衰减圈的每一圈距离
        shortintenArray.push(j);//短轴烈度
        R1=Math.exp((0.064+1.949*M-j)/(0.433+0.169*M))-13.073;
        shortAxisArray.push(R1);
    }
    find_ovals.splice(0,find_ovals.length);
    intexy.splice(0,find_ovals.length);
    length1.splice(0,intexy.length);//清空
    var colorIntensity=['#82BF24','#FFDD04','#D03A00','#E10700','#9A0103','#AFFF80','#E6FFC8','FFFFCE','D4FFD3','A1E7EA'];
    var numi=0;
    for(var i=0;i<=shortAxisArray.length-1;i++){
        if(longAxisArray[i]!=null && shortAxisArray[i]!=null){
        (function (item,index){
            var xy=new Array();
            xy[0]=longintenArray[index];//将符合条件每个长轴烈度储存起来
            xy[1]=shortintenArray[index];//将符合条件每个短轴烈度储存起来
            window.intexy[item]=xy; 
            window.length1[item]=0;
            var oval_points=ovalPoint(point,longAxisArray[index],shortAxisArray[index],A); 
            var oval = new BMap.Polygon(oval_points);
            oval.setStrokeWeight(1);
            oval.setStrokeColor(colorIntensity[item]);
            oval.setFillOpacity(0.2);
            oval.setFillColor(colorIntensity[item]);
            oval.class="oval";

            var opts = {
                width : 100,     // 信息窗口宽度
                height: 50,     // 信息窗口高度
                title : "椭圆烈度圈信息" , // 信息窗口标题
                enableMessage:false//设置允许信息窗发送短息
            };
            window.find_ovals.push(oval);
            var biglenght_point=createintensityinfowindow(oval_points,point,item);
            var infowindow = new BMap.InfoWindow("长轴："+window.length1[item].toFixed(2)+"公里", opts); 
            window.find_ovals[item].addEventListener("click", function(){                            
                    map.openInfoWindow(infowindow,biglenght_point); //开启信息窗口
                }); 
                 map.addOverlay(window.find_ovals[item]);
            })(numi,i)  
           
            numi++;

            //alert(j);
        }
    }
    map.centerAndZoom(point,10);


}
//center 椭圆中心 long 长轴公里数 short 短轴公里数 angle 偏转角度
//a^2=b^2+c^2 长短轴之间的关系  F1P+F2P=2a 椭圆上任意一点到两焦点之间的距离相等
//x^2/a^2+y^2/b^2=1       x轴的椭圆标准方程
function ovalPoint(centre,long,short,angle)
{   //后台计算点坐标
    // var draw_oval_url='index.php/DrawOvals/find_points';
    // $.ajax({
    //     url: draw_oval_url,
    //     type: 'POST',
    //     dataType: 'json',
    //     data: {"centre": centre,"long": long,"short": short,"angle": angle},
    //     async: false,
    //     success:function(data){
    //         alert(data);
    //     },
    //     error:function(data){
    //         alert(data);
    //     }
    // });

    
    //angle=angle*(2*Math.PI/360);
    var Point = new Array();
    var pLng;//这个点的经度
    var pLat;//这个点的纬度
    //下面求椭圆方程
    var a = long;
    var b = short;  //单位米
    var aPoint;
    var aPointLng;
    var A;//用于存储椭圆的长轴

    if(a<b){
        var d=a;
        a=b;
        b=d;
    }
    //现在要实现在纬度上找到这个相应的点 在同一纬度下距离原点b米的经度
    // for(var i = 0.0000; i<parseFloat(180.0000)-centre.lng;i=parseFloat(i)+0.000001){
    //     var aLng = centre.lng+i;
    //     aPoint = new BMap.Point(aLng,centre.lat);
    //     if( map.getDistance(centre,aPoint).toFixed(1) == a.toFixed(1)*1000 ){//在这个纬度下寻找距离为a的点
    //         aPointLng=aLng;//找到这个点的经度
    //         console.log(i);
    //         break;
    //     }
    // }
    //------------二分查找-优化算法--------------------
    var end=parseFloat(180.0000)-centre.lng;
    var count=0;//二分查找的次数
    for(var i = 0.0000; i<end;count++){
        var mid = parseFloat((i+end)/2);
        var aLng = centre.lng + mid;
        aPoint = new BMap.Point(aLng,centre.lat);
        if(map.getDistance(centre,aPoint).toFixed(1) ==  kmtom(a)){
            aPointLng=aLng;
            break;
        }else if(map.getDistance(centre,aPoint).toFixed(1) <  kmtom(a)){
            i=mid;
        }else{
            end = mid;
        }
        console.log(count);
}
    //然后相减就得到了椭圆中的a
    A=aPointLng-centre.lng;//短轴长度 是以地理坐标系的度为单位的
   //alert("A"+A);
   //alert("aPointLng"+aPointLng);
   //alert("zuo"+centre.lng-A);
   //
    //同样方法计算短轴
    var bPoint;
    var bPointLat;
    var B;          //用于存储椭圆的短轴
    // for(var i = 0.0000; i<parseFloat(90.0000)-centre.lat;i=parseFloat(i)+0.000001){
    //     var bLat = centre.lat+i;
    //     bPoint = new BMap.Point(centre.lng,bLat);
    //     if(map.getDistance(centre,bPoint).toFixed(0) == b.toFixed(0)*1000){//在这个经度下寻找距离为b的点
    //         bPointLat = bLat;
    //         break;
    //     }
    // }
    //--------------二分查找-优化算法----------------
    var end1=parseFloat(90.0000)-centre.lat
    for(var i = 0.0000; i<end1;){
        var mid = parseFloat((i+end1)/2);
        var bLat = centre.lat+mid;
        bPoint = new BMap.Point(centre.lng,bLat);
        if(map.getDistance(centre,bPoint).toFixed(1) ==  kmtom(b)){
            bPointLat = bLat;
            break;
        }else if(map.getDistance(centre,bPoint).toFixed(1) < kmtom(b)){
            i=mid;
        }else{
            end1 = mid;
        }
    }
    B=bPointLat - centre.lat;//这里得到的是以地理坐标系中的度做单位的
    
  
    var kVar= new Array();
    for(var i = 0; i<360;i++){
        //if(i==90||i==270) 当i=90或者270时 正切值是一个极大值
        //continue;
        kVar.push( Math.tan( i*(2*Math.PI/360)) );
    }
    var assemble = new Array();
    var onePoint;
    var twoPoint;
    var threePoint;

    for(var i = 0; i<359;i++){
        //在第一第四象限找这个点
        if((i >= 0 && i <=90) || (i > 270 && i <= 359)){
            x= Math.sqrt( (Math.pow(A,2)*Math.pow(B,2)) / ( Math.pow(B,2)+( Math.pow(A,2)*Math.pow(kVar[i],2) )) );
            y= kVar[i]*x;
            var x1 = x * Math.cos(angle * Math.PI / 180) - y * Math.sin(angle * Math.PI / 180);
            var y1 = x * Math.sin(angle * Math.PI / 180) + y * Math.cos(angle * Math.PI / 180);
            onePoint = new BMap.Point(centre.lng + x1,centre.lat+y1);
            assemble.push(onePoint);
        }else if(i>=91 && i<=270){//在二三象限找这个点
            x=(-1)* Math.sqrt( (Math.pow(A,2)*Math.pow(B,2)) / ( Math.pow(B,2)+( Math.pow(A,2)*Math.pow(kVar[i],2) )) );
            y= kVar[i]*x;
            var x1 = x * Math.cos(angle * Math.PI / 180) - y * Math.sin(angle * Math.PI / 180);
            var y1 = x * Math.sin(angle * Math.PI / 180) + y * Math.cos(angle * Math.PI / 180);
            twoPoint = new BMap.Point(centre.lng + x1,centre.lat+y1);
            assemble.push(twoPoint);
        }

    }
    return assemble;
}
function createintensityinfowindow(oval_points,point,numi)
{
    var farest1;
    for(var i=0 ; i<oval_points.length;i++){
        var z1=oval_points[i].lng;
        var z2=oval_points[i].lat;
        var ovalposition= new BMap.Point(z1,z2);       
        var longAxisNum=1*map.getDistance(ovalposition,point)/1000;
        if(length1[numi]<longAxisNum){

            length1[numi]=longAxisNum;
            farest1=oval_points[i];
        }
    }
    return farest1;
}
//千米到米 取整
function kmtom(i){
    return Math.round((i*1000*10)/10);
}