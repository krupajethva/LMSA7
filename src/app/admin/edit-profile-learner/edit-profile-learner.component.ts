import { Component, OnInit } from '@angular/core';
declare function myInput() : any;
declare var $,Bloodhound: any;

@Component({
  selector: 'app-edit-profile-learner',
  templateUrl: './edit-profile-learner.component.html',
  styleUrls: ['./edit-profile-learner.component.css']
})
export class EditProfileLearnerComponent implements OnInit {

  constructor() { }

  ngOnInit() {
	  setTimeout(function(){
			if( $(".bg_white_block").hasClass( "ps--active-y" )){  
				$('footer').removeClass('footer_fixed');     
			}      
			else{  
				$('footer').addClass('footer_fixed');    
			}
		},1500);
		myInput();
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
  }

}
