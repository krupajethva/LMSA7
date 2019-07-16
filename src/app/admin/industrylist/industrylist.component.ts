import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { IndustryService } from '../services/industry.service';

import { Globals } from '.././globals';

declare var $, swal: any;

@Component({
	selector: 'app-industrylist',
	providers: [IndustryService],
	templateUrl: './industrylist.component.html'

})
export class IndustrylistComponent implements OnInit {

	IndustryList;
	deleteEntity;
	msgflag;
	message;
	type;

	//globals;
	constructor( public globals: Globals, private router: Router, private IndustryService: IndustryService, private route: ActivatedRoute) { }

	ngOnInit() {

		this.globals.isLoading = true;
		this.IndustryService.getAllInd()
			.then((data) => {
				debugger
				this.IndustryList = data;
				this.globals.isLoading = false;
				
					let todaysdate = this.globals.todaysdate;
				setTimeout(function () {
					var table = $('#list_tables').DataTable({
						// scrollY: '55vh',
						responsive: {
							details: {
								display: $.fn.dataTable.Responsive.display.childRowImmediate,
								type: ''
							}
						},
						scrollCollapse: true,
						"oLanguage": {
							"sLengthMenu": "_MENU_ Industries per page",
							"sInfo": "Showing _START_ to _END_ of _TOTAL_ Industries",
							"sInfoFiltered": "(filtered from _MAX_ total Industries)",
							"sInfoEmpty": "Showing 0 to 0 of 0 Industries"
						},
						dom: 'lBfrtip',
						buttons: [
							{
								extend: 'excel',
								title: 'Learning Management System – Industry List – ' + todaysdate,
								filename: 'LearningManagementSystem–IndustryList–' + todaysdate,
								customize: function (xlsx) {
									var source = xlsx.xl['workbook.xml'].getElementsByTagName('sheet')[0];
									source.setAttribute('name', 'LMS-IndustryList');
								},
								exportOptions: {
									columns: [0, 1]
								}
							},
							{
								extend: 'print',
								title: 'Learning Management System –  Industry List – ' + todaysdate,
								exportOptions: {
									columns: [0, 1]
								}
							},
						]
					});

					$('.buttons-excel').attr('data-original-title', 'Export').tooltip();
					$('.buttons-print').attr('data-original-title', 'Print').tooltip();


				}, 100);
				this.globals.isLoading = false;
			},
				(error) => {
					this.globals.isLoading = false;
				});
		this.msgflag = false;

	}

	deleteIndustry(Industry) {
		debugger
		this.deleteEntity = Industry;
		swal({
			title: 'Delete an Industry',
			text: "Are you sure you want to delete this industry?",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes'
		})
			.then((result) => {
				if (result.value) {
					var del = { 'Userid': this.globals.authData.UserId, 'id': Industry.IndustryId };
					this.IndustryService.delete(del)
						.then((data) => {
							let index = this.IndustryList.indexOf(Industry);
							$('#Delete_Modal').modal('hide');
							if (index != -1) {
								this.IndustryList.splice(index, 1);
							}
							swal({

								type: 'success',
								title: 'Deleted!',
							    text: 'Industry has been deleted successfully',
								showConfirmButton: false,
								timer: 3000
							})
						},
							(error) => {
								$('#Delete_Modal').modal('hide');
								if (error.text) {
									swal({
										type: 'error',
										title:'Oops...',
										text: "You can't delete this record because of their dependency!",
										showConfirmButton: false,
										timer: 3000
									})
								}
							});
				}
			})

	}


	isActiveChange(changeEntity, i) {
		debugger
		this.globals.isLoading = true;
		if (this.IndustryList[i].IsActive == 1) {
			this.IndustryList[i].IsActive = 0;
			changeEntity.IsActive = 0;
		} else {
			this.IndustryList[i].IsActive = 1;
			changeEntity.IsActive = 1;
		}
		this.globals.isLoading = true;
		changeEntity.UpdatedBy = 1;

		this.IndustryService.isActiveChange(changeEntity)
			.then((data) => {
				this.globals.isLoading = false;
				swal({

					type: 'success',
					title: 'Industry Updated Successfully!',
					showConfirmButton: false,
					timer: 3000
				})

			},
				(error) => {
					this.globals.isLoading = false;
				});
	}

}
