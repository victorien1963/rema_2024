function provinceSelChange(selname,index,z,postid,addr,pro)
{	
	pList.getOptionAreasString(index,selname,z,0);
	pList.getPostString(index,0,postid,addr,pro);

}

function postSelChange(index,selpost,postid,addr,pro)
{	

	pList.getPostString(index,selpost,postid,addr,pro);

}

function area(name,code,post) 
{
   this.name=name;
   this.code=code;
   this.post=post;

}

function province(name,code) 
{
   this.data=new Array();
   this.name=name;
   this.code=code;
   this.add=area_add;

}
function provinceList() 
{
   this.data=new Array();
   this.add=province_add;
   this.addAt=province_addAt;
   this.getOptionString=provinceList_getOptionString;
   this.getOptionAreasString=provinceList_getAreasOptionString;
   this.getPostString=provinceList_getPostString;
}
function area_add(area)
{
	this.data[this.data.length]=area;
}
function province_add(province)
{
	this.data[this.data.length]=province;
}
function province_addAt(i,area)
{
	var province=this.data[i];
	province.add(area);
}
function provinceList_getOptionString(n)
{
	var temp="";
	for(var i=0;i<this.data.length;i++){
		if(i==n){
		temp+="<option value="+i+" selected>"+this.data[i].name;
		}else{
		temp+="<option value="+i+">"+this.data[i].name;
		
		}
	}
	return temp;
}
function provinceList_getAreasOptionString(index,selname,z,cs)
{
	var temp="";
	var prov=this.data[index];
	var getthiscode = "";
	
	if(prov==null || prov.data.length==0)
	{
		
		selname.length=1;
		selname.options[0].text="請選擇";
		selname.options[0].value="0";
		return "<option value=no>請選擇 </option>";
	}
	selname.length=0;
	for(var i=0;i<prov.data.length;i++)
	{
		if(cs==0){
		selname.length++;
		selname.options[i].text=prov.data[i].name;
		selname.options[i].value=prov.data[i].code;
		}

		if(prov.data[i].code==z){
			temp+="<option value="+prov.data[i].code+" selected>"+prov.data[i].name+"</option>";
		}else{
			temp+="<option value="+prov.data[i].code+">"+prov.data[i].name+"</option>";
		}
		
	}

	if(prov.data[0].name=="ALL"){
		if(typeof zonediv == "object"){
			zonediv.style.visibility="hidden";
		}
		if(typeof szonediv == "object"){
			szonediv.style.visibility="hidden";
		}
	}else{
		if(typeof zonediv == "object"){
			zonediv.style.visibility="visible";
		}
		if(typeof szonediv == "object"){
			szonediv.style.visibility="visible";
		}
	}
	

	return temp;
}

function provinceList_getPostString(index,selpost,postid,addr,pro)
{
		var prov=this.data[index];
		var getthiscode = "";
		
		for(var i=0;i<prov.data.length;i++)
		{
			if(prov.data[i].code==selpost){
				getthiscode = prov.data[i].post;
				getthisname = prov.data[i].name;
			}else if( selpost == 0 ){
				getthiscode = prov.data[0].post;
				getthisname = prov.data[0].name;
			}
		}
		
if( getthisname == "ALL"){ getthisname=""; getthiscode="";}
		
		addr.value = pro.options[pro.selectedIndex].text + getthisname;
		postid.value = getthiscode;
		

}


var pList=new provinceList();