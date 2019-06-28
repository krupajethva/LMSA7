import { Component, OnInit, ElementRef } from '@angular/core';
import { InstructorCoursesService } from '../services/instructor-courses.service';
import { LearnerCoursesService } from '../services/learner-courses.service';
import { Globals } from '.././globals';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
declare function myInput(): any;
declare var $, PerfectScrollbar, swal: any;
@Component({
  selector: 'app-instructor-courses',
  templateUrl: './instructor-courses.component.html',
  styleUrls: ['./instructor-courses.component.css']
})
export class InstructorCoursesComponent implements OnInit {
  SubCategoryList;
  InstructorCourseEntity;
  CourseList;
  btn_disable;
  submitted;
  ss;
  CoursescctionList;
  CourseSesssionList;
  CoursetopicList;
  Checktopicvalid;
  Checksessionvalid;
  CheckCoursevalid;
  CoursecloneEntity;
  datea;
  Ctime;
  SCtime;
  ECtime;
  coursestarthours;
  courseendhours;
  totalinstructor;
  Revokeable;
  ReInviteable;

  constructor(public globals: Globals, private router: Router, private elem: ElementRef, private route: ActivatedRoute,
    private InstructorCoursesService: InstructorCoursesService, private LearnerCoursesService: LearnerCoursesService) { }
  ngOnInit() {

    this.InstructorCourseEntity = {};
    this.CoursecloneEntity = {};
    this.Checktopicvalid = true;
    this.Checksessionvalid = true;
    this.CheckCoursevalid = true;
    this.ReInviteable = false;
    this.Revokeable = false;


    var d = new Date();
    var curr_date = d.getDate();
    var curr_month = d.getMonth() + 1; //Months are zero based
    var curr_year = d.getFullYear();
    // var curr_Hours=  d.getHours(); // => 9
    // var curr_Minutes=d.getMinutes(); // =>  30

    // this.Ctime=curr_Hours+':'+curr_Minutes;
    //alert(this.Ctime);

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



    setTimeout(function () {

      $('.skip_btn').click(function () {
        $('.skiped_block').addClass("active");
      });
      $('.skiped_block .close_skip').click(function () {
        $('.skiped_block').removeClass("active");
      });

      new PerfectScrollbar('.course_clone_block');
      //new PerfectScrollbar('.instructor_scroll');

      $('.modal').on('shown.bs.modal', function () {
        $('.right_content_block').addClass('style_position');
      })
      $('.modal').on('hidden.bs.modal', function () {
        $('.right_content_block').removeClass('style_position');
      });



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
      $('.modal').on('shown.bs.modal', function () {
        $('.right_content_block').addClass('style_position');
      })
      $('.modal').on('hidden.bs.modal', function () {
        $('.right_content_block').removeClass('style_position');
      });
    },
      500);



    this.InstructorCoursesService.getAllParent()
      //.map(res => res.json())
      .then((data) => {
        this.SubCategoryList = data['sub'];
        this.coursestarthours = data['coursestarthours'];
        this.courseendhours = data['courseendhours'];
        var hours = d.getHours() < 10 ? "0" + d.getHours() : d.getHours() + Number(this.coursestarthours.Value);
        var minutes = d.getMinutes() < 10 ? "0" + d.getMinutes() : d.getMinutes();
        var seconds = d.getSeconds() < 10 ? "0" + d.getSeconds() : d.getSeconds();
        this.Ctime = hours + ":" + minutes + ":" + seconds;
        this.SCtime = curr_year + '-' + month + '-' + date + " " + hours + ":" + minutes + ":" + seconds;
        var Ehours = d.getHours() < 10 ? "0" + d.getHours() : d.getHours() - Number(this.coursestarthours.Value);
        var Eminutes = d.getMinutes() < 10 ? "0" + d.getMinutes() : d.getMinutes();
        var Eseconds = d.getSeconds() < 10 ? "0" + d.getSeconds() : d.getSeconds();
        this.ECtime = curr_year + '-' + month + '-' + date + " " + Ehours + ":" + Eminutes + ":" + Eseconds;

      },
        (error) => {
          //alert('error');
          //this.router.navigate(['/pagenotfound']);
        });
    this.InstructorCoursesService.getAllCourse(this.globals.authData.UserId)
      //.map(res => res.json())
      .then((data) => {
        this.CourseList = data['course'];
      },
        (error) => {
          //alert('error');

          //this.router.navigate(['/pagenotfound']);
        });
    myInput();

  }
  addInstructorCourse(InstructorCourseForm) {


    if (InstructorCourseForm.valid) {
      this.globals.isLoading = true;

      //   this.SalesDashboardEntity.CompanyId;
      // 	this.SalesDashboardEntity.UserId;
      // this.vardisabled=true;
      if (this.InstructorCourseEntity.CourseName == undefined) {
        this.InstructorCourseEntity.CourseName = null;
      }
      if (this.InstructorCourseEntity.CategoryId == undefined) {
        this.InstructorCourseEntity.CategoryId = 0;
      }
      var data = { 'Cat': this.InstructorCourseEntity.CategoryId, 'Name': this.InstructorCourseEntity.CourseName, 'user': this.globals.authData.UserId };
      this.InstructorCoursesService.add(data)
        .then((data) => {
          // this.hideowner=false;
          // this.header_var = 'List of all users';
          //alert('success'); this.CourseList = data['course'];
          if (data == null) {

            this.CourseList = [];
          }
          else {
            this.CourseList = data['course'];
          }

          this.btn_disable = false;
          this.submitted = false;
          this.globals.isLoading = false;
          setTimeout(function () {
            $('.modal').on('shown.bs.modal', function () {
              $('.right_content_block').addClass('style_position');
            })
            $('.modal').on('hidden.bs.modal', function () {
              $('.right_content_block').removeClass('style_position');
            });
          },
            500);

        },
          (error) => {
            //alert('error');
            this.btn_disable = false;
            this.submitted = false;
            this.globals.isLoading = false;
            this.router.navigate(['/pagenotfound']);
          });
    }

  }
  Publish(CourseSessionId, k) {

    // var Enrolla={'CourseId': CourseId,'UserId': this.globals.authData.UserId};
    swal({
      title: 'Publish a session',
      text: "Are you sure you want to publish this session?",
      type: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes'
    })
      .then((result) => {
        if (result.value) {
          this.globals.isLoading = true;
          this.InstructorCoursesService.updatePublish(CourseSessionId)
            .then((data) => {
              this.globals.isLoading = false;
              //this.router.navigate(['/payment']);  
              this.ss = data;
              this.CourseSesssionList[k].PublishStatus = 1;
              swal({
                type: 'success',
                title: 'Success!',
                text: 'Session Published successfully.',
                showConfirmButton: false,
                timer: 3000
              })
              //   this.CourseList[index].PublishStatus = 1;
              //this.router.navigate(['/payment']);  
            },
              (error) => {
                alert('error');

              });
        }
      })

  }

