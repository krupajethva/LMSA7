import { Component, OnInit, ElementRef } from '@angular/core';
import { Globals } from '.././globals';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { CourseService } from '../services/course.service';
import { CourseSchedulerService } from '../services/course-scheduler.service';
import { IOption } from 'ng-select';
declare var CKEDITOR, PerfectScrollbar: any;
declare function myInput(): any;
declare var $, Bloodhound, swal: any;
declare var getAccordion, Dropzone: any;

@Component({
	selector: 'app-course',
	templateUrl: './course.component.html',
	styleUrls: ['./course.component.css']
})
export class CourseComponent implements OnInit {
	First1;
	singal;
	secondform;
	thirdform;
	fifthform;
	CourseEntity;
	ImageEntity;
	SubCategoryList;
	submitted;
	ParentList;
	ImageList;
	forthform;
	btn_disable;
	header;
	firstform;
	CourseFormList;
	skillsValid;
	ImageValid;
	badgeValid;
	MediaValid;
	VideoValid;
	TimeValid;
	VideoList;
	SubtopicList;
	schedularList;
	CountryList;
	stateList;
	InstructorList;
	InstructorListone
	CourseSchedulerEntity;
	array_data;
	stateList_temp;
	SDateValid;
	EDateValid;
	STimeValid;
	ETimeValid;
	InstructorList_temp;
	CourseCloseDateValid;
	InstructorValid;
	CourseList;
	aa;
	editsave;
	BadgesEntity;
	badgehide;
	selebadge;
	Bimageid;
	imageshow;
	DefalutBadges;
	urlid;
	validadd;
	menushow;
	tab1;
	tab2;
	tab3;
	tab4;
	tab5;
	autocompleteItems;
	constructor(public globals: Globals, private router: Router, private elem: ElementRef, private route: ActivatedRoute,
		private CourseService: CourseService, private CourseSchedulerService: CourseSchedulerService) { }
	//selectedCharacters: Array<string> = ['376'];
	//schedularList[i].Instructor: Array<string> = ['376'];
	selectedCharacters: Array<IOption> = [this.globals.authData.UserId];
	ngOnInit() {
		this.VideoValid = [];
		this.BadgesEntity = {};
		this.badgehide = false;
		this.imageshow = false;

		// $('.file_upload input[type="file"]').change(function (e) {
		// 	var fileName = e.target.files[0].name;
		// 	$('.file_upload input[type="text"]').val(fileName);
		// });




		// var Keyword = new Bloodhound({
		// 	datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
		// 	queryTokenizer: Bloodhound.tokenizers.whitespace,
		// 	prefetch: {
		// 		url: this.globals.baseAPIUrl + 'Course/skillsData',
		// 		filter: function (list) {
		// 			return $.map(list, function (cityname) {
		// 				return { name: cityname };
		// 			});
		// 		}
		// 	}
		// });		
		// Keyword.initialize();
		// $('#tagsinput').tagsinput({
		// 	typeaheadjs: {
		// 		name: 'Keyword',
		// 		displayKey: 'name',
		// 		valueKey: 'name',
		// 		source: Keyword.ttAdapter()
		// 	}
		// });
		//course session time picker


		// getAccordion("#tabs", 768);


		setTimeout(function () {

			$('#CourseImage').change(function (e) {
				var file = e.target.files[0];
				var reader = new FileReader();
				reader.onloadend = function () {

					$(".link").attr("href", reader.result);
					$(".link").text(reader.result);

				}
				reader.readAsDataURL(file);
			});
			$('#badgeImage').change(function (e) {


				var file = e.target.files[0];
				var reader = new FileReader();
				reader.onloadend = function () {

					$(".link1").attr("href", reader.result);
					$(".link1").text(reader.result);

				}
				reader.readAsDataURL(file);
			});

			//script for image selection for badge
			// add/remove checked class
			$(".image-radio").each(function () {
				if ($(this).find('input[type="radio"]').first().attr("checked")) {
					$(this).addClass('image-radio-checked');
				} else {
					$(this).removeClass('image-radio-checked');
				}
			});

			// sync the input state
			$(".image-radio").on("click", function (e) {
				$(".image-radio").removeClass('image-radio-checked');
				$(this).addClass('image-radio-checked');
				var name = $(this).attr('name');
				$("input[name='selectbages']").val(name);
				//$('#badgeImageicon input[type="text"]').val(name);
				var $radio = $(this).find('input[type="radio"]');
				$radio.prop("checked", !$radio.prop("checked"));

				e.preventDefault();
			});
			//script for image selection for badge
			$('#SubTopicTime00').durationPicker({ showSeconds: true, checkRanges: true, totalMax: 259200000 /* 3 days */ });

			//course session time picker


			//for single file upload
			$('.modal_fileupload #CourseImage').change(function (e) {
				var fileName = e.target.files[0].name;

				$('#modalfiletext').val(fileName);
				$('#myModal').modal('hide');
			});
			$('.modal_fileupload #Video').change(function (e) {
				var fileName = e.target.files[0].name;

				$('#modalfilevideo').val(fileName);
				$('#myModal1').modal('hide');
			});
			$('.modal_fileupload #badgeImage').change(function (e) {
				var fileName = e.target.files[0].name;

				$('#modalfilebadge').val(fileName);
				$('#myModal3').modal('hide');
			});
		}, 500);
		//for single file upload

		setTimeout(function () {

			function toggleIcon(e) {
				$(e.target)
					.prev('.panel-heading')
					.find(".more-less")
					.toggleClass('glyphicon-plus glyphicon-minus');
			}
			$('.panel-group').on('hidden.bs.collapse', toggleIcon);
			$('.panel-group').on('shown.bs.collapse', toggleIcon);

		}, 500);
		// $('#myModal2').modal('show');
		// $('.right_content_block').addClass('style_position');
		//start course tabs

		//Initialize tooltips
		$('.nav-tabs > li a[title]').tooltip();

		//Wizard
		$('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

			var $target = $(e.target);

			if ($target.parent().hasClass('disabled')) {
				return false;
			}
		});

		// $(".next-step").click(function (e) {

		// 	var $active = $('.wizard .nav-tabs li.active');
		// 	$active.next().removeClass('disabled');
		// 	nextTab($active);

		// });
		// $(".prev-step").click(function (e) {

		// 	var $active = $('.wizard .nav-tabs li.active');
		// 	prevTab($active);

		// });

		function nextTab(elem) {
			$(elem).next().find('a[data-toggle="tab"]').click();
		}
		function prevTab(elem) {
			$(elem).prev().find('a[data-toggle="tab"]').click();
		}

		//end course tabs

		//script for available sessions
		// setTimeout(function () {

		// }, 200);
		//scripts for available sessions


		// course session
		this.submitted = false;
		this.SDateValid = [];
		this.EDateValid = [];
		this.STimeValid = [];
		this.ETimeValid = [];
		this.InstructorValid = [];
		this.CourseCloseDateValid = [];
		this.array_data = [];
		this.stateList = [];
		this.stateList[0] = [];
		this.CourseSchedulerEntity = {};
		this.InstructorList = {};
		this.CourseList = {};

		setTimeout(function () {

			$('.form_time').datetimepicker({
				weekStart: 1,
				todayBtn: 0,
				autoclose: 1,
				startView: 1,
				maxView: 1,
				forceParse: 1,
				format: 'HH:ii p',
				pickDate: false,
				showMeridian: true,
			}).on('hide', function (ev) {
				$(".datetimepicker .prev").attr("style", "visibility:visible");
				$(".datetimepicker .next").attr("style", "visibility:visible");
				$(".switch").attr("style", "pointer-events: auto");
			});
			$(".form_time").click(function () {
				$(".datetimepicker .prev").attr("style", "visibility:hidden");
				$(".datetimepicker .next").attr("style", "visibility:hidden");
				$(".switch").attr("style", "pointer-events: none");
			});
			new PerfectScrollbar('.imageselectionmodal');
			new PerfectScrollbar('.mediaselectionmodal');
			new PerfectScrollbar('#mediascrollbar00');

		}, 500);
		//time picker for course session

		// setTimeout(function () {
		// 	$('.sub_upload input[type="file"]').change(function (e) {
		// 		var fileName = e.target.files[0].name;
		// 		$('.sub_upload input[type="text"]').val(fileName);
		// 	});
		// }, 500);
		//end single file uploader for course session
		debugger
		this.Bimageid = false;
		this.firstform = true;
		this.singal = false;
		this.editsave = false;
		this.CourseEntity = {};
		this.CourseEntity.TopicId = 0;
		this.CourseEntity.IsActive = 1;
		//ischecked
		var subtopic = [];
		var item1 = {
			'SubTopicName': '', 'SubTopicTime': '', 'SubTopicDescription': '', 'Video': '', 'ResourcesId3': '',
			'hh': '', 'mm': ''
		};
		subtopic.push(item1);
		var item = { 'TopicName': '', 'subtopic': subtopic };
		this.CourseFormList = [];
		this.SubtopicList = [];
		this.CourseFormList.push(item);
		console.log(this.CourseFormList);
		this.CourseFormList[0].subtopic[0].VideoValid = false;

		this.CourseService.getAllParent()
			//.map(res => res.json())
			.then((data) => {
				this.SubCategoryList = data['sub'];
			},
				(error) => {
					alert('error');
					this.router.navigate(['/pagenotfound']);
				});



