import { Component, OnInit, ElementRef } from '@angular/core';
import { Globals } from '.././globals';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
declare var $, Date, PerfectScrollbar, Swiper: any;
import { AssessmenttestService } from '../services/assessmenttest.service';
@Component({
  selector: 'app-assessmenttest',
  templateUrl: './assessmenttest.component.html',
  styleUrls: ['./assessmenttest.component.css']
})
export class AssessmenttestComponent implements OnInit {
  btn_disable;
  submitted;
  assessmentEntity;
  questionlist;
  ansEntity;
  all;
  UnAnswred;
  Reviewed;
  TotalQuestion;
  anstotalcount;
  percent;
  ResultId;
  Atim;
  AsTotaltime;
  pushtime;
  dd;
  constructor( public globals: Globals, private router: Router, private elem: ElementRef, private route: ActivatedRoute, private AssessmenttestService: AssessmenttestService) { }

  ngOnInit() {

    window.onbeforeunload = (ev) => {
      this.finalsubmit();

      // OR

      // this.yuorService.doActon().subscribe(() => {
      //     alert('did something before refresh');  
      // });

       // OR

      // finally return the message to browser api.
      var dialogText = 'Changes that you made may not be saved.';
      ev.returnValue = dialogText;
      return dialogText;
}; 
    this.Atim='';

    setTimeout(function () {
      // The slider being synced must be initialized first
      $('.carousel').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        itemWidth: 50,
        itemMargin:1,
        asNavFor: '.slider'
      });

      $('.slider').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        sync: ".carousel"
      });
      $(".carousel .flex-direction-nav:last-child").css("display", "block");
      $(".slider .flex-direction-nav:last-child").css("display", "block");
      /*----- end assessment slider script -----*/
    }, 500);


    this.globals.isLoading = false;
    this.assessmentEntity = {};
    this.ansEntity = {};
  
    //$('#myModal').modal({ backdrop: 'static', keyboard: false })

    // $(window).on('load', function () {
    //   $('#myModal').modal('show');
    // });
    let id = this.route.snapshot.paramMap.get('id');
    if (id) {
      this.AssessmenttestService.getbyassessment(id, this.globals.authData.UserId)
        .then((data) => {
          debugger
          clearInterval(counter);
          this.assessmentEntity = data['coursename'];
          this.questionlist = data['question'];
          this.assessmentEntity.UserId=this.globals.authData.UserId;
          this.ResultId = this.questionlist[0].ResultId;
        this.AsTotaltime=this.assessmentEntity.AsTotaltime;
         this.Atim= this.assessmentEntity.AssessmentTime;
         var Rid=this.ResultId;
         var count = this.Atim;
         var counter = setInterval(timer, 1000); //1000 will  run it every 1 second
         
         function timer()
        {
             count = count - 1;
             if (count == -1) {
                 clearInterval(counter);
                 return;
             }
         
             var seconds = count % 60;
             var minutes = Math.floor(count / 60);
             var hours = Math.floor(minutes / 60);
             minutes %= 60;
             hours %= 60;
             var hour = '' + hours;
             var minute ='' +  minutes;
             var second = '' + seconds;
             if(hours<10){
              hour = '0' + hours;
             } 
             if(minutes<10){
              minute = '0' + minutes;
             } 
             if(seconds<10){
              second = '0' + seconds;
             }
             this.dd= hour + ":" + minute + ":" + second;
             localStorage.setItem("Userdata", hour + ":" + minute + ":" + second);
             document.getElementById("countdown").innerHTML = hour + ":" + minute + ":" + second; // watch for spelling
             if(this.dd=="00:00:00")
             { debugger
                  alert("Boom!");
                  window.location.href='/assessment-result/'+Rid+'/1';
          
             }
            
          }
          var k = 0;
          this.TotalQuestion = this.questionlist[0].TotalAttendQuestion;
          this.ResultId = this.questionlist[0].ResultId;
     
          for (var i = 0; i < this.questionlist.length; i++) {
            if (this.questionlist[i].OptionId > 0) {

              k++;
            }
            this.anstotalcount = k;
            let addpro = (100 * k) / this.TotalQuestion;
            this.percent = Math.round(addpro);
            var progress = document.getElementById("progress");
            $(progress).css("width", addpro + "%");
            this.globals.isLoading = false;
      
            setTimeout(function () {
              $('.modal').on('shown.bs.modal', function () {
                $('.right_content_block').addClass('style_position');
              })
              $('.modal').on('hidden.bs.modal', function () {
                $('.right_content_block').removeClass('style_position');
              });
              // $('#test0').addClass('completed');




            }, 500);
          }
        },
          (error) => {
            //alert('error');
            this.btn_disable = false;
            this.submitted = false;
            //this.router.navigate(['/pagenotfound']);
          });

    }
   
 


    new PerfectScrollbar('.assessment_preview_scroll');


  }
  abc()
  {
    alert('a');
  }
  QuestionChange(OptionId, QuestionId, ResultId, j) {

  
    //  alert(OptionId+QuestionId+ResultId);
    this.ansEntity.OptionId = OptionId;
    this.ansEntity.QuestionId = QuestionId;
    this.ansEntity.ResultId = ResultId;
    this.ansEntity.UserId = this.globals.authData.UserId;

    this.globals.isLoading = true;
    // var del = { 'OptionId': OptionId, 'UserId': this.globals.authData.UserId };
    this.AssessmenttestService.assessmentans(this.ansEntity)
      .then((data) => {


        $('#test' + j).addClass('complete');
        this.globals.isLoading = false;
        this.questionlist[j].OptionId = this.ansEntity.OptionId;

        var k = 0;
        for (var i = 0; i < this.questionlist.length; i++) {
          if (this.questionlist[i].OptionId > 0) {
            k++;
          }
        }
        this.anstotalcount = k;
        let addpro = (100 * k) / this.TotalQuestion;
        this.percent = Math.round(addpro);
        var progress = document.getElementById("progress");
        $(progress).css("width", addpro + "%");

      },
        (error) => {
          //alert('error');
          this.btn_disable = false;
          this.submitted = false;
          //this.router.navigate(['/pagenotfound']);
        });


  }

    getLocalStorageData(name)
    {
      //  $.getElementById("demo").innerHTML = localStorage.getItem("Userdata");
        $("#demo").html(localStorage.getItem("Userdata"));
  
    }
  submitans()
  {
    	 $('#assessment_preview_modal').modal('show');
  }
  questionactive(question, i) {
    debugger
    if (this.questionlist[i].MarkasReview == 1) {
      this.questionlist[i].MarkasReview = 0;
      question.MarkasReview = 0;
    } else {
      this.questionlist[i].MarkasReview = 1;
      question.MarkasReview = 1;
    }
    this.globals.isLoading = true;
    question.UpdatedBy = this.globals.authData.UserId;

    this.AssessmenttestService.MarkasReview(question)
      .then((data) => {
        this.globals.isLoading = false;

        this.questionlist[i].MarkasReview = question.MarkasReview;
        this.questionlist[i].OptionId = question.OptionId;
      },
        (error) => {
          this.globals.isLoading = false;
          this.router.navigate(['/pagenotfound']);
        });
  }
  All() {debugger
 
    if($('input[name="Check1"]').is(':checked'))
    {
      this.assessmentEntity.all=true;
    }else
    {
      this.assessmentEntity.all=false;
    }
    if($('input[name="Check2"]').is(':checked'))
    {
      this.assessmentEntity.UnAnswred=true;
    }else
    {
      this.assessmentEntity.UnAnswred=false;
    }
    if($('input[name="Check3"]').is(':checked'))
    {
      this.assessmentEntity.Reviewed=true;
    }else
    {
      this.assessmentEntity.Reviewed=false;
    }
    this.AssessmenttestService.getbyassessmentcheck(this.assessmentEntity)
    .then((data) => {
      debugger
      // if(){

      // } else {

      // }
      this.questionlist = data;
      if(this.questionlist==null)
      {
        $(".carousel .flex-direction-nav").css("display", "none");
        $(".slider .flex-direction-nav").css("display", "none");
      }
      else
      {
      setTimeout(function () {

        // $('#test0').addClass('completed');
        /*----- start assessment slider script -----*/
  
        // The slider being synced must be initialized first
        $('.flexslider').removeData("flexslider");
        $('#slider').flexslider({
          destroy:true
        });
        $('#carousel').flexslider({
            destroy:true
        });
        $(".carousel .flex-direction-nav").css("display", "none");
        $(".slider .flex-direction-nav").css("display", "none");
       

        $('.carousel').flexslider({
          animation: "slide",
          controlNav: false,
          animationLoop: false,
          slideshow: false,
          itemWidth: 50,
          itemMargin:1,
          asNavFor: '.slider'
        });
  
        $('.slider').flexslider({
          animation: "slide",
          controlNav: false,
          animationLoop: false,
          slideshow: false,
          sync: ".carousel"
        });
        $(".carousel .flex-direction-nav:last-child").css("display", "block");
        $(".slider .flex-direction-nav:last-child").css("display", "block");
        /*----- end assessment slider script -----*/
      }, 500);
    }
    //   var k = 0;
    //   this.TotalQuestion = this.questionlist[0].TotalAttendQuestion;
    //  this.ResultId = this.questionlist[0].ResultId;
    //   for (var i = 0; i < this.questionlist.length; i++) {
    //     if (this.questionlist[i].OptionId > 0) {

    //       k++;
    //     }
    //   this.anstotalcount = k;
    //     let addpro = (100 * k) / this.TotalQuestion;
    //     this.percent = Math.round(addpro);
    //     var progress = document.getElementById("progress");
    //     $(progress).css("width", addpro + "%");
    //     this.globals.isLoading = false;
    //   }
    },
      (error) => {
        //alert('error');
        this.btn_disable = false;
        this.submitted = false;
        //this.router.navigate(['/pagenotfound']);
      });
    
  }
  finalsubmit() {
    debugger
    $("#demo").html(localStorage.getItem("Userdata"));
    this.pushtime=localStorage.getItem("Userdata");
    this.AsTotaltime;
    alert(this.pushtime);
    alert(this.AsTotaltime);
    this.AssessmenttestService.finalsubmit(this.ResultId, this.globals.authData.UserId,this.AsTotaltime,this.pushtime)
      .then((data) => {
        $('#assessment_preview_modal').modal('hide');
        this.router.navigate(['/assessment-result/' + this.ResultId]);
      },
        (error) => {
          //alert('error');
          this.btn_disable = false;
          this.submitted = false;
          //this.router.navigate(['/pagenotfound']);
        });
  }
}
