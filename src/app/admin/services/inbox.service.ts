import { Injectable } from '@angular/core';
import { Globals } from '.././globals';
import { HttpClient } from "@angular/common/http";
import { Router } from '@angular/router';


@Injectable()
export class InboxService {

  constructor(private http: HttpClient, private globals: Globals, private router: Router) { }

  // get id wise Data //
  getById(EmailLogId)
  {
    debugger
	let promise = new Promise((resolve, reject) => {
    this.http.get(this.globals.baseAPIUrl + 'Inbox/getById/' + EmailLogId)
      .toPromise()
      .then(
        res => { // Success
          resolve(res);
        },
        msg => { // Error
      reject(msg);
      this.globals.isLoading = false;
        }
      );
	});		
	return promise;
  }  

  // ** upload images multie //
  uploadFileMulti(file, iCount) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Inbox/uploadFileMulti/' + iCount, file)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            this.globals.isLoading = false;
           
          }
        );
    });
    return promise;
  }

  listUser() {
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'Inbox/listUser')
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            this.globals.isLoading = false;
            
          }
        );
    });
    return promise;
  }

  getAllData(userId) {
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'Inbox/getAllData/' + userId)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            this.globals.isLoading = false;
            
          }
        );
    });
    return promise;
  }



//  get all spam data
  getAllSpam(userId) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'Inbox/getAllSpam/' + userId)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
             this.globals.isLoading = false;
           
          }
        );
    });
    return promise;
  }
  
  getAllDraft(userId) {debugger
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'Inbox/getAllDraft/' + userId)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            this.globals.isLoading = false;
           
          }
        );
    });
    return promise;
  }

  getAllStarred(userId) {
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'Inbox/getAllStarred/' + userId)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            this.globals.isLoading = false;
          
          }
        );
    });
    return promise;
  }

  getAllSentbox(userId) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'Inbox/getAllSentbox/' + userId)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            this.globals.isLoading = false;
          
          }
        );
    });
    return promise;
  }

  //  get list Inbox data //
  getAllInbox(userId) {
    let promise = new Promise((resolve, reject) => {
      this.http.get(this.globals.baseAPIUrl + 'Inbox/getAllInbox/' + userId)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            this.globals.isLoading = false;
           
          }
        );
    });
    return promise;
  }
  

  // ** Unread to Read Multi Emails
  unreadMultieEmails(upreadmultie) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Inbox/updateUnReadMultiEmails', upreadmultie)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            this.globals.isLoading = false;
            
          }
        );
    });
    return promise;
  }


  // ** Unread send to Read Multi Emails
  unreadSendMultieEmails(upreadmultie) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Inbox/updateSendUnReadMultiEmails', upreadmultie)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            this.globals.isLoading = false;
          
          }
        );
    });
    return promise;
  }




  // ** Unread to Read Multi Emails
  readMultieEmails(upreadmultie) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Inbox/updateReadMultiEmails', upreadmultie)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            this.globals.isLoading = false;
           
          }
        );
    });
    return promise;
  }

  // **  To Add Starred Multi EmailsdeleteAllPermInbox
  starredMultieEmails(upstarredmultie) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Inbox/updateStarredMultiEmails', upstarredmultie)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            this.globals.isLoading = false;
           
          }
        );
    });
    return promise;
  }


  // ** add sendbox to mark as multie sttared
  sendstarredMultieEmails(upstarredmultie) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Inbox/sendupdateStarredMultiEmails', upstarredmultie)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            this.globals.isLoading = false;
           
          }
        );
    });
    return promise;
  }



  // **  To Add Starred Multi Emails
  deleteAllPermInbox(upstarredmultie) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Inbox/deleteAllPermInbox', upstarredmultie)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            this.globals.isLoading = false;
           
          }
        );
    });
    return promise;
  }



   // **  To delete Multi Emails
   deleteMultieEmails(updeletemultie) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Inbox/deleteMultiEmails', updeletemultie)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            this.globals.isLoading = false;
           
          }
        );
    });
    return promise;
  }


   // **  To delete Multi Emails
   delete(del) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Inbox/delete', del)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            this.globals.isLoading = false;
           
          }
        );
    });
    return promise;
  }

  // ** unread to Read Emails
  readEmails(upread) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Inbox/updateReadEmails', upread)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            this.globals.isLoading = false;
           
          }
        );
    });
    return promise;
  }


   // ** unread to Read Emails only
   readOnlyEmails(upread) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Inbox/onlyReadEmails', upread)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            this.globals.isLoading = false;
           
          }
        );
    });
    return promise;
  }

  // ** add to Stars Emails
  addstarInbox(upstar) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Inbox/updateAddStarEmails', upstar)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            this.globals.isLoading = false;
           
          }
        );
    });
    return promise;
  }

  // ** add to Stars Emails
  addImportantInbox(upimpo) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Inbox/updateImportantEmails', upimpo)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            this.globals.isLoading = false;
           
          }
        );
    });
    return promise;
  }

  // delete emails
  deleteInbox(upimpo) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Inbox/deleteEmails', upimpo)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            this.globals.isLoading = false;
           
          }
        );
    });
    return promise;
  }

  recoverMail(upimpo) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Inbox/recoverMail', upimpo)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            this.globals.isLoading = false;
           
          }
        );
    });
    return promise;
  }
  // ** new email add // 
  add(emailEntity) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Inbox/add', emailEntity)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            this.globals.isLoading = false;
            
          }
        );
    });
    return promise;
  }


   // ** Email add as draft //
   addDraft(emailEntity) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Inbox/addDraft', emailEntity)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            this.globals.isLoading = false;
          }
        );
    });
    return promise;
  }

  // ** add to Emails as draft from inbox preview
  addDrafts(emailPreviewEntity) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Inbox/addDraft', emailPreviewEntity)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            this.globals.isLoading = false;
          }
        );
    });
    return promise;
  }


  // ** add to Emails from Preview
  addPreview(emailPreviewEntity) {
    debugger
    let promise = new Promise((resolve, reject) => {
      this.http.post(this.globals.baseAPIUrl + 'Inbox/addPreview', emailPreviewEntity)
        .toPromise()
        .then(
          res => { // Success
            resolve(res);
          },
          msg => { // Error
            reject(msg);
            this.globals.isLoading = false;
            
          }
        );
    });
    return promise;
  }


}