  view_inst_btn(CourseSessionId) {
    $('.view_inst_block' + CourseSessionId).addClass("active");
  }

  cancel_inst_btn(CourseSessionId) {
    $('.view_inst_block' + CourseSessionId).removeClass("active");
  }

  draft(CourseId, i) {
    $('#modalsession' + i).modal('hide');
    this.router.navigate(['/course/edit/' + CourseId + '/' + true]);
  }
  attendance(CourseSessionId, i) {
    $('#modalsession' + i).modal('hide');
    this.router.navigate(['/attendance/' + CourseSessionId]);
  }

  clearForm(InstructorCourseForm) {
    //this.InstructorCourseEntity = {};
    this.InstructorCourseEntity.CategoryId = '';
    this.InstructorCourseEntity.CourseName = '';
    this.InstructorCoursesService.getAllCourse(this.globals.authData.UserId)
      //.map(res => res.json())
      .then((data) => {
        this.CourseList = data['course'];

      },
        (error) => {
          //alert('error');

          //this.router.navigate(['/pagenotfound']);
        });
    this.submitted = false;
    setTimeout(function () {
      $('.modal').on('shown.bs.modal', function () {
        $('.right_content_block').addClass('style_position');
      })
      $('.modal').on('hidden.bs.modal', function () {
        $('.right_content_block').removeClass('style_position');
      });
    },
      500);
    InstructorCourseForm.form.markAsPristine();
  }

