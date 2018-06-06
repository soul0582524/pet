    /**
    * 获得下级分类
    */
    function getNextClass(){
    
        var pid = $('#classi').val();
        if (pid != 0) {
            $.ajax({
                url: getNextClassUrl,
                type: 'POST',
                dataType: 'json',
                data: {'pid':pid},
                success:function(res){
                  
                    var content = '';
                    if (res.status == 1) {
                        content = "<option value = '0'>请选择二级分类</option>";
                        for (var i = 0; i < res.data.length; i++) {
                            
                            content += "<option value = '"+res.data[i].id+"'>"+res.data[i].name+"</option>";
                        }
                    }else if (res.status == 2) {
                        content  = "<option value = '0'>暂无下级分类</option>";
                    }
                    $('#class2').html(content);
                }
            })
        }
    }