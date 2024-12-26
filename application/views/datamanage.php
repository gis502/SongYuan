<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <base href="<?php  echo base_url();?>"/>
  <title>数据管理</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="public/plugins/layui/css/layui.css"  media="all">
  <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<body>  
<div style="margin-bottom: 5px;">          
 
<!-- 示例-970 -->
<!-- <ins class="adsbygoogle" style="display:inline-block;width:970px;height:90px" data-ad-client="ca-pub-6111334333458862" data-ad-slot="3820120620"></ins>
  -->
</div>
 
<!-- <div class="layui-btn-group demoTable">
  <button class="layui-btn" data-type="getCheckData">获取选中行数据</button>
  <button class="layui-btn" data-type="getCheckLength">获取选中数目</button>
  <button class="layui-btn" data-type="isAll">验证是否全选</button>
</div>
  -->
<!-- <table class="layui-table" lay-data="{width: 1380, height:632, url:'index.php/Data/dataManage', page:true,limit:15, id:'idTest'}" lay-filter="demo"> -->
<table class="layui-table" lay-data="{height: 'full-60', cellMinWidth: 80, url:'index.php/Data/dataManage', page:true,limit:30, id:'idTest'}" lay-filter="demo">
  <thead>
    <tr>
      <!-- <th lay-data="{type:'checkbox', fixed: 'left'}"></th> -->
      <th lay-data="{field:'ID', width:80, sort: true, fixed: true}">ID</th>
      <th lay-data="{field:'buildingNumber', width:115}">建筑物编号</th>
      <th lay-data="{field:'X', width:80, edit: 'text'}">经度</th>
      <th lay-data="{field:'Y', width:80, edit: 'text'}">纬度</th>
      <th lay-data="{field:'buildingName', width:115, edit: 'text'}">建筑物名称</th>
            <th lay-data="{field:'propertyType', width:115, edit: 'text'}">建筑类别</th>
            <th lay-data="{field:'city', width:80, edit: 'text'}">城市</th>
            <th lay-data="{field:'popeOrCounty', width:115, edit: 'text'}">辖区或者县</th>
            <th lay-data="{field:'streetOrTown', width:115, edit: 'text'}">街道或乡镇</th>
            <th lay-data="{field:'sixDegrEarthDam', width:80, edit: 'text'}">6度</th>
            <th lay-data="{field:'sevenDegrEarthDam', width:80, edit: 'text'}">7度</th>
            <th lay-data="{field:'eightDegrEarthDam', width:80, edit: 'text'}">8度</th>
            <th lay-data="{field:'nineDegrEarthDam', width:80, edit: 'text'}">9度</th>
            <th lay-data="{field:'tenDegrEarthDam', width:80, edit: 'text'}">10度</th>
            <th lay-data="{field:'baidu_X', width:80, edit: 'text'}">百度地图X</th>
            <th lay-data="{field:'baidu_Y', width:80, edit: 'text'}">百度地图Y</th>
            <th lay-data="{field:'nameOfHous', width:80, edit: 'text'}">户主姓名</th>
            <th lay-data="{field:'admiPosition', width:80, edit: 'text'}">行政位置</th>
            <th lay-data="{field:'height', width:80, edit: 'text'}">高度</th>
            <th lay-data="{field:'floor', width:80, edit: 'text'}">层数</th>
            <th lay-data="{field:'floorArea', width:80, edit: 'text'}">建筑面积</th>
            <th lay-data="{field:'constructionAge', width:80, edit: 'text'}">建造年代</th>
            <th lay-data="{field:'structureTypeOne', width:80, edit: 'text'}">结构类型1</th>
            <th lay-data="{field:'structureTypeTwo', width:80, edit: 'text'}">结构类型2</th>
            <th lay-data="{field:'earthquakeFortification', width:80, edit: 'text'}">抗震设防烈</th>
            <th lay-data="{field:'siteType', width:80, edit: 'text'}">场地类别</th>
            <th lay-data="{field:'foundationType', width:80, edit: 'text'}">场基类型</th>
            <th lay-data="{field:'baseType', width:80, edit: 'text'}">基础类型</th>
            <th lay-data="{field:'exteriorAndInterior', width:80, edit: 'text'}">外观及内部</th>
            <th lay-data="{field:'underDisadvantage', width:80, edit: 'text'}">底层不利因</th>
            <th lay-data="{field:'scatAndNotWhole', width:80, edit: 'text'}">散而不整</th>
            <th lay-data="{field:'britWithoutDelay', width:80, edit: 'text'}">脆而不延</th>
            <th lay-data="{field:'partAndUneven', width:80, edit: 'text'}">偏而不匀</th>
            <th lay-data="{field:'simpButNotRedu', width:80, edit: 'text'}">单而不冗</th>
            <th lay-data="{field:'remarks', width:80, edit: 'text'}">备注</th>
            <th lay-data="{field:'statusEvaluation', width:80, edit: 'text'}">鉴定意见</th>
            <th lay-data="{field:'predictOutcomes', width:80, edit: 'text'}">预测结果</th>
            <th lay-data="{field:'ToOrHuOrviOrCo', width:80, edit: 'text'}">小区或单位</th>
            <th lay-data="{field:'no', width:80, edit: 'text'}">楼号</th>
            <th lay-data="{fixed: 'right', width:178, align:'center', toolbar: '#barDemo'}">操作</th>
    </tr>
  </thead>
