import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CourseDiscussionComponent } from './course-discussion.component';

describe('CourseDiscussionComponent', () => {
  let component: CourseDiscussionComponent;
  let fixture: ComponentFixture<CourseDiscussionComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CourseDiscussionComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CourseDiscussionComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
