(function ($) {
  Drupal.behaviors.ajaxpagination = {
    attach: function (context, settings) {
	console.log("data loaded");


		$('.pagination-link').click(function(){
		console.log("jfjffjfj");
		$('.pagination-link').removeClass('active');
		$(this).addClass('active');

		});

		// function preventDefaultClick(event) {
		// 	console.log(event);
		// 	var status = confirm('Are you sure you want to delete?');
		// 	if (!status) {
		// 		event.preventDefault();
		// 		return false;
		// 	}
		// 	return true;
		// }

	}
  };


})(jQuery);