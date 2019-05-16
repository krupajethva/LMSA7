import { BrowserModule } from '@angular/platform-browser';
import { Globals } from './globals';
import { Component,NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { CommonModule } from "@angular/common";

import { ClientRoutingModule } from './client-routing.module';

import { ClientComponent } from './client.component.module';

import { HomeComponent } from './home/home.component';

import { HttpClientModule } from '@angular/common/http';

@NgModule({
  declarations: [
    ClientComponent,
	
    HomeComponent,
  
  ],
  imports: [
    CommonModule,
	FormsModule,
	HttpClientModule,
	ClientRoutingModule	
  ]
})
export class ClientModule { }
