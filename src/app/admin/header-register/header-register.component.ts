import { Component, OnInit } from '@angular/core';
declare var $: any;

@Component({
  selector: 'app-header-register',
  templateUrl: './header-register.component.html',
  styleUrls: ['./header-register.component.css']
})
export class HeaderRegisterComponent implements OnInit {

  constructor() { }

  ngOnInit() {
	  $('body').tooltip({
        selector: '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])',
        trigger: 'hover',
        container: 'body'
    }).on('click mousedown mouseup', '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])', function () {
        $('[data-toggle="tooltip"], [title]:not([data-toggle="popover"])').tooltip('destroy');
    });	 
	const body = document.querySelector('body');
	body.style.setProperty('--screen-height', $(window).height()+"px");
  }

}
