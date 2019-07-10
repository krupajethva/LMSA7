
import { Component, OnInit,ElementRef } from '@angular/core';
import { Globals } from '.././globals';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { CertificateBadgeService } from '../services/certificate-badge.service';
declare var $,swal: any;
declare function myInput() : any;

@Component({
  selector: 'app-certificate-badge',
  templateUrl: './certificate-badge.component.html',
  styleUrls: ['./certificate-badge.component.css']
})
export class CertificateBadgeComponent implements OnInit {
  ParentList;
badgesEntity;
	submitted;
	btn_disable;
  header;
  submitbutton;
  ImageValid;
  constructor( public globals: Globals, private router: Router, private elem: ElementRef, private route: ActivatedRoute,
		private CertificateBadgeService: CertificateBadgeService) { }

    ngOnInit() {
		
      this.badgesEntity = {};
      this.badgesEntity.ResourcesId = 0;
      this.badgesEntity.IsActive=1;
      setTimeout(function(){
        if( $(".bg_white_block").hasClass( "ps--active-y" )){  
          $('footer').removeClass('footer_fixed');     
        }      
        else{  
          $('footer').addClass('footer_fixed');    
        } 
        $('#BadgeImage').change(function (e) {
        
          
          var file = e.target.files[0];
          var reader = new FileReader();
          reader.onloadend = function () 
          {
          
          $(".link").attr("href", reader.result);
            $(".link").text(reader.result);
  
          }
          reader.readAsDataURL(file);
          });
      },100);
		
    let id = this.route.snapshot.paramMap.get('id');
    if (id) {
      this.header = 'Edit';
      this.submitbutton= 'Update';
      this.CertificateBadgeService.badgegetById(id)
        .then((data) => {
          this.badgesEntity = data;
        //  $('#UserImageIdIcon input[type="file"]').val(this.badgesEntity.BadgeImage);
          if(data['IsActive']==0){
            this.badgesEntity.IsActive = 0;
          } else {
            this.badgesEntity.IsActive = '1';
          }
          setTimeout(function(){
            myInput();
             },100);
        
        },
        (error) => {
          //alert('error');
          this.btn_disable = false;
          this.submitted = false;
        });
    }
    else {
      this.header = 'Add';
      this.submitbutton= 'Add';
      this.badgesEntity = {};
      this.badgesEntity.ResourcesId = 0;
      this.badgesEntity.IsActive = '1';
      myInput();
    }
    }
    replaceBadges() {

      var input = this.elem.nativeElement.querySelector('#BadgeImage');
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        var filename = $("#BadgeImage").val();
        this.badgesEntity.BadgeImage = Date.now() + '_' + filename;
        filename = filename.substring(filename.lastIndexOf('\\') + 1);
        reader.onload = (e: Event) => {
          $('#BadgeImagePreview').attr('src', e.target["result"]);
          $('#BadgeImagePreview').hide();
          $('#BadgeImagePreview').fadeIn(500);
          $('.custom-file-label').text(filename);
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
    addBadges(BadgesForm) 
    {	debugger
      	var count=0;
      this.badgesEntity.Dataurl=$('.link').attr('href');
      let file2 = this.elem.nativeElement.querySelector('#BadgeImage').files[0];
		var fd = new FormData();
		if (file2) {
			var BadgeImage = Date.now() + '_' + file2['name'];
			fd.append('BadgeImage', file2, BadgeImage);
			this.badgesEntity.BadgeImage = BadgeImage;
		}
		else {
			fd.append('BadgeImage', null);
			this.badgesEntity.BadgeImage = null;
		}
        let id = this.route.snapshot.paramMap.get('id');
        if (id) {
        this.badgesEntity.UpdatedBy = this.globals.authData.UserId;
        this.submitted = false;
      } else {
        this.badgesEntity.CreatedBy = this.globals.authData.UserId;
        this.badgesEntity.ResourcesId = 0;
        this.submitted = true;
      }
      if (this.badgesEntity.BadgeImage == "" || this.badgesEntity.BadgeImage == null || this.badgesEntity.BadgeImage == undefined) {
        this.ImageValid = true;
        count = 1;
      } else {
        this.ImageValid = false;
      }
        if(BadgesForm.valid && count == 0){
          this.btn_disable = true;
          this.CertificateBadgeService.add(this.badgesEntity)
          .then((data) => 
          {
            if (file2) {
              this.CertificateBadgeService.uploadFile(fd, this.globals.authData.UserId)
                .then((data) => {
                  this.globals.isLoading = false;
                  this.btn_disable = true;
                  this.submitted = false;                
                }, (error) => {
                  this.btn_disable = false;
                  this.submitted = false;
                  this.globals.isLoading = false;
                  this.router.navigate(['/pagenotfound']);
                });
              }
           BadgesForm.form.markAsPristine();
            if (id) {
          
            swal({
              type: 'success',
              title: 'Updated!',
              text: 'Badge has been updated successfully',
              showConfirmButton: false,
              timer: 1500
            })
          } else {
            swal({
              type: 'success',
              title: 'Added!',
              text: 'Badge has been added successfully',
              showConfirmButton: true
          
            })
          } 
            this.router.navigate(['/default-badgelist']);
          }, 
          (error) => 
          {
 
            this.btn_disable = false;
            this.submitted = false;

          });	
        
        }
      }
    clearForm(BadgesForm) {debugger
      BadgesForm.form.markAsPristine();
      this.badgesEntity = {};
      //BadgesForm.form.markAsPristine();
      this.submitted = false;
      this.badgesEntity.IsActive = '1';   
      this.badgesEntity.ResourcesId = 0;
    }
  
  }
 