import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { Globals } from '.././globals';
import { RouterModule } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { AddressesService } from '../services/addresses.service';
declare var swal: any;
declare function myInput(): any;
declare var $, Bloodhound: any;


@Component({
  selector: 'app-addresseslist',
  templateUrl: './addresseslist.component.html',
  styleUrls: ['./addresseslist.component.css']
})
export class AddresseslistComponent implements OnInit {
  AddressesList;
  deleteEntity;
  msgflag;
  message;
  type;
  constructor(public globals: Globals, private router: Router, private AddressesService: AddressesService, private route: ActivatedRoute) { }

  ngOnInit() {
    $('.buttons-excel').attr('data-original-title', 'Export to Excel').tooltip();
    $('.buttons-print').attr('data-original-title', 'Print').tooltip();

    this.globals.isLoading = true;

    this.AddressesService.getAllAddresses()
      .then((data) => {
        debugger
        this.AddressesList = data;
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
              "sLengthMenu": "_MENU_ Addresses per page",
              "sInfo": "Showing _START_ to _END_ of _TOTAL_ Addresses",
              "sInfoFiltered": "(filtered from _MAX_ total Addresses)",
              "sInfoEmpty": "Showing 0 to 0 of 0 Addresses"
            },
            dom: 'lBfrtip',
            buttons: [
              {
                extend: 'excel',
                title: 'Learning Management System – Addresses List – ' + todaysdate,
                filename: 'LearningManagementSystem–AddressesList–' + todaysdate,
                customize: function (xlsx) {
                  var source = xlsx.xl['workbook.xml'].getElementsByTagName('sheet')[0];
                  source.setAttribute('name', 'LMS-AddressesList');
                },
                exportOptions: {
                  columns: [0, 1, 2, 3]
                }
              },
              {
                extend: 'print',
                title: 'Learning Management System –  Addresses List – ' + todaysdate,
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
                title: 'Addresses List',
                exportOptions: {
                  columns: [0, 1, 2, 3]
                }
              },
              {
                extend: 'print',
                title: 'Addresses List',
                exportOptions: {
                  columns: [0, 1, 2, 3]
                }
              },
            ]
          }).container().appendTo($('#buttons'));

          $('.buttons-excel').attr('data-original-title', 'Export').tooltip();
          $('.buttons-print').attr('data-original-title', 'Print').tooltip();

        }, 100);


        this.globals.isLoading = false;
      },
        (error) => {
          this.globals.isLoading = false;
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


}
