window.onload = function(){
        //获取tabs下的所有div
        var tabs = document.getElementsByClassName("tab")[0];
        var tabs_divs = tabs.getElementsByTagName("div");
        //获取lists下的所有li
        var tabs_ul = document.getElementsByClassName("content-wrap")[0];
        var tabs_lis = tabs_ul.getElementsByClassName("content");  
       
            //给元素添加className
        function addClass(elem,value){
                if(!elem.className){
                    elem.className = value; //如果元素没有class，直接加
                }else{
                    var newClassName = elem.className;//如果元素已有class，追加
                    newClassName +=" ";
                    newClassName +=value;
                    elem.className = newClassName;  
                }
        }
        //给元素删除className
        function deleteClass(elem,value){
                var newClassName = elem.className;
                if(newClassName.indexOf(value)){//查找元素是否有需要删除的class
                    elem.className = newClassName.replace(value," ");//如果有，则替换掉
                }
        }


        for(var i =0,len = tabs_divs.length; i<len;i++){
            tabs_divs[i].index = i;
            tabs_divs[i].onclick = function(){
                for(var j = 0;j<len;j++){
                    deleteClass(tabs_lis[j],"c-active");
                    deleteClass(tabs_divs[j],"tab-active")
                }
                addClass(tabs_divs[this.index],"tab-active");
                addClass(tabs_lis[this.index],"c-active")
            }
        }

    } 