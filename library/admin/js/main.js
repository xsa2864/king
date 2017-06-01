function checks(){
    if(window.confirm('你确定执行吗?')){
		return true;
	}else{
		return false;
	}
}
function selects(obj, chk){
   if (chk == null)
  {
    chk = 'checkboxes';
  }

  var elems = document.getElementsByTagName("INPUT");
  for (var i=0; i < elems.length; i++)
  {
    if (elems[i].name == chk || elems[i].name == chk + "[]")
    {
      elems[i].checked = obj.checked;
    }
  }
}

function vdata(data){
	var d = eval("(" + data+ ")");
	return d;
}

function alertMsg(msg, tar, tmpW, tmpH) {
	if(!tar)  tar  = '';
	if(!tmpW) tmpW = msg.length * 40;
	if(!tmpH) tmpH = 20;

	$('#alertMsg').remove();
	$('body').append('<div id="alertMsg" style="padding: 10px 0;text-align:center;-moz-border-radius:10px;-khtml-border-radius:10px;-webkit-border-radius:10px;border-radius:10px">'+msg+'</div>');
	var obj = $('#alertMsg');

	if(tar){
		var aTop  = $(tar).offset().top;
		var aLeft = $(tar).offset().left;
		var aWidth = $(tar).outerWidth();
		var aHeight = $(tar).outerHeight();

		var tmpT = aTop + aHeight;
		var tmpL = aLeft;
	}else{
		var tmpT = ($(window).height() - tmpH) / 2 + $(document).scrollTop();
		var tmpL = ($(window).width() - tmpW) / 2;
	}

	obj.css({
		position: 'absolute',
		left: tmpL,
		top: tmpT,
		//right: 0,
		//bottom: 0,
		width: tmpW,
		height: tmpH,
		background: '#316D93',
		border: '2px solid #316D93',
		color: '#FFF',
		zIndex: 99999
	});
	window.setTimeout(function(){$('#alertMsg').fadeOut(500);}, 2000);
}