import { BrowserModule } from '@angular/platform-browser';
import { Globals } from './globals';
import { Component,NgModule } from '@angular/core';
import { Routes,RouterModule } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { CommonModule } from "@angular/common";

import { ClientComponent  } from './client.component.module';
import { HomeComponent } from './home/home.component';
import { HttpClientModule } from '@angular/common/http';

const routes: Routes = [	
	{
		path: '',
			component: ClientComponent,
			children: [
				
				// { path: 'dashboard', component : DashbordComponent },				
				{ path : 'home', component : HomeComponent  }
				
				
			]
	}
];
  
 @NgModule({
	imports: [RouterModule.forChild(routes)],
	exports: [RouterModule],
	providers: [Globals
	
	],

	bootstrap: [ClientComponent]
})
export class ClientRoutingModule { }
