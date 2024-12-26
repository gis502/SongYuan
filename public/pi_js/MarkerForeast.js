/**
 * @fileoverview MarkerClusterer标记聚合器用来解决加载大量点要素到地图上产生覆盖现象的问题，并提高性能。
 * 主入口类是<a href="symbols/BMapLib.MarkerClusterer.html">MarkerClusterer</a>，
 * 基于Baidu Map API 1.2。
 *
 * @author Baidu Map Api Group 
 * @version 1.2
 */
 

/** 
 * @namespace BMap的所有library类均放在BMapLib命名空间下
 */
var BMapLib = window.BMapLib = BMapLib || {};
(function(){


    /**
     * 判断给定的对象是否为数组
     * @param {Object} source 要测试的对象
     *
     * @return {Boolean} 如果是数组返回true，否则返回false
     */
    var isArray = function (source) {
        return '[object Array]' === Object.prototype.toString.call(source);
    };


    /**
     * 返回item在source中的索引位置
     * @param {Object} item 要测试的对象
     * @param {Array} source 数组
     *
     * @return {Number} 如果在数组内，返回索引，否则返回-1
     */
    var indexOf = function(item, source){
        var index = -1;
        if(isArray(source)){
            if (source.indexOf) {
                index = source.indexOf(item);
            } else {
                for (var i = 0, m; m = source[i]; i++) {
                    if (m === item) {
                        index = i;
                        break;
                    }
                }
            }
        }        
        return index;
    };

    
    var MarkerClusterer =  
        /**
         * MarkerClusterer(改)
         * @class 用来解决加载大量点要素到地图上产生覆盖现象的问题，并提高性能
         * @constructor
         * @param {Map} map 地图的一个实例。
         * @param {Json Object} options 可选参数，可选项包括：<br />
         *    markers {Array<Marker>} 要聚合的标记数组<br />
         *    girdSize {Number} 聚合计算时网格的像素大小，默认60<br />
         *    maxZoom {Number} 最大的聚合级别，大于该级别就不进行相应的聚合<br />
         *    minZoom {Number} 最小的聚合级别，小于该级别就不进行相应的聚合<br />
         *    minClusterSize {Number} 最小的聚合数量，小于该数量的不能成为一个聚合，默认为2<br />
         *    isAverangeCenter {Boolean} 聚合点的落脚位置是否是所有聚合在内点的平均值，默认为否，落脚在聚合内的第一个点<br />
         *    styles {Array<IconStyle>} 自定义聚合后的图标风格，请参考TextIconOverlay类<br />
         */
        BMapLib.MarkerClusterer = function(map, options){
            if (!map){
                return;
            }
            this._map = map;
            this._markers = [];
            this._clusters = [];
            
            var opts = options || {};
            this._gridSize = opts["gridSize"] || 10;
            this._maxZoom = opts["maxZoom"] || 11;
            this._minZoom = opts["minZoom"] || 10;
            this._minClusterSize = opts["minClusterSize"] || 1;           
            this._isAverageCenter = true;
            if (opts['isAverageCenter'] != undefined) {
                this._isAverageCenter = opts['isAverageCenter'];
            }    
            this._styles = opts["styles"] || [];
        
            var that = this; 
            var mkrs = opts["markers"];
            isArray(mkrs) && this.addMarkers(mkrs);
        };


    /**
     * 添加要聚合的标记数组。
     * @param {Array<Marker>} markers 要聚合的标记数组
     *
     * @return 无返回值。
     */
    MarkerClusterer.prototype.addMarkers = function(markers){
        for(var i = 0, len = markers.length; i <len ; i++){
            this._pushMarkerTo(markers[i]);
        }
        this._createClusters();   
    };

    /**
     * 把一个标记添加到要聚合的标记数组中
     * @param {BMap.Marker} marker 要添加的标记
     *
     * @return 无返回值。
     */
    MarkerClusterer.prototype._pushMarkerTo = function(marker){
        var index = indexOf(marker, this._markers);
        if(index === -1){
            marker.isInCluster = false;
            this._markers.push(marker);//Marker拖放后enableDragging不做变化，忽略
        }
    };


    /**
     * 根据所给定的标记，创建聚合点
     * @return 无返回值
     */
    MarkerClusterer.prototype._createClusters = function(){
        for(var i = 0, marker; marker = this._markers[i]; i++){
            if(!marker.isInCluster ){ 
                this._addToClosestCluster(marker);
            }
        }   
    };


    /**
     * 根据标记的位置，把它添加到最近的聚合中
     * @param {BMap.Marker} marker 要进行聚合的单个标记
     *
     * @return 无返回值。
     */
    MarkerClusterer.prototype._addToClosestCluster = function (marker){
        var distance = 400000;
        var clusterToAddTo = null;
        var position = marker.getPosition();
        for(var i = 0, cluster; cluster = this._clusters[i]; i++){
            var center = cluster.getCenter();
            if(center){
                var d = this._map.getDistance(center, marker.getPosition());
                if(d < distance){
                    distance = d;
                    clusterToAddTo = cluster;
                }
            }
        }
    
        if (clusterToAddTo && distance < 1000){
            clusterToAddTo.addMarker(marker);
        } else {
            var cluster = new Cluster(this);
            cluster.addMarker(marker);            
            this._clusters.push(cluster);
        }    
    };


    /**
     * 返回标记点的经纬度二维数组
     * @return 无返回值
     */
    MarkerClusterer.prototype.tobackpoint = function() {
        var clusters=this._clusters;
        var clusterscenter=[];
        for(var c_i=0;c_i<clusters.length;c_i++){
            var lng=clusters[c_i]._center.lng;
            var lat=clusters[c_i]._center.lat;
            var markeringroup=[];
            for(var m_i=0;m_i<clusters[c_i]._markers.length;m_i++){
                
                var _lat=clusters[c_i]._markers[m_i].point.lat;
                var _lng=clusters[c_i]._markers[m_i].point.lng;
                var _marker={
                    lng : _lng,
                    lat : _lat
                };
                markeringroup.push(_marker);
            }
            var clmarker={
                lng : lng,
                lat : lat,
                marher : markeringroup
            }
            clusterscenter.push(clmarker);
        }
        return clusterscenter;

    };


    /**
     * 获取聚合的Map实例。
     * @return {Map} Map的示例。
     */
    MarkerClusterer.prototype.getMap = function() {
      return this._map;
    };


    /**
     * 获取单个聚合的落脚点是否是聚合内所有标记的平均中心。
     * @return {Boolean} true或false。
     */
    MarkerClusterer.prototype.isAverageCenter = function() {
        return this._isAverageCenter;
    };
    /**
      * 清除上一次的聚合的结果
      * @return 无返回值。
      */
     MarkerClusterer.prototype._clearLastClusters = function(){
        for(var i = 0, cluster; cluster = this._clusters[i]; i++){            
            cluster.remove();
        }
        this._clusters = [];//置空Cluster数组
        this._removeMarkersFromCluster();//把Marker的cluster标记设为false
    };
     /**
      * 清除某个聚合中的所有标记
      * @return 无返回值
      */
     MarkerClusterer.prototype._removeMarkersFromCluster = function(){
         for(var i = 0, marker; marker = this._markers[i]; i++){
             marker.isInCluster = false;
         }
     };
     /**
      * 删除该聚合。
      * @return 无返回值。
      */
     Cluster.prototype.remove = function(){
        for (var i = 0, m; m = this._markers[i]; i++) {
                this._markers[i].getMap() && this._map.removeOverlay(this._markers[i]);
        }//清除散的标记点
        this._map.removeOverlay(this._clusterMarker);
        this._markers.length = 0;
        delete this._markers;
    }


    /**
     * 删除一组标记
     * @param {Array<BMap.Marker>} markers 需要被删除的marker数组
     *
     * @return {Boolean} 删除成功返回true，否则返回false
     */
    MarkerClusterer.prototype.removeMarkers = function(markers) {
        var success = false;
        for (var i = 0; i < markers.length; i++) {
            var r = this._removeMarker(markers[i]);
            success = success || r; 
        }

        if (success) {
            this._clearLastClusters();
            this._createClusters();
        }
        return success;
    };

    /**
      * 从地图上彻底清除所有的标记
      * @return 无返回值
      */
     MarkerClusterer.prototype.clearMarkers = function() {
        this._clearLastClusters();
        this._removeMarkersFromMap();
        this._markers = [];
    };
     /**
      * 把所有的标记从地图上清除
      * @return 无返回值
      */
     MarkerClusterer.prototype._removeMarkersFromMap = function(){
        for(var i = 0, marker; marker = this._markers[i]; i++){
            marker.isInCluster = false;
            this._map.removeOverlay(marker);       
        }
    };


     /**
     * 删除单个标记
     * @param {BMap.Marker} marker 需要被删除的marker
     *
     * @return {Boolean} 删除成功返回true，否则返回false
     */
    MarkerClusterer.prototype._removeMarker = function(marker) {
        var index = indexOf(marker, this._markers);
        if (index === -1) {
            return false;
        }
        this._map.removeOverlay(marker);
        this._markers.splice(index, 1);
        return true;
    };



    /**
     * @ignore
     * Cluster
     * @class 表示一个聚合对象，该聚合，包含有N个标记，这N个标记组成的范围，并有予以显示在Map上的TextIconOverlay等。
     * @constructor
     * @param {MarkerClusterer} markerClusterer 一个标记聚合器示例。
     */
    function Cluster(markerClusterer){
        this._markerClusterer = markerClusterer;
        this._map = markerClusterer.getMap();
        // this._minClusterSize = markerClusterer.getMinClusterSize();
        this._isAverageCenter = markerClusterer.isAverageCenter();
        this._center = null;//落脚位置
        this._markers = [];//这个Cluster中所包含的markers
        this._gridBounds = null;//以中心点为准，向四边扩大gridSize个像素的范围，也即网格范围
		this._isReal = false; //真的是个聚合
    
    }



    /**
     * 向该聚合添加一个标记。
     * @param {Marker} marker 要添加的标记。
     * @return 无返回值。
     */
    Cluster.prototype.addMarker = function(marker){
        if(this.isMarkerInCluster(marker)){
            return false;
        }//也可用marker.isInCluster判断,外面判断OK，这里基本不会命中
    
        if (!this._center){
            this._center = marker.getPosition();
        } else {
            if(this._isAverageCenter){
                var l = this._markers.length + 1;
                var lat = (this._center.lat * (l - 1) + marker.getPosition().lat) / l;
                var lng = (this._center.lng * (l - 1) + marker.getPosition().lng) / l;
                this._center = new BMap.Point(lng, lat);
            }//计算新的Center
        }
    
        marker.isInCluster = true;
        this._markers.push(marker);
    
        this._isReal = true;
        return true;
    };


    /**
     * 判断一个标记是否在该聚合中。
     * @param {Marker} marker 要判断的标记。
     * @return {Boolean} true或false。
     */
    Cluster.prototype.isMarkerInCluster= function(marker){
        if (this._markers.indexOf) {
            return this._markers.indexOf(marker) != -1;
        } else {
            for (var i = 0, m; m = this._markers[i]; i++) {
                if (m === marker) {
                    return true;
                }
            }
        }
        return false;
    };


    /**
     * 获取该聚合的落脚点。
     * @return {BMap.Point} 该聚合的落脚点。
     */
    Cluster.prototype.getCenter = function() {
        return this._center;
    };
   


})();

 
