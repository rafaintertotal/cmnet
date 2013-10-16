<html>
<!DOCTYPE html>
<!--[if IE 7 ]> <html lang="en" class="ie7"> <![endif]-->
<!--[if IE 8 ]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9 ]> <html lang="en" class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<title>Passo 2</title>
<link rel="stylesheet" media="screen" href="style.css" />

<!-- This is for mobile devices -->
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;"/>

<!-- This makes HTML5 elements work in IE 6-8 -->
<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<script type="text/javascript">
function temCrianca() {
  if (document.getElementById("crianca").checked) {
    document.getElementById("idadeCrianca").disabled=false;
    document.getElementById("qtdAdultos").value="1";
    document.getElementById("qtdAdultos").disabled=true;
  } else {
    document.getElementById("idadeCrianca").disabled=true;
    document.getElementById("qtdAdultos").disabled=false;
    document.getElementById("idadeCrianca").value="0";
  }
}

function doisAdultos() {
  if (document.getElementById("qtdAdultos").value > 1) {
  	document.getElementById("crianca").checked = false;
    document.getElementById("crianca").disabled=true;
    document.getElementById("idadeCrianca").disabled=true;
  } else {
    // document.getElementById("crianca").checked = false;
    document.getElementById("crianca").disabled=false;
    document.getElementById("idadeCrianca").disabled=false;
  }
}
</script>
</head>
<body>

</body>
</html>