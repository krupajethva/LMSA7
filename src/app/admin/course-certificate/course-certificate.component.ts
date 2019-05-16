import { Component, OnInit, ElementRef } from '@angular/core';
import { Globals } from '.././globals';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';

import { CourseCertificateService } from '../services/course-certificate.service';
declare var $, swal: any;
declare function myInput(): any;
declare var $, Bloodhound: any;
declare var CKEDITOR: any, swal: any;
@Component({
  selector: 'app-course-certificate',
  templateUrl: './course-certificate.component.html',
  styleUrls: ['./course-certificate.component.css']
})
export class CourseCertificateComponent implements OnInit {

  constructor( public globals: Globals, private router: Router, private elem: ElementRef, private route: ActivatedRoute,private CourseCertificateService: CourseCertificateService) { }

  CertificateEntity;
  btn_disable;
  des_valid;
	submitted;

  ngOnInit() { 
		this.CertificateEntity={};					
	
debugger
 	
			this.CourseCertificateService.getByIdCourseCertificat('1')
				.then((data) => {
            this.CertificateEntity=data;
				
				
				},
					(error) => {
						//alert('error');
						//this.globals.isLoading = false;
						this.router.navigate(['/pagenotfound']);
					});
    setTimeout(function () {
      $('.modal').on('shown.bs.modal', function () {
        $('.right_content_block').addClass('style_position');
      })
      $('.modal').on('hidden.bs.modal', function () {
        $('.right_content_block').removeClass('style_position');
      });
      CKEDITOR.replace('CertificateW', {
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
			CKEDITOR.on('instanceReady', function () {
				CKEDITOR.document.getById('contactList').on('dragstart', function (evt) {
					var target = evt.data.getTarget().getAscendant('div', true);
					CKEDITOR.plugins.clipboard.initDragDataTransfer(evt);
					var dataTransfer = evt.data.dataTransfer;
					dataTransfer.setData('text/html', '{' + target.getText() + '}');
				});
			});
    }, 500);
  }	

 
}
