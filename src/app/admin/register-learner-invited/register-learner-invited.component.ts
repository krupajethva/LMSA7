import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { RegisterLearnerInvitedService } from '../services/register-learner-invited.service';
import { JwtHelperService } from '@auth0/angular-jwt';
import { Globals } from '.././globals';
declare function myInput(): any;
declare var CKEDITOR, Bloodhound, swal, Dropzone, $: any;

@Component({
  selector: 'app-register-learner-invited',
  templateUrl: './register-learner-invited.component.html',
  styleUrls: ['./register-learner-invited.component.css']
})
export class RegisterLearnerInvitedComponent implements OnInit {
  RegisterEntity;
  same;
  submitted;
  submitted1;
  submitted2;
  btn_disable;
  EducationLeveList;
  departmentList;
  roleList;
  companyList;
  first1;
  CountryList;
  stateList;
  sameskill;
  autocompleteItems;

  constructor( private router: Router, private globals: Globals, private RegisterLearnerInvitedService: RegisterLearnerInvitedService, private route: ActivatedRoute) { }

  ngOnInit() {
    this.first1 = true;
    this.RegisterEntity = {};
    myInput();

    // var Keyword = new Bloodhound({
    //   datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
    //   queryTokenizer: Bloodhound.tokenizers.whitespace,
    //   prefetch: {
    //     url: this.globals.baseAPIUrl + 'Course/skillsData',
    //     filter: function (list) {
    //       return $.map(list, function (cityname) {
    //         return { name: cityname };
    //       });
    //     }
    //   }
    // });
    // Keyword.initialize();
    // $('#tagsinput').tagsinput({
    //   typeaheadjs: {
    //     name: 'Keyword',
    //     displayKey: 'name',
    //     valueKey: 'name',
    //     source: Keyword.ttAdapter()
    //   }
    // });


    this.RegisterLearnerInvitedService.getAllDefaultData()
      .then((data) => {
        this.EducationLeveList = data['education'];
        this.autocompleteItems = data['skills'];
        this.globals.isLoading = false;
      },
        (error) => {
          this.globals.isLoading = false;
        });


    let id = this.route.snapshot.paramMap.get('id');
    id = new JwtHelperService().decodeToken(id);
    this.RegisterLearnerInvitedService.getResetlink2(id)
      .then((data) => {
        if (data == 'fail') {
          swal({
            type: 'warning',
            title: 'Oops...',
            text: 'You are already used this Link!',
          })
          this.router.navigate(['/login']);
        }
        else {
          this.RegisterEntity = {};
          this.RegisterLearnerInvitedService.getAllDefaultData()
            .then((data) => {

              this.roleList = data['role'];


            },
              (error) => {
                this.btn_disable = false;
                this.submitted = false;
                this.globals.isLoading = false;
              });

          let id = this.route.snapshot.paramMap.get('id');

          var id1 = new JwtHelperService().decodeToken(id);

          this.RegisterEntity.UserId = id1.UserId;
          if (id) {
            this.RegisterLearnerInvitedService.getById(this.RegisterEntity.UserId)
              .then((data) => {
                this.RegisterEntity = data;
                setTimeout(function () {
                  myInput();
                }, 100);
              },
                (error) => {
                  this.btn_disable = false;
                  this.submitted = false;
                });
          }
          else {

            this.RegisterEntity = {};
            this.RegisterEntity.UserId = 0;
            this.RegisterEntity.CompanyId = 0;
            this.RegisterEntity.DepartmentId = 0;
            this.RegisterEntity.EducationLevelId = 0;
            this.RegisterEntity.IsActive = '1';
          }
        }
      },
        (error) => {
          this.btn_disable = false;
          this.submitted = false;
          this.globals.isLoading = false;
        });


  }

  next1(RegisterForm1) {
    this.submitted1 = true;
    if (RegisterForm1.valid) {
      this.submitted1 = false;
      $(".register_tab li").removeClass("active");
      $(".register_tab li#educationli").addClass("active");
      $("#personaldetail").removeClass("active in");
      $("#educationdetail").addClass("active in");
    }
  }

  previous1() {
    $(".register_tab li").removeClass("active");
    $(".register_tab li#personalli").addClass("active");
    $("#educationdetail").removeClass("active in");
    $("#personaldetail").addClass("active in");
  }

  next2(RegisterForm2) {
    this.submitted2 = true;
    var error_count = 0;

    if (this.RegisterEntity.Keyword == "" || this.RegisterEntity.Keyword == null || this.RegisterEntity.Keyword == undefined) {
      this.sameskill = true;
      error_count += 1;
    } else {
      this.sameskill = false;
    }
    if (RegisterForm2.valid && error_count == 0) {

      this.submitted2 = false;
      $(".register_tab li").removeClass("active");
      $(".register_tab li#loginli").addClass("active");
      $("#educationdetail").removeClass("active in");
      $("#logindetail").addClass("active in");
    }
  }

  previous2() {
    this.sameskill = false;
    $(".register_tab li").removeClass("active");
    $(".register_tab li#educationli").addClass("active");
    $("#logindetail").removeClass("active in");
    $("#educationdetail").addClass("active in");
  }



  learner_Register(learnerRegisterForm) {
    let id = this.route.snapshot.paramMap.get('id');
    this.submitted = true;
    if (learnerRegisterForm.valid) {
      this.RegisterEntity.Keyword = this.RegisterEntity.Keyword.join();
      this.submitted = false;
      this.btn_disable = true;
      this.globals.isLoading = true;
      this.RegisterLearnerInvitedService.invitedLearnerRegister(this.RegisterEntity)
        .then((data) => {
          this.btn_disable = false;
          this.submitted = false;
          this.RegisterEntity = {};
          learnerRegisterForm.form.markAsPristine();
          swal({
            type: 'success',
            title: 'Congratulations...!!!',
            text: 'Your registration is successfully. Now you can login.',
            showConfirmButton: false,
            timer: 3000
          })
          this.router.navigate(['/dashboard']);
        },
          (error) => {
            this.btn_disable = false;
            this.submitted = false;
            this.globals.isLoading = false;
          });
    }
  }

  checkpassword() {
    if (this.RegisterEntity.cPassword != this.RegisterEntity.Password) {
      this.same = true;
    } else {
      this.same = false;
    }

  }

}
