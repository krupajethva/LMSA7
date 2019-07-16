import { Component, OnInit } from '@angular/core';
import { CourseListService } from '../services/course-list.service';
import { Globals } from '.././globals';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
declare var $, swal, paypal, getAccordion: any;
declare function myInput(): any;

@Component({
  selector: 'app-course-discussion',
  templateUrl: './course-discussion.component.html',
  styleUrls: ['./course-discussion.component.css']
})
export class CourseDiscussionComponent implements OnInit {

  errorText;
  allowUser;
  postEntity;
  reviewEntity;
  courseid;
  UserDetail;
  CourseDiscussionList;
  CourseReviewList;
  ReviewAverage;
  Relatedcourse;
  CourseContent;
  submitted;
  btn_disable;
  disabled;
  CourseName;


  constructor(private CourseListService: CourseListService, private globals: Globals, private router: Router, private route: ActivatedRoute) { }

  ngOnInit() {
    this.errorText = false;
    this.allowUser = false;
	 myInput();

    setTimeout(function () {
      if ($(".bg_white_block").hasClass("ps--active-y")) {
        $('footer').removeClass('footer_fixed');
      }
      else {
        $('footer').addClass('footer_fixed');
      }
      getAccordion("#tabs", 768);

    }, 1000);
    this.postEntity = {};
    this.reviewEntity={};
    let id1 = this.route.snapshot.paramMap.get('id');
    this.courseid = id1;
    var obj = { 'CourseId': this.route.snapshot.paramMap.get('id'), 'UserId': this.globals.authData.UserId };
    this.CourseListService.checkUser(obj)
      .then((data) => {
        if(data=="Duplicate User"){
          this.allowUser=true;
        }
      },
        (error) => {
          
        });

        this.CourseListService.getUserDetail(this.globals.authData.UserId)
        
        .then((data) => {
          this.UserDetail=data;
        },
          (error) => {
            
          });
          this.CourseListService.getAllDiscussions(id1)
      
      .then((data) => {
        this.CourseDiscussionList = data['discussion'];
        this.CourseName = data['CourseName'];
       
      },
        (error) => {
          
        });
  }
  start_discusion(){
    this.postEntity={};
    $('.write_discusion').toggle(100);
    $('.write_reply').hide(100);
    $('.edit_reply').hide(100);
    $('.content_name .content').show(100);
  }
  addPost(postForm,discussion) {
    let id = this.route.snapshot.paramMap.get('id');
    this.submitted = true;
    if(discussion==0){
      this.postEntity.count = 0;
      this.postEntity.CreatedBy = this.globals.authData.UserId;
    }    
    
    this.postEntity.UpdatedBy = this.globals.authData.UserId;
    this.postEntity.UserId = this.globals.authData.UserId;
    this.postEntity.CourseId = id;
    this.globals.isLoading = true;
    if (postForm.valid) {
      this.CourseListService.addPost(this.postEntity)
        .then((data) => {
          debugger
          this.globals.isLoading = false;
          this.postEntity.DiscussionId = data['DiscussionId'];
          this.postEntity.PostTime = data['PostTime'];
          //this.CourseDiscussionList.push(this.postEntity);
          this.postEntity.Name = this.UserDetail.Name;
          this.postEntity.UserImage = this.UserDetail.UserImage;
          if(discussion==0){
            this.CourseDiscussionList.unshift(this.postEntity);
            $('.write_discusion').toggle(100);
          } else {
            var index =  this.CourseDiscussionList.indexOf(discussion);
            this.CourseDiscussionList[index].PostTime=this.postEntity.PostTime;
            this.CourseDiscussionList[index].Comment=this.postEntity.Comment;
            $('#content'+index+' .content').show(100);
            $('#edit_reply'+index).toggle(100);
          }
          
          this.btn_disable = false;
          this.submitted = false;
          this.disabled = false;
          this.postEntity = {};
         
          postForm.form.markAsPristine();

          if(discussion==0){
            swal({
             
              type: 'success',
              title: 'Added!',
              text: 'Your comment has been added successfully',
              showConfirmButton: false,
              timer: 1500
            })
          }
          else{
            swal({
              type: 'success',
              title: 'Updated!',
              text: 'Your comment has been updated successfully',
              showConfirmButton: false,
              timer: 1500
            })
          }

          //this.router.navigate(['/announcementlist']);
        },
          (error) => {
            this.btn_disable = false;
            this.submitted = false;
            this.globals.isLoading = false;
            this.router.navigate(['/pagenotfound']);
          });
    }
  }
  addCommentReply(replyForm,Discussion,firstlevelreply,secondlevelreply,ReplyEdit) {
    //alert(firstlevelreply);
    debugger
    let id = this.route.snapshot.paramMap.get('id');
    this.submitted = true;
    
    this.postEntity.UpdatedBy = this.globals.authData.UserId;
    this.postEntity.UserId = this.globals.authData.UserId;
    this.postEntity.CourseId = id;
    if(firstlevelreply==0 && secondlevelreply==0 && ReplyEdit==1){
      this.postEntity.count = 0;
      this.postEntity.ParentId = Discussion.DiscussionId;
      this.postEntity.CreatedBy = this.globals.authData.UserId;
    } else if(firstlevelreply!=0 && secondlevelreply==0 && ReplyEdit==1) {
      this.postEntity.count = 0;
      this.postEntity.ParentId = firstlevelreply.DiscussionId;
      this.postEntity.CreatedBy = this.globals.authData.UserId;
    }
    this.globals.isLoading = true;
    if (replyForm.valid) {
      this.CourseListService.addCommentReply(this.postEntity)
        .then((data) => {
          this.globals.isLoading = false;
          if(ReplyEdit==1){
          this.postEntity.DiscussionId = data['DiscussionId'];
          this.postEntity.PostTime = data['PostTime'];
          this.postEntity.Name = this.UserDetail.Name;
          this.postEntity.UserImage = this.UserDetail.UserImage;
          this.postEntity.Reply = this.postEntity.CommentReply;
          }
          else{
            this.postEntity.PostTime = data['PostTime'];
            this.postEntity.Reply = this.postEntity.CommentReply;
          }
          //this.CourseDiscussionList.push(this.postEntity);

          if(firstlevelreply==0 && secondlevelreply==0 && ReplyEdit==1){
            let index = this.CourseDiscussionList.indexOf(Discussion);
            if(this.CourseDiscussionList[index].child==undefined){
              this.CourseDiscussionList[index].child=[];
            }
            this.CourseDiscussionList[index].child.unshift(this.postEntity);
            this.CourseDiscussionList[index].count++;
            $('#write_reply'+index).hide(100);
          } 
          else if(firstlevelreply!=0 && secondlevelreply==0 && ReplyEdit==1) {
            let index = this.CourseDiscussionList.indexOf(Discussion);
            let index_child = this.CourseDiscussionList[index].child.indexOf(firstlevelreply);
            if(this.CourseDiscussionList[index].child[index_child].child==undefined){
              this.CourseDiscussionList[index].child[index_child].child=[];
            }
            this.CourseDiscussionList[index].child[index_child].child.unshift(this.postEntity);
            this.CourseDiscussionList[index].child[index_child].count++;
            $('#write_reply'+index+index_child).hide(100);
          }
          else if(firstlevelreply!=0 && secondlevelreply==0 && ReplyEdit==2) {
            let index = this.CourseDiscussionList.indexOf(Discussion);
            let index_child = this.CourseDiscussionList[index].child.indexOf(firstlevelreply);
            
            this.CourseDiscussionList[index].child[index_child].PostTime=this.postEntity.PostTime;
            this.CourseDiscussionList[index].child[index_child].CommentReply=this.postEntity.CommentReply;

            //this.CourseDiscussionList[index].child[index_child].count++;
            $('#edit_reply'+index+index_child).hide(100);
            $('#content'+index+index_child+' .content').show(100);
          }
          else if(firstlevelreply!=0 && secondlevelreply!=0 && ReplyEdit==2) {
            let index = this.CourseDiscussionList.indexOf(Discussion);
            let index_child = this.CourseDiscussionList[index].child.indexOf(firstlevelreply);
            let index_c_child = this.CourseDiscussionList[index].child[index_child].child.indexOf(secondlevelreply);
           
            this.CourseDiscussionList[index].child[index_child].child[index_c_child].PostTime=this.postEntity.PostTime;
            this.CourseDiscussionList[index].child[index_child].child[index_c_child].CommentReply=this.postEntity.CommentReply;

           // this.CourseDiscussionList[index].child[index_child].count++;
            $('#edit_reply'+index+index_child+index_c_child).hide(100);
            $('#content'+index+index_child+index_c_child+' .content').show(100);
          }
         
          this.btn_disable = false;
          this.submitted = false;
          this.disabled = false;
          this.postEntity = {};
          //$(this).next().next().toggle(400);
          replyForm.form.markAsPristine();

          if(ReplyEdit==1){
            swal({
              type: 'success',
              title: 'Added!',
              text: 'Your reply has been added successfully',
              showConfirmButton: false,
              timer: 1500
            })
          }
          else{
            swal({
             
              type: 'success',
              title: 'Updated!',
              text: 'Your reply has been updated successfully',
              showConfirmButton: false,
              timer: 1500
            })
          }

          //this.router.navigate(['/announcementlist']);
        },
          (error) => {
            this.btn_disable = false;
            this.submitted = false;
            this.globals.isLoading = false;
            this.router.navigate(['/pagenotfound']);
          });
    }
  }

