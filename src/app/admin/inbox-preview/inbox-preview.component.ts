import { Component, OnInit, ElementRef } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { Globals } from '.././globals';
import { RouterModule } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { InboxService } from '../services/inbox.service';
declare var $, swal: any;
declare function myInput(): any;
declare var $, Bloodhound: any;
declare var CKEDITOR, PerfectScrollbar, $: any;
@Component({
  selector: 'app-inbox-preview',
  templateUrl: './inbox-preview.component.html',
  styleUrls: ['./inbox-preview.component.css']
})
export class InboxPreviewComponent implements OnInit {
  inboxList;
  inboxcountList;
  sendboxList;
  addstarList;
  imortantList;
  draftList;
  draftcountList;
  emailPreviewEntity;
  btn_disable;
  submitted;
  des_valid;
  deleteEntity;
  userList;
  errorMsg;
  emailEntity;

  constructor(private elem: ElementRef,  public globals: Globals, private router: Router, private InboxService: InboxService, private route: ActivatedRoute) { }
  selectedCharacters: Array<string> = [];
  selectedCharactersCc: Array<string> = [];
  selectedCharactersBcc: Array<string> = [];
  ngOnInit() {
    this.des_valid = false;
    this.errorMsg = false;
    this.emailPreviewEntity = {};
    this.emailEntity = {};

    $('.mailbox_preview_btn').click(function () {
      $('.compose_mail_box').addClass('activemail');
    });
    $('.mailbox-header .close').click(function () {
      $('.compose_mail_box').removeClass('activemail');
    });


    debugger
    this.InboxService.listUser()
      .then((data) => {
        debugger
        this.userList = data;
      },
        (error) => {
          this.globals.isLoading = false;
        });
    this.InboxService.getAllData(this.globals.authData.UserId)
      .then((data) => {
        debugger

        this.inboxList = data['inbox'];
        this.inboxcountList = data['inboxcount'];
        this.draftcountList = data['draftcount'];
        this.globals.isLoading = false;
      },
        (error) => {
          this.globals.isLoading = false;

        });


    let id = this.route.snapshot.paramMap.get('id');
    if (id) {
      this.InboxService.getById(id)
        .then((data) => {
          this.emailPreviewEntity = data;
          setTimeout(function () {
            // $('#multiupload').imageuploadify();
            CKEDITOR.replace('EmailBody', {
              height: '100',
              resize_enabled: 'false',
              resize_maxHeight: '100',
              resize_maxWidth: '948',
              resize_minHeight: '100',
              resize_minWidth: '948',
              extraAllowedContent: 'span;ul;li;table;td;style;*[id];*(*);*{*}',
              enterMode: Number(2)
            });

          }, 100);


          setTimeout(function () {
            $('.compose_label a').click(function () {
              $('.compose_mail_box').addClass('activemail');
            });
            $('.mailbox-header .close').click(function () {
              $('.compose_mail_box').removeClass('activemail');
              $(".imageuploadify-container").remove();
            });

            $('.submit_btn.send_btn').click(function () {
              $(".imageuploadify-container").remove();
            });

            $('.submit_btn.draft_btn').click(function () {
              $(".imageuploadify-container").remove();
            });

          }, 100);


          setTimeout(function () {
            $('input[type="file"]').imageuploadify();
            myInput();
          }, 100);

        },
          (error) => {
            this.btn_disable = false;
            this.submitted = false;
          });
    }
    else {
      this.emailPreviewEntity = {};
      this.emailPreviewEntity.EmailLogId = 0;

    }

    //mailbox
    setTimeout(function () {
      $('.compose_label a').click(function () {
        $('.compose_mail_box').addClass('activemail');
      });
      $('.mailbox-header .close').click(function () {
        $('.compose_mail_box').removeClass('activemail');
      });
    }, 100);

    setTimeout(function () {
      $('#multiupload').imageuploadify();
      CKEDITOR.replace('MessageBody', {
        height: '100',
        resize_enabled: 'false',
        resize_maxHeight: '100',
        resize_maxWidth: '948',
        resize_minHeight: '100',
        resize_minWidth: '948',
        extraAllowedContent: 'span;ul;li;table;td;style;*[id];*(*);*{*}',
        enterMode: Number(2)
      });
    }, 100);

    // setTimeout(function () {
    //   $('input[type="file"]').imageuploadify();
    //   myInput();
    // }, 100);

    // PERFECT SCROLLBAR
    new PerfectScrollbar('.composebox');
    new PerfectScrollbar('.compose_mail_box');
    // END PERFECT SCROLLBAR


  }

