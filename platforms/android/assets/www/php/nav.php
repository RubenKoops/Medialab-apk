<?php
?>
<style>
nav {
	background-color:#FFF;
	position:fixed;
	width:100%; top:0; left:0;
	padding:5px;
	-webkit-box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.15);
	-moz-box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.15);
	box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.15);
	}
nav #user{
	position:fixed;
	border:none;
	border-left:1px solid rgba(0,0,0,0.29);
	top:8px; right:5px; padding:5px;
	}
	
nav ul{
	padding:0; margin:0; display:inline-block;
	}
nav h1{
	display:inline-block;
	margin:0;
	font-size:26px;
	margin-right:20px;
	}
nav h1 #logo{
	color:#000000; text-decoration:none;}
	
nav ul li:first-of-type {
	border:none;
	}
nav ul li{
	list-style-type:none;
	display:inline-block;
	border-left:1px solid rgba(0,0,0,0.29);
	font-size:20px;
	margin:5px; margin-top:0; margin-bottom:0;
	padding: 5px; padding-left:20px;
	}
nav ul li .active{
	text-decoration:underline;
	font-weight:bold;
	}
	
nav ul .cms{
	background-color: #9DC45F;
	color: #FFFFFF;
	padding:5px;
	border: none;
	border-radius:5px;
	}
	
#menu_checkbox,#menu_button { display:none;}

	
@media screen and (max-width: 800px) {
	nav{
		-webkit-box-shadow: none;
		-moz-box-shadow: none;
		box-shadow: none;
		}
	nav ul {
		position:fixed;
		left:0;top:50px; width:100%;
		background-color: #626262;
		max-height:0; overflow:hidden;
		-webkit-transition: all 0.5s cubic-bezier(0, 1.05, 0, 1);
		-moz-transition: all 0.5s cubic-bezier(0, 1.05, 0, 1);
		-o-transition: all 0.5s cubic-bezier(0, 1.05, 0, 1);
		transition: all 0.5s cubic-bezier(0, 1.05, 0, 1);
		-webkit-box-shadow: 0px 20px 50px 0px rgba(0,0,0,0.20);
		-moz-box-shadow: 0px 20px 50px 0px rgba(0,0,0,0.20);
		box-shadow: 0px 20px 50px 0px rgba(0,0,0,0.20);
		overflow-y:scroll;
    	overflow-x:hidden;
		}
	nav ul li {
		display:block;
		border:none;
		text-align:center;
		font-size:28px;
		margin:0; padding:0;
		margin-top:5; margin-bottom:5px; padding-top:10px; padding-bottom:10px;
		
		}	
	nav ul li .active{
		background-color: rgba(255,255,255,0.25);
		display:block;
		padding-top:5px; padding-bottom:5px;
		}
	nav h1{
		margin:0; margin-left:50px;
		font-size:32px;
		}
	#menu_button {
		display:block;
		font-size:32px;
		position:fixed;
		top:0px; left:10px;
		opacity:1;
		-webkit-transition: all 0.5s ease-in-out;
		-moz-transition: all 0.5s ease-in-out;
		-o-transition: all 0.5s ease-in-out;
		transition: all 0.5s ease-in-out;
		}	
	#menu_checkbox:checked + #menu_button{
		-ms-transform: rotate(90deg); /* IE 9 */
		-webkit-transform: rotate(90deg); /* Chrome, Safari, Opera */
		transform: rotate(90deg);
		opacity:0.4;
		-webkit-transition: all 0.5s ease-in-out;
		-moz-transition: all 0.5s ease-in-out;
		-o-transition: all 0.5s ease-in-out;
		transition: all 0.5s ease-in-out;
		}
		
	#menu_checkbox:checked ~ ul {
		-webkit-transition: all 0.5s ease-in-out;
		-moz-transition: all 0.5s ease-in-out;
		-o-transition: all 0.5s ease-in-out;
		transition: all 0.5s ease-in-out;
		max-height:85%;
		}
	}
</style>
<nav>
    <div id="user">
    	<a href="account.php" style="color:rgba(60,60,60,1.00)">
    	<?php echo $_SESSION['cur_user'];?></a>
        &nbsp;&nbsp;
        <?php if($_SESSION['login'] == true){?> 
        <a href="index.php?logout=true">logout</a>
        <?php }else{?>
        <a href="login.php">login</a>
        <?php }?>
        
    </div>
    <input id="menu_checkbox" name="menu_checkbox" type="checkbox">
	<label id="menu_button" for="menu_checkbox">&#9776;</label>
	<h1><a href="index.php" id="logo">CMS</a></h1>
    <ul>
    	<?php $cur_page = basename($_SERVER['PHP_SELF']);?>
        <li><a href="index.php" <?php if($cur_page == 'index.php')echo 'class="active"';?>>home</a></li>
        <?php buildNav();?>
    	<li class="normal"><a href="cms.php" class="cms" <?php if($cur_page == 'cms.php')echo 'class="active"';?>>cms</a></li>
        <li class="normal"><a href="account.php" class="cms" <?php if($cur_page == 'accpount.php')echo 'class="active"';?>>accounts</a></li>
    </ul>
</nav>