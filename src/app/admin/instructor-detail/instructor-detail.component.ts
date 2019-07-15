import { Component, OnInit } from '@angular/core';
import { InstructorfollowersService } from '../services/instructorfollowers.service';
import { Globals } from '.././globals';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
declare var $: any;


@Component({
  selector: 'app-instructor-detail',
  templateUrl: './instructor-detail.component.html',
  styleUrls: ['./instructor-detail.component.css']
})
export class InstructorDetailComponent implements OnInit {
  InstructorId;
  flag;
  totalFollowers;
  totalFolloings;
  Ratings;
  Reviews;
  Biography;
  Education;
  ProfileImage;
  InstructorUserId;
  ActiveCourses;
  FollowerDetail;
  FirstName;
  LastName;
  EmailAddress;
  totalcoursesdetails;
  totalcourses;
  InstructorEntity;


  constructor(private InstructorfollowersService: InstructorfollowersService, private globals: Globals, private router: Router, private route: ActivatedRoute) { }


  ngOnInit() {
    this.InstructorEntity = {};

  //this.FollowerDetail=[];
  this.totalcoursesdetails=[];
	  setTimeout(function () {
      if ($(".bg_white_block").hasClass("ps--active-y")) {
        $('footer').removeClass('footer_fixed');
      }
      else {
        $('footer').addClass('footer_fixed');
      }
	  
    }, 1000);
    let id = this.route.snapshot.paramMap.get('id');
    if(id){
      this.InstructorId=id;
    }else{
      this.InstructorId=this.globals.authData.UserId;
    }
   
    var obj = { 'InstructorId': this.InstructorId, 'LearnerId': this.globals.authData.UserId };
    this.InstructorfollowersService.getInstructorDetails(obj)
    .then((data) => {
      if (data) {
        console.log(data);
          this.FollowerDetail = data['FollowerDetail'];
          if(this.FollowerDetail!=null){
          this.flag = this.FollowerDetail.flag;
          this.totalFollowers = this.FollowerDetail.totalFollowers;
          this.totalFolloings = this.FollowerDetail.totalFolloings;
          this.Reviews = this.FollowerDetail.Reviews;
          this.Ratings = this.FollowerDetail.Ratings;
          this.totalcoursesdetails = this.FollowerDetail.totalcoursesdetails;
          console.log(this.totalcoursesdetails);
         this.totalcourses =this.totalcoursesdetails.length;
       
          }
          else{
            this.flag = 0;
            this.totalFollowers = 0;
            this.totalFolloings = 0;
          }
          this.FirstName = data['InstructorDetail']['FirstName'];
          this.LastName = data['InstructorDetail']['LastName'];
          this.Biography = data['InstructorDetail']['Biography'];
          this.Education = data['InstructorDetail']['Education'];
          this.ProfileImage = data['InstructorDetail']['ProfileImage'];
          this.InstructorUserId = data['InstructorDetail']['UserId'];
          
          this.EmailAddress = data['InstructorDetail']['EmailAddress'];
          this.ActiveCourses = data['ActiveCourses'];
      }
    },
      (error) => {
        //this.router.navigate(['/pagenotfound']);
      });
  }
  followInstructor() {
    debugger
    var follow = { 'InstructorId': this.InstructorId, 'LearnerId': this.globals.authData.UserId };
    this.InstructorfollowersService.followInstructor(follow)
      .then((data) => {
        this.globals.isLoading = false;
        $('#follow').hide();
        this.flag=1;
        this.totalFollowers = this.totalFollowers + 1;
        $('#unfollow').show();
      },
        (error) => {
          if (error.text) {
            alert("Error");
          }
        });
  }
  unfollowInstructor() {
    debugger
    var unfollow = { 'InstructorId': this.InstructorId, 'LearnerId': this.globals.authData.UserId };
    this.InstructorfollowersService.unfollowInstructor(unfollow)
      .then((data) => {
        this.globals.isLoading = false;
        $('#unfollow').hide();
        this.flag=0;
        this.totalFollowers = this.totalFollowers - 1;
        $('#follow').show();
      },
        (error) => {
          if (error.text) {
            alert("Error");
          }
        });
  }

  // SearchCourse(InstructorForm) {
  //   if ((this.InstructorEntity.Search == undefined || this.InstructorEntity.Search == "" || this.InstructorEntity.Search == null) ) {

  //   } else {
  //     if (InstructorForm.valid) {
  //       this.globals.isLoading = true;

  //       //   this.SalesDashboardEntity.CompanyId;
  //       // 	this.SalesDashboardEntity.UserId;
  //       // this.vardisabled=true;
  //       if (this.InstructorEntity.Search == undefined) {
  //         this.InstructorEntity.Search = null;
  //       }
      
  //       var data = {'Name': this.InstructorEntity.Search, 'user': this.globals.authData.UserId };
  //       this.InstructorfollowersService.SearchCourse(data)
  //         .then((data) => {
  //           this.globals.isLoading = false;
  //           // this.hideowner=false;
  //           // this.header_var = 'List of all users';
  //           //alert('success');
  //           if (data == 'error') {
  //             this.InstructorList = [];
  //           }
  //           else {
  //             this.InstructorList = data['search'];
  //           }
  //           setTimeout(function () {
  //             $('.modal').on('shown.bs.modal', function () {
  //               $('.right_content_block').addClass('style_position');
  //             })
  //             $('.modal').on('hidden.bs.modal', function () {
  //               $('.right_content_block').removeClass('style_position');
  //             });
  //             // myInput();
  //           },
  //             500);
  //           // this.btn_disable = false;
  //           // this.submitted = false;
  //           // this.globals.isLoading = false;
  //         },
  //           (error) => {
  //             //alert('error');
  //             // this.btn_disable = false;
  //             // this.submitted = false;
  //             // this.globals.isLoading = false;
  //             // this.router.navigate(['/pagenotfound']);

  //           });
  //     }

  //   }
  // }
}
