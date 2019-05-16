import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { Globals } from '.././globals';

import { RouterModule } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { EducationService } from '../services/education.service';
declare var $, swal: any;
declare function myInput(): any;
declare var $, Bloodhound: any;


@Component({
  selector: 'app-educationlist',
  templateUrl: './educationlist.component.html',
  styleUrls: ['./educationlist.component.css']
})
export class EducationlistComponent implements OnInit {
  EducationList;
  deleteEntity;
  msgflag;
  message;
  type;
  permissionEntity;
  constructor( public globals: Globals, private router: Router, private EducationService: EducationService, private route: ActivatedRoute) { }
  ngOnInit() {
    $('.buttons-excel').attr('data-original-title', 'Export to Excel').tooltip();
    $('.buttons-print').attr('data-original-title', 'Print').tooltip();

    this.globals.isLoading = true;

    this.EducationService.getAllCou()
      .then((data) => {
        debugger
        this.EducationList = data;
        this.globals.isLoading = false;
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
              "sLengthMenu": "_MENU_ Educations per page",
              "sInfo": "Showing _START_ to _END_ of _TOTAL_ Educations",
              "sInfoFiltered": "(filtered from _MAX_ total Educations)",
              "sInfoEmpty": "Showing 0 to 0 of 0 Educations"
            },
            dom: 'lBfrtip',
            buttons: [
              {
                extend: 'excel',
                title: 'Learning Management System – Education List – ' + todaysdate,
                filename: 'LearningManagementSystem–EducationList–' + todaysdate,
                customize: function (xlsx) {
                  var source = xlsx.xl['workbook.xml'].getElementsByTagName('sheet')[0];
                  source.setAttribute('name', 'LMS-EducationList');
                },
                exportOptions: {
                  columns: [0, 1]
                }
              },
              {
                extend: 'print',
                title: 'Learning Management System – Education List – ' + todaysdate,
                exportOptions: {
                  columns: [0, 1]
                }
              },
            ]
          });

          $('.buttons-excel').attr('data-original-title', 'Export').tooltip();
          $('.buttons-print').attr('data-original-title', 'Print').tooltip();


        }, 100);


        this.globals.isLoading = false;
      },
        (error) => {
          this.globals.isLoading = false;
          this.router.navigate(['/pagenotfound']);
        });
    this.msgflag = false;

    setTimeout(function () {
      if ($(".bg_white_block").hasClass("ps--active-y")) {
        $('footer').removeClass('footer_fixed');
      }
      else {
        $('footer').addClass('footer_fixed');
      }
    }, 1000);

  }


  isActiveChange(changeEntity, i) {
    debugger
    this.globals.isLoading = true;
    if (this.EducationList[i].IsActive == 1) {
      this.EducationList[i].IsActive = 0;
      changeEntity.IsActive = 0;
    } else {
      this.EducationList[i].IsActive = 1;
      changeEntity.IsActive = 1;
    }
    this.globals.isLoading = true;
    changeEntity.UpdatedBy = 1;

    this.EducationService.isActiveChange(changeEntity)
      .then((data) => {
        this.globals.isLoading = false;
        swal({

          type: 'success',
          title: 'Updated!',
          text: 'Education has been updated sccessfully!',
          showConfirmButton: false,
          timer: 3000
        })

      },
        (error) => {
          this.globals.isLoading = false;
          this.router.navigate(['/pagenotfound']);
        });
  }


  deleteEducation(Education) {
    debugger
    this.deleteEntity = Education;
    swal({
      title: 'Delete an Education',
      text: "Are you sure you want to delete this education?",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes',
      cancelButtonText: 'No'
    })
      .then((result) => {
        if (result.value) {
          var del = { 'Userid': this.globals.authData.UserId, 'id': Education.EducationLevelId };
          this.EducationService.delete(del)
            .then((data) => {
              let index = this.EducationList.indexOf(Education);
              $('#Delete_Modal').modal('hide');
              if (index != -1) {
                this.EducationList.splice(index, 1);
              }
              swal({

                type: 'success',
                title: 'Deleted!',
                text: 'Education has been deleted successfully',
                showConfirmButton: false,
                timer: 3000
              })
            },
              (error) => {
                $('#Delete_Modal').modal('hide');
                if (error.text) {
                  swal({

                    type: 'error',
                    title:'Oops...',
                    text: "You can't delete this record because of their dependency!",
                    showConfirmButton: false,
                    timer: 3000
                  })
                }
              });
        }
      })

  }



}
