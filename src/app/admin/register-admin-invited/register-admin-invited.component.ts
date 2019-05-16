import { Component, OnInit,ElementRef } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { Globals } from '.././globals';
import { RouterModule } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { RegisterAdminInvitedService } from '../services/register-admin-invited.service';
import { JwtHelperService } from '@auth0/angular-jwt';
declare function myInput() : any;
declare var $,swal: any;

@Component({
  selector: 'app-register-admin-invited',
  templateUrl: './register-admin-invited.component.html',
  styleUrls: ['./register-admin-invited.component.css']
})
export class RegisterAdminInvitedComponent implements OnInit {
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
  constructor(  private route:ActivatedRoute,private router: Router,private globals: Globals, private RegisterAdminInvitedService: RegisterAdminInvitedService,
		private elem: ElementRef) { }

    ngOnInit() {

      this.first1=true;
      this.RegisterEntity={};
      myInput();
    let id = this.route.snapshot.paramMap.get('id');
    id=new JwtHelperService().decodeToken(id);
    this.RegisterAdminInvitedService.getResetlink2(id)
    .then((data) => 
    { debugger
      if(data=='fail'){
        swal({
          type: 'warning',
          title: 'Oops...',
          text: 'You are already used this Link!',
          })
        this.router.navigate(['/login']);
      } 	
      else
      {
        this.RegisterEntity={};
        this.RegisterAdminInvitedService.getAllDefaultData()
        .then((data) => {
          this.roleList = data['role'];
          this.EducationLeveList = data['education'];
        },
        (error) => {
          alert('error');
          
        });

        let id = this.route.snapshot.paramMap.get('id');
  
        var id1=new JwtHelperService().decodeToken(id);
      
        this.RegisterEntity.UserId = id1.UserId;
        if (id) {
              debugger
              this.RegisterAdminInvitedService.getById(this.RegisterEntity.UserId)
              .then((data) => {
                this.RegisterEntity = data;	
                setTimeout(function(){
                  myInput();
                   },100);
                },
                (error) => {
                  this.btn_disable = false;
                  this.submitted = false;
                });
            }
            else
            {
              this.RegisterEntity = {};
              this.RegisterEntity.UserId = 0;
              this.RegisterEntity.IsActive = '1';
            }
      }			
    }, 
    (error) => 
        {
          this.btn_disable = false;
          this.submitted = false;
        });	
      
  }
  
    
    next1(RegisterForm1){
      this.submitted1 = true;
      if(RegisterForm1.valid){   
        this.submitted1 = false;   
        $(".register_tab li").removeClass("active");
        $(".register_tab li#educationli").addClass("active");
        $("#personaldetail").removeClass("active in");
        $("#educationdetail").addClass("active in");
      }
    }
  
    previous1(){
        $(".register_tab li").removeClass("active");
        $(".register_tab li#personalli").addClass("active");
        $("#educationdetail").removeClass("active in");
        $("#personaldetail").addClass("active in");
    }
  
    next2(RegisterForm2){
      this.submitted2 = true;
      if(RegisterForm2.valid){
        // let file1 = this.elem.nativeElement.querySelector('#CertificateId').files[0];
        // if(file1){
        //   this.certificate_error = false;
        //   this.submitted2 = false; 
        //   let file1 = this.elem.nativeElement.querySelector('#CertificateId').files[0];
        //   this.RegisterEntity.Certificate = file1['name'];
          $(".register_tab li").removeClass("active");
          $(".register_tab li#loginli").addClass("active");
          $("#educationdetail").removeClass("active in");
          $("#logindetail").addClass("active in");
        // } else {
        //   this.certificate_error = true;
        // }  
      }
    }
  
    previous2(){
      $(".register_tab li").removeClass("active");
      $(".register_tab li#educationli").addClass("active");
      $("#logindetail").removeClass("active in");
      $("#educationdetail").addClass("active in");
    }
  
    instructor_Register(InstructerRegisterForm){ 
      debugger
      this.submitted = true;
      if(InstructerRegisterForm.valid){ 
        // let file1 = this.elem.nativeElement.querySelector('#CertificateId').files[0];
        // var fd = new FormData();
        // if (file1) {				
        //   var Certificate = Date.now()+'_'+file1['name'];
        //   fd.append('Certificate', file1,Certificate);
        //   this.RegisterEntity.Certificate = Certificate;			
        // } else {
        //   fd.append('Certificate', null);
        //   this.RegisterEntity.Certificate = null;
        // }  
        this.submitted = false; 
        this.btn_disable = true;
        this.globals.isLoading = true;
        this.RegisterAdminInvitedService.invitedAdminRegister(this.RegisterEntity)
        .then((data) => 
        {	
          this.globals.isLoading = false;
          this.btn_disable = false;
          this.submitted = false;
          if(data=='email dublicate'){
            swal({
            type: 'warning',
            title: 'Oops...',
            text: 'This email is already exists!',
            })
          } else {
            
            // if(file1){
            //   this.RegisterAdminInvitedService.uploadFile(fd)
            //   .then((data) => 
            //   {	
            //     this.RegisterEntity = {};
            //     $("#CertificateId").val(null);
            //     InstructerRegisterForm.form.markAsPristine();
            //     swal({
            //       type: 'success',
            //       title: 'Congratulations...!!!',
            //       text: 'Your registration is successfully. Now you can login.',
            //       showConfirmButton: false,
            //       timer: 3000
            //       })   
            //     this.router.navigate(['/login']);				
            //   }, 
            //   (error) => 
            //   { 
            //     this.btn_disable = false;
            //     this.submitted = false;
            //     this.globals.isLoading = false;
            //     this.router.navigate(['/pagenotfound']);
            //   });
            // } 
           // else {
              this.RegisterEntity = {};
              $("#CertificateId").val(null);
              InstructerRegisterForm.form.markAsPristine();
              swal({
                type: 'success',
                title: 'Congratulations...!!!',
                text: 'Your registration is successfully. Now you can login.',
                showConfirmButton: false,
                timer: 3000
              })   
              this.router.navigate(['/login']);	
          //  }
  
          }			
        }, 
        (error) => 
        { 
          this.btn_disable = false;
          this.submitted = false;
          this.globals.isLoading = false;
          this.router.navigate(['/pagenotfound']);
        });
      }
    }
  
    checkpassword(){ 
      if(this.RegisterEntity.cPassword != this.RegisterEntity.Password){
        this.same = true;
      } else {
        this.same = false;
      }
    }
  
  }
  