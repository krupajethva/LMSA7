
import { Component, OnInit } from '@angular/core';
import { Globals } from '.././globals';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { ResetpasswordService } from '../services/resetpassword.service';
import { InvitationacceptdeclineService } from '../services/invitationacceptdecline.service';
import { JwtHelperService } from '@auth0/angular-jwt';
declare var $: any;
declare var $, swal: any;
declare function myInput(): any;



@Component({
	selector: 'app-invitationacceptdecline',
	providers: [InvitationacceptdeclineService],
	templateUrl: './invitationacceptdecline.component.html',
	styleUrls: ['./invitationacceptdecline.component.css']
})
export class InvitationacceptdeclineComponent implements OnInit {
	resetEntity;
	submitted;
	btn_disable;
	header;
	Accept;
	constructor(public globals: Globals, private router: Router, private route: ActivatedRoute, private InvitationacceptdeclineService: InvitationacceptdeclineService) { }


	ngOnInit() {
		debugger
		//this.resetEntity = {};
		//myInput();
		let id = this.route.snapshot.paramMap.get('id');
		
		var id1 = new JwtHelperService().decodeToken(id);
		console.log(id1);

		if (id1['type'] == 1) {
			this.Accept = true;
		} else {
			this.Accept = false;
		}

		// this.InvitationacceptdeclineService.AcceptorDecline(id1['type'], id1['CourseSessionId'], id1['UserId'])

		// .then((data) => {
		// 	console.log(data);
		// 	if (data == 'fail') {
		// 		swal({
		// 			type: 'danger',
		// 			title: 'Oops...',
		// 			text: 'You are already used this link!',
		// 			showConfirmButton: false,
		// 			timer: 3000
		// 		})
		// 		this.router.navigate(['/login']);
		// 	}
		// },
		// 	(error) => {
		// 		this.btn_disable = false;
		// 		this.submitted = false;
		// 		this.globals.isLoading = false;
		// 		this.router.navigate(['/pagenotfound']);
		// 	});



		this.InvitationacceptdeclineService.Insinvitation(id1['type'], id1['CourseSessionId'], id1['UserId'])
	
			.then((data) => {
				if (data == 'fail') {
					swal({
						type: 'danger',
						title: 'Oops...',
						text: 'You are already used this link!',
						showConfirmButton: false,
						timer: 3000
					})
					this.router.navigate(['/login']);
				}
			},
				(error) => {
					this.btn_disable = false;
					this.submitted = false;
					this.globals.isLoading = false;
					this.router.navigate(['/pagenotfound']);
				});

	}






}
