import { Component,ViewEncapsulation } from '@angular/core';
import { Globals } from './globals';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'admin-root',
  templateUrl: './admin.component.html',
  styleUrls: ['./admin.component.css'],
  encapsulation: ViewEncapsulation.None
})
export class AdminComponent {

	
	constructor(private route: ActivatedRoute,public globals: Globals) { }
    
    ngOnInit()
  {


    	
  }
}