  openCommentBox(i){
    this.postEntity = {};
    //replyForm.form.markAsPristine();
    setTimeout(function () {
        myInput();
    }, 100);
    if($('#write_reply'+i).is(':visible')){
      var check = true;
    } else {
      var check = false;
    }
    $('.write_reply').hide(100);
    $('.edit_reply').hide(100);
    $('.content_name .content').show(100);

    if(check){
      $('#write_reply'+i).hide(100);
    } else {
      $('#write_reply'+i).show(100);
    }
    
  }

  openCommentReplyBox(i,j){
    this.postEntity = {};
    //replyForm.form.markAsPristine();
      setTimeout(function () {
        myInput();
    }, 100);
    if($('#write_reply'+i+j).is(':visible')){
      var check = true;
    } else {
      var check = false;
    }
    $('.write_reply').hide(100);
    $('.edit_reply').hide(100);
    $('.content_name .content').show(100);
    if(check){
      $('#write_reply'+i+j).hide(100);
    } else {
      $('#write_reply'+i+j).show(100);
    }
  }
  editDiscussion(discussion,i){
    debugger
    this.postEntity=discussion;
    //console.log(this.postEntity);

    if($('#edit_reply'+i).is(':visible')){
      var check = true;
    } else {
      var check = false;
    }
    $('.write_reply').hide(100);
    $('.edit_reply').hide(100);
    $('.content_name .content').show(100);
    if(check){
      $('#edit_reply'+i).hide(100);
      $('#content'+i+' .content').show(100);
    } else {
      $('#edit_reply'+i).show(100);
      $('#content'+i+' .content').hide(100);
    }
    $('.write_discusion').hide(100);
    setTimeout(function () {
      myInput();
  }, 100);
  }
  editReply(firstlevelreply,i,j){
    debugger
    this.postEntity=firstlevelreply;
    this.postEntity.CommentReply=firstlevelreply.Reply;
    console.log(this.postEntity);

    if($('#edit_reply'+i+j).is(':visible')){
      var check = true;
    } else {
      var check = false;
    }
    $('.write_reply').hide(100);
    $('.edit_reply').hide(100);
    $('.content_name .content').show(100);
    if(check){
      $('#edit_reply'+i+j).hide(100);
      $('#content'+i+j+' .content').show(100);
    } else {
      $('#edit_reply'+i+j).show(100);
      $('#content'+i+j+' .content').hide(100);
    }   
    $('.write_discusion').hide(100);
    setTimeout(function () {
      myInput();
  }, 100);
  }
  editReplyReply(secondlevelreply,i,j,k){
    debugger
    this.postEntity=secondlevelreply;
    this.postEntity.CommentReply=secondlevelreply.Reply;
    console.log(this.postEntity);

    if($('#edit_reply'+i+j+k).is(':visible')){
      var check = true;
    } else {
      var check = false;
    }
    $('.write_reply').hide(100);
    $('.edit_reply').hide(100);
    $('.content_name .content').show(100);
    if(check){
      $('#edit_reply'+i+j+k).hide(100);
      $('#content'+i+j+k+' .content').show(100);
    } else {
      $('#edit_reply'+i+j+k).show(100);
      $('#content'+i+j+k+' .content').hide(100);
    }   
    $('.write_discusion').hide(100);
    setTimeout(function () {
      myInput();
  }, 100);
  }
  deleteDiscussion(discussion,firstreply,secondreply,levelId){
    debugger
    swal({
      title: 'Delete a Comment',
      text: "Are you sure you want to delete this comment?",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes',
      cancelButtonText: 'No'
    })
      .then((result) => {
        if (result.value) {
          this.globals.isLoading = true;
          //alert(discussion.DiscussionId);
          this.CourseListService.deleteDiscussion(discussion.DiscussionId)
            .then((data) => {
              
              if(levelId==1){          
                let index = this.CourseDiscussionList.indexOf(discussion);      
                if (index != -1) {
                  this.CourseDiscussionList.splice(index, 1);
                }
              }
              if(levelId==2){
                let index = this.CourseDiscussionList.indexOf(firstreply);
                let index_child = this.CourseDiscussionList[index].child.indexOf(discussion);
                if (index_child != -1) {
                  this.CourseDiscussionList[index].child.splice(index_child, 1);
                  this.CourseDiscussionList[index].count--;
                }
              }
              if(levelId==3){
                let index = this.CourseDiscussionList.indexOf(firstreply);
                let index_child = this.CourseDiscussionList[index].child.indexOf(secondreply);
                let index_child_child = this.CourseDiscussionList[index].child[index_child].child.indexOf(discussion);
                if (index_child_child != -1) {
                  this.CourseDiscussionList[index].child[index_child].child.splice(index_child_child, 1);
                  this.CourseDiscussionList[index].child[index_child].count--;
                }
              }
              
              this.allowUser=false;
              this.globals.isLoading = false;
              swal({
                type: 'success',
                title: 'Deleted!',
                text: 'Your comment has been deleted successfully',
                showConfirmButton: false,
                timer: 1500
              })
            },
              (error) => {
              });
        }
      })
  }

}
