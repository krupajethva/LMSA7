
import { Component, OnInit } from '@angular/core';
import { CourseListService } from '../services/course-list.service';
import { InstructorfollowersService } from '../services/instructorfollowers.service';
import { Globals } from '.././globals';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
declare var $, swal, paypal, getAccordion, PerfectScrollbar: any;
declare function myInput(): any;

@Component({

  selector: 'app-preview',
  templateUrl: './preview.component.html',
  styleUrls: ['./preview.component.css']
})
export class PreviewComponent implements OnInit {
  CourseDetailList;
  PurchaseEntity;
  SessionEnrollid;
  ssid;
  addScript;
  paypalLoad;
  disabled;
  show;
  submitted;
  btn_disable;
  postEntity;
  CourseDiscussionList;
  followerEntity;
  datea;
  Relatedcourse;
  CourseContent;
  reviewEntity;
  errorText;
  CourseReviewList;
  ReviewAverage;
  courseid;
  allowUser;
  UserDetail;
  display;
  CourseSesssionList;
  sessiontrue;
  StartDate;
  constructor(private CourseListService: CourseListService, private InstructorfollowersService: InstructorfollowersService, private globals: Globals, private router: Router, private route: ActivatedRoute) { }

  ngOnInit() {



    var $videoSrc;
    $('.video-btn').click(function () {
      $videoSrc = $(this).data("src");
    });
    console.log($videoSrc);



    // when the modal is opened autoplay it  
    $('#myModal').on('shown.bs.modal', function (e) {

      // set the video src to autoplay and not to show related video. Youtube related video is like a box of chocolates... you never know what you're gonna get
      $("#video").attr('src', $videoSrc + "?rel=0&amp;showinfo=0&amp;modestbranding=1&amp;autoplay=1");
    })


    // stop playing the youtube video when I close the modal
    $('#myModal').on('hide.bs.modal', function (e) {
      // a poor man's stop video
      $("#video").attr('src', $videoSrc);
    })

    setTimeout(function () {

      $('.modal').on('shown.bs.modal', function () {
        $('.right_content_block').addClass('style_position');
      })
      $('.modal').on('hidden.bs.modal', function () {
        $('.right_content_block').removeClass('style_position');
      });


      //   $('#desc00').click(function (e) {
      //     e.preventDefault();
      //     $("#desc_area00").toggle(300);
      //   });

      //   $('#desc10').click(function (e) {
      //     e.preventDefault();
      //     $("#desc_area10").toggle(300);
      //   });
    }, 500);


    //accordian for course content
    function toggleIcon(e) {
      $(e.target)
        .prev('.panel-heading')
        .find(".more-less")
        .toggleClass('glyphicon-plus glyphicon-minus');
    }
    $('.panel-group').on('hidden.bs.collapse', toggleIcon);
    $('.panel-group').on('shown.bs.collapse', toggleIcon);
    //end accordian for course content

    debugger
    var d = new Date();
    var curr_date = d.getDate();
    var curr_month = d.getMonth() + 1; //Months are zero based
    var curr_year = d.getFullYear();
    if (curr_month < 10) {
      var month = '0' + curr_month;
    } else {
      var month = '' + curr_month;
    }
    if (curr_date < 10) {
      var date = '0' + curr_date;
    }
    else {
      var date = '' + curr_date;
    }
    this.datea = curr_year + '-' + month + '-' + date;

    this.errorText = false;
    this.allowUser = false;
    this.display = false;
    this.CourseDetailList = [];
    this.CourseSesssionList = [];
    this.CourseDiscussionList = [];
    this.CourseReviewList = [];
    this.Relatedcourse=[];
    this.sessiontrue = false;
    myInput();
    //alert(this.datea.getFullYear()+ '/' +(this.datea.getMonth() + 1) + '/' + this.datea.getDate());
    //alert(this.datea);
    setTimeout(function () {
      if ($(".bg_white_block").hasClass("ps--active-y")) {
        $('footer').removeClass('footer_fixed');
      }
      else {
        $('footer').addClass('footer_fixed');
      }

      // $(".reply_time .reply_btn.first_level").click(function () {
      //   $(this).next().next().toggle(400);
      // });
      // $(".forum_box.inner_forum .reply_time .reply_btn").click(function () {
      //   $(this).next().next().toggle(400);
      // });

      // $(".edit_discusion").click(function () {
      //   $(this).next().next().toggle(400);
      // });


      // $("#review_btn").click(function () {
      //   $('#write_review').toggle(400);
      // });
      // $("#edit_review").click(function () {
      //   $('.content_name .write_review').toggle(400);
      // });

      // $('.write_review :radio').change(function () {
      //   console.log('New star rating: ' + this.value);
      // });
      // $('.clear_rating').click(function () {
      //   $('.write_review input[type="radio"]').prop("checked", false);
      // });


      // getAccordion("#tabs", 768);

    }, 1000);
    //this.CourseDetailList={};
    this.PurchaseEntity = {};
    this.postEntity = {};
    this.reviewEntity = {};
    this.PurchaseEntity.TotalAmount;
    // getAccordion("#tabs", 768);
    let id1 = this.route.snapshot.paramMap.get('id');
    this.courseid = id1;
    var id = { 'id': this.route.snapshot.paramMap.get('id'), 'LearnerId': this.globals.authData.UserId };
    var obj = { 'CourseId': this.route.snapshot.paramMap.get('id'), 'UserId': this.globals.authData.UserId };
    this.CourseListService.checkUser(obj)
      //.map(res => res.json())
      .then((data) => {
        if (data == "Duplicate User") {
          this.allowUser = true;
        }
      },
        (error) => {
          //alert('error');

          //this.router.navigate(['/pagenotfound']);
        });

    this.CourseListService.getUserDetail(this.globals.authData.UserId)
      //.map(res => res.json())
      .then((data) => {
        this.UserDetail = data;
      },
        (error) => {
          //alert('error');

          //this.router.navigate(['/pagenotfound']);
        });
    this.CourseListService.getAllCourseDetail(id)
      //.map(res => res.json())
      .then((data) => {debugger
        if (data) {
          this.CourseDetailList = data['detail'];
          this.CourseSesssionList = data['Preview'];
          for (var i = 0; i < this.CourseSesssionList.length; i++) {
				
            if (this.CourseSesssionList[i].monday =="0") { this.CourseSesssionList[i].monday = ''; } else { this.CourseSesssionList[i].monday = 'Mon'; }
            if( this.CourseSesssionList[i].tuesday== "0") { this.CourseSesssionList[i].tuesday = ''; } else { this.CourseSesssionList[i].tuesday = 'Tue'; }
            if (this.CourseSesssionList[i].wednesday == "0") { this.CourseSesssionList[i].wednesday = ''; } else { this.CourseSesssionList[i].wednesday = 'Wed'; }
            if (this.CourseSesssionList[i].thursday == "0") { this.CourseSesssionList[i].thursday = ''; } else { this.CourseSesssionList[i].thursday = 'Thu'; }
            if (this.CourseSesssionList[i].friday =="0") { this.CourseSesssionList[i].friday = ''; } else { this.CourseSesssionList[i].friday = 'Fri'; }
            if (this.CourseSesssionList[i].saturday == "0") { this.CourseSesssionList[i].saturday = ''; } else { this.CourseSesssionList[i].saturday = 'Sat'; }
            if (this.CourseSesssionList[i].sunday == "0") { this.CourseSesssionList[i].sunday = ''; } else { this.CourseSesssionList[i].sunday = 'Sun'; }
          }
          this.CourseContent = data['CourseContent'];
        }
      },
        (error) => {
          //alert('error');

          //this.router.navigate(['/pagenotfound']);
        });
    this.CourseListService.getDiscussionById(obj)
      //.map(res => res.json())
      .then((data) => {
        if (data) {
            this.CourseDiscussionList = data['discussion'];
            this.CourseReviewList = data['Reviews'];
            this.ReviewAverage = this.CourseReviewList[0].reviewavg;
          this.Relatedcourse = data['skill'];
     
          //console.log(this.CourseDiscussionList);
        }
      },
        (error) => {
          //alert('error');

          //this.router.navigate(['/pagenotfound']);
        });

  }
  // paypalConfig = {
  //   env: 'sandbox',
  //   client: {
  //     sandbox: 'AVae-_pCZcevpsso7uIEZkRRMR7vwrLGr_yiCuWAQJxGS3_5vCcLNjvd10k-xUXWRRW0KvgcoPjq9bn9',
  //     production: '<your-production-key here>'
  //   },
  //   commit: true,
  //   payment: (data, actions) => {
  //     return actions.payment.create({
  //       payment: {
  //         transactions: [
  //           {
  //             amount: { total: this.PurchaseEntity.TotalAmount, currency: 'USD' }
  //           }
  //         ]
  //       }
  //     });
  //   },
  //   onAuthorize: (data, actions) => {
  //     return actions.payment.execute().then((payment) => {
  //       //Do something when payment is successful.
  //       this.PurchaseEntity.LernerId = this.globals.authData.UserId;
  //       this.PurchaseEntity.InstracterId = this.globals.authData.ParentId;
  //       this.PurchaseEntity.EmailAddress = this.globals.authData.EmailAddress;
  //       this.PurchaseEntity.CourseId = 1;
  //       //alert('success');
  // this.CourseListService.PurchaseCourse(this.PurchaseEntity)
  //   .then((data) => {
  //     swal({
  //       type: 'success',
  //       title: 'Success...!!!',
  //       text: 'Your payment is successfully.',
  //       showConfirmButton: false,
  //       timer: 3000
  //     })
  //   },
  //     (error) => {
  //       swal({
  //         type: 'warning',
  //         title: 'Oops...',
  //         text: 'Something is wrong.',
  //       })
  //     });
  //     })
  //   }
  // };

