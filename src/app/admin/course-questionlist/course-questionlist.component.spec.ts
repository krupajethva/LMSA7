import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CourseQuestionlistComponent } from './course-questionlist.component';

describe('CourseQuestionlistComponent', () => {
  let component: CourseQuestionlistComponent;
  let fixture: ComponentFixture<CourseQuestionlistComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CourseQuestionlistComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CourseQuestionlistComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
