import { Component, OnInit, ElementRef } from '@angular/core';
import { Globals } from '.././globals';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { AnnouncementService } from '../services/announcement.service';
import { CalendarService } from '../services/calendar.service';
declare var $ : any;

@Component({
  selector: 'app-calendar',
  templateUrl: './calendar.component.html',
  styleUrls: ['./calendar.component.css']
})
export class CalendarComponent implements OnInit {
	AnnouncementTypeList;
	constructor( public globals: Globals, private router: Router,private elem: ElementRef, private route: ActivatedRoute,
		private AnnouncementService: AnnouncementService,private CalendarService: CalendarService) { }
  ngOnInit() {

 setTimeout(function(){
			if( $(".bg_white_block").hasClass( "ps--active-y" )){  
				$('footer').removeClass('footer_fixed');     
			}      
			else{  
				$('footer').addClass('footer_fixed');    
			}
		},1000);
		this.default();
		this.CalendarService.getCalendarDetails(this.globals.authData.UserId)
    .then((data) => 
    { 
	$('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'year,month,basicWeek,basicDay'
      },
	 eventRender: function(eventObj, $el) {
      $el.popover({
        title: eventObj.title,
        content: eventObj.description + '<br><b>Start:</b> ' + eventObj.start.format('D-MMM-YY h:mm a') + '<br><b>End:</b> ' + eventObj.end.format('D-MMM-YY h:mm a') + '<br><b>Location:</b> ' + eventObj.location + '<br><b>Organizer:</b> ' + eventObj.organizer,
		//content: '<p>' + eventObj.description + '<br>Start: ' + eventObj.start.format('h:mm a') + '</p><p>' + 'End: ' + eventObj.end.format('h:mm a') + '</p>',
        trigger: 'hover',
        placement: 'bottom',
        container: 'body',
		html : true 
      });
    },
      defaultDate: new Date(),
	  defaultView: 'month',
      yearColumns: 2,
	  bootstrap: true,
      navLinks: true,
      editable: false,
	  dragable: false,
      eventLimit: true,
      events: data
		});
	},
	(error) => 
  {
    this.globals.isLoading = false;
    this.router.navigate(['/pagenotfound']);
  });
	}
	default(){
    this.AnnouncementService.getAnnouncementTypes()
			.then((data) => {
				this.AnnouncementTypeList = data;
			//	this.globals.isLoading = false;
			},
			(error) => {
       // this.globals.isLoading = false;	
        this.router.navigate(['/pagenotfound']);
      });
	}
}