</table>
<button class="layui-btn" data-type="isAll" style="float:right" onclick="window.close()">关闭</button>
 
<script type="text/html" id="barDemo">
  <!-- <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="detail">查看</a> -->
  <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>
               
          
<script src="public/plugins/layui/layui.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
layui.use('table', function(){
 
  var table = layui.table;

  //监听表格复选框选择
  table.on('checkbox(demo)', function(obj){
    console.log(obj)
  });
   
  //监听工具条
  table.on('tool(demo)', function(obj){
    var data = obj.data;
    if(obj.event === 'detail'){
      layer.msg('ID：'+ data.id + ' 的查看操作');
    } else if(obj.event === 'del'){
      layer.confirm('确定删除吗？', function(index){
        obj.del();
         $.ajax({  
                type:'post',   //方法  
                url:"index.php/Data/delData",      //文件路径  
                dataType:'text',//用的是什么字符，json字符在js中相当有优势  
                data:{"buildingNumber":obj.data.buildingNumber,"propertyType":obj.data.propertyType},//data:"IntensityValue=" + params,//要传送的数据  
                async: true,//是否同步或者异步  
                success:function(data){//查错  
                    layer.msg("删除成功！");
                },  
                error:function(data){     
                    layer.alert(data,{icon:0});
                }  
          });
        layer.close(index);
      });
    } else if(obj.event === 'edit'){
       //监听单元格编辑
      table.on('edit(demo)', function(obj){
        var value = obj.value //得到修改后的值
        ,data = obj.data //得到所在行所有键值
        ,field = obj.field; //得到字段
        $.ajax({  
                type:'post',   //方法  
                url:"index.php/Data/DataUpdata",      //文件路径  
                dataType:'text',//用的是什么字符，json字符在js中相当有优势  
                data:{"buildingNumber":obj.data.buildingNumber,"propertyType":obj.data.propertyType,"field":field,"value":value},//data:"IntensityValue=" + params,//要传送的数据  
                async: true,//是否同步或者异步  
                success:function(res){//查错  
                  layer.msg('[ID: '+ data.ID +'] ' + field + ' 字段更改为：'+ value);
                },  
                error:function(data){     
                    layer.alert(data,{icon:0});
                }  
          });
      
      });
      //layer.alert('编辑行：<br>'+ JSON.stringify(data))
    }
  });
 
  var $ = layui.$, active = {
    getCheckData: function(){ //获取选中数据
      var checkStatus = table.checkStatus('idTest')
      ,data = checkStatus.data;
      layer.alert(JSON.stringify(data));
    }
    ,getCheckLength: function(){ //获取选中数目
      var checkStatus = table.checkStatus('idTest')
      ,data = checkStatus.data;
      layer.msg('选中了：'+ data.length + ' 个');
    }
    ,isAll: function(){ //验证是否全选
      var checkStatus = table.checkStatus('idTest');
      layer.msg(checkStatus.isAll ? '全选': '未全选')
    }
  };
  
  $('.demoTable .layui-btn').on('click', function(){
    var type = $(this).data('type');
    active[type] ? active[type].call(this) : '';
  });
});
</script>

</body>
</html>