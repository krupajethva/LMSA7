import { Component, OnInit, ElementRef } from '@angular/core';
import { Globals } from '.././globals';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { AssessmenttestService } from '../services/assessmenttest.service';
declare var $, html2pdf, html2canvas, saveAs, Date: any;
declare var PerfectScrollbar, Swiper: any;
declare var swal: any;
@Component({
  selector: 'app-assessmentresult',
  templateUrl: './assessmentresult.component.html',
  styleUrls: ['./assessmentresult.component.css']
})
export class AssessmentresultComponent implements OnInit {

  constructor( public globals: Globals, private router: Router, private elem: ElementRef, private route: ActivatedRoute, private AssessmenttestService: AssessmenttestService) { }
  btn_disable;
  ResultEntity;
  submitted;
  CourseEntity;
  Certificate;

  ngOnInit() {
 this.globals.isLoading=true;
    // setTimeout(function () {
    //   $("#badge").click(function () {
    //     html2canvas($("#widget"), {
    //       onrendered: function (canvas) {
    //         var filename = 'badge.png';
    //         var uri = canvas.toDataURL();
    //         var link = document.createElement('a');
    //         if (typeof link.download === 'string') {
    //           link.href = uri;
    //           link.download = filename;

    //           //Firefox requires the link to be in the body
    //           document.body.appendChild(link);

    //           //simulate click
    //           link.click();

    //           //remove the link when done
    //           document.body.removeChild(link);
    //         } else {
    //           window.open(uri);
    //         }
    //       }
    //     });
    //   });
    // }, 500);



    setTimeout(function () {
      $('.modal').on('shown.bs.modal', function () {
        $('.right_content_block').addClass('style_position');
      })
      $('.modal').on('hidden.bs.modal', function () {
        $('.right_content_block').removeClass('style_position');
      });

    }, 500);


    this.CourseEntity = {};
    this.ResultEntity = {};
    let id = this.route.snapshot.paramMap.get('id');
    let name = this.route.snapshot.paramMap.get('name');
   
      if(name=="1")
      {
        this.AssessmenttestService.timeoutsubmit(id,this.globals.authData.UserId)
         .then((data) => {
          this.AssessmenttestService.assessment_result(id)
          .then((data) => {
            debugger
           //this.timeout=true;
                    /* background-image: url({{CourseEntity.Dataurl}}); */
            this.CourseEntity = data['course'];
            this.ResultEntity = data['result'];
            this.Certificate = data['Certificate'];
            var Dataurlsign=this.Certificate.Dataurl;

            swal({
               
              type: 'info',
              title: 'TimeOut!',
              text: "Your Time is Out!!!!.",
              showConfirmButton: false,
              timer: 2500
            })
            var Result = this.ResultEntity.Result;
            var ss = parseInt(Result);
            var Dataurl=this.CourseEntity.Dataurl;
            this.globals.isLoading=false;
            setTimeout(function () {
            $('#baged').css('background-image', 'url(' + Dataurlsign + ')');
            $('#Signature').css('background-image', 'url(' + Dataurl + ')');
            
      }, 500);
            $(".my-progress-bar").circularProgress({
              line_width: 20,
              color: "#5cb85c",
              starting_position: 0, // 12.00 o' clock position, 25 stands for 3.00 o'clock (clock-wise)
              percent: 0, // percent starts from
              percentage: true,
              text: "Your Score"
            }).circularProgress('animate', ss, 5000);
            this.globals.isLoading = false;
  
          },
            (error) => {
              //alert('error');
              this.btn_disable = false;
              this.submitted = false;
              //this.router.navigate(['/pagenotfound']);
            });
               },
    (error) => {
      //alert('error');
      this.btn_disable = false;
      this.submitted = false;
      //this.router.navigate(['/pagenotfound']);
    });
      }else
      { 
        if (id) {
      this.AssessmenttestService.assessment_result(id)
        .then((data) => {debugger
          /* background-image: url({{CourseEntity.Dataurl}}); */
          this.CourseEntity = data['course'];
          this.ResultEntity = data['result'];
          this.Certificate = data['Certificate'];
          var Dataurlsign=this.Certificate.Dataurl;
          var Result = this.ResultEntity.Result;
          var ss = parseInt(Result);
          var Dataurl=this.CourseEntity.Dataurl;
          this.globals.isLoading=false;
          setTimeout(function () {
          $('#baged').css('background-image', 'url(' + Dataurl + ')');
          $('#baged1').css('background-image', 'url(' + Dataurl + ')');
          $('#baged2').css('background-image', 'url(' + Dataurl + ')');
          $('#Signature').css('background-image', 'url(' + Dataurlsign + ')');
          $('#Signature1').css('background-image', 'url(' + Dataurlsign + ')');
          
    }, 500);
          $(".my-progress-bar").circularProgress({
            line_width: 20,
            color: "#5cb85c",
            starting_position: 0, // 12.00 o' clock position, 25 stands for 3.00 o'clock (clock-wise)
            percent: 0, // percent starts from
            percentage: true,
            text: "Your Score"
          }).circularProgress('animate', ss, 5000);
          this.globals.isLoading = false;

        },
          (error) => {
            //alert('error');
            this.btn_disable = false;
            this.submitted = false;
            //this.router.navigate(['/pagenotfound']);
          });

    }
  }




  }

certificate()
{
  $('#assessmentresult_certipreview_modal').modal('show');
}
  test() {
    document.getElementById('root').style.display = "block";
    //document.getElementById('root').style.position = "relative";
    //document.getElementById('root').style.top = "-90px";
    //document.getElementById('root').style.left = "-160px";
    //document.getElementById('root').style.visibility = "visible";
    document.getElementById('root').style.zIndex = "-1";
    setTimeout(function () {
      var element = document.getElementById('root');
      html2pdf().from(element).set({
        margin: 0.5,
        filename: 'test.pdf',
        html2canvas: { scale: 1 },
        jsPDF: { orientation: 'landscape', unit: 'in', format: 'a4', compressPDF: false }
      }).save();
    }, 1000);
  }
  encodeImagetoBase64() {
    $('.image').change(function (e) {
      var file = e.target.files[0];
      var reader = new FileReader();
      reader.onloadend = function () 
      {
        $(".link").attr("href", reader.result);
        $(".link").text(reader.result);
      }
      reader.readAsDataURL(file);
    });
  }


