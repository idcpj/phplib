/**
 * Created by cc on 2017/5/6.
 */

(function($) {
    function PreLoad (imgs, opts) {
        this.imgs = (typeof imgs === 'string') ? [imgs] : imgs;
        this.opts = $.extend({}, PreLoad.DEFAULTS, opts);
        if (this.opts.order === 'ordered') {
            this._ordered(); // 有序加载
        } else {
            this._unordered(); // 无序加载
        }
    }
    PreLoad.DEFAULTS = {
        order: 'unordered', //默认进行无序预加载
        each: null, // 单个图片加载完成后执行的方法
        all: null // 所有图片加载完成后执行的方法
    };

    //有序加载
    PreLoad.prototype._ordered = function () { // 有序加载
        var imgs = this.imgs, len = imgs.length, count = 0, opts = this.opts;
        load();
        function load () {
            var img = new Image();
            $(img).on('load error', function() {

                opts.each && opts.each(count);

                if (count >= len) {
                    // 所有图片加载完毕
                    opts.all && opts.all();
                } else {
                    load();
                }
                count++;
            });
            img.src = imgs[count];
        }
    };
    //无序加载
    PreLoad.prototype._unordered = function() { // 无序加载
        var imgs = this.imgs, len = imgs.length, count = 0, opts = this.opts;
        imgs.forEach(function(elem) {
            var img = new Image();
            $(img).on('load error', function(){
                opts.each && opts.each(count);
                if (count >= len -1) {
                    opts.all && opts.all();
                }
                count++;
            });
            img.src = elem;
        });
    };
    $.extend({
        preload: function(imgs, opts) {
            new PreLoad(imgs, opts);
        }
    });
})(jQuery);





/*
(function($){

    //构造函数
    function PreLoad(imgs,options) {
        this.imgs=(typeof imgs ==='string')?[imgs]:imgs;
        this.options=$.extend({},PreLoad.DEFAULTS,options);//后后两个对象融合为新的对象
        this._unordered();
    }

    PreLoad.DEFAULTS={
        each :null, //每张图片加载完毕后执行
        all:null  //所有图片加载完毕后执行
    }
    PreLoad.prototype._unordered = function() { //无序加载
        var imgs=this.imgs,
            opt=this.options,
            count=0,
            len=imgs.length;

        $.each(imgs,function(i,src){
            if (typeof src !='string') return;
            var imgObj=new Image();

            $(imgObj).on('load error',function () {
                opt.each && opt.each(count);

                if (count>=len-1){
                    $('.loading').hide();
                    document.title='1/'+len;
                }
                count++;
            })
            imgObj.src=src;
        });
    };
    //把此对象变为jquery插件
    $.extend({
        preload:function (imgs,option){
            new PreLoad(imgs,option);
        }
    })

})(jQuery);
*/