  blankEntity()
  {
    this.emailEntity={};
    this.emailEntity.EmailNotificationId=0;
    this.selectedCharacters=[];
    this.selectedCharactersCc=[];
    this.selectedCharactersBcc=[];
    CKEDITOR.instances.MessageBody.setData('');
  }


    // ** add to mail compose
    addEmail(AddNewForm) {
      debugger
      this.emailEntity.UserId=this.selectedCharacters;
      this.emailEntity.UserId2=this.selectedCharactersCc;
      this.emailEntity.UserId3=this.selectedCharactersBcc;
      this.emailEntity.MessageBody = CKEDITOR.instances.MessageBody.getData();
      if(this.emailEntity.UserId!=''){
        this.errorMsg = false;
      }
      else{
        this.errorMsg = true;
      }
  
      if (this.emailEntity.MessageBody != "") {
        this.des_valid = false;
      } else {
        this.des_valid = true;
      }
      let UserId = this.route.snapshot.paramMap.get(this.globals.authData.UserId);
      if (UserId) {
        this.emailEntity.UpdatedBy = this.globals.authData.UserId;
        this.submitted = false;
      } else {
        this.emailEntity.CreatedBy = this.globals.authData.UserId;
        this.emailEntity.UpdatedBy = this.globals.authData.UserId;
        this.submitted = true;
      }
     
      let file1 = this.elem.nativeElement.querySelector('#CertificateId').files;
      var fd = new FormData();
      var size=25000000;
      var imageSize=0;
      this.emailEntity.Attachment = [];
      if (file1.length > 0) {
        for (var i = 0; i < file1.length; i++) {
          var Attachment = Date.now() + '_' + file1[i]['name'];
          imageSize=imageSize + file1[i].size;
        
          fd.append('Attachment' + i, file1[i], Attachment);
          this.emailEntity.Attachment.push(Attachment);
        }
        if(imageSize>size)
        {
         
          swal({
           
            type: 'warning',
            title: 'Please upload a file less than 25MB.',
            showConfirmButton: false,
            timer: 3000
          });
         
        }
       
      }
      else {
        fd.append('Attachment', null);
        this.emailEntity.Attachment = null;
      }
    
      if (AddNewForm.valid && !this.des_valid && imageSize<=size && !this.errorMsg) {
      
        if (file1) {
          this.InboxService.uploadFileMulti(fd, file1.length)
            .then((data) => {
              this.globals.isLoading = true;
              this.InboxService.add(this.emailEntity)
                .then((data) => {
                    this.des_valid = false;
                  this.btn_disable = false;
                  this.submitted = false;
                  this.globals.isLoading = false;
                  this.emailEntity = {};
                  CKEDITOR.instances.MessageBody.setData('');
                  this.emailEntity.UserId=this.selectedCharacters=[''];
                  this.emailEntity.UserId2=this.selectedCharactersCc=[''];
                  this.emailEntity.UserId3=this.selectedCharactersBcc=[''];
                  AddNewForm.form.markAsPristine();
                  swal({
                   
                    type: 'success',
                    title: 'Email send successfully.',
                    showConfirmButton: false,
                    timer: 3000
                  })
                  
                  this.InboxService.getAllData(this.globals.authData.UserId)
                  .then((data) => {
                    this.draftcountList = data['draftcount'];
                  },
                    (error) => {
                  
                    });
                    this.InboxService.getAllDraft(this.globals.authData.UserId)
                    .then((data) => {
                    this.draftList = data['draft'];
                    },
                    (error) => {
                    });
                  $('.compose_mail_box').removeClass('activemail');
                 
                },
                  (error) => {
                    this.btn_disable = false;
                  this.submitted = false;
                  });
              
            },
              (error) => {
                 swal({
           
            type: 'warning',
            title: 'Please upload a file less than 25MB.',
            showConfirmButton: false,
            timer: 3000
          });
                this.btn_disable = false;
                this.submitted = false;
                this.globals.isLoading = false;
              });
        } 
        
        else {
          this.emailEntity = {};
          $("#CertificateId").val(null);
          this.submitted = true;
          this.globals.isLoading = true;
          this.InboxService.add(this.emailEntity)
            .then((data) => {
              this.btn_disable = false;
              this.submitted = false;
              this.globals.isLoading = false;  
              this.emailEntity = {};
              CKEDITOR.instances.MessageBody.setData('');
              AddNewForm.form.markAsPristine(); 
              swal({
               
                type: 'success',
                title: 'Email send successfully.',
                showConfirmButton: false,
                timer: 3000
              })
  
              this.InboxService.getAllData(this.globals.authData.UserId)
              .then((data) => {
                this.draftcountList = data['draftcount'];
              },
                (error) => {
              
                });
                this.InboxService.getAllDraft(this.globals.authData.UserId)
                .then((data) => {
                this.draftList = data['draft'];
                },
                (error) => {
                });
              $('.compose_mail_box').removeClass('activemail');
            },
              (error) => {
                this.btn_disable = false;
                this.submitted = false;
              });
  
        }
  
  
      }
  
    }
  