  badge() {
    // alert("aas");
    document.getElementById('widget').style.display = "block";
    setTimeout(function () {
      html2canvas($("#widget"), {
        onrendered: function (canvas) {
          var filename = 'badge.png';
          var uri = canvas.toDataURL();
          var link = document.createElement('a');
          if (typeof link.download === 'string') {
            link.href = uri;
            link.download = filename;

            //Firefox requires the link to be in the body
            document.body.appendChild(link);

            //simulate click
            link.click();

            //remove the link when done
            document.body.removeChild(link);
          } else {
            window.open(uri);
          }
        }
      });
    }, 1000);
  }


  // badge() {

  //   // alert("aas");
  //   document.getElementById('widget').style.display = "block";
  //   setTimeout(function () {
  //     html2canvas($("#widget"), {
  //       onrendered: function (canvas) {
  //         var filename = 'badge.png';
  //         var uri = canvas.toDataURL();
  //         var link = document.createElement('a');
  //         if (typeof link.download === 'string') {
  //           link.href = uri;
  //           link.download = filename;

  //           //Firefox requires the link to be in the body
  //           document.body.appendChild(link);

  //           //simulate click
  //           link.click();

  //           //remove the link when done
  //           document.body.removeChild(link);
  //         } else {
  //           window.open(uri);
  //         }
  //       }
  //     });
  //   }, 1000);
  // }

  // // alert("aas");
  // document.getElementById('widget').style.display = "block";
  // setTimeout(function() {
  //   html2canvas($("#widget"), {
  //     onrendered: function (canvas) {
  //       var filename = 'badge.png';
  //       var uri = canvas.toDataURL();
  //       var link = document.createElement('a');
  //       if (typeof link.download === 'string') {
  //         link.href = uri;
  //         link.download = filename;

  //         //Firefox requires the link to be in the body
  //         document.body.appendChild(link);

  //         //simulate click
  //         link.click();

  //         //remove the link when done
  //         document.body.removeChild(link);
  //       } else {
  //         window.open(uri);
  //       }
  //     }
  //   });
  // }, 1000);
}


