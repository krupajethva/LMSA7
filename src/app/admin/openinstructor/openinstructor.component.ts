import { Component, OnInit, ElementRef } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { Globals } from '.././globals';

import { RouterModule } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { RegisterInstructorInvitedService } from '../services/register-instructor-invited.service';
declare var $,swal: any;
declare function myInput() : any;
declare var Bloodhound: any;

@Component({
  selector: 'app-openinstructor',
  templateUrl: './openinstructor.component.html',
  styleUrls: ['./openinstructor.component.css']
})
export class OpeninstructorComponent implements OnInit {
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
  UserId;

  constructor( public globals: Globals, private router: Router, private RegisterInstructorInvitedService: RegisterInstructorInvitedService,private route:ActivatedRoute, private elem: ElementRef) { }

  ngOnInit() {
    //multi selector
    setTimeout(function(){
    $('#example-enableFiltering').multiselect({
      includeSelectAllOption: true,
      enableFiltering: true
    });
    },100);
    //multi selector
    this.first1 = true;
    this.certificate_error=false;
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
    
    
      //   this.inviteUserEntity = {};
      //   this.inviteUserEntity.UserId = 0;
      //  this.inviteUserEntity.IsActive = '1';
      //  this.inviteUserEntity.RoleId ='';
      //  this.inviteUserEntity.CompanyId ='';
      //  this.inviteUserEntity.IndustryId ='';
      //  this.inviteUserEntity.InvitedByUserId ='';
       setTimeout(function(){
         myInput();
         },100);
    
    }
    
    
    // inviteUser(inviteForm) 
    // { myInput();
    //     this.submitted = true;
    //     if (inviteForm.valid) {
    //       this.submitted = false;
    //       if(this.companyhide==true){
    //         this.inviteUserEntity.CompanyId = 0;
    //       } 
    //       this.globals.isLoading = true;
    //       this.InviteInstructorService.openInstructorAdd(this.inviteUserEntity)
    //         .then((data) => {
    //           if (this.inviteUserEntity.CountryId > 0) {
    //             this.InviteInstructorService.getStateList(this.inviteUserEntity.CountryId)
    //               .then((data) => {
    //                 this.StateList = data;
    //                     this.globals.isLoading = false;
    //                     this.btn_disable = false;
    //                     this.submitted = false;
    //               },
    //               (error) => {
    //                 this.globals.isLoading = false;
    //                     this.btn_disable = false;
    //                     this.submitted = false;
                    
    //               });
    //           }
    
    //           if(data=='Fail'){
    //             swal({
    //               type: 'warning',
    //               title: 'Oops...',
    //               text: 'Email address already Registered!',
    //               })
    //             this.globals.isLoading = false;
    //             this.btn_disable = false;
    //             this.submitted = false;
    //           } else {
    //           this.btn_disable = false;
    //           this.submitted = false;
    //           this.inviteUserEntity = {};
    //           inviteForm.form.markAsPristine();	
    //           swal({
               
    //             type: 'success',
    //             title: 'success',
    //             text: 'User Invited successfully!',
    //             showConfirmButton: false,
    //            timer: 3000
    //           })
    //           this.globals.isLoading = false;
    //           }
    //         },
    //         (error) => {
    //           this.btn_disable = false;
    //           this.submitted = false;
    //           this.globals.isLoading = false;
    //           this.inviteUserEntity = {};
    //           inviteForm.form.markAsPristine();
    //         });
    //     }
    //   }
    
      next1(RegisterForm1) {
        debugger
        this.submitted1 = true;
        if (RegisterForm1.valid) {
          this.globals.isLoading = true;
          var obj = { 'EmailAddress': this.RegisterEntity.EmailAddress};
          this.RegisterInstructorInvitedService.checkEmail(obj)
          .then((data) => {
            if (data == "duplicate") {
                swal({
                  type: 'warning',
                  title: 'Oops...',
                  text: 'This email is already exists!',
                })
              this.submitted1 = false;
              this.globals.isLoading = false;
              }
              else{
                this.submitted1 = false;
                this.globals.isLoading = false;
                $(".register_tab li").removeClass("active");
                $(".register_tab li#educationli").addClass("active");
                $("#personaldetail").removeClass("active in");
                $("#educationdetail").addClass("active in");
              }

          },
          (error) => {
            this.submitted1 = false;
            this.globals.isLoading = false;
            this.router.navigate(['/pagenotfound']);
          });
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
        this.globals.isLoading = true;
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
          this.globals.isLoading = false;
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
        this.RegisterEntity.IsActive=0;
        this.RegisterEntity.InvitedByUserId=0;
        this.RegisterEntity.RoleId=3;
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
          this.RegisterInstructorInvitedService.openInstructorRegister(this.RegisterEntity)
            .then((data) => {
              this.UserId = data;
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
                  this.RegisterInstructorInvitedService.uploadFileCertificate(fd,this.UserId)
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
                      window.location.href='/open-register-instructor';
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
    