		this.CourseService.getAllimage(this.globals.authData.UserId)
			//.map(res => res.json())
			.then((data) => {debugger
				this.ImageList = data['image'];
				this.VideoList = data['video'];
				this.DefalutBadges = data['defalutbadge'];

	
				this.BadgesEntity.BadgeImageId = this.DefalutBadges[0].ResourcesId;
				this.BadgesEntity.ResourcesId = this.DefalutBadges[0].ResourcesId;
			

			},
				(error) => {
					//	alert('error');

					this.router.navigate(['/pagenotfound']);
				});
				this.CourseService.skillsData()
				.then((data) => {
					debugger
					this.autocompleteItems = data;
				},
					(error) => {
						//alert('error');
						this.btn_disable = false;
						this.submitted = false;
						//this.router.navigate(['/pagenotfound']);
					});
		this.CourseSchedulerService.getAllDefaultData()
			//.map(res => res.json())
			.then((data) => {
				this.CountryList = data['country'];
				this.stateList_temp = data['state'];
				this.InstructorList = data['instructor'];
				this.InstructorListone = data['instructor1'];

				let id = this.route.snapshot.paramMap.get('id');
				let name = this.route.snapshot.paramMap.get('name');


				if (id) {
					this.urlid = id;
					this.CourseEntity.CourseId = id;

					this.tab1 = true;
					this.tab2 = true;
					this.tab3 = true;
					this.tab4 = true;
					this.tab5 = true;
					if (name) {
						this.firstform = false;
						this.secondform = false;
						this.thirdform = true;
						this.forthform = false;
						this.imageshow = true;

						this.addSession(id);
					} else {
						this.firstform = true;
						this.imageshow = true;
						this.secondform = false;
						this.thirdform = false;
						this.forthform = false;

					}



					this.menushow = true;
					this.singal = true;
					this.editsave = true;
					this.header = 'Edit';
					this.CourseService.getById(id)
						.then((data) => {
							debugger
							if (name) {
								$('#st3').removeClass('success');
								$('#st3').addClass('active');
								$('#step3').addClass('active');
								$('#st2').addClass('success');
								$('#st1').addClass('success');
								$('#st4').addClass('success');
								$('#st5').addClass('success');
							}
							else {
								$('#st2').addClass('success');
								$('#st3').addClass('success');
								$('#st4').addClass('success');
								$('#st5').addClass('success');
							}
							this.CourseEntity = data;
							if(this.CourseEntity.Keyword!=null){
								this.CourseEntity.Keyword = this.CourseEntity.Keyword.split(","); 	//convert comma seperated string to array
							}
							if(this.CourseEntity.AssessmentTime != null)
							{		
								var time = this.CourseEntity.AssessmentTime.split(':');
								this.CourseEntity.AssessmentHour = time[0];
								this.CourseEntity.AssessmentMinute = time[1];
								this.CourseEntity.AssessmentSecond = time[2];
							}
							if (data['IsActive'] == 0) { this.CourseEntity.IsActive = 0; } else { this.CourseEntity.IsActive = '1'; }
							if (data['Featurescheck'] == 0) { this.CourseEntity.Featurescheck = 0; } else { this.CourseEntity.Featurescheck = '1'; }
							if (data['whatgetcheck'] == 0) { this.CourseEntity.whatgetcheck = 0; } else { this.CourseEntity.whatgetcheck = '1'; }
							if (data['Targetcheck'] == 0) { this.CourseEntity.Targetcheck = 0; } else { this.CourseEntity.Targetcheck = '1'; }
							if (data['Morecheck'] == 0) { this.CourseEntity.Morecheck = 0; } else { this.CourseEntity.Morecheck = '1'; }
							if (data['Requirementcheck'] == 0) { this.CourseEntity.Requirementcheck = 0; } else { this.CourseEntity.Requirementcheck = '1'; }
							$('#CourseImageicon input[type="text"]').val(this.CourseEntity.CourseImage);
							$('#Videoicon input[type="text"]').val(this.CourseEntity.Video);
							this.imageshow = true;
							setTimeout(function () {

								myInput();
								$(".CourseImagefocus").addClass('filled');
								$(".CourseImagefocus").parents('.form-group').addClass('focused');
								$(".Videofocus").addClass('filled');
								$(".Videofocus").parents('.form-group').addClass('focused');

							}, 100);
						},
							(error) => {
								//alert('error');
								this.btn_disable = false;
								this.submitted = false;
								//this.router.navigate(['/pagenotfound']);
							});
					this.CourseService.getByTopicId(id)
						.then((data) => {
							debugger
							this.CourseFormList = data;
							if (this.CourseFormList.length > 0) {
								this.CourseFormList = data;

								setTimeout(function () {

									myInput();
									$(".SingleUploadfocus").addClass('filled');
									$(".SingleUploadfocus").parents('.form-group').addClass('focused');
								}, 100);

							} else {
								var subtopic = [];
								var item1 = {
									'SubTopicName': '', 'SubTopicTime': '', 'SubTopicDescription': '', 'Video': '', 'ResourcesId3': '',
									'hh': '', 'mm': ''
								};
								subtopic.push(item1);
								var item = { 'TopicName': '', 'subtopic': subtopic };
								this.CourseFormList.splice(this.CourseFormList.length, 0, item);
								setTimeout(function () {

									$('.modal').on('shown.bs.modal', function () {
										$('.right_content_block').addClass('style_position');
									})
									$('.modal').on('hidden.bs.modal', function () {
										$('.right_content_block').removeClass('style_position');
									});
									$('.form_time_picker').click(function () {
										$('.switch').addClass('no_time_click');
									});

									myInput();
									new PerfectScrollbar('#mediascrollbar');
								}, 100);
								// var subtopic = [];
								// var item1 = {
								// 	'SubTopicName': '', 'SubTopicTime': '', 'SubTopicDescription': '', 'Video': '', 'ResourcesId3': '',
								// 	'hh': '', 'mm': ''
								// };
								// subtopic.push(item1);
								// var item = { 'TopicName': '', 'subtopic': subtopic };
								// this.CourseFormList = [];
								// this.SubtopicList = [];
								// this.CourseFormList.push(item);
								// console.log(this.CourseFormList);
								// this.CourseFormList[0].subtopic[0].VideoValid = false;
								// setTimeout(function () {

								// 	myInput();
								// 	$(".SingleUploadfocus").addClass('filled');
								// 	$(".SingleUploadfocus").parents('.form-group').addClass('focused');
								// }, 100);

							}



						},
							(error) => {
								//alert('error');
								this.btn_disable = false;
								this.submitted = false;
								//this.router.navigate(['/pagenotfound']);
							});
					this.CourseSchedulerService.getById(id, this.globals.authData.UserId)
						.then((data) => {
							debugger

							this.array_data = data['coursesession'];
							this.schedularList = data['coursesession'];
							for (var i = 0; i < this.array_data.length; i++) {
								this.stateList[i] = this.stateList_temp;
								this.schedularList[i].checkvalid = true;
								if(this.schedularList[i].PublishStatus==1)
								{
									this.schedularList[i].PublishStatus=1;}else
								{this.schedularList[i].PublishStatus=0;}
								if (this.schedularList[i].IsActive == 0) { this.schedularList[i].IsActive = 0; } else { this.schedularList[i].IsActive = '1'; }
								if (this.schedularList[i].monday == "0") { this.schedularList[i].monday = 0; } else { this.schedularList[i].monday = '1'; }
								if (this.schedularList[i].tuesday == "0") { this.schedularList[i].tuesday = 0; } else { this.schedularList[i].tuesday = '1'; }
								if (this.schedularList[i].wednesday == "0") { this.schedularList[i].wednesday = 0; } else { this.schedularList[i].wednesday = '1'; }
								if (this.schedularList[i].thursday == "0") { this.schedularList[i].thursday = 0; } else { this.schedularList[i].thursday = '1'; }
								if (this.schedularList[i].friday == "0") { this.schedularList[i].friday = 0; } else { this.schedularList[i].friday = '1'; }
								if (this.schedularList[i].saturday == "0") { this.schedularList[i].saturday = 0; } else { this.schedularList[i].saturday = '1'; }
								if (this.schedularList[i].sunday == "0") { this.schedularList[i].sunday = 0; } else { this.schedularList[i].sunday = '1'; }
							}

							this.CourseList = data['coursename'];
							// this.schedularList = data['coursesession'];

							this.globals.isLoading = false;

							setTimeout(function () {
								
								$(".instructorfocus").addClass('filled');
								$(".instructorfocus").parents('.form-group').addClass('focused');
								$('.form_time_picker').datetimepicker({
									weekStart: 1,
									todayBtn: 0,
									autoclose: true,
									todayHighlight: 0,
									startView: 1,
									//minView: 1,
									//maxView: 1,
									forceParse: 0,

									format: 'HH:ii P',
									showMeridian: true,
									pickDate: false,
									pickTime: true,
									pickerPosition: 'top-left'
								});

								// $('.form_time_picker').click(function () {
								// 	$('.switch').addClass('no_time_click');
								// });
								$('.form_time_picker').click(function () {
									$('.table-condensed thead tr').empty();
									$('.table-condensed thead tr').append('<th class="switch no_time_click">Pick Time</th>');
								});
								myInput();
							}, 100);
							setTimeout(function () {
								$('.form_date').datetimepicker({
									weekStart: 1,
									todayBtn: 1,
									autoclose: 1,
									todayHighlight: 1,
									startDate: '-0d',
									startView: 2,
									minView: 2,
									forceParse: 0,
									pickTime: false,
									format: 'yyyy/mm/dd',
								});
							}, 100);
						},
							(error) => {
								//alert('error');
								this.btn_disable = false;
								this.globals.isLoading = false;
								this.submitted = false;
								//this.router.navigate(['/pagenotfound']);
							});
					this.CourseService.badgegetById(id)
						.then((data) => {
							debugger
							this.BadgesEntity = data;
							if (this.BadgesEntity == null) {
								this.BadgesEntity = {};
								this.BadgesEntity.badgeletter = '';

							} else {
								this.Bimageid = true;
								this.BadgesEntity = data;
								this.BadgesEntity.BadgeImageId = this.BadgesEntity.BadgeImageId;
							}
						},
							(error) => {
								//alert('error');
								this.btn_disable = false;
								this.submitted = false;
								//this.router.navigate(['/pagenotfound']);
							});

				}
				else {

					this.urlid = 0;
					debugger
					var itemq = {
						'IsActive': 1, 'SessionName': 'session', 'StartTime': '', 'EndTime': '',
						'Location': '', 'StartDate': '', 'EndDate': '', 'Instructor': '', 'Instructorone': '', 'CountryId': '', 'StateId': '',
						'CourseCloseDate': '', 'Showstatus': '0', 'TotalSeats': '', 'Check': false, 'CourseSessionId': '0'
					};
					this.stateList = [];
					this.stateList[0] = [];
					// this.InstructorList = [];
					// this.InstructorList[0] = [];
					this.schedularList = [];


					this.schedularList.push(itemq);

					//this.schedularList.CourseSessionId = 0;
					var index = this.schedularList.length - 1;
					for (var i = 0; i < this.InstructorListone.length; i++) {
						if (this.globals.authData.RoleId == 3) {
							if (this.InstructorListone[i].value == this.globals.authData.UserId) {
								this.schedularList[0].Instructorone = this.InstructorListone[i].value;
							} else {

							}
						}

					}
					this.schedularList[0].STimeValid = false;
					this.schedularList[0].ETimeValid = false;
					this.schedularList[0].InstructorValid = false;
					this.schedularList[0].SDateValid = false;
					this.schedularList[0].EDateValid = false;
					this.schedularList[0].CourseCloseDateValid = false;
					this.schedularList[0].checkvalid = false;
					this.schedularList[0].SessionStatus = 0;
					this.schedularList[0].PublishStatus = 0;
					this.schedularList[0].CourseSessionId = 0;


					setTimeout(function () {
						$('#badg0').addClass('image-radio-checked');
						function toggleIcon(e) {
							$(e.target)
								.prev('.panel-heading')
								.find(".more-less")
								.toggleClass('glyphicon-plus glyphicon-minus');
						}
						$(".instructorfocus").removeClass('filled');
						$(".instructorfocus").parents('.form-group').addClass('focused');
						$('.panel-group').on('hidden.bs.collapse', toggleIcon);
						$('.panel-group').on('shown.bs.collapse', toggleIcon);
						$('#daily_recurrence' + index).removeClass('hide');
						$('.range_recurrence' + index).removeClass('hide');
						$('.form_time_picker').datetimepicker({
							weekStart: 1,
							todayBtn: 0,
							autoclose: true,
							todayHighlight: 0,
							startView: 1,
							//minView: 1,
							//maxView: 1,
							forceParse: 0,
							format: 'HH:ii P',
							showMeridian: true,
							pickDate: false,
							pickTime: true,
							pickerPosition: 'top-left'
						});

						$('.form_date').datetimepicker({
							weekStart: 1,
							todayBtn: 1,
							autoclose: 1,
							todayHighlight: 1,
							startDate: '-0d',
							startView: 2,
							minView: 2,
							forceParse: 0,
							pickTime: false,
							format: 'yyyy/mm/dd',
						});
						myInput();
					}, 100);


					setTimeout(function () {

						$('.form_time_picker').click(function () {
							$('.table-condensed thead tr').empty();
							$('.table-condensed thead tr').append('<th class="switch no_time_click">Pick Time</th>');
						}); myInput();
					}, 100);


					this.tab1 = true;
					this.tab2 = false;
					this.tab3 = false;
					this.tab4 = false;
					this.tab5 = false;
					this.menushow = false;
					this.header = 'Add';
					this.CourseEntity = {};
					this.CourseEntity.CourseId = 0;
					this.CourseEntity.IsActive = 1;
					this.CourseEntity.Featurescheck = true;
					this.CourseEntity.whatgetcheck = true;
					this.CourseEntity.Targetcheck = true;
					this.CourseEntity.Requirementcheck = true;
					this.CourseEntity.Morecheck = true;


				}






			},
				(error) => {
					//alert('error');
					this.globals.isLoading = false;
					this.router.navigate(['/pagenotfound']);
				});


		// Nirav



		// setTimeout(function () {


		// }, 500);

