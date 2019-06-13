import { Component, OnInit } from '@angular/core';
import { Globals } from '.././globals';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { ParentcategoryService } from '../services/parentcategory.service';
declare var $, swal: any;
declare function myInput(): any;
declare var $, Bloodhound: any;
@Component({
  selector: 'app-parentcategorylist',
  templateUrl: './parentcategorylist.component.html',
  styleUrls: ['./parentcategorylist.component.css']
})
export class ParentcategorylistComponent implements OnInit {
  categoryList;
  deleteEntity;
  msgflag;
  message;
  type;


  constructor( public globals: Globals, private router: Router, private route: ActivatedRoute,
    private ParentcategoryService: ParentcategoryService) { }

  ngOnInit() {
    this.ParentcategoryService.getAllCategory()
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
              "sLengthMenu": "_MENU_ Categories per page",
              "sInfo": "Showing _START_ to _END_ of _TOTAL_ Categories",
              "sInfoFiltered": "(filtered from _MAX_ total Categories)",
              "sInfoEmpty": "Showing 0 to 0 of 0 Categories"
            },
            dom: 'lBfrtip',
            buttons: [

              {
                extend: 'excel',
                title: 'Learning Management System – Category List – ' + todaysdate,
                filename: 'LearningManagementSystem–CategoryList–' + todaysdate,
                customize: function (xlsx) {
                  var source = xlsx.xl['workbook.xml'].getElementsByTagName('sheet')[0];
                  source.setAttribute('name', 'LMS-CategoryList');
                },
                exportOptions: {
                  columns: [0, 1, 2, 3]
                }
              },
              {
                extend: 'print',
                title: 'Learning Management System – Category List – ' + todaysdate,
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
                title: 'ParentCategories List',
                exportOptions: {
                  columns: [0, 1, 2, 3]
                }
              },
              {
                extend: 'print',
                title: 'ParentCategories List',
                exportOptions: {
                  columns: [0, 1, 2, 3]
                }
              },
            ]
          }).container().appendTo($('#buttons'));

          $('.buttons-excel').attr('data-original-title', 'Export').tooltip();
          $('.buttons-print').attr('data-original-title', 'Print').tooltip();


        }, 100);
        this.categoryList = data;
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
	    $(".categories").addClass("active");
      $(".categories > div").addClass("in");
      $(".categories > a").removeClass("collapsed");
      $(".categories > a").attr("aria-expanded","true");
    }, 1000);
  }
  deleteCategory(category) {
    debugger
    this.deleteEntity = category;
    swal({
      title: 'Delete a Category',
      text: "Are you sure you want to delete this category?",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes',
      cancelButtonText: 'No'
    })
      .then((result) => {
        if (result.value) {
          var del = { 'Userid': 1, 'id': category.CategoryId, 'Name': category.CategoryName };
          this.ParentcategoryService.deleteCategory(del)
            .then((data) => {
              let index = this.categoryList.indexOf(category);

              if (index != -1) {
                this.categoryList.splice(index, 1);
              }
              swal({

                type: 'success',
                title: 'Deleted!',
                text: 'Category has been deleted successfully',
     
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
    if (this.categoryList[i].IsActive == 1) {
      this.categoryList[i].IsActive = 0;
      changeEntity.IsActive = 0;
    } else {
      this.categoryList[i].IsActive = 1;
      changeEntity.IsActive = 1;
    }
    // this.globals.isLoading = true;
    changeEntity.UpdatedBy = 1;

    this.ParentcategoryService.isActiveChange(changeEntity)
      .then((data) => {
        // this.globals.isLoading = false;	
        swal({
          type: 'success',
          title: 'Category Updated Successfully!',
          showConfirmButton: false,
          timer: 1500
        })

      },
        (error) => {
          // this.globals.isLoading = false;
          this.router.navigate(['/pagenotfound']);
        });
  }
}


