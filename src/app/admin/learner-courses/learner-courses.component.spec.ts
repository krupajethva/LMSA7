import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { LearnerCoursesComponent } from './learner-courses.component';

describe('LearnerCoursesComponent', () => {
  let component: LearnerCoursesComponent;
  let fixture: ComponentFixture<LearnerCoursesComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ LearnerCoursesComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(LearnerCoursesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
