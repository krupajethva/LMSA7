import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CoursebeforereminderComponent } from './coursebeforereminder.component';

describe('CoursebeforereminderComponent', () => {
  let component: CoursebeforereminderComponent;
  let fixture: ComponentFixture<CoursebeforereminderComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CoursebeforereminderComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CoursebeforereminderComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
