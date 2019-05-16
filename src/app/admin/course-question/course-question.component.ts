import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { Globals } from '.././globals';

import { CourseQuestionService } from '../services/course-question.service';
declare var $, swal: any;
declare var CKEDITOR: any, swal: any;
declare function myInput(): any;
@Component({
  selector: 'app-course-question',
  templateUrl: './course-question.component.html',
  styleUrls: ['./course-question.component.css']
})
export class CourseQuestionComponent implements OnInit {
  TopicList;
  QuestionEntity;
  btn_disable;
  submitted;
  des_valid;
  readiovalid;
  Coursename;
  cid;
  buttonName;
  header;
  constructor( public globals: Globals, private router: Router, private CourseQuestionService: CourseQuestionService, private route: ActivatedRoute) { }

  ngOnInit() {

    this.QuestionEntity = {};
    this.QuestionEntity.IsActive = 1;
    var item = { 'CorrectAnswer': '1', 'OptionValue': '' };
    this.TopicList = [];
    this.TopicList.push(item);
    var item1 = { 'CorrectAnswer': '0', 'OptionValue': '' };

    this.TopicList.push(item1);
    setTimeout(function () {
    // $("#CorrectAnswer0").prop('checked', true);
       CKEDITOR.replace('QuestionName', {
         height: '300',
         resize_enabled: 'false',
         resize_maxHeight: '300',
         resize_maxWidth: '948',
         resize_minHeight: '300',
         resize_minWidth: '948',
         //extraAllowedContent: 'style;*[id,rel](*){*}'
         extraAllowedContent: 'span;ul;li;table;td;style;*[id];*(*);*{*}'
        // enterMode: Number(2)
 
       });
     }, 500);
    let id = this.route.snapshot.paramMap.get('id');
    this.cid=id;
    let QId = this.route.snapshot.paramMap.get('QuestionId');
    if (id) {
      this.header="Add";
      this.buttonName="Add";
      this.CourseQuestionService.getCourseById(id)
      .then((data) => {
        debugger
        this.Coursename = data;
      },
      (error) => {
        //alert('error');
        this.btn_disable = false;
        this.submitted = false;
        //this.router.navigate(['/pagenotfound']);
      });
      if (QId) {
        this.header="Edit";
        this.buttonName="Update";
        this.CourseQuestionService.getById(QId)
          .then((data) => {
            debugger
            this.QuestionEntity = data;
            
            if (data['IsActive'] == 0) {
              this.QuestionEntity.IsActive = 0;
            } else {
              this.QuestionEntity.IsActive = '1';
            }
            this.TopicList = data['TopicList'];
                  for(var i = 0; i < this.TopicList.length; i++)
                  {
                    if(this.TopicList[i].CorrectAnswer==1)
                    {
                     var ii=i;
                     setTimeout(function ()
                      {
                          $("#CorrectAnswer"+ii).prop('checked', true);
                          CKEDITOR.instances.QuestionText.setData(this.QuestionEntity.QuestionName);
                      }, 500);
              
                    }
                   
                  }
                  // setTimeout(function () {
                  //   CKEDITOR.instances.QuestionText.setData(this.QuestionEntity.QuestionName);
                  //  }, 500);
            this.globals.isLoading = false;
   
          },
            (error) => {
              //alert('error');
              this.btn_disable = false;
              this.submitted = false;
              //this.router.navigate(['/pagenotfound']);
            });
      } else {
        this.header="Add";
        this.buttonName="Add";
        this.QuestionEntity.QuestionId = 0;
     
        setTimeout(function () {
          $("#CorrectAnswer0").prop('checked', true);
        }, 500);
      }

    } else {
      this.header="Add";
      this.buttonName="Add";
      this.globals.isLoading = false;
      this.QuestionEntity.QuestionId = 0;
  
    }

  }

