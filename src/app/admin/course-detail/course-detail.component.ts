import { Component, OnInit } from '@angular/core';
import { CourseListService } from '../services/course-list.service';
import { InstructorfollowersService } from '../services/instructorfollowers.service';
import { Globals } from '.././globals';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
declare var $, swal, paypal, getAccordion, PerfectScrollbar: any;
declare function myInput(): any;

@Component({
  selector: 'app-course-detail',
  templateUrl: './course-detail.component.html',
  styleUrls: ['./course-detail.component.css']
})
export class CourseDetailComponent implements OnInit {
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
  shareEntity;
  submitted1;
  url = this.globals.baseUrl+'/course-detail/'+this.route.snapshot.paramMap.get('id');
    text = 'Learning Management System';
   // imageUrl = 'http://jasonwatmore.com/_content/images/jason.jpg';
  constructor(private CourseListService: CourseListService, private InstructorfollowersService: InstructorfollowersService, private globals: Globals, private router: Router, private route: ActivatedRoute) { }

  ngOnInit() {
    this.shareEntity={};
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
    this.sessiontrue = false;
    this.Relatedcourse=[];
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


      getAccordion("#tabs", 768);

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
      .then((data) => {
        if (data) {
          this.CourseDetailList = data['detail'];
          this.CourseSesssionList = data['session'];
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
            this.Relatedcourse = data['skill'];
            this.ReviewAverage = this.CourseReviewList[0].reviewavg;
          //console.log(this.CourseDiscussionList);
        }
      },
        (error) => {
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
  //       text: 'Your payment has been successfully.',
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

  relatedcourse(CourseId)
  {

window.location.href='/course-detail/'+CourseId;
  }
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
  add()
  {
    $('#modalsession').modal('show'); 
  }
  Enroll(Sessionid,i) {
    debugger
    Sessionid.sid=i;
    this.ssid=Sessionid.sid;
    this.globals.isLoading = true;
    var Enrolla = { 'CourseSessionId':  Sessionid.CourseSessionId, 'UserId': this.globals.authData.UserId };
    this.CourseListService.addEnroll(Enrolla)
      .then((data) => {
        //this.router.navigate(['/payment']);  
        swal({
          type: 'success',
          title: 'Success!',
          text: 'Course Enroll has been successfully.',
          showConfirmButton: false,
          timer: 3000
        })
        this.globals.isLoading = false;
        for (var i = 0; i < this.CourseContent.length; i++) 
        	{
            for (var j = 0; j < this.CourseContent[i].child.length; j++) 
            {
              this.CourseContent[i].child[j].enroll=1;
            }
          }
        this.CourseSesssionList[this.ssid].EnrollCheck =1;
        this.CourseSesssionList[this.ssid].RemainingSeats = +this.CourseSesssionList[this.ssid].RemainingSeats + +1;
        $('#modalsession').modal('hide'); 
      },
        (error) => {
          alert('error');
          this.globals.isLoading=false;
        });
  }
  start_discusion() {
    this.postEntity = {};
    $('.write_discusion').toggle(100);
    $('.write_reply').hide(100);
    $('.edit_reply').hide(100);
    $('.content_name .content').show(100);
  }
  addPost(postForm, discussion) {
    let id = this.route.snapshot.paramMap.get('id');
    this.submitted = true;
    if (discussion == 0) {
      this.postEntity.count = 0;
      this.postEntity.CreatedBy = this.globals.authData.UserId;
    }

    this.postEntity.UpdatedBy = this.globals.authData.UserId;
    this.postEntity.UserId = this.globals.authData.UserId;
    this.postEntity.CourseId = id;
    if (postForm.valid) {
      this.CourseListService.addPost(this.postEntity)
        .then((data) => {
          debugger
          this.postEntity.DiscussionId = data['DiscussionId'];
          this.postEntity.PostTime = data['PostTime'];
          //this.CourseDiscussionList.push(this.postEntity);
          this.postEntity.Name = this.UserDetail.Name;
          this.postEntity.ProfileImage = this.UserDetail.ProfileImage;
          if (discussion == 0) {
            this.CourseDiscussionList.unshift(this.postEntity);
            $('.write_discusion').toggle(100);
          } else {
            var index = this.CourseDiscussionList.indexOf(discussion);
            this.CourseDiscussionList[index].PostTime = this.postEntity.PostTime;
            this.CourseDiscussionList[index].Comment = this.postEntity.Comment;
            $('#content' + index + ' .content').show(100);
            $('#edit_reply' + index).toggle(100);
          }

          this.btn_disable = false;
          this.submitted = false;
          this.disabled = false;
          this.postEntity = {};

          postForm.form.markAsPristine();
          if (discussion == 0) {
            swal({
              type: 'success',
              title: 'Added!',
              text: 'Your comment has been added successfully',
              showConfirmButton: false,
              timer: 1500
            })
          }
          else {
            swal({
             
              type: 'success',
              title: 'Updated!',
              text: 'Your comment has been updated successfully',
              showConfirmButton: false,
              timer: 1500
            })
          }

          //this.router.navigate(['/announcementlist']);
        },
          (error) => {
            this.btn_disable = false;
            this.submitted = false;
            this.globals.isLoading = false;
            this.router.navigate(['/pagenotfound']);
          });
    }
  }
  addCommentReply(replyForm, Discussion, firstlevelreply, secondlevelreply, ReplyEdit) {
    //alert(firstlevelreply);
    debugger
    let id = this.route.snapshot.paramMap.get('id');
    this.submitted = true;
    this.postEntity.UpdatedBy = this.globals.authData.UserId;
    this.postEntity.UserId = this.globals.authData.UserId;
    this.postEntity.CourseId = id;
    if (firstlevelreply == 0 && secondlevelreply == 0 && ReplyEdit == 1) {
      this.postEntity.count = 0;
      this.postEntity.ParentId = Discussion.DiscussionId;
      this.postEntity.CreatedBy = this.globals.authData.UserId;
    } else if (firstlevelreply != 0 && secondlevelreply == 0 && ReplyEdit == 1) {
      this.postEntity.count = 0;
      this.postEntity.ParentId = firstlevelreply.DiscussionId;
    }

    if (replyForm.valid) {
      this.CourseListService.addCommentReply(this.postEntity)
        .then((data) => {
          debugger
          if (ReplyEdit == 1) {
            this.postEntity.DiscussionId = data['DiscussionId'];
            this.postEntity.PostTime = data['PostTime'];
            this.postEntity.Name = this.UserDetail.Name;
            this.postEntity.ProfileImage = this.UserDetail.ProfileImage;
            this.postEntity.Reply = this.postEntity.CommentReply;
          }
          else {
            this.postEntity.PostTime = data['PostTime'];
            this.postEntity.Reply = this.postEntity.CommentReply;
          }
          //this.CourseDiscussionList.push(this.postEntity);

          if (firstlevelreply == 0 && secondlevelreply == 0 && ReplyEdit == 1) {
            let index = this.CourseDiscussionList.indexOf(Discussion);
            if (this.CourseDiscussionList[index].child == undefined) {
              this.CourseDiscussionList[index].child = [];
            }
            this.CourseDiscussionList[index].child.unshift(this.postEntity);
            this.CourseDiscussionList[index].count++;
            $('#write_reply' + index).hide(100);
          }
          else if (firstlevelreply != 0 && secondlevelreply == 0 && ReplyEdit == 1) {
            let index = this.CourseDiscussionList.indexOf(Discussion);
            let index_child = this.CourseDiscussionList[index].child.indexOf(firstlevelreply);
            if (this.CourseDiscussionList[index].child[index_child].child == undefined) {
              this.CourseDiscussionList[index].child[index_child].child = [];
            }
            this.CourseDiscussionList[index].child[index_child].child.unshift(this.postEntity);
            this.CourseDiscussionList[index].child[index_child].count++;
            $('#write_reply' + index + index_child).hide(100);
          }
          else if (firstlevelreply != 0 && secondlevelreply == 0 && ReplyEdit == 2) {
            let index = this.CourseDiscussionList.indexOf(Discussion);
            let index_child = this.CourseDiscussionList[index].child.indexOf(firstlevelreply);

            this.CourseDiscussionList[index].child[index_child].PostTime = this.postEntity.PostTime;
            this.CourseDiscussionList[index].child[index_child].CommentReply = this.postEntity.CommentReply;

            //this.CourseDiscussionList[index].child[index_child].count++;
            $('#edit_reply' + index + index_child).hide(100);
            $('#content' + index + index_child + ' .content').show(100);
          }
          else if (firstlevelreply != 0 && secondlevelreply != 0 && ReplyEdit == 2) {
            let index = this.CourseDiscussionList.indexOf(Discussion);
            let index_child = this.CourseDiscussionList[index].child.indexOf(firstlevelreply);
            let index_c_child = this.CourseDiscussionList[index].child[index_child].child.indexOf(secondlevelreply);

            this.CourseDiscussionList[index].child[index_child].child[index_c_child].PostTime = this.postEntity.PostTime;
            this.CourseDiscussionList[index].child[index_child].child[index_c_child].CommentReply = this.postEntity.CommentReply;

            // this.CourseDiscussionList[index].child[index_child].count++;
            $('#edit_reply' + index + index_child + index_c_child).hide(100);
            $('#content' + index + index_child + index_c_child + ' .content').show(100);
          }

          this.btn_disable = false;
          this.submitted = false;
          this.disabled = false;
          this.postEntity = {};
          //$(this).next().next().toggle(400);
          replyForm.form.markAsPristine();

          if (ReplyEdit == 1) {
            swal({
             
              type: 'success',
              title: 'Added!',
              text: 'Your reply has been added successfully',
              showConfirmButton: false,
              timer: 1500
            })
          }
          else {
            swal({
              type: 'success',
              title: 'Updated!',
              text: 'Your reply has been updated successfully',
              showConfirmButton: false,
              timer: 1500
            })
          }

        },
          (error) => {
            this.btn_disable = false;
            this.submitted = false;
            this.globals.isLoading = false;
            this.router.navigate(['/pagenotfound']);
          });
    }
  }

  openCommentBox(i) {
    this.postEntity = {};
    //replyForm.form.markAsPristine();
    setTimeout(function () {
      myInput();
    }, 100);
    if ($('#write_reply' + i).is(':visible')) {
      var check = true;
    } else {
      var check = false;
    }
    $('.write_reply').hide(100);
    $('.edit_reply').hide(100);
    $('.content_name .content').show(100);

    if (check) {
      $('#write_reply' + i).hide(100);
    } else {
      $('#write_reply' + i).show(100);
    }

  }

  openCommentReplyBox(i, j) {
    this.postEntity = {};
    //replyForm.form.markAsPristine();
    setTimeout(function () {
      myInput();
    }, 100);
    if ($('#write_reply' + i + j).is(':visible')) {
      var check = true;
    } else {
      var check = false;
    }
    $('.write_reply').hide(100);
    $('.edit_reply').hide(100);
    $('.content_name .content').show(100);
    if (check) {
      $('#write_reply' + i + j).hide(100);
    } else {
      $('#write_reply' + i + j).show(100);
    }
  }

  followInstructor(CourseDetailList) {
    debugger
    this.followerEntity = CourseDetailList;
    var follow = { 'InstructorId': CourseDetailList.InstructorId, 'LearnerId': this.globals.authData.UserId };
    this.InstructorfollowersService.followInstructor(follow)
      .then((data) => {
        this.globals.isLoading = false;
        this.CourseDetailList.isfollowed = 1;
      },
        (error) => {
          if (error.text) {
            alert("Error");
          }
        });
  }
  unfollowInstructor(CourseDetailList) {
    debugger
    this.followerEntity = CourseDetailList;
    var unfollow = { 'InstructorId': CourseDetailList.InstructorId, 'LearnerId': this.globals.authData.UserId };
    this.InstructorfollowersService.unfollowInstructor(unfollow)
      .then((data) => {
        this.globals.isLoading = false;
        this.CourseDetailList.isfollowed = 0;
      },
        (error) => {
          if (error.text) {
            alert("Error");
          }
        });
  }
  addReview(reviewForm, review) {
    debugger
    let id = this.route.snapshot.paramMap.get('id');
    this.submitted = true;
    //console.log(this.reviewEntity);
    if (review == 0) {
      this.reviewEntity.CreatedBy = this.globals.authData.UserId;
    }
    this.reviewEntity.UpdatedBy = this.globals.authData.UserId;
    this.reviewEntity.UserId = this.globals.authData.UserId;
    this.reviewEntity.CourseId = id;
    if (this.reviewEntity.Ratings == "" || this.reviewEntity.Ratings == null || this.reviewEntity.Ratings == undefined) {
      this.errorText = true;
    } else {
      this.errorText = false;
    }
    if (reviewForm.valid && !this.errorText) {
      this.CourseListService.addReview(this.reviewEntity)
        .then((data) => {
          debugger
          this.reviewEntity.Rating = this.reviewEntity.Ratings;
          this.reviewEntity.Name = this.UserDetail.Name;
          this.reviewEntity.ProfileImage = this.UserDetail.ProfileImage;
          this.reviewEntity.ReviewId = data['ReviewData']['ReviewId'];
          this.reviewEntity.ReviewTime = data['ReviewData']['ReviewTime'];
          this.ReviewAverage = data['Reviews'][0].reviewavg;

          if (review == 0) {
            this.CourseReviewList.unshift(this.reviewEntity);
            $('#write_review').toggle(100);
          }
          else {
            let index = this.CourseReviewList.indexOf(review);
            this.CourseReviewList[index].Rating = this.reviewEntity.Ratings;
            this.CourseReviewList[index].ReviewTime = this.reviewEntity.ReviewTime;
            this.CourseReviewList[index].ReviewComment = this.reviewEntity.ReviewComment;

            $('#content' + index + ' .content').show(100);
            $('#content' + index + ' .star_review').show(100);
            $('#write_review' + index).toggle(100);
          }

          this.btn_disable = false;
          this.submitted = false;
          this.disabled = false;
          this.reviewEntity = {};
          this.allowUser = true;
          reviewForm.form.markAsPristine();

          if (review == 0) {
            swal({
              type: 'success',
              title: 'Added!',
              text: 'Your review has been added successfully',
              showConfirmButton: false,
              timer: 1500
            })
          }
          else {
            swal({
             
              type: 'success',
              title: 'Updated!',
              text: 'Your review has been updated successfully',
              showConfirmButton: false,
              timer: 1500
            })
          }

          //this.router.navigate(['/announcementlist']);
        },
          (error) => {
            this.btn_disable = false;
            this.submitted = false;
            this.globals.isLoading = false;
            this.router.navigate(['/pagenotfound']);
          });
    }
  }
  editDiv(review, i) {
    debugger
    this.reviewEntity = review;
    this.reviewEntity.Ratings = review.Rating;

    if ($('#write_review' + i).is(':visible')) {
      var check = true;
    } else {
      var check = false;
    }
    if (check) {
      $('#write_review' + i).hide(100);
      $('#content' + i + ' .content').show(400);
      $('#content' + i + ' .star_review').show(400);
    } else {
      $('#write_review' + i).show(100);
      $('#content' + i + ' .content').hide(400);
      $('#content' + i + ' .star_review').hide(400);
    }
    this.display = false;
    setTimeout(function () {
      myInput();
    }, 100);
  }
  clear_rating() {
    $('.write_review input[type="radio"]').prop("checked", false);
    this.reviewEntity.Ratings = null;

    //alert(this.reviewEntity.Ratings);
  }
  editDiscussion(discussion, i) {
    debugger
    this.postEntity = discussion;
    //console.log(this.postEntity);

    if ($('#edit_reply' + i).is(':visible')) {
      var check = true;
    } else {
      var check = false;
    }
    $('.write_reply').hide(100);
    $('.edit_reply').hide(100);
    $('.content_name .content').show(100);
    if (check) {
      $('#edit_reply' + i).hide(100);
      $('#content' + i + ' .content').show(100);
    } else {
      $('#edit_reply' + i).show(100);
      $('#content' + i + ' .content').hide(100);
    }
    $('.write_discusion').hide(100);
    setTimeout(function () {
      myInput();
    }, 100);
  }
  editReply(firstlevelreply, i, j) {
    debugger
    this.postEntity = firstlevelreply;
    this.postEntity.CommentReply = firstlevelreply.Reply;
    console.log(this.postEntity);

    if ($('#edit_reply' + i + j).is(':visible')) {
      var check = true;
    } else {
      var check = false;
    }
    $('.write_reply').hide(100);
    $('.edit_reply').hide(100);
    $('.content_name .content').show(100);
    if (check) {
      $('#edit_reply' + i + j).hide(100);
      $('#content' + i + j + ' .content').show(100);
    } else {
      $('#edit_reply' + i + j).show(100);
      $('#content' + i + j + ' .content').hide(100);
    }
    $('.write_discusion').hide(100);
    setTimeout(function () {
      myInput();
    }, 100);
  }
  editReplyReply(secondlevelreply, i, j, k) {
    debugger
    this.postEntity = secondlevelreply;
    this.postEntity.CommentReply = secondlevelreply.Reply;
    console.log(this.postEntity);

    if ($('#edit_reply' + i + j + k).is(':visible')) {
      var check = true;
    } else {
      var check = false;
    }
    $('.write_reply').hide(100);
    $('.edit_reply').hide(100);
    $('.content_name .content').show(100);
    if (check) {
      $('#edit_reply' + i + j + k).hide(100);
      $('#content' + i + j + k + ' .content').show(100);
    } else {
      $('#edit_reply' + i + j + k).show(100);
      $('#content' + i + j + k + ' .content').hide(100);
    }
    $('.write_discusion').hide(100);
    setTimeout(function () {
      myInput();
    }, 100);
  }
  deleteReview(review) {
    swal({
      title: 'Delete a Review',
      text: "Are you sure you want to delete this review?",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes',
      cancelButtonText: 'No'
    })
      .then((result) => {
        if (result.value) {
          this.globals.isLoading = true;
          var obj = { 'CourseId': this.route.snapshot.paramMap.get('id'), 'ReviewId': review.ReviewId, 'UserId': this.globals.authData.UserId};
          this.CourseListService.deleteReview(obj)
            .then((data) => {
              let index = this.CourseReviewList.indexOf(review);
              if (index != -1) {
                this.CourseReviewList.splice(index, 1);
              }
              this.ReviewAverage = data['Reviews'][0].reviewavg;
              this.allowUser = false;
              this.globals.isLoading = false;
              swal({
                type: 'success',
                title: 'Deleted!',
                text: 'Your review has been deleted successfully',
                showConfirmButton: false,
                timer: 1500
              })
            },
              (error) => {
              });
        }
      })
  }

  deleteDiscussion(discussion, firstreply, secondreply, levelId) {
    debugger
    swal({
      title: 'Delete a Comment',
      text: "Are you sure you want to delete this comment?",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes',
      cancelButtonText: 'No'
    })
      .then((result) => {
        if (result.value) {
          this.globals.isLoading = true;
          //alert(discussion.DiscussionId);
          this.CourseListService.deleteDiscussion(discussion.DiscussionId)
            .then((data) => {

              if (levelId == 1) {
                let index = this.CourseDiscussionList.indexOf(discussion);
                if (index != -1) {
                  this.CourseDiscussionList.splice(index, 1);
                }
              }
              if (levelId == 2) {
                let index = this.CourseDiscussionList.indexOf(firstreply);
                let index_child = this.CourseDiscussionList[index].child.indexOf(discussion);
                if (index_child != -1) {
                  this.CourseDiscussionList[index].child.splice(index_child, 1);
                  this.CourseDiscussionList[index].count--;
                }
              }
              if (levelId == 3) {
                let index = this.CourseDiscussionList.indexOf(firstreply);
                let index_child = this.CourseDiscussionList[index].child.indexOf(secondreply);
                let index_child_child = this.CourseDiscussionList[index].child[index_child].child.indexOf(discussion);
                if (index_child_child != -1) {
                  this.CourseDiscussionList[index].child[index_child].child.splice(index_child_child, 1);
                  this.CourseDiscussionList[index].child[index_child].count--;
                }
              }

              this.allowUser = false;
              this.globals.isLoading = false;
              swal({
               
                type: 'success',
                title: 'Deleted!',
                text: 'Your comment has been deleted successfully',
                showConfirmButton: false,
                timer: 1500
              })
            },
              (error) => {
              });
        }
      })
  }

  openDiv() {
    this.reviewEntity = {};
    this.display = true;
    $('#write_review').toggle(400);
    setTimeout(function () {
      myInput();
    }, 100);
  }
  openModal(){
    this.shareEntity={};
    $('#Share_Modal').modal('show');
  }
  noForm1(shareForm) {
		this.shareEntity = {};
		this.submitted1 = false;
		shareForm.form.markAsPristine();
	}
  shareConfirm(shareForm){
    this.submitted1=true;
    if (shareForm.valid) {
      this.globals.isLoading = true;
      this.shareEntity.courseName=this.CourseDetailList['CourseFullName'];
      this.shareEntity.skills=this.CourseDetailList['Keyword'];
      this.shareEntity.price=this.CourseDetailList['Price'];
      this.shareEntity.FirstName=this.globals.authData.FirstName;
      this.shareEntity.LastName=this.globals.authData.LastName;
      this.shareEntity.CourseId=this.route.snapshot.paramMap.get('id');
      this.CourseListService.shareCourse(this.shareEntity)
        .then((data) => {
          swal({
            type: 'success',
            title: 'Shared!',
            text: 'This course has been shared successfully',
            showConfirmButton: false,
            timer: 1500
          })
          $('#Share_Modal').modal('hide');
          this.submitted1=false;
          this.globals.isLoading = false;
        },
        (error) => {
          this.btn_disable = false;
          this.submitted1 = false;
          this.globals.isLoading = false;
          this.router.navigate(['/pagenotfound']);
        });
    }
  }
}
