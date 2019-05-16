import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import {HttpClient} from "@angular/common/http";
import { Router } from '@angular/router';

@Injectable()
export class ImageService {

  constructor(private http: HttpClient, private globals: Globals, private router: Router) { }

}