  RadioChange(i) {
    for (var j = 0; j <= this.TopicList.length; j++) {
      if (i == j) {
        this.TopicList[j].CorrectAnswer = 1;
      } else {
        this.TopicList[j].CorrectAnswer = 0;
      }
    }

  }

  AddNewTopic(index) {
    debugger
    //index+1

    var item = { 'CorrectAnswer': '0', 'OptionValue': '' };
    this.TopicList.push(item);
    // setTimeout(function(){
    //   myInput();
    //    },100);
  }

  DeleteTopic(item) {
    debugger
    var index = this.TopicList.indexOf(item);
    this.TopicList.splice(index, 1);
  }
  addQuestion(questionForm) {
    debugger
    var count = 0;
    var count1=1;
    let id = this.route.snapshot.paramMap.get('id');
    this.QuestionEntity.CourseId = id;
    this.QuestionEntity.CreatedBy = this.globals.authData.UserId;
    // this.QuestionEntity.QuestionId=0;
    this.QuestionEntity.QuestionName = CKEDITOR.instances.QuestionName.getData();
    if (this.QuestionEntity.QuestionName == "" || this.QuestionEntity.QuestionName == null || this.QuestionEntity.QuestionName == undefined) {
      this.des_valid = true;
      count = 1;
    } else {
      this.des_valid = false;
    }

    this.submitted = true;
    for (var j = 0; j < this.TopicList.length; j++)
    {
      if(this.TopicList[j].CorrectAnswer==1)
      {
        count1=0;
      }
    }
    if(count1==0)
    {
      this.readiovalid=false;
    }else
    {
      this.readiovalid=true;
    }
    let QId = this.route.snapshot.paramMap.get('QuestionId');
    if (QId) {
      this.QuestionEntity.UpdatedBy = this.globals.authData.UserId;
    } else {
      this.QuestionEntity.CreatedBy = this.globals.authData.UserId;
    }
    if (questionForm.valid && count == 0 &&  count1 == 0) {
      this.btn_disable = true;
      var addt = { 'QuestionEntity': this.QuestionEntity, 'TopicList': this.TopicList };
      this.CourseQuestionService.add(addt)
        .then((data) => {

          this.btn_disable = false;
          this.submitted = false;
          this.QuestionEntity = {};
          this.QuestionEntity.IsActive = 1;
          CKEDITOR.instances.QuestionName.setData('');
          var item = { 'CorrectAnswer': '1', 'OptionValue': '' };
          this.TopicList = [];
          this.TopicList.push(item);
          var item1 = { 'CorrectAnswer': '0', 'OptionValue': '' };
          this.TopicList.push(item1);
          setTimeout(function () {
            $("#CorrectAnswer0").prop('checked', true);
          }, 500);
          questionForm.form.markAsPristine();
          if (QId) {

            swal({

              type: 'success',
              title: 'Updated!',
              text: 'Question has been updated successfully',
              showConfirmButton: false,
              timer: 3000
            })
            this.router.navigate(['/course-questionlist/' + id]);
          } else {
            this.QuestionEntity.QuestionId = 0;
            swal({
              type: 'success',
              title: 'Added!',
              text: 'Question has been added successfully',
              showConfirmButton: false,
              timer: 3000
            })
          }


        },
          (error) => {

            this.btn_disable = false;
            this.submitted = false;


          });

    }

  } 
     clearForm(questionForm) {debugger
    this.QuestionEntity = {};
    var item = { 'CorrectAnswer': '1', 'OptionValue': '' };
    this.TopicList = [];
    this.TopicList.push(item);
    var item1 = { 'CorrectAnswer': '0', 'OptionValue': '' };

    this.TopicList.push(item1);
    setTimeout(function () {
      $("#CorrectAnswer0").prop('checked', true);
    }, 500);
    questionForm.form.markAsPristine();
    this.submitted = false;
    //this.CategoryEntity.CategoryId = 0;
    this.QuestionEntity.IsActive = '1';
    this.QuestionEntity.QuestionId = 0;
  }


}

