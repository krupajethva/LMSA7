import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { Globals } from '.././globals';
import { InstructorfollowersService } from '../services/instructorfollowers.service';
declare var $: any;

@Component({
  selector: 'app-instructorlist',
  templateUrl: './instructorlist.component.html',
  styleUrls: ['./instructorlist.component.css']
})
export class InstructorlistComponent implements OnInit {
  InstructorList;
  constructor( public globals: Globals, private router: Router,private InstructorfollowersService: InstructorfollowersService,private route:ActivatedRoute) { }

  ngOnInit() {
    var obj = {'LearnerId': this.globals.authData.UserId };
    this.InstructorfollowersService.getAllInstructors(obj)
      .then((data) => {
        this.InstructorList = data;
      },
      (error) => {
        // this.globals.isLoading = false;
        this.router.navigate(['/pagenotfound']);
      });
  }
  followInstructor(instructor) {
    debugger
    var follow = { 'InstructorId': instructor.UserId, 'LearnerId': this.globals.authData.UserId };
    this.InstructorfollowersService.followInstructor(follow)
      .then((data) => {
        this.globals.isLoading = false;
      //  $('#follow').hide();
        instructor.flag=1;
        instructor.totalFollowers = instructor.totalFollowers + 1;
      //  $('#unfollow').show();
      },
        (error) => {
          if (error.text) {
            alert("Error");
          }
        });
  }
  unfollowInstructor(instructor) {
    debugger
    var unfollow = { 'InstructorId': instructor.UserId, 'LearnerId': this.globals.authData.UserId };
    this.InstructorfollowersService.unfollowInstructor(unfollow)
      .then((data) => {
        this.globals.isLoading = false;
      //  $('#unfollow').hide();
        instructor.flag=0;
        instructor.totalFollowers = instructor.totalFollowers - 1;
     //   $('#follow').show();
      },
        (error) => {
          if (error.text) {
            alert("Error");
          }
        });
  }
}
