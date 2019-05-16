import { Component, OnInit, ElementRef } from '@angular/core';
import { Globals } from '.././globals';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { AnnouncementService } from '../services/announcement.service';
declare function myInput() : any;
declare var $,swal: any;
@Component({
  selector: 'app-announcement',
  templateUrl: './announcement.component.html',
  styleUrls: ['./announcement.component.css']
})
export class AnnouncementComponent implements OnInit {
  announcementEntity;
  submitted;
  btn_disable;
  typelist;
  audiencelist;
  header;

  constructor( public globals: Globals, private router: Router,private elem: ElementRef, private route: ActivatedRoute,
		private AnnouncementService: AnnouncementService) { }

  ngOnInit() {
    //this.globals.isLoading = true;	
    setTimeout(function(){
      // if( $(".bg_white_block").hasClass( "ps--active-y" )){  
			// 	$('footer').removeClass('footer_fixed');     
			// }      
			// else{  
			// 	$('footer').addClass('footer_fixed');    
      // }
      myInput();
    },100); 
    this.default();
  }
  default(){
    this.announcementEntity = {};
    let id = this.route.snapshot.paramMap.get('id');
    //this.globals.msgflag = true;
    this.globals.isLoading = true;
    this.AnnouncementService.getAnnouncementTypes()
			.then((data) => {
				this.typelist = data;
				this.globals.isLoading = false;
			},
			(error) => {
       this.globals.isLoading = false;	
        this.router.navigate(['/pagenotfound']);
      });
      this.AnnouncementService.getAnnouncementAudience()
			.then((data) => {
				this.audiencelist = data;
			this.globals.isLoading = false;
			},
			(error) => {
       this.globals.isLoading = false;	
        this.router.navigate(['/pagenotfound']);
      });
      
    if(id){
      this.header = 'Edit';
      this.AnnouncementService.getAnnouncementById(id)
      .then((data) => 
      { 
        if(data!=""){
          this.announcementEntity = data;
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
      this.announcementEntity = {};
      this.announcementEntity.AnnouncementId = 0;
      this.announcementEntity.IsActive = '1';
      this.globals.isLoading = false;
      myInput();	
    }	
  }
  addAnnouncement(announcementForm){
    //this.submitted = true;
    let id = this.route.snapshot.paramMap.get('id');
		if(id){
			this.submitted = false;
		} else {			
			this.announcementEntity.CreatedBy = this.globals.authData.UserId;
			this.submitted = true;
    }
    this.announcementEntity.UpdatedBy = this.globals.authData.UserId;
    this.announcementEntity.UserId = this.globals.authData.UserId;
    if(announcementForm.valid){
      this.AnnouncementService.addAnnouncement(this.announcementEntity)
			.then((data) => 
			{
				this.btn_disable = false;
				this.submitted = false;
				this.announcementEntity = {};
        announcementForm.form.markAsPristine();
        if(id){
          swal({
	
            type: 'success',
            title: 'Updated!',
						text: 'Announcement has been updated successfully',
						showConfirmButton: false,
						timer: 1500
					})
				} else {
          swal({

            type: 'success',
            title: 'Added!',
						text: 'Announcement has been added successfully',
						showConfirmButton: false,
						timer: 1500
					  })
				}	
        this.router.navigate(['/announcementlist']);
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
