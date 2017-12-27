/**
 * Created by yappy on 17-12-27.
 */

function saveFormData(postUrl, formId, locationUrl){
    $.ajax({
        type:"post",
        data: $(formId).serialize(),
        url:postUrl,
        error:function(){
            layer.closeAll('loading');
            layer.alert('您的网络不给力，请稍后再试。', { icon: 2 });
            return false;
        },
        success:function(data){
            if(data.success){
                layer.msg(data.message, {icon: 1});
                searchLastData(locationUrl);
                layer.closeAll();

            }else{
                layer.msg(data.message, {icon: 5});
            }
        }
    });
}
//删除视频数据
function deleteFormData(id,ajaxUrl,searchUrl){
    layer.confirm('确定要删除该数据？', {
        btn: ['确定','取消'] //按钮
    }, function(){
        $.ajax({
            type: "POST",
            url: ajaxUrl,
            data: {'id': id},
            error: function (request) {
                layer.alert('您的网络不给力，请稍后再试。')
                return false;
            },
            success: function (data) {
                if (data.success) {
                    layer.msg(data.message, {icon: 1});
                    searchLastData(searchUrl);
                } else {
                    layer.msg(data.message, {icon: 5});
                }
            }
        });
    });
}
/**
 * @name 视频搜索
 * @param url
 */
function searchLastData(url)
{
    var search = $('#search').val();
    var res = ajaxget(url + '&search=' + encodeURIComponent(search));
    $('#list_content').html(res);
}

/*编辑方式*/
function edit(url, width, height, title) {
    $.ajax({
        url: url,
        type: 'GET',
        beforeSend: function() {
            layer.load(0, { shade: false });
        },
        error: function(request) {
            layer.closeAll('loading');
            layer.alert('您的网络不给力，请稍后再试。', { icon: 2 });
            return false;
        },
        success: function(data) {
            layer.closeAll('loading');
            layer.open({
                type: 1,
                title: title,
                shadeClose: true,
                content: data,
                area: [width, height]
            })
        }
    })

}