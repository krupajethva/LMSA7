import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { Globals } from '.././globals';

import { RouterModule } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { CountryService } from '../services/country.service';
declare var $, swal: any;
declare function myInput(): any;
declare var $, Bloodhound: any;


@Component({
  selector: 'app-countrylist',
  templateUrl: './countrylist.component.html',
  styleUrls: ['./countrylist.component.css']
})
export class CountrylistComponent implements OnInit {
  CountryList;
  deleteEntity;
  msgflag;
  message;
  type;
  permissionEntity;
  constructor( public globals: Globals, private router: Router, private CountryService: CountryService, private route: ActivatedRoute) { }
  ngOnInit() {

    $('.buttons-excel').attr('data-original-title', 'Export to Excel').tooltip();
    $('.buttons-print').attr('data-original-title', 'Print').tooltip();

    this.globals.isLoading = true;

    this.CountryService.getAllCou()
      .then((data) => {
        debugger
        this.CountryList = data;
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
              "sLengthMenu": "_MENU_ Countries per page",
              "sInfo": "Showing _START_ to _END_ of _TOTAL_ Countries",
              "sInfoFiltered": "(filtered from _MAX_ total Countries)",
              "sInfoEmpty": "Showing 0 to 0 of 0 Countries"
            },
            dom: 'lBfrtip',
            buttons: [
              {
                extend: 'excel',
                title: 'Learning Management System – Country List – ' + todaysdate,
                filename: 'LearningManagementSystem–CountryList–' + todaysdate,
                customize: function (xlsx) {
                  var source = xlsx.xl['workbook.xml'].getElementsByTagName('sheet')[0];
                  source.setAttribute('name', 'LMS-CountryList');
                },
                exportOptions: {
                  columns: [0, 1, 2, 3]
                }
              },
              {
                extend: 'print',
                title: 'Learning Management System – Country List – ' + todaysdate,
                exportOptions: {
                  columns: [0, 1, 2, 3]
                }
              },
            ]
          });

          var buttons = new $.fn.dataTable.Buttons(table, {
            buttons: [
              {
                extend: 'excel',
                title: 'Countries List',
                exportOptions: {
                  columns: [0, 1, 2, 3]
                }
              },
              {
                extend: 'print',
                title: 'Countries List',
                exportOptions: {
                  columns: [0, 1, 2, 3]
                }
              },
            ]
          }).container().appendTo($('#buttons'));

          $('.buttons-excel').attr('data-original-title', 'Export to Excel').tooltip();
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
    if (this.CountryList[i].IsActive == 1) {
      this.CountryList[i].IsActive = 0;
      changeEntity.IsActive = 0;
    } else {
      this.CountryList[i].IsActive = 1;
      changeEntity.IsActive = 1;
    }
    this.globals.isLoading = true;
    changeEntity.UpdatedBy = 1;

    this.CountryService.isActiveChange(changeEntity)
      .then((data) => {
        this.globals.isLoading = false;
        swal({

          type: 'success',
          title: 'Country Updated Successfully!',
          showConfirmButton: false,
          timer: 3000
        })

      },
        (error) => {
          this.globals.isLoading = false;
          this.router.navigate(['/pagenotfound']);
        });
  }

  deleteCountry(Country) {
    debugger
    this.deleteEntity = Country;
    swal({
      title: 'Delete a Country',
      text: "Are you sure you want to delete this country?",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes',
      cancelButtonText: 'No'
    })
      .then((result) => {
        if (result.value) {
          var del = { 'Userid': this.globals.authData.UserId, 'id': Country.CountryId };
          this.CountryService.delete(del)
            .then((data) => {
              let index = this.CountryList.indexOf(Country);
              $('#Delete_Modal').modal('hide');
              if (index != -1) {
                this.CountryList.splice(index, 1);
              }
              swal({

                type: 'success',
                title: 'Deleted!',
                text: 'Country has been deleted successfully',
                showConfirmButton: false,
                timer: 3000
              })
            },
              (error) => {
                $('#Delete_Modal').modal('hide');
                if (error.text) {
                  swal({

                    type: 'success',
                    title: "You can't delete this record because of their dependency!",
                    showConfirmButton: false,
                    timer: 3000
                  })
                }
              });
        }
      })

  }



}
