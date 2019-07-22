import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { Globals } from '.././globals';
import { InstructorfollowersService } from '../services/instructorfollowers.service';
declare var $: any;

@Component({
  selector: 'app-instructorlist',
  templateUrl: './instructorlist.component.html',
  styleUrls: ['./instructorlist.component.css']
})
export class InstructorlistComponent implements OnInit {
  InstructorList;
  InstructorEntity;
  roleId;
  constructor(public globals: Globals, private router: Router, private InstructorfollowersService: InstructorfollowersService, private route: ActivatedRoute) { }

  ngOnInit() {
    this.InstructorEntity = {};
    this.roleId =this.globals.authData.RoleId;
    var obj = { 'LearnerId': this.globals.authData.UserId };
    this.InstructorfollowersService.getAllInstructors(obj)
      .then((data) => {
        this.InstructorList = data;
        //console.log(this.InstructorList);
      },
        (error) => {
          // this.globals.isLoading = false;
          this.router.navigate(['/pagenotfound']);
        });
  }
  followInstructor(instructor) {
    debugger
    var follow = { 'InstructorId': instructor.UserId, 'LearnerId': this.globals.authData.UserId };
    this.InstructorfollowersService.followInstructor(follow)
      .then((data) => {
        this.globals.isLoading = false;
        //  $('#follow').hide();
        instructor.flag = 1;
        instructor.totalFollowers = instructor.totalFollowers + 1;
        //  $('#unfollow').show();
      },
        (error) => {
          if (error.text) {
            alert("Error");
          }
        });
  }
  unfollowInstructor(instructor) {
    debugger
    var unfollow = { 'InstructorId': instructor.UserId, 'LearnerId': this.globals.authData.UserId };
    this.InstructorfollowersService.unfollowInstructor(unfollow)
      .then((data) => {
        this.globals.isLoading = false;
        //  $('#unfollow').hide();
        instructor.flag = 0;
        instructor.totalFollowers = instructor.totalFollowers - 1;
        //   $('#follow').show();
      },
        (error) => {
          if (error.text) {
            alert("Error");
          }
        });
  }

  SearchInstructor(InstructorForm) {
    if ((this.InstructorEntity.Search == undefined || this.InstructorEntity.Search == "" || this.InstructorEntity.Search == null) ) {

    } else {
      if (InstructorForm.valid) {
        this.globals.isLoading = true;

        //   this.SalesDashboardEntity.CompanyId;
        // 	this.SalesDashboardEntity.UserId;
        // this.vardisabled=true;
        if (this.InstructorEntity.Search == undefined) {
          this.InstructorEntity.Search = null;
        }
      
        var data = {  'Name': this.InstructorEntity.Search, 'user': this.globals.authData.UserId };
        this.InstructorfollowersService.SearchInstructor(data)
          .then((data) => {
            this.globals.isLoading = false;
            // this.hideowner=false;
            // this.header_var = 'List of all users';
            //alert('success');
            if (data == 'error') {
              this.InstructorList = [];
            }
            else {
              this.InstructorList = data['search'];
            }
            setTimeout(function () {
              $('.modal').on('shown.bs.modal', function () {
                $('.right_content_block').addClass('style_position');
              })
              $('.modal').on('hidden.bs.modal', function () {
                $('.right_content_block').removeClass('style_position');
              });
              // myInput();
            },
              500);
            // this.btn_disable = false;
            // this.submitted = false;
            // this.globals.isLoading = false;
          },
            (error) => {
              //alert('error');
              // this.btn_disable = false;
              // this.submitted = false;
              // this.globals.isLoading = false;
              // this.router.navigate(['/pagenotfound']);

            });
      }

    }
  }

  //Clear Form for instructor search
  clearForm(InstructorForm)
  {
    this.globals.isLoading = true;
    var obj = { 'LearnerId': this.globals.authData.UserId };
    this.InstructorfollowersService.getAllInstructors(obj)
      .then((data) => {
        this.InstructorList = data;
        this.InstructorEntity = {};
        this.globals.isLoading = false;
        InstructorForm.form.markAsPristine();
      },
        (error) => {
          // this.globals.isLoading = false;
          this.router.navigate(['/pagenotfound']);
        });
    
  }
}
