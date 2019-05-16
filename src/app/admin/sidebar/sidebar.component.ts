import { Component, OnInit } from '@angular/core';
import { Globals } from '.././globals';
import { Router } from '@angular/router';
import { RolepermissionService } from '../services/rolepermission.service';
declare var $,PerfectScrollbar: any;

@Component({
  selector: 'app-sidebar',
  templateUrl: './sidebar.component.html',
  styleUrls: ['./sidebar.component.css']
})
export class SidebarComponent implements OnInit {

  menuList;
  constructor(public globals: Globals, private router: Router, private RolepermissionService: RolepermissionService) { }

  ngOnInit() {

    this.globals.isLoading = true;
    this.menuList = [];   
    this.RolepermissionService.getLeftMenu(this.globals.authData.RoleId)
			.then((data) => 
			{
        this.menuList = data; 
        //console.log(this.menuList);
        this.globals.isLoading = false;
			},
			(error) => 
			{
        this.globals.isLoading = false;
        this.router.navigate(['/pagenotfound']);
      });	
      
	  $('.left_menu_toggle').click(function(){
		$('.left_menu_toggle i').toggleClass("fa-indent");
		$('.sidebar_wrap').toggleClass("small_menu");
		$('.menu_right').toggleClass("active_right");
		$('footer.footer_fixed').toggleClass("active_footermenu");
		$('footer').toggleClass("footer_sidebaractive");
	});
	    if ($(window).width() <= 834) {
      $('.left_menu_toggle i').addClass("fa-indent");
      $('.sidebar_wrap').addClass("small_menu");
      $('.menu_right').addClass("active_right");
      $('footer').addClass("footer_sidebaractive");
    }
	new PerfectScrollbar('.sidebar_wrap');
  }
  closecollapse(i,j){
    var check = $("#test"+i+j).hasClass("collapsed");
    
    $(".dropdown_menu").addClass("collapsed");
    $(".dropdown_menu").attr("aria-expanded","false");
    $(".collapse").removeClass("in");

    $(".test").removeClass("active");
    $("#test"+i+j).parent().addClass("active");

    if(check){ 
      //alert('yes');
      $("#test"+i+j).removeClass("collapsed");
      $("#test"+i+j).attr("aria-expanded","true");
      $("#collapseExample"+i+j).addClass("in");
    } else {
      //alert('no');
      $("#test"+i+j).addClass("collapsed");
      $("#test"+i+j).attr("aria-expanded","false");
      $("#collapseExample"+i+j).removeClass("in");
    }

  }

  menuopen(path,no,i,j){
    if(no==1){
      $(".dropdown_menu").addClass("collapsed");
      $(".dropdown_menu").attr("aria-expanded","false");
      $(".collapse").removeClass("in");
    } 
    $(".test").removeClass("active");
    $("#test"+i+j).addClass("active");
     this.globals.msgflag = false;	  
     this.globals.currentLink = this.router.url;
     this.router.navigate([path]);
   
   }

}
