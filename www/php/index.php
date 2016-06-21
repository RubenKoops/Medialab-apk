<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body {
	font-size:18px;
	font-family:Segoe, "Segoe UI", "DejaVu Sans", "Trebuchet MS", Verdana, sans-serif;
	color:#515151;
	}
wrapper {
	display:block;
	max-width:450px;
	margin:auto;
	}
a {
	color:#302B2B;
	display:inline-block;
	text-decoration:none;
	padding:5px; margin:5px;
	background-color: rgba(0,0,0,0.24);
	border-radius:10px;
	}
	
.refresh {
	background-color:rgba(117,216,76,1.00);
	padding:10px;
	}
#apk_list ul{
	padding:0;
	}
#apk_list a{
	float:right;
	}
#apk_list li{
	list-style-type:none;
	padding:5px; margin:5px;
	float:left;
	clear:both;
	}
.today:first-of-type{
	background-color:rgba(117,216,76,1.00);
	}
.oud::before{
	visibility:visible;
	opacity:1;
	content:"";
	width:100%; height:90px;
	position:absolute;
	transition: all 0.2s ease-in-out;
	-webkit-transition-delay: 0.8s; /* Safari */
	transition-delay: 0.8s;
	background: rgba(255,255,255,0);
	background: -moz-linear-gradient(top, rgba(255,255,255,0) 50%, rgba(255,255,255,1) 100%);
	background: -webkit-gradient(left top, left bottom, color-stop(50%, rgba(255,255,255,0)), color-stop(100%, rgba(255,255,255,1)));
	background: -webkit-linear-gradient(top, rgba(255,255,255,0) 50%, rgba(255,255,255,1) 100%);
	background: -o-linear-gradient(top, rgba(255,255,255,0) 50%, rgba(255,255,255,1) 100%);
	background: -ms-linear-gradient(top, rgba(255,255,255,0) 50%, rgba(255,255,255,1) 100%);
	background: linear-gradient(to bottom, rgba(255,255,255,0) 50%, rgba(255,255,255,1) 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ffffff', GradientType=0 );
	}
.oud:hover::before{
	visibility:hidden;
	opacity:0;
	transition: all 0.2s ease-in-out;
	}
#apk_list .oud{
	color:rgba(143,143,143,1.00);
	margin-top:40px;
	clear:both;
	padding-left:40px;
	padding-right:40px;
	display:block;
	max-height:90px;
	overflow:hidden;
	transition: all 1s ease-in-out;
	border-bottom:solid 1px rgba(184,184,184,1.00);
	}

#apk_list .oud:hover{
	max-height:400px;
	transition: all 1s ease-in-out;
	-webkit-transition-delay: 0.2s; /* Safari */
	transition-delay: 0.2s;
	border-bottom:solid 1px rgba(0,0,0,0.00);
	}
h5{
	margin:0;
	font-size:18px;
	}
.clear {
	clear:both;
	}
	
</style>
<wrapper>
    <a href="index.php" class="refresh">refresh</a>
    <div id="apk_list">
    <ul>
    <?php
    date_default_timezone_set('Europe/Amsterdam');
    foreach (glob("../build/*.apk") as $apk){
		$teller++;
		if (DateTime::createFromFormat('Y-m-d_His', str_replace("build/","",str_replace(".apk","",$apk))) == FALSE) {
			  rename($apk,"../build/".date("Y-m-d_His").".apk");
			  
			  $apk = "../build/".date("Y-m-d_His").".apk";
			}
		$apk_array[] = $apk;
        }
		
	$cur_date = date("Ymd");
	
	rsort($apk_array);	
	foreach($apk_array as $apk){
		$date = str_replace("../build/","",str_replace(".apk","",$apk));
		$pieces = explode("_",$date);
		$date = $pieces[0];
		$date = date("Ymd", strtotime($date));
		
		//echo $date.' - '.$cur_date;
		
		//laat alle items van vandaag zien
		if($date == $cur_date){
			?>
            <li><?php echo str_replace("../build/","",$apk);?></li><a class="today" href="<?php echo $apk;?>" download>download</a>
            <?php
			}
			
		else if($date != $oude_date){
			$oude_date = $date;
			?>
            <div class="clear"></div>
            </ul>
            <ul class="oud"><h5><?php echo date("l d F Y", strtotime($date));?></h5>
			<li><?php echo str_replace("../build/","",$apk);?></li><a href="<?php echo $apk;?>" download>download</a>
            <?php
			}else{
				?>
				<li><?php echo str_replace("../build/","",$apk);?></li><a href="<?php echo $apk;?>" download>download</a>
                <?php
				}
		
		
        }
    ?>
    </ul>
    </div>
</wrapper>