$(function() {
	var chart = Highcharts
			.chart(
					'schoolRank',
					{
						chart : {
							type : 'bar'
						},
						title : {
							text : '直尚教育校区排名(已报名)'
						},
						subtitle : {
							text : ''
						},
						xAxis : {
							categories : [ '南京校区', '北京校区', '长沙校区' ],
							title : {
								text : null
							},
							style : {
								fontSize : 16
							}
						},
						yAxis : {
							min : 0,
							title : {
								text : '招生人数',
								align : 'high'
							},
							labels : {
								overflow : 'justify'
							}
						},
						tooltip : {
							valueSuffix : '人'
						},
						plotOptions : {
							bar : {
								dataLabels : {
									enabled : true,
									allowOverlap : true
								// 允许数据标签重叠
								}
							}
						},
						legend : {
							layout : 'vertical',
							align : 'right',
							verticalAlign : 'top',
							x : -40,
							y : 100,
							floating : true,
							borderWidth : 1,
							backgroundColor : ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
							shadow : true
						},
						series : [ {
							name : '2016 年',
							data : [ 1007, 1531, 1635 ]
						}, {
							name : '2017 年',
							data : [ 1303, 2156, 2947 ]
						}, {
							name : '2018 年',
							data : [ 1973, 2914, 4054 ]
						} ]
					});

	Highcharts
			.chart(
					'infoSource',
					{
						chart : {
							type : 'variablepie'
						},
						title : {
							text : '学生信息来源'
						},
						subtitle : {
							text : '扇区长度（圆周方法）表示面积，宽度（纵向）表示学生渠道'
						},
						tooltip : {
							headerFormat : '',
							pointFormat : '<span style="color:{point.color}">\u25CF</span> <b> {point.name}</b><br/>'
									+ '面积 (人数): <b>{point.y}</b><br/>'
									+ '人口密度 (每种渠道人数): <b>{point.z}</b><br/>'
						},
						series : [ {
							minPointSize : 10,
							innerSize : '20%',
							zMin : 0,
							name : 'channels',
							data : [ {
								name : '智联',
								y : 505370,
								z : 92.9
							}, {
								name : '前程无忧',
								y : 551500,
								z : 118.7
							}, {
								name : '百度',
								y : 312685,
								z : 124.6
							}, {
								name : '360',
								y : 78867,
								z : 137.5
							}, {
								name : '搜狗',
								y : 301340,
								z : 201.8
							}, {
								name : '58同城',
								y : 41277,
								z : 214.5
							}, {
								name : '赶集网',
								y : 357022,
								z : 235.6
							}, {
								name : '院校招聘',
								y : 511144,
								z : 335.6
							}, {
								name : '院校宣讲',
								y : 511144,
								z : 335.6
							}, {
								name : '院校实训',
								y : 511144,
								z : 335.6
							}, {
								name : '院校专业共建',
								y : 511144,
								z : 335.6
							}, {
								name : '渠道代理',
								y : 511144,
								z : 335.6
							} ]
						} ]
					});
	// 创建渐变色
	Highcharts.getOptions().colors = Highcharts.map(
			Highcharts.getOptions().colors, function(color) {
				return {
					radialGradient : {
						cx : 0.5,
						cy : 0.3,
						r : 0.7
					},
					stops : [
							[ 0, color ],
							[
									1,
									Highcharts.Color(color).brighten(-0.3).get(
											'rgb') ] // darken
					]
				};
			});
	// 构建图表
	var chart = Highcharts
			.chart(
					'stuState',
					{
						title : {
							text : '学员意向分布图(未报名)'
						},
						tooltip : {
							pointFormat : '{series.name}: <b>{point.percentage:.1f}%</b>'
						},
						plotOptions : {
							pie : {
								allowPointSelect : true,
								cursor : 'pointer',
								dataLabels : {
									enabled : true,
									format : '<b>{point.name}</b>: {point.percentage:.1f} %',
									style : {
										color : (Highcharts.theme && Highcharts.theme.contrastTextColor)
												|| 'black'
									},
									connectorColor : 'silver'
								}
							}
						},
						series : [ {
							type : 'pie',
							name : '意向占比',
							data : [ [ '非常有意向', 45.0 ], [ '一般有意向', 26.8 ], {
								name : '非常有意向',
								y : 12.8,
								sliced : true,
								selected : true
							}, [ '意向不明', 8.5 ], [ '无意向', 6.9 ] ]
						} ]
					});
	var chart = Highcharts
			.chart(
					'stuTotal',
					{
						chart : {
							type : 'column'
						},
						title : {
							text : '月报名人数'
						},
						subtitle : {
							text : ''
						},
						xAxis : {
							categories : [ '一月', '二月', '三月', '四月', '五月', '六月',
									'七月', '八月', '九月', '十月', '十一月', '十二月' ],
							crosshair : true
						},
						yAxis : {
							min : 0,
							title : {
								text : '单位 (人)'
							}
						},
						tooltip : {
							// head + 每个 point + footer 拼接成完整的 table
							headerFormat : '<span style="font-size:10px">{point.key}</span><table>',
							pointFormat : '<tr><td style="color:{series.color};padding:0">{series.name}: </td>'
									+ '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
							footerFormat : '</table>',
							shared : true,
							useHTML : true
						},
						plotOptions : {
							column : {
								borderWidth : 0
							}
						},
						series : [
								{
									name : '南京校区',
									data : [ 198, 200, 150, 133, 251, 251, 269,
											98, 45, 146, 198, 187 ]
								},
								{
									name : '北京校区',
									data : [ 233, 253, 356, 126, 159, 258, 398,
											358, 369, 355, 398, 456 ]
								},
								{
									name : '长沙校区',
									data : [ 250, 123, 154, 259, 246, 289, 245,
											265, 360, 302, 125, 148 ]
								} ]
					});
});