import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CourseQuestionComponent } from './course-question.component';

describe('CourseQuestionComponent', () => {
  let component: CourseQuestionComponent;
  let fixture: ComponentFixture<CourseQuestionComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CourseQuestionComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CourseQuestionComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
