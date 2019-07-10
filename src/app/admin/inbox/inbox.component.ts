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
import { IOption } from 'ng-select';

@Component({
  selector: 'app-inbox',
  templateUrl: './inbox.component.html',
  styleUrls: ['./inbox.component.css']
})
export class InboxComponent implements OnInit {
  inboxList;
  inboxcountList;

  sendboxList;
  addstarList;
  imortantList;
  draftList;
  draftcountList;
  deleteEntity;
  insEntity;
  emailEntity;
  btn_disable;
  submitted;
  des_valid;
  spamList;
  userList;
  certificate_error;
  size = 0;
  unit = "";
  Check;
  Check2;
  Check3;
  Check4;
  Check5;
  Check6;
  errorMsg;
  currentDate;
  draftIndex;
  emailPreviewEntity;

  constructor(private elem: ElementRef, public globals: Globals, private router: Router, private InboxService: InboxService, private route: ActivatedRoute) { }
  selectedCharacters: Array<string> = [];
  selectedCharactersCc: Array<string> = [];
  selectedCharactersBcc: Array<string> = [];
  ngOnInit() {


    // PERFECT SCROLLBAR
    setTimeout(function () {
      new PerfectScrollbar('.inboxmail');
      new PerfectScrollbar('.inbox_preview_wrap');
    }, 100);
    // END PERFECT SCROLLBAR

    setTimeout(function () {
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



    debugger
    this.Check = false;
    this.Check2 = false;
    this.Check3 = false;
    this.Check4 = false;
    this.Check5 = false;
    this.Check6 = false;
    this.errorMsg = false;
    this.globals.isLoading = true;
    this.des_valid = false;
    this.emailEntity = {};
    this.inboxList = [];
    this.inboxcountList = [];
    this.sendboxList = [];
    this.addstarList = [];
    this.imortantList = [];
    this.draftList = [];
    this.draftcountList = [];
    this.spamList = [];
    this.currentDate = new Date();
    this.emailPreviewEntity = {};

    //this.currentDate=this.currentDate.toDateString();
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
        console.log(this.inboxList);
        this.inboxcountList = data['inboxcount'];
        this.sendboxList = data['sendbox'];
        this.addstarList = data['addstar'];
        this.draftList = data['draft'];
        this.spamList = data['spam'];
        this.draftcountList = data['draftcount'];
        this.globals.isLoading = false;
      },
        (error) => {
          this.globals.isLoading = false;
          this.router.navigate(['/pagenotfound']);
        });

    setTimeout(function () {
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

    let id = this.route.snapshot.paramMap.get('id');
    if (id == '1') {
      $(".tab1").removeClass("active");
      $("#tab1").addClass("active");
    }
    if (id == '2') {
      $(".tab1").removeClass("active");
      $("#tab2").addClass("active");
    }
    if (id == '3') {
      $(".tab1").removeClass("active");
      $("#tab3").addClass("active");
    }
    if (id == '4') {
      $(".tab1").removeClass("active");
      $("#tab4").addClass("active");
    }
    if (id == '5') {
      $(".tab1").removeClass("active");
      $("#tab5").addClass("active");
    }
    //mailbox
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

    // PERFECT SCROLLBAR
    setTimeout(function () {
      new PerfectScrollbar('.composebox');
      new PerfectScrollbar('.compose_mail_box');
      new PerfectScrollbar('.mailboxwrap');
    }, 500);
    // END PERFECT SCROLLBAR

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
          this.emailPreviewEntity.Subject = "RE: " + data['Subject'];

          let MessageBody = "<br/><hr/><b>From : </b>" + data['EmailAddress'] + "<br/><b>Sent : </b>" + data['CreatedOn'] + "<br/><b>To : </b>" + data['ToEmailAddressGroup'] + "<br/><b>Subject : </b>" + data['Subject'] + "<br/>" + data['MessageBody'] + "<br/>" + "<br/>" + "<br/>";
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
          this.emailPreviewEntity.Subject = "FW: " + data['Subject'];

          let MessageBody = "<br/><hr/><b>From : </b>" + data['EmailAddress'] + "<br/><b>Sent : </b>" + data['CreatedOn'] + "<br/><b>To : </b>" + data['ToEmailAddressGroup'] + "<br/><b>Subject : </b>" + data['Subject'] + "<br/>" + data['MessageBody'] + "<br/>" + "<br/>" + "<br/>";
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
          this.emailPreviewEntity.Subject = "RE: " + data['Subject'];

          let MessageBody = "<br/><hr/><b>From : </b>" + data['EmailAddress'] + "<br/><b>Sent : </b>" + data['CreatedOn'] + "<br/><b>To : </b>" + data['ToEmailAddressGroup'] + "<br/><b>Subject : </b>" + data['Subject'] + "<br/>" + data['MessageBody'] + "<br/>" + "<br/>" + "<br/>";
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



  // **
  clearEntity() {
    this.emailEntity = {};
    this.emailEntity.EmailNotificationId = 0;
    this.selectedCharacters = [];
    this.selectedCharactersCc = [];
    this.selectedCharactersBcc = [];
    CKEDITOR.instances.MessageBody.setData('');
  }


  selectAll() {
    var check = this.Check;
    if (check) {
      this.Check = false;
    } else {
      this.Check = true;
    }

    for (var i = 0; i < this.inboxList.length; i++) {
      if (check) {
        this.inboxList[i].Check = false;
      } else {
        this.inboxList[i].Check = true;
      }

    }
  }

  selectAllSent() {
    var check3 = this.Check3;
    if (check3) {
      this.Check3 = false;
    } else {
      this.Check3 = true;
    }
    for (var i = 0; i < this.sendboxList.length; i++) {
      if (check3) {
        this.sendboxList[i].Check3 = false;
      } else {
        this.sendboxList[i].Check3 = true;
      }

    }
  }

  selectAllStar() {
    var check5 = this.Check5;
    if (check5) {
      this.Check5 = false;
    } else {
      this.Check5 = true;
    }
    for (var i = 0; i < this.addstarList.length; i++) {
      if (check5) {
        this.addstarList[i].Check5 = false;
      } else {
        this.addstarList[i].Check5 = true;
      }
    }
  }

  selectAllSpam() {
    var check2 = this.Check2;
    if (check2) {
      this.Check2 = false;
    } else {
      this.Check2 = true;
    }
    for (var i = 0; i < this.spamList.length; i++) {
      if (check2) {
        this.spamList[i].Check2 = false;
      } else {
        this.spamList[i].Check2 = true;
      }
    }
  }

  selectAllDraft() {
    var check4 = this.Check4;
    if (check4) {
      this.Check4 = false;
    } else {
      this.Check4 = true;
    }
    for (var i = 0; i < this.draftList.length; i++) {
      if (check4) {
        this.draftList[i].Check4 = false;
      } else {
        this.draftList[i].Check4 = true;
      }
    }
  }

  // **
  sentbox() {
    this.InboxService.getAllSentbox(this.globals.authData.UserId)
      .then((data) => {
        this.sendboxList = data['sendbox'];
        this.inboxcountList = data['inboxcount'];
      },
        (error) => {


        });
  }

  // **
  inbox() {
    this.InboxService.getAllInbox(this.globals.authData.UserId)
      .then((data) => {
        this.inboxList = data['inbox'];
        this.inboxcountList = data['inboxcount'];
        $(".tab1").removeClass("active");
        $("#tab1").addClass("active");
      },
        (error) => {

        });

  }

  // **
  starred() {
    this.InboxService.getAllStarred(this.globals.authData.UserId)
      .then((data) => {
        this.addstarList = data['addstar'];
        this.inboxcountList = data['inboxcount'];

      },
        (error) => {


        });
  }

  //** */
  draft() {
    this.InboxService.getAllDraft(this.globals.authData.UserId)
      .then((data) => {
        this.draftList = data['draft'];
        this.inboxcountList = data['inboxcount'];
      },
        (error) => {

        });
  }

  // **
  spam() {

    this.InboxService.getAllSpam(this.globals.authData.UserId)
      .then((data) => {
        this.spamList = data['spam'];
        this.inboxcountList = data['inboxcount'];
      },
        (error) => {


        });
  }


  // add to email as Draft **
  drfatEdit(Draftres, index) {
    debugger
    //this.emailEntity=Draftres;
    console.log(this.emailEntity);
    this.selectedCharacters = Draftres['selectedCharacters'];
    this.selectedCharactersCc = Draftres['selectedCharactersCc'];
    this.selectedCharactersBcc = Draftres['selectedCharactersBcc'];
    this.emailEntity.Subject = Draftres['Subject'];
    this.emailEntity.EmailNotificationId = Draftres['EmailNotificationId'];
    this.emailEntity.MessageBody = CKEDITOR.instances.MessageBody.setData(Draftres['MessageBody']);
    $('.compose_mail_box').addClass('activemail');
    this.draftIndex = index;
    //alert(this.emailEntity.Subject);
  }

  // ** add to mail compose
  addEmail(AddNewForm) {
    debugger
    this.emailEntity.UserId = this.selectedCharacters;
    this.emailEntity.UserId2 = this.selectedCharactersCc;
    this.emailEntity.UserId3 = this.selectedCharactersBcc;
    this.emailEntity.MessageBody = CKEDITOR.instances.MessageBody.getData();
    if (this.emailEntity.UserId != '') {
      this.errorMsg = false;
    }
    else {
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
    var size = 25000000;
    var imageSize = 0;
    this.emailEntity.Attachment = [];
    if (file1.length > 0) {
      for (var i = 0; i < file1.length; i++) {
        var Attachment = Date.now() + '_' + file1[i]['name'];
        imageSize = imageSize + file1[i].size;

        fd.append('Attachment' + i, file1[i], Attachment);
        this.emailEntity.Attachment.push(Attachment);
      }
      if (imageSize > size) {

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

    if (AddNewForm.valid && !this.des_valid && imageSize <= size && !this.errorMsg) {

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
                this.emailEntity.UserId = this.selectedCharacters = [''];
                this.emailEntity.UserId2 = this.selectedCharactersCc = [''];
                this.emailEntity.UserId3 = this.selectedCharactersBcc = [''];
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
    this.emailEntity.UserId = this.selectedCharacters;
    this.emailEntity.UserId2 = this.selectedCharactersCc;
    this.emailEntity.UserId3 = this.selectedCharactersBcc;
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
    var size = 25000000;
    var imageSize = 0;
    this.emailEntity.Attachment = [];
    if (file1.length > 0) {
      for (var i = 0; i < file1.length; i++) {
        var Attachment = Date.now() + '_' + file1[i]['name'];
        imageSize = imageSize + file1[i].size;
        fd.append('Attachment' + i, file1[i], Attachment);
        this.emailEntity.Attachment.push(Attachment);
      }
      if (imageSize > size) {

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

    if (imageSize <= size) {
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

                      this.draftList[this.draftIndex].selectedCharacters = this.selectedCharacters;
                      this.draftList[this.draftIndex].selectedCharactersCc = this.selectedCharactersCc;
                      this.draftList[this.draftIndex].selectedCharactersBcc = this.selectedCharactersBcc;
                      this.draftList[this.draftIndex].Subject = this.emailEntity.Subject;
                      this.draftList[this.draftIndex].MessageBody = this.emailEntity.MessageBody;

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
                  this.draftList[this.draftIndex].selectedCharacters = this.selectedCharacters;
                  this.draftList[this.draftIndex].selectedCharactersCc = this.selectedCharactersCc;
                  this.draftList[this.draftIndex].selectedCharactersBcc = this.selectedCharactersBcc;
                  this.draftList[this.draftIndex].Subject = this.emailEntity.Subject;
                  this.draftList[this.draftIndex].MessageBody = this.emailEntity.MessageBody;
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
    this.emailEntity.UserId = this.selectedCharacters;
    this.emailEntity.UserId2 = this.selectedCharactersCc;
    this.emailEntity.UserId3 = this.selectedCharactersBcc;
    // this.emailEntity.Subject;
    this.emailEntity.MessageBody = CKEDITOR.instances.MessageBody.getData();
    if (this.emailEntity.UserId == '' && this.emailEntity.UserId2 == '' && this.emailEntity.UserId3 == '' && this.emailEntity.MessageBody == '') {
      this.emailEntity.UserId = this.selectedCharacters = [''];
      this.emailEntity = {};
      $('.compose_mail_box').removeClass('activemail');
    } else {

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
      var size = 25000000;
      var imageSize = 0;
      this.emailEntity.Attachment = [];
      if (file1.length > 0) {
        for (var i = 0; i < file1.length; i++) {
          var Attachment = Date.now() + '_' + file1[i]['name'];
          imageSize = imageSize + file1[i].size;
          fd.append('Attachment' + i, file1[i], Attachment);
          this.emailEntity.Attachment.push(Attachment);
        }
        if (imageSize > size) {

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
                          this.draftList[this.draftIndex].selectedCharacters = this.selectedCharacters;
                          this.draftList[this.draftIndex].selectedCharactersCc = this.selectedCharactersCc;
                          this.draftList[this.draftIndex].selectedCharactersBcc = this.selectedCharactersBcc;
                          this.draftList[this.draftIndex].Subject = this.emailEntity.Subject;
                          this.draftList[this.draftIndex].MessageBody = this.emailEntity.MessageBody;
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
                  this.draftList[this.draftIndex].selectedCharacters = this.selectedCharacters;
                  this.draftList[this.draftIndex].selectedCharactersCc = this.selectedCharactersCc;
                  this.draftList[this.draftIndex].selectedCharactersBcc = this.selectedCharactersBcc;
                  this.draftList[this.draftIndex].Subject = this.emailEntity.Subject;
                  this.draftList[this.draftIndex].MessageBody = this.emailEntity.MessageBody;
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




  // ** add to mark as permentnt delete **
  deletePermenantInbox(Spamres) {
    debugger
    this.deleteEntity = Spamres;
    swal({
      title: 'Delete an Email',
      text: "Are you sure you want to delete this email?",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes',
      cancelButtonText: 'No'
    })
      .then((result) => {
        if (result.value) {
          var del = { 'Userid': this.globals.authData.UserId, 'id': Spamres.EmailNotificationId };
          this.InboxService.delete(del)
            .then((data) => {
              let index = this.spamList.indexOf(Spamres);
              $('#Delete_Modal').modal('hide');
              if (index != -1) {
                this.spamList.splice(index, 1);
                this.spamList = data['spam'];
              }
              swal({

                type: 'success',
                title: 'Email deleted successfully.',
                showConfirmButton: false,
                timer: 3000
              })
              this.InboxService.getAllSpam(this.globals.authData.UserId)
                .then((data) => {
                  this.spamList = data['spam'];
                },
                  (error) => {
                    //alert('error');

                  });
            },
              (error) => {
                $('#Delete_Modal').modal('hide');
                if (error.text) {

                }
              });
        }
      })

  }

  //  add to mark as multie unread **
  unreadMultiInbox() {
    debugger
    let pusheditems = [];
    var inbox_length = this.inboxList.length;
    if (inbox_length > 0) {
      for (var i = 0; i < inbox_length; i++) {
        if (this.inboxList[i].Check) {
          pusheditems.push(this.inboxList[i].EmailNotificationId);
        }
      }
      // console.log(pusheditems);  
      if (pusheditems.length > 0) {
        var upreadmultie = { 'Userid': this.globals.authData.UserId, 'MultiId': pusheditems };
        this.InboxService.unreadMultieEmails(upreadmultie)
          .then((data) => {
            let index = this.inboxList.indexOf(pusheditems);


            for (var i = 0; i < inbox_length; i++) {
              //this.inboxList[i].Check;
              if (this.inboxList[i].Check) {
                this.inboxList[i].IsRead = 0;
              }
            }

            for (var i = 0; i < inbox_length; i++) {
              this.inboxList[i].Check == false;
            }

            swal({

              type: 'success',
              title: 'Emails add as unread successfully.',
              showConfirmButton: false,
              timer: 3000
            })
            this.globals.isLoading = false;
            this.InboxService.getAllInbox(this.globals.authData.UserId)
              .then((data) => {
                this.inboxList = data['inbox'];
                this.inboxcountList = data['inboxcount'];
              },
                (error) => {

                });
          },
            (error) => {
              this.globals.isLoading = false;
            });
      }
      else {
        swal({

          type: 'warning',
          title: 'Please select at least one email.',
          showConfirmButton: false,
          timer: 3000
        })
        this.globals.isLoading = false;
      }
    }

  }





  // ** add to mark as multie unread **
  starunreadMultiInbox() {
    debugger
    let pusheditems = [];
    var inbox_length = this.addstarList.length;
    if (inbox_length > 0) {
      for (var i = 0; i < inbox_length; i++) {
        if (this.addstarList[i].Check5) {
          pusheditems.push(this.addstarList[i].EmailNotificationId);
        }
      }
      // console.log(pusheditems);  
      if (pusheditems.length > 0) {
        var upreadmultie = { 'Userid': this.globals.authData.UserId, 'MultiId': pusheditems };
        this.InboxService.unreadMultieEmails(upreadmultie)
          .then((data) => {
            let index = this.addstarList.indexOf(pusheditems);
            for (var i = 0; i < inbox_length; i++) {

              if (this.addstarList[i].Check5) {
                this.addstarList[i].IsRead = 0;
              }
              this.addstarList[i].Check5 = false;
            }

            swal({

              type: 'success',
              title: 'Emails add as unread successfully.',
              showConfirmButton: false,
              timer: 3000
            })
            this.globals.isLoading = false;
            this.InboxService.getAllStarred(this.globals.authData.UserId)
              .then((data) => {
                this.addstarList = data['addstar'];
                this.inboxcountList = data['inboxcount'];
              },
                (error) => {

                });

          },
            (error) => {
              this.globals.isLoading = false;
            });
      }
      else {
        swal({

          type: 'warning',
          title: 'Please select at least one email.',
          showConfirmButton: false,
          timer: 3000
        })
        this.globals.isLoading = false;
      }
    }

  }


  // ** add draft to mark as multie unread **
  draftunreadMultiInbox() {
    debugger
    let pusheditems = [];
    var inbox_length = this.draftList.length;
    if (inbox_length > 0) {
      for (var i = 0; i < inbox_length; i++) {
        if (this.draftList[i].Check4) {
          pusheditems.push(this.draftList[i].EmailNotificationId);
        }
      }
      if (pusheditems.length > 0) {
        var upreadmultie = { 'Userid': this.globals.authData.UserId, 'MultiId': pusheditems };
        this.InboxService.unreadMultieEmails(upreadmultie)
          .then((data) => {
            let index = this.draftList.indexOf(pusheditems);


            for (var i = 0; i < inbox_length; i++) {
              //this.draftList[i].Check;
              if (this.draftList[i].Check4) {
                this.draftList[i].IsRead = 0;
              }
              this.draftList[i].Check4 = false;
            }

            swal({

              type: 'success',
              title: 'Emails add as unread successfully.',
              showConfirmButton: false,
              timer: 3000
            })
            this.globals.isLoading = false;
            this.InboxService.getAllDraft(this.globals.authData.UserId)
              .then((data) => {
                this.draftList = data['draft'];
              },
                (error) => {
                });
          },
            (error) => {
              this.globals.isLoading = false;
            });
      }
      else {
        swal({

          type: 'warning',
          title: 'Please select at least one email.',
          showConfirmButton: false,
          timer: 3000
        })
        this.globals.isLoading = false;
      }
    }

  }


  // ** add sendbox to mark as multie unread **
  sendunreadMultiInbox() {
    debugger
    let pusheditems = [];
    var inbox_length = this.sendboxList.length;
    if (inbox_length > 0) {
      for (var i = 0; i < inbox_length; i++) {
        if (this.sendboxList[i].Check3) {
          pusheditems.push(this.sendboxList[i].EmailNotificationId);
        }
      }
      if (pusheditems.length > 0) {
        var upreadmultie = { 'Userid': this.globals.authData.UserId, 'MultiId': pusheditems };
        this.InboxService.unreadSendMultieEmails(upreadmultie)
          .then((data) => {
            let index = this.sendboxList.indexOf(pusheditems);


            for (var i = 0; i < inbox_length; i++) {
              if (this.sendboxList[i].Check3) {
                this.sendboxList[i].IsRead = 0;
              }
              this.sendboxList[i].Check3 = false;
            }


            swal({

              type: 'success',
              title: 'Emails add as unread successfully.',
              showConfirmButton: false,
              timer: 3000
            })
            this.globals.isLoading = false;
            this.InboxService.getAllSentbox(this.globals.authData.UserId)
              .then((data) => {
                this.sendboxList = data['sendbox'];
              },
                (error) => {
                });
            this.InboxService.getAllInbox(this.globals.authData.UserId)
              .then((data) => {
                this.inboxcountList = data['inboxcount'];
              },
                (error) => {

                });
          },
            (error) => {
              this.globals.isLoading = false;
            });
      }
      else {
        swal({

          type: 'warning',
          title: 'Please select at least one email.',
          showConfirmButton: false,
          timer: 3000
        })
        this.globals.isLoading = false;
      }
    }

  }


  // ** add to mark as multie unread **
  spamunreadMultiInbox() {
    debugger
    let pusheditems = [];
    var inbox_length = this.spamList.length;
    if (inbox_length > 0) {
      for (var i = 0; i < inbox_length; i++) {
        if (this.spamList[i].Check2) {
          pusheditems.push(this.spamList[i].EmailNotificationId);
        }
      }
      // console.log(pusheditems);  
      if (pusheditems.length > 0) {
        var upreadmultie = { 'Userid': this.globals.authData.UserId, 'MultiId': pusheditems };
        this.InboxService.unreadMultieEmails(upreadmultie)
          .then((data) => {
            let index = this.inboxList.indexOf(pusheditems);


            for (var i = 0; i < inbox_length; i++) {
              //this.inboxList[i].Check;
              if (this.spamList[i].Check2) {
                this.spamList[i].IsRead = 0;
              }
              this.spamList[i].Check2 = false;
            }
            swal({

              type: 'success',
              title: 'Emails add as unread successfully.',
              showConfirmButton: false,
              timer: 3000
            })
            this.globals.isLoading = false;
            this.InboxService.getAllSpam(this.globals.authData.UserId)
              .then((data) => {
                this.spamList = data['spam'];
                this.inboxcountList = data['inboxcount'];
              },
                (error) => {

                });
          },
            (error) => {
              this.globals.isLoading = false;
            });
      }
      else {
        swal({

          type: 'warning',
          title: 'Please select at least one email.',
          showConfirmButton: false,
          timer: 3000
        })
        this.globals.isLoading = false;
      }
    }

  }


  // ** add to mark as multie readed **
  readMultiInbox() {
    debugger
    let pusheditems = [];
    var inbox_length = this.inboxList.length;
    if (inbox_length > 0) {
      for (var i = 0; i < inbox_length; i++) {
        if (this.inboxList[i].Check) {
          pusheditems.push(this.inboxList[i].EmailNotificationId);
        }
      }
      // console.log(pusheditems);  
      if (pusheditems.length > 0) {
        var upreadmultie = { 'Userid': this.globals.authData.UserId, 'MultiId': pusheditems };
        this.InboxService.readMultieEmails(upreadmultie)
          .then((data) => {
            let index = this.inboxList.indexOf(pusheditems);


            for (var i = 0; i < inbox_length; i++) {
              //this.inboxList[i].Check;
              if (this.inboxList[i].Check) {
                this.inboxList[i].IsRead = 1;
              } else {
                this.inboxList[i].IsRead = 0;
              }
              this.inboxList[i].Check = false;
            }

            swal({

              type: 'success',
              title: 'Emails add as read successfully.',
              showConfirmButton: false,
              timer: 3000
            })
            this.globals.isLoading = false;
            this.InboxService.getAllInbox(this.globals.authData.UserId)
              .then((data) => {
                this.inboxList = data['inbox'];
                this.inboxcountList = data['inboxcount'];
              },
                (error) => {

                });
          },
            (error) => {
              this.globals.isLoading = false;
            });
      }
      else {
        swal({

          type: 'warning',
          title: 'Please select at least one email.',
          showConfirmButton: false,
          timer: 3000
        })
        this.globals.isLoading = false;

      }
    }

  }




  // ** add start to mark as multie readed **
  starreadMultiInbox() {
    debugger
    let pusheditems = [];
    var inbox_length = this.addstarList.length;
    if (inbox_length > 0) {
      for (var i = 0; i < inbox_length; i++) {
        if (this.addstarList[i].Check5) {
          pusheditems.push(this.addstarList[i].EmailNotificationId);
        }
      }
      // console.log(pusheditems);  
      if (pusheditems.length > 0) {
        var upreadmultie = { 'Userid': this.globals.authData.UserId, 'MultiId': pusheditems };
        this.InboxService.readMultieEmails(upreadmultie)
          .then((data) => {
            let index = this.addstarList.indexOf(pusheditems);


            for (var i = 0; i < inbox_length; i++) {
              //this.inboxList[i].Check;
              if (this.addstarList[i].Check5) {
                this.addstarList[i].IsRead = 1;
              } else {
                this.addstarList[i].IsRead = 0;
              }
              this.addstarList[i].Check5 = false;
            }
            swal({

              type: 'success',
              title: 'Emails add as read successfully.',
              showConfirmButton: false,
              timer: 3000
            })
            this.globals.isLoading = false;
            this.InboxService.getAllStarred(this.globals.authData.UserId)
              .then((data) => {
                this.addstarList = data['addstar'];
                this.inboxcountList = data['inboxcount'];
              },
                (error) => {
                  //alert('error');

                });
          },
            (error) => {
              this.globals.isLoading = false;
            });
      }
      else {
        swal({

          type: 'warning',
          title: 'Please select at least one email.',
          showConfirmButton: false,
          timer: 3000
        })
        this.globals.isLoading = false;

      }
    }

  }


  // ** add draft to mark as multie readed **
  draftreadMultiInbox() {
    debugger
    let pusheditems = [];
    var inbox_length = this.draftList.length;
    if (inbox_length > 0) {
      for (var i = 0; i < inbox_length; i++) {
        if (this.draftList[i].Check4) {
          pusheditems.push(this.draftList[i].EmailNotificationId);
        }
      }
      // console.log(pusheditems);  
      if (pusheditems.length > 0) {
        var upreadmultie = { 'Userid': this.globals.authData.UserId, 'MultiId': pusheditems };
        this.InboxService.readMultieEmails(upreadmultie)
          .then((data) => {
            let index = this.draftList.indexOf(pusheditems);


            for (var i = 0; i < inbox_length; i++) {
              //this.draftList[i].Check;
              if (this.draftList[i].Check4) {
                this.draftList[i].IsRead = 1;
              } else {
                this.draftList[i].IsRead = 0;
              }
              this.draftList[i].Check4 = false;
            }

            swal({

              type: 'success',
              title: 'Emails add as read successfully.',
              showConfirmButton: false,
              timer: 3000
            })
            this.globals.isLoading = false;
            this.InboxService.getAllDraft(this.globals.authData.UserId)
              .then((data) => {
                this.draftList = data['draft'];
              },
                (error) => {
                  //alert('error');

                });
          },
            (error) => {
              this.globals.isLoading = false;
            });
      }
      else {
        swal({

          type: 'warning',
          title: 'Please select at least one email.',
          showConfirmButton: false,
          timer: 3000
        })
        this.globals.isLoading = false;

      }
    }

  }


  // ** add spam mark as multie readed **
  spamreadMultiInbox() {
    debugger
    let pusheditems = [];
    var inbox_length = this.spamList.length;
    if (inbox_length > 0) {
      for (var i = 0; i < inbox_length; i++) {
        if (this.spamList[i].Check2) {
          pusheditems.push(this.spamList[i].EmailNotificationId);
        }
      }
      // console.log(pusheditems);  
      if (pusheditems.length > 0) {
        var upreadmultie = { 'Userid': this.globals.authData.UserId, 'MultiId': pusheditems };
        this.InboxService.readMultieEmails(upreadmultie)
          .then((data) => {
            let index = this.spamList.indexOf(pusheditems);


            for (var i = 0; i < inbox_length; i++) {
              //this.spamList[i].Check;
              if (this.spamList[i].Check2) {
                this.spamList[i].IsRead = 1;
              } else {
                this.spamList[i].IsRead = 0;
              }
              this.spamList[i].Check2 = false;
            }

            swal({

              type: 'success',
              title: 'Emails add as read successfully.',
              showConfirmButton: false,
              timer: 3000
            })
            this.globals.isLoading = false;
            this.InboxService.getAllSpam(this.globals.authData.UserId)
              .then((data) => {
                this.spamList = data['spam'];
                this.inboxcountList = data['inboxcount'];
              },
                (error) => {
                  //alert('error');

                });
          },
            (error) => {
              this.globals.isLoading = false;
            });
      }
      else {
        swal({

          type: 'warning',
          title: 'Please select at least one email.',
          showConfirmButton: false,
          timer: 3000
        })
        this.globals.isLoading = false;

      }
    }

  }


  // ** add sendbox to mark as multie readed **
  sendreadMultiInbox() {
    debugger
    let pusheditems = [];
    var inbox_length = this.sendboxList.length;
    if (inbox_length > 0) {
      for (var i = 0; i < inbox_length; i++) {
        if (this.sendboxList[i].Check3) {
          pusheditems.push(this.sendboxList[i].EmailNotificationId);
        }
      }
      // console.log(pusheditems);  
      if (pusheditems.length > 0) {
        var upreadmultie = { 'Userid': this.globals.authData.UserId, 'MultiId': pusheditems };
        this.InboxService.readMultieEmails(upreadmultie)
          .then((data) => {
            let index = this.sendboxList.indexOf(pusheditems);


            for (var i = 0; i < inbox_length; i++) {
              //this.inboxList[i].Check;
              if (this.sendboxList[i].Check3) {
                this.sendboxList[i].IsRead = 1;
              } else {
                this.sendboxList[i].IsRead = 0;
              }
              this.sendboxList[i].Check3 = false;
            }

            swal({

              type: 'success',
              title: 'Emails add as read successfully.',
              showConfirmButton: false,
              timer: 3000
            })
            this.globals.isLoading = false;
            this.InboxService.getAllSentbox(this.globals.authData.UserId)
              .then((data) => {
                this.sendboxList = data['sendbox'];
              },
                (error) => {
                });
            this.InboxService.getAllInbox(this.globals.authData.UserId)
              .then((data) => {
                this.inboxList = data['inbox'];
                this.inboxcountList = data['inboxcount'];
              },
                (error) => {

                });
          },
            (error) => {
              this.globals.isLoading = false;
            });
      }
      else {
        swal({

          type: 'warning',
          title: 'Please select at least one email.',
          showConfirmButton: false,
          timer: 3000
        })
        this.globals.isLoading = false;

      }
    }

  }


  // delete all spam email permenant **
  deleteAllPermInbox() {
    debugger
    let pusheditems = [];
    var inbox_length = this.spamList.length;
    if (inbox_length > 0) {
      for (var i = 0; i < inbox_length; i++) {

        if (this.spamList[i].Check2) {
          pusheditems.push(this.spamList[i].EmailNotificationId)
        }
      }
      // console.log(pusheditems); 
      if (pusheditems.length > 0) {
        var upstarredmultie = { 'Userid': this.globals.authData.UserId, 'MultiId': pusheditems };
        this.InboxService.deleteAllPermInbox(upstarredmultie)
          .then((data) => {


            let index = this.spamList.indexOf(this.spamList[i]);
            $('#Delete_Modal').modal('hide');
            if (index != -1) {
              this.spamList.splice(index, 1);
            }

            swal({

              type: 'success',
              title: 'Emails deleted successfully.',
              showConfirmButton: false,
              timer: 3000
            })
            this.globals.isLoading = false;
            this.InboxService.getAllSpam(this.globals.authData.UserId)
              .then((data) => {
                this.spamList = data['spam'];
              },
                (error) => {
                });
          },
            (error) => {
              this.globals.isLoading = false;
            });
      }
      else {
        swal({

          type: 'warning',
          title: 'Please select at least one email.',
          showConfirmButton: false,
          timer: 3000
        })
        this.globals.isLoading = false;

      }
    }

  }


  // ** add to mark as multie sttared **
  starredMultiInbox() {
    debugger
    let pusheditems = [];
    var inbox_length = this.inboxList.length;
    if (inbox_length > 0) {
      for (var i = 0; i < inbox_length; i++) {
        this.inboxList[i].Check;
        if (this.inboxList[i].Check) {
          pusheditems.push(this.inboxList[i].EmailNotificationId)
        }
      }

      if (pusheditems.length > 0) {
        var upstarredmultie = { 'Userid': this.globals.authData.UserId, 'MultiId': pusheditems };
        this.InboxService.starredMultieEmails(upstarredmultie)
          .then((data) => {
            let index = this.inboxList.indexOf(pusheditems);


            for (var i = 0; i < inbox_length; i++) {
              if (this.inboxList[i].Check) {
                this.inboxList[i].IsStar = 1;
              } else {
                this.inboxList[i].IsStar = 0;
              }
              this.inboxList[i].Check = false;
            }
            swal({

              type: 'success',
              title: 'Emails add as starred successfully.',
              showConfirmButton: false,
              timer: 3000
            })
            this.globals.isLoading = false;
            this.InboxService.getAllInbox(this.globals.authData.UserId)
              .then((data) => {
                this.inboxList = data['inbox'];
              },
                (error) => {

                });

          },
            (error) => {
              this.globals.isLoading = false;
            });
      }
      else {
        swal({

          type: 'warning',
          title: 'Please select at least one email.',
          showConfirmButton: false,
          timer: 3000
        })
        this.globals.isLoading = false;

      }
    }

  }


  // ** add to mark as multie sttared **
  draftstarredMultiInbox() {
    debugger
    let pusheditems = [];
    var inbox_length = this.draftList.length;
    if (inbox_length > 0) {
      for (var i = 0; i < inbox_length; i++) {
        if (this.draftList[i].Check4) {
          pusheditems.push(this.draftList[i].EmailNotificationId)
        }
      }
      // console.log(pusheditems);  
      if (pusheditems.length > 0) {
        var upstarredmultie = { 'Userid': this.globals.authData.UserId, 'MultiId': pusheditems };
        this.InboxService.starredMultieEmails(upstarredmultie)
          .then((data) => {
            let index = this.draftList.indexOf(pusheditems);


            for (var i = 0; i < inbox_length; i++) {
              //this.draftList[i].Check;
              if (this.draftList[i].Check4) {
                this.draftList[i].IsStar = 1;
              } else {
                this.draftList[i].IsStar = 0;
              }
              this.draftList[i].Check4 = false;
            }
            swal({

              type: 'success',
              title: 'Emails add as starred successfully.',
              showConfirmButton: false,
              timer: 3000
            })
            this.globals.isLoading = false;
            this.InboxService.getAllDraft(this.globals.authData.UserId)
              .then((data) => {
                this.draftList = data['draft'];
              },
                (error) => {
                });
          },
            (error) => {
              this.globals.isLoading = false;
            });
      }
      else {
        swal({

          type: 'warning',
          title: 'Please select at least one email.',
          showConfirmButton: false,
          timer: 3000
        })
        this.globals.isLoading = false;

      }
    }

  }


  // ** add to mark as multie sttared **
  spamstarredMultiInbox() {
    debugger
    let pusheditems = [];
    var inbox_length = this.spamList.length;
    if (inbox_length > 0) {
      for (var i = 0; i < inbox_length; i++) {
        this.spamList[i].Check;
        if (this.spamList[i].Check2) {
          pusheditems.push(this.spamList[i].EmailNotificationId)
        }
      }
      // console.log(pusheditems);  
      if (pusheditems.length > 0) {
        var upstarredmultie = { 'Userid': this.globals.authData.UserId, 'MultiId': pusheditems };
        this.InboxService.starredMultieEmails(upstarredmultie)
          .then((data) => {
            let index = this.spamList.indexOf(pusheditems);


            for (var i = 0; i < inbox_length; i++) {
              //this.spamList[i].Check;
              if (this.spamList[i].Check2) {
                this.spamList[i].IsStar = 1;
              } else {
                this.spamList[i].IsStar = 0;
              }
              this.spamList[i].Check2 = false;
            }

            swal({

              type: 'success',
              title: 'Emails add as starred successfully.',
              showConfirmButton: false,
              timer: 3000
            })
            this.globals.isLoading = false;
            this.InboxService.getAllSpam(this.globals.authData.UserId)
              .then((data) => {
                this.spamList = data['spam'];
              },
                (error) => {
                });
          },
            (error) => {
              this.globals.isLoading = false;
            });
      }
      else {
        swal({

          type: 'warning',
          title: 'Please select at least one email.',
          showConfirmButton: false,
          timer: 3000
        })
        this.globals.isLoading = false;

      }
    }

  }



  // ** add sendbox to mark as multie sttared **
  sendstarredMultiInbox() {
    debugger
    let pusheditems = [];
    var inbox_length = this.sendboxList.length;
    if (inbox_length > 0) {
      for (var i = 0; i < inbox_length; i++) {
        this.sendboxList[i].Check;
        if (this.sendboxList[i].Check3) {
          pusheditems.push(this.sendboxList[i].EmailNotificationId)
        }
      }
      // console.log(pusheditems);  
      if (pusheditems.length > 0) {
        var upstarredmultie = { 'Userid': this.globals.authData.UserId, 'MultiId': pusheditems };
        this.InboxService.sendstarredMultieEmails(upstarredmultie)
          .then((data) => {
            let index = this.sendboxList.indexOf(pusheditems);


            for (var i = 0; i < inbox_length; i++) {

              if (this.sendboxList[i].Check3) {
                this.sendboxList[i].IsStar = 1;
              } else {
                this.sendboxList[i].IsStar = 0;
              }
              this.sendboxList[i].Check3 = false;
            }
            swal({

              type: 'success',
              title: 'Emails add as starred successfully.',
              showConfirmButton: false,
              timer: 3000
            })
            this.globals.isLoading = false;
            this.InboxService.getAllSentbox(this.globals.authData.UserId)
              .then((data) => {
                this.sendboxList = data['sendbox'];
              },
                (error) => {
                });
          },
            (error) => {
              this.globals.isLoading = false;
            });
      }
      else {
        swal({

          type: 'warning',
          title: 'Please select at least one email.',
          showConfirmButton: false,
          timer: 3000
        })
        this.globals.isLoading = false;

      }
    }

  }




  // ** add to mark as multie delete **
  deleteMultiInbox() {
    debugger
    let pusheditems = [];
    var inbox_length = this.inboxList.length;
    if (inbox_length > 0) {
      for (var i = 0; i < inbox_length; i++) {
        if (this.inboxList[i].Check) {
          pusheditems.push(this.inboxList[i].EmailNotificationId)
        }
      }

      if (pusheditems.length > 0) {
        var updeletemultie = { 'Userid': this.globals.authData.UserId, 'MultiId': pusheditems };
        this.InboxService.deleteMultieEmails(updeletemultie)
          .then((data) => {
            for (var i = 0; i < inbox_length; i++) {
              if (this.inboxList[i].Check) {
                this.inboxList[i].IsDelete = 1;
              } else {
                this.inboxList[i].IsDelete = 0;
              }
              this.inboxList[i].Check = false;
            }
            swal({

              type: 'success',
              title: 'Emails add as spam successfully.',
              showConfirmButton: false,
              timer: 3000
            })
            this.globals.isLoading = false;
            this.InboxService.getAllInbox(this.globals.authData.UserId)
              .then((data) => {
                this.inboxList = data['inbox'];
              },
                (error) => {

                });
          },
            (error) => {
              this.globals.isLoading = false;
            });
      }
      else {
        swal({

          type: 'warning',
          title: 'Please select at least one email.',
          showConfirmButton: false,
          timer: 3000
        })
        this.globals.isLoading = false;

      }
    }


  }




  // ** add starred to mark as multie delete **
  stardeleteMultiInbox() {
    debugger
    let pusheditems = [];
    var inbox_length = this.addstarList.length;
    if (inbox_length > 0) {
      for (var i = 0; i < inbox_length; i++) {
        if (this.addstarList[i].Check5) {
          pusheditems.push(this.addstarList[i].EmailNotificationId)
        }
      }
      if (pusheditems.length > 0) {
        var updeletemultie = { 'Userid': this.globals.authData.UserId, 'MultiId': pusheditems };
        this.InboxService.deleteMultieEmails(updeletemultie)
          .then((data) => {
            let index = this.addstarList.indexOf(pusheditems);


            for (var i = 0; i < inbox_length; i++) {
              if (this.addstarList[i].Check5) {
                this.addstarList[i].IsDelete = 1;
              } else {
                this.addstarList[i].IsDelete = 0;
              }
              this.addstarList[i].Check5 = false;
            }
            swal({

              type: 'success',
              title: 'Emails add as spam successfully.',
              showConfirmButton: false,
              timer: 3000
            })
            this.globals.isLoading = false;
            this.InboxService.getAllStarred(this.globals.authData.UserId)
              .then((data) => {
                this.addstarList = data['addstar'];
              },
                (error) => {

                });
          },
            (error) => {
              this.globals.isLoading = false;
            });
      }
      else {
        swal({

          type: 'warning',
          title: 'Please select at least one email.',
          showConfirmButton: false,
          timer: 3000
        })
        this.globals.isLoading = false;

      }
    }


  }

  // // ** add draft to mark as multie delete **
  draftdeleteMultiInbox() {
    debugger
    let pusheditems = [];
    var inbox_length = this.draftList.length;
    if (inbox_length > 0) {
      for (var i = 0; i < inbox_length; i++) {
        if (this.draftList[i].Check4) {
          pusheditems.push(this.draftList[i].EmailNotificationId)
        }
      }
      if (pusheditems.length > 0) {
        var updeletemultie = { 'Userid': this.globals.authData.UserId, 'MultiId': pusheditems };
        this.InboxService.deleteMultieEmails(updeletemultie)
          .then((data) => {
            let index = this.draftList.indexOf(pusheditems);
            for (var i = 0; i < inbox_length; i++) {
              if (this.draftList[i].Check4) {
                this.draftList[i].ImortantIsStatus = 1;
              } else {
                this.draftList[i].ImortantIsStatus = 0;
              }
              this.draftList[i].Check4 = false;
            }

            swal({

              type: 'success',
              title: 'Emails add as spam successfully.',
              showConfirmButton: false,
              timer: 3000
            })
            this.globals.isLoading = false;
            this.InboxService.getAllDraft(this.globals.authData.UserId)
              .then((data) => {
                this.draftList = data['draft'];
              },
                (error) => {

                });
          },
            (error) => {
              this.globals.isLoading = false;
            });
      }
      else {
        swal({

          type: 'warning',
          title: 'Please select at least one email.',
          showConfirmButton: false,
          timer: 3000
        })
        this.globals.isLoading = false;

      }
    }
  }


  // ** add send to mark as multie delete **
  senddeleteMultiInbox() {
    debugger
    let pusheditems = [];
    var inbox_length = this.sendboxList.length;
    if (inbox_length > 0) {
      for (var i = 0; i < inbox_length; i++) {
        if (this.sendboxList[i].Check3) {
          pusheditems.push(this.sendboxList[i].EmailNotificationId)
        }
      }
      if (pusheditems.length > 0) {
        var updeletemultie = { 'Userid': this.globals.authData.UserId, 'MultiId': pusheditems };
        this.InboxService.deleteMultieEmails(updeletemultie)
          .then((data) => {
            let index = this.sendboxList.indexOf(pusheditems);
            for (var i = 0; i < inbox_length; i++) {
              if (this.sendboxList[i].Check3) {
                this.sendboxList[i].IsDelete = 1;
              } else {
                this.sendboxList[i].IsDelete = 0;
              }
              this.sendboxList[i].Check3 = false;
            }

            swal({

              type: 'success',
              title: 'Emails add as spam successfully.',
              showConfirmButton: false,
              timer: 3000
            })
            this.InboxService.getAllSentbox(this.globals.authData.UserId)
              .then((data) => {
                this.sendboxList = data['sendbox'];

              },
                (error) => {


                });
          },
            (error) => {
              this.globals.isLoading = false;
            });
      }
      else {
        swal({

          type: 'warning',
          title: 'Please select at least one email.',
          showConfirmButton: false,
          timer: 3000
        })
        this.globals.isLoading = false;

      }
    }


  }


  // ** add to mark as read **
  readInbox(Inboxres, temp) {
    debugger
    this.deleteEntity = Inboxres;
    var upread = { 'Userid': this.globals.authData.UserId, 'EmailNotificationId': Inboxres.EmailNotificationId, 'IsRead': Inboxres.IsRead };
    this.globals.isLoading = true;
    this.InboxService.readEmails(upread)
      .then((data) => {

        if (temp == 1) {
          let index = this.inboxList.indexOf(Inboxres);
          if (Inboxres.IsRead == 1) {
            this.inboxList[index].IsRead = 0;
          } else {
            this.inboxList[index].IsRead = 1;
          }
          this.InboxService.getAllData(this.globals.authData.UserId)
            .then((data) => {
              this.inboxcountList = data['inboxcount'];
            },
              (error) => {
                this.globals.isLoading = false;
              });
        }
        else if (temp == 2) {
          let index = this.sendboxList.indexOf(Inboxres);
          if (Inboxres.IsRead == 1) {
            this.sendboxList[index].IsRead = 0;
          } else {
            this.sendboxList[index].IsRead = 1;
          }
          this.InboxService.getAllData(this.globals.authData.UserId)
            .then((data) => {
              this.inboxcountList = data['inboxcount'];
            },
              (error) => {
                this.globals.isLoading = false;
              });

        }

        else if (temp == 3) {
          let index = this.addstarList.indexOf(Inboxres);
          if (Inboxres.IsRead == 1) {
            this.addstarList[index].IsRead = 0;
          } else {
            this.addstarList[index].IsRead = 1;
          }
          this.InboxService.getAllData(this.globals.authData.UserId)
            .then((data) => {
              this.inboxcountList = data['inboxcount'];
            },
              (error) => {
                this.globals.isLoading = false;
              });

        }
        else if (temp == 4) {
          let index = this.imortantList.indexOf(Inboxres);
          if (Inboxres.IsRead == 1) {
            this.imortantList[index].IsRead = 0;
          } else {
            this.imortantList[index].IsRead = 1;
          }
          this.InboxService.getAllData(this.globals.authData.UserId)
            .then((data) => {
              this.inboxcountList = data['inboxcount'];
            },
              (error) => {
                this.globals.isLoading = false;
              });
        }
        else if (temp == 5) {
          let index = this.draftList.indexOf(Inboxres);
          if (Inboxres.IsRead == 1) {
            this.draftList[index].IsRead = 0;
          } else {
            this.draftList[index].IsRead = 1;
          }

        }
        else if (temp == 6) {
          let index = this.spamList.indexOf(Inboxres);
          if (Inboxres.IsRead == 1) {
            this.spamList[index].IsRead = 0;
          } else {
            this.spamList[index].IsRead = 1;
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



  // ** add to mark as read only **
  readOnlyInbox(Inboxres) {
    debugger
    this.deleteEntity = Inboxres;
    var upread = { 'Userid': this.globals.authData.UserId, 'EmailNotificationId': Inboxres.EmailNotificationId };
    this.globals.isLoading = true;
    this.InboxService.readOnlyEmails(upread)
      .then((data) => {
        this.globals.isLoading = false;
      },
        (error) => {
          this.globals.isLoading = false;
        });

  }

  // ** add to mark as sttared **
  addstarInbox(Inboxres, temp) {
    debugger
    this.deleteEntity = Inboxres;
    var upstar = { 'Userid': this.globals.authData.UserId, 'EmailNotificationId': Inboxres.EmailNotificationId, 'IsStar': Inboxres.IsStar };
    this.globals.isLoading = true;
    this.InboxService.addstarInbox(upstar)
      .then((data) => {

        if (temp == 1) {
          let index = this.inboxList.indexOf(Inboxres);
          if (Inboxres.IsStar == 1) {
            this.inboxList[index].IsStar = 0;
          } else {
            this.inboxList[index].IsStar = 1;
          }
        }
        else if (temp == 2) {
          let index = this.sendboxList.indexOf(Inboxres);
          if (Inboxres.IsStar == 1) {
            this.sendboxList[index].IsStar = 0;
          } else {
            this.sendboxList[index].IsStar = 1;
          }

        }
        else if (temp == 3) {
          let index = this.addstarList.indexOf(Inboxres);
          if (Inboxres.IsStar == 1) {
            this.addstarList[index].IsStar = 0;
          } else {
            this.addstarList[index].IsStar = 1;
          }
          this.InboxService.getAllStarred(this.globals.authData.UserId)
            .then((data) => {
              this.addstarList = data['addstar'];
            },
              (error) => {

              });
        }
        else if (temp == 4) {
          let index = this.imortantList.indexOf(Inboxres);
          if (Inboxres.IsStar == 1) {
            this.imortantList[index].IsStar = 0;
          } else {
            this.imortantList[index].IsStar = 1;
          }

        }
        else if (temp == 5) {
          let index = this.draftList.indexOf(Inboxres);
          if (Inboxres.IsStar == 1) {
            this.draftList[index].IsStar = 0;
          } else {
            this.draftList[index].IsStar = 1;
          }

        }
        else if (temp == 6) {
          let index = this.spamList.indexOf(Inboxres);
          if (Inboxres.IsStar == 1) {
            this.spamList[index].IsStar = 0;
          } else {
            this.spamList[index].IsStar = 1;
          }

        }

        this.globals.isLoading = false;
      },
        (error) => {
          this.globals.isLoading = false;
        });

  }

  recoverMail(Inboxres, temp) {
    debugger
    this.deleteEntity = Inboxres;
    var upstar = { 'Userid': this.globals.authData.UserId, 'EmailNotificationId': Inboxres.EmailNotificationId, 'IsDelete': Inboxres.IsDelete };
    this.globals.isLoading = true;
    this.InboxService.recoverMail(upstar)
      .then((data) => {
        if (temp == 6) {
          let index = this.spamList.indexOf(Inboxres);
          this.spamList.splice(index, 1);
        }

        this.globals.isLoading = false;
      },
        (error) => {
          this.globals.isLoading = false;
        });

  }
  // ** add to mark as delete **
  deleteInbox(Inboxres, temp) {
    debugger
    this.deleteEntity = Inboxres;
    var upimpo = { 'Userid': this.globals.authData.UserId, 'EmailNotificationId': Inboxres.EmailNotificationId, 'IsDelete': Inboxres.IsDelete };
    this.globals.isLoading = true;
    this.InboxService.deleteInbox(upimpo)
      .then((data) => {

        if (temp == 1) {
          let index = this.inboxList.indexOf(Inboxres);
          this.inboxList.splice(index, 1);
          // if (Inboxres.IsDelete == 1) {
          //   this.inboxList[index].IsDelete = 0;
          // } else {
          //   this.inboxList[index].IsDelete = 1;
          // }
        }
        else if (temp == 2) {
          let index = this.sendboxList.indexOf(Inboxres);
          this.sendboxList.splice(index, 1);
          // if (Inboxres.IsDelete == 1) {
          //   this.sendboxList[index].IsDelete = 0;
          // } else {
          //   this.sendboxList[index].IsDelete = 1;
          // }
        }
        else if (temp == 3) {
          let index = this.addstarList.indexOf(Inboxres);
          this.addstarList.splice(index, 1);
          // if (Inboxres.IsDelete == 1) {
          //   this.addstarList[index].IsDelete = 0;
          // } else {
          //   this.addstarList[index].IsDelete = 1;
          // }
        }
        else if (temp == 5) {
          let index = this.draftList.indexOf(Inboxres);
          this.draftList.splice(index, 1);
          // if (Inboxres.IsDelete == 1) {
          //   this.draftList[index].IsDelete = 0;
          // } else {
          //   this.draftList[index].IsDelete = 1;
          // }
        }
        else if (temp == 4) {
          let index = this.imortantList.indexOf(Inboxres);
          this.imortantList.splice(index, 1);
          // if (Inboxres.IsDelete == 1) {
          //   this.imortantList[index].IsDelete = 0;
          // } else {
          //   this.imortantList[index].IsDelete = 1;
          // }
        }
        this.globals.isLoading = false;
        this.InboxService.getAllSpam(this.globals.authData.UserId)
          .then((data) => {
            this.spamList = data['spam'];
          },
            (error) => {
              //alert('error');
            });
        this.InboxService.getAllData(this.globals.authData.UserId)
          .then((data) => {
            this.draftcountList = data['draftcount'];
            this.inboxcountList = data['inboxcount'];
          },
            (error) => {
              this.btn_disable = false;
              this.submitted = false;
              this.globals.isLoading = false;
            });
      },
        (error) => {
          this.globals.isLoading = false;
        });

  }

}
