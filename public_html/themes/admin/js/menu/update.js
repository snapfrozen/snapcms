$(document).ready(function() {
	var $tree = $('ul.sortable');
	$tree.nestedSortable({
			forcePlaceholderSize: true,
			handle: 'div',
			helper:	'clone',
			items: 'li',
			listType: 'ul',
			opacity: .6,
			placeholder: 'placeholder',
			revert: 250,
			tabSize: 25,
			tolerance: 'pointer',
			toleranceElement: '> div',
			//maxLevels: 3,	
			isTree: true,
			expandOnHover: 700,
			startCollapsed: true,
			branchClass: 'mjs-nestedSortable-branch',
			collapsedClass: 'collapsed',
			disableNestingClass: 'mjs-nestedSortable-no-nesting',
			errorClass: 'mjs-nestedSortable-error',
			expandedClass: 'expanded',
			hoveringClass: 'mjs-nestedSortable-hovering',
			leafClass: 'mjs-nestedSortable-leaf',
			stop:function(){
				updateToggles($tree);
			}
	});
	
	//Prevent bubble to prevent draging item when clicking close toggle
	$('ul.sortable span.disclose, ul.sortable a').on('mousedown', function() {
		return false;
	});
	
	$('span.disclose').on('click', function() {
		var $li = $(this).closest('li');
		$li.toggleClass('collapsed').toggleClass('expanded');
		return false;
	})
	//$('span.disclose').trigger('click');
	updateToggles($tree);
	
	$('a#saveMenu').click(function() {
		//var idList = $('ul.sortable').nestedSortable('toArray',{attribute:'rel',expression:(/(.+)/)});
		var idList = buildTreeList($("ul.sortable").eq(0));

		$.ajax({
			type:"POST",
			dataType:"json",
			data:{
				items:idList
			},
			url:SnapCMS.baseUrl + "/menu/updateStructure/id/" + SnapCMS.menuId,
			success:function(data){
				SnapCMS.processResponse(data);
			}
		});
	});
	
	//nestedSortable has a function which does something similar.. but it's broken
	function buildTreeList($elem)
	{
		var list = [];
		$elem.find('> li').each(function(){

			var item = {};
			item.id = $(this).data('id');

			if($(this).find('> ul > li').length > 0) {
				item.children = buildTreeList($(this).find('> ul'));
			}

			list.push(item);

		});	
		return list;
	}
	
	function updateToggles($tree) {
		$tree.find('li').each(function(){
			var $elem=$(this);
			if($elem.find('> ul > li').length >= 1) {
				$elem.find('.disclose .glyphicon').show();
			} else {
				$elem.find('.disclose .glyphicon').hide();
			}
		});
	}
});