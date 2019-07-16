
import { Component, OnInit } from '@angular/core';
import { Globals } from '.././globals';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { CategoryService } from '../services/category.service';
declare var $,swal: any;
declare function myInput() : any;
declare var $,Bloodhound: any;
@Component({
  selector: 'app-category',
  templateUrl: './category.component.html',

})
export class CategoryComponent implements OnInit {
  ParentList;

	CategoryEntity;
	submitted;
	btn_disable;
  header;
  submitbutton;
  constructor( public globals: Globals, private router: Router, private route: ActivatedRoute,
		private CategoryService: CategoryService) { }

    ngOnInit() {
		
      this.CategoryEntity = {};
      this.CategoryEntity.CategoryId=0;
      this.CategoryEntity.IsActive=1;
      setTimeout(function(){
        if( $(".bg_white_block").hasClass( "ps--active-y" )){  
          $('footer').removeClass('footer_fixed');     
        }      
        else{  
          $('footer').addClass('footer_fixed');    
        } 
      },100);
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
    //   debugger
    // this.CompanyService.getAllCo()
    // //.map(res => res.json())
    // .then((data) => {
    //   this.CompanyList = data;
    // //	console.log(data);
    // },
    // (error) => {
    //   //alert('error');
    
    //   //this.router.navigate(['/pagenotfound']);
    // });
  
      this.CategoryService.getAllParent()
      //.map(res => res.json())
      .then((data) => {
        this.ParentList = data;
       
      },
      (error) => {
        //alert('error');
      
        //this.router.navigate(['/pagenotfound']);
      });
  
    let id = this.route.snapshot.paramMap.get('id');
    if (id) {
      this.header = 'Edit';
      this.submitbutton= 'Update';
      this.CategoryService.getById(id)
        .then((data) => {
          this.CategoryEntity = data;
          if(data['IsActive']==0){
            this.CategoryEntity.IsActive = 0;
          } else {
            this.CategoryEntity.IsActive = '1';
          }
          setTimeout(function(){
            myInput();
             },100);
        
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
      this.CategoryEntity = {};
      this.CategoryEntity.CategoryId = 0;
      this.CategoryEntity.IsActive = '1';
      myInput();
    }
    setTimeout(function(){
		$(".subcategories").addClass("active");
        $(".subcategories > div").addClass("in");
        $(".subcategories > a").removeClass("collapsed");
      	$(".subcategories > a").attr("aria-expanded","true");
    },300);

    }
  
    addCategory(CategoryForm) 
    {		
        let id = this.route.snapshot.paramMap.get('id');
        if (id) {
        this.CategoryEntity.UpdatedBy = 1;
        this.submitted = false;
      } else {
        this.CategoryEntity.CreatedBy = 1;
        this.CategoryEntity.UpdatedBy = 1;
        this.CategoryEntity.CategoryId = 0;
        //this.CategoryEntity.CompanyId = 0;
        this.submitted = true;
      }
        
        if(CategoryForm.valid){
          this.btn_disable = true;
          this.globals.isLoading = true;
          this.CategoryService.add(this.CategoryEntity)
          .then((data) => 
          {
        
       
            this.btn_disable = false;
            this.submitted = false;
            this.CategoryEntity = {};
            CategoryForm.form.markAsPristine();
            if (id) {
          
            swal({
              type: 'success',
              title: 'Updated!',
              text: 'Category has been updated successfully',
              showConfirmButton: false,
              timer: 1500
            })
          } else {
            swal({
              type: 'success',
              title: 'Added!',
              text: 'Category has been added successfully',
              showConfirmButton: false,
              timer: 1500
            })
          } 
            this.router.navigate(['/categorylist']);
          }, 
          (error) => 
          {
 
            this.btn_disable = false;
            this.submitted = false;
            this.globals.isLoading = false;

          });	
        
        }
      }
    clearForm(CategoryForm) {debugger
      this.CategoryEntity = {};
      CategoryForm.form.markAsPristine();
      this.submitted = false;
      //this.CategoryEntity.CategoryId = 0;
      this.CategoryEntity.IsActive = '1';
      this.CategoryEntity.CategoryId = 0;
    }
  
  }
 