  // **
    saveDraftInbox() {
      debugger
      //alert(this.draftIndex);
      this.emailEntity.UserId=this.selectedCharacters;
      this.emailEntity.UserId2=this.selectedCharactersCc;
      this.emailEntity.UserId3=this.selectedCharactersBcc;
      this.emailEntity.MessageBody = CKEDITOR.instances.MessageBody.getData();
      if (this.emailEntity.MessageBody != "") {
        this.des_valid = false;
      } else {
        this.des_valid = true;
      }
      let UserId = this.route.snapshot.paramMap.get(this.globals.authData.UserId);
      if (UserId) {
        this.emailEntity.UpdatedBy = this.globals.authData.UserId;
        this.submitted = false;
      } else {
        this.emailEntity.CreatedBy = this.globals.authData.UserId;
        this.emailEntity.UpdatedBy = this.globals.authData.UserId;
        this.submitted = true;
      }
  
      let file1 = this.elem.nativeElement.querySelector('#CertificateId').files;
      var fd = new FormData();
      var size=25000000;
      var imageSize=0;
      this.emailEntity.Attachment = [];
      if (file1.length > 0) {
        for (var i = 0; i < file1.length; i++) {
          var Attachment = Date.now() + '_' + file1[i]['name'];
          imageSize=imageSize + file1[i].size;
          fd.append('Attachment' + i, file1[i], Attachment);
          this.emailEntity.Attachment.push(Attachment);
        }
        if(imageSize>size)
        {
         
          swal({
           
            type: 'warning',
            title: 'Please upload a file less than 25MB.',
            showConfirmButton: false,
            timer: 3000
          });
         
        }
       
      }
      else {
        fd.append('Attachment', null);
        this.emailEntity.Attachment = null;
      }
  
      if (imageSize<=size) {
        if (file1) {
          swal({
            title: 'Draft an Email',
            text: "Are you sure you want to save this email as a draft?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
          })
            .then((result) => {
              if (result.value) {
          this.InboxService.uploadFileMulti(fd, file1.length)
            .then((data) => {
              this.globals.isLoading = true;
              this.InboxService.addDraft(this.emailEntity)
                .then((data) => {
                    this.des_valid = false;
                  this.btn_disable = false;
                  this.submitted = false;
                  this.globals.isLoading = false;
                  
                      // this.draftList[this.draftIndex].selectedCharacters=this.selectedCharacters;
                      // this.draftList[this.draftIndex].selectedCharactersCc=this.selectedCharactersCc;
                      // this.draftList[this.draftIndex].selectedCharactersBcc=this.selectedCharactersBcc;
                      // this.draftList[this.draftIndex].Subject=this.emailEntity.Subject;
                      // this.draftList[this.draftIndex].MessageBody=this.emailEntity.MessageBody;
                      
                  // this.emailEntity = {};
                  // CKEDITOR.instances.MessageBody.setData('');
                  // this.emailEntity.UserId=this.selectedCharacters=[''];
                  // this.emailEntity.UserId2=this.selectedCharactersCc=[''];
                  // this.emailEntity.UserId3=this.selectedCharactersBcc=[''];
                  swal({
                   
                    type: 'success',
                    title: 'Email save as a draft successfully.',
                    showConfirmButton: false,
                    timer: 3000
                  })
                  
                  this.InboxService.getAllData(this.globals.authData.UserId)
                  .then((data) => {
                    this.draftcountList = data['draftcount'];
                    this.draftList = data['draft'];
                  },
                    (error) => {
                      this.btn_disable = false;
                      this.submitted = false;
                      this.globals.isLoading = false;
                    });
                  $('.compose_mail_box').removeClass('activemail');
  
                },
                  (error) => {
                    this.btn_disable = false;
                  this.submitted = false;
                  });
            },
              (error) => {
                 swal({
                  type: 'warning',
                  title: 'Please upload a file less than 25MB.',
                  showConfirmButton: false,
                  timer: 3000
                });
                this.btn_disable = false;
                this.submitted = false;
                this.globals.isLoading = false;
              });
            }
          },
          (error) => {
            this.btn_disable = false;
            this.submitted = false;
            $('.compose_mail_box').removeClass('activemail');
          });
        } else {
          this.emailEntity = {};
          $("#CertificateId").val(null);
            
          this.submitted = true;
          this.globals.isLoading = true;
          swal({
            title: 'Draft an Email',
            text: "Are you sure you want to save this email as a draft?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
          })
            .then((result) => {
              if (result.value) {
          this.InboxService.addDraft(this.emailEntity)
            .then((data) => {
              this.des_valid = false;
              this.btn_disable = false;
              this.submitted = false;
              this.globals.isLoading = false;
              //this.emailEntity = {};
              //CKEDITOR.instances.MessageBody.setData('');
              // this.draftList[this.draftIndex].selectedCharacters=this.selectedCharacters;
              // this.draftList[this.draftIndex].selectedCharactersCc=this.selectedCharactersCc;
              // this.draftList[this.draftIndex].selectedCharactersBcc=this.selectedCharactersBcc;
              // this.draftList[this.draftIndex].Subject=this.emailEntity.Subject;
              // this.draftList[this.draftIndex].MessageBody=this.emailEntity.MessageBody;
              swal({
                type: 'success',
                title: 'Email save as a draft successfully.',
                showConfirmButton: false,
                timer: 3000
              })
  
              this.InboxService.getAllData(this.globals.authData.UserId)
              .then((data) => {
                this.draftcountList = data['draftcount'];
                this.draftList = data['draft'];
              },
                (error) => {
                  this.btn_disable = false;
                  this.submitted = false;
                  this.globals.isLoading = false;
                });
              $('.compose_mail_box').removeClass('activemail');
             
            },
              (error) => {
                this.btn_disable = false;
                this.submitted = false;
              });
            }
          },
          (error) => {
            this.btn_disable = false;
            this.submitted = false;
            $('.compose_mail_box').removeClass('activemail');
          });
  
        }
        $('.compose_mail_box').removeClass('activemail');
      }
        }
  