		setTimeout(function () {


			$('.modal').on('shown.bs.modal', function () {
				$('.right_content_block').addClass('style_position');
			})
			$('.modal').on('hidden.bs.modal', function () {
				$('.right_content_block').removeClass('style_position');
			});

			$('.form_time_picker').click(function () {
				$('.switch').addClass('no_time_click');
			});
			$(".datetimepicker").find('thead th').remove();
			$(".datetimepicker").find('thead').append($('<th class="switch">').text('Pick Time'));
			$(".courses").addClass("active");
			$(".courses > div").addClass("in");
			$(".courses > a").removeClass("collapsed");
			$(".courses > a").attr("aria-expanded", "true");
			$('#Document0').imageuploadify();
			$('#MulVideo0').imageuploadify();

			CKEDITOR.replace('EmailBody', {
				height: '100',
				resize_enabled: 'false',
				resize_maxHeight: '100',
				resize_maxWidth: '948',
				resize_minHeight: '100',
				resize_minWidth: '948',
				extraAllowedContent: 'span;ul;li;table;td;style;*[id];*(*);*{*}',
				enterMode: Number(2)
				//extraAllowedContent: 'style;*[id,rel](*){*}
			});

			CKEDITOR.replace('EmailBodyW', {
				height: '100',
				resize_enabled: 'false',
				resize_maxHeight: '100',
				resize_maxWidth: '948',
				resize_minHeight: '100',
				resize_minWidth: '948',
				extraAllowedContent: 'span;ul;li;table;td;style;*[id];*(*);*{*}',
				enterMode: Number(2)
				//extraAllowedContent: 'style;*[id,rel](*){*}
			});

			CKEDITOR.replace('EmailBodyT', {
				height: '100',
				resize_enabled: 'false',
				resize_maxHeight: '100',
				resize_maxWidth: '948',
				resize_minHeight: '100',
				resize_minWidth: '948',
				extraAllowedContent: 'span;ul;li;table;td;style;*[id];*(*);*{*}',
				enterMode: Number(2)
				//extraAllowedContent: 'style;*[id,rel](*){*}
			});

			CKEDITOR.replace('EmailBodyM', {
				height: '100',
				resize_enabled: 'false',
				resize_maxHeight: '100',
				resize_maxWidth: '948',
				resize_minHeight: '100',
				resize_minWidth: '948',
				extraAllowedContent: 'span;ul;li;table;td;style;*[id];*(*);*{*}',
				enterMode: Number(2)
				//extraAllowedContent: 'style;*[id,rel](*){*}
			});
			CKEDITOR.replace('Requirement1', {
				height: '100',
				resize_enabled: 'false',
				resize_maxHeight: '100',
				resize_maxWidth: '948',
				resize_minHeight: '100',
				resize_minWidth: '948',
				extraAllowedContent: 'span;ul;li;table;td;style;*[id];*(*);*{*}',
				enterMode: Number(2)
				//extraAllowedContent: 'style;*[id,rel](*){*}
			});
			CKEDITOR.replace('EmailBody1', {
				height: '100',
				resize_enabled: 'false',
				resize_maxHeight: '100',
				resize_maxWidth: '948',
				resize_minHeight: '100',
				resize_minWidth: '948',
				extraAllowedContent: 'span;ul;li;table;td;style;*[id];*(*);*{*}',
				enterMode: Number(2)
				//extraAllowedContent: 'style;*[id,rel](*){*}
			}); myInput();

			$('.form_date').datetimepicker({
				weekStart: 1,
				todayBtn: 1,
				autoclose: 1,
				todayHighlight: 1,
				startDate: '-0d',
				startView: 2,
				//minView: 2,
				forceParse: 0,
				format: 'mm/dd/yyyy hh:ii',
				showMeridian: true,

			});


			new PerfectScrollbar('.imageselectionmodal');
			new PerfectScrollbar('.mediaselectionmodal');
			new PerfectScrollbar('#mediascrollbar00');
		}, 100);
		// var Keyword = new Bloodhound({
		// 	datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
		// 	queryTokenizer: Bloodhound.tokenizers.whitespace,
		// 	prefetch: {
		// 		url: this.globals.baseAPIUrl + 'Course/skillsData',
		// 		filter: function (list) {
		// 			return $.map(list, function (cityname) {
		// 				return { name: cityname };
		// 			});
		// 		}
		// 	}
		// });
		// Keyword.initialize();
		// $('#tagsinput').tagsinput({
		// 	typeaheadjs: {
		// 		name: 'Keyword',
		// 		displayKey: 'name',
		// 		valueKey: 'name',
		// 		source: Keyword.ttAdapter()
		// 	}
		// });


		// PERFECT SCROLLBAR

