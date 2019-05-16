 
function myInput(){
	
	// INPUT
	$('input').focus(function(){
	  $(this).parents('.form-group').addClass('focused');
	});
	$('select').focus(function(){
	  $(this).parents('.form-group').addClass('focused');
	});
	$('textarea').focus(function(){
	  $(this).parents('.form-group').addClass('focused');
	});

	$('input').blur(function(){
	  var inputValue = $(this).val();
	  if ( inputValue == "" ) {
			$(this).removeClass('filled');
			$(this).parents('.form-group').removeClass('focused');  
			// $("#StartDate").removeClass('filled');
			// $("#StartDate").parents('.form-group').addClass('focused');
			// $("#EndDate").removeClass('filled');
			// $("#EndDate").parents('.form-group').addClass('focused');
				$("#datepicker1").removeClass('filled');
				$("#datepicker1").parents('.form-group').addClass('focused');
				$("#datepicker2").removeClass('filled');
				$("#datepicker2").parents('.form-group').addClass('focused');
				$(".timefocus1").removeClass('filled');
				$(".timefocus1").parents('.form-group').addClass('focused');
				$(".timefocus2").removeClass('filled');
				$(".timefocus2").parents('.form-group').addClass('focused');
				$(".instructorfocus").removeClass('filled');
				$(".instructorfocus").parents('.form-group').addClass('focused');
				$(".SingleUploadfocus").removeClass('filled');
				$(".SingleUploadfocus").parents('.form-group').addClass('focused');
				$(".CourseImagefocus").removeClass('filled');
				$(".CourseImagefocus").parents('.form-group').addClass('focused');
				$(".Videofocus").removeClass('filled');
				$(".Videofocus").parents('.form-group').addClass('focused');
		} else
		 {
				$(this).addClass('filled');
				// $("#StartDate").addClass('filled');
				// $("#StartDate").parents('.form-group').addClass('focused');
				// $("#EndDate").addClass('filled');
				// $("#EndDate").parents('.form-group').addClass('focused');
				$("#datepicker1").addClass('filled');
				$("#datepicker1").parents('.form-group').addClass('focused');
				$("#datepicker2").addClass('filled');
				$("#datepicker2").parents('.form-group').addClass('focused');
				$(".timefocus1").addClass('filled');
				$(".timefocus1").parents('.form-group').addClass('focused');
				$(".timefocus2").addClass('filled');
				$(".timefocus2").parents('.form-group').addClass('focused');
				$(".instructorfocus").addClass('filled');
				$(".instructorfocus").parents('.form-group').addClass('focused');
				$(".SingleUploadfocus").addClass('filled');
				$(".SingleUploadfocus").parents('.form-group').addClass('focused');
				$(".CourseImagefocus").addClass('filled');
				$(".CourseImagefocus").parents('.form-group').addClass('focused');
				$(".Videofocus").addClass('filled');
				$(".Videofocus").parents('.form-group').addClass('focused');
	  }
	//   $("#StartDate").addClass('filled');
	// $("#StartDate").parents('.form-group').addClass('focused');
	// $("#EndDate").addClass('filled');
	// $("#EndDate").parents('.form-group').addClass('focused');
	});
	$('textarea').blur(function(){
	  var inputValue = $(this).val();
	  if ( inputValue == "" ) {
		$(this).removeClass('filled');
		$(this).parents('.form-group').removeClass('focused');  
	  } else {
		$(this).addClass('filled');
	  }
	});
	$('select').blur(function(){
	  var inputValue = $(this).val();
	  if ( inputValue == "" ) {
		$(this).removeClass('filled');
		$(this).parents('.form-group').removeClass('focused');  
	  } else {
		$(this).addClass('filled');
	  }
	});

	
	$('input').each(function() { 
		
			if($(this).attr('ng-reflect-model')){
				 $(this).addClass('filled');
				$(this).parents('.form-group').addClass('focused');
			
			}
		});
		$('textarea').each(function() {
			if($(this).attr('ng-reflect-model')){
				 $(this).addClass('filled');
				$(this).parents('.form-group').addClass('focused');
			}
		});
		$('select').each(function() {
			if($(this).attr('ng-reflect-model')){
				 $(this).addClass('filled');
				$(this).parents('.form-group').addClass('focused');
			}
		});
	
		$('#CourseImageicon input[type="file"]').change(function(e){
			var fileName = e.target.files[0].name;
			$('#CourseImageicon input[type="text"]').val(fileName);
		});
		$('#Videoicon input[type="file"]').change(function(e){
			var fileName = e.target.files[0].name;
			$('#Videoicon input[type="text"]').val(fileName);
		});
		$('#MulVideoicon input[type="file"]').change(function(e){
			var fileName = e.target.files[0].name;
			$('#MulVideoicon input[type="text"]').val(fileName);
		});
		
			$('#UserImageIdIcon input[type="file"]').change(function(e){
				var fileName = e.target.files[0].name;
				$('#UserImageIdIcon input[type="text"]').val(fileName);
			});
	
			$('#CertificateIcon input[type="file"]').change(function(e){
				var fileName = e.target.files[0].name;
				$('#CertificateIcon input[type="text"]').val(fileName);
			});
		
			// $('.file_upload input[type="file"]').change(function(e){
				// var fileName = e.target.files[0].name;
				// $('.file_upload input[type="text"]').val(fileName);
			// });
	
	// END INPUT
	// DATE PICKER
// $('.form_date').datetimepicker({
// 	weekStart: 1,
// 	todayBtn:  1,
// autoclose: 1,
// todayHighlight: 1,
// startView: 2,
// minView: 2,
// forceParse: 0
// });
// END DATE PICKER
}

