import { Component, OnInit, ElementRef } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { Globals } from '.././globals';
import { RouterModule } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { RegisterInstructorInvitedService } from '../services/register-instructor-invited.service';
import { JwtHelperService } from '@auth0/angular-jwt';
declare function myInput(): any;
declare var $, swal: any;

@Component({
  selector: 'app-register-instructor-invited',
  templateUrl: './register-instructor-invited.component.html',
  styleUrls: ['./register-instructor-invited.component.css']
})
export class RegisterInstructorInvitedComponent implements OnInit {
  RegisterEntity;
  same;
  submitted;
  submitted1;
  submitted2;
  btn_disable;
  EducationLeveList;
  certificate_error;
  first1;
  CountryList;
  companyList;
  roleList;
  stateList;
  departmentList;
  constructor( private route: ActivatedRoute, private router: Router, private globals: Globals, private RegisterInstructorInvitedService: RegisterInstructorInvitedService,
    private elem: ElementRef) { }

  ngOnInit() {

    this.first1 = true;
    this.RegisterEntity = {};
    myInput();
    let id = this.route.snapshot.paramMap.get('id');
    id = new JwtHelperService().decodeToken(id);
    this.RegisterInstructorInvitedService.getResetlink2(id)
      .then((data) => {
        debugger
        console.log(data);
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
          this.RegisterInstructorInvitedService.getAllDefaultData()
            .then((data) => {
              this.roleList = data['role'];
              this.EducationLeveList = data['education'];
              console.log(this.EducationLeveList);
            },
              (error) => {
                alert('error');

              });

          let id = this.route.snapshot.paramMap.get('id');

          var id1 = new JwtHelperService().decodeToken(id);

          this.RegisterEntity.UserId = id1.UserId;
          if (id) {
            debugger
            this.RegisterInstructorInvitedService.getById(this.RegisterEntity.UserId)
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
            this.RegisterEntity.IsActive = '1';
          }
        }
      },
        (error) => {
          this.btn_disable = false;
          this.submitted = false;
        });

  }

  next1(RegisterForm1) {
    debugger
    this.submitted1 = true;
    //this.globals.isLoading = true;
    if (RegisterForm1.valid) {
      //this.submitted1 = false;
      //this.globals.isLoading = false;
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
    debugger
    this.submitted2 = true;
    //this.globals.isLoading = true;
    let file1 = this.elem.nativeElement.querySelector('#CertificateId').files[0];
    this.RegisterEntity.Certificate = [];
      if (file1) {
        this.certificate_error = false;
      } 
     else {
      this.certificate_error = true;
      }
    if (RegisterForm2.valid && !this.certificate_error) {
      $(".register_tab li").removeClass("active");
      $(".register_tab li#loginli").addClass("active");
      $("#educationdetail").removeClass("active in");
      $("#logindetail").addClass("active in");
      //this.globals.isLoading = false;
      let file1 = this.elem.nativeElement.querySelector('#CertificateId').files;
      for (var i = 0; i < file1.length; i++) {
        var Certificate = Date.now() + '_' + file1[i]['name'];
        this.RegisterEntity.Certificate.push(Certificate);
      }
    }
  }

  previous2() {
    $(".register_tab li").removeClass("active");
    $(".register_tab li#educationli").addClass("active");
    $("#logindetail").removeClass("active in");
    $("#educationdetail").addClass("active in");
  }
  instructor_Register(InstructerRegisterForm) {
    debugger
    this.submitted = true;
    this.RegisterEntity.IsActive=1;
    if (InstructerRegisterForm.valid) {
      let file1 = this.elem.nativeElement.querySelector('#CertificateId').files;
      var fd = new FormData();
      this.RegisterEntity.Certificate = [];
      if (file1) {
        for (var i = 0; i < file1.length; i++) {
          var Certificate = Date.now() + '_' + file1[i]['name'];
          fd.append('Certificate' + i, file1[i], Certificate);
          this.RegisterEntity.Certificate.push(Certificate);
        }
      } 
      console.log(this.RegisterEntity.Certificate);
      this.btn_disable = true;
      this.globals.isLoading = true;
      this.RegisterInstructorInvitedService.invitedInstructorRegister(this.RegisterEntity)
        .then((data) => {
          //this.UserId = data;
          this.globals.isLoading = false;
          this.btn_disable = false;
          this.submitted = false;
          // if (data == 'fail') {
          //   swal({
          //     type: 'warning',
          //     title: 'Oops...',
          //     text: 'This email is already exists!',
          //   })
          // } else {
           // if (file1) {
              this.RegisterInstructorInvitedService.uploadFileCertificate(fd,this.RegisterEntity.UserId)
                .then((data) => {
                  this.RegisterEntity = {};
                  $("#CertificateId").val(null);
                  InstructerRegisterForm.form.markAsPristine();
                  swal({
                    type: 'success',
                    title: 'Congratulations...!!!',
                    text: 'Your registration is completed successfully.Check your mail.',
                    showConfirmButton: false,
                    timer: 3000
                  })
                  this.globals.isLoading = false;
                  this.first1 = true;
                  this.router.navigate(['/login']);
                },
                  (error) => {
                    this.btn_disable = false;
                    this.submitted = false;
                    this.globals.isLoading = false;
                    this.router.navigate(['/pagenotfound']);
                  });
            // } else {
            //   this.RegisterEntity = {};
            //   $("#CertificateId").val(null);
            //   InstructerRegisterForm.form.markAsPristine();
            //   swal({
            //     type: 'success',
            //     title: 'Congratulations...!!!',
            //     text: 'Your registration is successfully. Now you can login.',
            //     showConfirmButton: false,
            //     timer: 3000
            //   })
            //   this.router.navigate(['/login']);
            // }

          //}
        },
          (error) => {
            this.btn_disable = false;
            this.submitted = false;
            this.globals.isLoading = false;
            this.router.navigate(['/pagenotfound']);
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
