import { Component, OnInit } from '@angular/core';
declare var CKEDITOR: any;
declare var $: any;

@Component({
  selector: 'app-compose',
  templateUrl: './compose.component.html',
  styleUrls: ['./compose.component.css']
})
export class ComposeComponent implements OnInit {

  constructor() { }

  ngOnInit() {

    $('#multiupload').imageuploadify();

    CKEDITOR.replace('DescriptionF', {
      height: '100',
      resize_enabled: 'false',
      resize_maxHeight: '100',
      resize_maxWidth: '948',
      resize_minHeight: '100',
      resize_minWidth: '948',
      extraAllowedContent: 'span;ul;li;table;td;style;*[id];*(*);*{*}',
      enterMode: Number(2),
      //extraAllowedContent: 'style;*[id,rel](*){*}
      //removePlugins : 'elementspath,save,image,flash,iframe,link,smiley,tabletools,find,pagebreak,templates,about,maximize,showblocks,newpage,language',
      //removeButtons : 'Copy,Cut,Paste,Undo,Redo,Print,Form,TextField,Textarea,Button,SelectAll,NumberedList,BulletedList,CreateDiv,Table,PasteText,PasteFromWord,Select,HiddenField'
    });

  }

  show(toBlock) {
    this.setDisplay(toBlock, 'block');
  }
  hide(toNone) {
    this.setDisplay(toNone, 'none');
  }
  setDisplay(target, str) {
    document.getElementById(target).style.display = str;
  }

}
