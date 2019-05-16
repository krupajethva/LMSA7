import { Component, OnInit } from '@angular/core';
import { CourseListService } from '../services/course-list.service';
import { Globals } from '.././globals';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
declare var $, swal, paypal, getAccordion: any;
declare function myInput(): any;

@Component({
  selector: 'app-course-rating',
  templateUrl: './course-rating.component.html',
  styleUrls: ['./course-rating.component.css']
})
export class CourseRatingComponent implements OnInit {

	reviewEntity;
	CourseReviewList;
	ReviewAverage;
	btn_disable;
	submitted;
	disabled;
	errorText;
	CourseName;
  courseid;
  allowUser;
  UserDetail;
  display;

  constructor(private CourseListService: CourseListService, private globals: Globals, private router: Router, private route: ActivatedRoute) { }

  ngOnInit() {
    this.allowUser = false;
    this.errorText = false;
    this.display=false;
	  myInput();
	  setTimeout(function () {
      if ($(".bg_white_block").hasClass("ps--active-y")) {
        $('footer').removeClass('footer_fixed');
      }
      else {
        $('footer').addClass('footer_fixed');
      }
	  
	  $('.write_review :radio').change(function() {
		console.log('New star rating: ' + this.value);
	});
		}, 1000);
		
		this.reviewEntity={};
		let id = this.route.snapshot.paramMap.get('id');
    this.courseid = id;
    var obj = { 'CourseId': this.route.snapshot.paramMap.get('id'), 'UserId': this.globals.authData.UserId };
    this.CourseListService.checkUser(obj)
      .then((data) => {
        if(data=="Duplicate User"){
          this.allowUser=true;
        }
      },
        (error) => {
          
        });
        this.CourseListService.getUserDetail(this.globals.authData.UserId)
        
        .then((data) => {
          this.UserDetail=data;
        },
          (error) => {
            
          });
		this.CourseListService.getAllReviews(obj)
      //.map(res => res.json())
      .then((data) => {
				this.CourseName = data['CourseName'];
        this.CourseReviewList = data['Reviews'];
        this.ReviewAverage = this.CourseReviewList[0].reviewavg;
      },
        (error) => {
          //alert('error');

          //this.router.navigate(['/pagenotfound']);
        });
	}
	
	addReview(reviewForm,review) {
    debugger
    let id = this.route.snapshot.paramMap.get('id');
    this.submitted = true;
    //console.log(this.reviewEntity);
    if(review==0){
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
          this.reviewEntity.UserImage = this.UserDetail.UserImage;
          this.reviewEntity.ReviewId = data['ReviewData']['ReviewId'];
          this.reviewEntity.ReviewTime = data['ReviewData']['ReviewTime'];
          this.ReviewAverage = data['Reviews'][0].reviewavg;

          if(review==0){
            this.CourseReviewList.unshift(this.reviewEntity);
            $('#write_review').toggle(100);
          }
          else{
            let index = this.CourseReviewList.indexOf(review);
            this.CourseReviewList[index].Rating=this.reviewEntity.Ratings;
            this.CourseReviewList[index].ReviewTime=this.reviewEntity.ReviewTime;
            this.CourseReviewList[index].ReviewComment=this.reviewEntity.ReviewComment;
            
            $('#content'+index+' .content').show(100);
            $('#content'+index+' .star_review').show(100);
            $('#write_review'+index).toggle(100);
          }
          
          this.btn_disable = false;
          this.submitted = false;
          this.disabled = false;
          this.reviewEntity = {};
          this.allowUser=true;
          // if(this.reviewEntity.ReviewId && this.reviewEntity.ReviewId>0){
          //   setTimeout(function () {
          //     $("#edit_review").click(function () {
          //       $('.content_name .write_review').toggle(400);
          //     });
          // }, 500);
          // }
          // else{
          //   setTimeout(function () {
          //   $("#review_btn").click(function () {
          //     $('#write_review').toggle(400);
          //   });
          // }, 500);
          // }
          
        reviewForm.form.markAsPristine();

        if(review==0){
          swal({
           
            type: 'success',
            title: 'Added!',
            text: 'Your review has been added successfully',
            showConfirmButton: false,
            timer: 1500
          })
        }
        else{
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
  editDiv(review,i){
    debugger
    this.reviewEntity=review;
    this.reviewEntity.Ratings = review.Rating; 

    if($('#write_review'+i).is(':visible')){
      var check = true;
    } else {
      var check = false;
    }
    if(check){
      $('#write_review'+i).hide(100);
      $('#content'+i+' .content').show(400);
      $('#content'+i+' .star_review').show(400);
    } else {
      $('#write_review'+i).show(100);
      $('#content'+i+' .content').hide(400);
      $('#content'+i+' .star_review').hide(400);
    }
    this.display=false;
      setTimeout(function () {
      myInput();
  }, 100);
  }
  clear_rating(){
    $('.write_review input[type="radio"]').prop("checked", false);
        this.reviewEntity.Ratings = null; 
  }
  deleteReview(review){
    debugger
    swal({
      
       title: 'Delete a review',
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
              this.allowUser=false;
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
  openDiv(){
    this.reviewEntity = {};
    this.display=true;
    $('#write_review').toggle(400);
    setTimeout(function () {
      myInput();
  }, 100);
  }
}
