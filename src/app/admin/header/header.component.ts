import { Component, OnInit } from '@angular/core';
import { AuthService } from '../services/auth.service';
import { EditProfileService } from '../services/edit-profile.service';
import { Router } from '@angular/router';
import { Globals } from '../globals';
declare var $, PerfectScrollbar: any;
declare var $, swal: any;
declare function myInput(): any;
@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css']
})
export class HeaderComponent implements OnInit {
  newpassEntity;
  CompanyEntity;
  CountryList;
  stateList;
  EducationLeveList;
  RegisterEntity;
  constructor(private authService: AuthService, private router: Router, public globals: Globals, private EditProfileService: EditProfileService) { }

  ngOnInit() {

    this.newpassEntity = {};
    this.RegisterEntity = {};
    this.RegisterEntity.CountryId = '';
    this.RegisterEntity.StateId = '';
    this.newpassEntity = {};
    this.CompanyEntity = {};

    this.EditProfileService.getProfileById(this.globals.authData.UserId)
      .then((data) => {


        this.RegisterEntity = data['user'];
        this.globals.isLoading = false;
        setTimeout(function () {
          myInput();

          $('.modal').on('shown.bs.modal', function (e) {
            $(".modal-backdrop.fade.show").addClass("in");
            $(".modal.fade.show").addClass("in");
          });

          $('.modal').on('hidden.bs.modal', function () {
            $(".modal.fade.show").removeClass("in");
            $(".modal-backdrop.fade.show").removeClass("in");
          })
        }, 100);

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
        $("#dynamic2")
          .css("width", current_progress + "%")
          .attr("aria-valuenow", current_progress)
          .text(current_progress + "% Complete");



        // var current_progress = 0;
        // var counter = setInterval(function() {
        // 	//current_progress += 10;

        // 	$("#dynamic2")
        // 	.css("width", current_progress + "%")
        // 	.attr("aria-valuenow", current_progress)
        // 	.text(current_progress + "% Complete");
        // 	if (current_progress >= 100)
        // 		clearInterval(counter);

        // }, 1000);


      },
        (error) => {
          this.globals.isLoading = false;
          this.router.navigate(['/']);
        });


    new PerfectScrollbar('.bg_white_block');
    $('body').tooltip({
      selector: '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])',
      trigger: 'hover',
      container: 'body'
    }).on('click mousedown mouseup', '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])', function () {
      $('[data-toggle="tooltip"], [title]:not([data-toggle="popover"])').tooltip('destroy');
    });



    $(".alert-close").click(function () {
      $(".footer_fixed_wrapper").removeClass("active_up");
      $(".footer_bottom span").removeClass("active_i");
    });

    $(".footer_bottom span").click(function () {
      $(".footer_fixed_wrapper").toggleClass("active_up");
      $(".footer_bottom span").toggleClass("active_i");
    });









  }






  logout() {
    this.globals.isLoading = true;
    this.authService.logout(this.globals.authData.UserId)
      .then((data) => {
        window.location.href = '/login';
        this.globals.isLoading = false;
      },
        (error) => {
          this.globals.isLoading = false;
          this.router.navigate(['/pagenotfound']);
        });

  }

}
