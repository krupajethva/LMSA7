import { Component,ViewEncapsulation  } from '@angular/core';
import { Globals } from './globals';

@Component({
  selector: 'client-root',
  templateUrl: './client.component.html',
  styleUrls: ['./client.component.css'],
	encapsulation: ViewEncapsulation.None
})
export class ClientComponent {
  title = 'app';
  //globals;
  constructor(public globals: Globals) { }
  ngOnInit() {
    //this.globals = this.global;
    
  }
}
