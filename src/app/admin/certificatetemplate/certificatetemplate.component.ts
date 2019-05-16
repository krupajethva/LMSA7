import { Component, OnInit } from '@angular/core';
import { Globals } from '.././globals';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { CertificatetemplateService } from '../services/certificatetemplate.service';
declare var $, swal: any;
declare function myInput(): any;
declare var $, Bloodhound: any;
declare var CKEDITOR: any, swal: any;

@Component({
  selector: 'app-certificatetemplate',
  templateUrl: './certificatetemplate.component.html',
  styleUrls: ['./certificatetemplate.component.css']
})
export class CertificatetemplateComponent implements OnInit {

  CertificateEntity;
  submitted;
  btn_disable;
  header;
  des_valid;
  placeholderList;
  abcform;
  roleList;

  constructor( public globals: Globals, private router: Router, private route: ActivatedRoute,
    private CertificatetemplateService: CertificatetemplateService) { }

  ngOnInit() {

   


    this.globals.msgflag = false;
    this.des_valid = false;
    this.CertificateEntity = {};
    this.CertificateEntity.CertificateId = 0;
    this.CertificateEntity.IsActive = 1;

    CKEDITOR.replace('CertificateTemplate', {
      height: '300',
      resize_enabled: 'false',
      resize_maxHeight: '300',
      resize_maxWidth: '948',
      resize_minHeight: '300',
      resize_minWidth: '948',
      //extraAllowedContent: 'style;*[id,rel](*){*}'
      extraAllowedContent: 'span;ul;li;table;td;style;*[id];*(*);*{*}',
      enterMode: Number(2)
    });

    // setTimeout(function () {
    //   if ($(".bg_white_block").hasClass("ps--active-y")) {
    //     $('footer').removeClass('footer_fixed');
    //   }
    //   else {
    //     $('footer').addClass('footer_fixed');
    //   }
    // }, 100);
    var skills = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      prefetch: {
        url: '../assets/skills.json'
      }
    });
    skills.initialize();

    var elt = $('#skills');

    elt.tagsinput({
      typeaheadjs: {
        name: 'skills',
        displayKey: 'name',
        valueKey: 'name',
        source: skills.ttAdapter()
      }
    });
    let id = this.route.snapshot.paramMap.get('id');
    this.CertificatetemplateService.getDefaultList()
      .then((data) => {
        this.roleList = data['role'];
        this.placeholderList = data['placeholder'];
        //this.globals.isLoading = false;
      },
        (error) => {
          //alert('error');
          //this.globals.isLoading = false;
          this.router.navigate(['/pagenotfound']);
        });
    if (id) {
      this.header = 'Edit';
      this.CertificatetemplateService.getById(id)
        .then((data) => {
          if (data != "") {
            this.CertificateEntity = data;
            if (data['IsActive'] == 0) {
              this.CertificateEntity.IsActive = 0;
            } else {
              this.CertificateEntity.IsActive = '1';
            }
            setTimeout(function () {
              myInput();
            }, 100);
            CKEDITOR.instances.EmailBody.setData(this.CertificateEntity.EmailBody);
          } else {
            this.router.navigate(['/dashboard']);
          }
        },
          (error) => {
            //alert('error');
            this.btn_disable = false;
            this.submitted = false;
            this.router.navigate(['/pagenotfound']);
          });

    }
    else {
      this.header = 'Add';
      this.CertificateEntity = {};
      this.CertificateEntity.CertificateId = 0;
      this.CertificateEntity.IsActive = '1';
      setTimeout(function () {
        myInput();
      }, 100);
    }
    CKEDITOR.on('instanceReady', function () {
      CKEDITOR.document.getById('contactList').on('dragstart', function (evt) {
        var target = evt.data.getTarget().getAscendant('div', true);
        CKEDITOR.plugins.clipboard.initDragDataTransfer(evt);
        var dataTransfer = evt.data.dataTransfer;
        dataTransfer.setData('text/html', '{' + target.getText() + '}');
      });
    });
    setTimeout(function () {
      $(".CertificateTemplate").addClass("selected");
      $(".certificate").addClass("active");
      $(".CertificateTemplate").parent().removeClass("display_block");
    }, 500);
  }

  addCertificate(CertificateForm) {
    debugger
    this.CertificateEntity.CertificateTemplate = CKEDITOR.instances.CertificateTemplate.getData();
    if (this.CertificateEntity.CertificateTemplate != "") {
      this.des_valid = false;
    } else {
      this.des_valid = true;
    }
    let id = this.route.snapshot.paramMap.get('id');
    if (id) {
      this.CertificateEntity.UpdatedBy = 1;
      this.submitted = false;
    } else {
      this.CertificateEntity.CreatedBy = 1;
      this.CertificateEntity.UpdatedBy = 1;
      this.submitted = true;
    }
    if (id) {
      this.submitted = false;
    } else {
      this.CertificateEntity.CertificateId = 0;
      this.submitted = true;
    }
    if (CertificateForm.valid && this.des_valid == false) {
      this.btn_disable = true;
      this.CertificateEntity.check = 0;
      this.CertificatetemplateService.add(this.CertificateEntity)
        .then((data) => {
          if (data == 'sure') {
            //	this.btn_disable = false;
            //	this.submitted = false;
            this.abcform = CertificateForm;
            $('#Sure_Modal').modal('show');
          } else {
            //	this.btn_disable = false;
            //	this.submitted = false;

            this.btn_disable = false;
            this.submitted = false;
            this.CertificateEntity = {};
            CertificateForm.form.markAsPristine();
            if (id) {

              swal({
                type: 'success',
                title: 'Updated!',
                text: 'Certificate Updated Successfully!',
                showConfirmButton: false,
                timer: 1500
              })
            } else {
              swal({
               
                type: 'success',
                title: 'Added!',
                text: 'Certificate has been Added Successfully!',
                showConfirmButton: false,
                timer: 1500
              })
            }
            this.router.navigate(['/certificatetemplatelist']);
          }
        },
          (error) => {

            this.btn_disable = false;
            this.submitted = false;

          });

    }
  }

  clearForm(CertificateForm) {
    debugger
    this.CertificateEntity = {};
    this.submitted = false;
    this.CertificateEntity.CertificateId = 0;
    this.CertificateEntity.IsActive = '1';
    this.des_valid = false;
    CKEDITOR.instances.CertificateTemplate.setData('');
    CertificateForm.form.markAsPristine();
  }

  addConfirm(abcform) {

    this.CertificateEntity.check = 1;
    let id = this.route.snapshot.paramMap.get('id');
    this.CertificatetemplateService.add(this.CertificateEntity)
      .then((data) => {
        $('#Sure_Modal').modal('hide');
        //	this.btn_disable = false;
        //	this.submitted = false;
        this.CertificateEntity = {};
        abcform.form.markAsPristine();
        if (id) {
          this.globals.message = 'Email Template Updated Successfully!';
          this.globals.type = 'success';
          this.globals.msgflag = true;
        } else {
          this.globals.message = 'Email Template Added Successfully!';
          this.globals.type = 'success';
          this.globals.msgflag = true;
        }
        this.router.navigate(['/emailtemplate/list']);

      },
        (error) => {
          //alert('error');
          //this.btn_disable = false;
          //	this.submitted = false;
          //this.globals.isLoading = false;
          //	this.router.navigate(['/pagenotfound']);
        });
  }
}
