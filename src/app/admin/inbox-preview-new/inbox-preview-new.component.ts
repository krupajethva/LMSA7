import { Component, OnInit } from '@angular/core';
declare var $: any;

@Component({
  selector: 'app-inbox-preview-new',
  templateUrl: './inbox-preview-new.component.html',
  styleUrls: ['./inbox-preview-new.component.css']
})
export class InboxPreviewNewComponent implements OnInit {

  constructor() { }

  ngOnInit() {

    $('.modal').on('shown.bs.modal', function () {
      $('.right_content_block').addClass('style_position');
    })
    $('.modal').on('hidden.bs.modal', function () {
      $('.right_content_block').removeClass('style_position');
    });

  }

}