        // **
    Closedraft() {
      debugger
      this.emailEntity.UserId=this.selectedCharacters;
      this.emailEntity.UserId2=this.selectedCharactersCc;
      this.emailEntity.UserId3=this.selectedCharactersBcc;
     // this.emailEntity.Subject;
      this.emailEntity.MessageBody = CKEDITOR.instances.MessageBody.getData();
      if( this.emailEntity.UserId=='' && this.emailEntity.UserId2=='' &&  this.emailEntity.UserId3=='' && this.emailEntity.MessageBody=='')
      {
        this.emailEntity.UserId=this.selectedCharacters=[''];
        this.emailEntity={};
        $('.compose_mail_box').removeClass('activemail');
      }else
      {
       
      if (this.emailEntity.MessageBody != "") {
        this.des_valid = false;
      } else {
        this.des_valid = true;
      }
      let UserId = this.route.snapshot.paramMap.get(this.globals.authData.UserId);
      if (UserId) {
        this.emailEntity.UpdatedBy = this.globals.authData.UserId;
        this.submitted = false;
      } else {
        this.emailEntity.CreatedBy = this.globals.authData.UserId;
        this.emailEntity.UpdatedBy = this.globals.authData.UserId;
        this.submitted = true;
      }
      
  
      let file1 = this.elem.nativeElement.querySelector('#CertificateId').files;
      var fd = new FormData();
      var size=25000000;
      var imageSize=0;
      this.emailEntity.Attachment = [];
      if (file1.length > 0) {
        for (var i = 0; i < file1.length; i++) {
          var Attachment = Date.now() + '_' + file1[i]['name'];
          imageSize=imageSize + file1[i].size;
          fd.append('Attachment' + i, file1[i], Attachment);
          this.emailEntity.Attachment.push(Attachment);
        }
        if(imageSize>size)
        {
         
          swal({
            type: 'warning',
            title: 'Please upload a file less than 25MB.',
            showConfirmButton: false,
            timer: 3000
          });
         console.log(this.emailEntity);
          if (file1) {
            swal({
              title: 'Draft an Email',
              text: "Are you sure you want to save this email as a draft?",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes',
              cancelButtonText: 'No'
            })
              .then((result) => {
                if (result.value) {
            this.InboxService.uploadFileMulti(fd, file1.length)
              .then((data) => {
                      this.InboxService.addDraft(this.emailEntity)
                        .then((data) => {
                          this.des_valid = false;
                          this.btn_disable = false;
                          this.submitted = false;
                          this.globals.isLoading = false;
                          // this.emailEntity = {};
                          // CKEDITOR.instances.MessageBody.setData('');
                          // this.emailEntity.UserId=this.selectedCharacters=[''];
                          // this.emailEntity.UserId2=this.selectedCharactersCc=[''];
                          // this.emailEntity.UserId3=this.selectedCharactersBcc=[''];
                      // this.draftList[this.draftIndex].selectedCharacters=this.selectedCharacters;
                      // this.draftList[this.draftIndex].selectedCharactersCc=this.selectedCharactersCc;
                      // this.draftList[this.draftIndex].selectedCharactersBcc=this.selectedCharactersBcc;
                      // this.draftList[this.draftIndex].Subject=this.emailEntity.Subject;
                      // this.draftList[this.draftIndex].MessageBody=this.emailEntity.MessageBody;
                      this.emailEntity = {};
                          swal({
                            type: 'success',
                            title: 'Email save as a draft successfully.',
                            showConfirmButton: false,
                            timer: 3000
                          })
    
                          this.InboxService.getAllData(this.globals.authData.UserId)
                            .then((data) => {
                              this.draftcountList = data['draftcount'];
                            },
                              (error) => {
                                this.btn_disable = false;
                                this.submitted = false;
                                this.globals.isLoading = false;
                              });
                          $('.compose_mail_box').removeClass('activemail');
                         
                        },
                          (error) => {
                            this.btn_disable = false;
                            this.submitted = false;
                          });
                  
    
                      this.des_valid = false;
                      this.btn_disable = false;
                      this.submitted = false;
                      this.globals.isLoading = false;
                      this.emailEntity = {};
                      CKEDITOR.instances.MessageBody.setData('');
                      swal({
                       
                        type: 'success',
                        title: 'Email save as a draft successfully.',
                        showConfirmButton: false,
                        timer: 3000
                      })
    
                      this.InboxService.getAllData(this.globals.authData.UserId)
                        .then((data) => {
                          this.draftcountList = data['draftcount'];
    
                        },
                          (error) => {
                            this.btn_disable = false;
                            this.submitted = false;
                            this.globals.isLoading = false;
                          });
                      $('.compose_mail_box').removeClass('activemail');
              
              },
                (error) => {
                  swal({
                   
                    type: 'warning',
                    title: 'Please upload a file less than 25MB.',
                    showConfirmButton: false,
                    timer: 3000
                  });
                  this.btn_disable = false;
                  this.submitted = false;
                  this.globals.isLoading = false;
                });
    
              }
            },
              (error) => {
                this.btn_disable = false;
                this.submitted = false;
              });
          }
           
        }
       
      }
      else {
        fd.append('Attachment', null);
        this.emailEntity.Attachment = null;
        console.log(this.emailEntity);
        this.submitted = true;
       // this.globals.isLoading = true;
        swal({
          title: 'Draft an Email',
          text: "Are you sure you want to save this email as a draft?",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes',
          cancelButtonText: 'No'
        })
          .then((result) => {
            if (result.value) {
              this.InboxService.addDraft(this.emailEntity)
                .then((data) => {
                  this.des_valid = false;
                  this.btn_disable = false;
                  this.submitted = false;
                  this.globals.isLoading = false;
                  // this.emailEntity = {};
                  // CKEDITOR.instances.MessageBody.setData('');
                  // this.emailEntity.UserId=this.selectedCharacters=[''];
                  // this.emailEntity.UserId2=this.selectedCharactersCc=[''];
                  // this.emailEntity.UserId3=this.selectedCharactersBcc=[''];
                  // this.draftList[this.draftIndex].selectedCharacters=this.selectedCharacters;
                  //     this.draftList[this.draftIndex].selectedCharactersCc=this.selectedCharactersCc;
                  //     this.draftList[this.draftIndex].selectedCharactersBcc=this.selectedCharactersBcc;
                  //     this.draftList[this.draftIndex].Subject=this.emailEntity.Subject;
                  //     this.draftList[this.draftIndex].MessageBody=this.emailEntity.MessageBody;
                      this.emailEntity = {};
                  swal({
                   
                    type: 'success',
                    title: 'Email save as a draft successfully.',
                    showConfirmButton: false,
                    timer: 3000
                  })
  
                  this.InboxService.getAllData(this.globals.authData.UserId)
                    .then((data) => {
                      this.draftcountList = data['draftcount'];
  
                    },
                      (error) => {
                        this.btn_disable = false;
                        this.submitted = false;
                        this.globals.isLoading = false;
                      });
                   
                  $('.compose_mail_box').removeClass('activemail');
                  
                },
                  (error) => {
                    this.btn_disable = false;
                    this.submitted = false;
                  });
            }
          },
            (error) => {
              this.btn_disable = false;
              this.submitted = false;
            });
      }
      }
      
  
  
    }
    
