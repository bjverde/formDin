/*

Milonic DHTML Menu - JavaScript Website Navigation System.
Version 5.40 - Built: Sunday August 8 2004 - 17:11
Copyright 2004 (c) Milonic Solutions Limited. All Rights Reserved.
This is a commercial software product, please visit http://www.milonic.com/ for more information.
See http://www.milonic.com/license.php for Commercial License Agreement
All Copyright statements must always remain in place in all files at all times
*******  PLEASE NOTE: THIS IS NOT FREE SOFTWARE, IT MUST BE LICENSED FOR ALL USE  ******* 

License Number: 1000 for Unlicensed

*/



/*
Version 5.40 - Built: Sunday August 8 2004 - 17:11
*/
licenseNumber=1000;
licenseURL="Unlicensed";
_mD=2;_d=document;
function _drawMenu(){}

_n=navigator;_L=location;_nv=$tL(_n.appVersion);_nu=$tL(_n.userAgent);_ps=parseInt(_n.productSub);_f=false;_t=true;_n=null;_W=window;_wp=_W.createPopup;ie=(_d.all)?_t:_f;ie4=(!_d.getElementById&&ie)?_t:_f;ie5=(!ie4&&ie&&!_wp)?_t:_f;ie55=(!ie4&&ie&&_wp)?_t:_f;ns6=(_nu.indexOf("gecko")!=-1)?_t:_f;konq=(_nu.indexOf("konqueror")!=-1)?_t:_f;sfri=(_nu.indexOf("safari")!=-1)?_t:_f;if(konq||sfri){_ps=0;ns6=0}ns4=(_d.layers)?_t:_f;ns61=(_ps>=20010726)?_t:_f;ns7=(_ps>=20020823)?_t:_f;op=(_W.opera)?_t:_f;if(op||konq)ie=0;op5=(_nu.indexOf("opera 5")!=-1)?_t:_f;op6=(_nu.indexOf("opera 6")!=-1||_nu.indexOf("opera/6")!=-1)?_t:_f;op7=(_nu.indexOf("opera 7")!=-1||_nu.indexOf("opera/7")!=-1)?_t:_f;mac=(_nv.indexOf("mac")!=-1)?_t:_f;if(ns6||ns4||op||sfri)mac=_f;ns60=_f;if(ns6&&!ns61)ns60=_t;if(op7)op=_f;IEDtD=0;if(!op&&(_d.all&&_d.compatMode=="CSS1Compat")||(mac&&_d.doctype&&_d.doctype.name.indexOf(".dtd")!=-1))IEDtD=1;if(op)ie55=_f;_st=0;_en=0;$=" ";_m=new Array();_mi=new Array();;_sm=new Array();_tsm=new Array();_cip=new Array();;$S3="2E636F6D2F";$S4="646D2E706870";_mn=-1;_el=0;;_bl=0;;_MT=setTimeout("",0);_oMT=setTimeout("",0);;_cMT=setTimeout("",0);;_mst=setTimeout("",0);;_Mtip=setTimeout("",0);$ude="undefined ";;_zi=999;;_c=1;_oldel=-1;;_bH=500;;_oldbH=0;_bW=0;;_oldbW=0;_ofMT=0;;_startM=1;;_sT=0;;_sL=0;;_mcnt=0;_mnuD=0;_itemRef=-1;;inopenmode=0;lcl=0;_d.dne=0;inDragMode=0;function M_hideLayer(){}function _oTree(){}function mmMouseMove(){}function _cL(){}function _ocURL(){}function mmVisFunction(){}function remove(_ar,_dta){var _tar=new Array();for(_a=0;_a<_ar.length;_a++){if(_ar[_a]!=_dta){_tar[_tar.length]=_ar[_a]}}return _tar}function copyOf(_w){for(_cO in _w){this[_cO]=_w[_cO]}}function $tL($){if($)return $.toLowerCase()}function $tU($){if($)return $.toUpperCase()}function drawMenus(){_oldbH=0;_oldbW=0;for(_y=_mcnt;_y<_m.length;_y++){_drawMenu(_y,1)}}_$S={menu:0,text:1,url:2,showmenu:3,status:4,onbgcolor:5,oncolor:6,offbgcolor:7,offcolor:8,offborder:9,separatorcolor:10,padding:11,fontsize:12,fontstyle:13,fontweight:14,fontfamily:15,high3dcolor:16,low3dcolor:17,pagecolor:18,pagebgcolor:19,headercolor:20,headerbgcolor:21,subimagepadding:22,subimageposition:23,subimage:24,onborder:25,ondecoration:26,separatorsize:27,itemheight:28,image:29,imageposition:30,imagealign:31,overimage:32,decoration:33,type:34,target:35,align:36,imageheight:37,imagewidth:38,openonclick:39,closeonclick:40,keepalive:41,onfunction:42,offfunction:43,onbold:44,onitalic:45,bgimage:46,overbgimage:47,onsubimage:48,separatorheight:49,separatorwidth:50,separatorpadding:51,separatoralign:52,onclass:53,offclass:54,itemwidth:55,pageimage:56,targetfeatures:57,visitedcolor:58,pointer:59,imagepadding:60,valign:61,clickfunction:62,bordercolor:63,borderstyle:64,borderwidth:65,overfilter:66,outfilter:67,margin:68,pagebgimage:69,swap3d:70,separatorimage:71,pageclass:72,menubgimage:73,headerborder:74,pageborder:75,title:76,pagematch:77,rawcss:78,fileimage:79,clickcolor:80,clickbgcolor:81,clickimage:82,clicksubimage:83};function mm_style(){for($i in _$S)this[$i]=_n;this.built=0}_$M={items:0,name:1,top:2,left:3,itemwidth:4,screenposition:5,style:6,alwaysvisible:7,align:8,orientation:9,keepalive:10,openstyle:11,margin:12,overflow:13,position:14,overfilter:15,outfilter:16,menuwidth:17,itemheight:18,followscroll:19,menualign:20,mm_callItem:21,mm_obj_ref:22,mm_built:23,menuheight:24};function menuname(name){for($i in _$M)this[$i]=_n;this.name=$tL(name);_c=1;_mn++;this.menunumber=_mn}function _incItem(_it){_mi[_bl]=new Array();for($i in _x[6])_mi[_bl][_$S[$i]]=_x[6][$i];_mi[_bl][0]=_mn;_it=_it.split(";");for(_a=0;_a<_it.length;_a++){_sp=_it[_a].indexOf("`");if(_sp!=-1){_tI=_it[_a];for(_b=_a;_b<_it.length;_b++){_tI+=";"+_it[_b+1];_a++;if(_it[_b+1].indexOf("`")!=-1)_b=_it.length}_it[_a]=_tI.replace(/`/g,"")}_sp=_it[_a].indexOf("=");if(_sp==-1){if(_it[_a])_si=_si+";"+_it[_a]}else{_si=_it[_a].slice(_sp+1);_w=_it[_a].slice(0,_sp);if(_w=="showmenu")_si=$tL(_si)}if(_it[_a]){_mi[_bl][_$S[_w]]=_si}}_m[_mn][0][_c-2]=_bl;_c++;_bl++}_c=0;function ami(txt){_t=this;if(_c==1){_c++;;_m[_mn]=new Array();_x=_m[_mn];;for($i in _t)_x[_$M[$i]]=_t[$i];_x[21]=-1;_x[0]=new Array();if(!_x[12])_x[12]=0;_MS=_m[_mn][6];_MN=_m[_mn];if(_MN[15]==_n)_MN[15]=_MS.overfilter;if(_MN[16]==_n)_MN[16]=_MS.outfilter;_MS[65]=(_MS.borderwidth)?parseInt(_MS.borderwidth):0;_MS[64]=_MS.borderstyle;_MS[63]=_MS.bordercolor;if(!_MS.built){lcl++;_vC=_MS.visitedcolor;if(_vC){_oC=_MS.offcolor;if(!_oC)_oC="#000000";if(!_vC)_vC="#ff0000";_Lcl="<style>.linkclass"+lcl+":link{color:"+_oC+"}.linkclass"+lcl+":visited{color:"+_vC+"}</style>";_d.write(_Lcl);_MS.linkclass="linkclass"+lcl}_MS.built=1}}_incItem(txt)}menuname.prototype.aI=ami;
function menuWebSubmit(nome_modulo,nome_titulo){
	var msg='<span style="font-size:18px;color:blue;"><blink>Carregando...</blink></span>';
	try { 
	    closeAllMenus();
	   // limpar a area dados/formulario
          var obj = document.getElementById('area_dados');
          if(!obj)
	   {
             obj=document.getElementById('dados');
          }
          if (obj)
          {
	      obj.innerHTML=msg;
          }
       } catch(e){}
	//	try { document.getElementById('div_formdin').innerHTML=msg;} catch(e){}
	try {
	  	document.menuweb_submit.modulo.value=nome_modulo;
	 	document.menuweb_submit.submit();
 	} catch(e) {
 	alert( 'Não foi possivel definir a variável módulo para: '+nome_modulo+'".\n'+
 	'Verifique se no formulario existe um <form> com o nome "menuweb_submit"\n'+
 	'contendo um campo hidden chamado "modulo" e id="modulo" ou \n'+
 	'utilize o metodo criarForm() da classe menuWeb para criar o formulario.');
 	}
	
}
