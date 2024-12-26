function intensityRArray(intensity){
    var intensityR;
    if(intensity<=4 || intensity>8.5){
        alert("只支持4度以上8.5以下的烈度显示，现在的烈度为"+intensity);
        return;
    }/*else if(intensity>4 && intensity<=4.25){
     intensityR=15;
     }else if(intensity>4.25 && intensity<=4.5){
     intensityR=25;
     }else if(intensity>4.5 && intensity<=4.75){
     intensityR=40;
     }*/else if(intensity>4.75 && intensity<=5){
        intensityR=7.5;
    }else if(intensity>5 && intensity<=5.25){
        intensityR=15;
    }else if(intensity>5.25 && intensity<=5.5){
        intensityR=17;
    }else if(intensity>5.5 && intensity<=5.75){
        intensityR=20;
    }else if(intensity>5.75 && intensity<=6){
        intensityR=26;
    }else if(intensity>6 && intensity<=6.25){
        intensityR=29;
    }else if(intensity>6.25 && intensity<=6.5){
        intensityR=34;
    }else if(intensity>6.5 && intensity<=6.75){
        intensityR=40.5;
    }else if(intensity>6.75 && intensity<=7){
        intensityR=45;
    }else if(intensity>7 && intensity<=7.25){
        intensityR=52.5;
    }else if(intensity>7.25 && intensity<=7.5){
        intensityR=60;
    }else if(intensity>7.5 && intensity<=7.75){
        intensityR=70;
    }else if(intensity>7.75 && intensity<=8){
        intensityR=80;
    }else if(intensity>8 && intensity<=8.25){
        intensityR=95;
    }else if(intensity>8.25 && intensity<=8.5){
        intensityR=110;
    }
    return intensityR;
    // intensityR=[15,25,40,75,150,170,200,260,300,340,405,450,525,600,700,800,950,1100];
}
//根据烈度返回距离
function drawOval(){
    map.clearOverlays();
    var longAxis  = 2.033+2.010*M-(0.923+0.151*M)*Math.log(R+27.035);//长轴的烈度值
    var shortAxis = 0.064+1.949*M-(0.433+0.169*M)*Math.log(R+13.073);//短轴的烈度值
    var point = new BMap.Point(startX,startY);
    var longAxisArray = new Array();
    var shortAxisArray= new Array();
    for(var i = longAxis;i > 4; i = i-0.5){//计算烈度衰减圈的每一圈距离
        longAxisArray.push(intensityRArray(i));
    }
    for(var j=shortAxis;j>4;j = j-0.5 ){//计算烈度衰减圈的每一圈距离
        shortAxisArray.push(intensityRArray(j));
    }
    for(var i=0;i<longAxisArray.length;i++){
        if(longAxisArray[i]!=null &&shortAxisArray!=null){
            var oval = new BMap.Polygon(ovalPoint(point,shortAxisArray[i],longAxisArray[i],A), {
                strokeColor:"#FF7256", //原型边框颜色
                strokeWeight:2,
                strokeOpacity:0.5,
                fillColor:'#FF7256' //创建圆
            });
            map.addOverlay(oval);
        }
    }
    map.setZoom(6);
}
//center 椭圆中心 long 长轴公里数 short 短轴公里数 angle 偏转角度
//a^2=b^2+c^2 长短轴之间的关系  F1P+F2P=2a 椭圆上任意一点到两焦点之间的距离相等
//x^2/a^2+y^2/b^2=1       x轴的椭圆标准方程
function ovalPoint(centre,long,short,angle){
    var Point = new Array();
    var pLng;//这个点的经度
    var pLat;//这个点的纬度
    //下面求椭圆方程
    var a = long;
    var b = short;  //单位米
    var aPoint;
    var aPointLng;
    var A;//用于存储椭圆的长轴

    //现在要实现在纬度上找到这个相应的点 在同一纬度下距离原点b米的经度
    for(var i = 0.0000; i<parseFloat(180.0000)-centre.lng;i=parseFloat(i)+0.00001){
        var aLng = centre.lng+i;
        aPoint = new BMap.Point(aLng,centre.lat);

        if( map.getDistance(centre,aPoint).toFixed(0) == a.toFixed(0)*1000 ){//在这个纬度下寻找距离为a的点
            aPointLng=aLng;//找到这个点的经度
            break;
        }
    }
    //然后相减就得到了椭圆中的a
    A=aPointLng-centre.lng;//短轴长度 是以地理坐标系的度为单位的
    //同样方法计算短轴
    var bPoint;
    var bPointLat;
    var B;          //用于存储椭圆的短轴
    for(var i = 0.0000; i<parseFloat(90.0000)-centre.lat;i=parseFloat(i)+0.00001){
        var bLat = centre.lat+i;
        bPoint = new BMap.Point(centre.lng,bLat);
        if(map.getDistance(centre,bPoint).toFixed(0) == b.toFixed(0)*1000){//在这个经度下寻找距离为b的点
            bPointLat = bLat;
            break;
        }
    }
    B= bPointLat - centre.lat;//这里得到的是以地理坐标系中的度做单位的
    //得到C
    var C = Math.sqrt( Math.pow(A,2) - Math.pow(B,2) );
    //得到椭圆的点
    //思路 如果我以一个斜率去画一条线与椭圆相交就可以得到两个点
    //现在开始设那条线 的 K值
    var kVar= new Array();
    for(var i = 0; i<360;i++){
        kVar.push( Math.tan( i*(2*Math.PI/360)) );
    }
    //x^2/a^2+y^2/b^2=1 => x=根号下a^2*b^2/(b^2)+a^2*k^2
    var assemble = new Array();
    var onePoint;
    var twoPoint;
    var threePoint;

    for(var i = 0; i<359;i++){//在第一象限找这个点
        if(i>=0 && i<=90){
            x= Math.sqrt( (Math.pow(A,2)*Math.pow(B,2)) / ( Math.pow(B,2)+( Math.pow(A,2)*Math.pow(kVar[i],2) )) );
            y= kVar[i]*x;
            onePoint = new BMap.Point(centre.lng + x,centre.lat+y);
            assemble.push(onePoint);
        }else if(i>=91 && i<=270){//在第二三象限找这个点
            x=(-1)* Math.sqrt( (Math.pow(A,2)*Math.pow(B,2)) / ( Math.pow(B,2)+( Math.pow(A,2)*Math.pow(kVar[i],2) )) );
            y= kVar[i]*x;
            twoPoint = new BMap.Point(centre.lng + x,centre.lat+y);
            assemble.push(twoPoint);
        }else if(i>270 && i<=359){//在第四象限找这个点
            x= Math.sqrt( (Math.pow(A,2)*Math.pow(B,2)) / ( Math.pow(B,2)+( Math.pow(A,2)*Math.pow(kVar[i],2) )) );
            y= kVar[i]*x;
            threePoint = new BMap.Point(centre.lng + x,centre.lat+y);
            assemble.push(threePoint);
        }
    }
    //计算倾斜角所用的变量
    var lng;
    var lat;
    for(var i=0 ; i<assemble.length ; i++){//可用代码 向量法旋转椭圆
        lng=assemble[i].lng-centre.lng;//与原点相差的经度
        lat=assemble[i].lat-centre.lat;//与原点相差的纬度
        var x=Math.abs( lng * Math.cos(angle));
        var y=Math.abs( lng * Math.sin(angle));
        if(i>=0&&i<90) {
            assemble[i].lng = assemble[i].lng + x;
            assemble[i].lat = assemble[i].lat + y;
        }else if(i>=90&&i<180){
            assemble[i].lng=assemble[i].lng - x;
            assemble[i].lat=assemble[i].lat - y;
        }else if(i>=180&&i<270){
            assemble[i].lng=assemble[i].lng - x;
            assemble[i].lat=assemble[i].lat - y;
        }else if(i>=270&&i<359){
            assemble[i].lng=assemble[i].lng + x;
            assemble[i].lat=assemble[i].lat + y;
        }
    }
    return assemble;
}