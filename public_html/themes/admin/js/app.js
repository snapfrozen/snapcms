SnapCMS.processResponse = function(data) 
{
	//Update areas of the page with new content
	$.each(data.updateContent,function(key,value){
		var $elem = $('#'+key);
		$elem.fadeOut(function(){
			$elem.html(value);
			$elem.fadeIn();
		});
	});
}
SnapCMS.mergeOptions = function(obj1,obj2){
	var obj3 = {};
	for (var attrname in obj1) { obj3[attrname] = obj1[attrname]; }
	for (var attrname in obj2) { obj3[attrname] = obj2[attrname]; }
	return obj3;
};