  import { Component, OnInit } from '@angular/core';
  import { Globals } from '.././globals';
  import { Router } from '@angular/router';
  import { ActivatedRoute } from '@angular/router';
  import { InstructorinvitationService } from '../services/instructorinvitation.service';
  import {IOption} from 'ng-select';
  declare var $,swal: any;
  declare function myInput() : any;
  declare var $,Bloodhound: any;
  @Component({
    selector: 'app-instructorinvitation',
    templateUrl: './instructorinvitation.component.html',
    styleUrls: ['./instructorinvitation.component.css']
  })
  export class InstructorinvitationComponent implements OnInit {
    CourseList;
    InstructorList;
    InstructorEntity;
    submitted;
    btn_disable;
    header;
  
    constructor( public globals: Globals, private router: Router, private route: ActivatedRoute,
      private InstructorinvitationService: InstructorinvitationService) { }
      selectedCharacters:Array<string> = [];
      ngOnInit() {debugger
 
          var Keyword = new Bloodhound({
              datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
              queryTokenizer: Bloodhound.tokenizers.whitespace,
              prefetch: {
                url: this.globals.baseAPIUrl+'Course/skillsData',
                filter: function(list) {
                return $.map(list, function(cityname) {
                  return { name: cityname }; });
                }
              }
              });
              
              Keyword.initialize();
              
              $('#tagsinput').tagsinput({
              typeaheadjs: {
                name: 'Keyword',
                displayKey: 'name',
                valueKey: 'name',
                source: Keyword.ttAdapter()
              }
              
              });
     
        this.InstructorEntity = {};
        this.InstructorEntity.CourseId = 0;
        this.InstructorEntity.UserId = 0;

     
     
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
      
                          
                              this.InstructorinvitationService.getAllCourse()
                              //.map(res => res.json())
                              .then((data) => {
                                this.CourseList = data;
                                myInput();
                              },
                              (error) => {
                                //alert('error');
                              
                                //this.router.navigate(['/pagenotfound']);
                              });
                              this.InstructorinvitationService.getAllInstructor()
                              //.map(res => res.json())
                              .then((data) => {
                                this.InstructorList= data;
                                myInput();
                              },
                              (error) => {
                                //alert('error');
                              
                                //this.router.navigate(['/pagenotfound']);
                              });
                              myInput();
                          
      // setTimeout(function(){
      //   $(".company").addClass("selected");
      // },500);
  
      }
    //   onSelected(option: IOption) { 
    //     if(this.selectedCharacters.length>0){
    //       this.selectedCharacters.push(`${option.value}`);
    //     } else {
    //       this.selectedCharacters = [];
    //       this.selectedCharacters.push(`${option.value}`);
    //     }
    // }
    // changeSourceUser(option: IOption){ debugger
    //   this.selectedCharacters.splice(this.selectedCharacters.indexOf(option.value),1);
    // }
    addInstructor(InstructorForm) 
    {		debugger
        let id = this.route.snapshot.paramMap.get('id');
        if (id) {
        this.InstructorEntity.UpdatedBy = 1;
        this.submitted = false;
      } else {
        this.InstructorEntity.CreatedBy = 1;
        this.InstructorEntity.UpdatedBy = 1;

        this.submitted = true;
      }
        
        if(InstructorForm.valid){
          this.btn_disable = true;
          this.InstructorEntity.UserId = this.selectedCharacters;
          this.InstructorinvitationService.add(this.InstructorEntity)
          .then((data) => 
          {
        
       
            this.btn_disable = false;
            this.submitted = false;
            this.InstructorEntity = {};
            InstructorForm.form.markAsPristine();
            if (id) {
          
            swal({
             
              type: 'success',
              title: 'Updated!',
              text: 'Instructor has been updated successfully!',
              showConfirmButton: false,
              timer: 1500
            })
          } else {
          
            swal({
             
              type: 'success',
              title: 'Added!',
              text: 'Instructor has been added successfully!',
              showConfirmButton: false,
              timer: 1500
            })
          } 
            this.router.navigate(['/Instructorinvitationlist']);
          }, 
          (error) => 
          {
 
            this.btn_disable = false;
            this.submitted = false;

          });	
        
        }
      }
    }
    