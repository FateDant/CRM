$(function(){
	/*调用选择项*/
	new Tab({
		renderTo:"infoTab",
		dataSource:[{
			key:"1",
			value:"第一步:填写信息"
		},{
			key:"2",
			value:"第二步:验证信息"
		},{
			key:"3",
			value:"第三步:重设密码"
		}],
		moveSize:33.3,
		onClick:function(li){
			//给出对应内容
			$(li).parent().siblings().children().addClass("hidden");
			$(".contentItem:eq("+$(li).index()+")").removeClass("hidden");
		}
	});
});