  SessionClick(CourseId, i) {
    debugger
    $('#modalsession' + i).modal('show');
    var id = { 'CourseId': CourseId, 'UserId': this.globals.authData.UserId };
    this.InstructorCoursesService.getAllsessionDetail(id)
      //.map(res => res.json())
      .then((data) => {
        if (data) {
          this.CourseSesssionList = data;

          console.log( this.CourseSesssionList);
          for (var i = 0; i < this.CourseSesssionList.length; i++) {
            if (this.CourseSesssionList[i].IsActive == 0) { this.CourseSesssionList[i].IsActive = 0; } else { this.CourseSesssionList[i].IsActive = '1'; }
            //  this.CourseSesssionList.StartDate= this.CourseSesssionList.StartDate;
          }
          setTimeout(function () {
            new PerfectScrollbar('.instructor_scroll');
          },
            500);
          // var d = new Date(this.CourseSesssionList.StartDate);
          // alert(this.CourseSesssionList.StartDate);
          // this.StartDate = d;
          // this.StartDate = curr_year + '-' + month + '-' + date;
          //  Sessionid.CourseSDate = this.StartDate;
        }
      },
        (error) => {
          //alert('error');

          //this.router.navigate(['/pagenotfound']);
        });

  }
  close(i) {

    $('#modalsession' + i).modal('hide');
  }

  Revoke(SessionList) {
    debugger
    this.InstructorCoursesService.Revoke(SessionList)
    console.log(SessionList);
      // .then((data) => {
      //       let index = this.projectList.indexOf(project);
      //       if (index != -1) {
      //         this.projectList.splice(index, 1);
      //       }

      // },
      //   (error) => {
      //     if (error.text) {
      //      //error
      //     }
      //   });

}
  StartSession(CourseSessionId, k) {

    swal({
      title: 'Start a Session',
      text: "Are you sure you want to start this session?",
      type: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes'
    })
      .then((result) => {
        if (result.value) {
          this.InstructorCoursesService.StartSession(CourseSessionId)
            //.map(res => res.json())
            .then((data) => {
              if (data) {
                this.CourseSesssionList[k].SessionStatus = 1;
                swal({
                  type: 'success',
                  title: 'Start!',
                  text: 'Session has been started.',
                  showConfirmButton: false,
                  timer: 3000
                })
              }
            },
              (error) => {
                //alert('error');

                //this.router.navigate(['/pagenotfound']);
              });
        }
      })
  }
  EndSession(CourseSessionId, k) {
    swal({
      title: 'End a Session',
      text: "Are you sure you want to end this session?",
      type: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes'
    })
      .then((result) => {
        if (result.value) {
          this.InstructorCoursesService.EndSession(CourseSessionId)
            //.map(res => res.json())
            .then((data) => {
              if (data) {
                this.CourseSesssionList[k].SessionStatus = 2;
                swal({
                  type: 'success',
                  title: 'Seesion End!',
                  text: 'Session has been ended.',
                  showConfirmButton: false,
                  timer: 3000
                })

              }
            },
              (error) => {
                //alert('error');

                //this.router.navigate(['/pagenotfound']);
              });
        }
      })
  }
  clone(CourseId) {
    this.InstructorCoursesService.getbycourseclone(CourseId)
      //.map(res => res.json())
      .then((data) => {
        if (data) {
          this.CoursetopicList = data['topic'];
          this.CoursescctionList = data['session'];
          this.CoursecloneEntity.CourseId = this.CoursescctionList[0].CourseId;
          this.Checktopicvalid = true;
          this.Checksessionvalid = true;
          this.CheckCoursevalid = true;
        }
      },
        (error) => {
          //alert('error');
          //this.router.navigate(['/pagenotfound']);
        });
  }
  courseall() {
    this.CheckCoursevalid = !this.CheckCoursevalid;
    if (this.CheckCoursevalid == true) {
      this.Checktopicvalid = true;
      this.Checksessionvalid = true;
    } else {
      this.Checktopicvalid = false;
      this.Checksessionvalid = false;
    }

    for (var i = 0; i < this.CoursetopicList.length; i++) {
      if (this.Checktopicvalid == true) {
        this.CoursetopicList[i].Checksubtopic = true;
      } else {
        this.CoursetopicList[i].Checksubtopic = false;
      }
    }

    for (var i = 0; i < this.CoursescctionList.length; i++) {
      if (this.Checksessionvalid == true) {
        this.CoursescctionList[i].Checksession = true;
      } else {
        this.CoursescctionList[i].Checksession = false;
      }
    }
  }

