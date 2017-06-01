<?php 
	//header("http/1.1 404 not found");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>出错了</title>
<style type="text/css">
html { height: 100%; } /* always display scrollbars */
body { height: 100%; font-size: 62.5%; line-height: 1; font-family: Arial, Tahoma, Verdana, sans-serif; }
img {
    border: 0;
    max-width: 100%;
}

body {
    background: #dfdfdf;
    font-family: Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    overflow: hidden;
}

#mainError {
    position: relative;
    width: 600px;
    margin: 0 auto;
    padding-top: 8%;
    animation: main .8s 1;
    animation-fill-mode: forwards;
    -webkit-animation: main .8s 1;
    -webkit-animation-fill-mode: forwards;
    -moz-animation: main .8s 1;
    -moz-animation-fill-mode: forwards;
    -o-animation: main .8s 1;
    -o-animation-fill-mode: forwards;
    -ms-animation: main .8s 1;
    -ms-animation-fill-mode: forwards;
}

#mainError h2{
    position: relative;
    color: #dfdfdf;
	letter-spacing:2px;
	font: 30px 'TeXGyreScholaBold', Arial, sans-serif;
    line-height: 48px;
    font-weight: bold;
    text-align: center;
    text-shadow: 0 0;
}
#mainError #content {
    position: relative;
    width: 600px;
    background: white;
    -moz-box-shadow: 0 0 0 3px #ededed inset, 0 0 0 1px #a2a2a2, 0 0 20px rgba(0,0,0,.15);
    -webkit-box-shadow: 0 0 0 3px #ededed inset, 0 0 0 1px #a2a2a2, 0 0 20px rgba(0,0,0,.15);
    box-shadow: 0 0 0 3px #ededed inset, 0 0 0 1px #a2a2a2, 0 0 20px rgba(0,0,0,.15);
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    z-index: 5;
}
#content h2 {
    color: #0061a5;
}
#mainError #content{
	letter-spacing:1px;
    position: relative;
    padding: 20px;
    font-size: 14px;
    line-height: 1.3em;
    color: #999;
}
pre{
	border-top: 1px dotted;
	white-space: pre-wrap;
	background-color:#ff9;
	margin:2px;
	padding:5px;
	color:#111;
	line-height: 1.2em;
}
span.line{display:block;}
.heightLine{
	background-color: #999;
}
</style>
</head>
  <body>
    <div id="mainError">
	    <div id="content">
	      <h2>Sorry:An error has occurred.</h2>
	      	<?php 
				if (isset($errorMsg))
				{
					echo '<p>'.htmlspecialchars($errorMsg).'</p>';
				}
				
				if ($file)
				{
					$sources	= King_Exception::debug($file,$line);
					echo '<div><pre class="source"><code>';
					foreach ($sources as $num => $row)
					{
						$class	= 'line';
						if ($line == $num)
							$class	= 'line heightLine';
						echo '<span class="'.$class.'"><span>'.$num.'</span>'.htmlspecialchars($row, ENT_NOQUOTES,'utf-8').'</span>';
					}
					echo '</code></pre></div>';
				}	
			?>
			<br />
	    </div>
  </div>
</body>
</html>