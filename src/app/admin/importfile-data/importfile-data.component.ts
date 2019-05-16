import { Component, OnInit, ElementRef } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { Globals } from '.././globals';
import { RouterModule } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { RegisterInstructorInvitedService } from '../services/register-instructor-invited.service';
declare function myInput() : any;
declare var $,swal: any;
//import * as XLSX from 'ts-xlsx';

@Component({
  selector: 'app-importfile-data',
  templateUrl: './importfile-data.component.html',
  styleUrls: ['./importfile-data.component.css']
})
export class ImportfileDataComponent implements OnInit {
  RegisterEntity;
	same;
	submitted;
	btn_disable;
  certificate_error;
  first1;
  fileExtension;
  constructor(  private route:ActivatedRoute,private router: Router,private globals: Globals, private RegisterInstructorInvitedService: RegisterInstructorInvitedService,
		private elem: ElementRef) { }

    ngOnInit() {
      debugger
      myInput();
      this.first1=true;
      this.RegisterEntity={};
    
  
        let id = this.route.snapshot.paramMap.get('id');
        if (id) {
              debugger
              this.RegisterInstructorInvitedService.getById(this.RegisterEntity.UserId)
              .then((data) => {
                this.RegisterEntity = data;	
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
              setTimeout(function(){
                myInput();
                 },100);
            }
      	     
  }
  
  
  
    addFile(importFile){ 
      debugger
      myInput();
      this.submitted = true;
      if(importFile.valid){ 
        let file1 = this.elem.nativeElement.querySelector('#CertificateId').files[0];
        var fd = new FormData();
        if (file1) {		
         // var Certificate = Date.now()+'_'+file1['name'];		
          var Certificate = file1['name'];
          fd.append('Certificate', file1,Certificate);
          this.RegisterEntity.Certificate = Certificate;	

        } else {
          fd.append('Certificate', null);
          this.RegisterEntity.Certificate = null;
        }  
        
        this.submitted = false; 
        this.btn_disable = true;
        this.globals.isLoading = true;
        this.RegisterInstructorInvitedService.importFileData(this.RegisterEntity)
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
            
            if(file1){
              this.RegisterInstructorInvitedService.importFileUserData(fd)
              .then((data) => 
              {	
                this.RegisterEntity = {};
                $("#CertificateId").val(null);
                importFile.form.markAsPristine();
                swal({
                  type: 'success',
                  title: 'Congratulations!',
                  text: 'Your File is imported successfully.',
                  showConfirmButton: false,
                  timer: 1500
                  })   
                this.router.navigate(['/import-file']);				
              }, 
              (error) => 
              { 
                this.btn_disable = false;
                this.submitted = false;
                this.globals.isLoading = false;
                this.router.navigate(['/pagenotfound']);
              });
            } else {
              this.RegisterEntity = {};
              $("#CertificateId").val(null);
              importFile.form.markAsPristine();
              swal({
                type: 'success',

                text: 'Please Add valid File.',
                showConfirmButton: false,
                timer: 1500
              })   
              this.router.navigate(['/import-file']);	
            }
  
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
  
    
  
  }
  