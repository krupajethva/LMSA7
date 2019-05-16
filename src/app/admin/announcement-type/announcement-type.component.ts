import { Component, OnInit, ElementRef } from '@angular/core';
import { Globals } from '.././globals';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { AnnouncementService } from '../services/announcement.service';
declare function myInput() : any;
declare var $,swal: any;
@Component({
  selector: 'app-announcement-type',
  templateUrl: './announcement-type.component.html',
  styleUrls: ['./announcement-type.component.css']
})
export class AnnouncementTypeComponent implements OnInit {
  announcementtypeEntity;
  submitted;
  btn_disable;
  header;
  color_IsStatus = false;

  constructor( public globals: Globals, private router: Router,private elem: ElementRef, private route: ActivatedRoute,
    private AnnouncementService: AnnouncementService) { }
    
  ngOnInit() {
    setTimeout(function(){
      if( $(".bg_white_block").hasClass( "ps--active-y" )){  
				$('footer').removeClass('footer_fixed');     
			}      
			else{  
				$('footer').addClass('footer_fixed');    
      }
      $('#demo').colorpicker();
      myInput();
    },100); 
    this.default();
  }
  default(){
    debugger
    this.announcementtypeEntity = {};
    let id = this.route.snapshot.paramMap.get('id');
    this.globals.msgflag = false;
    if(id){
      this.header = 'Edit';
      this.AnnouncementService.getAnnounceTypeById(id)
      .then((data) => 
      { 
        if(data!=""){
          this.announcementtypeEntity = data;
        } else {
          this.router.navigate(['/pagenotfound']);
        }	
        this.globals.isLoading = false;		
        setTimeout(function(){
					myInput();
			  },100); 
      }, 
      (error) => 
      {
        this.globals.isLoading = false;
        this.router.navigate(['/pagenotfound']);
      });	 
    } else {
      this.header = 'Add';
      this.announcementtypeEntity = {};
      this.announcementtypeEntity.AnnouncementTypeId = 0;
      this.announcementtypeEntity.IsActive = '1';
      this.globals.isLoading = false;
      myInput();	
    }	
  }
  addAnnouncementType(announcementtypeForm){ debugger
    //this.submitted = true;
    let id = this.route.snapshot.paramMap.get('id');
		if(id){
			this.submitted = false;
		} else {			
			this.announcementtypeEntity.CreatedBy = this.globals.authData.UserId;
			this.submitted = true;
    }
    this.announcementtypeEntity.UpdatedBy = this.globals.authData.UserId;
    this.announcementtypeEntity.UserId = this.globals.authData.UserId;
    this.announcementtypeEntity.ColorCode = $('#demo').val();
    if(this.announcementtypeEntity.ColorCode!=null && this.announcementtypeEntity.ColorCode!='undefined' && this.announcementtypeEntity.ColorCode!=''){
      this.color_IsStatus = false;
    }
    else{
      this.color_IsStatus = true;
    }
    
    if(announcementtypeForm.valid && this.color_IsStatus==false){
      this.announcementtypeEntity.ColorCode = $('#demo').val();
      this.AnnouncementService.addAnnouncementType(this.announcementtypeEntity)
			.then((data) => 
			{
				this.btn_disable = false;
				this.submitted = false;
				this.announcementtypeEntity = {};
        announcementtypeForm.form.markAsPristine();
        if(id){
          swal({
		
            type: 'success',
            title: 'Updated!',
						text: 'Announcement Type updated successfully.',
						showConfirmButton: false,
						timer: 1500
					})
				} else {
          swal({
		
            type: 'success',
            title: 'Added!',
						text: 'Announcement Type added successfully.',
						showConfirmButton: false,
						timer: 1500
					  })
				}	
        this.router.navigate(['/announcementtypelist']);
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