  // ngAfterViewChecked(): void {
  //   if (!this.addScript) {
  //     this.addPaypalScript().then(() => {
  //       paypal.Button.render(this.paypalConfig, '#paypal-checkout-btn');
  //       this.paypalLoad = false;
  //     })
  //   }
  // }
  // addPaypalScript() {
  //   this.addScript = true;
  //   return new Promise((resolve, reject) => {
  //     let scripttagElement = document.createElement('script');
  //     scripttagElement.src = 'https://www.paypalobjects.com/api/checkout.js';
  //     scripttagElement.onload = resolve;
  //     document.body.appendChild(scripttagElement);
  //   })
  // }
  Preview(i,j)
  {
    $('#myModal'+i+j).modal('show'); 

		setTimeout(function () {	
			$('.modal').on('shown.bs.modal', function () {
				$('.right_content_block').addClass('style_position');
			})
			$('.modal').on('hidden.bs.modal', function () {
				$('.right_content_block').removeClass('style_position');
			});	
			new PerfectScrollbar('#mediascrollbar'+i+j);	
			myInput();	
		}, 100);
  }
  TopicDes(i, j) {
 
    $("#desc_area" + i + j).toggle(300);
  }
  // SessionEnrollcClick(Sessionid, i) {
  //   debugger
  //   Sessionid.sid=i;
  //   this.ssid=Sessionid.sid;
  //   //  var d = new Date();
  //   var d = new Date(Sessionid.StartDate);
  //   d.setDate(d.getDate() - 1);
  //   var curr_date = d.getDate();
  //   var curr_month = d.getMonth() + 1; //Months are zero based
  //   var curr_year = d.getFullYear();
  //   if (curr_month < 10) {
  //     var month = '0' + curr_month;
  //   } else {
  //     var month = '' + curr_month;
  //   }
  //   if (curr_date < 10) {
  //     var date = '0' + curr_date;
  //   }
  //   else {
  //     var date = '' + curr_date;
  //   }
  //   this.StartDate = d;
  //   this.StartDate = curr_year + '-' + month + '-' + date;
  //   Sessionid.CourseSDate = this.StartDate;
  //   $('.imageremove').removeClass('active');
  //   $('#session' + i).addClass('active');
  //   if ((Sessionid.RemainingSeats == Sessionid.TotalSeats && Sessionid.Showstatus == "0")
  //     || (Sessionid.Showstatus == "1" && (Sessionid.CourseCloseDate < this.datea)
  //       || !(Sessionid.CourseSDate > this.datea)) || (Sessionid.EnrollCheck > "0")) {

  //     this.sessiontrue = false;
  //     if (Sessionid.RemainingSeats == Sessionid.TotalSeats && Sessionid.Showstatus == "0") {
      
  //       swal({
  //         title: 'Course is full !',
  //         type: 'warning',
  //       //  showCancelButton: true,
  //         showConfirmButton: true,
  //         cancelButtonColor: '#d33',
  //       })
  //     } else if (Sessionid.Showstatus == "1" && (Sessionid.CourseCloseDate < this.datea)) {
  //       swal({
  //         title: 'Course close date!',
  //         type: 'warning',
  //        // showCancelButton: true,
  //         showConfirmButton: true,
  //         cancelButtonColor: '#d33',
  //       })
  //     }
  //     else {
     
  //       swal({
  //         title: 'Course close !',
  //         type: 'warning',
  //        // showCancelButton: true,
  //         showConfirmButton: true,
  //         cancelButtonColor: '#d33',
  //       })
  //     }

  //   } else {

  //     this.SessionEnrollid = Sessionid.CourseSessionId;

  //     this.sessiontrue = true;
      
  //   }





  //}

  
}
