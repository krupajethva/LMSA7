import { Component, OnInit } from '@angular/core';
import { Globals } from '.././globals';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { ParentcategoryService } from '../services/parentcategory.service';
declare var $, swal: any;
declare function myInput(): any;
declare var $, Bloodhound: any;
@Component({
  selector: 'app-parentcategory',
  templateUrl: './parentcategory.component.html',
  styleUrls: ['./parentcategory.component.css']

})
export class ParentcategoryComponent implements OnInit {


  ParentCategoryEntity;
  submitted;
  btn_disable;
  header;
  submitbutton;
  constructor( public globals: Globals, private router: Router, private route: ActivatedRoute,
    private ParentcategoryService: ParentcategoryService) { }

  ngOnInit() {

    this.ParentCategoryEntity = {};
    this.ParentCategoryEntity.CategoryId = 0;
    this.ParentCategoryEntity.IsActive = 1;
    setTimeout(function () {
      if ($(".bg_white_block").hasClass("ps--active-y")) {
        $('footer').removeClass('footer_fixed');
      }
      else {
        $('footer').addClass('footer_fixed');
      }
    }, 100);
    var skills = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      prefetch: {
        url: '../assets/skills.json'
      }
    });
    skills.initialize();
    var elt = $('#skills');
    elt.tagsinput({
      typeaheadjs: {
        name: 'skills',
        displayKey: 'name',
        valueKey: 'name',
        source: skills.ttAdapter()
      }
    });



    let id = this.route.snapshot.paramMap.get('id');
    if (id) {
      this.header = 'Edit';
      this.submitbutton= 'Update';
      this.ParentcategoryService.getById(id)
        .then((data) => {debugger
          this.ParentCategoryEntity = data;
          if(data['IsActive']==0){
            this.ParentCategoryEntity.IsActive = 0;
          } else {
            this.ParentCategoryEntity.IsActive = '1';
          }
          setTimeout(function () {
            myInput();
          }, 100);

        },
          (error) => {
            //alert('error');
            this.btn_disable = false;
            this.submitted = false;

            //this.router.navigate(['/pagenotfound']);
          });
    }
    else {
      this.header = 'Add';
      this.submitbutton= 'Add';
      this.ParentCategoryEntity = {};
      this.ParentCategoryEntity.CategoryId = 0;
      this.ParentCategoryEntity.IsActive = '1';
      myInput();
    }


  }

  addCategory(CategoryForm) {debugger
    let id = this.route.snapshot.paramMap.get('id');
    if (id) {
      this.ParentCategoryEntity.UpdatedBy = 1;
      this.submitted = false;
    } else {
      this.ParentCategoryEntity.CreatedBy = 1;
      this.ParentCategoryEntity.UpdatedBy = 1;
      //this.ParentCategoryEntity.CompanyId = 0;
      this.submitted = true;
    }
    if (id) {
      this.submitted = false;
    } else {
      this.ParentCategoryEntity.CategoryId = 0;
      this.submitted = true;
    }
    if (CategoryForm.valid) {
      this.btn_disable = true;
      this.ParentcategoryService.add(this.ParentCategoryEntity)
        .then((data) => {


          this.btn_disable = false;
          this.submitted = false;
          this.ParentCategoryEntity = {};
          CategoryForm.form.markAsPristine();
          if (id) {

            swal({
             
              type: 'success',
              title: 'Updated!',
              text: 'Category has been updated successfully!',
              showConfirmButton: false,
              timer: 1500
            })
          } else {
            swal({
             
              type: 'success',
              title: 'Added!',
              text: 'Category has been added successfully!',
              showConfirmButton: false,
              timer: 1500
            })
          }
          this.router.navigate(['/Parentcategorylist']);
        },
          (error) => {

            this.btn_disable = false;
            this.submitted = false;

          });

    }
  }
  clearForm(CategoryForm) {
    debugger
    this.ParentCategoryEntity = {};
    this.submitted = false;
    //this.ParentCategoryEntity.CategoryId = 0;
    this.ParentCategoryEntity.IsActive = '1';

    CategoryForm.form.markAsPristine();
    this.ParentCategoryEntity.CategoryId = 0;
  }

}
