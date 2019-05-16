
import { Component, OnInit } from '@angular/core';
import { Globals } from '.././globals';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { CertificateBadgeService } from '../services/certificate-badge.service';
declare var $,swal: any;
declare function myInput() : any;
declare var $,Bloodhound: any;
@Component({
  selector: 'app-certificate-badgeslist',
  templateUrl: './certificate-badgeslist.component.html',
  styleUrls: ['./certificate-badgeslist.component.css']
})
export class CertificateBadgeslistComponent implements OnInit {
  badgesList;
  deleteEntity;
	msgflag;
	message;
	type;
	permissionEntity;
	
  constructor( public globals: Globals, private router: Router, private route: ActivatedRoute,
		private CertificateBadgeService: CertificateBadgeService) { }

  ngOnInit() {
       this.CertificateBadgeService.getAllBadges()
       .then((data) => 
       { 

        let todaysdate = this.globals.todaysdate;
         setTimeout(function(){
           var table = $('#list_tables').DataTable( {
            // scrollY: '55vh',
         responsive: {
               details: {
                   display: $.fn.dataTable.Responsive.display.childRowImmediate,
                   type: ''
               }
           },
                scrollCollapse: true,           
                  "oLanguage": {
                    "sLengthMenu": "_MENU_ Badges per page",
                    "sInfo": "Showing _START_ to _END_ of _TOTAL_ Badges",
                    "sInfoFiltered": "(filtered from _MAX_ total Badges)",
                    "sInfoEmpty": "Showing 0 to 0 of 0 Categories"
                  },
                  dom: 'lBfrtip',
                  buttons: [
                    {
                      extend: 'excel',
                      title: 'Learning Management System – Badges List – ' + todaysdate,
                      filename: 'LearningManagementSystem–BadgesList–' + todaysdate,
                      customize: function (xlsx) {
                        var source = xlsx.xl['workbook.xml'].getElementsByTagName('sheet')[0];
                        source.setAttribute('name', 'LMS-BadgesList');
                      },
                      exportOptions: {
                        columns: [0, 1, 2, 3]
                      }
                    },
                    {
                      extend: 'print',
                      title: 'Learning Management System –  Badges List – ' + todaysdate,
                      exportOptions: {
                        columns: [0, 1, 2, 3]
                      }
                    },
                  ]
                });
                
                var buttons = new $.fn.dataTable.Buttons(table, {
                // buttons: [
                //             {
                //             extend: 'excel',
                //             title: 'Category List',
                //             exportOptions: {
                //               columns: [ 0, 1, 2, 3 ]
                //               }
                //             },
                //             {
                //             extend: 'print',
                //             title: 'Category List',
                //             exportOptions: {
                //               columns: [ 0, 1, 2, 3 ]
                //               }
                //             },
                //         ]
              }).container().appendTo($('#buttons'));
			  
			   $('.buttons-excel').attr('data-original-title', 'Export').tooltip();
       $('.buttons-print').attr('data-original-title', 'Print').tooltip();
	   
	   
         },100); 
         this.badgesList = data;	
         //this.globals.isLoading = false;	
       }, 
       (error) => 
       {
        // this.globals.isLoading = false;
         this.router.navigate(['/pagenotfound']);
       });
       this.msgflag = false;

       setTimeout(function(){
        if( $(".bg_white_block").hasClass( "ps--active-y" )){  
          $('footer').removeClass('footer_fixed');     
        }      
        else{  
          $('footer').addClass('footer_fixed');    
        }
      },100);
      setTimeout(function(){
        $(".categories").addClass("active");
        $(".categories > div").addClass("in");
        $(".categories > a").removeClass("collapsed");
      	$(".categories > a").attr("aria-expanded","true");
      },300);
  }
  deleteCategory(badges)
	{ debugger
		this.deleteEntity =  badges;
		swal({
			title: 'Delete a Badge?',
			text: "Are you sure you want to delete this Badge?",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes'
    })
		.then((result) => {
			if (result.value) {
		var del={'UpdatedBy':this.globals.authData.UserId,'id':badges.ResourcesId};
		this.CertificateBadgeService.deleteBadge(del)
		.then((data) => 
		{
			let index = this.badgesList.indexOf(badges);
	
			if (index != -1) {
				this.badgesList.splice(index, 1);
			}	
			swal({
        type: 'success',
        title: 'Deleted!',
				text: 'Badge has been deleted successfully',
				showConfirmButton: false,
				timer: 1500
			})
		}, 
		(error) => 
		{
		
			if(error.text){
				swal({

          type: 'error',
          title:'Oops...',
					text: "You can't delete this record because of their dependency!",
					showConfirmButton: false,
					timer: 1500
				})
			}	
		});	
	}
	})
						
	}

  isActiveChange(changeEntity, i)
  { 
    if(this.badgesList[i].IsActive==1){
      this.badgesList[i].IsActive = 0;
      changeEntity.IsActive = 0;
    } else {
      this.badgesList[i].IsActive = 1;
      changeEntity.IsActive = 1;
    }
   // this.globals.isLoading = true;
    changeEntity.UpdatedBy = 1;
    
		this.CertificateBadgeService.isActiveChange(changeEntity)
		.then((data) => 
		{	      
     // this.globals.isLoading = false;	
     swal({
      type: 'success',
      title: 'Updated!',
      text: 'Badge has been updated successfully',
      showConfirmButton: false,
      timer: 1500
    })
			
		}, 
		(error) => 
		{
     // this.globals.isLoading = false;
      this.router.navigate(['/pagenotfound']);
		});		
	}
  }


