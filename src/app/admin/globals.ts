import { Injectable } from '@angular/core';
import { JwtHelperService } from '@auth0/angular-jwt';
import { environment } from '../../environments/environment';

@Injectable()
export class Globals { 

  constructor() { }
   
    baseAPIUrl: string = environment.baseUrl+'/api/';  
    baseUrl: string = environment.baseUrl;
    headerpath: string = "{'Content-Type': 'application/json','Accept': 'application/json'}";
    IsLoggedIn: boolean = false;
    isLoading: boolean = false;
    authData = localStorage.getItem('token') ? new JwtHelperService().decodeToken(localStorage.getItem('token')):null;
    msgflag = false;
    message = '';
    type = '';
    IsAdmin = true;
    todaysdate: string = '';
    currentLink: string = '';
    currentLinkName: string = '';
    pageTitle: string = '';
    current_progress: number = 0;
}