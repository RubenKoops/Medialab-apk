// JavaScript Document

$(document).ready(function(){
	selectFromDb('inventory','*','editdate','DESC');
	formListener();
});
function formListener(){
	$("#opslaan").click(function(){
		insertToDb('inventory');
		});
	}
	
function selectFromDb(table,cols,keycol,order){
	var type_array = new Array();
	var owner_array = new Array();
	var name_array = new Array();
	
	var dataString="table="+table+"&cols="+cols+"&keycol="+keycol+"&order="+order+"&action=select";
	//alert(dataString);
	
	$.ajax({
		type: "POST",
		url:"http://pakhuis.hosts.ma-cloud.nl/medialab/php/getdata.php",
		data: dataString,
		xhrFields: { withCredentials: true },
		crossDomain: true,
		cache: false,
		success: function(data){
		//alert(data);
		if(data == 'geen data'){
			alert("geen data");
			}else{
				var result = JSON.parse(data);	
				$.each(result, function(i, field){
					var id=field.id;
					var name=field.name;
					var type=field.type;
					var state=field.state;
					var owner=field.owner;
					
					type_array.push(type);
					owner_array.push(owner);
					name_array.push(name);
					
					$("#itemlist").append("<li id='"+id+"' class='"+type+" "+state+"'><h1>"+name+" ("+id+")</h1>"+type+"</li>");
					});
				}
			}, 
			complete: function(data){
					//alert("ik ben klaar");
					generateTypes(type_array);
					generateOwners(owner_array);
					generateNames(name_array);
					$("#checkall").trigger("click");
					}
		});
}

function insertToDb(table){
	var id = $("#id").val().toUpperCase();
	var type = $("#type").val();
	var name = $("#name").val();
	var owner = $("#owner").val();
	var note = $("#note").val();
	
	var date = new Date();				var month = (date.getMonth()+1)+"";		var day = date.getDate()+"";
	var hours = date.getHours()+"";		var minutes = date.getMinutes()+"";		var seconds = date.getSeconds()+"";
	
	if(month.length< 2){month = "0"+month;}										if(hours.length< 2){hours = "0"+hours;}										
	if(day.length< 2){day = "0"+day;}												if(minutes.length< 2){minutes = "0"+minutes;}
																				if(seconds.length< 2){seconds = "0"+seconds;}									
	
	var date = date.getFullYear() + "-" + month + "-" + day +" "+ hours +":"+ minutes +":"+ seconds;
	//alert(date);
	var editdate = date;
	
	var ready = true;
	
	var cols = "id,type,name,date,editdate,owner,notes";
	var values = id+","+type+","+name+","+date+","+editdate+","+owner+","+note;
	
	var dataString="table="+table+"&cols="+cols+"&values="+values+"&action=insert";
	//alert(dataString);
	
	if(id.length == 0 | type.length == 0 | name.length == 0 | owner.length == 0 | note.length == 0){
		alert("vul alle velden in");
		ready = false;
		}
	if(ready == true){
		$.ajax({
		type: "POST",
		url:"http://pakhuis.hosts.ma-cloud.nl/medialab/php/getdata.php",
		data: dataString,
		xhrFields: { withCredentials: true },
		crossDomain: true,
		cache: false,
		success: function(data){
		alert(data);
			$("#itemlist").empty();
			selectFromDb('inventory','*','editdate','DESC');
			}, 
			complete: function(data){
					alert("ik ben klaar");
					}
		});
		}
	}

function generateTypes(type_array){
	type_array = jQuery.unique(type_array);
	$("#types").empty();
	$("#type_list").empty();
	$("#types").append("<input id='checkall' type='button' value='all'>");
	
	$.each( type_array, function( key, value ) {
		//alert( key + ": " + value );
		$("#types").append("<input id='"+value+"' type='checkbox' checked><label for='"+value+"'>"+value+"</label>");
		$("#type_list").append("<option value='"+value+"'></option>");
		});
}
function generateNames(name_array){
	name_array = jQuery.unique(name_array);
	$("#name_list").empty();
	
	$.each( name_array, function( key, value ) {
		//alert( key + ": " + value );
		$("#name_list").append("<option value='"+value+"'></option>");
		});
}
function generateOwners(owner_array){
	owner_array = jQuery.unique(owner_array);
	$("#owner_list").empty();
	
	$.each( owner_array, function( key, value ) {
		//alert( key + ": " + value );
		$("#owner_list").append("<option value='"+value+"'></option>");
		});
}