  // ** To replay email
  replay() {
    debugger
    let id = this.route.snapshot.paramMap.get('id');
    if (id) {
      this.InboxService.getById(id)
        .then((data) => {
          this.emailPreviewEntity.EmailNotificationId = 0;
          this.emailPreviewEntity.InviedByUsterId = data['EmailNotificationId'];
          this.selectedCharacters = data['selectedCharacters'];
          this.emailPreviewEntity.UserId2 = this.selectedCharactersCc;
          this.emailPreviewEntity.UserId3 = this.selectedCharactersBcc;
          this.emailPreviewEntity.Subject = "RE: "+data['Subject'];
         
          let MessageBody = "<br/><hr/><b>From : </b>"+data['EmailAddress']+"<br/><b>Sent : </b>"+data['CreatedOn']+"<br/><b>To : </b>"+data['ToEmailAddressGroup']+"<br/><b>Subject : </b>"+data['Subject']+"<br/>"+data['MessageBody']+"<br/>"+"<br/>"+"<br/>";
          this.emailPreviewEntity.MessageBody = CKEDITOR.instances.MessageBody.setData(MessageBody);

          setTimeout(function () {

            CKEDITOR.replace('EmailBody', {
              height: '100',
              resize_enabled: 'false',
              resize_maxHeight: '100',
              resize_maxWidth: '948',
              resize_minHeight: '100',
              resize_minWidth: '948',
              extraAllowedContent: 'span;ul;li;table;td;style;*[id];*(*);*{*}'
            });

          }, 100);
        },
          (error) => {
            this.btn_disable = false;
            this.submitted = false;
          });
    }
    else {
      this.emailPreviewEntity = {};
      this.emailPreviewEntity.EmailNotificationId = 0;
    }
    $('.compose_mail_box').addClass('activemail');

  }


