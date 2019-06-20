import { BrowserModule } from '@angular/platform-browser';
import { Component,NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { EscapeHtmlPipe } from './admin/pipes/keep-html.pipe';
import { AppComponent } from './app.component';
import { HttpClientModule } from '@angular/common/http';



@NgModule({

  declarations: [
		AppComponent,
		EscapeHtmlPipe
		
		
	],	
  imports: [
		BrowserModule,
		FormsModule,
		HttpClientModule,
		RouterModule.forRoot([	
		{
			path: '',
			//canActivate: [AuthGuard],
			loadChildren: './admin/admin.module#AdminModule'
		},	
		{
			path: 'client',
			//canActivate: [AuthGuard],
			loadChildren: './client/client.module#ClientModule'
		}
	])
  ],
	bootstrap: [AppComponent],
})
export class AppModule { }
