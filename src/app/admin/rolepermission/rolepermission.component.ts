import { Component, OnInit, ElementRef } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { RolepermissionService } from '../services/rolepermission.service';
import { Globals } from '.././globals';
import { CommonService } from '../services/common.service';
declare var $,swal: any;
declare function myInput(): any;

@Component({
  selector: 'app-rolepermission',
  templateUrl: './rolepermission.component.html',
  styleUrls: ['./rolepermission.component.css']
})
export class RolepermissionComponent implements OnInit {

  roleEntity;
  roleList;
  permissionList;
  btn_disable;
  permissionEntity

  constructor(private el: ElementRef,  private router: Router, private route: ActivatedRoute, private RolepermissionService: RolepermissionService, public globals: Globals, private CommonService:CommonService)
    {		
    }
    
  ngOnInit() {debugger
  
    this.globals.pageTitle = '- Role Permission';
    this.permissionList = [];
    $("footer").addClass("footer_admin");
    if ( $('#container').hasClass( "active_ulmainscreen" ) ) { 
      $('.col-md-10.col-sm-12.col-md-offset-2').addClass("active_divmainscreen");
    } else {
    $('.col-md-10.col-sm-12.col-md-offset-2').removeClass("active_divmainscreen");
    }
    this.globals.isLoading = true;
    this.permissionEntity = {};
    this.roleEntity = {};

    // this.permissionEntity.View=1;
    // this.permissionEntity.AddEdit=1;
    // this.permissionEntity.Delete=1;	
    // this.default();
debugger
    if(this.globals.authData.RoleId==5){	
      this.permissionEntity.View=1;
      this.permissionEntity.AddEdit=1;
      this.permissionEntity.Delete=1;	
      this.default();
    } else if(this.globals.authData.RoleId==1 || this.globals.authData.RoleId==2) {
      this.CommonService.get_permissiondata({'RoleId':this.globals.authData.RoleId,'screen':'Role Permissions'})
      .then((data) => 
      {
        this.permissionEntity = data;
        if(this.permissionEntity.View==1 ||  this.permissionEntity.AddEdit==1){
          this.default();
        } else {
          this.router.navigate(['/pagenotfound']);
        }	
      },
      (error) => 
      {
        this.globals.isLoading = false;
        this.router.navigate(['/pagenotfound']);
      });	
    } else {
      this.globals.isLoading = false;
      this.router.navigate(['/pagenotfound']);
    }      
  }

  default(){	
    if(this.globals.authData.RoleId==5){
      this.roleEntity.RoleId = 1;
    } else if(this.globals.authData.RoleId==1) {
      this.roleEntity.RoleId = 2;
    } else if(this.globals.authData.RoleId==2) {
      this.roleEntity.RoleId = 3;
    }

    this.RolepermissionService.getDefault(this.globals.authData.RoleId) 
    .then((data) => 
    { 
      this.roleList = data['role'];
      if(data){
      this.permissionList = data['permission'];
      }
      this.globals.isLoading = false;
      setTimeout(function(){
        // var table = $('#list_tables').DataTable( {
        //   scrollY: '55vh',
		 //responsive: {
         //   details: {
           //     display: $.fn.dataTable.Responsive.display.childRowImmediate,
             //   type: ''
           // }
        //},
        //      scrollCollapse: true,           
        //        "oLanguage": {
        //          "sLengthMenu": "_MENU_ Permissions per Page",
        //          "sInfo": "Showing _START_ to _END_ of _TOTAL_ Permissions",
        //          "sInfoFiltered": "(filtered from _MAX_ total Permissions)",
        //          "sInfoEmpty": "Showing 0 to 0 of 0 Permissions"
        //        },
        //        dom: 'lBfrtip',
        //        buttons: [
                     
        //            ]
        //      });
             
        //      var buttons = new $.fn.dataTable.Buttons(table, {
        //      buttons: [
        //                  {
        //                  extend: 'excel',
        //                  title: 'RolePermission List',
        //                  exportOptions: {
        //                    columns: [ 0, 1, 2, 3 ]
        //                    }
        //                  },
        //                  {
        //                  extend: 'print',
        //                  title: 'RolePermission List',
        //                  exportOptions: {
        //                    columns: [ 0, 1, 2, 3 ]
        //                    }
        //                  },
        //              ]
        //    }).container().appendTo($('#buttons'));
           myInput();
      },100); 
    }, 
    (error) => 
    {
      this.globals.isLoading = false;
      this.router.navigate(['/pagenotfound']);
    });	
    setTimeout(function(){
      $(".test").removeClass("active");
      $(".rolepermission").addClass("active");
      if ($("body").height() < $(window).height()) {  
				$('footer').addClass('footer_fixed');     
			}      
			else{  
				$('footer').removeClass('footer_fixed');    
			}
		},500);
  } 

  getRolePermission(){ 
    this.RolepermissionService.getRolePermission(this.roleEntity.RoleId)
    .then((data) => 
    { 
      this.permissionList = data;
    }, 
    (error) => 
    {
      this.globals.isLoading = false;
      this.router.navigate(['/pagenotfound']);
    });	 
  }

  updatePermission()
	{	
    this.btn_disable = true;
    this.RolepermissionService.update_permission(this.permissionList)
    .then((data) => 
    {
      this.btn_disable = false;
      swal({
       
        type: 'success',
        title: 'Updated!',
        text: 'Role Permission has been updated successfully',
        showConfirmButton: false,
        timer: 1500
      })
      
    }, 
    (error) => 
    {
      this.btn_disable = false;
      this.globals.isLoading = false;
      this.router.navigate(['/pagenotfound']);
    });
	}

}