		// END PERFECT SCROLLBAR


	}


	replaceBadges(Badge) {
		this.BadgesEntity.BadgeImageId = Badge.ResourcesId;
		this.BadgesEntity.ResourcesId = Badge.ResourcesId;
		//	alert(this.BadgesEntity.BadgeImageId);
	}
	imagemodalshow() {
		$('#myModal').modal('show');
	}
	videomodalshow() {
		$('#myModal1').modal('show');
	}
	singleupload(i, j) {
		$('#myModal2' + i + j).modal('show');
		$('#MulVideoiconn' + i + j).focus(function () {
			$(this).parents('.form-group').addClass('focused');
		});
		setTimeout(function () {
			$('.modal').on('shown.bs.modal', function () {
				$('.right_content_block').addClass('style_position');
			})
			$('.modal').on('hidden.bs.modal', function () {
				$('.right_content_block').removeClass('style_position');
			});
			new PerfectScrollbar('#mediascrollbar' + i + j);
			myInput();
		}, 100);

	}
	// onChange(Instructorone,j)
	// { debugger
	// 	//alert(Instructorone);

	// 	for (var i = 0; i < this.InstructorList.length; i++) 
	// 	{

	// 		if(this.InstructorList[i].value==Instructorone)
	// 		{
	// 			this.schedularList[j].InstSec = false;
	// 			this.InstructorList.splice(i, 1);
	// 			this.schedularList[j].InstSec = true;
	// 		}
	// 		//console.log(this.InstructorList);
	// 	}
	// 	setTimeout(function () {	

	// 	}, 100);


	// }


	close(i, j) {
		$('#myModal2' + i + j).modal('hide');
	}

	addSession(course_id) {
		debugger

		//.tab3=true;
		$('#st3').addClass('active');
		$('#step3').addClass('active');
		$('#step2').removeClass('active');
		this.tab3 = true;
		$('#st2').addClass('success');
		$('#st3').removeClass('success');
		$('#st2').removeClass('active');
		//this.selectedCharacters: Array<string> = this.globals.authData.UserId;

		this.CourseSchedulerEntity.CourseId = course_id;

	}
	imagecl(image, i) {
		debugger
		this.CourseEntity.image = image.FilePath;
		$('.imageremove').removeClass('active');
		$('#test' + i).addClass('active');
		this.CourseEntity.ResourcesId1 = image.ResourcesId;
		$('#CourseImageicon input[type="text"]').val(this.CourseEntity.image);

		$('#myModal').modal('hide');
		//	alert(this.CourseEntity.image);
		//$('#CourseImage').html(this.CourseEntity.image);
		//$('#CourseImageicon input[type="text"]').val(this.CourseEntity.image);
	}
	// imagesubmit() {
	// 	$('#CourseImageicon input[type="text"]').val(this.CourseEntity.image);
	// 	// $('.modal-dialog').hide();
	// 	// $('.right_content_block').removeClass('style_position');


	// }
	Videocl(Video, i, j) {
		debugger
		this.CourseEntity.Video = Video.FilePath;
		$('.Videoremove').removeClass('active');
		$('#Videoactive' + i + j).addClass('active');
		this.CourseEntity.ResourcesId2 = Video.ResourcesId;
		$('#Videoicon input[type="text"]').val(this.CourseEntity.Video);
		$('#myModal1').modal('hide');
		//	alert(this.CourseEntity.image);
		//$('#CourseImage').html(this.CourseEntity.image);
		//$('#CourseImageicon input[type="text"]').val(this.CourseEntity.image);
	}
	SubTopicVideo(i, j, k, Video) {
		debugger
		this.CourseFormList[i].subtopic[j].ResourcesId3 = Video.ResourcesId;
		setTimeout(function () {
			$('.Videoremove').removeClass('active');
			$('#Videoactive' + i + j + k).addClass('active');
			$('#MulVideoiconn' + i + j + ' input[type="text"]').val(Video.FilePath);
			$('#myModal2' + i + j).modal('hide');

		}, 100);
	}

	// Videosubmit() {
	// 	$('#Videoicon input[type="text"]').val(this.CourseEntity.Video);

	// }
	subtopicchange(Video, i, j) {
		debugger

		// var fileName = e.target.files[0].name;
		// $('#MulVideoiconn' + i + j + ' input[type="text"]').val(fileName);
		setTimeout(function () {


			var text = Video.model;
			text = text.substring(text.lastIndexOf("\\") + 1, text.length);
			$('#modalfilesingle' + i + j).val(text);
			$('#myModal2' + i + j).modal('hide');


			// });
		}, 100);
	}

	AddSubTopic(i, j) {

		debugger
		//var subtopic = [];
		var item1 = {
			'SubTopicName': '', 'SubTopicTime': '', 'SubTopicDescription': '', 'Video': '', 'ResourcesId3': '',
			'hh': '', 'mm': ''
		};
		//subtopic.push(item1);

		this.CourseFormList[i].subtopic.splice(this.CourseFormList[i].subtopic.length, 0, item1);
		this.CourseFormList[i].subtopic[j].VideoValid = false;
		this.CourseFormList[i].subtopic[j].TimeValid = false;

		setTimeout(function () {
			$('#Video' + i + j).imageuploadify();

			$('.modal').on('shown.bs.modal', function () {
				$('.right_content_block').addClass('style_position');
			})
			$('.modal').on('hidden.bs.modal', function () {
				$('.right_content_block').removeClass('style_position');
			});

			$('.form_time').datetimepicker({
				weekStart: 1,
				todayBtn: 0,
				autoclose: 1,
				startView: 1,
				maxView: 1,
				forceParse: 1,
				format: 'HH:ii p',
				pickDate: false,
				showMeridian: true,
			}).on('hide', function (ev) {
				$(".datetimepicker .prev").attr("style", "visibility:visible");
				$(".datetimepicker .next").attr("style", "visibility:visible");
				$(".switch").attr("style", "pointer-events: auto");
			});
			$(".form_time").click(function () {
				$(".datetimepicker .prev").attr("style", "visibility:hidden");
				$(".datetimepicker .next").attr("style", "visibility:hidden");
				$(".switch").attr("style", "pointer-events: none");
			});
			$('.form_time_picker').click(function () {
				$('.switch').addClass('no_time_click');
			});


			new PerfectScrollbar('#mediascrollbar' + i + j);
			//new PerfectScrollbar('#mediascrollbar02');
			myInput();
		}, 100);


	}
	DeleteSubTopic(item, i, j) {
		debugger

		// var index = this.CourseFormList[i].subtopic.indexOf(j);
		// this.CourseFormList[i].subtopic.splice(index, 1);
		swal({
			title: 'Delete a Course Sub Topic?',
			text: "Are you sure you want to delete this course sub topic?",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes'
		})
			.then((result) => {
				if (result.value) {
					//var del = { 'TopicId': TopicId, 'UserId': this.globals.authData.UserId };
					this.CourseService.deleteSubTopic(item)
						.then((data) => {

							this.btn_disable = false;
							this.submitted = false;

							this.CourseFormList[i].subtopic.splice(j, 1);

							swal({


								type: 'success',
								title: 'Deleted!',
								text: 'Course SubTopic has been deleted successfully',
								showConfirmButton: false,
								timer: 1500
							})

							this.globals.isLoading = false;
						},
							(error) => {
								this.btn_disable = false;
								this.submitted = false;
							});
				}
			})

	}
	AddTopic() {
		debugger

		var subtopic = [];
		var item1 = {
			'SubTopicName': '', 'SubTopicTime': '', 'SubTopicDescription': '', 'Video': '', 'ResourcesId3': '',
			'hh': '', 'mm': ''
		};
		subtopic.push(item1);
		var item = { 'TopicName': '', 'subtopic': subtopic };
		this.CourseFormList.splice(this.CourseFormList.length, 0, item);
		// var index = this.CourseFormList.length;
		// var temp_index = index - 1;
		// index = 'EmailBody' + index;
		setTimeout(function () {

			$('.modal').on('shown.bs.modal', function () {
				$('.right_content_block').addClass('style_position');
			})
			$('.modal').on('hidden.bs.modal', function () {
				$('.right_content_block').removeClass('style_position');
			});
			$('.form_time_picker').click(function () {
				$('.switch').addClass('no_time_click');
			});

			myInput();
			new PerfectScrollbar('#mediascrollbar');
		}, 100);

	}
	Previousfirst() {
		debugger
		this.CourseEntity.CourseId;
		this.firstform = true;
		this.secondform = false;
		this.thirdform = false;
		this.forthform = false;
		this.fifthform = false;
		//success



		//$('#st1').removeClass('disabled');
		$('#st1').addClass('active');
		$('#st1').removeClass('success');
		$('#step1').addClass('active');
		if (this.tab2 == true) {
			$('#step2').removeClass('active');
			$('#st2').addClass('success');
			$('#st2').removeClass('active');
		}
		if (this.tab3 == true) {
			$('#step3').removeClass('active');
			$('#st3').addClass('success');
			$('#st3').removeClass('active');
		}
		if (this.tab4 == true) {
			$('#step4').removeClass('active');
			$('#st4').addClass('success');
			$('#st4').removeClass('active');
		}
		if (this.tab5 == true) {
			$('#step5').removeClass('active');
			$('#st5').addClass('success');
			$('#st5').removeClass('active');
		}
	}
	Previoussecond() {
		debugger

		if (this.urlid) {
			// this.CourseService.getByTopicId(this.CourseEntity.CourseId)
			// .then((data) => {
			// 	debugger

			// 	this.CourseFormList = data;
			//	$('#st2').removeClass('disabled');
			this.singal = true;
			this.firstform = false;
			this.secondform = true;
			this.thirdform = false;
			this.forthform = false;
			this.fifthform = false;
			$('#st2').addClass('active');
			$('#step2').addClass('active');
			$('#st2').removeClass('success');
			if (this.tab1 == true) {
				$('#step1').removeClass('active');
				$('#st1').addClass('success');
				$('#st1').removeClass('active');
			}
			if (this.tab3 == true) {
				$('#step3').removeClass('active');
				$('#st3').addClass('success');
				$('#st3').removeClass('active');
			}
			if (this.tab4 == true) {
				$('#step4').removeClass('active');
				$('#st4').addClass('success');
				$('#st4').removeClass('active');
			}
			if (this.tab5 == true) {
				$('#step5').removeClass('active');
				$('#st5').addClass('success');
				$('#st5').removeClass('active');
			}

			// for (var i = 0; i < this.CourseFormList.length; i++) {
			// 	for (var j = 0; j < this.CourseFormList[i].subtopic.length; j++) {
			// 		$('#MulVideoiconn' + i + j + ' input[type="text"]').val(this.CourseFormList[i].subtopic[j].Video);
			// 		setTimeout(function () {

			// 			myInput();
			// 		}, 100);

			// 	}
			// }



			// },
			// 	(error) => {
			// 		//alert('error');
			// 		this.btn_disable = false;
			// 		this.submitted = false;
			// 		//this.router.navigate(['/pagenotfound']);
			// 	});
		}
		else {
			this.singal = true;
			this.firstform = false;
			this.secondform = true;
			this.thirdform = false;
			this.forthform = false;
			this.fifthform = false;
			$('#st2').addClass('active');
			$('#step2').addClass('active');
			$('#st2').removeClass('success');


			if (this.tab2 == true) {
				$('#step1').removeClass('active');
				$('#st1').addClass('success');
				$('#st1').removeClass('active');
			}
			if (this.tab3 == true) {
				$('#step3').removeClass('active');
				$('#st3').addClass('success');
				$('#st3').removeClass('active');
			}

			if (this.tab4 == true) {
				$('#step4').removeClass('active');
				$('#st4').addClass('success');
				$('#st4').removeClass('active');
			}
			if (this.tab5 == true) {
				$('#step5').removeClass('active');
				$('#st5').addClass('success');
				$('#st5').removeClass('active');
			}


		}


		//$('#st2').addClass('success');
	}
	Previoushtird() {
		debugger


		if (this.urlid) {
			// this.CourseSchedulerService.getById(this.CourseEntity.CourseId, this.globals.authData.UserId)
			// .then((data) => {
			debugger
			this.singal = false;
			this.firstform = false;
			this.secondform = false;
			this.thirdform = true;
			this.forthform = false;
			this.fifthform = false;
			//$('#st3').removeClass('disabled');
			$('#st3').addClass('active');
			$('#step3').addClass('active');
			$('#st3').removeClass('success');
			if (this.tab1 == true) {
				$('#step1').removeClass('active');
				$('#st1').addClass('success');
				$('#st1').removeClass('active');
			}
			if (this.tab2 == true) {
				$('#step2').removeClass('active');
				$('#st2').addClass('success');
				$('#st2').removeClass('active');
			}
			if (this.tab4 == true) {
				$('#step4').removeClass('active');
				$('#st4').addClass('success');
				$('#st4').removeClass('active');
			}
			if (this.tab5 == true) {
				$('#step5').removeClass('active');
				$('#st5').addClass('success');
				$('#st5').removeClass('active');
			}
			// this.schedularList = data['coursesession'];
			// for (var i = 0; i < this.array_data.length; i++) {
			// 	this.stateList[i] = this.stateList_temp;
			// 	this.schedularList[i].checkvalid = true;
			// 	if (this.schedularList[i].IsActive == 0) { this.schedularList[i].IsActive = 0; } else { this.schedularList[i].IsActive = '1'; }
			// 	if (this.schedularList[i].monday =="0") { this.schedularList[i].monday = 0; } else { this.schedularList[i].monday = '1'; }
			// 	if( this.schedularList[i].tuesday== "0") { this.schedularList[i].tuesday = 0; } else { this.schedularList[i].tuesday = '1'; }
			// 	if (this.schedularList[i].wednesday == "0") { this.schedularList[i].wednesday = 0; } else { this.schedularList[i].wednesday = '1'; }
			// 	if (this.schedularList[i].thursday == "0") { this.schedularList[i].thursday = 0; } else { this.schedularList[i].thursday = '1'; }
			// 	if (this.schedularList[i].friday =="0") { this.schedularList[i].friday = 0; } else { this.schedularList[i].friday = '1'; }
			// 	if (this.schedularList[i].saturday == "0") { this.schedularList[i].saturday = 0; } else { this.schedularList[i].saturday = '1'; }
			// 	if (this.schedularList[i].sunday == "0") { this.schedularList[i].sunday = 0; } else { this.schedularList[i].sunday = '1'; }
			// }

			// this.globals.isLoading = false;

			// setTimeout(function () {
			// 	$(".instructorfocus").addClass('filled');
			// 	$(".instructorfocus").parents('.form-group').addClass('focused');
			// 	$('.form_time_picker').datetimepicker({
			// 		weekStart: 1,
			// 		todayBtn: 0,
			// 		autoclose: true,
			// 		todayHighlight: 0,
			// 		startView: 1,
			// 		//minView: 1,
			// 		//maxView: 1,
			// 		forceParse: 0,

			// 		format: 'HH:ii P',
			// 		showMeridian: true,
			// 		pickDate: false,
			// 		pickTime: true,
			// 		pickerPosition: 'top-left'
			// 	});

			// 	// $('.form_time_picker').click(function () {
			// 	// 	$('.switch').addClass('no_time_click');
			// 	// });
			// 	$('.form_time_picker').click(function () {
			// 		$('.table-condensed thead tr').empty();
			// 		$('.table-condensed thead tr').append('<th class="switch no_time_click">Pick Time</th>');
			// 	});
			// 	myInput();
			// }, 100);
			// setTimeout(function () {
			// 	$('.form_date').datetimepicker({
			// 		weekStart: 1,
			// 		todayBtn: 1,
			// 		autoclose: 1,
			// 		todayHighlight: 1,
			// 		startDate: '-0d',
			// 		startView: 2,
			// 		minView: 2,
			// 		forceParse: 0,
			// 		pickTime: false,
			// 		format: 'yyyy/mm/dd',
			// 	});
			// }, 100);



			// },
			// 	(error) => {
			// 		//alert('error');
			// 		this.btn_disable = false;
			// 		this.submitted = false;
			// 		//this.router.navigate(['/pagenotfound']);
			// 	});
		}
		else {
			//  $('#st3').addClass('active');
			this.singal = false;
			this.firstform = false;
			this.secondform = false;
			this.thirdform = true;
			this.forthform = false;
			this.fifthform = false;
			//$('#st3').removeClass('disabled');
			$('#st3').addClass('active');
			$('#step3').addClass('active');
			$('#st3').removeClass('success');
			if (this.tab1 == true) {
				$('#step1').removeClass('active');
				$('#st1').addClass('success');
				$('#st1').removeClass('active');
			}
			if (this.tab2 == true) {
				$('#step2').removeClass('active');
				$('#st2').addClass('success');
				$('#st2').removeClass('active');
			}
			if (this.tab4 == true) {
				$('#step4').removeClass('active');
				$('#st4').addClass('success');
				$('#st4').removeClass('active');
			}
			if (this.tab5 == true) {
				$('#step5').removeClass('active');
				$('#st5').addClass('success');
				$('#st5').removeClass('active');
			}
		}


	}
	Previousfour() {
		debugger
		this.CourseEntity.CourseId;
		this.firstform = false;
		this.secondform = false;
		this.thirdform = false;
		this.forthform = true;
		this.fifthform = false;
		//success

		//$('#st1').removeClass('disabled');
		$('#st4').addClass('active');
		$('#st4').removeClass('success');
		$('#step4').addClass('active');
		if (this.tab2 == true) {
			$('#step2').removeClass('active');
			$('#st2').addClass('success');
			$('#st2').removeClass('active');
		}
		if (this.tab1 == true) {
			$('#step1').removeClass('active');
			$('#st1').addClass('success');
			$('#st1').removeClass('active');
		}
		if (this.tab3 == true) {
			$('#step3').removeClass('active');
			$('#st3').addClass('success');
			$('#st3').removeClass('active');
		}
		if (this.tab5 == true) {
			$('#step5').removeClass('active');
			$('#st5').addClass('success');
			$('#st5').removeClass('active');
		}
	}
	Previousfive() {
		debugger
		//this.addSession(this.CourseEntity.CourseId);
		this.CourseEntity.CourseId;
		let result = this.SubCategoryList.filter(obj => {
			return obj.CategoryId === this.CourseEntity.CategoryId;
		})
		this.CourseEntity.CategoryName = result[0]['CategoryName'];
		//alert(result[0]['CategoryName']);
		this.firstform = false;
		this.secondform = false;
		this.thirdform = false;
		this.forthform = false;
		this.fifthform = true;
		//success



		$('#st5').removeClass('disabled');
		$('#st5').addClass('active');
		$('#st5').removeClass('success');
		$('#step5').addClass('active');
		if (this.tab2 == true) {
			$('#step2').removeClass('active');
			$('#st2').addClass('success');
			$('#st2').removeClass('active');
		}
		if (this.tab1 == true) {
			$('#step1').removeClass('active');
			$('#st1').addClass('success');
			$('#st1').removeClass('active');
		}
		if (this.tab3 == true) {
			$('#step3').removeClass('active');
			$('#st3').addClass('success');
			$('#st3').removeClass('active');
		}
		if (this.tab4 == true) {
			$('#step4').removeClass('active');
			$('#st4').addClass('success');
			$('#st4').removeClass('active');
		}
	}
	DeleteTopic(item) {
		debugger
		// this.CourseService.deletetopic(item)
		// 	.then((data) => {
		// 		var index = this.CourseFormList.indexOf(item);

		// 		this.CourseFormList.splice(index, 1);
		// 	}, (error) => {
		// 		this.btn_disable = false;
		// 		this.submitted = false;
		// 	});

		swal({
			title: 'Delete a Course Topic',
			text: "Are you sure you want to delete this course topic?",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes!'
		})
			.then((result) => {
				if (result.value) {

					this.CourseService.deletetopic(item)
						.then((data) => {

							this.btn_disable = false;
							this.submitted = false;
							var index = this.CourseFormList.indexOf(item);

							this.CourseFormList.splice(index, 1);
							swal({

								type: 'success',
								title: 'Deleted!',
								text: 'Course Topic has been deleted successfully',
								showConfirmButton: false,
								timer: 1500
							})

							this.globals.isLoading = false;
						},
							(error) => {
								this.btn_disable = false;
								this.submitted = false;
							});
				}
			})
	}
	next_btn(CourseForm1) {
		debugger

		this.CourseEntity.Dataurl = $('.link').attr('href');
		// this.CourseEntity.ResourcesId2 = this.CourseEntity.Video;
		// this.CourseEntity.ResourcesId1 = this.CourseEntity.CourseImage;
		if (this.CourseEntity.Featurescheck == true) { this.CourseEntity.Featurescheck = 1; } else { this.CourseEntity.Featurescheck = 0; }
		if (this.CourseEntity.whatgetcheck == true) { this.CourseEntity.whatgetcheck = 1; } else { this.CourseEntity.whatgetcheck = 0; }
		if (this.CourseEntity.Targetcheck == true) { this.CourseEntity.Targetcheck = 1; } else { this.CourseEntity.Targetcheck = 0; }
		if (this.CourseEntity.Morecheck == true) { this.CourseEntity.Morecheck = 1; } else { this.CourseEntity.Morecheck = 0; }
		if (this.CourseEntity.Requirementcheck == true) { this.CourseEntity.Requirementcheck = 1; } else { this.CourseEntity.Requirementcheck = 0; }

		this.CourseEntity.EmailBody = CKEDITOR.instances.EmailBodyF.getData();
		this.CourseEntity.EmailBody2 = CKEDITOR.instances.EmailBodyW.getData();
		this.CourseEntity.EmailBody3 = CKEDITOR.instances.EmailBodyT.getData();
		this.CourseEntity.EmailBody4 = CKEDITOR.instances.EmailBodyM.getData();
		this.CourseEntity.Requirement = CKEDITOR.instances.Requirement1.getData();

		var count = 0;

		let file2 = this.elem.nativeElement.querySelector('#CourseImage').files[0];
		var fd = new FormData();
		if (file2) {
			var CourseImage = Date.now() + '_' + file2['name'];
			fd.append('CourseImage', file2, CourseImage);
			//this.CourseEntity.CourseImageicon = file2['name'];
			this.CourseEntity.CourseImage = CourseImage;
		}
		else {
			fd.append('CourseImage', null);
			this.CourseEntity.CourseImage = null;
		}
		let file3 = this.elem.nativeElement.querySelector('#Video').files[0];
		if (file3) {
			var Video = Date.now() + '_' + file3['name'];
			fd.append('Video', file3, Video);
			this.CourseEntity.CourseVideo = Video;
		}
		else {
			fd.append('Video', null);
			this.CourseEntity.CourseVideo = null;
		}
		let id = this.route.snapshot.paramMap.get('id');
		if (id || this.CourseEntity.CourseId > 0) {
			this.CourseEntity.UpdatedBy = this.globals.authData.UserId;
			this.submitted = false;
		} else {
			this.CourseEntity.CreatedBy = this.globals.authData.UserId;
			this.CourseEntity.UpdatedBy = this.globals.authData.UserId;
			this.CourseEntity.UserId = this.globals.authData.UserId;
			this.CourseEntity.PublishIsStatus = 0;
			this.CourseEntity.CourseId = 0;
			//this.CourseEntity.CompanyId = 0;
			this.submitted = true;
			if (this.CourseEntity.ResourcesId1) {
				this.CourseEntity.ResourcesId1;
			} else {
				if (this.CourseEntity.CourseImage == "" || this.CourseEntity.CourseImage == null || this.CourseEntity.CourseImage == undefined) {
					this.ImageValid = true;
					count = 1;
				} else {
					this.ImageValid = false;
				}
			}
			if (this.CourseEntity.ResourcesId2) {
				this.CourseEntity.ResourcesId2;
			} else {
				if (this.CourseEntity.Video == "" || this.CourseEntity.Video == null || this.CourseEntity.Video == undefined) {
					this.MediaValid = true;
					count = 1;
				} else {
					this.MediaValid = false;
				}
			}
		}


		this.submitted = true;
		if (this.CourseEntity.Keyword == "" || this.CourseEntity.Keyword == null || this.CourseEntity.Keyword == undefined) {
			this.skillsValid = true;
			count = 1;
		} else {
			this.skillsValid = false;
		}
		if (this.CourseEntity.ResourcesId1) {
			this.CourseEntity.ResourcesId1;
		} else {
			// if (this.CourseEntity.CourseImage == "" || this.CourseEntity.CourseImage == null || this.CourseEntity.CourseImage == undefined) {
			// 	this.ImageValid = true;
			// 	count = 1;
			// } else {
			// 	this.ImageValid = false;
			// }
		}
		if (this.CourseEntity.ResourcesId2) {
			this.CourseEntity.ResourcesId2;
		} else {
			// if (this.CourseEntity.Video == "" || this.CourseEntity.Video == null || this.CourseEntity.Video == undefined) {
			// 	this.MediaValid = true;
			// 	count = 1;
			// } else {
			// 	this.MediaValid = false;
			// }
		}
		if (CourseForm1.valid && count == 0) {
			//this.btn_disable = true;
			this.globals.isLoading = true;
			this.CourseEntity.Keyword = this.CourseEntity.Keyword.join();
			this.CourseService.add(this.CourseEntity)
				.then((data) => {
					// this.firstform = false;
					// this.secondform = true;
					this.CourseEntity.CourseId = data;
					console.log(this.CourseEntity.CourseId);

					if (file2 || file3) {
						this.CourseService.uploadFile(fd, this.globals.authData.UserId)
							.then((data) => {
								this.globals.isLoading = false;
								this.firstform = false;
								this.secondform = true;
								this.thirdform = false;
								this.forthform = false;
								this.btn_disable = true;
								this.submitted = false;
								this.globals.isLoading = false;
								for (var i = 0; i < this.CourseFormList.length; i++) {
									for (var j = 0; j < this.CourseFormList[i].subtopic.length; j++) {
										$('#MulVideoiconn' + i + j + ' input[type="text"]').val(this.CourseFormList[i].subtopic[j].Video);
									}
								}

								$('#st2').addClass('active');
								$('#step2').addClass('active');
								$('#step1').removeClass('active');
								this.tab2 = true;
								$('#st1').addClass('success');
								$('#st2').removeClass('success');
								$('#st1').removeClass('active');
							}, (error) => {
								this.btn_disable = false;
								this.submitted = false;
								this.globals.isLoading = false;
								this.router.navigate(['/pagenotfound']);
							});

					} else {
						for (var i = 0; i < this.CourseFormList.length; i++) {
							for (var j = 0; j < this.CourseFormList[i].subtopic.length; j++) {
								$('#MulVideoiconn' + i + j + ' input[type="text"]').val(this.CourseFormList[i].subtopic[j].Video);
							}
						}
						this.firstform = false;
						this.secondform = true;
						this.thirdform = false;
						this.forthform = false;
						this.btn_disable = true;
						this.submitted = false;
						this.globals.isLoading = false;
						this.tab2 = true;

					} setTimeout(function () {
						//$('#st2').removeClass('disabled');
						$('#st2').addClass('active');
						$('#step2').addClass('active');
						$('#step1').removeClass('active');
						//	$('#st1').addClass('disabled');
						$('#st1').addClass('success');
						$('#st2').removeClass('success');
						$('#st1').removeClass('active');
						this.tab1 = true;
						$('.modal').on('shown.bs.modal', function () {
							$('.right_content_block').addClass('style_position');
						})
						$('.modal').on('hidden.bs.modal', function () {
							$('.right_content_block').removeClass('style_position');
						});

					}, 500);


				}, (error) => {
					this.btn_disable = false;
					this.submitted = false;
				});


		} else { this.globals.isLoading = false; }

		// var skill = $('#tagsinput').val();


	}
	// back_btn() {

	// 	this.secondform = false;
	// 	this.firstform = true;
	// 	setTimeout(function () {
	// 		myInput();
	// 	}, 100);
	// }

	addCourseTopic(CourseForm) {
		debugger

		var count = 0;
		for (var i = 0; i < this.CourseFormList.length; i++) {
			var fd = new FormData();
			for (var j = 0; j < this.CourseFormList[i].subtopic.length; j++) {
				this.CourseFormList[i].subtopic[j].SubTopicTime = $("#SubTopicTime" + i + j).val();
				let file5 = this.elem.nativeElement.querySelector('#Video' + i + j).files[0];
				if (file5) {

					fd.append('Video' + j, file5);
					this.CourseFormList[i].subtopic[j].MulVideoicon = file5['name'];
					this.CourseFormList[i].subtopic[j].Video = this.CourseFormList[i].subtopic[j].MulVideoicon;
				}
				else {
					fd.append('Video', null);
					this.CourseFormList[i].subtopic[j].MulVideoicon = null;
				}
				if (this.CourseFormList[i].subtopic[j].ResourcesId3) {
					this.CourseFormList[i].subtopic[j].ResourcesId3;
					this.CourseFormList[i].subtopic[j].VideoValid = false;
				} else {
					if (this.CourseFormList[i].subtopic[j].Video == "" || this.CourseFormList[i].subtopic[j].Video == null || this.CourseFormList[i].subtopic[j].Video == undefined) {

						this.CourseFormList[i].subtopic[j].VideoValid = true;
						count = 1;
					} else {
						this.CourseFormList[i].subtopic[j].VideoValid = false;
					}
				}
				// if (this.CourseFormList[i].subtopic[j].hh == "" || this.CourseFormList[i].subtopic[j].hh == null || this.CourseFormList[i].subtopic[j].hh == undefined ) {

				// 	this.CourseFormList[i].subtopic[j].TimeValid = true;
				// 	count = 1;
				// } else {
				// 	this.CourseFormList[i].subtopic[j].TimeValid = false;
				// }
				// if (this.CourseFormList[i].subtopic[j].mm == "" || this.CourseFormList[i].subtopic[j].mm == null || this.CourseFormList[i].subtopic[j].mm == undefined) {
				// 	this.CourseFormList[i].subtopic[j].TimeValid = true;
				// 	count = 1;
				// } else {
				// 	this.CourseFormList[i].subtopic[j].TimeValid = false;
				// }
				if (this.CourseFormList[i].subtopic[j].hh > 0 || this.CourseFormList[i].subtopic[j].mm > 0) {
					this.CourseFormList[i].subtopic[j].TimeValid = false;
				} else {
					this.CourseFormList[i].subtopic[j].TimeValid = true;
					count = 1;
				}

			}

		}
		let id = this.route.snapshot.paramMap.get('id');
		if (id) {
			this.CourseEntity.UpdatedBy = this.globals.authData.UserId;
			this.submitted = false;
		} else {

			this.CourseEntity.CreatedBy = this.globals.authData.UserId;
			this.CourseEntity.UserId = this.globals.authData.UserId;
			this.CourseEntity.TopicId = 0;


			this.submitted = true;
		}
		this.CourseEntity.CreatedBy = this.globals.authData.UserId;
		this.CourseEntity.CourseId = this.CourseEntity.CourseId;
		if (CourseForm.valid && count == 0) {
			this.globals.isLoading = true;
			this.btn_disable = true;
			for (var i = 0; i < this.CourseFormList.length; i++) {
				var fd = new FormData();
				for (var j = 0; j < this.CourseFormList[i].subtopic.length; j++) {

					let file5 = this.elem.nativeElement.querySelector('#Video' + i + j).files[0];
					if (file5) {
						var Uservideo = Date.now() + '_' + file5['name'];
						// fd.append('UserImage', file5,Uservideo);
						// this.RegisterEntity.UserImage = Uservideo;

						fd.append('Video' + j, file5, Uservideo);
						this.CourseFormList[i].subtopic[j].MulVideoicon = Uservideo;
						this.CourseFormList[i].subtopic[j].Video = this.CourseFormList[i].subtopic[j].MulVideoicon;
					}
					else {
						fd.append('Video', null);
						this.CourseFormList[i].subtopic[j].Video = null;
					}
				}
				if (this.CourseFormList[i].subtopic.length > 0) {
					this.CourseService.uploadFile2(fd, this.CourseFormList[i].subtopic.length, this.globals.authData.UserId)
						.then((data) => {
							debugger


						}, (error) => {
							this.btn_disable = false;
							this.submitted = false;
							this.globals.isLoading = false;
							this.router.navigate(['/pagenotfound']);
						});

				}

			}

			// var fd = new FormData();
			// if (file1) {				
			// 	var UserImage = Date.now()+'_'+file1['name'];
			// 	fd.append('UserImage', file1,UserImage);
			// 	this.RegisterEntity.UserImage = UserImage;			
			// } else {
			// 	fd.append('UserImage', null);
			// 	this.RegisterEntity.UserImage = null;
			// }  







			var addt = { 'topic': this.CourseFormList, 'course': this.CourseEntity };
			this.CourseService.addtopic(addt)
				.then((data) => {

					var course_id = data['CourseId'];
					this.btn_disable = false;
					this.submitted = false;

					//this.CourseFormList = data['Courselist'];

					this.editsave = true;
					//$('#st3').removeClass('disabled');
					this.firstform = false;
					this.secondform = false;
					this.thirdform = true;
					this.forthform = false;

					this.tab3 = true;
					// $('#st3').removeClass('success');
					setTimeout(function () {
						$('#step3').addClass('active');
						$('#step2').removeClass('active');
						$('#st2').addClass('success');
						//	$('#st2').addClass('disabled');
						$('#st2').removeClass('active');
						$('#st3').addClass('active');
					}, 100);
					//this.addSession(course_id);

					this.globals.isLoading = false;


				},
					(error) => {
						this.btn_disable = false;
						this.submitted = false;
					});


		}
		this.globals.isLoading = false;
	}
	edittopic(CourseForm) {
		debugger

		var count = 0;
		for (var i = 0; i < this.CourseFormList.length; i++) {
			var fd = new FormData();
			for (var j = 0; j < this.CourseFormList[i].subtopic.length; j++) {
				this.CourseFormList[i].subtopic[j].SubTopicTime = $("#SubTopicTime" + i + j).val();
				let file5 = this.elem.nativeElement.querySelector('#Video' + i + j).files[0];
				if (file5) {

					fd.append('Video' + j, file5);
					this.CourseFormList[i].subtopic[j].MulVideoicon = file5['name'];
					this.CourseFormList[i].subtopic[j].Video = this.CourseFormList[i].subtopic[j].MulVideoicon;
				}
				else {
					fd.append('Video', null);
					this.CourseFormList[i].subtopic[j].MulVideoicon = null;
				}
				if (this.CourseFormList[i].subtopic[j].ResourcesId3) {
					this.CourseFormList[i].subtopic[j].ResourcesId3;
					this.CourseFormList[i].subtopic[j].VideoValid = false;
				} else {
					if (this.CourseFormList[i].subtopic[j].Video == "" || this.CourseFormList[i].subtopic[j].Video == null || this.CourseFormList[i].subtopic[j].Video == undefined) {

						this.CourseFormList[i].subtopic[j].VideoValid = true;
						count = 1;
					} else {
						this.CourseFormList[i].subtopic[j].VideoValid = false;
					}
				}
				// if (this.CourseFormList[i].subtopic[j].hh == "" || this.CourseFormList[i].subtopic[j].hh == null || this.CourseFormList[i].subtopic[j].hh == undefined) {

				// 	this.CourseFormList[i].subtopic[j].TimeValid = true;
				// 	count = 1;
				// } else {
				// 	this.CourseFormList[i].subtopic[j].TimeValid = false;
				// }
				// if (this.CourseFormList[i].subtopic[j].mm == "" || this.CourseFormList[i].subtopic[j].mm == null || this.CourseFormList[i].subtopic[j].mm == undefined) {
				// 	this.CourseFormList[i].subtopic[j].TimeValid = true;
				// 	count = 1;
				// } else {
				// 	this.CourseFormList[i].subtopic[j].TimeValid = false;
				// }
				if (this.CourseFormList[i].subtopic[j].hh > 0 || this.CourseFormList[i].subtopic[j].mm > 0) {
					this.CourseFormList[i].subtopic[j].TimeValid = false;

				} else {
					this.CourseFormList[i].subtopic[j].TimeValid = true;
					count = 1;

				}


			}
		}
		// this.Entity;
		// 		console.log(Entity);
		// 		if (Entity.TopicId > 0) {
		// 			Entity.TopicId;
		// 		}
		// 		else {
		// 			Entity.TopicId = 0;
		// 		}
		let id = this.route.snapshot.paramMap.get('id');
		if (id) {
			this.CourseEntity.UpdatedBy = this.globals.authData.UserId;
			this.submitted = true;

		} else {

			this.CourseEntity.CreatedBy = this.globals.authData.UserId;
			this.CourseEntity.UserId = this.globals.authData.UserId;
			this.CourseEntity.TopicId = 0;
			this.submitted = false;
		}
		if (CourseForm.valid && count == 0) {
			//this.CourseFormList;
			this.globals.isLoading = true;
			for (var i = 0; i < this.CourseFormList.length; i++) {
				var fd = new FormData();
				for (var j = 0; j < this.CourseFormList[i].subtopic.length; j++) {

					let file5 = this.elem.nativeElement.querySelector('#Video' + i + j).files[0];
					if (file5) {
						var Uservideo = Date.now() + '_' + file5['name'];
						// fd.append('UserImage', file5,Uservideo);
						// this.RegisterEntity.UserImage = Uservideo;

						fd.append('Video' + j, file5, Uservideo);
						this.CourseFormList[i].subtopic[j].MulVideoicon = Uservideo;
						this.CourseFormList[i].subtopic[j].Video = this.CourseFormList[i].subtopic[j].MulVideoicon;

					} else {
						fd.append('Video', null);
						this.CourseFormList[i].subtopic[j].Video = null;
					}
				}
				if (this.CourseFormList[i].subtopic.length > 0) {
					this.CourseService.uploadFile2(fd, this.CourseFormList[i].subtopic.length, this.globals.authData.UserId)
						.then((data) => {



						}, (error) => {
							this.btn_disable = false;
							this.submitted = false;
							this.globals.isLoading = false;
							this.router.navigate(['/pagenotfound']);
						});

				}

			}
			var addt = { 'topic': this.CourseFormList, 'course': this.CourseEntity };
			this.CourseService.edittopic(addt)
				.then((data) => {
					this.firstform = false;
					this.secondform = false;
					this.thirdform = true;
					this.forthform = false;
					var course_id = data;
					this.addSession(course_id);
					this.tab3 = true;
					$('#st3').removeClass('success');
					$('#step3').addClass('active');
					$('#step2').removeClass('active');
					$('#st2').addClass('success');
					//	$('#st2').addClass('disabled');
					$('#st2').removeClass('active');
					$('#st3').addClass('active');

					this.globals.isLoading = false;
					this.btn_disable = false;
					this.submitted = false;


				},
					(error) => {
						this.btn_disable = false;
						this.submitted = false;
					});


		}
		this.globals.isLoading = false;
	}
	// Course session
	AddNewSession(CourseFormSession) {
		var count = 0;
		debugger
		for (var j = 0; j < this.schedularList.length; j++) {
			var Wday = 0;
			if (this.schedularList[j].IsActive == true) { this.schedularList[j].IsActive = 1; } else { this.schedularList[j].IsActive = 0; }
			if (this.schedularList[j].sunday == true) { this.schedularList[j].sunday = 1; } else { this.schedularList[j].sunday = 0; }
			if (this.schedularList[j].monday == true) { this.schedularList[j].monday = 1; } else { this.schedularList[j].monday = 0; }
			if (this.schedularList[j].tuesday == true) { this.schedularList[j].tuesday = 1; } else { this.schedularList[j].tuesday = 0; }
			if (this.schedularList[j].wednesday == true) { this.schedularList[j].wednesday = 1; } else { this.schedularList[j].wednesday = 0; }
			if (this.schedularList[j].thursday == true) { this.schedularList[j].thursday = 1; } else { this.schedularList[j].thursday = 0; }
			if (this.schedularList[j].friday == true) { this.schedularList[j].friday = 1; } else { this.schedularList[j].friday = 0; }
			if (this.schedularList[j].saturday == true) { this.schedularList[j].saturday = 1; } else { this.schedularList[j].saturday = 0; }

			this.schedularList[j].StartTime = $("#StartTime" + j).val();
			this.schedularList[j].EndTime = $("#EndTime" + j).val();
			this.schedularList[j].StartDate = $("#StartDate" + j).val();
			this.schedularList[j].EndDate = $("#EndDate" + j).val();
			this.schedularList[j].CourseCloseDate = $("#CourseCloseDate" + j).val();

			if (this.schedularList[j].StartDate > this.schedularList[j].EndDate) {
				count = 1;
				this.schedularList[j].startlessenddate = true;
			} else {
				this.schedularList[j].startlessenddate = false;
			}
			if (this.schedularList[j].Showstatus == 0) {

				this.schedularList[j].CourseCloseDate = null;

			} else {
				this.schedularList[j].TotalSeats = 0;
				if (this.schedularList[j].CourseCloseDate == "" || this.schedularList[j].CourseCloseDate == null || this.schedularList[j].CourseCloseDate == undefined) {
					this.schedularList[j].CourseCloseDateValid = true;
					count = 1;
				} else {
					this.schedularList[j].CourseCloseDateValid = false;
				}


			}
			if (this.schedularList[j].StartTime == "" || this.schedularList[j].StartTime == null || this.schedularList[j].StartTime == undefined) {
				this.schedularList[j].STimeValid = true;
				count = 1;
			} else {
				this.schedularList[j].STimeValid = false;
			}
			if (this.schedularList[j].EndTime == "" || this.schedularList[j].EndTime == null || this.schedularList[j].EndTime == undefined) {
				this.schedularList[j].ETimeValid = true;
				count = 1;
			} else {
				this.schedularList[j].ETimeValid = false;
			}
			if (this.schedularList[j].StartDate == "" || this.schedularList[j].StartDate == null || this.schedularList[j].StartDate == undefined) {
				this.schedularList[j].SDateValid = true;
				count = 1;
			} else {
				this.schedularList[j].SDateValid = false;
			}
			if (this.schedularList[j].EndDate == "" || this.schedularList[j].EndDate == null || this.schedularList[j].EndDate == undefined) {
				this.schedularList[j].EDateValid = true;
				count = 1;
			} else {
				this.schedularList[j].EDateValid = false;
			}

			if (this.schedularList[j].Instructor == "" || this.schedularList[j].Instructor == null || this.schedularList[j].Instructor == undefined) {
				this.schedularList[j].InstructorValid = true;
				count = 1;
			} else {
				this.schedularList[j].InstructorValid = false;
			}
			if (this.schedularList[j].sunday == 1) {
				Wday = 1;
			} if (this.schedularList[j].monday == 1) {
				Wday = 1;
			} if (this.schedularList[j].tuesday == 1) {
				Wday = 1;
			} if (this.schedularList[j].wednesday == 1) {
				Wday = 1;
			} if (this.schedularList[j].thursday == 1) {
				Wday = 1;
			} if (this.schedularList[j].friday == 1) {
				Wday = 1;
			} if (this.schedularList[j].saturday == 1) {
				Wday = 1;
			}
			if (Wday == 0) {
				this.schedularList[j].checkboxbtnvalid = true;
			} else {
				this.schedularList[j].checkboxbtnvalid = false;
			}

			this.schedularList.CourseSessionId = 0;
		}
		if (CourseFormSession.valid && count == 0 && Wday > 0) {
			this.validadd = false;
			this.submitted = false;
			// this.btn_disable = false;
			// var item = { 'ScheduleName': '', 'StartTime': '', 'EndTime': '','Everyday':'','EveryWeekDay': '','EveryWeek':'', 
			// 'Check1': '', 'Check2': '', 'Check3': '', 'Check4': '', 'Check5': '', 'Check6': '', 'Check7': '','MonthlyIsStatus':'',
			// 'MonthDay':'','EveryMonth':'','WeekDay':'','WhichWeekDay':'','EveryMonth2':'','EveryYears':'','YearlyIsStatus':'','Month':'',
			// 'YearlyWeekDay':'','YearlyWhichWeekDay':'','YearlyMonth':'','StartDate':'','EndIsStatus':'','NoOfOccurences':'','EndDate':'','Documenticon': [], 'MulVideoicon': [] };
			var item = {
				'IsActive': 1, 'SessionName': 'Session', 'StartTime': '', 'EndTime': '',
				'Location': '', 'StartDate': '', 'EndDate': '', 'Instructor': '', 'Instructorone': '', 'CountryId': '', 'StateId': '',
				'CourseCloseDate': '', 'Showstatus': '0', 'TotalSeats': '', 'Check': false, 'CourseSessionId': '0'
			};
			this.schedularList.splice(this.schedularList.length, 0, item);
			var index = this.schedularList.length - 1;
			for (var i = 0; i < this.InstructorListone.length; i++) {
				if (this.globals.authData.RoleId == 3) {
					if (this.InstructorListone[i].value == this.globals.authData.UserId) {
						this.schedularList[index].Instructorone = this.InstructorListone[i].value;
					} else {

					}
				}

			}
			this.schedularList[index].checkvalid = false;
			this.schedularList[index].CourseSessionId = 0;
			this.schedularList[index].SessionStatus = 0;
			this.schedularList[index].PublishStatus = 0;
			this.schedularList[index].CourseSessionId = 0;

			setTimeout(function () {

				$('#daily_recurrence' + index).removeClass('hide');
				$('.range_recurrence' + index).removeClass('hide');
				$('.form_time_picker').datetimepicker({
					weekStart: 1,
					todayBtn: 0,
					autoclose: true,
					todayHighlight: 0,
					startView: 1,
					//minView: 1,
					//maxView: 1,
					forceParse: 0,
					format: 'HH:ii P',
					showMeridian: true,
					pickDate: false,
					pickTime: true,
					pickerPosition: 'top-left'
				});

				$('.form_date').datetimepicker({
					weekStart: 1,
					todayBtn: 1,
					autoclose: 1,
					todayHighlight: 1,
					startDate: '-0d',
					startView: 2,
					minView: 2,
					forceParse: 0,
					pickTime: false,
					format: 'yyyy/mm/dd',

				});
				myInput();
			}, 500);
			setTimeout(function () {

				$('.form_time_picker').click(function () {
					$('.table-condensed thead tr').empty();
					$('.table-condensed thead tr').append('<th class="switch no_time_click">Pick Time</th>');
				}); myInput();
			}, 500);
		} else {
			this.globals.isLoading = false;
			this.submitted = true;
			this.btn_disable = false;
			this.validadd = true;

		}
	}


	DeleteCoursesession(item, i) {
		debugger

		this.CourseSchedulerEntity.UpdatedBy = this.globals.authData.UserId;
		swal({
			title: 'Delete a course session?',
			text: "Are you sure you want to delete this course session?",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		})
			.then((result) => {
				if (result.value) {
					var del = { 'CourseSessionId': i, 'UserId': this.CourseSchedulerEntity.UpdatedBy };
					this.CourseSchedulerService.deleteScheduler(del)
						.then((data) => {

							this.btn_disable = false;
							this.submitted = false;
							var index = this.schedularList.indexOf(item);
							if (index != -1) {
								this.schedularList.splice(index, 1);
							}
							swal({

								type: 'success',
								title: 'Deleted!',
								text: 'Course Session has been deleted successfully',
								showConfirmButton: false,
								timer: 1500
							})

							this.globals.isLoading = false;
						},
							(error) => {
								this.btn_disable = false;
								this.submitted = false;
							});
				}
			})
	}
	addCourseSession(CourseFormSession) {

		var count = 0;

		debugger
		for (var j = 0; j < this.schedularList.length; j++) {
			var Wday = 0;
			if (this.schedularList[j].IsActive == true) { this.schedularList[j].IsActive = 1; } else { this.schedularList[j].IsActive = 0; }
			if (this.schedularList[j].sunday == true) { this.schedularList[j].sunday = 1; } else { this.schedularList[j].sunday = 0; }
			if (this.schedularList[j].monday == true) { this.schedularList[j].monday = 1; } else { this.schedularList[j].monday = 0; }
			if (this.schedularList[j].tuesday == true) { this.schedularList[j].tuesday = 1; } else { this.schedularList[j].tuesday = 0; }
			if (this.schedularList[j].wednesday == true) { this.schedularList[j].wednesday = 1; } else { this.schedularList[j].wednesday = 0; }
			if (this.schedularList[j].thursday == true) { this.schedularList[j].thursday = 1; } else { this.schedularList[j].thursday = 0; }
			if (this.schedularList[j].friday == true) { this.schedularList[j].friday = 1; } else { this.schedularList[j].friday = 0; }
			if (this.schedularList[j].saturday == true) { this.schedularList[j].saturday = 1; } else { this.schedularList[j].saturday = 0; }

			this.schedularList[j].StartTime = $("#StartTime" + j).val();
			this.schedularList[j].EndTime = $("#EndTime" + j).val();
			this.schedularList[j].StartDate = $("#StartDate" + j).val();
			this.schedularList[j].EndDate = $("#EndDate" + j).val();
			this.schedularList[j].CourseCloseDate = $("#CourseCloseDate" + j).val();

			if (this.schedularList[j].StartDate > this.schedularList[j].EndDate) {
				count = 1;
				this.schedularList[j].startlessenddate = true;
			} else {
				this.schedularList[j].startlessenddate = false;
			}
			if (this.schedularList[j].Showstatus == 0) {

				this.schedularList[j].CourseCloseDate = null;

			} else {
				this.schedularList[j].TotalSeats = 0;
				if (this.schedularList[j].CourseCloseDate == "" || this.schedularList[j].CourseCloseDate == null || this.schedularList[j].CourseCloseDate == undefined) {
					this.schedularList[j].CourseCloseDateValid = true;
					count = 1;
				} else {
					this.schedularList[j].CourseCloseDateValid = false;
				}


			}
			if (this.schedularList[j].StartTime == "" || this.schedularList[j].StartTime == null || this.schedularList[j].StartTime == undefined) {
				this.schedularList[j].STimeValid = true;
				count = 1;
			} else {
				this.schedularList[j].STimeValid = false;
			}
			if (this.schedularList[j].EndTime == "" || this.schedularList[j].EndTime == null || this.schedularList[j].EndTime == undefined) {
				this.schedularList[j].ETimeValid = true;
				count = 1;
			} else {
				this.schedularList[j].ETimeValid = false;
			}
			if (this.schedularList[j].StartDate == "" || this.schedularList[j].StartDate == null || this.schedularList[j].StartDate == undefined) {
				this.schedularList[j].SDateValid = true;
				count = 1;
			} else {
				this.schedularList[j].SDateValid = false;
			}
			if (this.schedularList[j].EndDate == "" || this.schedularList[j].EndDate == null || this.schedularList[j].EndDate == undefined) {
				this.schedularList[j].EDateValid = true;
				count = 1;
			} else {
				this.schedularList[j].EDateValid = false;
			}

			if (this.schedularList[j].Instructor == "" || this.schedularList[j].Instructor == null || this.schedularList[j].Instructor == undefined) {
				this.schedularList[j].InstructorValid = true;
				count = 1;
			} else {
				this.schedularList[j].InstructorValid = false;
			}
			if (this.schedularList[j].sunday == 1) {
				Wday = 1;
			} if (this.schedularList[j].monday == 1) {
				Wday = 1;
			} if (this.schedularList[j].tuesday == 1) {
				Wday = 1;
			} if (this.schedularList[j].wednesday == 1) {
				Wday = 1;
			} if (this.schedularList[j].thursday == 1) {
				Wday = 1;
			} if (this.schedularList[j].friday == 1) {
				Wday = 1;
			} if (this.schedularList[j].saturday == 1) {
				Wday = 1;
			}
			if (Wday == 0) {
				this.schedularList[j].checkboxbtnvalid = true;
			} else {
				this.schedularList[j].checkboxbtnvalid = false;
			}

			this.schedularList.CourseSessionId = 0;
		}


		let id = this.route.snapshot.paramMap.get('id');
		if (id) {

			this.CourseSchedulerEntity.UpdatedBy = this.globals.authData.UserId;
			this.submitted = false;
			//this.CourseSchedulerEntity.CourseId = id;
			this.CourseSchedulerEntity.CourseId = this.CourseEntity.CourseId;

		} else {

			this.CourseSchedulerEntity.CreatedBy = this.globals.authData.UserId;
			this.CourseSchedulerEntity.UserId = this.globals.authData.UserId;

			//this.CourseSchedulerEntity.CourseId = id;
			this.CourseSchedulerEntity.CourseId = this.CourseEntity.CourseId;
		}
		this.CourseSchedulerEntity.CreatedBy = this.globals.authData.UserId;
		if (CourseFormSession.valid && count == 0 && Wday > 0) {
			this.globals.isLoading = true;
			this.btn_disable = true;

			this.firstform = false;
			this.secondform = false;
			this.thirdform = false;
			this.forthform = true;
			this.fifthform = false;
			this.tab4 = true;
			setTimeout(function () {

				$('#st4').removeClass('disabled');
				$('#st4').removeClass('success');
				$('#st4').addClass('active');
				$('#step4').addClass('active');
				$('#step3').removeClass('active');
				$('#st3').removeClass('active');
				$('#st3').addClass('success');
			}, 100);
			// var addt = { 'schedularList': this.schedularList, 'course': this.CourseSchedulerEntity };
			// this.CourseSchedulerService.addScheduler(addt)
			// 	.then((data) => {
			// 		this.btn_disable = false;
			// 		this.submitted = false;
			// 		this.globals.isLoading = false;
			// 		//	this.CourseSchedulerEntity = {};
			// 		CourseFormSession.form.markAsPristine();


			// 	},
			// 		(error) => {
			// 			this.btn_disable = false;
			// 			this.submitted = false;
			// 			this.globals.isLoading = false;
			// 		});					


		} else {
			this.globals.isLoading = false;
			this.submitted = true;
			this.btn_disable = false;

		} this.globals.isLoading = false;

	}
	Publish(CourseFormSession, Entity, i) {
		debugger

		var count = 0;
		Entity.CourseSessionId;
		if (Entity.Check == true) { Entity.Check = 1; } else { Entity.Check = 0; }
		Entity.StartTime = $("#StartTime" + i).val();
		Entity.EndTime = $("#EndTime" + i).val();
		Entity.StartDate = $("#StartDate" + i).val();
		Entity.EndDate = $("#EndDate" + i).val();
		Entity.CourseCloseDate = $("#CourseCloseDate" + i).val();
		if (Entity.Sunday == true) { Entity.Sunday = 1; } else { Entity.Sunday = 0; }
		if (Entity.Monday == true) { Entity.Monday = 1; } else { Entity.Monday = 0; }
		if (Entity.tuesday == true) { Entity.tuesday = 1; } else { Entity.tuesday = 0; }
		if (Entity.wednesday == true) { Entity.wednesday = 1; } else { Entity.wednesday = 0; }
		if (Entity.thursday == true) { Entity.thursday = 1; } else { Entity.thursday = 0; }
		if (Entity.friday == true) { Entity.friday = 1; } else { Entity.friday = 0; }
		if (Entity.saturday == true) { Entity.saturday = 1; } else { Entity.saturday = 0; }
		if (Entity.Showstatus == 0) {
			Entity.CourseCloseDate = null;
		} else {
			Entity.TotalSeats = 0;
			if (Entity.CourseCloseDate == "" || Entity.CourseCloseDate == null || Entity.CourseCloseDate == undefined) {
				this.schedularList[i].CourseCloseDateValid = true;
				count = 1;
			} else {
				this.CourseCloseDateValid = false;
			}
		}
		if (Entity.StartTime == "" || Entity.StartTime == null || Entity.StartTime == undefined) {
			this.schedularList[i].STimeValid = true;
			count = 1;
		} else {
			this.schedularList[i].STimeValid = false;
		}
		if (Entity.EndTime == "" || Entity.EndTime == null || Entity.EndTime == undefined) {
			this.schedularList[i].ETimeValid = true;
			count = 1;
		} else {
			this.schedularList[i].ETimeValid = false;
		}
		if (Entity.StartDate == "" || Entity.StartDate == null || Entity.StartDate == undefined) {
			this.schedularList[i].SDateValid = true;
			count = 1;
		} else {
			this.schedularList[i].SDateValid = false;
		}
		if (Entity.EndDate == "" || Entity.EndDate == null || Entity.EndDate == undefined) {
			this.schedularList[i].EDateValid = true;
			count = 1;
		} else {
			this.schedularList[i].EDateValid = false;
		}

		if (Entity.Instructor == "" || Entity.Instructor == null || Entity.Instructor == undefined) {
			this.schedularList[i].InstructorValid = true;
			count = 1;
		} else {
			this.schedularList[i].InstructorValid = false;
		}





		let id = this.route.snapshot.paramMap.get('id');
		if (id) {
			this.CourseSchedulerEntity.UpdatedBy = this.globals.authData.UserId;
			this.submitted = false;
			//this.CourseSchedulerEntity.CourseId = id;
			this.CourseSchedulerEntity.CourseId;

		} else {

			this.CourseSchedulerEntity.CreatedBy = this.globals.authData.UserId;
			this.CourseSchedulerEntity.UserId = this.globals.authData.UserId;
			this.schedularList[i].CourseSessionId = 0;
			//this.CourseSchedulerEntity.CourseId = id;
			this.CourseSchedulerEntity.CourseId;
		}
		this.CourseSchedulerEntity.CreatedBy = this.globals.authData.UserId;
		// var Enrolla={'CourseId': CourseId,'UserId': this.globals.authData.UserId};

		if (CourseFormSession.valid && count == 0) {
			this.btn_disable = true;
			this.globals.isLoading = true;
			var addt = { 'schedularList': Entity, 'course': this.CourseSchedulerEntity };
			this.CourseSchedulerService.updatePublish(addt)
				.then((data) => {
					this.btn_disable = false;
					this.submitted = false;
					// this.schedularList[i].CourseSessionId = data;
					//	this.CourseSchedulerEntity = {};
					CourseFormSession.form.markAsPristine();
					swal({
						type: 'success',
						title: 'Success...!',
						text: 'Session has been Publish is successfully.',
						showConfirmButton: false,
						timer: 3000
					})
					this.globals.isLoading = false;




				},
					(error) => {
						this.btn_disable = false;
						this.submitted = false;
						this.globals.isLoading = false;
					});

		} else {
			this.globals.isLoading = false;
			this.submitted = true;
			this.btn_disable = false;

		}
		this.globals.isLoading = false;

	}
	getStateList(CourseFormSession, i) {
		debugger

		//	CourseFormSession.form.controls.StateId.markAsDirty();
		this.schedularList[i].StateId = '';
		if (this.schedularList[i].CountryId > 0) {
			this.CourseSchedulerService.getStateList(this.schedularList[i].CountryId)
				.then((data) => {
					this.stateList[i] = data;


				},
					(error) => {
						//alert('error');
					});
		}
		else {
			this.stateList[i] = [];
		}
	}
	maxStudent(CourseFormSession) {
		debugger
		setTimeout(function () {
			$('.form_date').datetimepicker({
				weekStart: 1,
				todayBtn: 1,
				autoclose: 1,
				startDate: '-0d',
				todayHighlight: 1,
				startView: 2,
				minView: 2,
				forceParse: 0,
				pickTime: false,
				format: 'yyyy/mm/dd',
			});

		}, 100);
	}
	clone(Entity) {
		debugger
		this.globals.isLoading = true;
		var addt = { 'schedularList': Entity, 'CreatedBy': this.globals.authData.UserId };
		this.CourseSchedulerService.CloneCourse(addt)
			.then((data) => {
				this.schedularList.push(Entity);
				this.globals.isLoading = false;

				swal({
					type: 'success',
					title: 'Added!',
					text: 'Course has been clone successfully',
					showConfirmButton: false,
					timer: 1500
				})
				setTimeout(function () {
					$(".instructorfocus").addClass('filled');
					$(".instructorfocus").parents('.form-group').addClass('focused');
					$('.form_time_picker').datetimepicker({
						weekStart: 1,
						todayBtn: 0,
						autoclose: true,
						todayHighlight: 0,
						startView: 1,
						//minView: 1,
						//maxView: 1,
						forceParse: 0,
						format: 'HH:ii P',
						showMeridian: true,
						pickDate: false,
						pickTime: true,
						pickerPosition: 'top-left'
					});

					// $('.form_time_picker').click(function () {
					// 	$('.switch').addClass('no_time_click');
					// });
					$('.form_time_picker').click(function () {
						$('.table-condensed thead tr').empty();
						$('.table-condensed thead tr').append('<th class="switch no_time_click">Pick Time</th>');
					});
					myInput();
				}, 100);
				setTimeout(function () {
					$('.form_date').datetimepicker({
						weekStart: 1,
						todayBtn: 1,
						autoclose: 1,
						todayHighlight: 1,
						startDate: '-0d',
						startView: 2,
						minView: 2,
						forceParse: 0,
						pickTime: false,
						format: 'yyyy/mm/dd',

					});

				}, 100);

			},
				(error) => {
					//alert('error');
				});
	}

	badgecl(image, i) {
		debugger
		this.BadgesEntity.image = image.FilePath;
		$('.badgeremove').removeClass('active');
		$('#badgetest' + i).addClass('active');
		this.BadgesEntity.ResourcesId = image.ResourcesId;
		$('#badgeImageicon input[type="text"]').val(this.BadgesEntity.image);
		$('#myModal3').modal('hide');

		$('#badgeImage').change(function (e) {
			// alert('a');

			var file = e.target.files[0];
			var reader = new FileReader();
			reader.onloadend = function () {

				$(".link").attr("href", reader.result);
				$(".link").text(reader.result);
			}
			this.BadgesEntity.Dataurl = reader.readAsDataURL(file);
			//alert(this.BadgesEntity.Dataurl);
		});
	}
	Browseshow() {
		$("input[name='selectbages']").val(null);
		//this.BadgesEntity.badgeImage = null;
		this.BadgesEntity.ResourcesId = 0;
		$('#badgeImageicon input[type="text"]').val(null);
		this.badgehide = true;
		setTimeout(function () {
			$(".image-radio").each(function () {
				if ($(this).find('input[type="radio"]').first().attr("checked")) {
					$(this).addClass('image-radio-checked');
				} else {
					$(this).removeClass('image-radio-checked');
				}
			});
			//this.BadgesEntity.ResourcesId3=0;
			// sync the input state
			$(".image-radio").on("click", function (e) {
				$(".image-radio").removeClass('image-radio-checked');
				$(this).addClass('image-radio-checked');
				var name = $(this).attr('name');

				//$('#badgeImageicon input[type="text"]').val(name);
				var $radio = $(this).find('input[type="radio"]');
				$radio.prop("checked", !$radio.prop("checked"));

				e.preventDefault();

			});
		}, 500);
	}
	Browsehide() {
		debugger
		this.badgehide = false;
		this.BadgesEntity.ResourcesId = null;
		this.BadgesEntity.BadgeImageId = null;
		//this.BadgesEntity.badgeImage = null;
		$("input[name='selectbages']").val(null);
		$('#badgeImageicon input[type="text"]').val(null);
		$('#badgeImage input[type="text"]').val(null);
		setTimeout(function () {
			$(".image-radio").each(function () {
				if ($(this).find('input[type="radio"]').first().attr("checked")) {
					$(this).addClass('image-radio-checked');
				} else {
					$(this).removeClass('image-radio-checked');
				}
			});

			// sync the input state
			$(".image-radio").on("click", function (e) {
				$(".image-radio").removeClass('image-radio-checked');
				$(this).addClass('image-radio-checked');
				var name = $(this).attr('name');
				$("input[name='selectbages']").val(name);
				//$('#badgeImageicon input[type="text"]').val(name);
				var $radio = $(this).find('input[type="radio"]');
				$radio.prop("checked", !$radio.prop("checked"));

				e.preventDefault();

			});
		}, 500);
	}
	addbadge(BadgesForm) {
		debugger
		this.BadgesEntity.Dataurl = $('.link1').attr('href');
		this.BadgesEntity.CourseId = this.CourseEntity.CourseId;
		let file2 = this.elem.nativeElement.querySelector('#badgeImage').files[0];
		var fd = new FormData();
		if (file2) {
			var badgeImage = Date.now() + '_' + file2['name'];
			fd.append('badgeImage', file2, badgeImage);
			this.BadgesEntity.badgeImage = badgeImage;
		}
		else {
			if (this.BadgesEntity.badgeImage == null) {
				fd.append('badgeImage', null);
				this.BadgesEntity.badgeImage = null;
			}
			else {

			}

		}
		var count = 0;
		let id = this.route.snapshot.paramMap.get('id');

		if (id) {
			this.BadgesEntity.UpdatedBy = this.globals.authData.UserId;
			this.submitted = true;
			this.BadgesEntity.CreatedBy = this.globals.authData.UserId;
			if (this.badgehide == true) {
				if (this.BadgesEntity.ResourcesId > 0) {
					this.BadgesEntity.ResourcesId;
					this.BadgesEntity.selectid = 0;

				} else {
					this.BadgesEntity.ResourcesId = 0;
					this.BadgesEntity.BadgeImageId = 0;
					this.BadgesEntity.selectid = 0;

				}

			} else {
				var name = $("input[name='selectbages']").val();
				this.BadgesEntity.badgeImage = name;
				this.BadgesEntity.selectid = 0;

				if (this.BadgesEntity.BadgeImageId == "" || this.BadgesEntity.BadgeImageId == 0 || this.BadgesEntity.BadgeImageId == undefined) {
					this.BadgesEntity.BadgeImageId;
				} else {

					// this.BadgesEntity.BadgeImageId = 0;
					this.BadgesEntity.selectid = 1;

				}
			}
		}
		else {
			this.BadgesEntity.CreatedBy = this.globals.authData.UserId;
			this.BadgesEntity.BadgesId = 0;
			this.submitted = true;

			if (this.badgehide == true) {
				if (this.BadgesEntity.ResourcesId > 0) {
					this.BadgesEntity.ResourcesId;
					this.badgeValid = false;
					this.BadgesEntity.selectid = 0;
				}
				else {
					if (this.BadgesEntity.badgeImage == "" || this.BadgesEntity.badgeImage == null || this.BadgesEntity.badgeImage == undefined) {
						this.badgeValid = true;
						count = 1;
					} else {
						this.badgeValid = false;
						this.BadgesEntity.selectid = 0;
						this.BadgesEntity.ResourcesId = 0;
						this.BadgesEntity.BadgeImageId = 0;
					}
				}

			} else {
				var name = $("input[name='selectbages']").val();
				// this.BadgesEntity.badgeImage = name;
				if (this.BadgesEntity.BadgeImageId == "" || this.BadgesEntity.BadgeImageId == 0 || this.BadgesEntity.BadgeImageId == undefined) {
					this.selebadge = true;
					count = 1;
				} else {

					this.selebadge = false;
					this.BadgesEntity.selectid = 1;
				}
				this.badgeValid = false;
			}
		}
		if (BadgesForm.valid && count == 0) {
			this.btn_disable = true;

			// this.firstform = false;
			// this.secondform = false;
			// this.thirdform = false;
			// this.forthform = false;
			// this.fifthform=true;

			// this.tab5=true;
			// setTimeout(function () {	
			// $('#st5').removeClass('disabled');
			// $('#st5').removeClass('success');
			// 	$('#st5').addClass('active');
			//    $('#step5').addClass('active');
			//    $('#step4').removeClass('active');
			//    $('#st4').removeClass('active');
			//    $('#st4').addClass('success');
			// }, 100);

			if (file2) {

				this.CourseService.badgeuploadFile(fd, this.globals.authData.UserId)
					.then((data) => {
						this.globals.isLoading = false;
						this.btn_disable = true;
						this.submitted = false;



						//	this.router.navigate(['/instructor-courses']);
					}, (error) => {
						this.btn_disable = false;
						this.submitted = false;
						this.globals.isLoading = false;
						this.router.navigate(['/pagenotfound']);
					});

			} else {
				//	this.router.navigate(['/instructor-courses']);
			}
			this.tab5 = true;
			this.Previousfive();

		}
	}
	Finelsubmit() {

		debugger
			this.globals.isLoading = true;
		if(this.urlid>0)
		{
			this.BadgesEntity.UpdatedBy = this.globals.authData.UserId;
		}else
		{

		}
		this.CourseService.addbadge(this.BadgesEntity)
			.then((data) => {

			},
				(error) => {

					this.btn_disable = false;
					this.submitted = false;

				});
		this.CourseSchedulerEntity.CourseId = this.CourseEntity.CourseId;
		this.CourseSchedulerEntity.CreatedBy = this.globals.authData.UserId;
		this.CourseSchedulerEntity.UpdatedBy = this.globals.authData.UserId;
		this.CourseSchedulerEntity.UserId = this.globals.authData.UserId;
		for (var j = 0; j < this.schedularList.length; j++) 
		{
			if(this.schedularList[j].Publish==true)
			{
				this.schedularList[j].Publish=1;
			}else
			{
				this.schedularList[j].Publish=0;
			}
			if(this.schedularList[j].Check==true)
			{
				this.schedularList[j].Check=1;
			}else
			{
				this.schedularList[j].Check=0;
			}
		}
		var addt = { 'schedularList': this.schedularList, 'course': this.CourseSchedulerEntity };
		this.CourseSchedulerService.addScheduler(addt)
			.then((data) => {
				this.btn_disable = false;
				this.submitted = false;
				this.globals.isLoading = false;
				//	this.CourseSchedulerEntity = {};
				this.router.navigate(['/instructor-courses']);


			},
				(error) => {
					this.btn_disable = false;
					this.submitted = false;
					this.globals.isLoading = false;
				});
	}
}