  // ** To forward email
  forward() {
    debugger
    let id = this.route.snapshot.paramMap.get('id');
    if (id) {
      this.InboxService.getById(id)
        .then((data) => {
          this.globals.isLoading = false;
          this.emailPreviewEntity.EmailNotificationId = 0;
          this.emailPreviewEntity.UserId = this.selectedCharacters;
          this.emailPreviewEntity.UserId2 = this.selectedCharactersCc;
          this.emailPreviewEntity.UserId3 = this.selectedCharactersBcc;
          this.emailPreviewEntity.Subject = "FW: "+data['Subject'];
         
          let MessageBody = "<br/><hr/><b>From : </b>"+data['EmailAddress']+"<br/><b>Sent : </b>"+data['CreatedOn']+"<br/><b>To : </b>"+data['ToEmailAddressGroup']+"<br/><b>Subject : </b>"+data['Subject']+"<br/>"+data['MessageBody']+"<br/>"+"<br/>"+"<br/>";
          this.emailPreviewEntity.MessageBody = CKEDITOR.instances.MessageBody.setData(MessageBody);
          setTimeout(function () {

            CKEDITOR.replace('EmailBody', {
              height: '100',
              resize_enabled: 'false',
              resize_maxHeight: '100',
              resize_maxWidth: '948',
              resize_minHeight: '100',
              resize_minWidth: '948',
              extraAllowedContent: 'span;ul;li;table;td;style;*[id];*(*);*{*}'

            });

          }, 100);

        },
          (error) => {
            this.btn_disable = false;
            this.submitted = false;
            this.globals.isLoading = false;
          });
    }
    else {
      this.emailPreviewEntity = {};
      this.emailPreviewEntity.EmailNotificationId = 0;
      this.btn_disable = false;
      this.submitted = false;
      this.globals.isLoading = false;
    }
    $('.compose_mail_box').addClass('activemail');
  }