  topicall() {
    this.Checktopicvalid = !this.Checktopicvalid;
    for (var i = 0; i < this.CoursetopicList.length; i++) {
      if (this.Checktopicvalid == true) {
        this.CoursetopicList[i].Checksubtopic = true;
      } else {
        this.CoursetopicList[i].Checksubtopic = false;
      }
    }
    if (this.Checktopicvalid == true && this.Checksessionvalid == true) {
      this.CheckCoursevalid = true;
    }
    else {
      this.CheckCoursevalid = false;
    }
  }

  topicSuball(Checksubtopic, i) {
    this.CoursetopicList[i].Checksubtopic = !this.CoursetopicList[i].Checksubtopic;
    var count = 0;
    for (var j = 0; j < this.CoursetopicList.length; j++) {
      if (this.CoursetopicList[j].Checksubtopic == false) {
        count = count + 1;
      }
    }

    if (count == 0) {
      this.Checktopicvalid = true;
      if (this.Checktopicvalid == true && this.Checksessionvalid == true) {
        this.CheckCoursevalid = true;
      }
    } else {
      this.Checktopicvalid = false;
      this.CheckCoursevalid = false;
    }
  }
  sessionall() {
    this.Checksessionvalid = !this.Checksessionvalid;
    for (var i = 0; i < this.CoursescctionList.length; i++) {
      if (this.Checksessionvalid == true) {
        this.CoursescctionList[i].Checksession = true;
      } else {
        this.CoursescctionList[i].Checksession = false;
      }
    }
    if (this.Checktopicvalid == true && this.Checksessionvalid == true) {
      this.CheckCoursevalid = true;
    }
    else {
      this.CheckCoursevalid = false;
    }
  }
  sessionSuball(Checksession, i) {

    this.CoursescctionList[i].Checksession = !this.CoursescctionList[i].Checksession;
    var count = 0;
    for (var j = 0; j < this.CoursescctionList.length; j++) {
      if (this.CoursescctionList[j].Checksession == false) {
        count = count + 1;
      }
    }
    if (count == 0) {
      this.Checksessionvalid = true;
      if (this.Checktopicvalid == true && this.Checksessionvalid == true) {
        this.CheckCoursevalid = true;
      }

    } else {
      this.Checksessionvalid = false;
      this.CheckCoursevalid = false;

    }

  }
  clonesubmit(CloneForm) {

    // this.CoursecloneEntity = {};
    this.CoursecloneEntity.CourseId = this.CoursecloneEntity.CourseId;
    this.CoursecloneEntity.Checksession = this.Checksessionvalid;
    this.CoursecloneEntity.CheckcourseDetail = true;
    this.CoursecloneEntity.Checkbages = true;
    this.CoursecloneEntity.CheckCours = this.CheckCoursevalid;
    this.CoursecloneEntity.Checktopic = this.Checktopicvalid;
    var clone = { 'Course': this.CoursecloneEntity, 'CoursesesstionList': this.CoursescctionList, 'CourseTopicList': this.CoursetopicList };
    this.InstructorCoursesService.addclone(clone)
      //.map(res => res.json())
      .then((data) => {
        if (data) {

          // alert(data);
          window.location.href = '/course/edit/' + data;
          //  this.router.navigate(['/course/edit/'+data])

        }
      },
        (error) => {
          //alert('error');

          //this.router.navigate(['/pagenotfound']);
        });

  }
  isActiveChange(SessionEntity, i) {
    debugger
    if (this.CourseSesssionList[i].IsActive == false) {
      this.CourseSesssionList[i].IsActive = 0;
      SessionEntity.IsActive = 0;
    } else {
      this.CourseSesssionList[i].IsActive = 1;
      SessionEntity.IsActive = 1;
    }
    // this.globals.isLoading = true;
    SessionEntity.UpdatedBy = 1;

    this.InstructorCoursesService.isActiveChange(SessionEntity)
      .then((data) => {
        // this.globals.isLoading = false;	
        swal({
          type: 'success',
          title: 'Updated!',
          text: 'Category has been updated successfully',
          showConfirmButton: false,
          timer: 1500
        })

      },
        (error) => {
          // this.globals.isLoading = false;
          this.router.navigate(['/pagenotfound']);
        });
  }
}



