import { Component, OnInit } from '@angular/core';
declare var $: any;
@Component({
  selector: 'app-footer-register',
  templateUrl: './footer-register.component.html',
  styleUrls: ['./footer-register.component.css']
})
export class FooterRegisterComponent implements OnInit {
  Globs;
  constructor() { }

  ngOnInit() {
	  /* -- Footer --*/
var currentYear = (new Date()).getFullYear();
$("#footer_year").html(currentYear);
/* --End Footer --*/
  }

}
