import { Component, OnInit, ElementRef } from '@angular/core';
import { Globals } from '.././globals';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { AnnouncementService } from '../services/announcement.service';
import { ActivedeleteService } from '../services/activedelete.service';
declare function myInput(): any;
declare var $, swal: any;

@Component({
  selector: 'app-announcementlist',
  templateUrl: './announcementlist.component.html',
  styleUrls: ['./announcementlist.component.css']
})
export class AnnouncementlistComponent implements OnInit {

  announcementEntity;
  submitted;
  btn_disable;
  announcementlist;
  deleteEntity;
  header;

  constructor( public globals: Globals, private router: Router, private elem: ElementRef, private route: ActivatedRoute,
    private AnnouncementService: AnnouncementService, private ActivedeleteService: ActivedeleteService) { }

  ngOnInit() {
    setTimeout(function () {
      // if( $(".bg_white_block").hasClass( "ps--active-y" )){  
      // 	$('footer').removeClass('footer_fixed');     
      // }      
      // else{  
      // 	$('footer').addClass('footer_fixed');    
      // }
      myInput();
    }, 100);
    this.default();
  }
  default() {
    this.announcementEntity = {};
    this.AnnouncementService.getAnnouncements(this.globals.authData.UserId)
      .then((data) => {

        let todaysdate = this.globals.todaysdate;
        setTimeout(function () {
          var table = $('#list_tables').DataTable({
            // scrollY: '55vh',
            responsive: {
              details: {
                display: $.fn.dataTable.Responsive.display.childRowImmediate,
                type: ''
              }
            },
            scrollCollapse: true,
            "oLanguage": {
              "sLengthMenu": "_MENU_ Announcement per Page",
              "sInfo": "Showing _START_ to _END_ of _TOTAL_ Announcement",
              "sInfoFiltered": "(filtered from _MAX_ total Announcement)",
              "sInfoEmpty": "Showing 0 to 0 of 0 Announcement"
            },
            dom: 'lBfrtip',
            buttons: [

            ]
          });

          var buttons = new $.fn.dataTable.Buttons(table, {
            buttons: [
              {
                extend: 'excel',
                title: 'Learning Management System – Announcement List – ' + todaysdate,
                filename: 'LearningManagementSystem–AnnouncementList–' + todaysdate,
                customize: function (xlsx) {
                  var source = xlsx.xl['workbook.xml'].getElementsByTagName('sheet')[0];
                  source.setAttribute('name', 'LMS-AnnouncementList');
                },
                exportOptions: {
                  columns: [0, 1, 2]
                }
              },
              {
                extend: 'print',
                title: 'Learning Management System –  Announcement List – ' + todaysdate,
                exportOptions: {
                  columns: [0, 1, 2]
                }
              },
            ]
          }).container().appendTo($('#buttons'));
          $('.buttons-excel').attr('data-original-title', 'Export to Excel').tooltip();
          $('.buttons-print').attr('data-original-title', 'Print').tooltip();
        }, 100);
        this.announcementlist = data;
        //	this.globals.isLoading = false;
      },
        (error) => {
          // this.globals.isLoading = false;	
          this.router.navigate(['/pagenotfound']);
        });
  }
  isActiveChange(changeEntity, i) {
    if (this.announcementlist[i].IsActive == 1) {
      this.announcementlist[i].IsActive = 0;
      changeEntity.IsActive = 0;
    } else {
      this.announcementlist[i].IsActive = 1;
      changeEntity.IsActive = 1;
    }
    this.globals.isLoading = true;
    changeEntity.UpdatedBy = this.globals.authData.UserId;
    changeEntity.Id = changeEntity.AnnouncementId;
    changeEntity.TableName = 'tblannouncement';
    changeEntity.FieldName = 'AnnouncementId';
    changeEntity.Module = 'Announcement Activity';
    this.ActivedeleteService.isActiveChange(changeEntity)
      .then((data) => {
        this.globals.isLoading = false;
        swal({

          type: 'success',
          title: 'Announcement updated successfully',
          showConfirmButton: false,
          timer: 1500
        })
      },
        (error) => {
          this.globals.isLoading = false;
          this.router.navigate(['/pagenotfound']);
        });
  }
  deleteAnnouncement(announcement) {
    this.deleteEntity = announcement;
    swal({
      title: 'Delete a Announcement',
      text: "Are You sure you want to delete this announcement?",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes',
      cancelButtonText: 'No'
    })
      .then((result) => {
        if (result.value) {
          var del = { 'Userid': this.globals.authData.UserId, 'id': announcement.AnnouncementId, 'TableName': 'tblannouncement', 'FieldName': 'AnnouncementId', 'Module': 'Announcement' };
          this.ActivedeleteService.delete(del)
            .then((data) => {
              let index = this.announcementlist.indexOf(announcement);
              if (index != -1) {
                this.announcementlist.splice(index, 1);
              }
              swal({
                type: 'success',
                title: 'Deleted!',
    
                text: 'Announcement has been deleted successfully',
                showConfirmButton: false,
                timer: 1500
              })
            },
              (error) => {
                if (error.text) {
                  this.globals.message = "You can't delete this record because of their dependency!";
                  this.globals.type = 'danger';
                  this.globals.msgflag = true;
                }
              });
        }
      })
  }

}
