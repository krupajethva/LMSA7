import { Component, OnInit } from '@angular/core';
declare var $: any;

@Component({
  selector: 'app-footer',
  templateUrl: './footer.component.html',
  styleUrls: ['./footer.component.css']
})
export class FooterComponent implements OnInit {

  constructor() { }

  ngOnInit() {
	  /* -- Footer --*/
var currentYear = (new Date()).getFullYear();
$("#footer_year").html(currentYear);
/* --End Footer --*/
	 
  }

}
