import { Component, OnInit, ElementRef } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { Globals } from '.././globals';
import { AuthService } from '../services/auth.service';
import { EditProfileService } from '../services/edit-profile.service';

declare var $, swal: any;
declare function myInput(): any;
declare var $, Bloodhound: any;

@Component({
	selector: 'app-edit-profile-admin',
	templateUrl: './edit-profile-admin.component.html',
	styleUrls: ['./edit-profile-admin.component.css']
})
export class EditProfileAdminComponent implements OnInit {

	newpassEntity;
	same;
	submitted2;
	btn_disable2;
	CompanyEntity;
	RegisterEntity;
	submitted;
	btn_disable;
	submitted1;
	btn_disable1;
	CountryList;
	StateList;
	EducationLeveList;
	oldnewsame;
	UserImage_error;
	sameskill;
	IndustryList;
	CompanyList;
	IndustryEntity;
	EducationEntity;
	CertificateEntity;
	autocompleteItems;


	constructor(private elem: ElementRef, private authService: AuthService,  public globals: Globals, private router: Router, private EditProfileService: EditProfileService, private route: ActivatedRoute) { }



	ngOnInit() {

		setTimeout(function () {
			$('#Signature').change(function (e) {
			
				
				var file = e.target.files[0];
				var reader = new FileReader();
				reader.onloadend = function () 
				{
				
				$(".link1").attr("href", reader.result);
				  $(".link1").text(reader.result);

				}
				reader.readAsDataURL(file);
			  });
			if ($(".bg_white_block").hasClass("ps--active-y")) {
				$('footer').removeClass('footer_fixed');
			}
			else {
				$('footer').addClass('footer_fixed');
			}
		}, 100);


		this.newpassEntity = {};
		this.globals.isLoading = true;
		this.btn_disable = false;
		this.RegisterEntity = {};
		this.RegisterEntity.CountryId = '';
		this.RegisterEntity.StateId = '';
		this.newpassEntity = {};
		this.CompanyEntity = {};
		this.IndustryEntity = {};
		this.EducationEntity = {};

		debugger
		this.EditProfileService.getDefaultData()
			.then((data) => {
				this.IndustryList = data['industry'];
				this.CountryList = data['country'];
				this.StateList = data['state'];
				this.EducationLeveList = data['educationLevel'];
				this.autocompleteItems = data['skills'];
				this.EditProfileService.getProfileById(this.globals.authData.UserId)
					.then((data) => {
						this.RegisterEntity = data['user'];
						console.log(this.RegisterEntity);
						this.CompanyEntity = data['user'];
						// alert(this.RegisterEntity.ProfileImage);
						this.EditProfileService.getEducationDetail(this.globals.authData.UserId)
							.then((data) => {
								this.EducationEntity = data['EducationDetails'];
								this.CertificateEntity = data['EducationCertificates'];
								console.log(data);
								setTimeout(function () {
									myInput();
								}, 100);
								if(this.EducationEntity.Skills!=null){
									this.EducationEntity.Skills = this.EducationEntity.Skills.split(","); 	//convert comma seperated string to array
								}
								
								this.countProgressBar();
							},
								(error) => {
									this.globals.isLoading = false;
								});
					},
						(error) => {
							this.globals.isLoading = false;
						});
			},
				(error) => {
					this.globals.isLoading = false;
				});
		setTimeout(function () {
			$('input[type="file"]').imageuploadify();
			myInput();
			$("")
		}, 100);
	}
	replaceImage() {
		var input = this.elem.nativeElement.querySelector('#UsereditImageId');
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			var filename = $("#UsereditImageId").val();
			this.RegisterEntity.ProfileImage = Date.now() + '_' + filename;
			filename = filename.substring(filename.lastIndexOf('\\') + 1);
			reader.onload = (e: Event) => {
				$('#ProfilePhotoPreview').attr('src', e.target["result"]);
				$('#ProfilePhotoPreview').hide();
				$('#ProfilePhotoPreview').fadeIn(500);
				$('.custom-file-label').text(filename);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	replaceSignature() {

		var input = this.elem.nativeElement.querySelector('#Signature');
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			var filename = $("#Signature").val();
			this.RegisterEntity.Signature = Date.now() + '_' + filename;
			filename = filename.substring(filename.lastIndexOf('\\') + 1);
			reader.onload = (e: Event) => {
				$('#SignaturePreview').attr('src', e.target["result"]);
				$('#SignaturePreview').hide();
				$('#SignaturePreview').fadeIn(500);
				$('.custom-file-label').text(filename);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	countProgressBar() {
		var current_progress = 0;
		if (this.globals.authData.RoleId == 2 || this.globals.authData.RoleId == 1) {
			if (this.RegisterEntity.FirstName != '' && this.RegisterEntity.FirstName != null) {
				current_progress += 8;
			}
			if (this.RegisterEntity.LastName != '' && this.RegisterEntity.LastName != null) {
				current_progress += 8;
			}
			if (this.RegisterEntity.Title != '' && this.RegisterEntity.Title != null) {
				current_progress += 8;
			}
			if (this.RegisterEntity.EmailAddress != '' && this.RegisterEntity.EmailAddress != null) {
				current_progress += 8;
			}
			if (this.RegisterEntity.PhoneNumber != '' && this.RegisterEntity.PhoneNumber != null) {
				current_progress += 8;
			}
			if (this.RegisterEntity.PhoneNumber2 != '' && this.RegisterEntity.PhoneNumber2 != null) {
				current_progress += 8;
			}
			if (this.RegisterEntity.ProfileImage != '' && this.RegisterEntity.ProfileImage != null) {
				current_progress += 8;
			}
			// if (this.RegisterEntity.Biography != '' && this.RegisterEntity.Biography != null) {
			// 	current_progress += 7;
			// }
			if (this.RegisterEntity.Address1 != '' && this.RegisterEntity.Address1 != null) {
				current_progress += 8;
			}
			if (this.RegisterEntity.Address2 != '' && this.RegisterEntity.Address2 != null) {
				current_progress += 8;
			}
			if (this.RegisterEntity.CountryId != '' && this.RegisterEntity.CountryId != null) {
				current_progress += 7;
			}
			if (this.RegisterEntity.StateId != '' && this.RegisterEntity.StateId != null) {
				current_progress += 7;
			}
			if (this.RegisterEntity.City != '' && this.RegisterEntity.City != null) {
				current_progress += 7;
			}
			if (this.RegisterEntity.ZipCode != '' && this.RegisterEntity.ZipCode != null) {
				current_progress += 7;
			}
			// if (this.RegisterEntity.Name != '' && this.RegisterEntity.Name != null) {
			// 	current_progress += 5;
			// }
			// if (this.RegisterEntity.EmailAddressCom != '' && this.RegisterEntity.EmailAddressCom != null) {
			// 	current_progress += 5;
			// }
			// if (this.RegisterEntity.Website != '' && this.RegisterEntity.Website != null) {
			// 	current_progress += 3;
			// }
			// if (this.RegisterEntity.IndustryName != '' && this.RegisterEntity.IndustryName != null) {
			// 	current_progress += 2;
			// }
			// if (this.RegisterEntity.Address12 != '' && this.RegisterEntity.Address12 != null) {
			// 	current_progress += 3;
			// }
			// if (this.RegisterEntity.Address22 != '' && this.RegisterEntity.Address22 != null) {
			// 	current_progress += 2;
			// }
			// if (this.RegisterEntity.cid != '' && this.RegisterEntity.cid != null) {
			// 	current_progress += 5;
			// }
			// if (this.RegisterEntity.sid != '' && this.RegisterEntity.sid != null) {
			// 	current_progress += 5;
			// }
			// if (this.RegisterEntity.City2 != '' && this.RegisterEntity.City2 != null) {
			// 	current_progress += 2;
			// }
			// if (this.RegisterEntity.ZipCode2 != '' && this.RegisterEntity.ZipCode2 != null) {
			// 	current_progress += 3;
			// }
		}

		if (this.globals.authData.RoleId == 3) {
			if (this.RegisterEntity.FirstName != '' && this.RegisterEntity.FirstName != null) {
				current_progress += 10;
			}
			if (this.RegisterEntity.LastName != '' && this.RegisterEntity.LastName != null) {
				current_progress += 10;
			}
			if (this.RegisterEntity.Title != '' && this.RegisterEntity.Title != null) {
				current_progress += 5;
			}
			if (this.RegisterEntity.EmailAddress != '' && this.RegisterEntity.EmailAddress != null) {
				current_progress += 5;
			}
			if (this.RegisterEntity.PhoneNumber != '' && this.RegisterEntity.PhoneNumber != null) {
				current_progress += 5;
			}
			if (this.RegisterEntity.PhoneNumber2 != '' && this.RegisterEntity.PhoneNumber2 != null) {
				current_progress += 5;
			}
			if (this.RegisterEntity.ProfileImage != '' && this.RegisterEntity.ProfileImage != null) {
				current_progress += 5;
			}
			if (this.RegisterEntity.Biography != '' && this.RegisterEntity.Biography != null) {
				current_progress += 5;
			}
			if (this.RegisterEntity.Address1 != '' && this.RegisterEntity.Address1 != null) {
				current_progress += 5;
			}
			if (this.RegisterEntity.Address2 != '' && this.RegisterEntity.Address2 != null) {
				current_progress += 5;
			}
			if (this.RegisterEntity.CountryId != '' && this.RegisterEntity.CountryId != null) {
				current_progress += 5;
			}
			if (this.RegisterEntity.StateId != '' && this.RegisterEntity.StateId != null) {
				current_progress += 5;
			}
			if (this.RegisterEntity.City != '' && this.RegisterEntity.City != null) {
				current_progress += 5;
			}
			if (this.RegisterEntity.ZipCode != '' && this.RegisterEntity.ZipCode != null) {
				current_progress += 5;
			}
			if (this.RegisterEntity.Education != '' && this.RegisterEntity.Education != null) {
				current_progress += 5;
			}
			if (this.RegisterEntity.Field != '' && this.RegisterEntity.Field != null) {
				current_progress += 5;
			}
			if (this.RegisterEntity.Certificate != '' && this.RegisterEntity.Certificate != null) {
				current_progress += 10;
			}
		}

		if (this.globals.authData.RoleId == 4) {
			if (this.RegisterEntity.FirstName != '' && this.RegisterEntity.FirstName != null) {
				current_progress += 10;
			}
			if (this.RegisterEntity.LastName != '' && this.RegisterEntity.LastName != null) {
				current_progress += 10;
			}
			if (this.RegisterEntity.Title != '' && this.RegisterEntity.Title != null) {
				current_progress += 6;
			}
			if (this.RegisterEntity.EmailAddress != '' && this.RegisterEntity.EmailAddress != null) {
				current_progress += 6;
			}
			if (this.RegisterEntity.PhoneNumber != '' && this.RegisterEntity.PhoneNumber != null) {
				current_progress += 6;
			}
			if (this.RegisterEntity.PhoneNumber2 != '' && this.RegisterEntity.PhoneNumber2 != null) {
				current_progress += 6;
			}
			if (this.RegisterEntity.ProfileImage != '' && this.RegisterEntity.ProfileImage != null) {
				current_progress += 6;
			}
			// if (this.RegisterEntity.Biography != '' && this.RegisterEntity.Biography != null) {
			// 	current_progress += 5;
			// }
			if (this.RegisterEntity.Address1 != '' && this.RegisterEntity.Address1 != null) {
				current_progress += 5;
			}
			if (this.RegisterEntity.Address2 != '' && this.RegisterEntity.Address2 != null) {
				current_progress += 5;
			}
			if (this.RegisterEntity.CountryId != '' && this.RegisterEntity.CountryId != null) {
				current_progress += 5;
			}
			if (this.RegisterEntity.StateId != '' && this.RegisterEntity.StateId != null) {
				current_progress += 5;
			}
			if (this.RegisterEntity.City != '' && this.RegisterEntity.City != null) {
				current_progress += 5;
			}
			if (this.RegisterEntity.ZipCode != '' && this.RegisterEntity.ZipCode != null) {
				current_progress += 5;
			}
			if (this.RegisterEntity.Education != '' && this.RegisterEntity.Education != null) {
				current_progress += 5;
			}
			if (this.RegisterEntity.Field != '' && this.RegisterEntity.Field != null) {
				current_progress += 5;
			}
			if (this.RegisterEntity.Skills != '' && this.RegisterEntity.Skills != null) {
				current_progress += 10;
			}
		}

		if (this.globals.authData.RoleId == 5) {
			if (this.RegisterEntity.FirstName != '' && this.RegisterEntity.FirstName != null) {
				current_progress += 10;
			}
			if (this.RegisterEntity.LastName != '' && this.RegisterEntity.LastName != null) {
				current_progress += 10;
			}
			if (this.RegisterEntity.Title != '' && this.RegisterEntity.Title != null) {
				current_progress += 10;
			}
			if (this.RegisterEntity.EmailAddress != '' && this.RegisterEntity.EmailAddress != null) {
				current_progress += 10;
			}
			if (this.RegisterEntity.PhoneNumber != '' && this.RegisterEntity.PhoneNumber != null) {
				current_progress += 6;
			}
			if (this.RegisterEntity.PhoneNumber2 != '' && this.RegisterEntity.PhoneNumber2 != null) {
				current_progress += 10;
			}
			if (this.RegisterEntity.ProfileImage != '' && this.RegisterEntity.ProfileImage != null) {
				current_progress += 10;
			}
			// if (this.RegisterEntity.Biography != '' && this.RegisterEntity.Biography != null) {
			// 	current_progress += 5;
			// }
			if (this.RegisterEntity.Address1 != '' && this.RegisterEntity.Address1 != null) {
				current_progress += 6;
			}
			if (this.RegisterEntity.Address2 != '' && this.RegisterEntity.Address2 != null) {
				current_progress += 6;
			}
			if (this.RegisterEntity.CountryId != '' && this.RegisterEntity.CountryId != null) {
				current_progress += 6;
			}
			if (this.RegisterEntity.StateId != '' && this.RegisterEntity.StateId != null) {
				current_progress += 6;
			}
			if (this.RegisterEntity.City != '' && this.RegisterEntity.City != null) {
				current_progress += 5;
			}
			if (this.RegisterEntity.ZipCode != '' && this.RegisterEntity.ZipCode != null) {
				current_progress += 5;
			}

		}


		this.globals.current_progress = current_progress;
		setTimeout(function () {
			$("#dynamic")
				.css("width", current_progress + "%")
				.attr("aria-valuenow", current_progress)
				.text(current_progress + "% Complete");

			$("#dynamic2")
				.css("width", current_progress + "%")
				.attr("aria-valuenow", current_progress)
				.text(current_progress + "% Complete");
		}, 1000);
		this.globals.isLoading = false;
	}

	editprofile(RegisterForm) {
		debugger
		this.RegisterEntity.Dataurl=$('.link1').attr('href');
		this.submitted = true;

		if (RegisterForm.valid) {

			let profileImage = this.elem.nativeElement.querySelector('#UsereditImageId').files[0];
			var profilefd = new FormData();
			if (profileImage) {
				var ProfileImage = Date.now() + '_' + profileImage['name'];
				profilefd.append('ProfileImage', profileImage, ProfileImage);
				this.RegisterEntity.ProfileImage = ProfileImage;
			} else {
				profilefd.append('ProfileImage', null);
				this.RegisterEntity.ProfileImage = null;
			}

			let signatureImage;

			if (this.globals.authData.RoleId == 3) {
				let signatureImage = this.elem.nativeElement.querySelector('#Signature').files[0];
				var signaturefd = new FormData();
				if (signatureImage) {
					var Signature = Date.now() + '_' + signatureImage['name'];
					signaturefd.append('Signature', signatureImage, Signature);
					this.RegisterEntity.Signature = Signature;
				} else {
					signaturefd.append('Signature', null);
					this.RegisterEntity.Signature = null;
				}
			}


			this.btn_disable = true;
			this.globals.isLoading = true;
			this.EditProfileService.editprofile(this.RegisterEntity)
				.then((data) => {
					if (profileImage) {
						this.EditProfileService.uploadProfilePicture(profilefd, this.globals.authData.UserId)
							.then((data) => {
								$("#UsereditImageId").val(null);
							},
								(error) => {
									this.btn_disable = false;
									this.submitted = false;
									this.globals.isLoading = false;
									this.router.navigate(['/pagenotfound']);
								});
					}
					if (this.globals.authData.RoleId == 3) {
					
							this.EditProfileService.uploadSignature(signaturefd, this.globals.authData.UserId)
								.then((data) => {
									$("#Signature").val(null);
								},
									(error) => {
										this.btn_disable = false;
										this.submitted = false;
										this.globals.isLoading = false;
										this.router.navigate(['/pagenotfound']);
									});
						
					}

					RegisterForm.form.markAsPristine();
					swal({
						type: 'success',
						title: 'Updated!',
						text: 'Your profile has been updated successfully.',
						showConfirmButton: false,
						timer: 3000
					})
					this.globals.isLoading = false;
					this.btn_disable = false;
					this.submitted = false;
					this.RegisterEntity = {};
					this.countProgressBar();
					window.location.href = '/edit-profile-admin';
				},
					(error) => {
						this.btn_disable = false;
						this.submitted = false;
						this.globals.isLoading = false;
						this.router.navigate(['/pagenotfound']);
					});
		}
	}

	updateEducationDetails(eduForm) {

		debugger
		myInput();
		this.submitted1 = false;
		var error_count = 0;

		if (this.globals.authData.RoleId == 4) {

			if (this.EducationEntity.Skills == "" || this.EducationEntity.Skills == null || this.EducationEntity.Skills == undefined) {
				this.sameskill = true;
				error_count += 1;
			} else {
				this.sameskill = false;
			}
		} else {
			this.EducationEntity.Skills = null;
		}
		if (eduForm.valid && error_count == 0) {
			console.log(this.EducationEntity.Skills);
			this.EducationEntity.Skills = this.EducationEntity.Skills.join();
			console.log(this.EducationEntity.Skills);
			this.btn_disable1 = true;
			this.globals.isLoading = true;
			let file1 = null;
			var fd = new FormData();
			if (this.globals.authData.RoleId == 3) {
				let file1 = this.elem.nativeElement.querySelector('#CertificateId').files;
			}
			this.EducationEntity.Certificate = [];
			if (file1 != null) {
				for (var i = 0; i < file1.length; i++) {
					var Certificate = Date.now() + '_' + file1[i]['name'];
					fd.append('Certificate' + i, file1[i], Certificate);
					this.EducationEntity.Certificate.push(Certificate);
				}
				this.EducationEntity.UserId = this.globals.authData.UserId;
				this.EditProfileService.updateEducationDetails(this.EducationEntity)
					.then((data) => {
						this.globals.isLoading = false;
						this.btn_disable1 = false;
						this.submitted1 = false;
						this.EducationEntity.Skills = this.EducationEntity.Skills.split(',');
						console.log(this.EducationEntity.Skills);

						if (file1) {
							this.EditProfileService.uploadFileCertificate(fd, this.globals.authData.UserId)
								.then((data) => {
									$("#CertificateId").val(null);
									eduForm.form.markAsPristine();
									swal({
										type: 'success',
										title: 'Updated!',
										text: 'Profile has been updated successfully!',
										showConfirmButton: false,
										timer: 3000
									})
									window.location.href = '/edit-profile-admin';
								},
									(error) => {
										this.btn_disable1 = false;
										this.submitted1 = false;
										this.globals.isLoading = false;
									});
						}
						else {
							swal({
								type: 'success',
								title: 'Updated!',
								text: 'Profile has been updated successfully!',
								showConfirmButton: false,
								timer: 3000
							})
						}

					},
						(error) => {
							this.btn_disable1 = false;
							this.submitted1 = false;
							this.globals.isLoading = false;
						});


			} else {
				fd.append('Certificate', null);
				this.EducationEntity.Certificate = null;

				this.EducationEntity.UserId = this.globals.authData.UserId;
				this.EditProfileService.updateEducationDetails(this.EducationEntity)
					.then((data) => {
						this.EducationEntity.Skills = this.EducationEntity.Skills.split(',');
						this.globals.isLoading = false;
						this.btn_disable1 = false;
						this.submitted1 = false;
						swal({

							type: 'success',
							title: 'Updated!',
							text: 'Profile has beem updated successfully!',
							showConfirmButton: false,
							timer: 3000
						})

					},
						(error) => {
							this.btn_disable1 = false;
							this.submitted1 = false;
							this.globals.isLoading = false;
						});
			}
		}
	}

	updateCompany(companyForm) {
		debugger
		this.submitted1 = false;
		if (companyForm.valid) {
			this.btn_disable1 = true;
			this.globals.isLoading = true;
			this.CompanyEntity.UpdatedBy = this.globals.authData.UserId;
			this.EditProfileService.updateCompany(this.CompanyEntity)
				.then((data) => {
					if (this.CompanyEntity.cid > 0) {
						this.EditProfileService.getStateList(this.CompanyEntity.cid)
							.then((data) => {
								this.StateList = data;
								this.globals.isLoading = false;
								this.btn_disable1 = false;
								this.submitted1 = false;
							},
								(error) => {
									this.globals.isLoading = false;
									this.btn_disable1 = false;
									this.submitted1 = false;
								});
					}
					this.globals.isLoading = false;
					this.btn_disable1 = false;
					this.submitted1 = false;
					swal({
						type: 'success',
						title: 'Updated!',
						text: 'Company details has been updated successfully!',
						showConfirmButton: false,
						timer: 3000
					})
				},
					(error) => {
						this.btn_disable1 = false;
						this.submitted1 = false;
						this.globals.isLoading = false;
					});
		}
	}

	deleteCertificate(certificate) {
		swal({
			title: 'Delete a cetificate',
			text: "Are you sure you want to delete this cetificate?",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes'
		})
			.then((result) => {
				if (result.value) {
					var del = { 'Userid': this.globals.authData.UserId, 'id': certificate.CertificateId, 'Name': certificate.Certificate };
					this.EditProfileService.deleteCertificate(del)
						.then((data) => {
							let index = this.CertificateEntity.indexOf(certificate);
							if (index != -1) {
								this.CertificateEntity.splice(index, 1);
							}
							swal({
								type: 'success',
								title: 'Deleted!',
								text: 'Certificate has been deleted successfully',
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

	logout() {
		this.globals.authData = '';
		localStorage.removeItem('token');
		window.location.href = '/login';
	}

	ChangePassword(newpassForm) {
		this.submitted2 = true;
		if (newpassForm.valid && !this.same && !this.oldnewsame) {
			this.newpassEntity.UserId = this.globals.authData.UserId;
			this.btn_disable2 = true;
			this.globals.isLoading = true;
			this.EditProfileService.changepassword(this.newpassEntity)
				.then((data) => {
					if (data == 'wrong current password') {
						swal({
							type: 'warning',
							title: 'Oops...',
							text: 'You entered wrong current password!',
						})
						this.globals.isLoading = false;
						this.btn_disable2 = false;
						this.submitted2 = false;
					}
					else {
						this.btn_disable2 = false;
						this.submitted2 = false;
						this.newpassEntity = {};
						newpassForm.form.markAsPristine();
						this.globals.isLoading = false;
						swal({

							type: 'success',
							title: 'Password changed!',
							text: 'Your password has been changed!',
							showConfirmButton: false,
							timer: 3000
						})
					}
				},
					(error) => {
						this.globals.isLoading = false;
						this.router.navigate(['/pagenotfound']);
						this.btn_disable2 = false;
						this.submitted2 = false;
					});

		}
	}

	// User for Company //
	getStateList(companyForm) {
		debugger
		myInput();
		companyForm.form.controls.sid.markAsDirty();
		this.CompanyEntity.sid = '';
		if (this.CompanyEntity.cid > 0) {
			this.EditProfileService.getStateList(this.CompanyEntity.cid)
				.then((data) => {
					this.StateList = data;
				},
					(error) => {
						this.btn_disable = false;
						this.submitted = false;
					});
		} else {
			this.StateList = [];
		}
	}

	// use for user //
	getStateListadd(RegisterForm) {
		debugger
		myInput();
		RegisterForm.form.controls.StateId.markAsDirty();
		this.RegisterEntity.StateId = '';
		if (this.RegisterEntity.CountryId > 0) {
			this.EditProfileService.getStateListadd(this.RegisterEntity.CountryId)
				.then((data) => {
					this.StateList = data;
				},
					(error) => {
						this.btn_disable = false;
						this.submitted = false;
					});
		} else {
			this.StateList = [];
		}
	}

	checkpassword() {
		if (this.newpassEntity.cPassword != this.newpassEntity.nPassword) {
			this.same = true;
			this.oldnewsame = false;
		} else {
			this.same = false;
			if (this.newpassEntity.Password == this.newpassEntity.nPassword) {
				this.oldnewsame = true;
			}
			else {

				this.oldnewsame = false;
			}
		}
	}

	clearChangePassword(newpassForm) {
		this.btn_disable2 = false;
		this.submitted2 = false;
		this.same = false;
		this.newpassEntity = {};
		newpassForm.form.markAsPristine();
	}




}
