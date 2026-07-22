$('.selection').easySelectable({
	onSelecting: function(el){
		
		// whichWeek('add',$(el).attr('data-name'),$(el).attr('data-id'));
	},
	onSelected: function(el){
		var name  =  $(el).attr('data-name');
		var id = $(el).attr('data-id');
	    $("#"+name).val(function() {
	    	var str = this.value;
			var re = new RegExp(','+id,"g");
	        var newstr = str.replace(re, "");
	        return newstr +','+id;
	    });
		// console.log(el[0].innerHTML);
	},
	onUnSelected: function(el){
		var name  =  $(el).attr('data-name');
		var id = $(el).attr('data-id');
		$("#"+name).val(function() {
	        var str = this.value;
			var re = new RegExp(','+id,"g");
	        var newstr = str.replace(re, "");
	        return newstr;
	    });
		
		// whichWeek('remove',$(el).attr('data-name'),$(el).attr('data-id'));
	}
});