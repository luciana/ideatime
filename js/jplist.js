/*
 * jPList - jQuery plugin for sorting, filtering and paging 
 * http://do-web.com/jplist/overview
 *
 * Copyright 2011, Miriam Zusin
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://do-web.com/jplist/license
 */

(function($){
   $.fn.jplist = function(options){
	   
	var options = $.extend({
		items_box: "",
		item_path: "",
		pagingbox: "#buttons",
		pageinfo: "#info",
		//filter_field: "#filter input",
		filter_path: "",
		sort: {},
		filter: {},
		sort_order: "asc", //"desc",
		sort_is_num: false,
		sort_name: "",
		max_pages: 5,
		items_on_page: 15,
		redraw_callback: "",
		cookies: true,
		sort_dd_path: "#sort-drop-down",
		paging_dd_path: "#page-by"
	},options);

	return this.each(function() {            
		var hndl = this;
		
		// 1. pathes
		this.box = $(this).find(options.items_box);
		this.items = $(this).find(options.item_path);	
		
		this.getOuterHTML = function(el){
			var html = "";
			var attr = el[0].attributes;
			var inner = el.html();
			var name = el[0].tagName.toString().toLowerCase();
			
			html += "<" + name + " ";
			
			for(var i=0; i<attr.length; i++){
			
				if(attr[i].nodeValue != null && 
				   attr[i].nodeValue != ''){
				
					html += attr[i].nodeName + "=";
					html += "'" + attr[i].nodeValue + "' ";
				}
			}
			
			html += ">";
			html += inner;
			html += "</" + name + ">";
			
			return html;
		};
		
		
		//Data class ---------------
		function DataClass(){
		
			var dc_hndl = this;			
			this.data = new Array();
			var sortArr, filterArr;
			
			//const
			this.ID = 0;
			this.HTML = 1;
			this.SORT_ARR = 2;
			this.FILTER_ARR = 3;
			
			this.url = document.URL;
			
			//init sort const
			var j = 0;
			for(var sort_name in options.sort){
			
				this["sort-" + sort_name] = j;
				j++;
			}
			
			//init filter const
			var j = 0;
			for(var filter_name in options.filter){
			
				this["filter-" + filter_name] = j;				
				j++;
			}			
			
			this.getItems = function(){
			
				var html, i = 0, filter;
				
				hndl.items.each(function(){
				
					//html
					html = hndl.getOuterHTML($(this));
					
					//init arrays
					sortArr = new Array();
					filterArr = new Array();
					
					//sort
					for(var sort_name in options.sort){	
						
						sortArr.push([$(this).find(options.sort[sort_name]).text()]);						
					}
					
					//filter
					for(var filter_name in options.filter){	
						
						filterArr.push([$(this).find(options.filter[filter_name]).text()]);						
					}
					
					dc_hndl.data.push([i, html, sortArr, filterArr]);
					
					i++;
				});
			};
			
			//init
			this.getItems();
			
			this.print = function(data){
				
				var html = "";
				var sort_val = hndl.sortObj.sort_name;
				var items_on_page_val = hndl.pagingObj.items_on_page;
				var cpage_val = hndl.pagingObj.cpage;
				var order_val = hndl.sortObj.order;
				var sort_is_num_val = Boolean(hndl.sortObj.sort_is_num);
						
				for(var i=0; i<data.length; i++){
				
					html += data[i][hndl.dataObj.HTML];
				}
			
				hndl.box.html(html);
				
				if(options.cookies){
					hndl.cookiesObj.setCookies();
				}
				
				if($.isFunction(options.redraw_callback)){
				
					options.redraw_callback(sort_val, items_on_page_val, cpage_val, order_val, sort_is_num_val);
				}								
			};
		}
		//end of Data class ---------
		
		//Filter class ---------------
		function FilterClass(){
		
			var f_hndl = this;
			this.filter_pathes = $(hndl).find(options.filter_path);
			this.input_fields = this.filter_pathes.find("input");
			
			this.input_fields.keyup(function(){
				
				hndl.pagingObj.cpage = 0;
				hndl.viewObj.updateView();
			});
			
			this.format = function(val){
			
				var temp = new String(val);				
				temp = temp.replace(/[^a-zA-Z0-9]+/g,'');				
				return temp.toLowerCase();
			};
			
			this.if_add_item = function(arr){
				var res = true;
				for(var i=0; i<arr.length; i++){
					res = res & arr[i];
				}
				//console.log(arr);
				return res;
			};
			
			this.filterData = function(data){
				var filtered = new Array();
				var filter_arr, item;
				var item_to_add_arr;
				
				for (var i=0; i<data.length; i++){
				
					item = data[i];
					filter_arr = item[hndl.dataObj.FILTER_ARR];
					
					//init values arr
					item_to_add_arr = new Array();
					
					f_hndl.input_fields.each(function(){												
						var val = f_hndl.format($(this).val());
						var class_name = $(this).attr("class");
						var filter_index = hndl.dataObj["filter-" + class_name];
						var data_item = filter_arr[filter_index];
						
						if((f_hndl.format(data_item[0]).indexOf(val) != -1) || 
							($.trim(val) == "")){							
							item_to_add_arr.push(true);
						}
						else{
							item_to_add_arr.push(false);
						}
					});
					
					
					if(f_hndl.if_add_item(item_to_add_arr)){
						filtered.push(item);
					}
				}
				
				return filtered;
			};
		}
		//end of Filter class ---------
		
		//Cookies class ---------------
		function CookiesClass(){
		
			var coo_hndl = this;	
			
			this.setCookies = function(){
				var filter_val, filter_class_name;
					
				var sort_val = hndl.sortObj.sort_name;
				var items_on_page_val = hndl.pagingObj.items_on_page;
				var cpage_val = hndl.pagingObj.cpage;
				var order_val = hndl.sortObj.order;
				var sort_is_num_val = Boolean(hndl.sortObj.sort_is_num);
				
				//filter vals
				hndl.filterObj.input_fields.each(function(){										
					filter_val = hndl.filterObj.format($(this).val());
					filter_class_name = $(this).attr("class");
					coo_hndl.setCookie("f-" + filter_class_name, filter_val); //filter
				});
				
				coo_hndl.setCookie("s", sort_val); //sort
				coo_hndl.setCookie("iop", items_on_page_val);
				coo_hndl.setCookie("c", cpage_val);	//cpage			
				coo_hndl.setCookie("o", order_val); //order
				coo_hndl.setCookie("sn", sort_is_num_val); //sort_is_num
				coo_hndl.setCookie("id", hndl.dataObj.url);
				
			};
			
			this.getCookies = function(){
				
				var filter_val, filter_class_name;
				
				var sort_val = coo_hndl.getCookie("s"); //sort
				var items_on_page_val = coo_hndl.getCookie("iop"); 
				var cpage_val = coo_hndl.getCookie("c"); //cpage
				var order_val = coo_hndl.getCookie("o"); //order
				var sort_is_num_val = coo_hndl.getCookie("sn") == "true"?true:false; //sort_is_num	
				var id = coo_hndl.getCookie("id");
				
				if(id != hndl.dataObj.url){
					if(hndl.filterObj.filter_field != undefined){
						hndl.filterObj.filter_field.val("");
					}
					hndl.pagingObj.cpage = 0;
				}	
				else{
				
					hndl.filterObj.input_fields.each(function(){
						filter_class_name = $(this).attr("class");
						filter_val = coo_hndl.getCookie("f-" + filter_class_name);
						
						if(filter_val != undefined && filter_val != ""){
							hndl.filterObj.filter_pathes.find("input[class='" + filter_class_name + "']").val(filter_val);
						}
					});
					
					if(cpage_val != undefined && cpage_val != ""){
						hndl.pagingObj.cpage = cpage_val;
					}
								
				}

				if(sort_val != undefined && sort_val != ""){
					hndl.sortObj.sort_name = sort_val;
				}
				
				if(items_on_page_val != undefined && items_on_page_val != ""){
					hndl.pagingObj.items_on_page = items_on_page_val;
				}
								
				if(order_val != undefined && order_val != ""){					
					hndl.sortObj.order = order_val;
				}				
				
				if(sort_is_num_val != undefined && sort_is_num_val != ""){						
					hndl.sortObj.sort_is_num = Boolean(sort_is_num_val);
				}
			};
			
			this.setCookie = function(name, value){					
				var c_value = escape(value);
				var exdate = new Date();
				exdate.setDate(exdate.getDate() + 1); //1 day
				document.cookie = name + "=" + c_value + ";path=/; expires=" + exdate.toUTCString();
			};
			
			this.getCookie = function(c_name){
				
				var i, x, y, ARRcookies;
				ARRcookies = document.cookie.split(";");
				
				for (i=0; i<ARRcookies.length; i++){

					x = ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
					y = ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
					x = x.replace(/^\s+|\s+$/g,"");

					if (x == c_name){

							return unescape(y);
					}

				}
			};
			
		}
		//end of Cookies class ---------
		
		//Sort class ---------------
		function SortClass(){
		
			var s_hndl = this;
			
			this.order = options.sort_order;
			this.sort_name = options.sort_name;
			this.sort_is_num = Boolean(options.sort_is_num);			
			
			this.getFromArr = function(data_item, sort_name){
				
				var sort_index = hndl.dataObj["sort-" + sort_name];
				return data_item[hndl.dataObj.SORT_ARR][sort_index];
			};
			
			this.sortData = function(data){
				
				if(Boolean(s_hndl.sort_is_num)){
					data.sort(function(a, b){
					
						var x = s_hndl.getFromArr(a, s_hndl.sort_name);
						var y = s_hndl.getFromArr(b, s_hndl.sort_name);
						
						//if x or y not numbers
						try{
							x = x.toString().replace(/[^0-9.]+/g,'');
							y = y.toString().replace(/[^0-9.]+/g,'');
						}
						catch(ex){}
						
						if(s_hndl.order == "asc"){
						
							if(x == "")	{return 1;}						
							if(y == "")	{return -1;}
						}	
						else{
							if(y == "")	{return 1;}						
							if(x == "")	{return -1;}
						}
						
						return eval(x - y);
					
					});
				}
				else{
					
					data.sort(function(a, b){
						
						var x = s_hndl.getFromArr(a, s_hndl.sort_name);
						var y = s_hndl.getFromArr(b, s_hndl.sort_name);
						
						if(x == undefined || y == undefined){
							return x > y ? 1 : -1; 
						}
						else{
							return x.toString().toLowerCase() > y.toString().toLowerCase() ? 1 : -1; 
						}						
					});					
					
				}
					
				if(s_hndl.order == "desc"){
					data.reverse(function(a, b){
					
						var x = s_hndl.getFromArr(a, s_hndl.sort_name);
						var y = s_hndl.getFromArr(b, s_hndl.sort_name);
						
						if(x == undefined || y == undefined){
							return x > y ? 1 : -1; 
						}
						else{
							return x.toString().toLowerCase() > y.toString().toLowerCase() ? 1 : -1; 
						}	
					});
				}
				
				
				return data;
			};
		}
		//end of Sort class ---------
		
		//View class ---------------
		function ViewClass(){
		
			var v_hndl = this;
			
			this.viewData = new Array();
			
			this.updateView = function(){
								
				//filter view
				v_hndl.viewData = hndl.filterObj.filterData(hndl.dataObj.data);
				
				//sort view				
				v_hndl.viewData = hndl.sortObj.sortData(v_hndl.viewData);				
					
				//set paging
				v_hndl.viewData = hndl.pagingObj.setPaging(v_hndl.viewData);
								
				//print html
				hndl.dataObj.print(v_hndl.viewData);
				
			};
			
		}
		//end of View class ---------
		
		//Drop Down class ---------------
		function DropDownClass(){
		
			var dd_hndl = this;
			
			this.sort_dd = $(hndl).find(options.sort_dd_path);
			this.paging_dd = $(hndl).find(options.paging_dd_path);			
			
			$(document).click(function(){
				$(hndl).find(".drop-down").each(function(){					
					
					var ul = $(this).find("ul");
					if(ul.is(":visible")){
						ul.hide();
					}					
				});
			});
				
			this.init_dd = function(el){
				
				var val = el.find("li span:eq(0)").text();
				var panel, ul;
				
				el.prepend("<div class='panel'>" + val + "</div>");
				
				panel = el.find(".panel");
				ul = el.find("ul");
				
				panel.click(function(e){
					e.stopPropagation();
					
					if(ul.is(":visible")){
						ul.hide();
					}
					else{
						ul.show();
					}
				});	

				ul.find("li").click(function(){
					panel.html($(this).text());
				});				
			};
			
			this.init_dd(this.sort_dd);
			this.init_dd(this.paging_dd);	
			
			this.sort_dd_panel = this.sort_dd.find(".panel");
			this.paging_dd_panel = this.paging_dd.find(".panel");
			
			this.sort_dd.find("li").click(function(){
				var val = $(this).find("span").attr("class");
				var is_num, order = "asc", sort_name = "";
				
				if(val.indexOf("true") != -1){
					is_num = true;
				}	
				else{
					is_num = false
				}				
				
				if(val.indexOf("desc") != -1){
					order = "desc";
				}
				
				for(var sn in options.sort){
					if($(this).find("span").hasClass(sn)){
						sort_name = sn;
					}
				}
				
				//console.log(sort_name + " " + order + " " + is_num);	
				hndl.sort(sort_name, order, is_num);
			});
			
			this.initDD = function(){
				var items_on_page_val = hndl.pagingObj.items_on_page;
				var sort_val = hndl.sortObj.sort_name;
				var order_val = hndl.sortObj.order;
				var sort_is_num_val = Boolean(hndl.sortObj.sort_is_num);
				
				//console.log(sort_val + " " + order_val + " " + sort_is_num_val);
				var pspan;
				
				//paging drop down
				pspan = dd_hndl.paging_dd.find("span[class='p" + items_on_page_val + "']");		
				
				if(pspan.length <= 0){
					pspan = dd_hndl.paging_dd.find("span[class='all']");
				}				
				
				dd_hndl.paging_dd_panel.html(pspan.text());
				
				//sort drop down
				dd_hndl.sort_dd.find("ul li span").each(function(){
					
					if($(this).hasClass(sort_val) &&
					   $(this).hasClass(order_val) &&
					   $(this).hasClass(sort_is_num_val)){
						
							//console.log("here");
							dd_hndl.sort_dd_panel.html($(this).text());
					   }
				});
			};
			
			this.paging_dd.find("li").click(function(){
				var val = $(this).find("span").attr("class").replace("p", "");
				hndl.paging(val);
			});
			
		}
		//end of Drop Down class ---------
		
		//Paging class ---------------
		function PagingClass(){
		
			var p_hndl = this;

			this.all_items_num = hndl.items.length;
			this.items_on_page = options.items_on_page;
			this.cpage = 0;
			this.pagingView = new Array();

			this.pageinfo = $(hndl).find(options.pageinfo);
			this.pagingbox = $(hndl).find(options.pagingbox);
			this.pagingbox.html("<div id='pagingprev'></div><div id='pagingmid'></div><div id='pagingnext'></div>");
			this.pagingprev = this.pagingbox.find("#pagingprev");
			this.pagingmid = this.pagingbox.find("#pagingmid");
			this.pagingnext = this.pagingbox.find("#pagingnext");
			this.pagingprev.html("<span class='first'>&laquo;</span><span class='prev'>&lt;</span>");
			this.pagingnext.html("<span class='next'>&gt;</span><span class='last'>&raquo;</span>");
			this.first = this.pagingprev.find(".first");
			this.prev = this.pagingprev.find(".prev");
			this.next = this.pagingnext.find(".next");
			this.last = this.pagingnext.find(".last");
			
			this.first.click(function(){
				p_hndl.cpage = 0;
				p_hndl.setPaging(p_hndl.pagingView);
			});
			
			this.prev.click(function(){
				p_hndl.cpage = p_hndl.getprevpage();
				p_hndl.setPaging(p_hndl.pagingView);
			});
			
			this.next.click(function(){
				p_hndl.cpage = p_hndl.getnextpage();
				p_hndl.setPaging(p_hndl.pagingView);
			});
			
			this.last.click(function(){
				p_hndl.cpage = p_hndl.get_pages_num(p_hndl.items_on_page) - 1;
				p_hndl.setPaging(p_hndl.pagingView);
			});	

			this.get_pages_num = function(items_on_page){
				return eval(Math.ceil(p_hndl.all_items_num/items_on_page));
			};
			
			this.getprevpage = function(){
				if(p_hndl.cpage <= 0){
					return 0;
				}
				else{
					return p_hndl.cpage - 1;
				}
			};
			
			this.getnextpage = function(){
				if(p_hndl.cpage >= p_hndl.get_pages_num(p_hndl.items_on_page) - 1){
					return p_hndl.get_pages_num(p_hndl.items_on_page) - 1;
				}
				else{
					return eval(p_hndl.cpage) + 1;
				}
			};
			
			
			this.setPaging = function(data){
			
				var start = p_hndl.cpage*p_hndl.items_on_page;
				var end = eval(start) + eval(p_hndl.items_on_page);
				var all = data.length;
				p_hndl.pagingView = data;
				
				if(end > data.length){
					end = data.length;
				}
												
				//update vars
				p_hndl.all_items_num = all;
				
				//update data array
				data = data.slice(start, end);
				
				//update info
				p_hndl.updateInfo(start, end, all);
				
				//update bullets
				p_hndl.updateBullets();
				
				//arrow
				p_hndl.setarrowview();
				
				//if one page
				p_hndl.setPagingDisplay(data.length);
				
				hndl.dataObj.print(data);
				
				return data;
			};
			
			this.updateBullets = function(){
			
				var start, end, diff;
				var html = "";
			
				if(p_hndl.cpage >= 0 && p_hndl.cpage < p_hndl.get_pages_num(p_hndl.items_on_page)){
				
					diff = Math.floor(p_hndl.cpage / options.max_pages);
					start = options.max_pages*diff;
					end = options.max_pages*(diff + 1);
					
					if(end > p_hndl.get_pages_num(p_hndl.items_on_page)){
						end = p_hndl.get_pages_num(p_hndl.items_on_page);
					}
					
					html +=	"<div id='pagesbox'>";			
					for(var i=start; i<end; i++){
						
						html += "<span";						
						if(i == p_hndl.cpage){
							html += " class='current'";
						}
						html += ">" + (eval(i) + 1) + "</span> ";
					}
					html +=	"</div>";
					
					p_hndl.pagingmid.html(html);
					p_hndl.pagingmid.find("span").unbind().click(function(){
						var page = $(this).text() - 1;
						p_hndl.cpage = page;
						p_hndl.setPaging(p_hndl.pagingView);
					});
				}
			};
			
			this.setarrowview = function(){
				
				//set pagingprev visibility
				if(p_hndl.cpage == 0){//< options.max_pages
					p_hndl.pagingprev.css("visibility", "hidden");
				}
				else{
					p_hndl.pagingprev.css("visibility", "visible");
				}
				
				//set pagingnext visibility
				if(p_hndl.cpage == p_hndl.get_pages_num(p_hndl.items_on_page) - 1){ //>= Math.floor(hndl.get_pages_num(hndl.items_on_page)/options.max_pages)*options.max_pages){
					p_hndl.pagingnext.css("visibility", "hidden");
				}
				else{
					p_hndl.pagingnext.css("visibility", "visible");
				}	
			};
			
			this.setPagingDisplay = function(){			
				
				if(p_hndl.get_pages_num(p_hndl.items_on_page) == 1){
					//p_hndl.pagingbox.css("visibility", "hidden");
				}
				else{
					p_hndl.pagingbox.css("visibility", "visible");
				}
			};
			
			this.updateInfo = function(start, end, all){
				p_hndl.pageinfo.html((eval(start) + 1) + " - " + eval(end) + " of " + eval(all));
			};
		}
		//end of Paging class ---------
		
		//objects
		this.dataObj = new DataClass();
		this.filterObj = new FilterClass();
		this.sortObj = new SortClass();
		this.viewObj = new ViewClass();
		this.pagingObj = new PagingClass();
		this.cookiesObj = new CookiesClass();
		this.ddObj = new DropDownClass();
				
		//cookies
		if(options.cookies){
			this.cookiesObj.getCookies();
			this.viewObj.updateView();
			this.ddObj.initDD();
		}
		
		//api
		this.sort = function(sort_name, order, sort_is_num){
			
			hndl.pagingObj.cpage = 0;
			hndl.sortObj.sort_name = sort_name;
			hndl.sortObj.order = order;
			hndl.sortObj.sort_is_num = Boolean(sort_is_num);
			
			hndl.viewObj.updateView();
		};
		
		this.paging = function(items_on_page){
			
			if(items_on_page == "all"){
				hndl.pagingObj.items_on_page = hndl.pagingObj.all_items_num;
			}
			else{
				hndl.pagingObj.items_on_page = items_on_page;
			}
			
			hndl.pagingObj.cpage = 0;
			hndl.viewObj.updateView();
		};
		
		//init view
		this.viewObj.updateView();
		
	});    
   };
})(jQuery);