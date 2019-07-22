import { Component, OnInit } from '@angular/core';
import { Globals } from '.././globals';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
declare function myInput(): any;

import { CourseListService } from '../services/course-list.service';
declare var $, PerfectScrollbar: any;
@Component({
  selector: 'app-course-list',
  templateUrl: './course-list.component.html',
  styleUrls: ['./course-list.component.css']
})
export class CourseListComponent implements OnInit {
  CourseList;
  InstList;
  SubCategoryList;
  SkillList;
  CourseFilterEntity;

  constructor(public globals: Globals, private router: Router, private route: ActivatedRoute,
    private CourseListService: CourseListService) { }

  ngOnInit() {

    setTimeout(function () {
      $('.multiselectdropdown').multiselect({
        includeSelectAllOption: true,
        enableFiltering: true
      });
    }, 500);

    setTimeout(function () {
      if ($(".bg_white_block").height() < $(window).height() - 100) {
        $('footer').addClass('footer_fixed');
      }
      else {
        $('footer').removeClass('footer_fixed');
      }
      // $('.left_menu_toggle i').toggleClass("fa-indent");
      // $('.sidebar_wrap').toggleClass("small_menu");
      // $('.menu_right').toggleClass("active_right");
      // $('footer.footer_fixed').toggleClass("active_footermenu");
    }, 500);
    // $('.grid_btn').click(function () {
    //   $('.grid_btn').addClass("active");
    //   $('.list_btn').removeClass("active");
    //   $('.course_list_block .col-md-4').removeClass("list_block");
    // });
    // $('.list_btn').click(function () {
    //   $('.list_btn').addClass("active");
    //   $('.grid_btn').removeClass("active");
    //   $('.course_list_block .col-md-4').addClass("list_block");
    // });
    myInput();
   this.CourseFilterEntity = {};
    this.CourseListService.getAllCourse()
      //.map(res => res.json())
      .then((data) => {
        debugger
        this.CourseList = data['course'];
        this.SubCategoryList = data['sub'];
        this.InstList = data['Inst'];
        this.SkillList = data['skill'];
      },
        (error) => {
          //alert('error');

          //this.router.navigate(['/pagenotfound']);
        });


  }
  CategoryWise(CategoryId, i) {
    debugger
    this.globals.isLoading = true;
    this.CourseListService.getCategoryWise(CategoryId)
      .then((data) => {
        debugger
        this.CourseList = data;
        $('.users').removeClass('active');
        $('.test').removeClass('active');
        $('#test' + i).addClass('active');
        this.globals.isLoading = false;
      },
        (error) => {
          //alert('error');
          this.globals.isLoading = false;
        });
  }
  // Display instructor wise course
  /*InstWise(UserId, i) {
    debugger
    this.globals.isLoading = true;
    this.CourseListService.getInstWise(UserId)
      .then((data) => {
        debugger
        this.CourseList = data;
        $('.test').removeClass('active');
        $('.users').removeClass('active');
        $('#users' + i).addClass('active');
        this.globals.isLoading = false;
      },
        (error) => {
          //alert('error');
          this.globals.isLoading = false;

        });
  } */
  // clear form
  clearData(CourseFilterForm) { 
    this.globals.isLoading = true;
    this.CourseListService.getAllCourse()
      //.map(res => res.json())
      .then((data) => {
        this.CourseList = data['course'];
        this.SubCategoryList = data['sub'];
        this.InstList = data['Inst'];
        this.SkillList = data['skill'];
        this.CourseFilterEntity = {};
        this.CourseFilterEntity.CourseSkill = '';
        this.CourseFilterEntity.Instructor = '';
        this.globals.isLoading = false;
        CourseFilterForm.form.markAsPristine();

      },
        (error) => {
          //alert('error');
          this.globals.isLoading = false;
          //this.router.navigate(['/pagenotfound']);
        });

    //LearnerCourseForm.form.markAsPristine();
  }
  // course filter
  courseFilter(CourseFilterForm)
  {
    
    var CourseFullName = $("#CourseFullName").val();
    var CourseSkill = $("#CourseSkill").val();
    var Instructor = $("#Instructor").val();
    if(CourseFullName != null)
    {
      this.CourseFilterEntity.CourseFullName =  CourseFullName.toString();
    }
    else
    {
      this.CourseFilterEntity.CourseFullName = '';
    }
    if(CourseSkill != null)
    {
      this.CourseFilterEntity.CourseSkill =  CourseSkill.toString();
    }
    else
    {
      this.CourseFilterEntity.CourseSkill = '';
    }
    if(Instructor != null)
    {
      this.CourseFilterEntity.Instructor =  Instructor.toString();
    }
    else
    {
      this.CourseFilterEntity.Instructor = '';
    }

    this.CourseListService.courseFilter(this.CourseFilterEntity)
      //.map(res => res.json())
      .then((data) => {
        this.CourseList = data['Course'];
        this.globals.isLoading = false;

      },
        (error) => {
          //alert('error');
          this.globals.isLoading = false;
          //this.router.navigate(['/pagenotfound']);
        });
    
  }
}
