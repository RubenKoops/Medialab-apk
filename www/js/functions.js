// JavaScript Document 

//function index
/*
insertText('ids','values')
	Zet values in ids, gescheiden met een "|"

copyInput('id',this.value)
	Kopierd value naar andere id

changeStyle('id','css','style')
	Veranderd de gewenste style
	
editUser(id,state)
	disable tekstvelden als de gebruiker bewerkt wordt

displayCheckbox('className')
	Geef checkbox een id en alle items met dezelfde class als de id worden getoggled in display:none/block
	
removeElement('class1|class2')
*/
$(document).ready(function(){
	addTogleListeners();
	
	var username = window.localStorage.getItem("username");
	var password = window.localStorage.getItem("password");
	if(password){
		$("#username").val(window.localStorage.getItem("username"));
		$("#password").val(window.localStorage.getItem("password"));
		}
	
		
});

function removeSpaces(string) {
 return string.split(' ').join('');
}	 

	
function addTogleListeners(){
	
	$("#types").on("click","input",function(){
		
		if(this.id == "checkall"){
			//alert("je moeder");
			$("#types :checkbox").prop("checked",true);
			$("#itemlist li").css('display','block');
			}else{
				//alert(this.id);
				if($("."+this.id).css('display') != 'none'){
					$("."+this.id).css('display','none');
					}else{
						$("."+this.id).css('display','block');
						}
				}
		});
		
		
	$("wrapper").click(function(){
		$("#menu_checkbox").prop("checked",false);
		});
		
	$("#menu_checkbox").click(function(){
		if($("#popup_checkbox").prop("checked") == true){
			var popup_checkbox = $("#popup_checkbox");
			popup_checkbox.trigger('click');
			}
		});
	$(".toggle_popup_menu").click(function(){
		var checkBox = $("#popup_checkbox");
		checkBox.trigger('click');
		$("#menu_checkbox").prop("checked",false);
		$('#action').val("insert");	$('#id').val("");		$('#type').val(""); 
		$('#name').val("");			$('#owner').val(""); 	$('#note').val("");
		if($(".edit").css('display') == 'none'){
			setTimeout(
			  function() 
			  {
				$('.edit').css("display","block");
				$('#info').css("display","none");
				$('#delete').css("display","none");
				$('#confirm_delete').css("display","none");
				$('#id').prop('readonly',false);
			  }, 300);
			
			}
		});
		
	$("#itemlist").on("click",".edit_popup_menu",function(){
		$('.edit').css("display","none");
		$('#info').css("display","block");
		$('#delete').css("display","inline");
		$('#id').prop('readonly',true);
		var checkBox = $("#popup_checkbox");
		checkBox.trigger('click');
		$("#menu_checkbox").prop("checked",false);
		window.editid = event.target.id;
		//alert(editid);
		getDataFromDb(editid);
		});
		
	$("#itemlist").on("click",".show_product",function(){
		window.showid = event.target.id;
		getDataFromDb(window.showid);
		//alert(editid);
		var checkBox = $("#product_checkbox");
		checkBox.trigger('click');
		$("#product_checkbox").prop("checked",true);
		showProduct();
		});
		
	$(".home").click(function(){
			$("#menu_checkbox").prop("checked",false);
			if($("#product_checkbox").prop("checked") == false){
				//alert("ik refresh de data omdat je op home klikt");
				$("#itemlist").empty()
				getDataFromDb();
				}
			$("#product_checkbox").prop("checked",false);
			
		});
};


	
function login(){
	$("#login").click(function(){
		//alert("login");
		var username=$("#username").val();
		username = username.toLowerCase();
		username = (username.trim());
		
		var password=$("#password").val();
		password = (password.trim());
		
		var ready=false;
		
		 if($.trim(username).length>0 & $.trim(password).length>0){
			 ready=true;
			}else{
				$("body").append("<msg>vul alle velden in</msg>");
				}
		 var dataString="username="+username+"&password="+password+"&login=medialab";
		 if(ready == true){
			 $.ajax({
				type: "POST",
				url:"http://pakhuis.hosts.ma-cloud.nl/login.php",
				data: dataString,
				xhrFields: {
				   withCredentials: true
				},
				crossDomain: true,
				cache: false,
				beforeSend: function(){ $("#login").val('Connecting...');},
				success: function(data){
					data= (data.trim());
					if(data=="ok"){
						//alert("inserted");
						$("body").append("<msg>login gelukt</msg>");
						window.localStorage.setItem('login', true);
						window.localStorage.setItem('username', username);
						window.localStorage.setItem('password', password);
						checkLogin();
						$("#login").val('login');
						}
						else{
							alert(data);
							window.location.replace("login.html");
							$("body").append("<msg>"+data+"</msg>");
							$("#login").val('login');
							}
						}
					});
				}return false;
				
			
		});
		};


function confirmDelete(){
	if($("#confirm_delete").css("max-height") == "100px"){
		$('#confirm_delete').css("max-height","0");
		}else{
			$('#confirm_delete').css("max-height","100px");
			}
	}
  

			
	
