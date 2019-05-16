import { Component, OnInit } from '@angular/core';
import { Globals } from '.././globals';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { CertificatetemplateService } from '../services/certificatetemplate.service';
declare var $, swal: any;
declare function myInput(): any;
declare var $, Bloodhound: any;
@Component({
  selector: 'app-certificatetemplatelist',
  templateUrl: './certificatetemplatelist.component.html',
  styleUrls: ['./certificatetemplatelist.component.css']
})
export class CertificatetemplatelistComponent implements OnInit {
  certificateList;
  deleteEntity;
  msgflag;
  message;
  type;
  certificateData;


  constructor( public globals: Globals, private router: Router, private route: ActivatedRoute,
    private CertificatetemplateService: CertificatetemplateService) { }

  ngOnInit() {

    
    setTimeout(function () {
      $('.modal').on('shown.bs.modal', function () {
        $('.right_content_block').addClass('style_position');
      })
      $('.modal').on('hidden.bs.modal', function () {
        $('.right_content_block').removeClass('style_position');
      });

    }, 500);
    
    debugger

    

    $('.buttons-excel').attr('data-original-title', 'Export to Excel').tooltip();
    $('.buttons-print').attr('data-original-title', 'Print').tooltip();



    this.CertificatetemplateService.getAllCertificate()
      .then((data) => {
        debugger
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
              "sLengthMenu": "_MENU_ Certificates per page",
              "sInfo": "Showing _START_ to _END_ of _TOTAL_ Certificates",
              "sInfoFiltered": "(filtered from _MAX_ total Certificate)",
              "sInfoEmpty": "Showing 0 to 0 of 0 Certificates"
            },
            dom: 'lBfrtip',
            buttons: [
              {
                extend: 'excel',
                title: 'Learning Management System – Certificates List – ' + todaysdate,
                filename: 'LearningManagementSystem–CertificatesList–' + todaysdate,
                customize: function (xlsx) {
                  var source = xlsx.xl['workbook.xml'].getElementsByTagName('sheet')[0];
                  source.setAttribute('name', 'LMS-CertificatesList');
                },
                exportOptions: {
                  columns: [0, 1, 2, 3]
                }
              },
              {
                extend: 'print',
                title: 'Learning Management System –  Certificates List – ' + todaysdate,
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
                title: 'Certificates List',
                exportOptions: {
                  columns: [0, 1, 2, 3]
                }
              },
              {
                extend: 'print',
                title: 'Certificates List',
                exportOptions: {
                  columns: [0, 1, 2, 3]
                }
              },
            ]
          }).container().appendTo($('#buttons'));
		  
		   $('.buttons-excel').attr('data-original-title', 'Export').tooltip();
          $('.buttons-print').attr('data-original-title', 'Print').tooltip();
		  
		  
        }, 100);
        this.certificateList = data;
        //this.globals.isLoading = false;	
      },
        (error) => {
          // this.globals.isLoading = false;
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
  deleteCertificate(certificate) {
    debugger
    this.deleteEntity = certificate;
    swal({
      title: 'Delete a Certificate',
      text: "Are you sure you want to delete this certificate?",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes',
      cancelButtonText: 'No'
    })
      .then((result) => {
        if (result.value) {
          var del = { 'Userid': 1, 'id': certificate.CertificateId, 'Name': certificate.CertificateName };
          this.CertificatetemplateService.deleteCertificate(del)
            .then((data) => {
              let index = this.certificateList.indexOf(certificate);

              if (index != -1) {
                this.certificateList.splice(index, 1);
              }
              swal({
                type: 'success',
                title: 'Deleted!',
                text: 'Certificate has been deleted successfully',
                showConfirmButton: false,
                timer: 1500
              })
            },
              (error) => {

                if (error.text) {
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

  isActiveChange(changeEntity, i) {
    if (this.certificateList[i].IsActive == 1) {
      this.certificateList[i].IsActive = 0;
      changeEntity.IsActive = 0;
    } else {
      this.certificateList[i].IsActive = 1;
      changeEntity.IsActive = 1;
    }
    // this.globals.isLoading = true;
    changeEntity.UpdatedBy = 1;

    this.CertificatetemplateService.isActiveChange(changeEntity)
      .then((data) => {
        // this.globals.isLoading = false;	
        swal({
         
          type: 'success',
          title: 'Certificate Updated Successfully!',
          showConfirmButton: false,
          timer: 1500
        })

      },
        (error) => {
          // this.globals.isLoading = false;
          this.router.navigate(['/pagenotfound']);
        });
  }

  viewCertificate(CertificateId) {
    this.CertificatetemplateService.getById(CertificateId)
      .then((data) => {
        this.certificateData = data;
        $('#ViewCertificate_Modal').modal('show');
      },
        (error) => {
          alert('error');

        });
  }

}