  // ** To replay all
  replayAll() {
    debugger
    let id = this.route.snapshot.paramMap.get('id');
    if (id) {
      this.InboxService.getById(id)
        .then((data) => {
          this.emailPreviewEntity.EmailNotificationId = 0;
          this.emailPreviewEntity.InvitedByUserId = data['EmailNotificationId'];
          this.selectedCharacters = data['SenderId'];
          console.log(this.selectedCharacters);
          this.selectedCharacters = data['selectedCharacters'];

          console.log(this.selectedCharacters);
          this.selectedCharactersCc = data['selectedCharactersCc'];;
          this.emailPreviewEntity.UserId3 = this.selectedCharactersBcc;
          this.emailPreviewEntity.Subject = "RE: "+data['Subject'];
         
          let MessageBody = "<br/><hr/><b>From : </b>"+data['EmailAddress']+"<br/><b>Sent : </b>"+data['CreatedOn']+"<br/><b>To : </b>"+data['ToEmailAddressGroup']+"<br/><b>Subject : </b>"+data['Subject']+"<br/>"+data['MessageBody']+"<br/>"+"<br/>"+"<br/>";
          this.emailPreviewEntity.MessageBody = CKEDITOR.instances.MessageBody.setData(MessageBody);
        },
          (error) => {
            this.btn_disable = false;
            this.submitted = false;
          });
    }
    else {
      this.emailPreviewEntity = {};
      this.emailPreviewEntity.EmailNotificationId = 0;
      this.globals.isLoading = false;
    }


    $('.compose_mail_box').addClass('activemail');
  }

  deleteInbox(Inboxres, temp) {
    debugger
    this.deleteEntity = Inboxres;
    var upimpo = { 'Userid': this.globals.authData.UserId, 'EmailNotificationId': Inboxres.EmailNotificationId, 'IsDelete': Inboxres.IsDelete };
    this.globals.isLoading = true;
    this.InboxService.deleteInbox(upimpo)
      .then((data) => {

        if (temp == 1) {
          if (Inboxres.IsDelete == 1) {
            this.emailPreviewEntity.IsDelete = 0;
          } else {
            this.emailPreviewEntity.IsDelete = 1;
          }
        }
        this.globals.isLoading = false;
      },
        (error) => {
          this.globals.isLoading = false;
        });

  }

  readInbox(Inboxres, temp) {
    debugger
    this.deleteEntity = Inboxres;
    var upread = { 'Userid': this.globals.authData.UserId, 'EmailNotificationId': Inboxres.EmailNotificationId, 'IsRead': Inboxres.IsRead };
    this.globals.isLoading = true;
    this.InboxService.readEmails(upread)
      .then((data) => {

        if (temp == 1) {
          if (Inboxres.IsRead == 1) {
            this.emailPreviewEntity.IsRead = 0;
          } else {
            this.emailPreviewEntity.IsRead = 1;
          }
          this.InboxService.getAllData(this.globals.authData.UserId)
          .then((data) => {
            this.inboxcountList = data['inboxcount'];
          },
            (error) => {
              this.globals.isLoading = false;
            });
        }
        this.globals.isLoading = false;
      },
        (error) => {
          this.globals.isLoading = false;
        });

  }

  addstarInbox(Inboxres, temp) {
    debugger
    this.deleteEntity = Inboxres;
    var upstar = { 'Userid': this.globals.authData.UserId, 'EmailNotificationId': Inboxres.EmailNotificationId, 'IsStar': Inboxres.IsStar };
    this.globals.isLoading = true;
    this.InboxService.addstarInbox(upstar)
      .then((data) => {

        if (temp == 1) {
          if (Inboxres.IsStar == 1) {
            this.emailPreviewEntity.IsStar = 0;
          } else {
            this.emailPreviewEntity.IsStar = 1;
          }
        }

        this.globals.isLoading = false;
      },
        (error) => {
          this.globals.isLoading = false;
        });

  }


}
