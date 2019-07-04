import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CoursebeforereminderlistComponent } from './coursebeforereminderlist.component';

describe('CoursebeforereminderlistComponent', () => {
  let component: CoursebeforereminderlistComponent;
  let fixture: ComponentFixture<CoursebeforereminderlistComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CoursebeforereminderlistComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CoursebeforereminderlistComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
